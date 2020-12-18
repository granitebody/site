<?php
/*
Plugin Name: Easy Digital Downloads - MailChimp
Plugin URL: https://easydigitaldownloads.com/downloads/mail-chimp/
Description: Subscribe customers to MailChimp lists when purchasing products through Easy Digital Downloads
Version: 3.0.11
Author: Easy Digital Downloads
Author URI: https://easydigitaldownloads.com
*/

if ( version_compare( PHP_VERSION, '5.3.3', '<' ) ) {
	add_action( 'admin_notices', 'eddmc_below_php_version_notice' );

	function eddmc_below_php_version_notice() {
		echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by Easy Digital Downloads - MailChimp. Please contact your host and request that your version be upgraded to 5.3.3 or later.', 'eddmc' ) . '</p></div>';
	}

	return;
}

class EDD_MailChimp {

	private static $instance;

	public static $database;
	public static $actions;
	public static $checkout;
	public static $ecommerce;
	public static $metabox;
	public static $settings;
	public static $sync;

	/**
	 * Setup the instance using the correct class
	 *
	 * @return instanceof EDD_MailChimp_Extension
	 */
	public static function instance() {

		// Return early if Easy Digital Downloads core is not detected
		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			return;
		}

		if ( ! isset( self::$instance ) AND ! ( self::$instance instanceof EDD_MailChimp_Extension ) ) {
			self::$instance = new self;
			self::$instance->_define_constants();
			self::$instance->_include_files();

			self::$database  = new EDD_MailChimp_Database;
			self::$actions   = new EDD_MailChimp_Actions;
			self::$checkout  = new EDD_MailChimp_Checkout;
			self::$ecommerce = new EDD_MailChimp_Ecommerce;
			self::$metabox   = new EDD_MailChimp_Metabox;
			self::$settings  = new EDD_MailChimp_Settings;
			self::$sync      = new EDD_MailChimp_Sync;

			if ( class_exists( 'EDD_License' ) && is_admin() ) {
				$eddmc_license = new EDD_License( __FILE__, EDD_MAILCHIMP_PRODUCT_NAME, EDD_MAILCHIMP_VERSION, 'Easy Digital Downloads, LLC', null, null, EDD_MAILCHIMP_PRODUCT_ID );
			}
		}

		return self::$instance;

	}

	public function __construct() {
		add_action( 'admin_init', array( $this, 'load_upgrade_routine' ) );
		add_action( 'edd_dismiss_mc_interest_notice', array( $this, 'dismiss_interest_fix_notice' ) );
		add_action( 'init', array( $this, 'textdomain' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load the plugin's textdomain
	 */
	public function textdomain() {
		load_plugin_textdomain( 'eddmc', false, EDD_MAILCHIMP_PATH . '/languages/' );
	}

	/**
	 * Catch the dismissal of the interest group reconfiguration notice.
	 */
	public function dismiss_interest_fix_notice() {
		delete_option( 'edd_mc_reconfigure_download_interests' );
	}

	/**
	 * Display any necessary admin notices
	 *
	 * @since 3.0.5
	 * @return void
	 */
	public function admin_notices() {

		$show_data_fix_notice = get_option( 'edd_mc_reconfigure_download_interests' );
		if ( current_user_can( 'manage_options' ) && ! empty( $show_data_fix_notice ) ) {
			echo '<div class="notice notice-error">';
				echo '<p>';
					_e( 'Easy Digital Downloads - MailChimp detected an error in your synced MailChimp Interest Groups caused by a recent update. While we\'ve already re-synced your interest groups, please visit your individual products to ensure the correct groups are selected.', 'eddmc' );
				echo '</p>';
				echo '<p>';
					printf(
						__( 'Once you have updated the products that are configured with specific MailChimp interest groups, you can safely <a href="%s"> hide this notice</a>.', 'eddmc' ),
						add_query_arg( array( 'edd_action' => 'dismiss_mc_interest_notice' ) )
					);
				echo '</p>';
				echo '<p>';
					_e( 'We apologize for the inconvenience. - The EDD Team', 'eddmc' );
				echo '</p>';
			echo '</div>';
		}

	}

	/**
	 * Load upgrade routine if required
	 *
	 * @return void
	 */
	public function load_upgrade_routine() {

		if ( class_exists('Easy_Digital_Downloads') && function_exists('edd_has_upgrade_completed') ) {

			// DEV ONLY
			// $completed_upgrades = get_option( 'edd_completed_upgrades' );

			// foreach ($completed_upgrades as $i => $value) {
			//   if ($value == 'upgrade_mailchimp_api3_default_list') {
			//     unset($completed_upgrades[$i]);
			//   }
			// }

			// update_option( 'edd_completed_upgrades', $completed_upgrades );
			// DEV ONLY

			$api3_default_list = edd_has_upgrade_completed( 'upgrade_mailchimp_api3_default_list' );
			$list = get_option( 'eddmc_list' );

			if ( ! $api3_default_list  && ! empty( $list ) ) {

				// Require upgrade routine
				if ( ! class_exists( 'EDD_MailChimp_V3_Upgrade' ) ) {
					include( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-v3-upgrade.php' );
					new EDD_MailChimp_V3_Upgrade;
				}
			} else {
				edd_set_upgrade_complete( 'upgrade_mailchimp_api3' );
				edd_set_upgrade_complete( 'upgrade_mailchimp_api3_default_list' );
				edd_set_upgrade_complete( 'upgrade_mailchimp_api3_default_list' );
			}

			// Fix an issue in Version 3.0.4 that caused interest group data to get corrupted.
			// See: https://github.com/easydigitaldownloads/edd-mail-chimp/issues/63
				$fix_304_intereests = edd_has_upgrade_completed( 'eddmc_304_interests_fix' );
			if ( ! $fix_304_intereests ) {

				// Get the current set of interests lists.
				global $wpdb;
				$interests = $wpdb->get_results( "SELECT * FROM $wpdb->edd_mailchimp_interests" );

				$has_invalid_remote_interest_ids = array();
				if ( is_array( $interests ) ) {

					/**
					 * Loop through each interest to see if the remote interest id value is _only_ numeric.
					 *
					 * Valid remote interest id's are alphanumeric and always contain letters and numbers. If the value
					 * we find is only numeric, then it is one that was corrupted by the %d data format.
					 */
					foreach ( $interests as $interest ) {
						if ( is_numeric( $interest->interest_remote_id ) ) {
							$has_invalid_remote_interest_ids[] = $interest->id;
						}
					}
				}

				// If we didn't have any interests, or any interests with invalid remote IDs
				if ( ! empty( $has_invalid_remote_interest_ids ) ) {

					// If $has_invalid_remote_interest_ids is not empty, we need to remove the invalid interests as well
					// as any connections to downloads.
					foreach ( $has_invalid_remote_interest_ids as $invalid_id ) {
						$wpdb->delete( $wpdb->edd_mailchimp_interests, array( 'id' => $invalid_id ), array( '%d' ) );
						$wpdb->delete( $wpdb->edd_mailchimp_downloads_interests, array( 'interest_id' => $invalid_id ), array( '%d' ) );
					}

					update_option( 'edd_mc_reconfigure_download_interests', '1' );

				}

				$list_ids = $wpdb->get_col( "SELECT remote_id FROM $wpdb->edd_mailchimp_lists", 0 );
				if ( ! empty( $list_ids ) ) {
					foreach ( $list_ids as $list_id ) {
						$mc_lists = new EDD_MailChimp_List( $list_id );
						$mc_lists->sync_interests();
					}
				}

				edd_set_upgrade_complete( 'eddmc_304_interests_fix' );

			}
		}
	}

	/**
	 * Define any constants used throughout the plugin
	 *
	 * @return [type] [description]
	 */
	private function _define_constants() {
		global $wpdb;

		if ( ! isset( $wpdb->edd_mailchimp_lists ) ) {
		  $wpdb->edd_mailchimp_lists = $wpdb->prefix . 'edd_mailchimp_lists';
		}

		if ( ! isset( $wpdb->edd_mailchimp_downloads_lists ) ) {
		  $wpdb->edd_mailchimp_downloads_lists = $wpdb->prefix . 'edd_mailchimp_downloads_lists';
		}

		if ( ! isset( $wpdb->edd_mailchimp_interests ) ) {
		  $wpdb->edd_mailchimp_interests = $wpdb->prefix . 'edd_mailchimp_interests';
		}

		if ( ! isset( $wpdb->edd_mailchimp_downloads_interests ) ) {
		  $wpdb->edd_mailchimp_downloads_interests = $wpdb->prefix . 'edd_mailchimp_downloads_interests';
		}

		define( 'EDD_MAILCHIMP_PRODUCT_NAME', 'Mail Chimp' );
		define( 'EDD_MAILCHIMP_PRODUCT_ID', 746 );
		define( 'EDD_MAILCHIMP_VERSION', '3.0.11' );
		define( 'EDD_MAILCHIMP_URL',  plugin_dir_url(__FILE__) );
		define( 'EDD_MAILCHIMP_PATH', plugin_dir_path(__FILE__) );
		define( 'EDD_MAILCHIMP_BASENAME', plugin_basename( __FILE__ ) );
	}


	/**
	 * Include files required by the MailChimp extension.
	 *
	 * @return void
	 */
	private function _include_files() {

		require( EDD_MAILCHIMP_PATH . '/vendor/autoload.php' );

		// Models
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-api.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-collection.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-model.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-cart.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-customer.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-list.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-order.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-product.php' );
		require_once( EDD_MAILCHIMP_PATH . '/models/class-edd-mailchimp-store.php' );

		// Includes
		require_once( EDD_MAILCHIMP_PATH . '/includes/functions.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-database.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-download.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-actions.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-checkout.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-ecommerce.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-metabox.php' );
		require_once( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-settings.php' );

		// Jobs
		require_once( EDD_MAILCHIMP_PATH . '/jobs/class-edd-mailchimp-sync.php' );
	}


	/**
	 * Provides a backwards-compatible method to subscribe users to a MailChimp list.
	 *
	 * @deprecated 3.0 Use EDD_MailChimp_List subscribe method
	 * @return boolean true if the user was successfully subscribed, false otherwise.
	 */
	public function subscribe_email( $user_info = array(), $list_id = false, $prevent_opt_in = false ) {

		_deprecated_function( __FUNCTION__, '3.0', 'EDD_MailChimp_List' );

		$list = $list_id !== false ? new EDD_MailChimp_List( $list_id ) : EDD_MailChimp_List::get_default();

		// Maintains the same behavior as the previously-named $opt_in_overrid(d)e
		// If the user has enabled opt-in in settings, but passed `true` as the $prevent_opt_in value,
		// override the preference stored in the user settings.
		if ( $prevent_opt_in ) {
			$options['double_opt_in'] = false;
		}

		$result = $list->subscribe( $user_info, $options );
		return $result;
	}
}

function edd_mc_load() {
	$GLOBALS['eddmc'] = EDD_MailChimp::instance();
}
add_action( 'plugins_loaded', 'edd_mc_load' );
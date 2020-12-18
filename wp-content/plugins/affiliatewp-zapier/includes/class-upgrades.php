<?php
/**
 * AffiliateWP Zapier Upgrades Class
 *
 * @package     AffiliateWP Zapier
 * @copyright   Copyright (c) 2020, Sandhills Development, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.2
 */

/**
 * The Affiliate_WP_Zapier_Upgrades class.
 *
 * Handles database upgrade for the AffiliateWP Zapier add-on.
 */
class Affiliate_WP_Zapier_Upgrades {

	/**
	 * Signals whether the upgrade was successful.
	 *
	 * @since  1.2
	 * @access private
	 * @var    bool
	 */
	private $upgraded = false;

	/**
	 * AffiliateWP - Zapier version.
	 *
	 * @since  1.2
	 * @access private
	 * @var    string
	 */
	private $version;

	/**
	 * Sets up the Upgrades class instance.
	 *
	 * @since  1.2
	 * @access public
	 */
	public function __construct() {

		$this->version = get_option( 'affwp_zapier_version' );

		add_action( 'admin_init', array( $this, 'init' ), -9999 );

	}

	/**
	 * Initializes upgrade routines for the current version of Affiliate Zapier.
	 *
	 * @since  1.2
	 * @access public
	 */
	public function init() {

		if ( empty( $this->version ) ) {
			$this->version = '1.1.2'; // last version that didn't have the version option set
		}

		if ( version_compare( $this->version, '1.2', '<' ) ) {
			$this->v12_upgrade();
		}

		// If upgrades have occurred
		if ( $this->upgraded ) {
			update_option( 'affwp_zapier_version_upgraded_from', $this->version );
			update_option( 'affwp_zapier_version', AFFWP_ZAPIER_VERSION );
		}

	}

	/**
	 * Performs database upgrades for version 1.2.
	 *
	 * @since 1.2
	 */
	private function v12_upgrade() {

		global $wpdb;

		$table_name = affiliatewp_zapier()->logs->table_name;

		$wpdb->query( "TRUNCATE TABLE $table_name" );

		@affiliate_wp()->utils->log( 'Zapier Upgrade: The logs table was refreshed during the upgrade to 1.2.' );
		// Upgraded!
		$this->upgraded = true;
	}

}
new Affiliate_WP_Zapier_Upgrades;
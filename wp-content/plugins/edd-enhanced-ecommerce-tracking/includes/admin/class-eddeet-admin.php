<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class EDDEET_Admin.
 *
 * EDD Enhanced eCommerce Tracking admin class manages settings and other admin stuff..
 *
 * @class		EDDEET_Admin
 * @version		1.0.0
 * @package		EDD Enhanced eCommerce Tracking
 * @author		Jeroen Sormani
 */
class EDDEET_Admin {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Register 'eCommerce Tracking' tab
		add_filter( 'edd_settings_sections_extensions', array( $this, 'register_section' ) );

		// Add settings to 'Extensions' tab
		add_filter( 'edd_settings_extensions', array( $this, 'register_settings' ) );

		// Add license field
		add_action( 'admin_init', array( $this, 'updater' ), 5 );

		// Add the plugin page Settings and Docs links
		add_filter( 'plugin_action_links_' . plugin_basename( EDD_Enhanced_Ecommerce_Tracking()->file ), array( $this, 'plugins_page_link' ) );

	}


	/**
	 * Register settings section.
	 *
	 * @since 1.0.9
	 *
	 * @param array $sections List of existing sections.
	 * @return mixed List of modified sections.
	 */
	public function register_section( $sections ) {
		$sections['edd-enhanced-ecommerce-tracking'] = __( 'eCommerce Tracking', 'edd-ehanced-ecommerce-tracking' );

		return $sections;
	}


	/**
	 * Register settings.
	 *
	 * Add settings to the existing extension settings.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $existing_settings List of existing settings.
	 * @return array                    List of modified settings.
	 */
	public function register_settings( $existing_settings ) {

		$settings = apply_filters( 'eddeet_settings', array(
			array(
				'id'   => 'eddeet_header',
				'name' => '<span id="eddeet">' . __( 'EDD Enhanced eCommerce Tracking', 'edd-enhanced-ecommerce-tracking' ) . '</span>',
				'desc' => __( '', 'edd-enhanced-ecommerce-tracking' ),
				'type' => 'header',
			),
			array(
				'id'   => 'eddeet_ua',
				'name' => __( 'UA Code', 'edd-enhanced-ecommerce-tracking' ),
				'desc' => __( 'Add the UA code copied from your Google Analytics account', 'edd-enhanced-ecommerce-tracking' ),
				'type' => 'text',
			),
			array(
				'id'   => 'eddeet_implementation_method',
				'name' => __( 'Tracking method', 'edd-enhanced-ecommerce-tracking' ),
				'desc' => __( 'Google Analytics provides different methods of tracking data.', 'edd-enhanced-ecommerce-tracking' ) . ' ' . '<a href="https://aceplugins.com/?p=63#tracking-method" target="_blank" rel="noopener noreferrer">' . __( 'Learn more', 'edd-enhanced-ecommerce-tracking' ) . '</a>',
				'type' => 'select',
				'options' => array(
					'gtagjs'               => __( 'gtag.js', 'edd-enhanced-ecommerce-tracking' ),
					'analyticsjs'          => __( 'analytics.js', 'edd-enhanced-ecommerce-tracking' ),
					'measurement-protocol' => __( 'Measurement Protocol', 'edd-enhanced-ecommerce-tracking' ),
				),
			),
			array(
				'id'   => 'eddeet_using_cart',
				'name' => __( 'Using cart', 'edd-enhanced-ecommerce-tracking' ),
				'desc' => __( 'Check if using a separate cart page (<code>[download_cart]</code>)', 'edd-enhanced-ecommerce-tracking' ),
				'type' => 'checkbox',
			),
			array(
				'id'   => 'eddeet_anonymize_ip',
				'name' => __( 'Anonymize IP addresses', 'edd-enhanced-ecommerce-tracking' ),
				'desc' => __( 'Anonymize the IP addresses from data tracked by GA.', 'edd-enhanced-ecommerce-tracking' ),
				'type' => 'checkbox',
			),
			array(
				'id'   => 'eddeet_debug_mode',
				'name' => __( 'Debug mode', 'edd-enhanced-ecommerce-tracking' ),
				'desc' => __( 'Add logging for all API calls to Google Analytics. EDD based logs can be found in the uploads folder.', 'edd-enhanced-ecommerce-tracking' ),
				'type' => 'checkbox',
			),
		) );

		// Merge with existing plugin settings
		return array_merge( $existing_settings, array( 'edd-enhanced-ecommerce-tracking' => $settings ) );

	}


	/**
	 * Init plugin updater.
	 *
	 * Initialise the plugin updater class.
	 *
	 * @since 1.0.0
	 */
	function updater() {

		if ( ! get_option( 'edd_enhanced_ecommerce_tracking_license_key', null ) && $edd_lk = edd_get_option( 'edd_edd_enhanced_ecommerce_tracking_license_key' ) ) {
			update_option( 'edd_enhanced_ecommerce_tracking_license_key', $edd_lk );
		}

		// Updater
		if ( ! class_exists( '\JeroenSormani\WP_Updater\WPUpdater' ) ) {
			require plugin_dir_path( EDD_Enhanced_Ecommerce_Tracking()->file ) . '/libraries/wp-updater/wp-updater.php';
		}
		new \JeroenSormani\WP_Updater\WPUpdater( array(
			'file'    => EDD_Enhanced_Ecommerce_Tracking()->file,
			'name'    => 'EDD Enhanced eCommerce Tracking',
			'version' => EDD_Enhanced_Ecommerce_Tracking()->version,
			'api_url' => 'https://aceplugins.com/',
			'license_option_name' => 'edd_enhanced_ecommerce_tracking_license_key',
		) );

	}


	/**
	 * Plugins page link.
	 *
	 * Add a 'settings' link to the plugin on the plugins page.
	 *
	 * @since 1.0.2
	 *
	 * @param  array $links List of existing plugin links.
	 * @return array        List of modified plugin links.
	 */
	public function plugins_page_link( $links ) {
		$url = '<a href="' . admin_url( 'edit.php?post_type=download&page=edd-settings&tab=extensions#eddeet' ) . '">' . __( 'Settings', 'edd-enhanced-ecommerce-tracking' ) . '</a>';
		array_unshift( $links, $url );

		return $links;
	}


}

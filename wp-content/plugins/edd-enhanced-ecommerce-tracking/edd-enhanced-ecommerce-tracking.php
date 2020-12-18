<?php
/**
 * Plugin Name: 	EDD Enhanced eCommerce Tracking
 * Plugin URI:		https://aceplugins.com/plugin/edd-enhanced-ecommerce-tracking/
 * Description:		Use this plugin to track your sales via Google Analytics Enhanced Ecommerce. Using the Google API, tracking will give you <strong>99,9%</strong> accuracy.
 * Version: 		1.2.0.1
 * Author: 			Jeroen Sormani
 * Author URI: 		https://jeroensormani.com/
 * Text Domain: 	edd-enhanced-ecommerce-tracking
 */

use EDD_Enhanced_eCommerce_Tracking\Implementations\analyticsjs;
use EDD_Enhanced_eCommerce_Tracking\Implementations\gtagjs;
use EDD_Enhanced_eCommerce_Tracking\Implementations\Measurement_Protocol;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EDD_Enhanced_Ecommerce_Tracking.
 *
 * Main class initializes the plugin.
 *
 * @class		EDD_Enhanced_Ecommerce_Tracking
 * @version		1.0.0
 * @author		Jeroen Sormani
 */
class EDD_Enhanced_Ecommerce_Tracking {


	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 * @var string $version Plugin version number.
	 */
	public $version = '1.2.0.1';


	/**
	 * Plugin file.
	 *
	 * @since 1.0.0
	 * @var string $file Plugin file path.
	 */
	public $file = __FILE__;


	/**
	 * Instance of EDD_Enhanced_Ecommerce_Tracking.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var EDD_Enhanced_Ecommerce_Tracking $instance Main plugin instance.
	 */
	private static $instance;


	/**
	 * @var EDDEET_Admin $admin Admin class.
	 */
	public $admin;


	/**
	 * @var $track_data EDDEET_Data Data tracking class.
	 */
	public $track_data;


	/**
	 * @var $implementation \EDD_Enhanced_eCommerce_Tracking\Implementations\Analytics_Implementation
	 */
	public $implementation;


	/**
	 * @var $compatibility EDDEET_Compatibility Compatibility class.
	 */
	public $compatibility;


	/**
	 * Construct.
	 *
	 * Initialize the class and plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {}


	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since 1.0.0
	 * @return EDD_Enhanced_Ecommerce_Tracking Instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Check if EDD is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( ! is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) && ! function_exists( 'EDD' ) ) {
			return false;
		}

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-eddeet-data.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/helper-functions.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/Implementations/Implementation.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/Implementations/gtagjs.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/Implementations/measurement-protocol.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/Implementations/analyticsjs.php';

		$this->track_data = new EDDEET_Data();

		$tracking_method = edd_get_option( 'eddeet_implementation_method', 'measurement-protocol' );
		if ( $tracking_method == 'gtagjs' ) {
			$this->implementation = new gtagjs( $this->track_data );
		} elseif ( $tracking_method == 'analyticsjs' ) {
			$this->implementation = new analyticsjs( $this->track_data );
		} elseif ( $tracking_method == 'measurement-protocol' ) {
			$this->implementation = new Measurement_Protocol( $this->track_data );
		}

		if ( is_admin() ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-eddeet-admin.php';
			$this->admin = new EDDEET_Admin();
		}

		// Compatibility class.
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-eddeet-compatibility.php';
		$this->compatibility = new EDDEET_Compatibility();

		// BC for code snippets/customizations for adding notices
		require_once plugin_dir_path( __FILE__ ) . 'includes/deprecated.php';
		$this->front_end = new EDDEET_Front_End();
		$this->triggers = new EDDEET_Triggers();
		$this->measurement_protocol = new EDDEET_Measurement_Protocol();

		// Load textdomain
		$this->load_textdomain();
	}


	/**
	 * Load textdomain.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'edd-enhanced-ecommerce-tracking', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Helper to log messages.
	 *
	 * @since 1.0.9
	 *
	 * @param array|string $message Message to log, can be array.
	 */
	public function log( $message ) {
		if ( edd_get_option( 'eddeet_debug_mode' ) ) {
			$logger = $GLOBALS['edd_logs'];
			$message = ( is_array( $message ) ? print_r( $message, 1 ) : $message ) . PHP_EOL;
			$logger->log_to_file( $message );
		}
	}


}


if ( ! function_exists( 'EDD_Enhanced_Ecommerce_Tracking' ) ) {

	/**
	 * The main function responsible for returning the EDD_Enhanced_Ecommerce_Tracking object.
	 *
	 * Use this function like you would a global variable, except without needing to declare the global.
	 *
	 * Example: <?php EDD_Enhanced_Ecommerce_Tracking()->method_name(); ?>
	 *
	 * @since 1.0.0
	 *
	 * @return EDD_Enhanced_Ecommerce_Tracking Class instance.
	 */
	function EDD_Enhanced_Ecommerce_Tracking() {
		return EDD_Enhanced_Ecommerce_Tracking::instance();
	}
}
EDD_Enhanced_Ecommerce_Tracking()->init();

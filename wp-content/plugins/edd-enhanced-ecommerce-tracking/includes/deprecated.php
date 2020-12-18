<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Deprecated class, file still exists for BC/code snippets that may've called this.
 *
 * @deprecated 1.2.0
 */
class EDDEET_Front_End {

	public function __construct() {
		// Ok.. so the reason for all this is to add a notice for people who are using
		// a customization to (re)move the tracking script. Its a bit odd, but works
		// and is important enough to add.
		if ( is_admin() ) { // Only in admin, doesn't do anything, but meant for the check below.
			add_action( 'wp_footer', array( $this, 'print_js_tracking_code' ) );
		}

		add_action( 'after_setup_theme', function() {
			if ( ! has_action( 'wp_footer', array( $this, 'print_js_tracking_code' ) ) ) {
				add_action( 'admin_notices', array( $this, 'customization_notice' ) );
			}
		} );
	}

	public function print_js_tracking_code() {
		_edd_deprecated_function( 'EDDEET_Front_End::print_js_tracking_code', '1.2.0' );
	}

	/**
	 * Notice to display when someone *WASN'T* using the tracking code.
	 * This was part of a customization that needs updating.
	 *
	 * @since 1.2.0
	 */
	public function customization_notice() {
		?><div class="notice notice-warning is-dismissible">
			<p>
				<strong><?php _e( 'Thank you for updating EDD Enhanced eCommerce Tracking.', 'edd-enhanced-ecommerce-tracking' ); ?></strong><br/>
				<?php _e( 'It appears you might be using a customization with regards to page tracking. With the new update this customization will need to be updated.', 'edd-enhanced-ecommerce-tracking' ); ?>
			</p>
		</div><?php
	}
}

/**
 * Deprecated class, file still exists for BC/code snippets that may've called this.
 *
 * @deprecated 1.2.0
 */
class EDDEET_Triggers {
	public function __call( $name, $args ) {
		_edd_deprecated_function( 'EDDEET_Triggers', '1.2.0', 'EDDEET_Data' );
	}
}

/**
 * Deprecated class, file still exists for BC/code snippets that may've called this.
 *
 * @deprecated 1.2.0
 */
class EDDEET_Measurement_Protocol {

	public function get_ua() {
		_edd_deprecated_function( 'EDDEET_Measurement_Protocol::get_ua', '1.2.0', '\EDD_Enhanced_eCommerce_Tracking\get_ua()' );
		return \EDD_Enhanced_eCommerce_Tracking\get_ua();
	}

	public function api_call( $body = array() ) {
		_edd_deprecated_function( 'EDDEET_Measurement_Protocol::api_call', '1.2.0' );
	}

	public function track_event( $args = array() ) {
		_edd_deprecated_function( 'EDDEET_Measurement_Protocol::track_event', '1.2.0', 'EDDEET_Data::add_track_data()' );
	}

	public function get_cid( $payment_id = '' ) {
		_edd_deprecated_function( 'EDDEET_Measurement_Protocol::get_cid', '1.2.0', '\EDD_Enhanced_eCommerce_Tracking\get_cid()' );
		return \EDD_Enhanced_eCommerce_Tracking\get_cid( $payment_id );
	}

}

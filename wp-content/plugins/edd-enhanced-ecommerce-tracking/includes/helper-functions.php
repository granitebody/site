<?php
namespace EDD_Enhanced_eCommerce_Tracking;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Get UA code.
 *
 * Get the UA code via filter.
 *
 * @since 1.0.3
 *
 * @return string UA code.
 */
function get_ua() {
	return apply_filters( 'eddeet_ua_code', sanitize_text_field( edd_get_option( 'eddeet_ua' ) ) );
}


/**
 * Generate CID if it doesn't exist.
 * @see http://php.net/manual/en/function.uniqid.php#94959
 *
 * @return string
 */
function generate_cid() {
	return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

		// 32 bits for "time_low"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff),

		// 16 bits for "time_mid"
		mt_rand(0, 0xffff),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand(0, 0x0fff) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand(0, 0x3fff) | 0x8000,

		// 48 bits for "node"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	);
}


/**
 * Get CID.
 *
 * Get the CID. Try to get it from a COOKIE, when not available, generate one.
 *
 * @since 1.0.0
 * @param int $payment_id
 * @return mixed|string
 */
function get_cid( $payment_id = 0 ) {

	$saved_cid = get_post_meta( $payment_id, 'eddeet_cid', true );

	if ( ! empty( $_COOKIE['_ga'] ) ) {

		list( $version, $domainDepth, $cid1, $cid2 ) = preg_split( '[\.]', $_COOKIE['_ga'], 4 );
		$contents = array( 'version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1 . '.' . $cid2 );
		$cid      = $contents['cid'];

		return $cid;

	} elseif ( ! empty( $payment_id ) && ! empty( $saved_cid ) ) {

		// Try to return the saved cID.
		return $saved_cid;

	} else {
		return generate_cid();
	}

}


/**
 * Tracking method default selection.
 *
 * With 1.2.0 a new setting was introduced to choose which tracking method is used.
 * Before it was only using Measurement Protocol, now there's also gtag.js/analytics.js.
 * Currently it is more recommended to use one of the JS implementations. This function
 * prevents existing users from unknowingly switching methods by setting non-chosen settings to MP.
 *
 * @since 1.2.0
 *
 * @param $value
 * @param $key
 * @param $default
 * @return string
 */
function eddeet_implementation_method_option_value( $value, $key, $default ) {
	if ( empty( $value ) && ! empty( edd_get_option( 'eddeet_ua' ) ) ) {
		return 'measurement-protocol';
	}

	return $value;
}
add_filter( 'edd_get_option_eddeet_implementation_method', '\EDD_Enhanced_eCommerce_Tracking\eddeet_implementation_method_option_value', 10, 3 );

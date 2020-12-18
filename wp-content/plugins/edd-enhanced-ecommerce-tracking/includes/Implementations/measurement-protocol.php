<?php
namespace EDD_Enhanced_eCommerce_Tracking\Implementations;

use function EDD_Enhanced_eCommerce_Tracking\generate_cid;
use function EDD_Enhanced_eCommerce_Tracking\get_cid;
use function EDD_Enhanced_eCommerce_Tracking\get_ua;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Measurement Protocol implementation of Enhanced eCommerce.
 * Uses server side (PHP) API calls to GA to track visitor events.
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/
 * @package EDD_Enhanced_eCommerce_Tracking\Implementations
 */
class Measurement_Protocol {


	/**
	 * Google Analytics MP url.
	 *
	 * @since 1.0.0
	 * @var $api_url
	 */
	protected $api_url = 'https://ssl.google-analytics.com/collect';


	private $data;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @param \EDDEET_Data $data
	 */
	public function __construct( \EDDEET_Data $data ) {
		$this->hooks();

		$this->data = $data;

		// Output tracking script
		add_action( 'wp_head', array( $this, 'output_script' ) );
	}


	/**
	 * Class hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {

		// Trigger the API call at the end of pageload or AJAX call
		add_action( 'shutdown', array( $this, 'track_data' ) );

		// Remove from cart - Trigger data tracking at this stage
		add_action( 'edd_pre_remove_from_cart', array( $this, 'track_data' ), 100, 1 );

		// Measure checkout process
		add_action( 'edd_complete_purchase', array( $this, 'track_data' ), 100 );

		// Transaction/Refund - Trigger data tracking at this stage
		add_action( 'edd_update_payment_status', array( $this, 'track_data' ), 100, 3 );

	}

	/**
	 * Output main tracking script.
	 *
	 * Output the main tracking script that GA requires.
	 *
	 * @since 1.2.0
	 */
	public function output_script() {
		if ( ! $ua = \EDD_Enhanced_eCommerce_Tracking\get_ua() ) {
			return;
		}

		do_action( 'eddeet_before_tracking_code' );

		?><script>
			(function( i, s, o, g, r, a, m ){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function() {
			(i[r].q=i[r].q||[]).push( arguments )},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName( o )[0];a.async=1;a.src=g;m.parentNode.insertBefore( a, m )
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			<?php do_action( 'eddeet_before_ga_create' ); ?>

			ga( 'create', '<?php echo esc_js( $ua ); ?>', 'auto' );

			<?php do_action( 'eddeet_before_send_pageview' );

			if ( edd_get_option( 'eddeet_anonymize_ip', false ) ) {
				?>ga('set', 'anonymizeIp', true);<?php
			}
			?>

			ga( 'send', 'pageview' );

			<?php do_action( 'eddeet_after_tracking_code' ); ?>

		</script><?php

	}

	/**
	 * API Call.
	 *
	 * Call the Google Analytics Measurement Protocol API to send tracking data.
	 *
	 * @since 1.0.0
	 * @param  array $body Array of data to send to the API.
	 * @return bool
	 */
	public function api_call( $body = array() ) {

		// Allow to bail on a API call
		if ( apply_filters( 'eddeet_api_call_return', false, $body ) ) {
			EDD_Enhanced_Ecommerce_Tracking()->log( 'eddeet_api_call_return for:' );
			EDD_Enhanced_Ecommerce_Tracking()->log( $body );
			return;
		}

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$user_language = isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ? explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) : array();
		$user_language = reset( $user_language );

		$default_body = array(
			'v'   => '1', // Required - Version
			'tid' => get_ua(), // Required - UA code
			'cid' => get_cid(), // Required - Unique (anonymous) visitor ID
			't'   => 'event', // Required - Hit type
			'ni'  => true, // Non interaction

			'dh'  => str_replace( array( 'http://', 'https://' ), '', site_url() ),
			'dp'  => $_SERVER['REQUEST_URI'],
			'dt'  => get_the_title(),

			// Hits that usually also go with JS
			'ul'  => $user_language, // Optional - User language

			'uip' => $ip, // Optional - User IP, to make sure its not the servers'
			'ua'  => $_SERVER['HTTP_USER_AGENT'], // Optional - User Agent

		);
		$body         = wp_parse_args( $body, $default_body );
		$body         = apply_filters( 'eddeet_api_call_body', $body );

		EDD_Enhanced_Ecommerce_Tracking()->log( $body );

		// Requests without ID are ignored by GA
		if ( false == $body['cid'] ) {
			return false;
		}

		$response = wp_remote_post( $this->api_url, array(
			'method'   => 'POST',
			'timeout'  => '5',
			'blocking' => false,
			'body'     => array_merge( $body, array( 'z' => time() ) ),
		) );

	}


	/**
	 * Track event.
	 *
	 * Method to track an event via the measurement protocol.
	 *
	 * @since 1.0.0
	 */
	public function track_event( $args = array() ) {

		$default_args = array(
			't'  => 'event', // Required - Hit type
			'ec' => '', // Event category
			'ea' => '', // Event Action
			'el' => '', // Event Label
			'ev' => null, // Event Value
		);
		$args         = wp_parse_args( $args, $default_args );
		$args         = apply_filters( 'eddeet_trigger_event_args', $args );

		$this->api_call( $args );

	}


	/**
	 * Send the tracking data.
	 *
	 * @since 1.2.0
	 */
	public function track_data() {
		$data = $this->data->get_tracking_data();
		$data = $this->format_tracking_data( $data );

		array_map( array( $this, 'track_event' ), $data );

		$this->data->tracked_data();
	}

	/**
	 * Format raw tracking data.
	 *
	 * Format the entire list of raw tracking data for this implementation.
	 *
	 * @since 1.2.0
	 *
	 * @param array $data List of raw tracking data.
	 * @return array List of formatted tracking data.
	 */
	private function format_tracking_data( $data ) {
		if ( empty( $data ) ) return $data;

		// Format data for implementation
		array_walk( $data, function( &$track_data ) use ( $data ) {
			$type = $track_data['type'];
			if ( method_exists( $this, 'format_' . $type ) ) {
				$track_data = call_user_func( array( $this, 'format_' . $type ), $track_data['body'], $data );
			}

			$track_data = apply_filters( 'eddeet/format_tracking_data/' . $type, $track_data, $data );
		});


		return $data;
	}


	private function format_view_item_list( $data ) {
		$c = 0;
		$formatted_data = array(
			'ec' => 'ecommerce',
			'ea' => 'impression',
			'el' => 'Impression',
		);

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				"il{$c}nm"    => 'Overview',
				"il{$c}pi1id" => $d['id'],
				"il{$c}pi1nm" => $d['name'],
				"il{$c}pi1ca" => $d['category'],
				"il{$c}pi1va" => isset( $d['variant'] ) ? $d['variant'] : '',
			) );
		}

		return $formatted_data;
	}


	private function format_view_item( $data ) {
		$c = 0;
		$formatted_data = array();

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				'ec'    => 'ecommerce',
				'ea'    => 'detail',
				'el'    => 'Detail',
				'pa'    => 'detail',
				'pal'   => '',
				"pr{$c}id" => $d['id'],
				"pr{$c}nm" => $d['name'],
				"pr{$c}ca" => $d['category'],
			) );
		}

		return $formatted_data;
	}


	private function format_add_to_cart( $data ) {
		$c = 0;
		$formatted_data = array(
			'ec'    => 'ecommerce',
			'ea'    => 'add',
			'el'    => edd_get_option( 'add_to_cart_text', __( 'Purchase', 'edd' ) ),
			'pa'    => 'add',
			'pal'   => '',
		);

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				"ev"       => $d['quantity'],
				"pr{$c}id" => $d['id'],
				"pr{$c}nm" => $d['name'],
				"pr{$c}ca" => $d['category'],
				"pr{$c}va" => $d['variant'], // Variant
				"pr{$c}pr" => $d['price'], // Price
				"pr{$c}qt" => $d['quantity'], // Quantity
			) );
		}

		return $formatted_data;
	}


	private function format_remove_from_cart( $data ) {
		$c = 0;
		$formatted_data = array(
			'ec'    => 'ecommerce',
			'ea'    => 'remove',
			'el'    => 'Remove',
			'ev'    => '',
			'pa'    => 'remove',
			'pal'   => '',
		);

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				"ev"       => $d['quantity'],
				"pr{$c}id" => $d['id'],
				"pr{$c}nm" => $d['name'],
				"pr{$c}ca" => $d['category'],
				"pr{$c}va" => $d['variant'], // Variant
				"pr{$c}pr" => $d['price'], // Price
				"pr{$c}qt" => $d['quantity'], // Quantity
			) );
		}

		return $formatted_data;
	}

	// @todo
	private function format_update_cart( $data ) {
		$c = 0;
		$formatted_data = array();

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				'pa'    => 'remove',
				'pal'   => '',
				"pr{$c}id" => $d['id'],
				"pr{$c}nm" => $d['name'],
				"pr{$c}ca" => $d['category'],
				"pr{$c}va" => $d['variant'], // Variant
				"pr{$c}pr" => $d['price'], // Price
				"pr{$c}qt" => $d['quantity'], // Quantity
			) );
		}

		return $formatted_data;
	}

	private function format_cart_items( $data ) {
		$c = 0;
		$formatted_data = array();

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				"pr{$c}id"  => $d['id'],
				"pr{$c}nm"  => $d['name'],
				"pr{$c}ca"  => $d['category'],
				"pr{$c}pr"  => $d['price'],
				"pr{$c}qt"  => $d['quantity'],
				"pr{$c}va"  => $d['variant'],
			) );
		}

		return $formatted_data;
	}

	private function format_begin_checkout( $data ) {
		$formatted_data = array_merge( array(
			't'   => 'event',
			'ec'  => 'ecommerce',
			'ea'  => 'checkout',
			'el'  => edd_get_option( 'eddeet_using_cart', '0' ) == '1' ? 'Cart' : 'Checkout page',
			'pa'  => 'checkout',
			'cos' => '1',
			'col' => edd_get_gateway_admin_label( edd_get_chosen_gateway() ),
		), $this->format_cart_items( $data ) );

		return $formatted_data;
	}


	private function format_checkout_progress( $data ) {
		$formatted_data = array_merge( array(
			't'   => 'event',
			'ec'  => 'ecommerce',
			'ea'  => 'checkout',
			'el'  => edd_get_option( 'eddeet_using_cart', '0' ) == '1' && ! edd_is_checkout() ? 'Checkout page' : 'Complete',
			'pa'  => 'checkout',
			'cos' => edd_get_option( 'eddeet_using_cart', '0' ) == '1' && ! edd_is_checkout() ? '3' : '2',
			'col' => edd_get_gateway_admin_label( edd_get_chosen_gateway() ),
		), $this->format_cart_items( $data ) );

		return $formatted_data;
	}

	private function format_transaction_items( $data ) {
		$c              = 0;
		$formatted_data = array();

		foreach ( $data['items'] as $k => $d ) {
			$c++;

			$formatted_data = array_merge( $formatted_data, array(
				"pr{$c}id" => $d['id'],
				"pr{$c}nm" => $d['name'],
				"pr{$c}ca" => $d['category'],
				"pr{$c}pr" => $d['price'],
				"pr{$c}qt" => $d['quantity'],
				"pr{$c}va" => $d['variant'],
			) );
		}

		return $formatted_data;
	}

	private function format_purchase( $data ) {
		$payment = edd_get_payment_by( 'payment_number', $data['transaction_id'] );

		$formatted_data = array_merge( array(
			't'   => 'event',
			'ec'  => 'ecommerce',
			'ea'  => 'checkout',
			'el'  => 'Transaction',
			'cid' => get_cid( $payment->ID ),

			'ti'  => $data['transaction_id'], // Transaction ID
			'ta'  => null, // Affiliation
			'tr'  => $data['value'], // Revenue
			'tt'  => $data['tax'], // Taxes
			'ts'  => null, // Shipping
			'tcc' => $data['coupon'], // Discount code
			'cu' => $data['currency'], // Payment currency

			'pa'  => 'purchase',
		), $this->format_transaction_items( $data ) );

		return $formatted_data;
	}

	private function format_refund( $data ) {
		$payment = edd_get_payment_by( 'payment_number', $data['transaction_id'] );

		$formatted_data = array(
			't'   => 'event',
			'ec'  => 'ecommerce',
			'ea'  => 'Refund',
			'el'  => 'Refund',
			'cid' => get_cid( $payment->ID ),
			'ti'  => $data['transaction_id'], // Transaction ID
			'pa'  => 'refund',
		);

		return $formatted_data;
	}

}

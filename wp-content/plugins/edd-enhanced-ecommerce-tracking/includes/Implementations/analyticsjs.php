<?php
namespace EDD_Enhanced_eCommerce_Tracking\Implementations;


/**
 * analytics.js implementation of Enhanced eCommerce.
 * Uses JavaScript to track visitor events.
 *
 * This is the older JS implementation and how the EDDEET_Data class structures its data by default.
 *
 * @link https://developers.google.com/analytics/devguides/collection/analyticsjs/
 * @package EDD_Enhanced_eCommerce_Tracking\Implementations
 */
class analyticsjs implements Analytics_Implementation {

	/** @var \EDDEET_Data */
	private $data;

	public function __construct( \EDDEET_Data $data ) {
		$this->data = $data;

		// Output tracking script
		add_action( 'wp_footer', array( $this, 'output_script' ) );
		add_action( 'admin_footer', array( $this, 'output_script' ) );

		// Make sure add/remove from cart AJAX actions get the proper response.
		add_filter( 'edd_ajax_add_to_cart_response', array( $this, 'add_ajax_tracking_data' ) );
		add_filter( 'edd_ajax_remove_from_cart_response', array( $this, 'add_ajax_tracking_data' ) );
		add_filter( 'edd_ajax_cart_item_quantity_response', array( $this, 'add_ajax_tracking_data' ) );
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

			if ( edd_get_option( 'eddeet_anonymize_ip', false ) ) : ?>
				ga('set', 'anonymizeIp', true);
			<?php endif; ?>

			ga('require', 'ec');

			<?php echo $this->track_data(); ?>

			<?php if ( ! is_admin() ) : ?>
				ga('send', 'pageview');
			<?php endif; ?>

			<?php do_action( 'eddeet_after_tracking_code' ); ?>

		</script><?php
	}


	/**
	 * Output JS tracking data.
	 *
	 * Output the code that registers ecommerce tracking and transactional data.
	 *
	 * @since 1.2.0
	 */
	public function track_data() {

		$tracking_data = $this->data->get_tracking_data();
		$tracking_data = $this->format_tracking_data( $tracking_data );

		?>
		var trackingData = <?php echo json_encode( $tracking_data, JSON_PRETTY_PRINT ); ?>;
		if (trackingData.length) {
			eddeet_track(trackingData);
			ga('send', 'event', 'ecommerce', 'track', {'nonInteraction': 1});
		}

		<?php // Let the system know the data has been tracked.
		$this->data->tracked_data();
		?>

		function eddeet_track(data) {
			if (typeof data[0] === 'object') {
				var i;
				for (i = 0; i < Object.keys(data).length; i++) {
					eddeet_track(data[i]);
				}
			} else {
				if (data.length) {
					ga.apply(this, data);
				}
			}
		}

		if (typeof jQuery !== 'undefined') {
			jQuery(document.body).on('edd_cart_item_added', eddeet_ajax_track_event);
			jQuery(document.body).on('edd_cart_item_removed', eddeet_ajax_track_event);
			<!-- jQuery(document.body).on('edd_quantity_updated', eddeet_ajax_track_event); // Bug in EDD causing it to trigger multiple times -->
		}

		function eddeet_ajax_track_event(event, response) {
			if (response.hasOwnProperty('tracking')) {
				eddeet_track(response.tracking);
				ga('send', 'event', 'ecommerce', 'track', {'nonInteraction': 1});
			}
		}<?php
	}


	/**
	 * Add tracking data to AJAX response.
	 *
	 * Add data that should get tracked to the AJAX response from the server.
	 *
	 * @since 1.2.0
	 *
	 * @param  array  $response Original response that the server sends.
	 * @return array            Modified response that the server sends.
	 */
	public function add_ajax_tracking_data( $response ) {
		$response['tracking'] = $this->format_tracking_data( $this->data->get_tracking_data() );
		$this->data->tracked_data();

		return $response;
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

		$impressions = array_filter( $data, function( $v ) {
			return $v['type'] == 'view_item_list';
		} );

		$data = array_filter( $data, function( $v ) {
			return $v['type'] != 'view_item_list';
		} );

		if ( isset( $impressions['impressions'] ) ) {
			array_walk( $impressions['impressions']['body']['items'], function( $v ) use ( &$data, $impressions ) {
				$impressions['impressions']['body'] = $v;
				array_push( $data, $impressions['impressions'] );
			}, $data );
		}

		// Format data for implementation
		array_walk( $data, function( &$track_data ) use ( $data ) {
			$type = $track_data['type'];
			if ( method_exists( $this, 'format_' . $type ) ) {
				$track_data = call_user_func( array( $this, 'format_' . $type ), $track_data, $data );
			}

			$track_data = apply_filters( 'eddeet/format_tracking_data/' . $type, $track_data, $data );
		});


		return $data;
	}

	private function format_view_item_list( $data ) {
		$data = array(
			'ec:addImpression',
			array(
				'id' => $data['body']['id'],
				'name' => $data['body']['name'],
				'category' => $data['body']['category'],
				'variant' => $data['body']['variant'],
				'list' => $data['body']['list_name'],
				'position' => $data['body']['list_position'],
			),
		);

		return $data;
	}

	private function format_view_item( $data ) {
		$item = reset( $data['body']['items'] );

		$data = array(
			'ec:addProduct',
			array(
				'id' => $item['id'],
				'name' => $item['name'],
				'category' => $item['category'],
				// 'variant' => $item['variant'],
			),
		);

		return $data;
	}

	private function format_add_to_cart( $data ) {
		$data = array(
			array(
				'ec:addProduct',
				reset( $data['body']['items'] ),
			),
			array(
				'ec:setAction',
				'add',
			),
		);

		return $data;
	}

	private function format_remove_from_cart( $data ) {
		$data = array(
			array(
				'ec:addProduct',
				reset( $data['body']['items'] ),
			),
			array(
				'ec:setAction',
				'remove',
			),
		);

		return $data;
	}

	private function format_begin_checkout( $data ) {
		$data = array_map( function( $item ) {
			return array( 'ec:addProduct', $item );
		}, $data['body']['items']);

		$data[] = array(
			'ec:setAction',
			'checkout',
			array(
				'step' => 1,
				'option' => edd_get_gateway_admin_label( edd_get_chosen_gateway() )
			),
		);

		return $data;
	}

	private function format_checkout_progress( $data ) {

		$data = array_map( function( $item ) {
			return array( 'ec:addProduct', $item );
		}, $data['body']['items']);

		$data[] = array(
			'ec:setAction',
			'checkout',
			array(
				'step' => edd_get_option( 'eddeet_using_cart', '0' ) == 1 && ! edd_is_checkout() ? 3 : 2,
				'option' => edd_get_gateway_admin_label( edd_get_chosen_gateway() )
			),
		);

		return $data;
	}

	private function format_purchase( $data, $raw ) {
		$payment_id = $data['payment_id'];
		$payment = new \EDD_Payment( $payment_id );

		$data = array_map( function( $item ) {
			return array( 'ec:addProduct', $item );
		}, $data['body']['items']);

		$data[] = array(
			'ec:setAction',
			'purchase',
			array(
				'id'      => edd_get_payment_number( $payment_id ),
				'revenue' => edd_get_payment_amount( $payment_id ),
				'tax'     => edd_use_taxes() ? edd_get_payment_tax( $payment_id ) : null,
				'coupon'  => $payment->discounts !== 'none' ? $payment->discounts : null,
				// 'affiliation' => '',
				// 'shipping' => '',
			),
		);

		$data[] = array( 'set', 'currencyCode', $payment->currency );

		return $data;
	}

	private function format_refund( $data, $raw ) {
		$payment_id = $data['payment_id'];

		$data = array_map( function( $item ) {
			return array( 'ec:addProduct', $item );
		}, $data['body']['items']);

		$data[] = array(
			'ec:setAction',
			'refund',
			array(
				'id' => edd_get_payment_number( $payment_id ),
			),
		);

		return $data;
	}

}

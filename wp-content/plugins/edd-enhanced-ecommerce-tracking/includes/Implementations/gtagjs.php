<?php
namespace EDD_Enhanced_eCommerce_Tracking\Implementations;


/**
 * gtag.js implementation of Enhanced eCommerce.
 * Uses JavaScript to track visitor events.
 *
 * This is the default implementation and how the EDDEET_Data class structures its data by default.
 * Making this the primary and easiest implementation.
 *
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/
 * @package EDD_Enhanced_eCommerce_Tracking\Implementations
 */
class gtagjs implements Analytics_Implementation {

	/** @var \EDDEET_Data */
	private $data;

	public function __construct( \EDDEET_Data $data ) {
		$this->data = $data;

		// Output tracking script
		add_action( 'wp_head', array( $this, 'output_script' ) );
		add_action( 'admin_head', array( $this, 'output_script' ) );

		// Output the data tracking code
		add_action( 'wp_footer', array( $this, 'track_data' ), 100 );
		add_action( 'admin_footer', array( $this, 'track_data' ), 10 );

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
		?><script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js( \EDD_Enhanced_eCommerce_Tracking\get_ua() ); ?>"></script><?php
	}


	/**
	 * Output JS tracking data.
	 *
	 * Output the code that registers pageviews and transactional data.
	 *
	 * @since 1.2.0
	 */
	public function track_data() {

		$config = array();
		if ( edd_get_option( 'eddeet_anonymize_ip', false ) ) {
			$config['anonymize_ip'] = true;
		}
		if ( is_admin() ) {
			$config['send_page_view'] = false;
		}
		?><script type="text/javascript">
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php echo esc_js( \EDD_Enhanced_eCommerce_Tracking\get_ua() ); ?>', <?php echo json_encode( (object) $config ); ?>);

			<?php
			foreach ( $this->data->get_tracking_data() as $k => $data ) :
				?>gtag('event', '<?php echo $data['type']; ?>', <?php echo json_encode( $data['body'], JSON_PRETTY_PRINT ); ?> );<?php echo PHP_EOL;
			endforeach;

			// Let the system know the data has been tracked.
			$this->data->tracked_data();
			?>

			if (typeof jQuery !== 'undefined') {
				jQuery(document.body).on('edd_cart_item_added', eddeet_ajax_track_event);
				jQuery(document.body).on('edd_cart_item_removed', eddeet_ajax_track_event);
				// jQuery(document.body).on('edd_quantity_updated', eddeet_ajax_track_event); // Bug in EDD causing it to trigger multiple times
			}

			function eddeet_ajax_track_event(event, response) {
				if (response.hasOwnProperty('tracking')) {
					for (var i = 0; i < response.tracking.length; i++) {
						var event = response.tracking[i];
						gtag('event', event.type, event.body );
					}
				}
			}
		</script><?php
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
		$response['tracking'] = $this->data->get_tracking_data();
		$this->data->tracked_data();

		return $response;
	}

}

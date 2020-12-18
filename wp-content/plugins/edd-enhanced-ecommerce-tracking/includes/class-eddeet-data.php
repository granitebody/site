<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class EDDEET_Data.
 *
 * Google Analytics Trigger class, this class takes care of all the
 * API triggers, like impressions and product link clicks.
 *
 * @since		1.2.0
 * @author		Jeroen Sormani
 */
class EDDEET_Data {

	/**
	 * Store impressions to send in one call.
	 *
	 * @since 1.2.0
	 * @var array $impressions List of products loaded on the page.
	 */
	private $impressions = array();

	/**
	 * @var array List of -raw- data that should be tracked. Formatted according to implementation.
	 */
	private $track_data = array();


	/**
	 * Constructor.
	 *
	 * @since 1.2.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'setup_tracking_data' ) );
		add_action( 'admin_init', array( $this, 'setup_tracking_data' ) );

		// Add impressions
		add_action( 'edd_purchase_link_end', array( $this, 'track_impressions' ), 10, 2 );

		// Download detail
		add_action( 'edd_purchase_link_end', array( $this, 'track_download_detail' ), 10, 2 );

		// Add to cart
		add_action( 'edd_pre_add_to_cart', array( $this, 'track_add_to_cart' ), 10, 2 );

		// Remove from cart - @todo track checkout remove from cart
		add_action( 'edd_pre_remove_from_cart', array( $this, 'track_remove_from_cart' ), 10, 1 );

		// Update cart quantity @todo
		add_action( 'wp_ajax_edd_update_quantity', array( $this, 'track_update_cart_quantity' ), 5 );
		add_action( 'wp_ajax_nopriv_edd_update_quantity', array( $this, 'track_update_cart_quantity' ), 5 );

		// Checkout begin? (cart)
		add_action( 'edd_before_cart', array( $this, 'track_checkout_cart' ) );

		// Checkout begin? (checkout)
		add_action( 'edd_before_checkout_cart', array( $this, 'track_checkout_page' ) );

		// Checkout progress
		add_action( 'edd_complete_purchase', array( $this, 'track_checkout_complete' ) );

		// Transaction
		add_action( 'edd_update_payment_status', array( $this, 'track_transaction' ), 10, 3 );

		// Refund
		add_action( 'edd_update_payment_status', array( $this, 'track_refund' ), 10, 3 );

	}

	/**
	 * Get tracking data.
	 *
	 * @since 1.2.0
	 *
	 * @return array List of data to track.
	 */
	public function get_tracking_data() {
		return array_filter( $this->track_data );
	}

	/**
	 * Get tracking data from session.
	 *
	 * @return array
	 */
	public function get_tracking_data_from_session() {
		$tracking_data = EDD()->session->get( 'eddeet_track_data' );

		return array_filter( (array) $tracking_data );
	}

	public function setup_tracking_data() {
		$this->track_data = $this->get_tracking_data_from_session();
	}

	/**
	 * Add tracking data.
	 *
	 * @param $data
	 * @return array
	 */
	public function add_track_data( $data ) {
		$this->track_data[] = $data;

		EDD()->session->set( 'eddeet_track_data', $this->track_data );

		return $this->track_data;
	}

	/**
	 * Triggered when the data has been tracked.
	 */
	public function tracked_data() {
		do_action( 'eddeet/trakcked_data', $this->get_tracking_data() );

		EDD()->session->set( 'eddeet_track_data', array() );
	}


	/**
	 * Product impression.
	 *
	 * Add a impression the list of impressions. The impressions
	 * are send to the Google API at the end of the page.
	 *
	 * @since 1.2.0
	 *
	 * @param int $download_id ID of the download being loaded.
	 * @param array $args Purchase link args.
	 */
	public function track_impressions( $download_id, $args ) {
		if ( is_singular( 'download' ) ) {
			return;
		}

		$download       = new EDD_Download( $download_id );
		$categories     = (array) get_the_terms( $download->ID, 'download_category' );
		$category_names = wp_list_pluck( $categories, 'name' );
		$first_category = reset( $category_names );
		$list           = $this->get_the_list();
		$c              = count( $this->impressions ) + 1;

		// Prevent duplicate impressions on one page
		if ( isset( $this->track_data['impressions'][ $download->ID ] ) ) {
			return;
		}

		$this->track_data['impressions']['type']            = 'view_item_list';
		$this->track_data['impressions']['body']['items'][] = array(
			'list_name'     => 'Overview',
			'id'            => $download->ID,
			'name'          => $download->post_title,
			'category'      => $first_category,
			'variant'       => '',
			'list_position' => $c,
			'price'         => '',
		);

		EDD()->session->set( 'eddeet_track_data', $this->track_data );
	}


	/**
	 * Get download detail args.
	 *
	 * @since 1.2.0
	 *
	 * @param int $download_id ID of the download being loaded.
	 * @param array $args Purchase link args.
	 * @return array|mixed|void
	 */
	public function track_download_detail( $download_id, $args ) {
		if ( ! is_singular( 'download' ) ) {
			return;
		}

		// Bail if this product detail is already tracked. Prevents
		// double tracking as there could be multiple buy buttons on the page.
		if ( isset( $this->tracked_detail ) && $this->tracked_detail >= 1 ) {
			return;
		} else {
			$this->tracked_detail = 1;
		}

		$download       = new EDD_Download( $download_id );
		$categories     = (array) get_the_terms( $download->ID, 'download_category' );
		$category_names = wp_list_pluck( $categories, 'name' );
		$first_category = reset( $category_names );
		$list           = $this->get_the_list();

		$this->add_track_data( array(
			'type' => 'view_item',
			'body' => array(
				'items' => array(
					array(
						'id'       => $download_id,
						'name'     => $download->get_name(),
						'category' => $first_category,
						'price'    => $download->get_price(),
					),
				),
			),
		) );
	}


	/**
	 * Add to cart.
	 *
	 * Add a trigger for adding a product to the cart.
	 *
	 * @since 1.2.0
	 *
	 * @param int $download_id
	 * @param array $options
	 */
	public function track_add_to_cart( $download_id, $options ) {

		$download      = new EDD_Download( $download_id );
		$price_options = $download->get_prices();

		$price_id       = isset( $options['price_id'] ) ? ( is_array( $options['price_id'] ) ? $options['price_id'][0] : $options['price_id'] ) : false;
		$variation      = isset( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';
		$price          = isset( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['amount'] : '';
		$price          = empty( $price ) ? $download->get_price() : $price;
		$quantity       = isset( $options['quantity'] ) ? $options['quantity'] : 1;
		$categories     = (array) get_the_terms( $download->ID, 'download_category' );
		$category_names = wp_list_pluck( $categories, 'name' );
		$first_category = reset( $category_names );
		$list           = $this->get_the_list();

		$this->add_track_data( array(
			'type' => 'add_to_cart',
			'body' => array(
				'items' => array(
					array(
						'id'        => $download_id,
						'name'      => $download->get_name(),
						'variant'   => $variation,
						'quantity'  => $quantity,
						'category'  => $first_category,
						'price'     => $price,
						'list_name' => $list,
					),
				),
			),
		) );

	}


	/**
	 * Remove from cart.
	 *
	 * Add a trigger for removing a product to the cart.
	 *
	 * @since 1.2.0
	 *
	 * @param string $cart_key Index key of the cart item being removed.
	 */
	public function track_remove_from_cart( $cart_key ) {

		$cart_contents = edd_get_cart_contents();

		// Bail if cart key doesn't exist
		if ( ! isset( $cart_contents[ $cart_key ] ) ) {
			return;
		}

		$download       = new EDD_Download( $cart_contents[ $cart_key ]['id'] );
		$price_options  = $download->get_prices();
		$price_id       = isset( $cart_contents[ $cart_key ]['options']['price_id'] ) ? $cart_contents[ $cart_key ]['options']['price_id'] : null;
		$variation      = isset( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';
		$price          = isset( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['amount'] : '';
		$price          = empty( $price ) ? $download->get_price() : $price;
		$quantity       = isset( $cart_contents[ $cart_key ]['quantity'] ) ? $cart_contents[ $cart_key ]['quantity'] : 1;
		$categories     = (array) get_the_terms( $download->ID, 'download_category' );
		$category_names = wp_list_pluck( $categories, 'name' );
		$first_category = reset( $category_names );
		$list           = $this->get_the_list();

		$this->add_track_data( array(
			'type' => 'remove_from_cart',
			'body' => array(
				'items' => array(
					array(
						'id'        => $download->ID,
						'name'      => $download->get_name(),
						'variant'   => $variation,
						'quantity'  => $quantity,
						'category'  => $first_category,
						'price'     => $price,
						'list_name' => $list,
					),
				),
			),
		) );
	}


	/**
	 * Trigger cart update.
	 *
	 * Trigger the adding or removing from products from the cart.
	 *
	 * @since 1.2.0
	 */
	public function track_update_cart_quantity() {

		// Bail if quantity/id is not set
		if ( ! isset( $_POST['quantity'] ) || ! isset( $_POST['download_id'] ) || empty( $_POST['quantity'] ) || empty( $_POST['download_id'] ) ) {
			return;
		}

		$origin_qty     = 1;
		$updated_qty    = $_POST['quantity'];
		$cart_contents  = edd_get_cart_contents();
		$download       = new EDD_Download( $_POST['download_id'] );
		$price_options  = $download->get_prices();
		$options        = isset( $_POST['options'] ) ? maybe_unserialize( stripslashes( $_POST['options'] ) ) : null;
		$price_id       = isset( $options['price_id'] ) ? $options['price_id'] : null;
		$variation      = ! empty( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';
		$price          = isset( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['amount'] : '';
		$price          = empty( $price ) ? $download->get_price() : $price;
		$categories     = (array) get_the_terms( $download->ID, 'download_category' );
		$category_names = wp_list_pluck( $categories, 'name' );
		$first_category = reset( $category_names );


		// Get the original quantity
		foreach ( $cart_contents as $key => $item ) {
			if ( $_POST['download_id'] == $item['id'] ) {
				$origin_qty = $item['quantity'];
			}
		}


		// New qty is bigger, added products
		if ( $updated_qty > $origin_qty ) {

			$this->add_track_data( array(
				'type' => 'add_to_cart',
				'body' => array(
					'items' => array(
						array(
							'id'        => $download->ID,
							'name'      => $download->get_name(),
							'variant'   => $variation,
							'quantity'  => absint( $updated_qty - $origin_qty ),
							'category'  => $first_category,
							'price'     => $price,
							'list_name' => '',
						),
					),
				),
			) );

			// New qty is lower, removed products
		} elseif ( $updated_qty < $origin_qty ) {

			$this->add_track_data( array(
				'type' => 'remove_from_cart',
				'body' => array(
					'items' => array(
						array(
							'id'        => $download->ID,
							'name'      => $download->get_name(),
							'variant'   => $variation,
							'quantity'  => absint( $origin_qty - $updated_qty ),
							'category'  => $first_category,
							'price'     => $price,
							'list_name' => '',
						),
					),
				),
			) );

		}

	}


	/**
	 * Cart items.
	 *
	 * Method to return a formatted array of the cart items with their data.
	 * Used in $this->trigger_checkout_cart() and $this->trigger_checkout_step_1().
	 *
	 * @since 1.2.0
	 *
	 * @return array List of cart items formatted to send along with a GA API request.
	 */
	public function get_formatted_cart_items() {

		$items         = array();
		$cart_contents = edd_get_cart_content_details();

		if ( $cart_contents ) {
			foreach ( $cart_contents as $key => $item ) {

				$download       = new EDD_Download( $item['id'] );
				$price_options  = $download->get_prices();
				$price_id       = isset( $item['item_number']['options']['price_id'] ) ? $item['item_number']['options']['price_id'] : null;
				$variation      = ! empty( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';
				$categories     = (array) get_the_terms( $item['id'], 'download_category' );
				$category_names = wp_list_pluck( $categories, 'name' );
				$first_category = reset( $category_names );

				$items[] = array(
					'id'       => $item['id'],
					'name'     => $item['name'],
					'variant'  => $variation,
					'quantity' => $item['quantity'],
					'category' => $first_category,
					'price'    => $item['item_price'],
				);
			}
		}

		return $items;
	}


	/**
	 * Cart checkout.
	 *
	 * When the option 'I use a cart' is set, the cart will be set as checkout step 1.
	 *
	 * @since 1.2.0
	 */
	public function track_checkout_cart() {
		if ( '1' == edd_get_option( 'eddeet_using_cart', '0' ) ) {

			$this->add_track_data( array(
				'type' => 'begin_checkout',
				'body' => array(
					'items' => $this->get_formatted_cart_items(),
					'coupon' => implode( ', ', EDD()->cart->get_discounts() ),
				),
			) );
		}
	}


	/**
	 * Checkout page.
	 *
	 * Trigger the API tracking call for the checkout page.
	 *
	 * @since 1.2.0
	 */
	public function track_checkout_page() {

		// Bail if its not the checkout
		if ( ! edd_is_checkout() ) {
			return;
		}

		$this->add_track_data( array(
			'type' => edd_get_option( 'eddeet_using_cart', '0' ) == '1' ? 'checkout_progress' : 'begin_checkout',
			'body' => array(
				'items' => $this->get_formatted_cart_items(),
				'coupon' => implode( ', ', EDD()->cart->get_discounts() ),
			),
		) );
	}


	/**
	 * Checkout complete.
	 *
	 * Trigger the API tracking call for the checkout complete page.
	 *
	 * @since 1.2.0
	 *
	 * @param int $payment_id ID of the payment that is just completed.
	 */
	public function track_checkout_complete( $payment_id ) {
		return; // It is not possible to have two different 'ec:setAction' on one page
		$this->add_track_data( array(
			'type' => 'checkout_progress',
			'body' => array(
				'items' => $this->get_transaction_items( $payment_id ),
			),
		) );
	}


	/**
	 * Trigger transaction.
	 *
	 * Trigger the API tracking call for transaction.
	 *
	 * @since 1.2.0
	 *
	 * @param int $payment_id ID of the transaction payment.
	 */
	public function track_transaction( $payment_id, $new_status, $old_status ) {

		// Bail if the current status update isn't for completion.
		if ( 'publish' !== $new_status && 'complete' !== $new_status ) {
			return;
		}

		// Bail if payment is already tracked
		if ( 'yes' == get_post_meta( $payment_id, 'eddeet_tracked', true ) ) {
			return;
		}

		$payment = new EDD_Payment( $payment_id );

		$this->add_track_data( array(
			'type'       => 'purchase',
			'payment_id' => $payment_id,
			'body'       => array(
				'transaction_id' => edd_get_payment_number( $payment_id ), // Transaction ID
				'value'          => edd_get_payment_amount( $payment_id ), // Revenue
				'currency'       => $payment->currency,
				'tax'            => edd_use_taxes() ? edd_get_payment_tax( $payment_id ) : null, // Taxes
				'coupon'         => $payment->discounts !== 'none' ? $payment->discounts : null, // Coupon
				'items'          => $this->get_transaction_items( $payment_id ),
//				'affiliation' => '', // Affiliation
			),
		) );

		update_post_meta( $payment_id, 'eddeet_tracked', 'yes' );

	}


	/**
	 * Transaction items.
	 *
	 * Prepare the transaction items for API call.
	 *
	 * @since 1.2.0
	 *
	 * @param  int   $payment_id ID of the payment being prepared for the tracking API call.
	 * @return array             List of download items that are bought.
	 */
	private function get_transaction_items( $payment_id ) {

		$items        = array();
		$payment_meta = edd_get_payment_meta( $payment_id );

		if ( $payment_meta['cart_details'] ) {
			foreach ( $payment_meta['cart_details'] as $key => $item ) {

				$download       = new EDD_Download( $item['id'] );
				$price_options  = $download->get_prices();
				$price_id       = isset( $item['item_number']['options']['price_id'] ) ? $item['item_number']['options']['price_id'] : null;
				$variation      = ! is_null( $price_id ) && isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';
				$categories     = (array) get_the_terms( $item['id'], 'download_category' );
				$category_names = wp_list_pluck( $categories, 'name' );
				$first_category = reset( $category_names );

				$items[] = array(
					'id'       => $item['id'],
					'name'     => $item['name'],
					'variant'  => $variation,
					'quantity' => $item['quantity'],
					'category' => $first_category,
					'price'    => $item['item_price'],
				);
			}
		}

		return $items;
	}


	/**
	 * Track refunds.
	 *
	 * Track refunds when a order status goes to 'refunded'.
	 *
	 * @since 1.2.0
	 *
	 * @param int    $payment_id ID of the payment that is being changed.
	 * @param string $new_status The new status string.
	 * @param string $old_status Old status string.
	 */
	public function track_refund( $payment_id, $new_status, $old_status ) {

		// Bail if purchase is not being refunded
		if ( 'refunded' != $new_status || 'yes' == get_post_meta( $payment_id, 'eddeet_tracked_refund', true ) ) {
			return;
		}

		$payment = new EDD_Payment( $payment_id );

		$this->add_track_data( array(
			'type' => 'refund',
			'payment_id' => $payment_id,
			'body' => array(
				'transaction_id' => edd_get_payment_number( $payment_id ), // Transaction ID
				'value'          => edd_get_payment_amount( $payment_id ), // Revenue
				'currency'       => $payment->currency,
				'tax'            => edd_use_taxes() ? edd_get_payment_tax( $payment_id ) : null, // Taxes
				'items'          => $this->get_transaction_items( $payment_id ),
//				'affiliation' => '', // Affiliation
			),
		) );

		update_post_meta( $payment_id, 'eddeet_tracked_refund', 'yes' );

	}


	/**
	 * Get the list.
	 *
	 * Get the list the the current page is showing the product impression on.
	 *
	 * @since 1.2.0
	 *
	 * @return string
	 */
	public function get_the_list() {
		$list = 'Default';

		if ( is_search() ) {
			$list = __( 'Search results', 'edd-enhanced-ecommerce-tracking' );
		}

		return urlencode( $list );
	}


	/**
	 * Save cID.
	 *
	 * Save the cID of the user in the database - temporarily.
	 * This method has been brought to life as the tracking
	 * after a PayPal purchase did not recognize ANY cookies.
	 *
	 * @since 1.0.3
	 *
	 * @param int   $payment_id   ID of the payment being done.
	 * @param array $payment_data List of payment data.
	 */
	public function save_user_cid( $payment_id, $payment_data ) {

		if ( isset( $_COOKIE['_ga'] ) ) {
			list( $version, $domainDepth, $cid1, $cid2 ) = preg_split( '[\.]', $_COOKIE['_ga'], 4 );
			$contents = array( 'version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1 . '.' . $cid2 );
			$cid      = $contents['cid'];
			update_post_meta( $payment_id, 'eddeet_cid', $cid );
		}
	}
}

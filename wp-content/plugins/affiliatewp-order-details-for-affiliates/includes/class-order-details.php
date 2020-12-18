<?php
/**
 * Order Details class
 */
class AffiliateWP_Order_Details_For_Affiliates_Order_Details {

	/**
	 * Allowed order details
	 *
	 * @since 1.0
	 * @return  array allowed order details
	 */
	public function allowed() {

		$disabled = affiliate_wp()->settings->get( 'odfa_disable_details' );
		$disabled = $disabled ? $disabled : array();

		$allowed = array(
			'customer_name'             => array_key_exists( 'customer_name', $disabled ) ? false : true,
			'customer_email'            => array_key_exists( 'customer_email', $disabled ) ? false : true,
			'customer_billing_address'  => array_key_exists( 'customer_billing_address', $disabled ) ? false : true,
			'customer_shipping_address' => array_key_exists( 'customer_shipping_address', $disabled ) ? false : true,
			'customer_phone'            => array_key_exists( 'customer_phone', $disabled ) ? false : true,
			'order_number'              => array_key_exists( 'order_number', $disabled ) ? false : true,
			'order_total'               => array_key_exists( 'order_total', $disabled ) ? false : true,
			'order_date'                => array_key_exists( 'order_date', $disabled ) ? false : true,
			'referral_amount'           => array_key_exists( 'referral_amount', $disabled ) ? false : true,
			'coupon_code'               => array_key_exists( 'coupon_code', $disabled ) ? false : true,
		);

		return (array) apply_filters( 'affwp_odfa_allowed_details', $allowed );
	}

	/**
	 * Referral arguments
	 *
	 * @since 1.0.4
	 * 
	 * @return array $args
	 */
	public function referral_args() {

		// Get the shortcode attributes.
		global $affwp_od_atts;

		// Set up defaults.
		$args = apply_filters( 'affwp_odfa_referral_args', 
			array(
				'affiliate_id' => (int) affwp_get_affiliate_id(),
				'number'       => 100,
				'status'       => array( 'unpaid', 'paid' )
			), affwp_get_affiliate_id()
		);

		// Override the affiliate ID if added to the [affiliate_order_details] shortcode.
		if ( ! empty( $affwp_od_atts['affiliate_id'] ) ) {
			$args['affiliate_id'] = (int) $affwp_od_atts['affiliate_id'];
		}

		// Override the number of referrals if added to the [affiliate_order_details] shortcode.
		if ( ! empty( $affwp_od_atts['number'] ) ) {
			$args['number'] = $affwp_od_atts['number'];
		}

		// Override the status if added to the [affiliate_order_details] shortcode.
		if ( ! empty( $affwp_od_atts['status'] ) ) {
			$args['status'] = explode( ',', $affwp_od_atts['status'] );
			$args['status'] = array_filter( array_map( 'trim', $args['status']) ); 
		}

		return $args;
	}

	/**
	 * Determines if the order attached to the referral actually exists.
	 *
	 * @access public
	 * @since  1.1.3
	 *
	 * @param int|\AffWP\Referral $referral Referral object or ID.
	 * @return bool True if the order exists, otherwise false.
	 */
	public function exists( $referral ) {
		$exists = true;

		switch( $referral->context ) {
			case 'edd':
				if ( ! function_exists( 'edd_get_payment' )
					|| ( function_exists( 'edd_get_payment' ) && ! edd_get_payment( $referral->reference ) )
				) {
					$exists = false;
				}

				break;

			case 'woocommerce':

				if( ! class_exists( 'WC_Order' ) ) {
					break;
				}

				if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {

					try {
						$order = new WC_Order( $referral->reference );
					} catch ( Exception $e ) {

						$this->woocommerce_order_error( $referral );

						$exists = false;
					}

				} else {

					$order = new WC_Order( $referral->reference );

					if ( $order->id <= 0 ) {
						$this->woocommerce_order_error( $referral );

						$exists = false;
					}

				}

				break;
		}

		return $exists;
	}

	/**
	 * Handles messaging/logging output in the event of a WooCommerce order error on retrieval.
	 *
	 * @access private
	 * @since  1.1.3
	 *
	 * @param \AffWP\Referral $referral Referral object.
	 */
	private function woocommerce_order_error( $referral ) {
		if ( method_exists( 'Affiliate_WP_Utilities', 'log' ) ) {
			affiliate_wp()->utils->log( sprintf( 'Invalid order ID #%1$s for referral #%2$s in the Order Details tab.', $referral->reference, $referral->referral_id ) );
		}

		esc_html_e( 'No data could be found for the current order.', 'affiliatewp-order-details-for-affiliates' );
	}

	/**
	 * Has customer details or order details
	 *
	 * @since 1.0.1
	 * @return boolean
	 */
	public function has( $type = '' ) {

		$ret = false;
		$is_allowed = affiliatewp_order_details_for_affiliates()->order_details->allowed();

		switch ( $type ) {

			case 'customer_details':

				if (
					$is_allowed['customer_name'] ||
					$is_allowed['customer_email'] ||
					$is_allowed['customer_phone'] ||
					$is_allowed['customer_shipping_address'] ||
					$is_allowed['customer_billing_address']

				) {
					$ret = true;
				}

				break;

			case 'order_details':

				if (
					$is_allowed['order_number'] ||
					$is_allowed['order_total'] ||
					$is_allowed['order_date'] ||
					$is_allowed['coupon_code'] ||
					$is_allowed['referral_amount']

				) {
					$ret = true;
				}

				break;

		}

		return $ret;
	}

	/**
	 * Retrieve specific order information
	 */
	public function get( $referral = '', $info = '' ) {

		$is_allowed = $this->allowed();

		switch ( $referral->context ) {

			case 'edd':
				if ( ! function_exists( 'edd_get_payment_meta' ) ) {
					break;
				}

				$payment        = new EDD_Payment( $referral->reference );
				$payment_meta   = edd_get_payment_meta( $referral->reference );
				$user_info      = edd_get_payment_meta_user_info( $referral->reference );

				if ( $info == 'order_number' ) {
					return $is_allowed['order_number'] ? $referral->reference : '';
				}

				if ( $info == 'order_date' ) {
					return $is_allowed['order_date'] ? $payment_meta['date'] : '';
				}

				if ( $info == 'order_total' ) {
					return $is_allowed['order_total'] ? edd_currency_filter( edd_format_amount( edd_get_payment_amount( $referral->reference ) ) ) : '';
				}

				if ( $info == 'coupon_code' ) {
					return $is_allowed['coupon_code'] && 'none' !== $payment->discounts ? $payment->discounts : '';
				}

				if ( $info == 'customer_name' ) {
					return $is_allowed['customer_name'] ? $payment->first_name . ' ' . $payment->last_name : '';
				}

				if ( $info == 'customer_email' ) {
					return $is_allowed['customer_email'] && isset( $user_info['email'] ) ? $user_info['email'] : '';
				}

				if ( $info == 'customer_address' ) {
					//return $is_allowed['customer_email'] && isset( $user_info['email'] ) ? $user_info['email'] : '';

					$address = ! empty( $user_info['address'] ) ? $user_info['address'] : '';

					if ( $is_allowed['customer_address'] && ! empty( $address ) ) {
						$customer_address = $address['line1'] . '<br />';
						$customer_address .= $address['line2'] . '<br />';
						$customer_address .= $address['city'] . '<br />';
						$customer_address .= $address['zip'] . '<br />';
						$customer_address .= $address['state'] . '<br />';
						$customer_address .= $address['country'] . '<br />';
					}

					return ! empty( $customer_address ) ? $customer_address : '';

				}

				break;

			case 'woocommerce':

				if ( ! class_exists( 'WC_Order' ) ) {
					break;
				}

				$order = new WC_Order( $referral->reference );

				if ( $info == 'order_number' ) {

					if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {
						$order_id = $order->get_id();
					} else {
						$order_id = $order->id;
					}

					$seq_order_number = get_post_meta( $order_id, '_order_number', true );

					// sequential order numbers compatibility
					if ( $seq_order_number && class_exists( 'WC_Seq_Order_Number_Pro' ) ) {
						$order_number = $seq_order_number;
					} else {
						$order_number = $referral->reference;
					}

					return $is_allowed['order_number'] ? $order_number : '';

				}

				if ( $info == 'order_date' ) {
					if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {
						$order_date = $order->get_date_created();
					} else {
						$order_date = $order->order_date;
					}

					return $is_allowed['order_date'] ? $order_date : '';
				}

				if ( $info == 'order_total' ) {
					return $is_allowed['order_total'] ? $order->get_formatted_order_total() : '';
				}

				if ( $info == 'coupon_code' ) {
					return $is_allowed['coupon_code'] ? implode( ', ', $order->get_used_coupons() ) : '';
				}

				if ( $info == 'customer_name' ) {
					if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {
						$name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
					} else {
						$name = $order->billing_first_name . ' ' . $order->billing_last_name;;
					}

					return $is_allowed['customer_name'] && $name ? $name : '';
				}

				if ( $info == 'customer_email' ) {
					if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {
						$billing_email = $order->get_billing_email();
					} else {
						$billing_email = $order->billing_email;
					}

					return $is_allowed['customer_email'] && $billing_email ? $billing_email : '';
				}

				if ( $info == 'customer_phone' ) {
					if ( affiliatewp_order_details_for_affiliates()->woocommerce_is_300() ) {
						$billing_phone = $order->get_billing_phone();
					} else {
						$billing_phone = $order->billing_phone;
					}

					return $is_allowed['customer_phone'] && $billing_phone ? $billing_phone : '';
				}

				if ( $info == 'customer_shipping_address' ) {
					return $is_allowed['customer_shipping_address'] && $order->get_formatted_shipping_address() ? $order->get_formatted_shipping_address() : '';
				}

				if ( $info == 'customer_billing_address' ) {
					return $is_allowed['customer_billing_address'] && $order->get_formatted_billing_address() ? $order->get_formatted_billing_address() : '';
				}

				break;
		}

		if ( $info == 'referral_amount' ) {
			return $is_allowed['referral_amount'] ? affwp_currency_filter( $referral->amount ) : '';
		}

		do_action( 'affwp_odfa_order_details', $referral, $info );
	}


}

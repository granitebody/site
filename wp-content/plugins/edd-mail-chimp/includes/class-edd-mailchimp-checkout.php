<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class EDD_MailChimp_Checkout {

	public function __construct() {
		add_action( 'edd_purchase_form_before_submit', array( $this, 'checkout_fields' ), 100 );
		add_action( 'edd_checkout_before_gateway', array( $this, 'checkout_signup' ), 10, 3 );
		add_action( 'edd_payment_saved', array( $this, 'store_payment_meta' ), 10, 2 );
		add_action( 'edd_complete_purchase', array( $this, 'completed_purchase_signup' ), 30, 3 );
	}

	/**
	* Output the signup checkbox on the checkout screen, if enabled
	*/
	public function checkout_fields() {
		if( ! self::_show_checkout_signup() ) {
			return;
		}

		$label = edd_get_option('eddmc_label');
		$checked = edd_get_option('eddmc_checkout_signup_default_value', false);

		if( ! empty( $label ) ) {
			$checkout_label = trim( $label );
		} else {
			$checkout_label = __( 'Signup for the newsletter', 'eddmc' );
		}

		ob_start(); ?>
		<fieldset id="edd_mailchimp">
			<p>
				<input name="edd_mailchimp_signup" id="edd_mailchimp_signup" type="checkbox" <?php if ($checked) { echo 'checked="checked"'; } ?>/>
				<label for="edd_mailchimp_signup"><?php echo $checkout_label; ?></label>
			</p>
		</fieldset>
		<?php
		echo ob_get_clean();
	}


	/**
	 * Check if a customer needs to be subscribed at checkout
	 */
	public function checkout_signup( $posted, $user_info, $valid_data ) {

		if ( empty( $posted['edd_mailchimp_signup'] ) ) {
			EDD()->session->set( 'eddmc_subscribed_at_checkout', null );
			edd_debug_log( 'checkout_signup() not added to session because edd_mailchimp_signup was not present' );
			return;
		}

		edd_debug_log( 'checkout_signup() added opt-in status to the purchase session' );
		EDD()->session->set( 'eddmc_subscribed_at_checkout', 1 );

	}

	/**
	 * Store the opt-in status on the payment meta, so we can use it after it is processed.
	 *
	 * @param int         $payment_id
	 * @param EDD_Payment $payment
	 */
	public function store_payment_meta( $payment_id = 0, EDD_Payment $payment ) {

		// We only need to process MailChimp subscriptions on orders just created.
		if ( empty( $payment->new ) ) {
			return;
		}

		$opt_in_status = EDD()->session->get( 'eddmc_subscribed_at_checkout' );
		if ( ! empty( $opt_in_status ) ) {
			edd_debug_log( 'store_payment_meta() opt-in status saved to payment meta' );
			$payment->update_meta( '_mc_subscribed', 1 );
		}
	}

	/**
	 * Check if a customer needs to be subscribed on completed purchase for the default list and of specific products
	 *
	 * @param int $payment_id        The Payment ID being completed.
	 * @param EDD_Payment $payment   The EDD_Payment object of the payment being completed.
	 * @param EDD_Customer $customer The customer being processed.
	 */
	public function completed_purchase_signup( $payment_id = 0, EDD_Payment $payment, EDD_Customer $customer ) {

		edd_debug_log( 'completed_purchase_signup() started for payment ' . $payment_id );

		$user = array(
			'first_name' => $payment->first_name,
			'last_name'  => $payment->last_name,
			'email'      => $payment->email,
		);

		// First we process the default list handling.
		$default_list = EDD_MailChimp_List::get_default();
		$opted_in     = $payment->get_meta( '_mc_subscribed' );

		edd_debug_log( 'completed_purchase_signup(): default list is ' . $default_list->remote_id );
		edd_debug_log( 'completed_purchase_signup(): default list opt-in status ' . var_export( $opted_in, true ) );

		if ( $default_list && $opted_in ) {

			edd_debug_log( 'completed_purchase_signup(): user info ' . var_export( $user, true ) );

			$subscribed = $default_list->subscribe( $user );

			edd_debug_log( 'completed_purchase_signup() customer subscription result: ' . var_export( $subscribed, true ) );

			if( $subscribed ) {

				edd_debug_log( 'completed_purchase_signup() customer subscription response from MailChimp: ' . var_export( $default_list->api->getLastResponse(), true ) );

			} else {

				edd_debug_log( 'completed_purchase_signup() MailChimp request:' . var_export( $default_list->api->getLastRequest(), true ) );
				edd_debug_log( 'completed_purchase_signup() MailChimp error:' . var_export( $default_list->api->getLastError(), true ) );

			}

		}

		// Then we go through each item purchased and handle the per-list subscription status.
		foreach ( $payment->cart_details as $line ) {

			edd_debug_log( 'completed_purchase_signup() processing Download ' . $line['id'] );

			$download = new EDD_MailChimp_Download( (int) $line['id'] );
			$preferences = $download->subscription_preferences();

			$double_opt_in = get_post_meta( $line['id'], 'edd_mailchimp_double_opt_in', true );

			foreach( $preferences as $preference ) {

				// TODO: Determine if we need to respect the main double opt-in if the per product one is disabled?
				$list = new EDD_MailChimp_List( $preference['remote_id'] );
				$options = array( 'interests' => $preference['interests'] );
				$is_double_opt_in = ! empty( $double_opt_in );
				$options['double_opt_in'] = $is_double_opt_in;

				edd_debug_log( 'completed_purchase_signup() about to subscribe customer. User data: ' . print_r( $user, true ) . 'Options data: ' . print_r( $options, true ) );

				$subscribed = $list->subscribe( $user, $options );

				edd_debug_log( 'completed_purchase_signup() customer subscription result: ' . var_export( $subscribed, true ) );

				if( $subscribed ) {

					edd_debug_log( 'completed_purchase_signup() customer subscription response from MailChimp: ' . var_export( $list->api->getLastResponse(), true ) );

				} else {

					edd_debug_log( 'completed_purchase_signup() MailChimp request:' . var_export( $list->api->getLastRequest(), true ) );
					edd_debug_log( 'completed_purchase_signup() MailChimp error:' . var_export( $list->api->getLastError(), true ) );

				}

			}
		}

		edd_debug_log( 'completed_purchase_signup() completed for payment ' . $payment_id );

	}

	/**
	* Determines if the checkout signup option should be displayed
	*/
	private static function _show_checkout_signup() {
		$show = edd_get_option('eddmc_show_checkout_signup');
		return ! empty( $show );
	}

}
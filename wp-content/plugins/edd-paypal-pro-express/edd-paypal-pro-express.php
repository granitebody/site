<?php
/*
Plugin Name: Easy Digital Downloads - PayPal Website Payments Pro and PayPal Express Gateway
Plugin URL: https://easydigitaldownloads.com/downloads/paypal-pro-express/
Description: Adds a payment gateway for PayPal Website Payments Pro and PayPal Express Gateway
Version: 1.4.5
Author: Easy Digital Downloads, LLC
Author URI: https://easydigitaldownloads.com
*/

if ( !defined( 'EPPE_PLUGIN_DIR' ) ) {
	define( 'EPPE_PLUGIN_DIR', dirname( __FILE__ ) );
}

function eppe_plugin_data( $variable ) {

	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$plugin_data = get_plugin_data( EPPE_PLUGIN_DIR . '/edd-paypal-pro-express.php' );

	return $plugin_data[ $variable ];

}

define( 'EDD_EPPE_STORE_API_URL', 'https://easydigitaldownloads.com' );
define( 'EDD_EPPE_PRODUCT_NAME', 'PayPal Pro and PayPal Express' );
define( 'EDD_EPPE_VERSION', eppe_plugin_data( 'Version' ) );

if ( class_exists( 'EDD_License' ) && is_admin() ) {
	$license = new EDD_License( __FILE__, 'PayPal Pro and PayPal Express', EDD_EPPE_VERSION, 'EDD Team', 'eppe_license_key' );
}

// Load the text domain
function eppe_load_textdomain() {

	// Set filter for plugin's languages directory
	$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'eppe' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'eppe', $locale );

	// Setup paths to current locale file
	$mofile_local  = $lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/eppe/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/edd-paypal-pro-express folder
		load_textdomain( 'eppe', $mofile_global );
	}
	elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/edd-paypal-pro-express/languages/ folder
		load_textdomain( 'eppe', $mofile_local );
	}
	else {
		// Load the default language files
		load_plugin_textdomain( 'eppe', false, $lang_dir );
	}

}
add_action( 'init', 'eppe_load_textdomain' );


// registers the gateway
function eppe_register_paypal_pro_express_gateway( $gateways ) {

	// Format: ID => Name
	$gateways['paypalpro'] = array( 'admin_label' => __( 'PayPal Pro', 'eppe' ), 'checkout_label' => __( 'Credit Card', 'eppe' ) );
	$gateways['paypalexpress'] = array( 'admin_label' => __( 'PayPal Express', 'eppe' ), 'checkout_label' => __( 'PayPal', 'eppe' ) );

	return $gateways;

}
add_filter( 'edd_payment_gateways', 'eppe_register_paypal_pro_express_gateway' );

add_action( 'edd_paypalexpress_cc_form', '__return_false' );

add_action( 'edd_paypalexpress_purchase_form_validate_cc', '__return_false' );

// processes the payment
function eppe_pro_process_payment( $purchase_data ) {

	$validate = eppe_validate_post_fields( $purchase_data['post_data'] );
	$parsed_return_query = eppe_parsed_return_query( $purchase_data['card_info'] );

	if ( $validate != true ) {
		edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] . '&' . http_build_query( $parsed_return_query ) );
	}

	global $edd_options;

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalPro.php';

	$credentials = eppe_api_credentials();

	foreach ( $credentials as $cred ) {

		if ( is_null( $cred ) ) {

			edd_set_error( 0, __( 'You must enter your API keys in settings', 'eppe' ) );
			edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] . '&' . http_build_query( $parsed_return_query ) );

		}

	}

	$paypalpro = new PayPalProGateway();

	// setup the payment details
	$payment_data = array(
		'price'        => $purchase_data['price'],
		'date'         => $purchase_data['date'],
		'user_email'   => $purchase_data['post_data']['edd_email'],
		'purchase_key' => $purchase_data['purchase_key'],
		'currency'     => edd_get_currency(),
		'downloads'    => $purchase_data['downloads'],
		'cart_details' => $purchase_data['cart_details'],
		'user_info'    => $purchase_data['user_info'],
		'status'       => 'pending'
	);

	// record this payment
	$payment = edd_insert_payment( $payment_data );

	$paypal_data = array(
		'credentials'     => array(
			'api_username'  => $credentials['api_username'],
			'api_password'  => $credentials['api_password'],
			'api_signature' => $credentials['api_signature']
		),
		'api_end_point'   => $credentials['api_end_point'],
		'card_data'       => array(
			'number'          => $purchase_data['card_info']['card_number'],
			'exp_month'       => $purchase_data['card_info']['card_exp_month'],
			'exp_year'        => $purchase_data['card_info']['card_exp_year'],
			'cvc'             => $purchase_data['card_info']['card_cvc'],
			'card_type'       => eppe_get_card_type( $purchase_data['card_info']['card_number'] ),
			'first_name'      => $purchase_data['user_info']['first_name'],
			'last_name'       => $purchase_data['user_info']['last_name'],
			'billing_address' => $purchase_data['card_info']['card_address'] . ' ' . $purchase_data['card_info']['card_address_2'],
			'billing_city'    => $purchase_data['card_info']['card_city'],
			'billing_state'   => $purchase_data['card_info']['card_state'],
			'billing_zip'     => $purchase_data['card_info']['card_zip'],
			'billing_country' => $purchase_data['card_info']['card_country'],
			'email'           => $purchase_data['post_data']['edd_email'],
		),
		'subtotal'        => $purchase_data['subtotal'],
		'discount_amount' => round( $purchase_data['discount'], 2 ),
		'fees'            => isset( $purchase_data['fees'] ) ? $purchase_data['fees'] : false,
		'tax'             => $purchase_data['tax'],
		'price'           => round( $purchase_data['price'], 2 ),
		'currency_code'   => edd_get_currency(),
		'api_end_point'   => $credentials['api_end_point'],
		'cart_details'    => $purchase_data['cart_details'],
		'discount'        => $purchase_data['user_info']['discount'],
		'payment_id'      => $payment
	);

	$paypalpro->purchase_data( $paypal_data );

	$transaction  = $paypalpro->process_sale();

	$responsecode = strtoupper( $transaction['ACK'] );

	if ( $responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING' || isset( $transaction['TRANSACTIONID'] ) ) {

		edd_insert_payment_note( $payment, 'PayPal Pro Transaction ID: ' . $transaction['TRANSACTIONID'] );
		edd_update_payment_meta( $payment, '_edd_eppe_txn_id', $transaction['TRANSACTIONID'] );

		if ( function_exists( 'edd_set_payment_transaction_id' ) ) {
			edd_set_payment_transaction_id( $payment, $transaction['TRANSACTIONID'] );
		}

		// complete the purchase
		edd_update_payment_status( $payment, 'publish' );
		edd_empty_cart();
		edd_send_to_success_page(); // this function redirects and exits itself

	}
	else {

		foreach ( $transaction as $key => $value ) {

			if ( substr( $key, 0, 11 ) == 'L_ERRORCODE' ) {

				$error_code = substr( $key, 11 );
				$value = $transaction['L_ERRORCODE' . $error_code];
				edd_set_error( $value, $transaction['L_SHORTMESSAGE' . $error_code] . ' ' . $transaction['L_LONGMESSAGE' . $error_code] );
				edd_record_gateway_error( __( 'PayPal Pro Error', 'edd' ), sprintf( __( 'PayPal Pro returned an error while processing a payment. Details: %s', 'eppe' ), json_encode( $transaction ) ), $payment );

			}

		}

		edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] . '&' . http_build_query( $parsed_return_query ) );
	}

}
add_action( 'edd_gateway_paypalpro', 'eppe_pro_process_payment' );

function eppe_exp_process_payment( $purchase_data ) {

	global $edd_options;

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalExpress.php';

	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {

		if ( is_null( $cred ) ) {

			edd_set_error( 0, __( 'You must enter your API keys in settings', 'eppe' ) );
			edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] );

		}

	}

	$paypalexpress = new PayPalExpressGateway();

	$return_url = add_query_arg( 'payment-confirmation', 'paypalexpress', edd_get_success_page_uri() );
	$cancel_url = function_exists( 'edd_get_failed_transaction_uri' ) ? edd_get_failed_transaction_uri() : home_url();

	$payment_data = array(
		'price'        => $purchase_data['price'],
		'date'         => $purchase_data['date'],
		'user_email'   => $purchase_data['user_email'],
		'purchase_key' => $purchase_data['purchase_key'],
		'currency'     => edd_get_currency(),
		'downloads'    => $purchase_data['downloads'],
		'cart_details' => $purchase_data['cart_details'],
		'user_info'    => $purchase_data['user_info'],
		'status'       => 'pending'
	);

	// record the pending payment
	$payment     = edd_insert_payment( $payment_data );

	$paypal_data = array(
		'credentials'     => array(
			'api_username'  => $credentials['api_username'],
			'api_password'  => $credentials['api_password'],
			'api_signature' => $credentials['api_signature']
		),
		'api_end_point'   => $credentials['api_end_point'],
		'urls'            => array(
			'return_url' => $return_url,
			'cancel_url' => $cancel_url
		),
		'subtotal'        => $purchase_data['subtotal'],
		'discount_amount' => round( $purchase_data['discount'], 2 ),
		'fees'            => isset( $purchase_data['fees'] ) ? $purchase_data['fees'] : false,
		'tax'             => $purchase_data['tax'],
		'price'           => round( $purchase_data['price'], 2 ),
		'currency_code'   => edd_get_currency(),
		'cart_details'    => $purchase_data['cart_details'],
		'payment_id'      => $payment,
		'first_name'      => $purchase_data['user_info']['first_name'],
		'last_name'       => $purchase_data['user_info']['last_name'],
		'address1'        => ! empty( $purchase_data['user_info']['address']['line1'] ) ? $purchase_data['user_info']['address']['line1'] : null,
		'address2'        => ! empty( $purchase_data['user_info']['address']['line2'] ) ? $purchase_data['user_info']['address']['line2'] : null,
		'city'            => ! empty( $purchase_data['user_info']['address']['city'] ) ? $purchase_data['user_info']['address']['city'] : null,
		'state'           => ! empty( $purchase_data['user_info']['address']['state'] ) ? $purchase_data['user_info']['address']['state'] : null,
		'country'         => ! empty( $purchase_data['user_info']['address']['country'] ) ? $purchase_data['user_info']['address']['country'] : null,
		'zip'             => ! empty( $purchase_data['user_info']['address']['zip'] ) ? $purchase_data['user_info']['address']['zip'] : null,
		'discount'        => $purchase_data['user_info']['discount'],
		'email'           => ! empty( $purchase_data['user_email'] ) ? $purchase_data['user_email'] : null,
	);

	$paypalexpress->purchase_data( $paypal_data );

	$token = $paypalexpress->retrieve_token();

	$responsecode = strtoupper( $token['ACK'] );

	if ( $responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING' ) {

		edd_update_payment_meta( $payment, '_edd_ppe_token', $token['TOKEN'] );

		if ( isset( $edd_options['paypal_in_context'] ) && $edd_options['paypal_in_context'] && isset( $_REQUEST['eppe_ajax'] ) ) {

			echo $token['TOKEN'];
			die;

		}

		$express_url = $credentials['express_checkout_url'] . urlencode( $token['TOKEN'] );

		wp_redirect( $express_url );
		exit;

	} else {

		// get rid of the pending purchase
		edd_update_payment_status( $payment, 'failed' );

		foreach ( $token as $key => $value ) {

			if ( substr( $key, 0, 11 ) == 'L_ERRORCODE' ) {

				$error_code = substr( $key, 11 );
				$value = $token['L_ERRORCODE' . $error_code];
				edd_set_error( $value, $token['L_SHORTMESSAGE' . $error_code] . ' ' . $token['L_LONGMESSAGE' . $error_code] );

			}

		}
		edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] );
	}

}
add_action( 'edd_gateway_paypalexpress', 'eppe_exp_process_payment' );

function eppe_exp_show_confirmation( $content ) {

	global $edd_options;

	$token    = ( isset( $_GET['token'] ) )   ? $_GET['token']   : '';
	$payer_id = ( isset( $_GET['PayerID'] ) ) ? $_GET['PayerID'] : '';

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalExpress.php';

	$paypalexpress = new PayPalExpressGateway();

	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {

		if ( is_null( $cred ) ) {

			edd_set_error( 0, __( 'You must enter your API keys in settings', 'eppe' ) );
			edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] );

		}

	}

	$paypalexpress->purchase_data( array(
		'credentials'		=> array(
			'api_username'	=> $credentials['api_username'],
			'api_password'	=> $credentials['api_password'],
			'api_signature'	=> $credentials['api_signature']
		),
		'api_end_point'		=> $credentials['api_end_point']
	) );

	$details = $paypalexpress->express_checkout_details( $token );

	if ( ! did_action('wp_head') ) {

		return $content;

	} else {

		$payment_id = $paypalexpress->get_purchase_id_by_token( $token );

		if ( edd_is_payment_complete( $payment_id ) ) {

			return $content;

		}

		// If this payment is auto confirmed, return content.
		$auto_confirm = edd_get_option( 'pp_auto_confirm', false );

		if ( $auto_confirm ) {

			return $content;

		}

		ob_start(); ?>
			<p><?php _e( 'Please confirm your payment', 'eppe' ); ?></p>
			<div id="billing_info">
				<p><strong><?php echo $details['FIRSTNAME'] ?> <?php echo $details['LASTNAME'] ?></strong><br />
				<?php _e( 'PayPal Status:', 'eppe' ); ?> <?php echo $details['PAYERSTATUS'] ?><br />
				<?php if ( isset( $details['PHONENUM'] ) ): ?>
					<?php _e( 'Phone:', 'eppe' ); ?> <?php echo $details['PHONENUM'] ?><br />
				<?php endif; ?>
				<?php _e( 'Email:', 'eppe' ); ?> <?php echo $details['EMAIL'] ?></p>
			</div>
			<table id="order_summary" class="edd-table">
				<thead>
					<tr>
						<th><?php _e( 'Item Name', 'eppe' ); ?></th>
						<th><?php _e( 'Item Price', 'eppe' ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<?php if ( ! empty( $details['TAXAMT'] ) ) { ?>
					<tr>
						<th colspan="2" class="edd_cart_tax"><?php _e( 'Tax:', 'eppe' ); ?> <span class="edd_cart_tax_amount"><?php echo edd_currency_filter( edd_format_amount( $details['TAXAMT'] ) ); ?></span></th>
					</tr>
					<?php } ?>
					<tr>
						<th colspan="2" class="edd_cart_total"><?php _e( 'Total:', 'eppe' ); ?> <span class="edd_cart_amount"><?php echo edd_currency_filter( edd_format_amount( $details['AMT'] ) ); ?></span></th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					foreach ( $details as $key => $value ) {

						if ( substr( $key, 0, 23 ) == 'L_PAYMENTREQUEST_0_NAME' ) {

							$number = substr( $key, 23 );
							echo '<tr><td>' . $details['L_PAYMENTREQUEST_0_NAME' . $number] . '</td>';
							echo '<td>' . edd_currency_filter( $details['L_PAYMENTREQUEST_0_AMT' . $number] ) . '</td></tr>';

						}

					}
					?>
				</tbody>
			</table>

			<form action="<?php echo esc_url( add_query_arg( 'token', $token, edd_get_success_page_uri() ) ); ?>" method="post" id="edd-paypal-express-confirm">
				<input type="hidden" name="edd_action" value="confirm_paypal_express" />
				<input type="hidden" name="token" value="<?php echo esc_attr( $token ); ?>" />
				<input type="hidden" name="payer_id" value="<?php echo esc_attr( $payer_id ); ?>" />
				<input type="submit" value="<?php _e( 'Confirm', 'eppe' ); ?>" />
			</form>
		<?php
		return ob_get_clean();
	}

}
add_filter( 'edd_payment_confirm_paypalexpress', 'eppe_exp_show_confirmation' );

function eppe_maybe_auto_confirm_payment() {

	if ( ! function_exists( 'edd_get_option' ) ) {
		return;
	}

	// Prepare variables.
	$auto_confirm = edd_get_option( 'pp_auto_confirm', false );
	$confirm      = isset( $_REQUEST['payment-confirmation'] ) && 'paypalexpress' == $_REQUEST['payment-confirmation'] ? true : false;
	$token        = ! empty( $_REQUEST['token'] ) ? $_REQUEST['token'] : false;
	$payer_id     = ! empty( $_REQUEST['PayerID'] ) ? $_REQUEST['PayerID'] : false;

	// If we are not confirming PP express, return.
	if ( ! $confirm ) {
		return;
	}

	// Verify on the checkout success page.
	if ( ! edd_is_success_page() ) {
		return;
	}

	// Verify we can auto confirm.
	if ( ! $auto_confirm ) {
		return;
	}

	// Make sure our variables exist.
	if ( ! $token || ! $payer_id ) {
		return;
	}

	// Auto confirm the payment.
	eppe_exp_process_confirmation( array( 'token' => $token, 'payer_id' => $payer_id ) );
}
add_action( 'template_redirect', 'eppe_maybe_auto_confirm_payment' );

function eppe_exp_process_confirmation( $data ) {

	global $edd_options;

	if ( ! function_exists( 'EDD' ) ) {
		return;
	}

	$token    = ( isset( $data['token'] ) )    ? $data['token']    : '';
	$payer_id = ( isset( $data['payer_id'] ) ) ? $data['payer_id'] : '';

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalExpress.php';

	if ( empty( $token ) ) {
		return;
	}

	$paypalexpress = new PayPalExpressGateway();

	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {
		if ( is_null( $cred ) ) {
			return;
		}
	}

	$paypalexpress->purchase_data( array(
		'credentials'  => array(
			'api_username'  => $credentials['api_username'],
			'api_password'  => $credentials['api_password'],
			'api_signature' => $credentials['api_signature']
		),
		'api_end_point' => $credentials['api_end_point']
	) );

	$details    = $paypalexpress->express_checkout_details( $token );
	$sale       = $paypalexpress->express_checkout( $token, $payer_id, $details['AMT'], $details['ITEMAMT'], $details['TAXAMT'], $details['CURRENCYCODE'] );
	$payment_id = $paypalexpress->get_purchase_id_by_token( $token );

	$payment = edd_get_payment( $payment_id );
	$txn_id  = $payment->get_meta( '_edd_eppe_txn_id', true );

	// If the payment already has a transaction ID, just redirect to the purchase confirmation.
	if ( ! empty( $txn_id ) ) {
		$redirect_url = add_query_arg( array( 'purchase_key' => $payment->key ), edd_get_success_page_uri() );
		wp_safe_redirect( $redirect_url );
		exit;
	}

	if ( is_array( $sale ) && ( trim( $sale['ACK'] ) == 'Success' ) || trim( $sale['ACK'] ) == 'SuccessWithWarning' ) {

		if ( 'instant' == $sale['PAYMENTINFO_0_PAYMENTTYPE'] ) {
			edd_update_payment_status( $payment_id, 'publish' );
		} elseif ( 'echeck' == $sale['PAYMENTINFO_0_PAYMENTTYPE'] ) {
			edd_update_payment_status( $payment_id, 'pending' );
			edd_insert_payment_note( $payment_id, 'PayPal eCheck Expected Clear Date: ' . $sale['PAYMENTINFO_n_EXPECTEDECHECKCLEARDATE'] );
		} else {
			edd_update_payment_status( $payment_id, 'pending' );
		}
		edd_insert_payment_note( $payment_id, 'PayPal Express Transaction ID: ' . $sale['PAYMENTINFO_0_TRANSACTIONID'] );
		edd_update_payment_meta( $payment_id, '_edd_eppe_payer_id', $payer_id );
		edd_update_payment_meta( $payment_id, '_edd_eppe_txn_id', $sale['PAYMENTINFO_0_TRANSACTIONID'] );

		if ( function_exists( 'edd_set_payment_transaction_id' ) ) {
			edd_set_payment_transaction_id( $payment_id, $sale['PAYMENTINFO_0_TRANSACTIONID'] );
		}

		edd_empty_cart();

	} else {
		// Something went wrong, lets redirect to a failed transaction page
		edd_update_payment_status( $payment_id, 'failed' );
		if ( empty( $sale['L_ERRORCODE0'] ) ) {
			$sale['L_ERRORCODE0'] = '';
		}
		if ( empty( $sale['L_LONGMESSAGE0'] ) ) {
			$sale['L_LONGMESSAGE0'] = __( '(No Error Provided)', 'eppe' );
		}
		edd_insert_payment_note( $payment_id, __( 'Payment failed with error: ', 'eppe' ) . $sale['L_ERRORCODE0'] . ' ' . $sale['L_LONGMESSAGE0'] );
		edd_record_gateway_error( __( 'Payment failed', 'eppe' ), sprintf( __( 'A payment failed to process: %s', 'eppe' ), json_encode( $sale ) ), $payment_id );

		$cancel_url = function_exists( 'edd_get_failed_transaction_uri' ) ? edd_get_failed_transaction_uri( '?payment_id=' . $payment_id ) : home_url();

		wp_redirect( $cancel_url );
		exit;
	}
}
add_action( 'edd_confirm_paypal_express', 'eppe_exp_process_confirmation' );


// mark a payment as failed if a user cancels from in PayPal
function eppe_failed_payment() {

	global $edd_options;

	if ( is_admin() ) {
		return;
	}

	if ( ! is_page( $edd_options['failure_page'] ) ) {
		return;
	}

	if ( ! isset( $_GET['token'] ) ) {
		return;
	}

	$token = ( isset( $_GET['token'] ) ) ? urldecode( $_GET['token'] ) : '';

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalExpress.php';

	$paypalexpress = new PayPalExpressGateway();

	$payment_id = $paypalexpress->get_purchase_id_by_token( $token );

	$status     = edd_get_payment_status( $payment_id );

	if ( $status != 'pending' ) {
		return;
	}

	edd_update_payment_status( $payment_id, 'failed' );

	if ( function_exists( 'edd_insert_payment_note' ) ) {
		edd_insert_payment_note( $payment_id, __( 'The user cancelled payment after going to PayPal', 'eppe' ) );
	}

	edd_empty_cart();

}
add_action( 'template_redirect', 'eppe_failed_payment' );


function eppe_settings_section( $sections ) {

	// Note the array key here of 'ck-settings'
	$sections['eppe_paypal_pro_express']      = __( 'PayPal Pro/Express', 'eppe' );

	return $sections;

}
add_filter( 'edd_settings_sections_gateways', 'eppe_settings_section' );

// adds the settings to the Payment Gateways section
function eppe_add_settings( $settings ) {

	$eppe_settings = array(
		array(
			'id'   => 'paypal_pro_express_settings',
			'name' => '<strong>' . __( 'PayPal Pro/Express<br>API Keys', 'eppe' ) . '</strong>',
			'desc' => __( 'Configure your PayPal Pro and PayPal Express settings', 'eppe' ),
			'type' => 'header'
		),
		array(
			'id'   => 'paypal_pro_express_description',
			'name' => '',
			'desc' => '',
			'type' => 'hook',
		),
		array(
			'id'   => 'live_paypal_api_username',
			'name' => __( 'Live API Username', 'eppe' ),
			'desc' => __( 'Enter your live API username', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'live_paypal_api_password',
			'name' => __( 'Live API Password', 'eppe' ),
			'desc' => __( 'Enter your live API password', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'live_paypal_api_signature',
			'name' => __( 'Live API Signature', 'eppe' ),
			'desc' => __( 'Enter your live API signature', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'live_paypal_merchant_id',
			'name' => __( 'Live PayPal Merchant ID', 'eppe' ),
			'desc' => __( 'Enter your Live PayPal Merchant ID - NOTE: This is only required for In-Context Checkout<br>You can find your Merchant ID in your Account Profile in PayPal', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'test_paypal_api_username',
			'name' => __( 'Test API Username', 'eppe' ),
			'desc' => __( 'Enter your test API username', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'test_paypal_api_password',
			'name' => __( 'Test API Password', 'eppe' ),
			'desc' => __( 'Enter your test API password', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'test_paypal_api_signature',
			'name' => __( 'Test API Signature', 'eppe' ),
			'desc' => __( 'Enter your test API signature', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'test_paypal_merchant_id',
			'name' => __( 'Test PayPal Merchant ID', 'eppe' ),
			'desc' => __( 'Enter your Test PayPal Merchant ID - NOTE: This is only required for In-Context Checkout<br>You can find your Merchant ID in your Account Profile in PayPal', 'eppe' ),
			'type' => 'text',
			'size' => 'regular'
		),
		array(
			'id'   => 'paypal_in_context',
			'name' => __( 'PayPal Express In-Context Checkout', 'eppe' ),
			'desc' => __( 'Enable PayPal Express In-Context Checkout', 'eppe' ),
			'type' => 'checkbox'
		),
		array(
			'id'   => 'pp_auto_confirm',
			'name' => __( 'Auto Confirm Express Payments?', 'eppe' ),
			'desc' => __( 'If checked, payments made with PayPal Express will be auto-confirmed once the user returns to your site from PayPal.', 'eppe' ),
			'type' => 'checkbox'
		),
		array(
			'id'    => 'paypal_billing_fields',
			'name'  => __( 'Billing Address Display', 'eppe' ),
			'desc'  => __( 'Select how you would like to display the billing address fields on the checkout form. <p><strong>Notes</strong>:</p><p>This option is for PayPal Pro only.<br>If taxes are enabled, this option cannot be changed from "Full address".</p>', 'eppe' ),
			'type'  => 'select',
			'options' => array(
				'full'        => __( 'Full address', 'eppe' ),
				'zip_country' => __( 'Zip / Postal Code and Country only', 'eppe' ),
				'none'        => __( 'No address fields', 'eppe' )
			),
			'std'   => 'full'
		)
	);

	// If EDD is at version 2.5 or later...
	if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
		// Use the previously noted array key as an array key again and next your settings
		$eppe_settings = array( 'eppe_paypal_pro_express' => $eppe_settings );
	}

	return array_merge( $settings, $eppe_settings );
}
add_filter( 'edd_settings_gateways', 'eppe_add_settings' );

function eppe_settings_header_description() {
	if ( ! current_user_can( 'manage_shop_settings' ) ) {
		return;
	}

	ob_start();
	?>
		<span class="description">To obtain API Keys, please read the PayPal documentation here:<br><a target="_blank" href="https://developer.paypal.com/docs/classic/api/apiCredentials/#creating-an-api-signature">https://developer.paypal.com/docs/classic/api/apiCredentials/#creating-an-api-signature</a>
	<?php echo ob_get_clean();
}
add_action( 'edd_paypal_pro_express_description', 'eppe_settings_header_description' );

function eppe_api_credentials() {
	global $edd_options;

	if ( edd_is_test_mode() ) {
		$api_username         = isset( $edd_options['test_paypal_api_username'] ) ? $edd_options['test_paypal_api_username'] : null;
		$api_password         = isset( $edd_options['test_paypal_api_password'] ) ? $edd_options['test_paypal_api_password'] : null;
		$api_signature        = isset( $edd_options['test_paypal_api_signature'] ) ? $edd_options['test_paypal_api_signature'] : null;
		$api_end_point        = 'https://api-3t.sandbox.paypal.com/nvp';
		$express_checkout_url = ! empty( $edd_options['paypal_in_context'] ) ? 'https://www.sandbox.paypal.com/checkoutnow?token=' : 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
	} else {
		$api_username         = isset( $edd_options['live_paypal_api_username'] ) ? $edd_options['live_paypal_api_username'] : null;
		$api_password         = isset( $edd_options['live_paypal_api_password'] ) ? $edd_options['live_paypal_api_password'] : null;
		$api_signature        = isset( $edd_options['live_paypal_api_signature'] ) ? $edd_options['live_paypal_api_signature'] : null;
		$api_end_point        = 'https://api-3t.paypal.com/nvp';
		$express_checkout_url = ! empty( $edd_options['paypal_in_context'] ) ? 'https://www.paypal.com/checkoutnow?token=' : 'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
	}
	$data = array(
		'api_username'        => $api_username,
		'api_password'        => $api_password,
		'api_signature'       => $api_signature,
		'api_end_point'       => $api_end_point,
		'express_checkout_url'=> $express_checkout_url,
	);
	return $data;
}
function eppe_parsed_return_query( $post_data ) {
	$post_data = array(
		'billing_address'   => $post_data['card_address'],
		'billing_address_2' => $post_data['card_address_2'],
		'billing_city'      => $post_data['card_city'],
		'billing_country'   => $post_data['card_country'],
		'billing_zip'       => $post_data['card_zip'],
		'card_cvc'          => $post_data['card_cvc'],
		'card_exp_month'    => $post_data['card_exp_month'],
		'card_exp_year'     => $post_data['card_exp_year'],
	);
	$post_data = array_filter( $post_data );
	return $post_data;
}
function eppe_validate_post_fields( $purchase_data ) {
	$validate = true;
	$number = 0;

	foreach ( $purchase_data as $k => $v ) {
		if ( $v == '' ) {
			switch ( $k ) {
				case 'card_address':
					$k = __( 'Billing Address', 'eppe' );
					break;
				case 'card_city':
					$k = __( 'Billing City', 'eppe' );
					break;
				case 'card_zip':
					$k = __( 'Billing Zip', 'eppe' );
					break;
				case 'card_number':
					$k = __( 'Credit Card Number', 'eppe' );
					break;
				case 'card_cvc':
					$k = __( 'CVC Code', 'eppe' );
					break;
				case 'card_exp_month':
					$k = __( 'Credit Card Expiration Month', 'eppe' );
					break;
				case 'card_exp_year':
					$k = __( 'Credit Card Expiration Year', 'eppe' );
					break;
				default:
					$k = false;
					break;
			}

			if ( $k != false ) {
				edd_set_error( $number, __( "Invalid $k", 'eppe' ) );
				$validate = false;

				$number++;
			}
		}
	}
	return $validate;
}

function eppe_get_card_type( $card_number ) {
	/*
	* mastercard: Must have a prefix of 51 to 55, and must be 16 digits in length.
	* Visa: Must have a prefix of 4, and must be either 13 or 16 digits in length.
	* American Express: Must have a prefix of 34 or 37, and must be 15 digits in length.
	* Discover: Must have a prefix of 6011, and must be 16 digits in length.
	*/
	if ( preg_match( "/^5[1-5][0-9]{14}$/", $card_number ) ) {
		return "mastercard";
	}

	if ( preg_match( "/^4[0-9]{12}([0-9]{3})?$/", $card_number ) ) {
		return "visa";
	}

	if ( preg_match( "/^3[47][0-9]{13}$/", $card_number ) ) {
		return "amex";
	}

	if ( preg_match( "/^6011[0-9]{12}$/", $card_number ) ) {
		return "discover";
	}
}

/**
 * Given a Payment ID, extract the transaction ID
 *
 * @param  string $payment_id       Payment ID
 * @return string                   Transaction ID
 */
function eppe_express_get_payment_transaction_id( $payment_id ) {

	$notes = edd_get_payment_notes( $payment_id );
	$transaction_id = null;

	foreach ( $notes as $note ) {

		if ( preg_match( '/^PayPal Express Transaction ID: ([^\s]+)/', $note->comment_content, $match ) ) {

			$transaction_id = $match[1];
			continue;

		}

	}

	return apply_filters( 'eppe_get_paypalexpress_transaction_id', $transaction_id, $payment_id );
}
add_filter( 'edd_get_payment_transaction_id-paypalexpress', 'eppe_express_get_payment_transaction_id', 10, 1 );

/**
 * Given a Payment ID, extract the transaction ID
 *
 * @param  string $payment_id       Payment ID
 * @return string                   Transaction ID
 */
function eppe_pro_get_payment_transaction_id( $payment_id ) {

	$notes = edd_get_payment_notes( $payment_id );
	$transaction_id = null;

	foreach ( $notes as $note ) {

		if ( preg_match( '/^PayPal Pro Transaction ID: ([^\s]+)/', $note->comment_content, $match ) ) {

			$transaction_id = $match[1];
			continue;

		}

	}

	return apply_filters( 'eppe_get_paypalpro_transaction_id', $transaction_id, $payment_id );
}
add_filter( 'edd_get_payment_transaction_id-paypalpro', 'eppe_pro_get_payment_transaction_id', 10, 1 );

function eppe_admin_messages() {
	global $typenow;

	if ( 'download' != $typenow ) {
		return;
	}

	$edd_access_level = current_user_can('manage_shop_settings');

	if ( isset( $_GET['eppe-message'] ) && $_GET['eppe-message'] == 'refund_failed' && current_user_can( $edd_access_level ) ) {
		add_settings_error( 'eppe-notices', 'eppe-cancellation-failed', __( 'Refund failed. Please see the gateway log for more information.', 'eppe' ), 'error' );
	}

	if ( isset( $_GET['eppe-message'] ) && $_GET['eppe-message'] == 'refund_processed' && current_user_can( $edd_access_level ) ) {
		add_settings_error( 'eppe-notices', 'eppe-cancellation-processed', __( 'Refund processed successfully.', 'eppe' ), 'updated' );
	}

	if ( isset( $_GET['eppe-message'] ) && $_GET['eppe-message'] == 'bad_credentials' && current_user_can( $edd_access_level ) ) {
		add_settings_error( 'eppe-notices', 'eppe-missing-credentials', __( 'API Credentials are required in order to process a refund. Please visit the gateway settings page to add the correct credentials.', 'eppe' ), 'updated' );
	}

	settings_errors( 'eppe-notices' );
}
add_action( 'admin_notices', 'eppe_admin_messages' );

// listens for a IPN request and then processes the order information
function eppe_listen_for_ipn() {
	// IPN is only kept in case a user does not return to the site and trigger the updates.
	if ( isset( $_GET['ipn'] ) && $_GET['ipn'] == 'eppe' ) {
		// Check the request method is POST
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
			return;
		}

		// Set initial post data to empty string
		$post_data = '';
		// Fallback just in case post_max_size is lower than needed
		if ( ini_get( 'allow_url_fopen' ) ) {
			$post_data = file_get_contents( 'php://input' );
		} else {
			// If allow_url_fopen is not enabled, then make sure that post_max_size is large enough
			ini_set( 'post_max_size', '12M' );
		}
		// Start the encoded data collection with notification command
		$encoded_data = 'cmd=_notify-validate';
		// Get current arg separator
		$arg_separator = edd_get_php_arg_separator_output();
		// Verify there is a post_data
		if ( $post_data || strlen( $post_data ) > 0 ) {
			// Append the data
			$encoded_data .= $arg_separator . $post_data;
		} else {
			// Check if POST is empty
			if ( empty( $_POST ) ) {
				// Nothing to do
				return;
			} else {
				// Loop through each POST
				foreach ( $_POST as $key => $value ) {
					// Encode the value and append the data
					$encoded_data .= $arg_separator . "$key=" . urlencode( $value );
				}
			}
		}

		// Convert collected post data to an array
		parse_str( $encoded_data, $encoded_data_array );
		foreach ( $encoded_data_array as $key => $value ) {
			if ( false !== strpos( $key, 'amp;' ) ) {
				$new_key = str_replace( '&amp;', '&', $key );
				$new_key = str_replace( 'amp;', '&', $new_key );

				unset( $encoded_data_array[ $key ] );
				$encoded_data_array[ $new_key ] = $value;
			}
		}
		if ( ! edd_get_option( 'disable_paypal_verification' ) ) {
			// Validate the IPN
			$remote_post_vars = array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(
					'host'         => 'www.paypal.com',
					'connection'   => 'close',
					'content-type' => 'application/x-www-form-urlencoded',
					'post'         => '/cgi-bin/webscr HTTP/1.1',
					'user-agent'   => 'EDD IPN Verification/' . EDD_VERSION . '; ' . get_bloginfo( 'url' )

				),
				'sslverify'   => false,
				'body'        => $encoded_data_array
			);

			// Get response
			$api_response = wp_remote_post( edd_get_paypal_redirect(), $remote_post_vars );
			if ( is_wp_error( $api_response ) ) {
				edd_record_gateway_error( __( 'IPN Error', 'eppe' ), sprintf( __( 'Invalid IPN verification response. IPN data: %s', 'eppe' ), json_encode( $api_response ) ) );
				return; // Something went wrong
			}

			if ( wp_remote_retrieve_body( $api_response ) !== 'VERIFIED' && edd_get_option( 'disable_paypal_verification', false ) ) {
				edd_record_gateway_error( __( 'IPN Error', 'eppe' ), sprintf( __( 'Invalid IPN verification response. IPN data: %s', 'eppe' ), json_encode( $api_response ) ) );
				return; // Response not okay
			}
		}

		// Check if $post_data_array has been populated
		if ( ! is_array( $encoded_data_array ) && ! empty( $encoded_data_array ) ) {
			return;
		}

		$defaults = array(
			'txn_type'       => '',
			'payment_status' => ''
		);

		$encoded_data_array = wp_parse_args( $encoded_data_array, $defaults );

		$payment_id = 0;

		if ( ! empty( $encoded_data_array[ 'parent_txn_id' ] ) ) {
			$payment_id = edd_get_purchase_id_by_transaction_id( $encoded_data_array[ 'parent_txn_id' ] );
		} elseif ( ! empty( $encoded_data_array[ 'txn_id' ] ) ) {
			$payment_id = edd_get_purchase_id_by_transaction_id( $encoded_data_array[ 'txn_id' ] );
		}

		if ( empty( $payment_id ) ) {
			$payment_id = ! empty( $encoded_data_array[ 'custom' ] ) ? absint( $encoded_data_array[ 'custom' ] ) : 0;
		}

		if ( empty( $payment_id ) ) {
			return;
		}

		$payment = new EDD_Payment( $payment_id );

		// Collect payment details
		$purchase_key   = isset( $data['invoice'] ) ? $data['invoice'] : $data['item_number'];
		$paypal_amount  = $data['mc_gross'];
		$payment_status = strtolower( $data['payment_status'] );

		if ( $payment->gateway != 'paypalexpress' ) {
			return; // this isn't a PayPal Express IPN
		}

		if ( 'completed' == $payment_status || edd_is_test_mode() ) {
			edd_insert_payment_note( $payment_id, sprintf( __( 'PayPal Transaction ID: %s', 'eppe' ) , $data['txn_id'] ) );
			edd_set_payment_transaction_id( $payment_id, $data['txn_id'] );
			edd_update_payment_status( $payment_id, 'publish' );
		} else if ( 'refunded' == $payment_status || 'reversed' == $payment_status ) {
			if ( ! edd_get_payment_meta( $payment_id, '_edd_eppe_full_refund', true ) && edd_get_payment_status( $payment_id ) != 'refunded' ) {
				edd_update_payment_meta( $payment_id, '_edd_eppe_full_refund', true );
				edd_insert_payment_note( $payment_id, sprintf( __( 'PayPal Refund Transaction ID: %s', 'eppe' ) , $_POST['txn_id'] ) );
				edd_update_payment_status( $payment_id, 'refunded' );

				$gateway = edd_get_payment_gateway( $payment_id );

				if ( $gateway == 'paypalexpress' ) {
					edd_update_payment_meta( $payment_id, '_edd_paypalexpress_refunded', true );
				}
				elseif ( $gateway == 'paypalpro' ) {
					edd_update_payment_meta( $payment_id, '_edd_paypalpro_refunded', true );
				}
			}
		} else if ( 'pending' == $payment_status && isset( $data['pending_reason'] ) ) {
			// Look for possible pending reasons, such as an echeck
			$note = '';
			switch( strtolower( $data['pending_reason'] ) ) {
				case 'echeck' :
					$note = __( 'Payment made via eCheck and will clear automatically in 5-8 days', 'eppe' );
					$payment->status = 'processing';
					$payment->save();
					break;
				case 'address' :
					$note = __( 'Payment requires a confirmed customer address and must be accepted manually through PayPal', 'eppe' );
					break;
				case 'intl' :
					$note = __( 'Payment must be accepted manually through PayPal due to international account regulations', 'eppe' );
					break;
				case 'multi-currency' :
					$note = __( 'Payment received in non-shop currency and must be accepted manually through PayPal', 'eppe' );
					break;
				case 'paymentreview' :
				case 'regulatory_review' :
					$note = __( 'Payment is being reviewed by PayPal staff as high-risk or in possible violation of government regulations', 'eppe' );
					break;
				case 'unilateral' :
					$note = __( 'Payment was sent to non-confirmed or non-registered email address.', 'eppe' );
					break;
				case 'upgrade' :
					$note = __( 'PayPal account must be upgraded before this payment can be accepted', 'eppe' );
					break;
				case 'verify' :
					$note = __( 'PayPal account is not verified. Verify account in order to accept this payment', 'eppe' );
					break;
				case 'other' :
					$note = __( 'Payment is pending for unknown reasons. Contact PayPal support for assistance', 'eppe' );
					break;
			}

			if ( ! empty( $note ) ) {
				edd_insert_payment_note( $payment_id, $note );
			}
		}
		return true;
	}
}
add_action( 'init', 'eppe_listen_for_ipn' );

/**
 *
 * Properly add the `async` attribute to the in-context script.
* @param $tag
* @param $handle
 *
 * @return mixed
 */
function eppe_add_async_attribute( $tag, $handle ){
    if ( 'eppe-in-context' !== $handle ) {
        return $tag;
    }

    return str_replace( ' src', ' async="async" src', $tag );
}
add_filter( 'script_loader_tag', 'eppe_add_async_attribute', 10, 2 );

function eppe_after_purchase_form() {
	global $edd_options;
	if ( ! empty( $edd_options['paypal_in_context'] ) && ! empty( $edd_options['gateways']['paypalexpress'] ) ) {
		$merchant_id = edd_is_test_mode() ? trim( $edd_options['test_paypal_merchant_id'] ) : trim( $edd_options['live_paypal_merchant_id'] );
		$environment = edd_is_test_mode() ? "sandbox" : "production";
		wp_enqueue_script( 'eppe-in-context', '//www.paypalobjects.com/api/checkout.js', array( 'edd-ajax', 'jquery' ), null );
		wp_add_inline_script(
			'eppe-in-context',
			"
			jQuery(document).ready(function($) {
				if ( !$('select#edd-gateway, input.edd-gateway').length && parseFloat( $('.edd_cart_total .edd_cart_amount').data('total') ) > 0 ) {
					inContextSetup( 'setup' );
				}
				if ( edd_scripts.is_checkout == '1' && $('select#edd-gateway, input.edd-gateway').length && parseFloat( $('.edd_cart_total .edd_cart_amount').data('total') ) > 0 ) {
					if ( $('select#edd-gateway, input.edd-gateway').val() == 'paypalexpress' ) {
						setTimeout( function() {
							inContextSetup( 'reset' );
						}, 1500);
					}
				}
				$('select#edd-gateway, input.edd-gateway').change( function (e) {
					if ( $(this).val() == 'paypalexpress' ) {
						setTimeout( function() {
							inContextSetup( 'reset' );
						}, 1500);
					}
				});
				function inContextSetup( method ) {
					if ( ! $('#edd-purchase-button').length ) {
						setTimeout( function() {
							inContextSetup( method );
						}, 500);
						return;
					}
					var options = {
						buttons: ['edd-purchase-button'],
						environment: '{$environment}',
						condition: function () {
							var valid = true;
							if ($('#edd-email').val() == '') {
								valid = false;
							}
							$('#edd_purchase_form input.required').each(function() {
								if($(this).val() == '') {
									valid = false;
								}
							});

							if($('#edd_agree_to_terms').length) {
								if (!$('#edd_agree_to_terms').is(':checked')) {
									valid = false;
								}
							}
							return valid;
						}
					};
					if ( method == 'setup' ) {
						window.paypalCheckoutReady = function () {
							paypal.checkout.setup( '{$merchant_id}', options );
						}
					}
					else if ( method == 'reset') {
						paypal.checkout.setup( '{$merchant_id}', options );
					}
				}
			});
			"
		);
	}
}
add_action( 'wp_enqueue_scripts', 'eppe_after_purchase_form' );

function eppe_pro_checkout_error_checks( $valid_data, $_post_data ) {
	if ( $valid_data['gateway'] == 'paypalpro' ) {
		$card_data = edd_get_purchase_cc_info();
		$display   = edd_get_option( 'paypal_billing_fields', 'full' );

		// use edd_set_error( $error_id, $error_message ) to set errors
		foreach ( $card_data as $key => $value ) {
			if ( $key == 'card_address_2' || $key == 'card_number' ) {
				continue;
			}

			if ( empty( $value ) ) {
				$skip = false;
				switch( $key ) {
					case 'card_address':
					case 'card_city':
						if ( 'full' !== $display ) {
							continue 2;
						}
						$field = __( 'Billing ', 'eppe' ) . $key;
						break;
					case 'card_country':
						if ( 'full' !== $display || 'zip_country' !== $display ) {
							continue 2;
						}
						$field = __( 'Billing ', 'eppe' ) . $key;
						break;
					case 'card_zip':
						if ( 'full' !== $display || 'zip_country' !== $display ) {
							continue 2;
						}
						$field = __( 'Billing ', 'eppe' ) . $key . __( ' / Postal Code', 'eppe' );
						break;
					case 'card_state':
						if ( 'full' !== $display ) {
							continue 2;
						}
						$field = __( 'Billing ', 'eppe' ) . $key . __( ' / Province', 'eppe' );
						break;
					case 'card_cvc':
						$field = __( 'CVC', 'eppe' );
						$skip = true;
						break;
					case 'card_name':
						$field = __( 'Name on the Card', 'eppe' );
						$skip = true;
						break;
					default:
						$field = $key;
						break;
				}

				$field = str_replace( 'card_', '', $field );
				$field = str_replace( '_', '', $field );
				$field = $skip ? $field : ucwords( $field );
				edd_set_error( $key, $field . __( ' is required.', 'eppe' ) );
			}
		}

		// Validate the card number
		$card_type = edd_detect_cc_type( $card_data['card_number'] );
		$valid = empty( $card_data['card_number'] ) ? false : true;
		$valid &= edd_validate_card_number_format( $card_data['card_number'] );

		if ( ! apply_filters( 'edd_purchase_form_valid_cc', $valid, $card_type ) ) {
			edd_set_error( 'invalid_cc_number', __( 'The credit card number you entered is invalid', 'edd' ) );
		}

		// Validate the card expiration date
		if ( ! edd_purchase_form_validate_cc_exp_date( $card_data['card_exp_month'], $card_data['card_exp_year'] ) ) {
			edd_set_error( 'ivalid_cc_exp_date', __( 'Please enter a valid expiration date', 'edd' ) );
		}
	}
}
add_action( 'edd_checkout_error_checks', 'eppe_pro_checkout_error_checks', 10, 2 );

/**
 * Given a transaction ID, generate a link to the PayPal transaction ID details
 *
 * @since  1.4
 * @param  string $transaction_id The Transaction ID
 * @param  int    $payment_id     The payment ID for this transaction
 * @return string                 A link to the PayPal transaction details
 */
function eppe_paypalexpress_link_transaction_id( $transaction_id, $payment_id ) {
	$base_url = edd_is_test_mode() ? 'sandbox' : 'history';
	$paypal_base_url = 'https://' . $base_url . '.paypal.com/cgi-bin/webscr?cmd=_history-details-from-hub&id=';
	$transaction_url = '<a href="' . esc_url( $paypal_base_url . $transaction_id ) . '" target="_blank">' . $transaction_id . '</a>';

	return apply_filters( 'eppe_paypalexpress_link_payment_details_transaction_id', $transaction_url );
}
add_filter( 'edd_payment_details_transaction_id-paypalexpress', 'eppe_paypalexpress_link_transaction_id', 10, 2 );

/**
 * Given a transaction ID, generate a link to the PayPal transaction ID details
 *
 * @since  1.4
 * @param  string $transaction_id The Transaction ID
 * @param  int    $payment_id     The payment ID for this transaction
 * @return string                 A link to the PayPal transaction details
 */
function eppe_paypalpro_link_transaction_id( $transaction_id, $payment_id ) {
	$base_url = edd_is_test_mode() ? 'sandbox' : 'history';
	$paypal_base_url = 'https://' . $base_url . '.paypal.com/cgi-bin/webscr?cmd=_history-details-from-hub&id=';
	$transaction_url = '<a href="' . esc_url( $paypal_base_url . $transaction_id ) . '" target="_blank">' . $transaction_id . '</a>';

	return apply_filters( 'eppe_paypalpro_link_payment_details_transaction_id', $transaction_url );
}
add_filter( 'edd_payment_details_transaction_id-paypalpro', 'eppe_paypalpro_link_transaction_id', 10, 2 );

/**
 * Shows checkbox to automatically refund payments made with PayPal Express.
 *
 * @access public
 * @since  1.4.1
 *
 * @param int $payment_id The current payment ID.
 * @return void
 */
function eppe_paypal_refund_admin_js( $payment_id = 0 ) {
	// If not the proper gateway, return early.
	$gateway = edd_get_payment_gateway( $payment_id );
	if (  $gateway !== 'paypalexpress' && $gateway !== 'paypalpro' ) {
		return;
	}

	// If our credentials are not set, return early.
	// Set PayPal API key credentials.
	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {
		if ( is_null( $cred ) ) {
			// Missing credentials so lets not allow a refund
			return;
		}
	}

	// Localize the refund checkbox label.
	$label = __( 'Refund Payment in PayPal', 'eppe' );
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('select[name=edd-payment-status]').change(function() {
				if ( 'refunded' == $(this).val() ) {
					$('#edd-paypal-refund').remove();
					$('label[for="edd-paypal-refund"]').remove();
					$(this).parent().parent().append('<input type="checkbox" id="edd-paypal-refund" name="edd-paypal-refund" value="1" style="margin-top:0">');
					$(this).parent().parent().append('<label for="edd-paypal-refund"><?php echo $label; ?><br></label>');
				} else {
					$('#edd-paypal-refund').remove();
					$('label[for="edd-paypal-refund"]').remove();
				}
			});
		});
	</script>
	<?php
}
add_action( 'edd_view_order_details_before', 'eppe_paypal_refund_admin_js', 100 );


/**
 * Possibly refunds a payment made with PayPal Express.
 *
 * @access public
 * @since  1.4.1
 *
 * @param int $payment_id The current payment ID.
 * @return void
 */
function eppe_maybe_refund_paypal_purchase( $payment_id = 0 ) {
	// Prepare variables.
	$payment_id = absint( $payment_id );
	$status     = isset( $_POST['edd-payment-status'] ) ? stripslashes( strip_tags( $_POST['edd-payment-status'] ) ) : false;
	$refund     = isset( $_POST['edd-paypal-refund'] ) ? stripslashes( strip_tags( $_POST['edd-paypal-refund'] ) ) : false;
	$user_id    = edd_get_payment_user_id( $payment_id );
	$gateway    = edd_get_payment_gateway( $payment_id );
	$old_refund = edd_get_payment_meta( $payment_id, '_edd_eppe_full_refund', true );

	// If not status is found, return early.
	if ( ! $status ) {
		return;
	}

	// If the status is not set to "refunded", return early.
	if ( 'refunded' !== $status ) {
		return;
	}

	// If the refund box wasn't checked, return false.
	if ( ! $refund ) {
		return;
	}

	// If not PayPal Express or PayPal Pro, return early.
	if ( 'paypalexpress' !== $gateway && 'paypalpro' !== $gateway ) {
		return;
	}

	switch( $gateway ) {
		case 'paypalexpress':
			$processed  = edd_get_payment_meta( $payment_id, '_edd_paypalexpress_refunded', true );
			// If the payment has already been refunded in the past, return early.
			if ( $processed || $old_refund ) {
				return;
			}
			// Process the refund in PayPal.
			eppe_refund_paypalexpress_purchase( $payment_id );
			break;
		case 'paypalpro':
			$processed  = edd_get_payment_meta( $payment_id, '_edd_paypalpro_refunded', true );
			// If the payment has already been refunded in the past, return early.
			if ( $processed || $old_refund ) {
				return;
			}
			// Process the refund in PayPal.
			eppe_refund_paypalpro_purchase( $payment_id );
			break;
	}
}
add_action( 'edd_updated_edited_purchase', 'eppe_maybe_refund_paypal_purchase', 999 );

/**
 * Refunds a purchase made via PayPal Express.
 *
 * @access public
 * @since  1.4.1
 *
 * @param int $payment_id The current payment ID.
 * @return void
 */
function eppe_refund_paypalexpress_purchase( $payment_id = 0 ) {
	// Verify the payment ID is a valid integer.
	$payment_id = absint( $payment_id );
	if ( ! $payment_id ) {
		echo '<pre>' . var_export( __( 'Payment could not be refunded because the payment ID was invalid.', 'eppe' ), true ) . '</pre>';
		die;
	}

	// Grab the transaction ID for the payment. Try notes first since transaction IDs weren't stored in transaction ID field originally.
	$transaction_id = eppe_express_get_payment_transaction_id( $payment_id );
	// If we cannot grab the PayPal Express Transaction ID from comment notes, try from the transaction ID instead.
	if ( ! $transaction_id ) {
		$transaction_id = edd_get_payment_transaction_id( $payment_id );
		if ( ! $transaction_id ) {
			echo '<pre>' . var_export( __( 'There was an issue grabbing the transaction ID for the PayPal payment. This payment should be refunded from the PayPal website.', 'eppe' ), true ) . '</pre>';
			die;
		}
	}

	// Set PayPal API key credentials.
	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {
		if ( is_null( $cred ) ) {
			echo '<pre>' . var_export( __( 'API Credentials are required in order to process a refund. Please visit the gateway settings page to add the correct credentials.', 'eppe' ), true ) . '</pre>';
			die;
		}
	}

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalExpress.php';

	$paypalexpress = new PayPalExpressGateway();

	$paypalexpress->purchase_data( array(
		'credentials'		=> array(
			'api_username'	=> $credentials['api_username'],
			'api_password'	=> $credentials['api_password'],
			'api_signature'	=> $credentials['api_signature']
		),
		'api_end_point'		=> $credentials['api_end_point']
	) );

	$refund = $paypalexpress->refund_transaction( $transaction_id, 'full', edd_get_payment_amount( $payment_id ), edd_get_payment_currency_code( $payment_id ), 'Refund ' . $payment_id );
	if ( $refund ) {
		$responsecode = strtoupper( $refund['ACK'] );
		if ( ( $responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING' ) ) {
			// Insert a payment note with the refund ID and set our meta field so we don't accidentally try to refund again in the future.
			edd_insert_payment_note( $payment_id, 'PayPal Express Refund Transaction ID: ' . $refund['REFUNDTRANSACTIONID'] );
			edd_update_payment_meta( $payment_id, '_edd_paypalexpress_refunded', true );

			// Run hook letting people know the payment has been refunded successfully.
			do_action( 'eppe_refund_paypalexpress_purchase', $payment_id );
		}
		else {
			edd_record_gateway_error( __( 'Refund Failed', 'eppe' ), sprintf( __( 'A refund failed to process: %s', 'eppe' ), json_encode( $refund ) ), $payment_id );
			echo '<pre>' . var_export( sprintf( __( '%s. This payment needs to be managed from the PayPal website directly.', 'eppe' ), $parsed_response['L_LONGMESSAGE0'] ), true ) . '</pre>';
			die;
		}
	}
	else {
		// If the request failed, return early with the notice.
		echo '<pre>' . var_export( sprintf( __( 'The refund request to PayPal failed: %s. This payment needs to be managed from the PayPal website directly.', 'eppe' ), $response ), true ) . '</pre>';
		die;
	}
}

/**
 * Refunds a purchase made via PayPal Pro.
 *
 * @access public
 * @since  1.4.1
 *
 * @param int $payment_id The current payment ID.
 * @return void
 */
function eppe_refund_paypalpro_purchase( $payment_id = 0 ) {
	// Verify the payment ID is a valid integer.
	$payment_id = absint( $payment_id );
	if ( ! $payment_id ) {
		echo '<pre>' . var_export( __( 'Payment could not be refunded because the payment ID was invalid.', 'eppe' ), true ) . '</pre>';
		die;
	}

	// Grab the transaction ID for the payment. Try notes first since transaction IDs weren't stored in transaction ID field originally.
	$transaction_id = eppe_pro_get_payment_transaction_id( $payment_id );
	// If we cannot grab the PayPal Pro Transaction ID from comment notes, try from the transaction ID instead.
	if ( ! $transaction_id ) {
		$transaction_id = edd_get_payment_transaction_id( $payment_id );
		if ( ! $transaction_id ) {
			echo '<pre>' . var_export( __( 'There was an issue grabbing the transaction ID for the PayPal payment. This payment should be refunded from the PayPal website.', 'eppe' ), true ) . '</pre>';
			die;
		}
	}

	// Set PayPal API key credentials.
	$credentials = eppe_api_credentials();
	foreach ( $credentials as $cred ) {
		if ( is_null( $cred ) ) {
			echo '<pre>' . var_export( __( 'API Credentials are required in order to process a refund. Please visit the gateway settings page to add the correct credentials.', 'eppe' ), true ) . '</pre>';
			die;
		}
	}

	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalFunctions.php';
	require_once EPPE_PLUGIN_DIR . '/paypal/PayPalPro.php';

	$paypalpro = new PayPalProGateway();

	$paypalpro->purchase_data( array(
		'credentials'		=> array(
			'api_username'	=> $credentials['api_username'],
			'api_password'	=> $credentials['api_password'],
			'api_signature'	=> $credentials['api_signature']
		),
		'api_end_point'		=> $credentials['api_end_point']
	) );

	$refund = $paypalpro->refund_transaction( $transaction_id, 'full', edd_get_payment_amount( $payment_id ), edd_get_payment_currency_code( $payment_id ), 'Refund ' . $payment_id );
	if ( $refund ) {
		$responsecode = strtoupper( $refund['ACK'] );
		if ( ( $responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING' ) ) {
			// Insert a payment note with the refund ID and set our meta field so we don't accidentally try to refund again in the future.
			edd_insert_payment_note( $payment_id, 'PayPal Pro Refund Transaction ID: ' . $refund['REFUNDTRANSACTIONID'] );
			edd_update_payment_meta( $payment_id, '_edd_paypalpro_refunded', true );

			// Run hook letting people know the payment has been refunded successfully.
			do_action( 'eppe_refund_paypalpro_purchase', $payment_id );
		}
		else {
			edd_record_gateway_error( __( 'Refund Failed', 'eppe' ), sprintf( __( 'A refund failed to process: %s', 'eppe' ), json_encode( $refund ) ), $payment_id );
			echo '<pre>' . var_export( sprintf( __( '%s. This payment needs to be managed from the PayPal website directly.', 'eppe' ), $parsed_response['L_LONGMESSAGE0'] ), true ) . '</pre>';
			die;
		}
	}
	else {
		// If the request failed, return early with the notice.
		echo '<pre>' . var_export( sprintf( __( 'The refund request to PayPal failed: %s. This payment needs to be managed from the PayPal website directly.', 'eppe' ), $response ), true ) . '</pre>';
		die;

	}
}

function eppe_sanitize_paypal_billing_fields_save( $value, $key ) {
	if ( 'paypal_billing_fields' == $key && edd_use_taxes() ) {
		$value = 'full';
	}
	return $value;

}
add_filter( 'edd_settings_sanitize_select', 'eppe_sanitize_paypal_billing_fields_save', 10, 2 );

function eppe_setup_billing_address_fields() {
	if ( ! function_exists( 'edd_use_taxes' ) ) {
		return;
	}

	if ( edd_use_taxes() || 'paypalpro' !== edd_get_chosen_gateway() || ! edd_get_cart_total() > 0 ) {
		return;
	}

	$display = edd_get_option( 'paypal_billing_fields', 'full' );

	switch( $display ) {
		case 'full' :
			// Make address fields required
			add_filter( 'edd_require_billing_address', '__return_true' );
			break;
		case 'zip_country' :
			remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields', 10 );
			add_action( 'edd_after_cc_fields', 'eppe_zip_and_country', 9 );
			break;
		case 'none' :
			remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields', 10 );
			break;
	}
}
add_action( 'init', 'eppe_setup_billing_address_fields', 9 );

function eppe_zip_and_country() {
	$logged_in = is_user_logged_in();
	$customer  = EDD()->session->get( 'customer' );
	$customer  = wp_parse_args( $customer, array( 'address' => array(
		'line1'   => '',
		'line2'   => '',
		'city'    => '',
		'zip'     => '',
		'state'   => '',
		'country' => ''
	) ) );

	$customer['address'] = array_map( 'sanitize_text_field', $customer['address'] );

	if ( $logged_in ) {
		$user_address = get_user_meta( get_current_user_id(), '_edd_user_address', true );
		foreach ( $customer['address'] as $key => $field ) {
			if ( empty( $field ) && ! empty( $user_address[ $key ] ) ) {
				$customer['address'][ $key ] = $user_address[ $key ];
			} else {
				$customer['address'][ $key ] = '';
			}

		}
	}
?>
	<fieldset id="edd_cc_address" class="cc-address">
		<legend><?php _e( 'Billing Details', 'eppe' ); ?></legend>
		<p id="edd-card-country-wrap">
			<label for="billing_country" class="edd-label">
				<?php _e( 'Billing Country', 'eppe' ); ?>
				<?php if ( edd_field_is_required( 'billing_country' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<span class="edd-description"><?php _e( 'The country for your billing address.', 'eppe' ); ?></span>
			<select name="billing_country" id="billing_country" class="billing_country edd-select<?php if ( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>"<?php if ( edd_field_is_required( 'billing_country' ) ) {  echo ' required '; } ?>>
				<?php

				$selected_country = edd_get_shop_country();

				if ( ! empty( $customer['address']['country'] ) && '*' !== $customer['address']['country'] ) {
					$selected_country = $customer['address']['country'];
				}

				$countries = edd_get_country_list();
				foreach( $countries as $country_code => $country ) {
					echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
				}
				?>
			</select>
		</p>
		<p id="edd-card-zip-wrap">
			<label for="card_zip" class="edd-label">
				<?php _e( 'Billing Zip / Postal Code', 'eppe' ); ?>
				<?php if ( edd_field_is_required( 'card_zip' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<span class="edd-description"><?php _e( 'The zip or postal code for your billing address.', 'eppe' ); ?></span>
			<input type="text" size="4" name="card_zip" class="card-zip edd-input<?php if ( edd_field_is_required( 'card_zip' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Zip / Postal Code', 'eppe' ); ?>" value="<?php echo $customer['address']['zip']; ?>"<?php if ( edd_field_is_required( 'card_zip' ) ) {  echo ' required '; } ?>/>
		</p>
	</fieldset>
<?php
}
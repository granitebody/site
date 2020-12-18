<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class EDDEET_Compatibility.
 *
 * Compatibility class, adds compatibility to the plugin for specific plugins.
 *
 * @class		EDDEET_Compatibility
 * @version		1.0.2
 * @package		EDD Enhanced eCommerce Tracking
 * @author		Jeroen Sormani
 */
class EDDEET_Compatibility {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Yoast Google Analytics
		if ( is_plugin_active( 'google-analytics-for-wordpress/googleanalytics.php' ) || is_plugin_active( 'google-analytics-premium/googleanalytics-premium.php' ) ) {
			add_action( 'init', array( $this, 'monster_insights_ga_compatibility' ), 5 );
		}

		// EDD Recurring
		add_action( 'edd_recurring_record_payment', array( $this, 'trigger_transaction_for_recurring' ), 10, 4 );
	}


	/**
	 * Yoast GA compatibility.
	 *
	 * Add actions to make the Yoast GA plugin compatible.
	 *
	 * @since 1.0.2
	 */
	public function monster_insights_ga_compatibility() {

		// Yoast GA compatibility
		if ( edd_get_option( 'eddeet_implementation_method' ) == 'measurement-protocol' ) {
			add_filter( 'eddeet_settings', array( $this, 'eddeet_ua_field_monster_insights_notice' ) );
		}
		add_action( 'edd_eddeet_ua', array( $this, 'eddeet_ua_field_yoast_active' ) );

		// Yoasts' UA code
		add_filter( 'eddeet_ua_code', array( $this, 'yoast_ga_ua_code' ) );

		if ( edd_get_option( 'eddeet_implementation_method' ) == 'measurement-protocol' ) {
			remove_action( 'wp_head', array( EDD_Enhanced_Ecommerce_Tracking()->implementation, 'output_script' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'monster_insights_conflict_notice' ) );
		}
	}


	/**
	 * Unset UA field.
	 *
	 * Unset the UA field when Yoast GA is active.
	 *
	 * @since 1.0.2
	 *
	 * @param  array $settings List of settings from EDDEET.
	 * @return array           List of modified settings.
	 */
	public function eddeet_ua_field_monster_insights_notice( $settings ) {

		foreach ( $settings as $key => $setting ) {
			if ( 'eddeet_ua' == $setting['id'] ) {
				ob_start();
					?><div class="notice notice-info inline">
						<p>
							<strong><?php _e( 'Monster Insights plugin detected', 'edd-enhanced-ecommerce-tracking' ); ?></strong><br/>
							<?php _e( 'EDD Enhanced eCommerce Tracking won\'t output pageview tracking scripts, this will be left to Monster Insights.', 'edd-enhanced-ecommerce-tracking' ); ?>
						</p>
					</div><?php
				$notice = ob_get_clean();
				$settings[ $key ]['desc'] .= $notice;
			}
		}

		return $settings;
	}


	/**
	 * Replace UA code.
	 *
	 * Replace the UA code for the UA code of Yoasts' plugin.
	 *
	 * @since 1.0.3
	 */
	public function yoast_ga_ua_code( $ua_code ) {

		// New with 6.x
		if ( function_exists( 'monsterinsights_get_ua' ) ) {
			return monsterinsights_get_ua();
		}

		// BC
		$yoast_options = get_option( 'yst_ga', array() );
		$yoast_options = $yoast_options['ga_general'];

		if ( ! empty( $yoast_options['analytics_profile'] ) && ! empty( $yoast_options['analytics_profile_code'] ) ) {
			$tracking_code = $yoast_options['analytics_profile_code'];
		} elseif ( ! empty( $yoast_options['analytics_profile'] ) && empty( $yoast_options['analytics_profile_code'] ) ) {
			// Analytics profile is still holding the UA code
			$tracking_code = $yoast_options['analytics_profile'];
		}

		if ( ! empty( $yoast_options['manual_ua_code_field'] ) && ! empty( $yoast_options['manual_ua_code'] ) ) {
			$tracking_code = $yoast_options['manual_ua_code_field'];
		}

		if ( ! empty( $tracking_code ) ) {
			$ua_code = $tracking_code;
		}

		return $ua_code;
	}


	/**
	 * Transaction items.
	 *
	 * Prepare the transaction items for API call.
	 *
	 * @since 1.0.0
	 *
	 * @param  int   $payment_id ID of the payment being prepared for the tracking API call.
	 * @return array             List of download items that are bought.
	 */
	public function get_renewal_transaction_items( $payment_id ) {

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
	 * Trigger transaction.
	 *
	 * Trigger the API tracking call for transaction.
	 *
	 * @since 1.0.0
	 *
	 * @param int $payment_id ID of the transaction payment.
	 */
	public function trigger_transaction_for_recurring( $payment_id, $parent_payment_id, $amount, $transaction_id ) {

		// Bail if payment is already tracked
		if ( 'yes' == get_post_meta( $payment_id, 'eddeet_tracked', true ) ) {
			return;
		}

		$payment = new EDD_Payment( $payment_id );

		EDD_Enhanced_Ecommerce_Tracking()->track_data->add_track_data( array(
			'type'       => 'purchase',
			'payment_id' => $payment_id,
			'body'       => array(
				'transaction_id' => edd_get_payment_number( $payment_id ), // Transaction ID
				'value'          => edd_get_payment_amount( $payment_id ), // Revenue
				'currency'       => $payment->currency,
				'tax'            => edd_use_taxes() ? edd_get_payment_tax( $payment_id ) : null, // Taxes
				'coupon'         => $payment->discounts !== 'none' ? $payment->discounts : null, // Coupon
				'items'          => $this->get_renewal_transaction_items( $payment_id ),
			),
		) );

		update_post_meta( $payment_id, 'eddeet_tracked', 'yes' );
	}


	/**
	 * Conflict notice EDDEET/MI.
	 *
	 * Show a notice when the tracking method is not through the Measurement Protocol
	 * and MI is active. This won't work as the other methods require JS implementation
	 * in order to work.
	 *
	 * @since 1.2.0
	 */
	public function monster_insights_conflict_notice() {
		?><div class="notice notice-error">
			<p>
				<strong><?php _e( 'Plugin conflict detected', 'edd-enhanced-ecommerce-tracking' ); ?></strong><br/>
				<?php _e( 'Monster Insights and EDD Enhanced eCommerce Tracking are both activated and by default output a page tracking script. Only the <code>Measurement protocol</code> tracking method can be used in combination with Monster Insights. <br/>Either disable Monster Insights (EDDEET adds page tracking too) or switch the \'Tracking method\' setting.', 'edd-enhanced-ecommerce-tracking' ); ?>
			</p>
		</div><?php
	}

}

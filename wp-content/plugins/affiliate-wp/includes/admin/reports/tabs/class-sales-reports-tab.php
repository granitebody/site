<?php
/**
 * Reports: Sales tab
 *
 * @package     AffiliateWP
 * @subpackage  Admin/Reports
 * @copyright   Copyright (c) 2020, Sandhills Development, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.5
 */

namespace AffWP\Referral\Sale\Admin\Reports;

use AffWP\Admin\Reports;

/**
 * Implements a core 'Sales' tab for the Reports screen.
 *
 * @since 2.5
 *
 * @see \AffWP\Admin\Reports\Tab
 */
class Tab extends Reports\Tab {

	/**
	 * Sets up the Visits tab for Reports.
	 *
	 * @since 2.5
	 */
	public function __construct() {
		if ( $this->active_integration_supports_sales() ) {
			$this->tab_id   = 'sales';
			$this->label    = _x( 'Sales', 'sales report label', 'affiliate-wp' );
			$this->priority = 0;
			$this->graph    = new \Affiliate_WP_Sales_Graph;

			$this->set_up_additional_filters();

			parent::__construct();
		}
	}

	/**
	 * Returns true if any active integration supports sales reporting.
	 *
	 * @since 2.5
	 *
	 * @return bool True if any integration supports sales reporting. False otherwise.
	 */
	private function active_integration_supports_sales() {
		$result = false;

		// Retrieve supported integrations
		$supported_enabled_integrations = affiliate_wp()->integrations->query( array(
			'supports' => 'sales_reporting',
			'status'   => 'enabled',
			'fields'   => 'ids',
		) );

		// Loop through each integration and determine if the plugin is active.
		foreach ( $supported_enabled_integrations as $integration ) {
			$integration = affiliate_wp()->integrations->get( $integration );

			if ( ! is_wp_error( $integration ) && $integration->is_active() ) {
				$result = true;
				break;
			}
		}

		return $result;
	}

	/**
	 * Removes the affiliate filter field for this tab.
	 *
	 * @since 2.5
	 */
	public function affiliate_filter() { }

	/**
	 * Registers the Sales tab tiles.
	 *
	 * @since 2.5
	 */
	public function register_tiles() {
		$supported_integrations = affiliate_wp()->integrations->query( array(
			'supported_integrations' => 'sales_reporting',
		) );

		$context = array_keys( $supported_integrations );

		$referral_statuses = array(
			'paid',
			'unpaid',
		);

		$this->register_tile( 'all_time_net_affiliate_revenue', array(
			'label'           => __( 'Net Affiliate-generated Revenue', 'affiliate-wp' ),
			'type'            => 'amount',
			'tooltip'         => __( 'Total revenue earned as a result of affiliate-generated sales, with affiliate earnings deducted.', 'affiliate-wp' ),
			'context'         => 'primary',
			'comparison_data' => __( 'All Time', 'affiliate-wp' ),
			'data'            => affiliate_wp()->referrals->sales->get_profits_by_referral_status(
				$referral_statuses,
				$this->affiliate_id,
				'alltime'
			),
		) );

		$this->register_tile( 'all_time_affiliate_revenue_percentage', array(
			'label'           => __( 'Gross Revenue Increase From Affiliates', 'affiliate-wp' ),
			'tooltip'         => __( 'Increase in gross revenue as a result of affiliate-generated sales.', 'affiliate-wp' ),
			'data'            => affiliate_wp()->integrations->get_affiliate_generated_sale_percentage(),
			'type'            => 'percentage',
			'context'         => 'secondary',
			'comparison_data' => __( 'All Time', 'affiliate-wp' ),
		) );

		$this->register_tile( 'gross_affiliate_revenue', array(
			'label'           => __( 'Gross Affiliate-generated Revenue', 'affiliate-wp' ),
			'tooltip'         => __( 'Total revenue earned as a result of affiliate-generated sales.', 'affiliate-wp' ),
			'type'            => 'amount',
			'context'         => 'tertiary',
			'comparison_data' => $this->get_date_comparison_label(),
			'data'            => affiliate_wp()->referrals->sales->get_revenue_by_referral_status(
				$referral_statuses,
				$this->affiliate_id,
				$this->date_query
			),
		) );

		$this->register_tile( 'total_sales_earnings', array(
			'label'           => __( 'Total Affiliate Sales Earnings', 'affiliate-wp' ),
			'tooltip'         => __( 'Total amount earned by affiliates as a result of affiliate-generated sales.', 'affiliate-wp' ),
			'type'            => 'amount',
			'context'         => 'primary',
			'comparison_data' => $this->get_date_comparison_label(),
			'data'            => affiliate_wp()->referrals->get_earnings_by_status(
				$referral_statuses,
				$this->affiliate_id,
				$this->date_query,
				$context,
				'sale'
			),
		) );

		$this->register_tile( 'net_affiliate_revenue', array(
			'label'           => __( 'Net Affiliate-generated Revenue', 'affiliate-wp' ),
			'tooltip'         => __( 'The net revenue generated by the affiliate channel after deducting affiliate earnings.', 'affiliate-wp' ),
			'type'            => 'amount',
			'context'         => 'secondary',
			'comparison_data' => $this->get_date_comparison_label(),
			'data'            => affiliate_wp()->referrals->sales->get_profits_by_referral_status(
				$referral_statuses,
				$this->affiliate_id,
				$this->date_query
			),
		) );

		$this->register_tile( 'affiliate_sale_percentage', array(
			'label'           => __( 'Affiliate-generated Sales', 'affiliate-wp' ),
			'tooltip'         => __( 'Percentage (%) of sales generated by affiliates.', 'affiliate-wp' ),
			'data'            => affiliate_wp()->integrations->get_affiliate_generated_order_percentage( $this->date_query ),
			'type'            => 'percentage',
			'context'         => 'tertiary',
			'comparison_data' => $this->get_date_comparison_label(),
		) );

		$this->register_tile( 'affiliate_revenue_percentage', array(
			'label'           => __( 'Gross Revenue Increase From Affiliates', 'affiliate-wp' ),
			'tooltip'         => __( 'Increase in gross revenue as a result of affiliate-generated sales.', 'affiliate-wp' ),
			'data'            => affiliate_wp()->integrations->get_affiliate_generated_sale_percentage( $this->date_query ),
			'type'            => 'percentage',
			'comparison_data' => $this->get_date_comparison_label(),
			'context'         => 'primary',
		) );

		$this->register_tile( 'affiliate_sale_count', array(
			'label'           => __( 'Affiliate-generated Sale Count', 'affiliate-wp' ),
			'tooltip'         => __( 'Total number of affiliate-generated sales.', 'affiliate-wp' ),
			'type'            => 'number',
			'context'         => 'secondary',
			'comparison_data' => $this->get_date_comparison_label(),
			'data'            => affiliate_wp()->referrals->count( array(
				'date'   => $this->date_query,
				'status' => $referral_statuses,
				'type'   => 'sale',
			) ),
		) );

	}

	/**
	 * Handles display for the 'Trends' section.
	 *
	 * Must be overridden by extending sub-classes.
	 *
	 * @since 2.5
	 */
	public function display_trends() {
		$this->graph->set( 'show_controls', false );
		$this->graph->set( 'x_mode', 'time' );
		$this->graph->display();
	}
}
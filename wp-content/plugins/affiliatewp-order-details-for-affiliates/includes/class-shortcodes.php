<?php

class AffiliateWP_Order_Details_For_Affiliates_Shortcodes {

	public function __construct() {

        // force front-end scripts
        add_filter( 'affwp_force_frontend_scripts', array( $this, 'force_frontend_scripts' ) );

        // [affiliate_order_details]
        add_shortcode( 'affiliate_order_details', array( $this, 'affiliate_order_details' ) );
	}

    /**
     * Force the frontend scripts to load on pages with the shortcodes
     *
     * @since  1.0
     */
    public function force_frontend_scripts( $ret ) {
        global $post;

        if ( has_shortcode( $post->post_content, 'affiliate_order_details' ) ) {
            $ret = true;
        }

        return $ret;
    }

    /**
    * [affiliate_order_details] shortcode
    *
    * @since  1.0
    */
    public function affiliate_order_details( $atts, $content = null ) {

        global $affwp_od_atts;

    	if ( ! ( affwp_is_affiliate() && affwp_is_active_affiliate() ) ) {
    		return;
    	}

		if ( ! ( affiliatewp_order_details_for_affiliates()->can_access_order_details() || affiliatewp_order_details_for_affiliates()->global_order_details_access() ) ) {
			return;
		}

        $affwp_od_atts = shortcode_atts( array(
            'number'       => '',
            'affiliate_id' => '',
            'status'       => ''

        ), $atts, 'affiliate_order_details' );

    	ob_start();

    	affiliate_wp()->templates->get_template_part( 'dashboard-tab', 'order-details' );

    	$content = ob_get_clean();

    	return do_shortcode( $content );
    }
}
new AffiliateWP_Order_Details_For_Affiliates_Shortcodes;

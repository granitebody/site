<?php

// =============================================================================
// VIEWS/PARTIALS/PRODUCTS.PHP
// -----------------------------------------------------------------------------
// Products partial.
// =============================================================================

$style_id = ( isset( $style_id ) ) ? $style_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-wc-products', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------
// 01. The markup output in this condition is duplicated from WooCommerce
//     templates (e.g. Upsells, Related Products, et cetera).

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php

  if ( $products_type === 'main-loop' ) { // 01
    $the_products = wc_get_products( array(
      'limit'   => intval( $products_count ),
      'orderby' => $products_orderby,
      'order'   => $products_order
    ) );

    wc_set_loop_prop( 'columns', intval( $products_columns ) );

    woocommerce_product_loop_start();
      foreach ( $the_products as $the_product ) :
        $post_object = get_post( $the_product->get_id() );
        setup_postdata( $GLOBALS['post'] =& $post_object );
        wc_get_template_part( 'content', 'product' );
      endforeach;
    woocommerce_product_loop_end();
  }

  if ( $products_type === 'cross-sells' ) {
    woocommerce_cross_sell_display(
      intval( $products_count ),
      intval( $products_columns ),
      $products_orderby,
      $products_order
    );
  }

  if ( $products_type === 'related' ) {
    woocommerce_related_products( array(
      'posts_per_page' => intval( $products_count ),
      'columns'        => intval( $products_columns ),
      'orderby'        => $products_orderby,
      'order'          => $products_order
    ) );
  }

  if ( $products_type === 'upsells' ) {
    woocommerce_upsell_display(
      intval( $products_count ),
      intval( $products_columns ),
      $products_orderby,
      $products_order
    );
  }

  ?>
</div>

<?php

// =============================================================================
// VIEWS/ELEMENTS/TP-WC-SHOP-SORT.PHP
// -----------------------------------------------------------------------------
// WooCommerce shop sort.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-wc-shop-sort', $class ) );


// Prepare Atts
// ------------

$atts = array(
  'class' => $classes
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php woocommerce_catalog_ordering(); ?>
  <?php woocommerce_result_count(); ?>
</div>

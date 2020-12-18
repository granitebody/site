<?php

// =============================================================================
// VIEWS/ELEMENTS/TP-WC-SHOP-NOTICES.PHP
// -----------------------------------------------------------------------------
// WooCommerce shop notices.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-wc-shop-notices', $class ) );


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
  <?php woocommerce_output_all_notices(); ?>
</div>

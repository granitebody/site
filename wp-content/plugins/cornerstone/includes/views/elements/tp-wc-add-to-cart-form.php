<?php

// =============================================================================
// VIEWS/ELEMENTS/TP-WC-ADD-TO-CART-FORM.PHP
// -----------------------------------------------------------------------------
// WooCommerce add to cart form.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-wc-add-to-cart-form', $class ) );


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

global $product;

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php if ( ! empty($product) ) : woocommerce_template_single_add_to_cart(); endif; ?>
</div>

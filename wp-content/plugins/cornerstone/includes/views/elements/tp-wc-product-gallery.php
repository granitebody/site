<?php

// =============================================================================
// VIEWS/ELEMENTS/TP-WC-PRODUCT-GALLERY.PHP
// -----------------------------------------------------------------------------
// WooCommerce product gallery.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-wc-product-gallery', $class ) );


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
  <?php // echo wc_get_gallery_image_html( get_post_thumbnail_id(), true ); ?>
  <?php echo $gallery_content; ?>
</div>

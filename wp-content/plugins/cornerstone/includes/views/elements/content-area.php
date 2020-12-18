<?php

// =============================================================================
// VIEWS/ELEMENTS/CONTENT-AREA.PHP
// -----------------------------------------------------------------------------
// Content area element.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-content-area', $class ) );


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

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo do_shortcode( $content ); ?>
</div>

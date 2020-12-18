<?php

// =============================================================================
// VIEWS/ELEMENTS/LINE.PHP
// -----------------------------------------------------------------------------
// Line element.
// =============================================================================

// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-line', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<hr <?php echo x_atts( $atts, $custom_atts ); ?>/>

<?php

// =============================================================================
// VIEWS/ELEMENTS/GAP.PHP
// -----------------------------------------------------------------------------
// Gap element.
// =============================================================================

// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-line', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<hr <?php echo x_atts( $atts, $custom_atts ); ?>>

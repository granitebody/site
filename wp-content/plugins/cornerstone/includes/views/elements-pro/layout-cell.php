<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/LAYOUT-CELL.PHP
// -----------------------------------------------------------------------------
// Layout element (Cell).
// =============================================================================

// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-cell', $class );


// Advanced Background
// -------------------

if ( $layout_cell_bg_advanced === true ) {
  $bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Particles
// ---------

$particles = cs_make_particles( $_view_data, 'layout_cell' );

if ( ! empty( $particles ) ) {
  $classes[] = 'has-particle';
}


// Atts
// ----

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( $layout_cell_tag === 'a' ) {
  $atts = cs_apply_link( $atts, $_view_data, 'layout_cell' );
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<<?php echo $layout_cell_tag; ?> <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php if ( isset( $bg ) ) { echo $bg; } ?>
  <?php do_action( 'x_layout_cell', $_modules, $_view_data ); ?>
  <?php if ( ! empty( $particles ) ) { echo $particles; } ?>
</<?php echo $layout_cell_tag; ?>>

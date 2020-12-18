<?php

// =============================================================================
// VIEWS/ELEMENTS/LAYOUT-COLUMN.PHP
// -----------------------------------------------------------------------------
// Layout element (Column).
// =============================================================================

// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-col', $class );


// Advanced Background
// -------------------

if ( $layout_column_bg_advanced === true ) {
  $bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Particles
// ---------

$particles = cs_make_particles( $_view_data, 'layout_column' );

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

if ( $layout_column_tag === 'a' ) {
  $atts = cs_apply_link( $atts, $_view_data, 'layout_column' );
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<<?php echo $layout_column_tag; ?> <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php if ( isset( $bg ) ) { echo $bg; } ?>
  <?php do_action( 'x_layout_column', $_modules, $_view_data ); ?>
  <?php if ( ! empty( $particles ) ) { echo $particles; } ?>
</<?php echo $layout_column_tag; ?>>

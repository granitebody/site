<?php

// =============================================================================
// VIEWS/ELEMENTS/LAYOUT-ROW.PHP
// -----------------------------------------------------------------------------
// Layout element (Row).
// =============================================================================

// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-row', $class );

if ( $layout_row_global_container == true ) {
  $classes[] = 'x-container max width';
}


// Advanced Background
// -------------------

if ( $layout_row_bg_advanced === true ) {
  $bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Particles
// ---------

$particles = cs_make_particles( $_view_data, 'layout_row' );

if ( ! empty( $particles ) ) {
  $classes[] = 'has-particle';
}


// Atts
// ----

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( $layout_row_tag === 'a' ) {
  $atts = cs_apply_link( $atts, $_view_data, 'layout_row' );
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<<?php echo $layout_row_tag; ?> <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php if ( isset( $bg ) ) { echo $bg; } ?>
  <div class="x-row-inner"><?php do_action( 'x_layout_row', $_modules, $_view_data ); ?></div>
  <?php if ( ! empty( $particles ) ) { echo $particles; } ?>
</<?php echo $layout_row_tag; ?>>

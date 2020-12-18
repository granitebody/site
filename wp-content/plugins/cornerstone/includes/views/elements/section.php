<?php

// =============================================================================
// VIEWS/ELEMENTS/SECTION.PHP
// -----------------------------------------------------------------------------
// Section element.
// =============================================================================

$atts = ( isset( $atts ) ) ? $atts : array();


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-section', $class );


// Separators
// ----------

$section_top_separator_content = NULL;

if ( $section_top_separator === true ) {
  $section_top_separator_content = cs_get_partial_view(
    'separator',
    cs_extract( $_view_data, array( 'section_top_separator' => 'separator' ) )
  );
}


$section_bottom_separator_content = NULL;

if ( $section_bottom_separator === true ) {
  $section_bottom_separator_content = cs_get_partial_view(
    'separator',
    cs_extract( $_view_data, array( 'section_bottom_separator' => 'separator' ) )
  );
}


// Advanced Background
// -------------------

if ( $section_bg_advanced === true ) {
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

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( $section_tag === 'a' ) {
  $atts = cs_apply_link( $atts, $_view_data, 'section' );
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

?>

<<?php echo $section_tag; ?> <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo $section_top_separator_content; ?>
  <?php if ( isset( $bg ) ) { echo $bg; } ?>
  <?php do_action( 'x_section', $_modules, $_view_data ); ?>
  <?php if ( ! empty( $particles ) ) { echo $particles; } ?>
  <?php echo $section_bottom_separator_content; ?>
</<?php echo $section_tag; ?>>

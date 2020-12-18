<?php

// =============================================================================
// VIEWS/PARTIALS/DROPDOWN.PHP
// -----------------------------------------------------------------------------
// Dropdown partial.
// =============================================================================

$unique_id            = ( isset( $unique_id )                             ) ? $unique_id : '';
$style_id             = ( isset( $style_id )                              ) ? $style_id : '';
$dropdown_custom_atts = ( isset( $dropdown_custom_atts )                  ) ? $dropdown_custom_atts : null;
$tag                  = ( isset( $dropdown_is_list ) && $dropdown_is_list ) ? 'ul' : 'div';

// Prepare Attr Values
// -------------------

$id_slug = ( isset( $id ) && ! empty( $id ) ) ? $id . '-dropdown' : $style_id . '-dropdown';
$classes = x_attr_class( array( $style_id, 'x-dropdown', $class ) );


// Prepare Atts
// ------------

$atts = array(
  'id'                => $id_slug,
  'class'             => $classes,
  'data-x-stem'       => NULL,
  'data-x-stem-top'   => NULL,
  'data-x-toggleable' => $unique_id,
  'aria-hidden'       => 'true',
);

if ( isset( $_region ) && $_region === 'left' ) {
  $atts['data-x-stem-top'] = 'h';
}

if ( isset( $_region ) && $_region === 'right' ) {
  $atts['data-x-stem-top'] = 'rh';
}

// Dynamic Rendering
// -----------------

$output_dropdown_content = do_shortcode($dropdown_content);

if (isset($dropdown_content_dynamic_rendering) && $dropdown_content_dynamic_rendering) {
  $output_dropdown_content = apply_filters( 'cs_dynamic_rendering', $output_dropdown_content );
  $output_dropdown_content = "<div data-x-toggleable-content=\"$style_id\">$output_dropdown_content</div>";
}


// Output
// ------

?>

<<?php echo $tag ?> <?php echo x_atts( $atts, $dropdown_custom_atts ); ?>>
  <?php echo $output_dropdown_content; ?>
</<?php echo $tag ?>>

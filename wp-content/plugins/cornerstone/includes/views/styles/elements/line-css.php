<?php

// =============================================================================
// LINE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'radius' => 'line_border_radius',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'line_box_shadow_dimensions',
  'base'       => 'line_box_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-line {
  @if $line_direction === 'horizontal' {
    width: $line_width;
    max-width: $line_max_width;
  }
  @if $line_direction === 'vertical' {
    height: $line_height;
    max-height: $line_max_height;
  }
  @unless $line_margin?? {
    margin: $line_margin;
  }
  @if $line_direction === 'horizontal' {
    border-width: $line_size 0 0 0;
  }
  @if $line_direction === 'vertical' {
    border-width: 0 0 0 $line_size;
  }
  border-style: $line_style;
  border-color: $line_color;
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  font-size: $line_base_font_size;
  <?php echo cs_get_partial_style( '_shadow-base', $data_box_shadow ); ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-line',
  'children' => [],
) );

?>

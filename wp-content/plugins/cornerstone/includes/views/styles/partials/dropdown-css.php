<?php

// =============================================================================
// _DROPDOWN-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != '' ) ? $selector : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

$data_border = array(
  'width'  => $key_prefix . 'dropdown_border_width',
  'style'  => $key_prefix . 'dropdown_border_style',
  'base'   => $key_prefix . 'dropdown_border_color',
  'radius' => $key_prefix . 'dropdown_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'dropdown_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'dropdown_box_shadow_dimensions',
  'base'       => $key_prefix . 'dropdown_box_shadow_color',
);



// Base
// =============================================================================
// transition-* order: opacity, transform, visibility

?>

.$_el<?php echo $selector; ?> .x-dropdown {
  width: $<?php echo $key_prefix; ?>dropdown_width;
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $<?php echo $key_prefix; ?>dropdown_padding?? {
    padding: $<?php echo $key_prefix; ?>dropdown_padding;
  }
  font-size: $<?php echo $key_prefix; ?>dropdown_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
  transition-duration: $<?php echo $key_prefix; ?>dropdown_duration, $<?php echo $key_prefix; ?>dropdown_duration, 0s;
  transition-timing-function: $<?php echo $key_prefix; ?>dropdown_timing_function;
}

.$_el<?php echo $selector; ?> .x-dropdown:not(.x-active) {
  transition-delay: 0s, 0s, $<?php echo $key_prefix; ?>dropdown_duration;
}

.$_el<?php echo $selector; ?> .x-dropdown[data-x-stem-top] {
  @unless $<?php echo $key_prefix; ?>dropdown_margin?? {
    margin: $<?php echo $key_prefix; ?>dropdown_margin;
  }
}

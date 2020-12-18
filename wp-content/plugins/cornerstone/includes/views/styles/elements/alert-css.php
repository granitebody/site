<?php

// =============================================================================
// ALERT-CSS.PHP
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

$data_linotype = array(
  'ff'     => 'alert_font_family',
  'fsize'  => 'alert_font_size',
  'fstyle' => 'alert_font_style',
  'fw'     => 'alert_font_weight',
  'lh'     => 'alert_line_height',
  'ls'     => 'alert_letter_spacing',
  'ta'     => 'alert_text_align',
  'td'     => 'alert_text_decoration',
  'tt'     => 'alert_text_transform',
);

$data_border = array(
  'width'    => 'alert_border_width',
  'style'    => 'alert_border_style',
  'base'     => 'alert_border_color',
  'radius'   => 'alert_border_radius',
  'fallback' => true,
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'alert_box_shadow_dimensions',
  'base'       => 'alert_box_shadow_color',
  'fallback'   => true,
);

$data_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'alert_text_shadow_dimensions',
  'base'       => 'alert_text_shadow_color',
  'fallback'   => true,
);



// Base
// =============================================================================

?>

.$_el.x-alert {
  @if $alert_width !== 'auto' {
    width: $alert_width;
  }
  @unless $alert_max_width?? {
    max-width: $alert_max_width;
  }
  @unless $alert_margin?? {
    margin: $alert_margin;
  }
  @if $alert_margin?? {
    margin: 0;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $alert_padding?? {
    padding: $alert_padding;
  }
  @if $alert_padding?? {
    padding: 0;
  }
  <?php
  echo cs_get_partial_style( '_linotype', $data_linotype );
  echo cs_get_partial_style( '_shadow-base', $data_text_shadow );
  ?>
  color: $alert_text_color;
  background-color: $alert_bg_color;
  <?php echo cs_get_partial_style( '_shadow-base', $data_box_shadow ); ?>
}

@if $alert_close === true {
  .$_el .close {
    position: absolute;
    top: $alert_close_offset_top;
    @if $alert_close_location === 'left' {
      left: $alert_close_offset_side;
      right: auto;
    }
    @if $alert_close_location === 'right' {
      left: auto;
      right: $alert_close_offset_side;
    }
    bottom: auto;
    width: 1em;
    height: 1em;
    font-size: $alert_close_font_size;
    text-shadow: none;
    color: $alert_close_color;
    opacity: 1;
  }

  .$_el .close:hover,
  .$_el .close:focus {
    color: $alert_close_color_alt;
    opacity: 1;
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-alert',
  'children' => [],
) );

?>

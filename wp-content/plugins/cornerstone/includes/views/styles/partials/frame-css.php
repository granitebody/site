<?php

// =============================================================================
// _FRAME-CSS.PHP
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

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

$data_border = array(
  'width'  => $key_prefix . 'frame_border_width',
  'style'  => $key_prefix . 'frame_border_style',
  'base'   => $key_prefix . 'frame_border_color',
  'radius' => $key_prefix . 'frame_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'frame_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'frame_box_shadow_dimensions',
  'base'       => $key_prefix . 'frame_box_shadow_color',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-frame {
  @if $<?php echo $key_prefix; ?>frame_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>frame_width;
  }
  @unless $<?php echo $key_prefix; ?>frame_max_width?? {
    max-width: $<?php echo $key_prefix; ?>frame_max_width;
  }
  @unless $<?php echo $key_prefix; ?>frame_margin?? {
    margin: $<?php echo $key_prefix; ?>frame_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $<?php echo $key_prefix; ?>frame_padding?? {
    padding: $<?php echo $key_prefix; ?>frame_padding;
  }
  font-size: $<?php echo $key_prefix; ?>frame_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?> .x-frame-inner {
  @if $<?php echo $key_prefix; ?>frame_content_sizing === 'fixed-height' {
    padding-bottom: $frame_content_height;
  }
  @if $<?php echo $key_prefix; ?>frame_content_sizing === 'aspect-ratio' {
    padding-bottom: calc(($<?php echo $key_prefix; ?>frame_content_aspect_ratio_height / $<?php echo $key_prefix; ?>frame_content_aspect_ratio_width) * 100%);
  }
}

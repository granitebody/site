<?php

// =============================================================================
// _ICON-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. :hover
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '.x-icon';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

$data_border = array(
  'width'  => $key_prefix . 'icon_border_width',
  'style'  => $key_prefix . 'icon_border_style',
  'base'   => $key_prefix . 'icon_border_color',
  'alt'    => $key_prefix . 'icon_border_color_alt',
  'radius' => $key_prefix . 'icon_border_radius',
);

$data_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'icon_color',
  'alt'  => $key_prefix . 'icon_color_alt',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'icon_bg_color',
  'alt'  => $key_prefix . 'icon_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'icon_box_shadow_dimensions',
  'base'       => $key_prefix . 'icon_box_shadow_color',
  'alt'        => $key_prefix . 'icon_box_shadow_color_alt',
);

$data_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'icon_text_shadow_dimensions',
  'base'       => $key_prefix . 'icon_text_shadow_color',
  'alt'        => $key_prefix . 'icon_text_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  @if $<?php echo $key_prefix; ?>icon_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>icon_width;
  }
  @unless $<?php echo $key_prefix; ?>icon_margin?? {
    margin: $<?php echo $key_prefix; ?>icon_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @if $<?php echo $key_prefix; ?>icon_height !== 'auto' {
    height: $<?php echo $key_prefix; ?>icon_height;
    line-height: $<?php echo $key_prefix; ?>icon_height;
  }
  font-size: $<?php echo $key_prefix; ?>icon_font_size;
  <?php
  echo cs_get_partial_style( '_shadow-base', $data_text_shadow );
  echo cs_get_partial_style( '_color-base', $data_color );
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// :hover
// =============================================================================

?>

.$_el<?php echo $selector; ?>:hover,
.$_el<?php echo $selector; ?>[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_color );
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  echo cs_get_partial_style( '_shadow-alt', $data_text_shadow );
  ?>
}

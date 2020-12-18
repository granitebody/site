<?php

// =============================================================================
// _TOGGLE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Type: Icon
//   04. Type: Toggle
// =============================================================================

// Setup
// =============================================================================

$no_base    = ( isset( $no_base ) && $no_base == true     ) ? ''                : ' .x-graphic';
$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';

$data_border = array(
  'width'  => $key_prefix . 'graphic_icon_border_width',
  'style'  => $key_prefix . 'graphic_icon_border_style',
  'base'   => $key_prefix . 'graphic_icon_border_color',
  'alt'    => $key_prefix . 'graphic_icon_border_color_alt',
  'radius' => $key_prefix . 'graphic_icon_border_radius',
);

$data_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'graphic_icon_color',
  'alt'  => $key_prefix . 'graphic_icon_color_alt',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'graphic_icon_bg_color',
  'alt'  => $key_prefix . 'graphic_icon_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'graphic_icon_box_shadow_dimensions',
  'base'       => $key_prefix . 'graphic_icon_box_shadow_color',
  'alt'        => $key_prefix . 'graphic_icon_box_shadow_color_alt',
);

$data_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'graphic_icon_text_shadow_dimensions',
  'base'       => $key_prefix . 'graphic_icon_text_shadow_color',
  'alt'        => $key_prefix . 'graphic_icon_text_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector . $no_base; ?> {
  @unless $<?php echo $key_prefix; ?>graphic_margin?? {
    margin: $<?php echo $key_prefix; ?>graphic_margin;
  }
}



<?php

// Type: Icon
// =============================================================================
// .$_el<?php echo $selector; > .x-graphic {
//   font-size: $<?php echo $key_prefix; >graphic_icon_font_size;
// }

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'icon' {

  .$_el<?php echo $selector; ?> .x-graphic-icon {
    font-size: $<?php echo $key_prefix; ?>graphic_icon_font_size;
    width: $<?php echo $key_prefix; ?>graphic_icon_width;
    <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
    @if $<?php echo $key_prefix; ?>graphic_icon_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>graphic_icon_height;
      line-height: $<?php echo $key_prefix; ?>graphic_icon_height;
    }
    <?php
    echo cs_get_partial_style( '_shadow-base', $data_text_shadow );
    echo cs_get_partial_style( '_color-base', $data_color );
    echo cs_get_partial_style( '_color-base', $data_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
    ?>
  }

  @if $<?php echo $key_prefix; ?>graphic_has_alt === true {
    .$_el<?php echo $selector; ?>:hover .x-graphic-icon,
    .$_el<?php echo $selector; ?>[class*="active"] .x-graphic-icon,
    [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-graphic-icon {
      <?php
      echo cs_get_partial_style( '_color-alt', $data_color );
      echo cs_get_partial_style( '_border-alt', $data_border );
      echo cs_get_partial_style( '_color-alt', $data_background_color );
      echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
      echo cs_get_partial_style( '_shadow-alt', $data_text_shadow );
      ?>
    }
  }
}



<?php

// Type: Image
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'image' {
  .$_el<?php echo $selector; ?> .x-graphic-image {
    @unless $<?php echo $key_prefix; ?>graphic_image_max_width?? {
      max-width: $<?php echo $key_prefix; ?>graphic_image_max_width;
    }
  }
}



<?php

// Type: Toggle
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>graphic_type === 'toggle' {
  <?php echo cs_get_partial_style( 'toggle' ); ?>
}

<?php

// =============================================================================
// IMAGE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'image_border_width',
  'style'  => 'image_border_style',
  'base'   => 'image_border_color',
  'alt'    => 'image_border_color_alt',
  'radius' => 'image_outer_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'image_bg_color',
  'alt'  => 'image_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'image_box_shadow_dimensions',
  'base'       => 'image_box_shadow_color',
  'alt'        => 'image_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-image {
  @if $image_display !== 'inline-block' {
    display: $image_display;
  }
}

@if $image_type !== 'scaling' {
  .$_el.x-image {
    @if $image_styled_width !== 'auto' {
      width: $image_styled_width;
    }
    @unless $image_styled_max_width?? {
      max-width: $image_styled_max_width;
    }
    @unless $image_margin?? {
      margin: $image_margin;
    }
    <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
    @unless $image_padding?? {
      padding: $image_padding;
    }
    <?php
    echo cs_get_partial_style( '_color-base', $data_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
    ?>
  }

  .$_el.x-image img {
    @if $image_styled_width !== 'auto' {
      width: 100%;
    }
    @unless $image_inner_border_radius?? {
      border-radius: $image_inner_border_radius;
    }
    @if $image_object_fit !== 'fill' {
      object-fit: $image_object_fit;
    }
    @if $image_object_position !== '50% 50%' {
      object-position: $image_object_position;
    }
  }

  .$_el.x-image,
  .$_el.x-image img {
    @if $image_styled_height !== 'auto' {
      height: $image_styled_height;
    }
    @unless $image_styled_max_height?? {
      max-height: $image_styled_max_height;
    }
  }
}

.$_el.x-image:hover,
.$_el.x-image[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-image {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  ?>
}

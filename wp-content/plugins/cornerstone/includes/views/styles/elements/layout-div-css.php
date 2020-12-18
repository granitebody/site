<?php

// =============================================================================
// LAYOUT-DIV-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Particles
//   04. Effects
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'layout_div_border_width',
  'style'  => 'layout_div_border_style',
  'base'   => 'layout_div_border_color',
  'alt'    => 'layout_div_border_color_alt',
  'radius' => 'layout_div_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'layout_div_bg_color',
  'alt'  => 'layout_div_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'layout_div_box_shadow_dimensions',
  'base'       => 'layout_div_box_shadow_color',
  'alt'        => 'layout_div_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-div {
  @if $layout_div_overflow_x !== 'visible' {
    overflow-x: $layout_div_overflow_x;
  }
  @if $layout_div_overflow_y !== 'visible' {
    overflow-y: $layout_div_overflow_y;
  }
  @if $layout_div_flexbox {
    display: flex;
    flex-direction: $layout_div_flex_direction;
    justify-content: $layout_div_flex_justify;
    align-items: $layout_div_flex_align;
    @if $layout_div_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $layout_div_flex_align;
    }
  }
  flex: $layout_div_flex;
  @if $layout_div_position !== 'relative' {
    position: $layout_div_position;
  }
  @if $layout_div_position !== 'static' {
    @if $layout_div_top !== 'auto' {
      top: $layout_div_top;
    }
    @if $layout_div_left !== 'auto' {
      left: $layout_div_left;
    }
    @if $layout_div_right !== 'auto' {
      right: $layout_div_right;
    }
    @if $layout_div_bottom !== 'auto' {
      bottom: $layout_div_bottom;
    }
  }
  @if $layout_div_z_index !== 'auto' {
    z-index: $layout_div_z_index;
  }
  @if $layout_div_width !== 'auto' {
    width: $layout_div_width;
  }
  @unless $layout_div_min_width?? {
    min-width: $layout_div_min_width;
  }
  @unless $layout_div_max_width?? {
    max-width: $layout_div_max_width;
  }
  @if $layout_div_height !== 'auto' {
    height: $layout_div_height;
  }
  @unless $layout_div_min_height?? {
    min-height: $layout_div_min_height;
  }
  @unless $layout_div_max_height?? {
    max-height: $layout_div_max_height;
  }
  @unless $layout_div_margin?? {
    margin: $layout_div_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $layout_div_padding?? {
    padding: $layout_div_padding;
  }
  font-size: $layout_div_base_font_size;
  @unless $layout_div_text_align?? {
    text-align: $layout_div_text_align;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el.x-div > * {
  @if $layout_div_pointer_events === 'none-self' {
    pointer-events: auto;
  }
}

$layout_div_tag.$_el.x-div {
  @if $layout_div_pointer_events === 'auto' {
    pointer-events: auto;
  }
  @if $layout_div_pointer_events === 'none-self' || $layout_div_pointer_events === 'none-all' {
    pointer-events: none;
  }
}

.$_el.x-div:hover,
.$_el.x-div[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-div {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  ?>
}



<?php

// Particles
// =============================================================================

?>

@if $layout_div_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-div',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'layout_div_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $layout_div_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-div',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'layout_div_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-div',
  'children' => [],
) );

?>

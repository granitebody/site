<?php

// =============================================================================
// LAYOUT-COLUMN-CSS.PHP
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
  'width'  => 'layout_column_border_width',
  'style'  => 'layout_column_border_style',
  'base'   => 'layout_column_border_color',
  'alt'    => 'layout_column_border_color_alt',
  'radius' => 'layout_column_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'layout_column_bg_color',
  'alt'  => 'layout_column_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'layout_column_box_shadow_dimensions',
  'base'       => 'layout_column_box_shadow_color',
  'alt'        => 'layout_column_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-col {
  @if $layout_column_overflow !== 'visible' {
    overflow: $layout_column_overflow;
  }
  @if $layout_column_flexbox {
    display: flex;
    flex-direction: $layout_column_flex_direction;
    justify-content: $layout_column_flex_justify;
    align-items: $layout_column_flex_align;
    @if $layout_column_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $layout_column_flex_align;
    }
  }
  z-index: $layout_column_z_index;
  @if $layout_column_width !== 'auto' {
    width: $layout_column_width;
  }
  @unless $layout_column_min_width?? {
    min-width: $layout_column_min_width;
  }
  @unless $layout_column_max_width?? {
    max-width: $layout_column_max_width;
  }
  @if $layout_column_height !== 'auto' {
    height: $layout_column_height;
  }
  @unless $layout_column_min_height?? {
    min-height: $layout_column_min_height;
  }
  @unless $layout_column_max_height?? {
    max-height: $layout_column_max_height;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $layout_column_padding?? {
    padding: $layout_column_padding;
  }
  font-size: $layout_column_base_font_size;
  @unless $layout_column_text_align?? {
    text-align: $layout_column_text_align;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el.x-col:hover,
.$_el.x-col[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-col {
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

@if $layout_column_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-col',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'layout_column_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $layout_column_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-col',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'layout_column_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-col',
  'children' => [],
) );

?>

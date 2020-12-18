<?php

// =============================================================================
// LAYOUT-GRID-CSS.PHP
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
//   05. Responsive Styles
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'layout_grid_border_width',
  'style'  => 'layout_grid_border_style',
  'base'   => 'layout_grid_border_color',
  'alt'    => 'layout_grid_border_color_alt',
  'radius' => 'layout_grid_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'layout_grid_bg_color',
  'alt'  => 'layout_grid_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'layout_grid_box_shadow_dimensions',
  'base'       => 'layout_grid_box_shadow_color',
  'alt'        => 'layout_grid_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-grid {
  @if $layout_grid_overflow !== 'visible' {
    overflow: $layout_grid_overflow;
  }
  grid-gap: $layout_grid_gap_row $layout_grid_gap_column;
  justify-content: $layout_grid_justify_content;
  align-content: $layout_grid_align_content;
  justify-items: $layout_grid_justify_items;
  align-items: $layout_grid_align_items;
  z-index: $layout_grid_z_index;
  @if $layout_grid_global_container === false {
    @if $layout_grid_width !== 'auto' {
      width: $layout_grid_width;
    }
    @unless $layout_grid_max_width?? {
      max-width: $layout_grid_max_width;
    }
  }
  @unless $layout_grid_margin?? {
    margin: $layout_grid_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $layout_grid_padding?? {
    padding: $layout_grid_padding;
  }
  font-size: $layout_grid_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el.x-grid:hover,
.$_el.x-grid[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-grid {
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

@if $layout_grid_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-grid',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'layout_grid_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $layout_grid_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-grid',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'layout_grid_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-grid',
  'children' => [],
) );

?>



<?php

// Responsive Styles
// =============================================================================

?>

@media (max-width: 479.98px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_xs;
    grid-template-rows: $layout_grid_template_rows_xs;
  }
}

@media (min-width: 480px) and (max-width: 766.98px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_sm;
    grid-template-rows: $layout_grid_template_rows_sm;
  }
}

@media (min-width: 767px) and (max-width: 978.98px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_md;
    grid-template-rows: $layout_grid_template_rows_md;
  }
}

@media (min-width: 979px) and (max-width: 1199.98px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_lg;
    grid-template-rows: $layout_grid_template_rows_lg;
  }
}

@media (min-width: 1200px) {
  .$_el.x-grid {
    grid-template-columns: $layout_grid_template_columns_xl;
    grid-template-rows: $layout_grid_template_rows_xl;
  }
}

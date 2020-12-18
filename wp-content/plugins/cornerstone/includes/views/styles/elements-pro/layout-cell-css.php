<?php

// =============================================================================
// LAYOUT-CELL-CSS.PHP
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
  'width'  => 'layout_cell_border_width',
  'style'  => 'layout_cell_border_style',
  'base'   => 'layout_cell_border_color',
  'alt'    => 'layout_cell_border_color_alt',
  'radius' => 'layout_cell_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'layout_cell_bg_color',
  'alt'  => 'layout_cell_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'layout_cell_box_shadow_dimensions',
  'base'       => 'layout_cell_box_shadow_color',
  'alt'        => 'layout_cell_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-cell {
  @if $layout_cell_overflow !== 'visible' {
    overflow: $layout_cell_overflow;
  }
  @if $layout_cell_flexbox {
    display: flex;
    flex-direction: $layout_cell_flex_direction;
    justify-content: $layout_cell_flex_justify;
    align-items: $layout_cell_flex_align;
    @if $layout_cell_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $layout_cell_flex_align;
    }
  }
  z-index: $layout_cell_z_index;
  @if $layout_cell_width !== 'auto' {
    width: $layout_cell_width;
  }
  @unless $layout_cell_min_width?? {
    min-width: $layout_cell_min_width;
  }
  @unless $layout_cell_max_width?? {
    max-width: $layout_cell_max_width;
  }
  @if $layout_cell_height !== 'auto' {
    height: $layout_cell_height;
  }
  @unless $layout_cell_min_height?? {
    min-height: $layout_cell_min_height;
  }
  @unless $layout_cell_max_height?? {
    max-height: $layout_cell_max_height;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $layout_cell_padding?? {
    padding: $layout_cell_padding;
  }
  font-size: $layout_cell_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el.x-cell:hover,
.$_el.x-cell[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-cell {
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

@if $layout_cell_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-cell',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'layout_cell_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $layout_cell_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-cell',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'layout_cell_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-cell',
  'children' => [],
) );

?>



<?php

// Responsive Styles
// =============================================================================

?>

@media (max-width: 479.98px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_xs !== '' { grid-column-start: $layout_cell_column_start_xs; }
    @if $layout_cell_column_end_xs !== '' { grid-column-end: $layout_cell_column_end_xs; }
    @if $layout_cell_row_start_xs !== '' { grid-row-start: $layout_cell_row_start_xs; }
    @if $layout_cell_row_end_xs !== '' { grid-row-end: $layout_cell_row_end_xs; }
    @if $layout_cell_justify_self_xs !== 'auto' { justify-self: $layout_cell_justify_self_xs; }
    @if $layout_cell_align_self_xs !== 'auto' { align-self: $layout_cell_align_self_xs; }
  }
}

@media (min-width: 480px) and (max-width: 766.98px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_sm !== '' { grid-column-start: $layout_cell_column_start_sm; }
    @if $layout_cell_column_end_sm !== '' { grid-column-end: $layout_cell_column_end_sm; }
    @if $layout_cell_row_start_sm !== '' { grid-row-start: $layout_cell_row_start_sm; }
    @if $layout_cell_row_end_sm !== '' { grid-row-end: $layout_cell_row_end_sm; }
    @if $layout_cell_justify_self_sm !== 'auto' { justify-self: $layout_cell_justify_self_sm; }
    @if $layout_cell_align_self_sm !== 'auto' { align-self: $layout_cell_align_self_sm; }
  }
}

@media (min-width: 767px) and (max-width: 978.98px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_md !== '' { grid-column-start: $layout_cell_column_start_md; }
    @if $layout_cell_column_end_md !== '' { grid-column-end: $layout_cell_column_end_md; }
    @if $layout_cell_row_start_md !== '' { grid-row-start: $layout_cell_row_start_md; }
    @if $layout_cell_row_end_md !== '' { grid-row-end: $layout_cell_row_end_md; }
    @if $layout_cell_justify_self_md !== 'auto' { justify-self: $layout_cell_justify_self_md; }
    @if $layout_cell_align_self_md !== 'auto' { align-self: $layout_cell_align_self_md; }
  }
}

@media (min-width: 979px) and (max-width: 1199.98px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_lg !== '' { grid-column-start: $layout_cell_column_start_lg; }
    @if $layout_cell_column_end_lg !== '' { grid-column-end:   $layout_cell_column_end_lg; }
    @if $layout_cell_row_start_lg !== '' { grid-row-start:    $layout_cell_row_start_lg; }
    @if $layout_cell_row_end_lg !== '' { grid-row-end: $layout_cell_row_end_lg; }
    @if $layout_cell_justify_self_lg !== 'auto' { justify-self: $layout_cell_justify_self_lg; }
    @if $layout_cell_align_self_lg !== 'auto' { align-self:   $layout_cell_align_self_lg; }
  }
}

@media (min-width: 1200px) {
  .$_el.x-cell {
    @if $layout_cell_column_start_xl !== '' { grid-column-start: $layout_cell_column_start_xl; }
    @if $layout_cell_column_end_xl !== '' { grid-column-end: $layout_cell_column_end_xl;   }
    @if $layout_cell_row_start_xl !== '' { grid-row-start: $layout_cell_row_start_xl;    }
    @if $layout_cell_row_end_xl !== ''{ grid-row-end: $layout_cell_row_end_xl; }
    @if $layout_cell_justify_self_xl !== 'auto' { justify-self: $layout_cell_justify_self_xl; }
    @if $layout_cell_align_self_xl !== 'auto' { align-self: $layout_cell_align_self_xl; }
  }
}

<?php

// =============================================================================
// LAYOUT-ROW-CSS.PHP
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
//   06. Columns
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'layout_row_border_width',
  'style'  => 'layout_row_border_style',
  'base'   => 'layout_row_border_color',
  'alt'    => 'layout_row_border_color_alt',
  'radius' => 'layout_row_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'layout_row_bg_color',
  'alt'  => 'layout_row_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'layout_row_box_shadow_dimensions',
  'base'       => 'layout_row_box_shadow_color',
  'alt'        => 'layout_row_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-row {
  @if $layout_row_overflow !== 'visible' {
    overflow: $layout_row_overflow;
  }
  z-index: $layout_row_z_index;
  @if $layout_row_global_container === false {
    @if $layout_row_width !== 'auto' {
      width: $layout_row_width;
    }
    @unless $layout_row_max_width?? {
      max-width: $layout_row_max_width;
    }
  }
  @unless $layout_row_margin?? {
    margin: $layout_row_margin;
  }
  @if $layout_row_margin?? {
    margin-left: auto;
    margin-right: auto;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @if $layout_row_padding?? {
    padding: 1px;
  }
  @unless $layout_row_padding?? {
    padding: $layout_row_padding;
  }
  font-size: $layout_row_base_font_size;
  @unless $layout_row_text_align?? {
    text-align: $layout_row_text_align;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el > .x-row-inner {
  @if $layout_row_reverse === false {
    flex-direction: row;
  }
  @if $layout_row_reverse === true {
    flex-direction: row-reverse;
  }
  justify-content: $layout_row_flex_justify;
  align-items: $layout_row_flex_align;
  align-content: $layout_row_flex_align;
  @if $layout_row_padding?? {
    margin: calc((($layout_row_gap_row / 2) + 1px) * -1) calc((($layout_row_gap_column / 2) + 1px) * -1);
  }
  @unless $layout_row_padding?? {
    margin: calc(($layout_row_gap_row / 2) * -1) calc(($layout_row_gap_column / 2) * -1);
  }
}

.$_el.x-row:hover,
.$_el.x-row[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-row {
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

@if $layout_row_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-row',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'layout_row_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $layout_row_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-row',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'layout_row_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-row',
  'children' => [],
) );

?>



<?php

// Responsive Styles
// =============================================================================

?>

@media (max-width: 479.98px) {
  @each-nth-child $size, $index in $layout_row_layout_xs {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 480px) and (max-width: 766.98px) {
  @each-nth-child $size, $index in $layout_row_layout_sm {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 767px) and (max-width: 978.98px) {
  @each-nth-child $size, $index in $layout_row_layout_md {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 979px) and (max-width: 1199.98px) {
  @each-nth-child $size, $index in $layout_row_layout_lg {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}

@media (min-width: 1200px) {
  @each-nth-child $size, $index in $layout_row_layout_xl {
    .$_el > .x-row-inner > *:nth-child($index) {
      flex-basis: calc($size - $layout_row_gap_column);
    }
  }
}



<?php

// Columns
// =============================================================================

?>

.$_el > .x-row-inner > * {
  @if $layout_row_grow === true {
    flex-grow: 1;
  }
  margin: calc($layout_row_gap_row / 2) calc($layout_row_gap_column / 2);
}

<?php

// =============================================================================
// PAGINATION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Items
//   04. Current
//   05. Dots
//   06. Prev / Next
//   07. Responsive
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'pagination_border_width',
  'style'  => 'pagination_border_style',
  'base'   => 'pagination_border_color',
  'radius' => 'pagination_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'pagination_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'pagination_box_shadow_dimensions',
  'base'       => 'pagination_box_shadow_color',
);


// Items
// -----

$data_items_border = array(
  'width'  => 'pagination_items_border_width',
  'style'  => 'pagination_items_border_style',
  'base'   => 'pagination_items_border_color',
  'alt'    => 'pagination_items_border_color_alt',
  'radius' => 'pagination_items_border_radius',
);

$data_items_color = array(
  'type' => 'color',
  'base' => 'pagination_items_text_color',
  'alt'  => 'pagination_items_text_color_alt',
);

$data_items_background_color = array(
  'type' => 'background',
  'base' => 'pagination_items_bg_color',
  'alt'  => 'pagination_items_bg_color_alt',
);

$data_items_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'pagination_items_box_shadow_dimensions',
  'base'       => 'pagination_items_box_shadow_color',
  'alt'        => 'pagination_items_box_shadow_color_alt',
);


// Current
// -------

$data_current_border = array(
  'width'      => 'pagination_items_border_width',
  'style'      => 'pagination_items_border_style',
  'base'       => 'pagination_current_border_color',
  'color_only' => true,
);

$data_current_box_shadow = array(
  'type'              => 'box',
  'dimensions'        => 'pagination_items_box_shadow_dimensions',
  'base'              => 'pagination_current_box_shadow_color',
  'no_alt_allow_none' => true,
);


// Dots
// ----

$data_dots_border = array(
  'width'      => 'pagination_items_border_width',
  'style'      => 'pagination_items_border_style',
  'base'       => 'pagination_dots_border_color',
  'color_only' => true,
);

$data_dots_box_shadow = array(
  'type'              => 'box',
  'dimensions'        => 'pagination_items_box_shadow_dimensions',
  'base'              => 'pagination_dots_box_shadow_color',
  'no_alt_allow_none' => true,
);


// Prev / Next
// -----------

$data_prev_next_border = array(
  'width'      => 'pagination_items_border_width',
  'style'      => 'pagination_items_border_style',
  'base'       => 'pagination_prev_next_border_color',
  'color_only' => true,
);

$data_prev_next_box_shadow = array(
  'type'              => 'box',
  'dimensions'        => 'pagination_items_box_shadow_dimensions',
  'base'              => 'pagination_prev_next_box_shadow_color',
  'no_alt_allow_none' => true,
);

$data_prev_next_alt_border = array(
  'width'      => 'pagination_items_border_width',
  'style'      => 'pagination_items_border_style',
  'base'       => 'pagination_prev_next_border_color_alt',
  'color_only' => true,
);

$data_prev_next_alt_box_shadow = array(
  'type'              => 'box',
  'dimensions'        => 'pagination_items_box_shadow_dimensions',
  'base'              => 'pagination_prev_next_box_shadow_color_alt',
  'no_alt_allow_none' => true,
);



// Base
// =============================================================================

?>

.$_el.x-paginate {
  @if $pagination_width !== 'auto' {
    width: $pagination_width;
  }
  @unless $pagination_max_width?? {
    max-width: $pagination_max_width;
  }
  @unless $pagination_margin?? {
    margin: $pagination_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $pagination_padding?? {
    padding: $pagination_padding;
  }
  @if $pagination_base_font_size !== '1em' {
    font-size: $pagination_base_font_size;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el .x-paginate-inner {
  justify-content: $pagination_flex_justify;
  @unless $pagination_items_gap?? {
    margin-right: calc($pagination_items_gap * -1);
    margin-bottom: calc($pagination_items_gap * -1);
  }
}



<?php

// Items
// =============================================================================

?>

.$_el .x-paginate-inner > * {
  @if $pagination_items_grow === true {
    flex-grow: 1;
    flex-basis: 0%;
  }
  min-width: $pagination_items_min_width;
  min-height: $pagination_items_min_height;
  @unless $pagination_items_gap?? {
    margin-right: $pagination_items_gap;
    margin-bottom: $pagination_items_gap;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_items_border ); ?>
  @unless $pagination_items_padding?? {
    padding: $pagination_items_padding;
  }
  font-family: $pagination_items_font_family;
  font-size: $pagination_items_font_size;
  @if $pagination_items_font_style !== 'normal' {
    font-style: $pagination_items_font_style;
  }
  font-weight: $pagination_items_font_weight;
  <?php
  echo cs_get_partial_style( '_color-base', $data_items_color );
  echo cs_get_partial_style( '_color-base', $data_items_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_items_box_shadow );
  ?>
}

.$_el .x-paginate-inner > a:hover {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_items_color );
  echo cs_get_partial_style( '_border-alt', $data_items_border );
  echo cs_get_partial_style( '_color-alt', $data_items_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_items_box_shadow );
  ?>
}



<?php

// Current
// =============================================================================

?>

@if $pagination_numbered_hide !== 'xl' {
  .$_el .x-paginate-inner > .current {
    color: $pagination_current_text_color;
    <?php echo cs_get_partial_style( '_border-base', $data_current_border ); ?>
    background-color: $pagination_current_bg_color;
    <?php echo cs_get_partial_style( '_shadow-base', $data_current_box_shadow ); ?>
  }
}



<?php

// Dots
// =============================================================================

?>

@if $pagination_numbered_hide !== 'xl' {
  @if $pagination_dots === true {
    .$_el .x-paginate-inner > .dots {
      color: $pagination_dots_text_color;
      <?php echo cs_get_partial_style( '_border-base', $data_dots_border ); ?>
      background-color: $pagination_dots_bg_color;
      <?php echo cs_get_partial_style( '_shadow-base', $data_dots_box_shadow ); ?>
    }
  }
}



<?php

// Prev / Next
// =============================================================================

?>

@if $pagination_numbered_hide !== 'xl' {
  @if $pagination_prev_next === true {
    .$_el .x-paginate-inner > .prev,
    .$_el .x-paginate-inner > .next {
      color: $pagination_prev_next_text_color;
      <?php echo cs_get_partial_style( '_border-base', $data_prev_next_border ); ?>
      background-color: $pagination_prev_next_bg_color;
      <?php echo cs_get_partial_style( '_shadow-base', $data_prev_next_box_shadow ); ?>
    }

    .$_el .x-paginate-inner > .prev:hover,
    .$_el .x-paginate-inner > .next:hover {
      color: $pagination_prev_next_text_color_alt;
      <?php echo cs_get_partial_style( '_border-base', $data_prev_next_alt_border ); ?>
      background-color: $pagination_prev_next_bg_color_alt;
      <?php echo cs_get_partial_style( '_shadow-base', $$data_prev_next_alt_box_shadow ); ?>
    }
  }
}



<?php

// Responsive
// =============================================================================

?>

@if $pagination_numbered_hide === 'xs' {
  @media (max-width: 479.98px) {
    .$_el .x-paginate-inner > :not(.prev):not(.next) {
      display: none !important;
    }
  }
}

@if $pagination_numbered_hide === 'sm' {
  @media (max-width: 766.98px) {
    .$_el .x-paginate-inner > :not(.prev):not(.next) {
      display: none !important;
    }
  }
}

@if $pagination_numbered_hide === 'md' {
  @media (max-width: 978.98px) {
    .$_el .x-paginate-inner > :not(.prev):not(.next) {
      display: none !important;
    }
  }
}

@if $pagination_numbered_hide === 'lg' {
  @media (max-width: 1199.98px) {
    .$_el .x-paginate-inner > :not(.prev):not(.next) {
      display: none !important;
    }
  }
}

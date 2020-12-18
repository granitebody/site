<?php

// =============================================================================
// BREADCRUMBS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
//   04. List
//   05. List Items
//   06. Links
//   07. Delimiter
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'breadcrumbs_border_width',
  'style'  => 'breadcrumbs_border_style',
  'base'   => 'breadcrumbs_border_color',
  'radius' => 'breadcrumbs_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'breadcrumbs_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'breadcrumbs_box_shadow_dimensions',
  'base'       => 'breadcrumbs_box_shadow_color',
);


// Links
// -----

$data_links_border = array(
  'width'  => 'breadcrumbs_links_border_width',
  'style'  => 'breadcrumbs_links_border_style',
  'base'   => 'breadcrumbs_links_border_color',
  'alt'    => 'breadcrumbs_links_border_color_alt',
  'radius' => 'breadcrumbs_links_border_radius',
);

$data_links_color = array(
  'type' => 'color',
  'base' => 'breadcrumbs_links_color',
  'alt'  => 'breadcrumbs_links_color_alt',
);

$data_links_background_color = array(
  'type' => 'background',
  'base' => 'breadcrumbs_links_bg_color',
  'alt'  => 'breadcrumbs_links_bg_color_alt',
);

$data_links_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'breadcrumbs_links_box_shadow_dimensions',
  'base'       => 'breadcrumbs_links_box_shadow_color',
  'alt'        => 'breadcrumbs_links_box_shadow_color_alt',
);

$data_links_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'breadcrumbs_links_text_shadow_dimensions',
  'base'       => 'breadcrumbs_links_text_shadow_color',
  'alt'        => 'breadcrumbs_links_text_shadow_color_alt',
);


// Delimiter
// ---------

$data_delimiter_color = array(
  'type' => 'color',
  'base' => 'breadcrumbs_delimiter_color',
);

$data_delimiter_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'breadcrumbs_delimiter_text_shadow_dimensions',
  'base'       => 'breadcrumbs_delimiter_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-crumbs {
  @if $breadcrumbs_width !== 'auto' {
    width: $breadcrumbs_width;
  }
  @unless $breadcrumbs_max_width?? {
    max-width: $breadcrumbs_max_width;
  }
  @unless $breadcrumbs_margin?? {
    margin: $breadcrumbs_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $breadcrumbs_padding?? {
    padding: $breadcrumbs_padding;
  }
  font-family: $breadcrumbs_font_family;
  font-size: $breadcrumbs_font_size;
  font-style: $breadcrumbs_font_style;
  font-weight: $breadcrumbs_font_weight;
  line-height: $breadcrumbs_line_height;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-crumbs',
  'children' => ['.x-crumbs-link'],
) );

?>



<?php

// List
// =============================================================================

?>

.$_el .x-crumbs-list {
  @if $breadcrumbs_reverse === true {
    flex-direction: row-reverse;
  }
  justify-content: $breadcrumbs_flex_justify;
  @if $breadcrumbs_delimiter === true {
    @if $breadcrumbs_reverse === true {
      margin-right: -$breadcrumbs_delimiter_spacing !important;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: -$breadcrumbs_delimiter_spacing !important;
    }
  }
}



<?php

// List Items
// =============================================================================

?>

.$_el .x-crumbs-list-item {
  @if $breadcrumbs_delimiter === true {
    @if $breadcrumbs_reverse === true {
      margin-right: $breadcrumbs_delimiter_spacing;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: $breadcrumbs_delimiter_spacing;
    }
  }
}



<?php

// Links
// =============================================================================
// Removed from bottom of styles. Creating overflow issue since `text-overflow`
// is being used. Will need to look into a way to solve this.
//
// .$_el .x-crumbs-link span {
//   @unless $breadcrumbs_links_letter_spacing?? {
//     margin-right: calc($breadcrumbs_links_letter_spacing * -1);
//   }
// }

?>

.$_el .x-crumbs-link {
  @unless $breadcrumbs_links_max_width?? {
    max-width: $breadcrumbs_links_max_width;
  }
  @unless $breadcrumbs_links_min_width?? {
    min-width: $breadcrumbs_links_min_width;
  }
  @unless $breadcrumbs_links_margin?? {
    margin: $breadcrumbs_links_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_links_border ); ?>
  @unless $breadcrumbs_links_padding?? {
    padding: $breadcrumbs_links_padding;
  }
  @unless $breadcrumbs_letter_spacing?? {
    letter-spacing: $breadcrumbs_letter_spacing;
  }
  @unless $breadcrumbs_links_base_font_size === '1em' {
    font-size: $breadcrumbs_links_base_font_size;
  }
  font-style: $breadcrumbs_links_font_style;
  @unless $breadcrumbs_links_letter_spacing?? {
    letter-spacing: $breadcrumbs_links_letter_spacing;
  }
  line-height: $breadcrumbs_links_line_height;
  @unless $breadcrumbs_links_text_align?? {
    text-align: $breadcrumbs_links_text_align;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_links_text_shadow ); ?>
  @unless $breadcrumbs_links_text_transform?? {
    text-transform: $breadcrumbs_links_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_links_color );
  echo cs_get_partial_style( '_color-base', $data_links_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_links_box_shadow );
  ?>
}

.$_el .x-crumbs-link:hover {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_links_color );
  echo cs_get_partial_style( '_border-alt', $data_links_border );
  echo cs_get_partial_style( '_color-alt', $data_links_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_links_box_shadow );
  echo cs_get_partial_style( '_shadow-alt', $data_links_text_shadow );
  ?>
}



<?php

// Delimiter
// =============================================================================

?>

@if $breadcrumbs_delimiter === true {
  .$_el .x-crumbs-delimiter {
    @if $breadcrumbs_reverse === true {
      margin-right: $breadcrumbs_delimiter_spacing;
    }
    @if $breadcrumbs_reverse === false {
      margin-left: $breadcrumbs_delimiter_spacing;
    }
    <?php
    echo cs_get_partial_style( '_color-base', $data_delimiter_color );
    echo cs_get_partial_style( '_shadow-base', $data_delimiter_text_shadow );
    ?>
  }
}

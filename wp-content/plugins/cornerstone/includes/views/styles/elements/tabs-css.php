<?php

// =============================================================================
// TABS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Effects
//   03. Tablist
//   04. Tabs
//   05. Panels
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'tabs_border_width',
  'style'  => 'tabs_border_style',
  'base'   => 'tabs_border_color',
  'radius' => 'tabs_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'tabs_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'tabs_box_shadow_dimensions',
  'base'       => 'tabs_box_shadow_color',
);


// Base
// ----

$data_tablist_border = array(
  'width'  => 'tabs_tablist_border_width',
  'style'  => 'tabs_tablist_border_style',
  'base'   => 'tabs_tablist_border_color',
  'radius' => 'tabs_tablist_border_radius',
);

$data_tablist_background_color = array(
  'type' => 'background',
  'base' => 'tabs_tablist_bg_color',
);

$data_tablist_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'tabs_tablist_box_shadow_dimensions',
  'base'       => 'tabs_tablist_box_shadow_color',
);


// Tabs
// ----

$data_tabs_border = array(
  'width'  => 'tabs_tabs_border_width',
  'style'  => 'tabs_tabs_border_style',
  'base'   => 'tabs_tabs_border_color',
  'alt'    => 'tabs_tabs_border_color_alt',
  'radius' => 'tabs_tabs_border_radius',
);

$data_tabs_color = array(
  'type' => 'color',
  'base' => 'tabs_tabs_text_color',
  'alt'  => 'tabs_tabs_text_color_alt',
);

$data_tabs_background_color = array(
  'type' => 'background',
  'base' => 'tabs_tabs_bg_color',
  'alt'  => 'tabs_tabs_bg_color_alt',
);

$data_tabs_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'tabs_tabs_box_shadow_dimensions',
  'base'       => 'tabs_tabs_box_shadow_color',
  'alt'        => 'tabs_tabs_box_shadow_color_alt',
);

$data_tabs_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'tabs_tabs_text_shadow_dimensions',
  'base'       => 'tabs_tabs_text_shadow_color',
  'alt'        => 'tabs_tabs_text_shadow_color_alt',
);


// Panels
// ------

$data_panels_border = array(
  'width'  => 'tabs_panels_border_width',
  'style'  => 'tabs_panels_border_style',
  'base'   => 'tabs_panels_border_color',
  'radius' => 'tabs_panels_border_radius',
);

$data_panels_color = array(
  'type' => 'color',
  'base' => 'tabs_panels_text_color',
);

$data_panels_background_color = array(
  'type' => 'background',
  'base' => 'tabs_panels_bg_color',
);

$data_panels_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'tabs_panels_box_shadow_dimensions',
  'base'       => 'tabs_panels_box_shadow_color',
);

$data_panels_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'tabs_panels_text_shadow_dimensions',
  'base'       => 'tabs_panels_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-tabs {
  @if $tabs_width !== 'auto' {
    width: $tabs_width;
  }
  @unless $tabs_max_width?? {
    max-width: $tabs_max_width;
  }
  @unless $tabs_margin?? {
    margin: $tabs_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $tabs_padding?? {
    padding: $tabs_padding;
  }
  font-size: $tabs_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-tabs',
  'children' => [],
) );

?>



<?php

// Tablist
// =============================================================================

?>

.$_el .x-tabs-list {
  @unless $tabs_tablist_margin?? {
    margin: $tabs_tablist_margin;
  }
  <?php
  echo cs_get_partial_style( '_border-base', $data_tablist_border );
  echo cs_get_partial_style( '_color-base', $data_tablist_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_tablist_box_shadow );
  ?>
}

.$_el .x-tabs-list ul {
  justify-content: $tabs_tabs_justify_content;
  @unless $tabs_tablist_padding?? {
    padding: $tabs_tablist_padding;
  }
}

.$_el .x-tabs-list li {
  @unless $tabs_tabs_min_width?? {
    min-width: $tabs_tabs_min_width;
  }
  @unless $tabs_tabs_max_width?? {
    max-width: $tabs_tabs_max_width;
  }
  @if $tabs_tabs_fill_space === true {
    flex: 1 0 0%;
  }
}



<?php

// Tabs
// =============================================================================

?>

.$_el .x-tabs-list button {
  @unless $tabs_tabs_margin?? {
    margin: $tabs_tabs_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_tabs_border ); ?>
  padding: $tabs_tabs_padding;
  font-family: $tabs_tabs_font_family;
  font-size: $tabs_tabs_font_size;
  font-style: $tabs_tabs_font_style;
  font-weight: $tabs_tabs_font_weight;
  line-height: $tabs_tabs_line_height;
  @unless $tabs_tabs_letter_spacing?? {
    letter-spacing: $tabs_tabs_letter_spacing;
  }
  @unless $tabs_tabs_text_align?? {
    text-align: $tabs_tabs_text_align;
  }
  @unless $tabs_tabs_text_decoration?? {
    text-decoration: $tabs_tabs_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_tabs_text_shadow ); ?>
  @unless $tabs_tabs_text_transform?? {
    text-transform: $tabs_tabs_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_tabs_color ); ?>
  background-color: $tabs_tabs_bg_color;
  <?php echo cs_get_partial_style( '_shadow-base', $data_tabs_box_shadow ); ?>
}

.$_el .x-tabs-list button span {
  @unless $tabs_tabs_letter_spacing?? {
    margin-right: calc($tabs_tabs_letter_spacing * -1);
  }
}

.$_el .x-tabs-list button:hover,
.$_el .x-tabs-list button[class*="active"] {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_tabs_color );
  echo cs_get_partial_style( '_border-alt', $data_tabs_border );
  echo cs_get_partial_style( '_color-alt', $data_tabs_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_tabs_box_shadow );
  echo cs_get_partial_style( '_shadow-alt', $data_tabs_text_shadow );
  ?>
}



<?php

// Panels
// =============================================================================

?>

.$_el .x-tabs-panel {
  @unless $tabs_panels_margin?? {
    margin: $tabs_panels_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_panels_border ); ?>
  @unless $tabs_panels_padding?? {
    padding: $tabs_panels_padding;
  }
  font-family: $tabs_panels_font_family;
  font-size: $tabs_panels_font_size;
  font-style: $tabs_panels_font_style;
  font-weight: $tabs_panels_font_weight;
  line-height: $tabs_panels_line_height;
  @unless $tabs_panels_letter_spacing?? {
    letter-spacing: $tabs_panels_letter_spacing;
  }
  @unless $tabs_panels_text_align?? {
    text-align: $tabs_panels_text_align;
  }
  @unless $tabs_panels_text_decoration?? {
    text-decoration: $tabs_panels_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_panels_text_shadow ); ?>
  @unless $tabs_panels_text_transform?? {
    text-transform: $tabs_panels_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_panels_color );
  echo cs_get_partial_style( '_color-base', $data_panels_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_panels_box_shadow );
  ?>
}

@if $tabs_panels_equal_height === true {
  .$_el .x-tabs-panel.x-active {
    display: flex;
    flex-flow: column nowrap;
    justify-content: $tabs_panels_flex_justify;
    align-items: $tabs_panels_flex_align;
  }
}

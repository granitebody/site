<?php

// =============================================================================
// WIDGET-AREA-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'widget_area_border_width',
  'style'  => 'widget_area_border_style',
  'base'   => 'widget_area_border_color',
  'radius' => 'widget_area_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'widget_area_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'widget_area_box_shadow_dimensions',
  'base'       => 'widget_area_box_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-widget-area {
  font-size: $widget_area_base_font_size;
  @unless $widget_area_margin?? {
    margin: $widget_area_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $widget_area_padding?? {
    padding: $widget_area_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el.x-widget-area .widget:not(:first-child) {
  margin: $widget_area_spacing 0 0;
}

.$_el.x-widget-area .widget .h-widget {
  margin: 0 0 $widget_area_headline_spacing;
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-widget-area',
  'children' => [],
) );

?>

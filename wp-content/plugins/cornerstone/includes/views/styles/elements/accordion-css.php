<?php

// =============================================================================
// ACCORDION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
//   04. Item
//   05. Header
//   06. Content
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'accordion_border_width',
  'style'  => 'accordion_border_style',
  'base'   => 'accordion_border_color',
  'radius' => 'accordion_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'accordion_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'accordion_box_shadow_dimensions',
  'base'       => 'accordion_box_shadow_color',
);


// Item
// ----

$data_item_border = array(
  'width'  => 'accordion_item_border_width',
  'style'  => 'accordion_item_border_style',
  'base'   => 'accordion_item_border_color',
  'radius' => 'accordion_item_border_radius',
);

$data_item_background_color = array(
  'type' => 'background',
  'base' => 'accordion_item_bg_color',
);

$data_item_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'accordion_item_box_shadow_dimensions',
  'base'       => 'accordion_item_box_shadow_color',
);


// Header
// ------

$data_header_border = array(
  'width'  => 'accordion_header_border_width',
  'style'  => 'accordion_header_border_style',
  'base'   => 'accordion_header_border_color',
  'alt'    => 'accordion_header_border_color_alt',
  'radius' => 'accordion_header_border_radius',
);

$data_header_color = array(
  'type' => 'color',
  'base' => 'accordion_header_text_color',
  'alt'  => 'accordion_header_text_color_alt',
);

$data_header_background_color = array(
  'type' => 'background',
  'base' => 'accordion_header_bg_color',
  'alt'  => 'accordion_header_bg_color_alt',
);

$data_header_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'accordion_header_box_shadow_dimensions',
  'base'       => 'accordion_header_box_shadow_color',
  'alt'        => 'accordion_header_box_shadow_color_alt',
);

$data_header_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'accordion_header_text_shadow_dimensions',
  'base'       => 'accordion_header_text_shadow_color',
  'alt'        => 'accordion_header_text_shadow_color_alt',
);

$data_header_indicator_color = array(
  'type' => 'color',
  'base' => 'accordion_header_indicator_color',
  'alt'  => 'accordion_header_indicator_color_alt',
);


// Content
// -------

$data_content_border = array(
  'width'  => 'accordion_content_border_width',
  'style'  => 'accordion_content_border_style',
  'base'   => 'accordion_content_border_color',
  'radius' => 'accordion_content_border_radius',
);

$data_content_color = array(
  'type' => 'color',
  'base' => 'accordion_content_text_color',
);

$data_content_background_color = array(
  'type' => 'background',
  'base' => 'accordion_content_bg_color',
);

$data_content_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'accordion_content_box_shadow_dimensions',
  'base'       => 'accordion_content_box_shadow_color',
);

$data_content_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'accordion_content_text_shadow_dimensions',
  'base'       => 'accordion_content_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-acc {
  @if $accordion_width !== 'auto' {
    width: $accordion_width;
  }
  @unless $accordion_max_width?? {
    max-width: $accordion_max_width;
  }
  @unless $accordion_margin?? {
    margin: $accordion_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $accordion_padding?? {
    padding: $accordion_padding;
  }
  font-size: $accordion_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-acc',
  'children' => ['.x-acc-header', '.x-acc-header-indicator', '[data-x-toggle-collapse]'],
) );

?>



<?php

// Item
// =============================================================================

?>

.$_el.x-acc .x-acc-item {
  @if $accordion_item_overflow === true {
    overflow: hidden;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_item_border ); ?>
  @unless $accordion_item_padding?? {
    padding: $accordion_item_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_item_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_item_box_shadow );
  ?>
}

.$_el.x-acc .x-acc-item + .x-acc-item {
  margin-top: $accordion_item_spacing;
}



<?php

// Header
// =============================================================================

?>

.$_el.x-acc .x-acc-header {
  @unless $accordion_header_margin?? {
    margin: $accordion_header_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_header_border ); ?>
  @unless $accordion_header_padding?? {
    padding: $accordion_header_padding;
  }
  font-family: $accordion_header_font_family;
  font-size: $accordion_header_font_size;
  font-style: $accordion_header_font_style;
  font-weight: $accordion_header_font_weight;
  line-height: $accordion_header_line_height;
  @unless $accordion_header_letter_spacing?? {
    letter-spacing: $accordion_header_letter_spacing;
  }
  @unless $accordion_header_text_align?? {
    text-align: $accordion_header_text_align;
  }
  @unless $accordion_header_text_decoration?? {
    text-decoration: $accordion_header_text_decoration;
  }
  @unless $accordion_header_text_transform?? {
    text-transform: $accordion_header_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_shadow-base', $data_header_text_shadow );
  echo cs_get_partial_style( '_color-base', $data_header_color );
  echo cs_get_partial_style( '_color-base', $data_header_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_header_box_shadow );
  ?>
}

.$_el.x-acc .x-acc-header:hover,
.$_el.x-acc .x-acc-header[class*="active"] {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_header_color );
  echo cs_get_partial_style( '_border-alt', $data_header_border );
  echo cs_get_partial_style( '_color-alt', $data_header_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_header_box_shadow );
  echo cs_get_partial_style( '_shadow-alt', $data_header_text_shadow );
  ?>
}


<?php

// Header Content
// --------------

?>

.$_el.x-acc .x-acc-header-content {
  @if $accordion_header_content_reverse === true {
    flex-direction: row-reverse;
  }
}


<?php

// Header Indicator
// ----------------

?>

.$_el.x-acc .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    width: $accordion_header_indicator_width;
    height: $accordion_header_indicator_height;
    font-size: $accordion_header_indicator_font_size;
    <?php echo cs_get_partial_style( '_color-base', $data_header_indicator_color ); ?>
    transform: translate3d(0, 0, 0) rotate($accordion_header_indicator_rotation_start);
  }
}

.$_el.x-acc .x-acc-header:hover .x-acc-header-indicator,
.$_el.x-acc .x-acc-header[class*="active"] .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    <?php echo cs_get_partial_style( '_color-alt', $data_header_indicator_color ); ?>
  }
}

.$_el.x-acc .x-acc-header.x-active .x-acc-header-indicator {
  @if $accordion_header_indicator === true {
    transform: translate3d(0, 0, 0) rotate($accordion_header_indicator_rotation_end);
  }
}


<?php

// Header Text
// -----------

?>

.$_el.x-acc .x-acc-header-text {
  @if $accordion_header_indicator === true {
    @unless $accordion_header_content_spacing?? {
      @if $accordion_header_content_reverse === false {
        margin-left: $accordion_header_content_spacing;
      }
      @if $accordion_header_content_reverse === true {
        margin-right: $accordion_header_content_spacing;
      }
    }
  }
  @if $accordion_header_text_overflow === true {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}



<?php

// Content Inner
// =============================================================================

?>

.$_el.x-acc .x-acc-content {
  @unless $accordion_content_margin?? {
    margin: $accordion_content_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_content_border ); ?>
  @unless $accordion_content_padding?? {
    padding: $accordion_content_padding;
  }
  font-family: $accordion_content_font_family;
  font-size: $accordion_content_font_size;
  font-style: $accordion_content_font_style;
  font-weight: $accordion_content_font_weight;
  line-height: $accordion_content_line_height;
  @unless $accordion_content_letter_spacing?? {
    letter-spacing: $accordion_content_letter_spacing;
  }
  @unless $accordion_content_text_align?? {
    text-align: $accordion_content_text_align;
  }
  @unless $accordion_content_text_decoration?? {
    text-decoration: $accordion_content_text_decoration;
  }
  @unless $accordion_content_text_transform?? {
    text-transform: $accordion_content_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_shadow-base', $data_content_text_shadow );
  echo cs_get_partial_style( '_color-base', $data_content_color );
  echo cs_get_partial_style( '_color-base', $data_content_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_content_box_shadow );
  ?>
}

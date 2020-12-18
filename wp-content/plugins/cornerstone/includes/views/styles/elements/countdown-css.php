<?php

// =============================================================================
// COUNTDOWN-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Effects
//   03. Units
//   04. Number
//   05. Digit
//   06. Label
//   07. Complete
//   08. Delimiter
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'  => 'countdown_border_width',
  'style'  => 'countdown_border_style',
  'base'   => 'countdown_border_color',
  'radius' => 'countdown_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'countdown_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'countdown_box_shadow_dimensions',
  'base'       => 'countdown_box_shadow_color',
);


// Units
// -----

$data_unit_border = array(
  'width'  => 'countdown_unit_border_width',
  'style'  => 'countdown_unit_border_style',
  'base'   => 'countdown_unit_border_color',
  'radius' => 'countdown_unit_border_radius',
);

$data_unit_background_color = array(
  'type' => 'background',
  'base' => 'countdown_unit_bg_color',
);

$data_unit_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'countdown_unit_box_shadow_dimensions',
  'base'       => 'countdown_unit_box_shadow_color',
);


// Number
// ------

$data_number_border = array(
  'width'  => 'countdown_number_border_width',
  'style'  => 'countdown_number_border_style',
  'base'   => 'countdown_number_border_color',
  'radius' => 'countdown_number_border_radius',
);

$data_number_background_color = array(
  'type' => 'background',
  'base' => 'countdown_number_bg_color',
);

$data_number_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'countdown_number_box_shadow_dimensions',
  'base'       => 'countdown_number_box_shadow_color',
);


// Digit
// -----

$data_digit_border = array(
  'width'  => 'countdown_digit_border_width',
  'style'  => 'countdown_digit_border_style',
  'base'   => 'countdown_digit_border_color',
  'radius' => 'countdown_digit_border_radius',
);

$data_digit_color = array(
  'type' => 'color',
  'base' => 'countdown_digit_text_color',
);

$data_digit_background_color = array(
  'type' => 'background',
  'base' => 'countdown_digit_bg_color',
);

$data_digit_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'countdown_digit_box_shadow_dimensions',
  'base'       => 'countdown_digit_box_shadow_color',
);

$data_digit_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'countdown_digit_text_shadow_dimensions',
  'base'       => 'countdown_digit_text_shadow_color',
);


// Label
// -----

$data_label_color = array(
  'type' => 'color',
  'base' => 'countdown_label_text_color',
);

$data_label_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'countdown_label_text_shadow_dimensions',
  'base'       => 'countdown_label_text_shadow_color',
);


// Complete
// --------

$data_complete_color = array(
  'type' => 'color',
  'base' => 'countdown_complete_text_color',
);

$data_complete_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'countdown_complete_text_shadow_dimensions',
  'base'       => 'countdown_complete_text_shadow_color',
);


// Delimiter
// ---------

$data_delimiter_color = array(
  'type' => 'color',
  'base' => 'countdown_delimiter_text_color',
);

$data_delimiter_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'countdown_delimiter_text_shadow_dimensions',
  'base'       => 'countdown_delimiter_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-countdown {
  @if $countdown_width !== 'auto' {
    width: $countdown_width;
  }
  @unless $countdown_max_width?? {
    max-width: $countdown_max_width;
  }
  @unless $countdown_margin?? {
    margin: $countdown_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @if $countdown_padding?? {
    padding: 1px;
  }
  @unless $countdown_padding?? {
    padding: $countdown_padding;
  }
  font-size: $countdown_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-countdown',
  'children' => [],
) );

?>



<?php

// Units
// =============================================================================

?>

.$_el .x-countdown-units {
  @if $countdown_padding?? {
    margin: calc((($countdown_unit_gap_row / 2) + 1px) * -1) calc((($countdown_unit_gap_column / 2) + 1px) * -1);
  }
  @unless $countdown_padding?? {
    margin: calc(($countdown_unit_gap_row / 2) * -1) calc(($countdown_unit_gap_column / 2) * -1);
  }
}

.$_el .x-countdown-unit-content {
  @if $countdown_unit_width !== 'auto' {
    width: $countdown_unit_width;
  }
  margin: calc($countdown_unit_gap_row / 2) calc($countdown_unit_gap_column / 2);
  <?php echo cs_get_partial_style( '_border-base', $data_unit_border ); ?>
  @unless $countdown_unit_padding?? {
    padding: $countdown_unit_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_unit_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_unit_box_shadow );
  ?>
}



<?php

// Number
// =============================================================================

?>

.$_el .x-countdown-number {
  @unless $countdown_number_margin?? {
    margin: $countdown_number_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_number_border ); ?>
  @unless $countdown_number_padding?? {
    padding: $countdown_number_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_number_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_number_box_shadow );
  ?>
}



<?php

// Digit
// =============================================================================

?>

.$_el .x-countdown-digit {
  @unless $countdown_digit_margin?? {
    margin: $countdown_digit_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_digit_border ); ?>
  @unless $countdown_digit_padding?? {
    padding: $countdown_digit_padding;
  }
  font-family: $countdown_digit_font_family;
  font-size: $countdown_digit_font_size;
  font-style: $countdown_digit_font_style;
  font-weight: $countdown_digit_font_weight;
  line-height: $countdown_digit_line_height;
  @unless $countdown_digit_text_align?? {
    text-align: $countdown_digit_text_align;
  }
  @unless $countdown_digit_text_decoration?? {
    text-decoration: $countdown_digit_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_digit_text_shadow ); ?>
  @unless $countdown_digit_text_transform?? {
    text-transform: $countdown_digit_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_digit_color );
  echo cs_get_partial_style( '_color-base', $data_digit_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_digit_box_shadow );
  ?>
}



<?php

// Label
// =============================================================================

?>

.$_el .x-countdown-label {
  @unless $countdown_label_spacing?? {
    @if $countdown_labels_output === 'compact' {
      margin-left: $countdown_label_spacing;
    }
    @if $countdown_labels_output === 'top' {
      margin-bottom: $countdown_label_spacing;
    }
    @if $countdown_labels_output === 'bottom' {
      margin-top: $countdown_label_spacing;
    }
  }
  font-family: $countdown_label_font_family;
  font-size: $countdown_label_font_size;
  font-style: $countdown_label_font_style;
  font-weight: $countdown_label_font_weight;
  @unless $countdown_label_letter_spacing?? {
    letter-spacing: $countdown_label_letter_spacing;
    margin-right: calc($countdown_label_letter_spacing * -1);
  }
  line-height: $countdown_label_line_height;
  @unless $countdown_label_text_align?? {
    text-align: $countdown_label_text_align;
  }
  @unless $countdown_label_text_decoration?? {
    text-decoration: $countdown_label_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_label_text_shadow ); ?>
  @unless $countdown_label_text_transform?? {
    text-transform: $countdown_label_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_label_color ); ?>
}



<?php

// Complete
// =============================================================================

?>

.$_el .x-countdown-complete {
  font-family: $countdown_complete_font_family;
  font-size: $countdown_complete_font_size;
  font-style: $countdown_complete_font_style;
  font-weight: $countdown_complete_font_weight;
  @unless $countdown_complete_letter_spacing?? {
    letter-spacing: $countdown_complete_letter_spacing;
    margin-right: calc($countdown_complete_letter_spacing * -1);
  }
  line-height: $countdown_complete_line_height;
  @unless $countdown_complete_text_align?? {
    text-align: $countdown_complete_text_align;
  }
  @unless $countdown_complete_text_decoration?? {
    text-decoration: $countdown_complete_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_complete_text_shadow ); ?>
  @unless $countdown_complete_text_transform?? {
    text-transform: $countdown_complete_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_complete_color ); ?>
}



<?php

// Delimiter
// =============================================================================

?>

@if $countdown_delimiter === true {
  .$_el .x-countdown-unit:not(:last-child):after {
    content: "$countdown_delimiter_content";
    margin-top: $countdown_delimiter_vertical_adjustment;
    font-family: $countdown_delimiter_font_family;
    font-size: $countdown_delimiter_font_size;
    font-weight: $countdown_delimiter_font_weight;
    <?php
    echo cs_get_partial_style( '_shadow-base', $data_delimiter_text_shadow );
    echo cs_get_partial_style( '_color-base', $data_delimiter_color );
    ?>
  }
}

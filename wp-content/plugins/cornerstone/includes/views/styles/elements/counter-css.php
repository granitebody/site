<?php

// =============================================================================
// COUNTER-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Wrap
//   04. Before / After
//   05. Effects
// =============================================================================

// Setup
// =============================================================================

// Wrap
// ----

$data_wrap_color = array(
  'type' => 'color',
  'base' => 'counter_number_text_color',
);

$data_wrap_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'counter_number_text_shadow_dimensions',
  'base'       => 'counter_number_text_shadow_color',
);


// Before / After
// --------------

$data_before_after_color = array(
  'type' => 'color',
  'base' => 'counter_before_after_text_color',
);

$data_before_after_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'counter_before_after_text_shadow_dimensions',
  'base'       => 'counter_before_after_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-counter {
  @if $counter_width !== 'auto' {
    width: $counter_width;
  }
  @unless $counter_max_width?? {
    max-width: $counter_max_width;
  }
  @unless $counter_margin?? {
    margin: $counter_margin;
  }
  font-size: $counter_base_font_size;
}



<?php

// Wrap
// =============================================================================

?>

.$_el .x-counter-number-wrap {
  @if $counter_before_after === true {
    margin: $counter_number_margin;
  }
  font-family: $counter_number_font_family;
  font-size: $counter_number_font_size;
  font-style: $counter_number_font_style;
  font-weight: $counter_number_font_weight;
  line-height: $counter_number_line_height;
  @unless $counter_number_letter_spacing?? {
    letter-spacing: $counter_number_letter_spacing;
    margin-right: calc($counter_number_letter_spacing * -1);
  }
  @unless $counter_number_text_align?? {
    text-align: $counter_number_text_align;
  }
  @unless $counter_number_text_decoration?? {
    text-decoration: $counter_number_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_wrap_text_shadow ); ?>
  @unless $counter_number_text_transform?? {
    text-transform: $counter_number_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_wrap_color ); ?>
}



<?php

// Before / After
// =============================================================================

?>

@if $counter_before_after === true {
  .$_el .x-counter-before,
  .$_el .x-counter-after {
    font-family: $counter_before_after_font_family;
    font-size: $counter_before_after_font_size;
    font-style: $counter_before_after_font_style;
    font-weight: $counter_before_after_font_weight;
    line-height: $counter_before_after_line_height;
    @unless $counter_before_after_letter_spacing?? {
      letter-spacing: $counter_before_after_letter_spacing;
      margin-right: calc($counter_before_after_letter_spacing * -1);
    }
    @unless $counter_before_after_text_align?? {
      text-align: $counter_before_after_text_align;
    }
    @unless $counter_before_after_text_decoration?? {
      text-decoration: $counter_before_after_text_decoration;
    }
    <?php echo cs_get_partial_style( '_shadow-base', $data_before_after_text_shadow ); ?>
    @unless $counter_before_after_text_transform?? {
      text-transform: $counter_before_after_text_transform;
    }
    <?php echo cs_get_partial_style( '_color-base', $data_before_after_color ); ?>
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-counter',
  'children' => [],
) );

?>

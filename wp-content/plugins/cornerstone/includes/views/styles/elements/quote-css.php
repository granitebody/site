<?php

// =============================================================================
// QUOTE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
//   04. Text
//   05. Cite
//   06. Marks
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'    => 'quote_border_width',
  'style'    => 'quote_border_style',
  'base'     => 'quote_border_color',
  'radius'   => 'quote_border_radius',
  'fallback' => true,
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'quote_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'quote_box_shadow_dimensions',
  'base'       => 'quote_box_shadow_color',
);


// Text
// ----

$data_text_color = array(
  'type' => 'color',
  'base' => 'quote_text_text_color',
);

$data_text_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'quote_text_text_shadow_dimensions',
  'base'       => 'quote_text_text_shadow_color',
);


// Cite
// ----

$data_cite_border = array(
  'width'  => 'quote_cite_border_width',
  'style'  => 'quote_cite_border_style',
  'base'   => 'quote_cite_border_color',
  'radius' => 'quote_cite_border_radius',
);

$data_cite_color = array(
  'type' => 'color',
  'base' => 'quote_cite_text_color',
);

$data_cite_background_color = array(
  'type' => 'background',
  'base' => 'quote_cite_bg_color',
);

$data_cite_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'quote_cite_box_shadow_dimensions',
  'base'       => 'quote_cite_box_shadow_color',
);

$data_cite_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'quote_cite_text_shadow_dimensions',
  'base'       => 'quote_cite_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-quote {
  @if $quote_width !== 'auto' {
    width: $quote_width;
  }
  @unless $quote_max_width?? {
    max-width: $quote_max_width;
  }
  @unless $quote_margin?? {
    margin: $quote_margin;
  }
  @if $quote_margin?? {
    margin: 0;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $quote_padding?? {
    padding: $quote_padding;
  }
  @if $quote_padding?? {
    padding: 0;
  }
  font-size: $quote_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-quote',
  'children' => [],
) );

?>



<?php

// Text
// =============================================================================

?>

.$_el .x-quote-text {
  font-family: $quote_text_font_family;
  font-size: $quote_text_font_size;
  font-style: $quote_text_font_style;
  font-weight: $quote_text_font_weight;
  line-height: $quote_text_line_height;
  @unless $quote_text_letter_spacing?? {
    letter-spacing: $quote_text_letter_spacing;
  }
  @unless $quote_text_text_align?? {
    text-align: $quote_text_text_align;
  }
  @unless $quote_text_text_decoration?? {
    text-decoration: $quote_text_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_text_text_shadow ); ?>
  @unless $quote_text_text_transform?? {
    text-transform: $quote_text_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_text_color ); ?>
}



<?php

// Cite
// =============================================================================

?>

@if $quote_cite_content !== '' {

  .$_el .x-quote-cite {
    flex-direction: $quote_cite_flex_direction;
    justify-content: $quote_cite_flex_justify;
    align-items: $quote_cite_flex_align;
    @if $quote_cite_flex_wrap === true {
      flex-wrap: wrap;
      align-content: $quote_cite_flex_align;
    }
    @unless $quote_cite_margin?? {
      margin: $quote_cite_margin;
    }
    <?php echo cs_get_partial_style( '_border-base', $data_cite_border ); ?>
    @unless $quote_cite_padding?? {
      padding: $quote_cite_padding;
    }
    font-family: $quote_cite_font_family;
    font-size: $quote_cite_font_size;
    font-style: $quote_cite_font_style;
    font-weight: $quote_cite_font_weight;
    line-height: $quote_cite_line_height;
    @unless $quote_cite_letter_spacing?? {
      letter-spacing: $quote_cite_letter_spacing;
    }
    @unless $quote_cite_text_align?? {
      text-align: $quote_cite_text_align;
    }
    @unless $quote_cite_text_decoration?? {
      text-decoration: $quote_cite_text_decoration;
    }
    <?php echo cs_get_partial_style( '_shadow-base', $data_cite_text_shadow ); ?>
    @unless $quote_cite_text_transform?? {
      text-transform: $quote_cite_text_transform;
    }
    <?php
    echo cs_get_partial_style( '_color-base', $data_cite_color );
    echo cs_get_partial_style( '_color-base', $data_cite_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_cite_box_shadow );
    ?>
  }

  .$_el .x-quote-cite-text {
    @unless $quote_cite_letter_spacing?? {
      margin-right: calc($quote_cite_letter_spacing * -1);
    }
  }

  @if $quote_cite_graphic === true {

    <?php

    echo cs_get_partial_style( 'graphic', array(
      'no_base'    => true,
      'selector'   => ' .x-quote-cite-mark',
      'key_prefix' => 'quote_cite'
    ) );

    ?>

  }

  @if $quote_cite_position === 'before' {
    .$_el .x-quote-content {
      flex-direction: column-reverse;
    }
  }

}



<?php

// Marks
// =============================================================================

?>

@if $quote_marks_opening_graphic === true || $quote_marks_closing_graphic === true {
  .$_el.x-quote {
    flex-direction: $quote_marks_graphic_direction;
  }
}

@if $quote_marks_opening_graphic === true {

  .$_el .x-quote-mark-opening {
    align-self: $quote_marks_graphic_opening_align;
  }

  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base'    => true,
    'selector'   => ' .x-quote-mark-opening',
    'key_prefix' => 'quote_marks_opening'
  ) );

  ?>

}

@if $quote_marks_closing_graphic === true {

  .$_el .x-quote-mark-closing {
    align-self: $quote_marks_graphic_closing_align;
  }

  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base'    => true,
    'selector'   => ' .x-quote-mark-closing',
    'key_prefix' => 'quote_marks_closing'
  ) );

  ?>

}

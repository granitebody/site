<?php

// =============================================================================
// TESTIMONIAL-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
//   04. Content
//   05. Text
//   06. Cite
//   07. Graphic
//   08. Rating
// =============================================================================

// Setup
// =============================================================================

// Base
// ----

$data_border = array(
  'width'    => 'testimonial_border_width',
  'style'    => 'testimonial_border_style',
  'base'     => 'testimonial_border_color',
  'radius'   => 'testimonial_border_radius',
  'fallback' => true,
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'testimonial_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'testimonial_box_shadow_dimensions',
  'base'       => 'testimonial_box_shadow_color',
);


// Content
// -------

$data_content_border = array(
  'width'  => 'testimonial_content_border_width',
  'style'  => 'testimonial_content_border_style',
  'base'   => 'testimonial_content_border_color',
  'radius' => 'testimonial_content_border_radius',
);

$data_content_background_color = array(
  'type' => 'background',
  'base' => 'testimonial_content_bg_color',
);

$data_content_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'testimonial_content_box_shadow_dimensions',
  'base'       => 'testimonial_content_box_shadow_color',
);


// Text
// ----

$data_text_color = array(
  'type' => 'color',
  'base' => 'testimonial_text_text_color',
);

$data_text_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'testimonial_text_text_shadow_dimensions',
  'base'       => 'testimonial_text_text_shadow_color',
);


// Cite
// ----

$data_cite_border = array(
  'width'  => 'testimonial_cite_border_width',
  'style'  => 'testimonial_cite_border_style',
  'base'   => 'testimonial_cite_border_color',
  'radius' => 'testimonial_cite_border_radius',
);

$data_cite_color = array(
  'type' => 'color',
  'base' => 'testimonial_cite_text_color',
);

$data_cite_background_color = array(
  'type' => 'background',
  'base' => 'testimonial_cite_bg_color',
);

$data_cite_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'testimonial_cite_box_shadow_dimensions',
  'base'       => 'testimonial_cite_box_shadow_color',
);

$data_cite_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'testimonial_cite_text_shadow_dimensions',
  'base'       => 'testimonial_cite_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-testimonial {
  flex-direction: $testimonial_graphic_flex_direction;
  align-items: $testimonial_graphic_flex_align;
  @if $testimonial_width !== 'auto' {
    width: $testimonial_width;
  }
  @unless $testimonial_max_width?? {
    max-width: $testimonial_max_width;
  }
  @unless $testimonial_margin?? {
    margin: $testimonial_margin;
  }
  @if $testimonial_margin?? {
    margin: 0;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $testimonial_padding?? {
    padding: $testimonial_padding;
  }
  @if $testimonial_padding?? {
    padding: 0;
  }
  font-size: $testimonial_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-testimonial',
  'children' => [],
) );

?>



<?php

// Content
// =============================================================================

?>

.$_el .x-testimonial-content {
  @unless $testimonial_content_margin?? {
    margin: $testimonial_content_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_content_border ); ?>
  @unless $testimonial_content_padding?? {
    padding: $testimonial_content_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_content_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_content_box_shadow );
  ?>
}



<?php

// Text
// =============================================================================

?>

.$_el .x-testimonial-text {
  font-family: $testimonial_text_font_family;
  font-size: $testimonial_text_font_size;
  font-style: $testimonial_text_font_style;
  font-weight: $testimonial_text_font_weight;
  line-height: $testimonial_text_line_height;
  @unless $testimonial_text_letter_spacing?? {
    letter-spacing: $testimonial_text_letter_spacing;
  }
  @unless $testimonial_text_text_align?? {
    text-align: $testimonial_text_text_align;
  }
  @unless $testimonial_text_text_decoration?? {
    text-decoration: $testimonial_text_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_text_text_shadow ); ?>
  @unless $testimonial_text_text_transform?? {
    text-transform: $testimonial_text_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_text_color ); ?>
}



<?php

// Cite
// =============================================================================

?>

@if $testimonial_cite_content !== '' || $testimonial_graphic === true || $testimonial_rating === true {

  .$_el .x-testimonial-cite {
    flex-direction: $testimonial_graphic_flex_direction;
    align-items: $testimonial_graphic_flex_align;
    align-self: $testimonial_cite_align_self;
    @if $testimonial_cite_position === 'before' {
      margin-bottom: $testimonial_cite_spacing;
    }
    @if $testimonial_cite_position === 'after' {
      margin-top: $testimonial_cite_spacing;
    }
    <?php echo cs_get_partial_style( '_border-base', $data_cite_border ); ?>
    @unless $testimonial_cite_padding?? {
      padding: $testimonial_cite_padding;
    }
    font-family: $testimonial_cite_font_family;
    font-size: $testimonial_cite_font_size;
    font-style: $testimonial_cite_font_style;
    font-weight: $testimonial_cite_font_weight;
    line-height: $testimonial_cite_line_height;
    @unless $testimonial_cite_letter_spacing?? {
      letter-spacing: $testimonial_cite_letter_spacing;
    }
    @unless $testimonial_cite_text_align?? {
      text-align: $testimonial_cite_text_align;
    }
    @unless $testimonial_cite_text_decoration?? {
      text-decoration: $testimonial_cite_text_decoration;
    }
    <?php echo cs_get_partial_style( '_shadow-base', $data_cite_text_shadow ); ?>
    @unless $testimonial_cite_text_transform?? {
      text-transform: $testimonial_cite_text_transform;
    }
    <?php
    echo cs_get_partial_style( '_color-base', $data_cite_color );
    echo cs_get_partial_style( '_color-base', $data_cite_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_cite_box_shadow );
    ?>
  }

  .$_el .x-testimonial-cite-text {
    @unless $testimonial_cite_letter_spacing?? {
      margin-right: calc($testimonial_cite_letter_spacing * -1);
    }
  }

  @if $testimonial_cite_position === 'before' {
    .$_el .x-testimonial-content {
      flex-direction: column-reverse;
    }
  }

}



<?php

// Graphic
// =============================================================================

?>

@if $testimonial_graphic === true {

  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base'    => true,
    'selector'   => ' .x-graphic',
    'key_prefix' => 'testimonial',
  ) );

  ?>

}



<?php

// Rating
// =============================================================================

?>

@if $testimonial_rating === true {

  <?php

  echo cs_get_partial_style( 'rating', array(
    'selector'   => ' .x-rating',
    'key_prefix' => 'testimonial',
    'as_partial' => true,
  ) );

  ?>

}

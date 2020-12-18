<?php

// =============================================================================
// _RATING-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Graphic
//   04. Text
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '.x-rating';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Base
// ----

$data_border = array(
  'width'  => $key_prefix . 'rating_border_width',
  'style'  => $key_prefix . 'rating_border_style',
  'base'   => $key_prefix . 'rating_border_color',
  'radius' => $key_prefix . 'rating_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'rating_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'rating_box_shadow_dimensions',
  'base'       => $key_prefix . 'rating_box_shadow_color',
);


// Graphic
// -------

$data_graphic_icon_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'rating_graphic_icon_color',
);


// Text
// ----

$data_text_linotype = array(
  'ff'     => $key_prefix . 'rating_font_family',
  'fsize'  => $key_prefix . 'rating_font_size',
  'fstyle' => $key_prefix . 'rating_font_style',
  'fw'     => $key_prefix . 'rating_font_weight',
  'lh'     => $key_prefix . 'rating_line_height',
  'ls'     => $key_prefix . 'rating_letter_spacing',
  'ta'     => $key_prefix . 'rating_text_align',
  'td'     => $key_prefix . 'rating_text_decoration',
  'tt'     => $key_prefix . 'rating_text_transform',
);

$data_text_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'rating_text_color',
);

$data_text_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'rating_text_shadow_dimensions',
  'base'       => $key_prefix . 'rating_text_shadow_color',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  flex-direction: $<?php echo $key_prefix; ?>rating_flex_direction;
  justify-content: $<?php echo $key_prefix; ?>rating_flex_justify;
  align-items: $<?php echo $key_prefix; ?>rating_flex_align;
  @if $<?php echo $key_prefix; ?>rating_flex_wrap === true {
    flex-wrap: wrap;
    align-content: $<?php echo $key_prefix; ?>rating_flex_align;
  }
  @if $<?php echo $key_prefix; ?>rating_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>rating_width;
  }
  @unless $<?php echo $key_prefix; ?>rating_max_width?? {
    max-width: $<?php echo $key_prefix; ?>rating_max_width;
  }
  @unless $<?php echo $key_prefix; ?>rating_margin?? {
    margin: $<?php echo $key_prefix; ?>rating_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $<?php echo $key_prefix; ?>rating_padding?? {
    padding: $<?php echo $key_prefix; ?>rating_padding;
  }
  font-size: $<?php echo $key_prefix; ?>rating_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Graphic
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-rating-graphic > * + * {
  margin-left: $<?php echo $key_prefix; ?>rating_graphic_spacing;
}

@if $<?php echo $key_prefix; ?>rating_graphic_type === 'icon' {
  .$_el<?php echo $selector; ?> .x-icon {
    <?php echo cs_get_partial_style( '_color-base', $data_graphic_icon_color ); ?>
  }
}

@if $<?php echo $key_prefix; ?>rating_graphic_type === 'image' {
  .$_el<?php echo $selector; ?> .x-image {
    max-width: $<?php echo $key_prefix; ?>rating_graphic_image_max_width;
  }
}



<?php

// Text
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>rating_text === true {
  .$_el<?php echo $selector; ?> .x-rating-text {
    @unless $<?php echo $key_prefix; ?>rating_text_margin?? {
      margin: $<?php echo $key_prefix; ?>rating_text_margin;
    }
    <?php
    echo cs_get_partial_style( '_linotype', $data_text_linotype );
    echo cs_get_partial_style( '_shadow-base', $data_text_text_shadow );
    echo cs_get_partial_style( '_color-base', $data_text_color );
    ?>
  }
}

<?php

// =============================================================================
// CARD-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Include Partial CSS
//   03. Base
//   04. Effects
//   05. Faces
//   06. Face: All
//   07. Face: Front
//   08. Face: Back
// =============================================================================

// Setup
// =============================================================================

// Faces
// -----

$data_border = array(
  'radius' => 'card_border_radius',
);


// Front
// -----

$data_front_border = array(
  'width'  => 'card_front_border_width',
  'style'  => 'card_front_border_style',
  'base'   => 'card_front_border_color',
);

$data_front_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'card_front_box_shadow_dimensions',
  'base'       => 'card_front_box_shadow_color',
);


// Back
// ----

$data_back_border = array(
  'width'  => 'card_back_border_width',
  'style'  => 'card_back_border_style',
  'base'   => 'card_back_border_color',
);

$data_back_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'card_back_box_shadow_dimensions',
  'base'       => 'card_back_box_shadow_color',
);



// Include Partial CSS
// =============================================================================

echo cs_get_partial_style( 'text', array(
  'selector'   => ' .is-front .x-text',
  'key_prefix' => 'card_front',
) );

echo cs_get_partial_style( 'text', array(
  'selector'   => ' .is-back .x-text',
  'key_prefix' => 'card_back',
) );

echo cs_get_partial_style( 'anchor', array(
  'anchor_selector' => ' .x-anchor',
  'without_effects' => true
) );



// Base
// =============================================================================
// 01. `perspective` must be placed on element wrapping `preserve-3d`.

?>

.$_el.x-card {
  font-size: $card_base_font_size;
  @unless $card_width?? {
    width: $card_width;
  }
  @unless $card_max_width?? {
    max-width: $card_max_width;
  }
  @unless $card_margin?? {
    margin: $card_margin;
  }
  perspective: $card_perspective;
}



<?php

// Effects
// =============================================================================
// Includes `.x-card-faces` Where `transform-style: preserve-3d` is applied in
// static CSS.

echo cs_get_partial_style( 'effects', array(
  'selector'        => '.x-card',
  'children'        => ['.x-card-faces'],
  'transition_base' => 750,
) );

?>



<?php

// Face: All
// =============================================================================
// 01. Where `backface-visibility: hidden` is applied in static CSS.

?>

.$_el .x-card-face {
  justify-content: $card_content_justify;
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
}



<?php

// Face: Front
// =============================================================================

?>

.$_el .x-card-face.is-front {
  <?php echo cs_get_partial_style( '_border-base', $data_front_border ); ?>
  @unless $card_front_padding?? {
    padding: $card_front_padding;
  }
  background-color: $card_front_bg_color;
  <?php echo cs_get_partial_style( '_shadow-base', $data_front_box_shadow ); ?>
}



<?php

// Face: Back
// =============================================================================

?>

.$_el .x-card-face.is-back {
  <?php echo cs_get_partial_style( '_border-base', $data_back_border ); ?>
  @unless $card_back_padding?? {
    padding: $card_back_padding;
  }
  background-color: $card_back_bg_color;
  <?php echo cs_get_partial_style( '_shadow-base', $data_back_box_shadow ); ?>
}

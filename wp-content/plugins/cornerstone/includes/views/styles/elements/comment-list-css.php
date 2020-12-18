<?php

// =============================================================================
// COMMENT-LIST-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Message
//   04. Effects
// =============================================================================

// Setup
// =============================================================================

// Message
// -------

$data_message_border = array(
  'width'  => 'comment_list_message_border_width',
  'style'  => 'comment_list_message_border_style',
  'base'   => 'comment_list_message_border_color',
  'radius' => 'comment_list_message_border_radius',
);

$data_message_color = array(
  'type' => 'color',
  'base' => 'comment_list_message_text_color',
);

$data_message_background_color = array(
  'type' => 'background',
  'base' => 'comment_list_message_bg_color',
);

$data_message_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'comment_list_message_box_shadow_dimensions',
  'base'       => 'comment_list_message_box_shadow_color',
);

$data_message_text_shadow = array(
  'type'       => 'text',
  'dimensions' => 'comment_list_message_text_shadow_dimensions',
  'base'       => 'comment_list_message_text_shadow_color',
);



// Base
// =============================================================================
// @if $comment_list_width !== 'auto' {
//   width: $comment_list_width;
// }
// @unless $comment_list_max_width?? {
//   max-width: $comment_list_max_width;
// }
// @unless $comment_list_margin?? {
//   margin: $comment_list_margin;
// }
// @unless $comment_list_border_width?? || $comment_list_border_style?? {
//   border-width: $comment_list_border_width;
//   border-style: $comment_list_border_style;
//   border-color: $comment_list_border_color;
// }
// @unless $comment_list_border_radius?? {
//   border-radius: $comment_list_border_radius;
// }
// @unless $comment_list_padding?? {
//   padding: $comment_list_padding;
// }
// background-color: $comment_list_bg_color;
// @unless $comment_list_box_shadow_dimensions?? {
//   @if $comment_list_box_shadow_color LIKE '%transparent%' {
//     box-shadow: none;
//   }
//   @unless $comment_list_box_shadow_color LIKE '%transparent%' {
//     box-shadow: $comment_list_box_shadow_dimensions $comment_list_box_shadow_color;
//   }
// }

?>

.$_el.x-comment-list {
  @unless $comment_list_margin?? {
    margin: $comment_list_margin;
  }
}



<?php

// Message
// =============================================================================

?>

@if $comment_list_messages === true {
  .$_el .x-comment-list-message {
    <?php echo cs_get_partial_style( '_border-base', $data_message_border ); ?>
    @unless $comment_list_message_padding?? {
      padding: $comment_list_message_padding;
    }
    font-family: $comment_list_message_font_family;
    font-size: $comment_list_message_font_size;
    font-style: $comment_list_message_font_style;
    font-weight: $comment_list_message_font_weight;
    line-height: $comment_list_message_line_height;
    letter-spacing: $comment_list_message_letter_spacing;
    @unless $comment_list_message_text_align?? {
      text-align: $comment_list_message_text_align;
    }
    <?php echo cs_get_partial_style( '_shadow-base', $data_message_text_shadow ); ?>
    text-transform: $comment_list_message_text_transform;
    <?php
    echo cs_get_partial_style( '_color-base', $data_message_color );
    echo cs_get_partial_style( '_color-base', $data_message_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_message_box_shadow );
    ?>
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-comment-list',
  'children' => [],
) );

?>

<?php

// =============================================================================
// COMMENT-FORM-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Effects
// =============================================================================

// Base
// =============================================================================
// @if $comment_form_width !== 'auto' {
//   width: $comment_form_width;
// }
// @unless $comment_form_max_width?? {
//   max-width: $comment_form_max_width;
// }
// @unless $comment_form_margin?? {
//   margin: $comment_form_margin;
// }
// @unless $comment_form_border_width?? || $comment_form_border_style?? {
//   border-width: $comment_form_border_width;
//   border-style: $comment_form_border_style;
//   border-color: $comment_form_border_color;
// }
// @unless $comment_form_border_radius?? {
//   border-radius: $comment_form_border_radius;
// }
// @unless $comment_form_padding?? {
//   padding: $comment_form_padding;
// }
// background-color: $comment_form_bg_color;
// @unless $comment_form_box_shadow_dimensions?? {
//   @if $comment_form_box_shadow_color LIKE '%transparent%' {
//     box-shadow: none;
//   }
//   @unless $comment_form_box_shadow_color LIKE '%transparent%' {
//     box-shadow: $comment_form_box_shadow_dimensions $comment_form_box_shadow_color;
//   }
// }

?>

.$_el.x-comment-form {
  @unless $comment_form_margin?? {
    margin: $comment_form_margin;
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-comment-form',
  'children' => [],
) );

?>

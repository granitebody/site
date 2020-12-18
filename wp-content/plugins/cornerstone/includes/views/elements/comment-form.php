<?php

// =============================================================================
// VIEWS/ELEMENTS/COMMENT-FORM.PHP
// -----------------------------------------------------------------------------
// Comment form element.
// =============================================================================

$style_id = ( isset( $style_id ) ) ? $style_id : '';
$class    = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-comment-form', $class ) )
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Prepare Args
// ------------

$args = array(
  'format'               => 'html5',
  'id_form'              => 'commentform',
  'class_container'      => 'comment-respond',
  'class_form'           => 'comment-form',
  'title_reply'          => $comment_form_title_reply_content,
  'title_reply_to'       => $comment_form_title_reply_to_content,
  'comment_notes_before' => '',
  'comment_notes_after'  => '',
  'cancel_reply_link'    => $comment_form_cancel_reply_link_content,
  'cancel_reply_before'  => '',
  'cancel_reply_after'   => '',
  'id_submit'            => 'entry-comment-submit', // 'submit'
  'class_submit'         => 'x-comment-form-submit',
  'name_submit'          => 'submit',
  'label_submit'         => $comment_form_label_submit_content,
);

if ( $comment_form_logged_in_as === false ) {
  $args['logged_in_as'] = '';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php comment_form( apply_filters( 'x_comment_form_args', $args ) ); ?>
</div>

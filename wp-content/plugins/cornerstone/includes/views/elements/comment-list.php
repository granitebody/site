<?php

// =============================================================================
// VIEWS/ELEMENTS/COMMENT-LIST.PHP
// -----------------------------------------------------------------------------
// Comment list element.
// =============================================================================

$style_id = ( isset( $style_id ) ) ? $style_id : '';
$class    = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-comment-list', $class ) )
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );

// Prepare Args
// ------------

$args = array(
  'style'             => $comment_list_style,
  // 'format'            => 'html5',
  // 'type'              => 'comment',//$comment_list_type,
  'avatar_size'       => 32,
  'short_ping'        => false,
  // 'echo'              => true,
  // 'walker'            => null,
  // 'max_depth'         => null,
  // 'end-callback'      => null,
  // 'page'              => null,
  // 'per_page'          => null,
  // 'reverse_children'  => null,
);

if ( function_exists( 'x_get_stack' ) ) {
  $args['callback'] = 'x_' . x_get_stack() . '_comment';
}

if ( $comment_list_order === 'newest' ) {
  $args['reverse_top_level'] = true;
}




// Simulate wp-comments.php to populate query
$shim_template = function() { return CS()->path('includes/views/app/shim.php'); };
add_filter( 'comments_template', $shim_template );
comments_template();
remove_filter( 'comments_template', $shim_template );

$count = intval(get_comments_number());

// Output
// ------
// 01. Comments are open, has comments.
// 02. Comments are open, no comments.
// 03. Comments are closed.

?>


<div <?php echo x_atts( $atts ); ?>>

  <?php if ( have_comments() && comments_open() && $count > 0 ) : // 01 ?>
    <<?php echo $comment_list_style; ?> class="x-comments-list">
    <?php echo wp_list_comments( $args ); ?>
    </<?php echo $comment_list_style; ?>>
  <?php endif; ?>


  <?php if ( $comment_list_messages === true ) : ?>
    <?php if ( comments_open() && $count === 0) : // 02 ?>
      <div class="x-comment-list-message">
        <?php echo $comment_list_no_comments_content; ?>
      </div>
    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() ) : // 03 ?>
      <div class="x-comment-list-message">
        <?php echo $comment_list_closed_content; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>

</div>

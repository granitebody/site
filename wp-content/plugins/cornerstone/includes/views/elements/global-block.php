<?php

// =============================================================================
// VIEWS/ELEMENTS/GLOBAL-BLOCK.PHP
// -----------------------------------------------------------------------------
// Global Block element.
// =============================================================================

$global_block_id = apply_filters( 'cs_global_block_id', $global_block_id );


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'cs-content', 'x-global-block' );
$classes[] = "x-global-block-$global_block_id";
$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Validation
// ----------

$error = false;

if ( ! $global_block_id ) {
  return;
} else {
  $current_id = (int) get_the_ID();
  $global_block_post = get_post( $global_block_id );
  if ( ! is_a($global_block_post, 'WP_Post' ) ) {
    $error = 'Unable to locate Global Block';
  } else if ( 'cs_global_block' !== $global_block_post->post_type ) {
    $error = 'The Global Block element was passed a non Global Block ID.';
  }
}


// Prevent Self Referencing
// ------------------------
// 01. If a Global block ever attempts to reference itself (even through
//     nesting) we need to abort and show an error message to avoid an
//     infinite loop.

global $cs_global_block_ancestory;

if ( ! isset( $cs_global_block_ancestory ) ) {
  $cs_global_block_ancestory = array();
}

if ( in_array( $global_block_id, $cs_global_block_ancestory, true) || $global_block_id === $current_id ) { // 01
  $error = 'Global Blocks can not reference themselves';
}


// Prepare Content
// ---------------
// 01. Start Rendering Isolation.
// 02. End Rendering Isolation.

if ( ! $error ) {

  $gb_top_level = false; // 01

  if ( ! apply_filters( '_cs_rendering_global_block', false ) ) {
    $gb_top_level = true;
    add_filter('_cs_rendering_global_block', '__return_true' );
  }

  array_push( $cs_global_block_ancestory, $global_block_id );

  $content = do_shortcode( cs_build_shortcode( 'cs_content', [
    '_p' => $global_block_id,
    'wrap' => false
  ]) ); //do_shortcode ensures classic elements are output in the preview

  array_pop( $cs_global_block_ancestory );

  $post_settings = CS()->common()->get_post_settings( $global_block_id );

  if ( apply_filters( '_cornerstone_custom_css', isset( $post_settings['custom_css'] ) ) ) {
    CS()->component('Styling')->add_styles( "$global_block_id-custom", $post_settings['custom_css'] );
  }

  if ( isset( $post_settings['custom_js'] ) && $post_settings['custom_js'] ) {
    $content .= '<script>' . $post_settings['custom_js'] . '</script>';
  }

  if ( ! $content ) {
    $error = 'This Global Block does not have any content.';
  }

  if ( $gb_top_level ) { // 02
    remove_filter('_cs_rendering_global_block', '__return_true' );

    if ( apply_filters( 'cs_is_preview', false ) ) {
      $atts['data-cs-nav-btn'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => "global-blocks/$global_block_id",
          'context' => csi18n( 'common.global-blocks.entity' )
        ),
        'label' => sprintf( csi18n( 'common.edit' ), csi18n( 'common.global-blocks.entity' ) ),
        'icon' => 'edit'
      ) );
    }

  }
}

if ( $error ) {
  $content = apply_filters( 'cs_global_block_error', "<div style=\"padding: 35px; line-height: 1.5; text-align: center; color: #000; background-color: #fff;\">$error</div>");
}



// Output
// ------

?>

<div <?php echo x_atts( apply_filters( 'cs_global_block_atts', $atts, $global_block_id ), $custom_atts ); ?>>
  <?php echo $content; ?>
</div>

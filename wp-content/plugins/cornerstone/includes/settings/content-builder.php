<?php

function cornerstone_content_builder_settings_controls($post) {

  $post_type_obj = get_post_type_object( $post->post_type );
  $controls = [];

  //
  // General
  //

  $general_controls = array();

  if ( post_type_supports( $post->post_type, 'title' ) || $post->post_type === 'cs_global_block') {
    $general_controls[] = array(
      'key' => 'general_post_title',
      'type' => 'text',
      'label' => __( 'Title', 'cornerstone' ),
    );
  }

  if ( $post->post_type !== 'cs_global_block' ) {

    $general_controls[] = array(
      'key' => 'general_post_name',
      'type' => 'text',
      'label' => __( 'Slug', 'cornerstone' ),
    );

    $general_controls[] = array(
      'key' => 'general_post_status',
      'type' => 'select',
      'label' => __( 'Status', 'cornerstone' ),
      'options' => array(
        'choices' => cs_get_post_status_choices( $post )
      ),
      'condition' => array(
        'user_can:{context}.publish' => true
      )
    );

    // // To furnish this we need an image control that saves the ID instead of URL
    // if (post_type_supports($post->post_type, 'thumbnail')) {

    // }

    if (post_type_supports($post->post_type, 'comments')) {
      $general_controls[] = array(
        'key' => 'general_allow_comments',
        'type' => 'toggle',
        'label' => __( 'Allow Comments', 'cornerstone' ),
      );
    }

    if (post_type_supports($post->post_type, 'excerpt')) {
      $general_controls[] = array(
        'key' => 'general_manual_excerpt',
        'type' => 'textarea',
        'label' => __( 'Manual Excerpt', 'cornerstone' ),
        'options' => array(
          'placeholder' => __( '(Optional) An excerpt will be derived from any paragraphs in your content. You can override this by crafting your own excerpt here, or in the WordPress post editor.', 'cornerstone' )
        )
      );
    }

    if ($post_type_obj->hierarchical) {
      $general_controls[] = array(
        'key' => 'general_post_parent',
        'type' => 'select',
        'label' => sprintf( __( 'Parent %s', 'cornerstone' ), $post_type_obj->labels->singular_name),
        'options' => array(
          'choices' => cs_get_post_parent_choices( $post )
        )
      );
    }

    if ($post->post_type === 'page') {
      $general_controls[] = array(
        'key' => 'general_page_template',
        'type' => 'select',
        'label' => __( 'Page Template', 'cornerstone' ),
        'options' => array(
          'choices' => cs_get_page_template_options($post->post_type, $post )
        )
      );
    }
  }

  $controls[] = array(
    'type'  => 'group',
    'label' => __('General', 'cornerstone'),
    'controls' => $general_controls
  );


  $controls = apply_filters('cs_builder_settings_controls', $controls, $post );

  if (apply_filters('cs_builder_settings_responsive_text', true, $post)) {
    $controls[] = array(
      'type'  => 'responsive-text',
      'key' => 'responsive_text',
      'label' => __( 'Responsive Text', 'cornerstone' )
    );
  }

  return $controls;
}


// //
// // X Settings
// //

// if (apply_filters( 'x_settings_pane', false ) && in_array($post->post_type, array( 'post', 'page', 'x-portfolio'))) {

//   $x_settings = [];

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Meta Settings', 'cornerstone' ),
//     'controls' => $x_settings
//   );
// }


// //
// // Sliders
// //

// if (apply_filters( 'x_settings_pane', false ) && ( class_exists( 'RevSlider' ) || class_exists( 'LS_Sliders' ) )) {


//   $slider_above_controls = [];
//   $slider_below_controls = [];

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Slider Settings: Above Masthead', 'cornerstone' ),
//     'controls' => $slider_above_controls
//   );

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Slider Settings: Above Masthead', 'cornerstone' ),
//     'controls' => $slider_below_controls
//   );

// }

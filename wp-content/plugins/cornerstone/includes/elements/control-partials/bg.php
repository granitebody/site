<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/BG.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_bg( $settings ) {

  // Setup
  // -----

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_' : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']       : 'bg';
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();


  // Conditions
  // ----------

  $condition_bg_lower_on       = array( 'key' => $k_pre . 'bg_lower_type', 'op' => 'NOT IN', 'value' => array( 'none', 'color' ) );
  $condition_bg_lower_color    = array( $k_pre . 'bg_lower_type' => 'color' );
  $condition_bg_lower_image    = array( $k_pre . 'bg_lower_type' => 'image' );
  $condition_bg_lower_img      = array( $k_pre . 'bg_lower_type' => 'img' );
  $condition_bg_lower_video    = array( $k_pre . 'bg_lower_type' => 'video' );
  $condition_bg_lower_custom   = array( $k_pre . 'bg_lower_type' => 'custom' );
  $condition_bg_lower_parallax = array( $condition_bg_lower_on, array( $k_pre . 'bg_lower_parallax' => true ) );

  $condition_bg_upper_on       = array( 'key' => $k_pre . 'bg_upper_type', 'op' => 'NOT IN', 'value' => array( 'none', 'color' ) );
  $condition_bg_upper_color    = array( $k_pre . 'bg_upper_type' => 'color' );
  $condition_bg_upper_image    = array( $k_pre . 'bg_upper_type' => 'image' );
  $condition_bg_upper_img      = array( $k_pre . 'bg_upper_type' => 'img' );
  $condition_bg_upper_video    = array( $k_pre . 'bg_upper_type' => 'video' );
  $condition_bg_upper_custom   = array( $k_pre . 'bg_upper_type' => 'custom' );
  $condition_bg_upper_parallax = array( $condition_bg_upper_on, array( $k_pre . 'bg_upper_parallax' => true ) );


  // Options
  // -------

  $options_bg_type = array(
    'choices' => array(
      array( 'value' => 'none',   'label' => __( 'None', '__x__' )             ),
      array( 'value' => 'color',  'label' => __( 'Color', '__x__' )            ),
      array( 'value' => 'image',  'label' => __( 'Background Image', '__x__' ) ),
      array( 'value' => 'img',    'label' => __( '<img/> Element', '__x__' )   ),
      array( 'value' => 'video',  'label' => __( 'Video', '__x__' )            ),
      array( 'value' => 'custom', 'label' => __( 'Custom', '__x__' )           ),
    )
  );

  $options_bg_image_repeat = array(
    'choices' => array(
      array( 'value' => 'no-repeat', 'label' => __( 'None', '__x__' ) ),
      array( 'value' => 'repeat-x',  'label' => __( 'X', '__x__' )    ),
      array( 'value' => 'repeat-y',  'label' => __( 'Y', '__x__' )    ),
      array( 'value' => 'repeat',    'label' => __( 'Both', '__x__' ) ),
    )
  );

  $options_bg_img_alt = array(
    // 'placeholder' => __( 'e.g. “Thing About Picture”', '__x__' ),
    'placeholder' => __( 'Describe Your Image', '__x__' ),
  );

  $options_bg_img_object_fit = array(
    'choices' => array(
      array( 'value' => 'contain',    'label' => __( 'contain', '__x__' )    ),
      array( 'value' => 'cover',      'label' => __( 'cover', '__x__' )      ),
      array( 'value' => 'fill',       'label' => __( 'fill', '__x__' )       ),
      array( 'value' => 'none',       'label' => __( 'none', '__x__' )       ),
      array( 'value' => 'scale-down', 'label' => __( 'scale-down', '__x__' ) ),
    )
  );

  $options_bg_video_placeholder = array(
    'placeholder' => 'http://example.com/a.mp4'
  );

  $options_bg_parallax_size = array(
    'available_units' => array( '%' ),
    'fallback_value'  => '150%',
    'ranges'          => array(
      '%' => array( 'min' => 100, 'max' => 250, 'step' => 5 ),
    ),
  );

  $options_bg_parallax_direction = array(
    'choices' => array(
      array( 'value' => 'v', 'icon' => 'ui:resize-ns' ),
      array( 'value' => 'h', 'icon' => 'ui:resize-ew' ),
    )
  );


  // Individual Controls (Lower)
  // ---------------------------

  $control_bg_lower_type = array(
    'key'     => $k_pre . 'bg_lower_type',
    'type'    => 'select',
    'label'   => __( 'Type', '__x__' ),
    'options' => $options_bg_type,
  );

  $control_bg_lower_color = array(
    'key'       => $k_pre . 'bg_lower_color',
    'type'      => 'color',
    'label'     => __( 'Color', '__x__' ),
    'condition' => $condition_bg_lower_color,
  );

  $control_bg_lower_image = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_image',
    ),
    'type'      => 'image',
    'label'     => __( 'Image', '__x__' ),
    'condition' => $condition_bg_lower_image,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_lower_image_repeat = array(
    'key'       => $k_pre . 'bg_lower_image_repeat',
    'type'      => 'choose',
    'label'     => __( 'Repeat', '__x__' ),
    'condition' => $condition_bg_lower_image,
    'options'   => $options_bg_image_repeat,
  );

  $control_bg_lower_image_size_and_position = array(
    'type'      => 'group',
    'label'     => __( 'Size &amp; Position', '__x__' ),
    'condition' => $condition_bg_lower_image,
    'controls'  => array(
      array(
        'key'  => $k_pre . 'bg_lower_image_size',
        'type' => 'text',
        'options' => array( 'dynamic' => false )
      ),
      array(
        'key'  => $k_pre . 'bg_lower_image_position',
        'type' => 'text',
        'options' => array( 'dynamic' => false )
      ),
    ),
  );

  $control_bg_lower_img_src = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_img_src',
    ),
    'type'      => 'image',
    'label'     => __( 'Image', '__x__' ),
    'condition' => $condition_bg_lower_img,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_lower_img_alt = array(
    'key'       => $k_pre . 'bg_lower_img_alt',
    'type'      => 'text',
    'label'     => __( 'Alt Text', '__x__' ),
    'options'   => $options_bg_img_alt,
    'condition' => $condition_bg_lower_img,
  );

  $control_bg_lower_img_size_and_position = array(
    'type'      => 'group',
    'label'     => __( 'Object Fit &amp; Position', '__x__' ),
    'condition' => $condition_bg_lower_img,
    'controls'  => array(
      array(
        'key'       => $k_pre . 'bg_lower_img_object_fit',
        'type'      => 'select',
        'options'   => $options_bg_img_object_fit,
        'condition' => $condition_bg_lower_img,
      ),
      array(
        'key'       => $k_pre . 'bg_lower_img_object_position',
        'type'      => 'text',
        'condition' => $condition_bg_lower_img,
      ),
    ),
  );

  $control_bg_lower_video = array(
    'key'       => $k_pre . 'bg_lower_video',
    'type'      => 'text',
    'label'     => __( 'Video Source', '__x__' ),
    'condition' => $condition_bg_lower_video,
    'options'   => $options_bg_video_placeholder,
  );

  $control_bg_lower_video_poster = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_video_poster',
    ),
    'type'      => 'image',
    'label'     => __( 'Poster Image', '__x__' ),
    'condition' => $condition_bg_lower_video,
    'options'   => array(
      'height' => 3
    ),
  );

  $control_bg_lower_video_loop = array(
    'key'       => $k_pre . 'bg_lower_video_loop',
    'type'      => 'choose',
    'label'     => __( 'Loop', '__x__' ),
    'condition' => $condition_bg_lower_video,
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_bg_lower_custom_content = array(
    'key'       => $k_pre . 'bg_lower_custom_content',
    'type'      => 'text-editor',
    'label'     => __( 'Content', '__x__' ),
    'condition' => $condition_bg_lower_custom,
    'options'   => array(
      'height'                => 3,
      'mode'                  => 'html',
      'no_rich_text'          => true,
      'disable_input_preview' => false,
    ),
  );

  $control_bg_lower_custom_aria_hidden = array(
    'key'       => $k_pre . 'bg_lower_custom_aria_hidden',
    'type'      => 'choose',
    'label'     => __( 'ARIA Hidden', '__x__' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_lower_custom,
  );

  $control_bg_lower_parallax = array(
    'key'       => $k_pre . 'bg_lower_parallax',
    'type'      => 'choose',
    'label'     => __( 'Parallax', '__x__' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_lower_on,
  );

  $control_bg_lower_parallax_size = array(
    'key'        => $k_pre . 'bg_lower_parallax_size',
    'type'       => 'slider',
    'label'      => __( 'Size', '__x__' ),
    'options'    => $options_bg_parallax_size,
    'conditions' => $condition_bg_lower_parallax,
  );

  $control_bg_lower_parallax_direction_and_reverse = array(
    'type'       => 'group',
    'label'      => __( 'Direction', '__x__' ),
    'conditions' => $condition_bg_lower_parallax,
    'controls'   => array(
      array(
        'key'     => $k_pre . 'bg_lower_parallax_direction',
        'type'    => 'choose',
        'options' => $options_bg_parallax_direction,
      ),
      array(
        'keys' => array(
          'lower_parallax_reverse' => $k_pre . 'bg_lower_parallax_reverse',
        ),
        'type'    => 'checkbox-list',
        'options' => array(
          'list' => array(
            array( 'key' => 'lower_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
          ),
        ),
      ),
    ),
  );


  // Individual Controls (Upper)
  // ---------------------------

  $control_bg_upper_type = array(
    'key'     => $k_pre . 'bg_upper_type',
    'type'    => 'select',
    'label'   => __( 'Type', '__x__' ),
    'options' => $options_bg_type,
  );

  $control_bg_upper_color = array(
    'key'       => $k_pre . 'bg_upper_color',
    'type'      => 'color',
    'label'     => __( 'Color', '__x__' ),
    'condition' => $condition_bg_upper_color,
  );

  $control_bg_upper_image = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_image',
    ),
    'type'      => 'image',
    'label'     => __( 'Image', '__x__' ),
    'condition' => $condition_bg_upper_image,
    'options'   => array(
      'height' => 2
    ),
  );

  $control_bg_upper_image_repeat = array(
    'key'       => $k_pre . 'bg_upper_image_repeat',
    'type'      => 'choose',
    'label'     => __( 'Repeat', '__x__' ),
    'condition' => $condition_bg_upper_image,
    'options'   => $options_bg_image_repeat,
  );

  $control_bg_upper_image_size_and_position = array(
    'type'      => 'group',
    'label'     => __( 'Size &amp; Position', '__x__' ),
    'condition' => $condition_bg_upper_image,
    'controls'  => array(
      array(
        'key'  => $k_pre . 'bg_upper_image_size',
        'type' => 'text',
        'options' => array( 'dynamic' => false )
      ),
      array(
        'key'  => $k_pre . 'bg_upper_image_position',
        'type' => 'text',
        'options' => array( 'dynamic' => false )
      ),
    ),
  );

  $control_bg_upper_img_src = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_img_src',
    ),
    'type'      => 'image',
    'label'     => __( 'Image', '__x__' ),
    'condition' => $condition_bg_upper_img,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_upper_img_alt = array(
    'key'       => $k_pre . 'bg_upper_img_alt',
    'type'      => 'text',
    'label'     => __( 'Alt Text', '__x__' ),
    'options'   => $options_bg_img_alt,
    'condition' => $condition_bg_upper_img,
  );

  $control_bg_upper_img_size_and_position = array(
    'type'      => 'group',
    'label'     => __( 'Object Fit &amp; Position', '__x__' ),
    'condition' => $condition_bg_upper_img,
    'controls'  => array(
      array(
        'key'       => $k_pre . 'bg_upper_img_object_fit',
        'type'      => 'select',
        'options'   => $options_bg_img_object_fit,
        'condition' => $condition_bg_upper_img,
      ),
      array(
        'key'       => $k_pre . 'bg_upper_img_object_position',
        'type'      => 'text',
        'condition' => $condition_bg_upper_img,
      ),
    ),
  );

  $control_bg_upper_video = array(
    'key'       => $k_pre . 'bg_upper_video',
    'type'      => 'text',
    'label'     => __( 'Video Source', '__x__' ),
    'condition' => $condition_bg_upper_video,
    'options'   => $options_bg_video_placeholder,
  );

  $control_bg_upper_video_poster = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_video_poster',
    ),
    'type'      => 'image',
    'label'     => __( 'Poster Image', '__x__' ),
    'condition' => $condition_bg_upper_video,
    'options'   => array(
      'height' => 3
    )
  );

  $control_bg_upper_video_loop = array(
    'key'       => $k_pre . 'bg_upper_video_loop',
    'type'      => 'choose',
    'label'     => __( 'Loop', '__x__' ),
    'condition' => $condition_bg_upper_video,
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_bg_upper_custom_content = array(
    'key'       => $k_pre . 'bg_upper_custom_content',
    'type'      => 'text-editor',
    'label'     => __( 'Content', '__x__' ),
    'condition' => $condition_bg_upper_custom,
    'options'   => array(
      'height'                => 3,
      'mode'                  => 'html',
      'no_rich_text'          => true,
      'disable_input_preview' => false,
    ),
  );

  $control_bg_upper_custom_aria_hidden = array(
    'key'       => $k_pre . 'bg_upper_custom_aria_hidden',
    'type'      => 'choose',
    'label'     => __( 'ARIA Hidden', '__x__' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_upper_custom,
  );

  $control_bg_upper_parallax = array(
    'key'       => $k_pre . 'bg_upper_parallax',
    'type'      => 'choose',
    'label'     => __( 'Parallax', '__x__' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_upper_on,
  );

  $control_bg_upper_parallax_size = array(
    'key'        => $k_pre . 'bg_upper_parallax_size',
    'type'       => 'slider',
    'label'      => __( 'Size', '__x__' ),
    'options'    => $options_bg_parallax_size,
    'conditions' => $condition_bg_upper_parallax,
  );

  $control_bg_upper_parallax_direction_and_reverse = array(
    'type'       => 'group',
    'label'      => __( 'Direction', '__x__' ),
    'conditions' => $condition_bg_upper_parallax,
    'controls'   => array(
      array(
        'key'     => $k_pre . 'bg_upper_parallax_direction',
        'type'    => 'choose',
        'options' => $options_bg_parallax_direction,
      ),
      array(
        'keys' => array(
          'upper_parallax_reverse' => $k_pre . 'bg_upper_parallax_reverse',
        ),
        'type'    => 'checkbox-list',
        'options' => array(
          'list' => array(
            array( 'key' => 'upper_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
          ),
        ),
      ),
    ),
  );


  // Control Groups (Advanced)
  // -------------------------

  $control_group_bg_adv_lower_layer = array(
    'type'       => 'group',
    'label'      => __( '{{prefix}} Background Lower Layer', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => array(
      $control_bg_lower_type,
      $control_bg_lower_color,
      $control_bg_lower_image,
      $control_bg_lower_image_repeat,
      $control_bg_lower_image_size_and_position,
      $control_bg_lower_img_src,
      $control_bg_lower_img_alt,
      $control_bg_lower_img_size_and_position,
      $control_bg_lower_video,
      $control_bg_lower_video_poster,
      $control_bg_lower_video_loop,
      $control_bg_lower_custom_content,
      $control_bg_lower_custom_aria_hidden,
      $control_bg_lower_parallax,
      $control_bg_lower_parallax_size,
      $control_bg_lower_parallax_direction_and_reverse,
    ),
  );

  $control_group_bg_adv_upper_layer = array(
    'type'       => 'group',
    'label'      => __( '{{prefix}} Background Upper Layer', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => array(
      $control_bg_upper_type,
      $control_bg_upper_color,
      $control_bg_upper_image,
      $control_bg_upper_image_repeat,
      $control_bg_upper_image_size_and_position,
      $control_bg_upper_img_src,
      $control_bg_upper_img_alt,
      $control_bg_upper_img_size_and_position,
      $control_bg_upper_video,
      $control_bg_upper_video_poster,
      $control_bg_upper_video_loop,
      $control_bg_upper_custom_content,
      $control_bg_upper_custom_aria_hidden,
      $control_bg_upper_parallax,
      $control_bg_upper_parallax_size,
      $control_bg_upper_parallax_direction_and_reverse,
    ),
  );


  // Control Groups (Standard Design)
  // --------------------------------

  $control_group_bg_std_lower_layer = array(
    'type'       => 'group',
    'label'      => __( '{{prefix}} Background Lower Layer', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'conditions' => array_merge(
      $conditions,
      array( array( 'key' => $k_pre . 'bg_lower_type', 'op' => '!=', 'value' => 'none' ) )
    ),
    'controls'   => array(
      $control_bg_lower_color,
      cs_amend_control( $control_bg_lower_image, array( 'options' => array( 'height' => 5 ) ) ),
      $control_bg_lower_video,
      cs_amend_control( $control_bg_lower_video_poster, array( 'options' => array( 'height' => 4 ) ) )
    ),
  );

  $control_group_bg_std_upper_layer = array(
    'type'       => 'group',
    'label'      => __( '{{prefix}} Background Upper Layer', '__x__' ),
    'label_vars' => array( 'prefix' => $label_prefix ),
    'conditions' => array_merge(
      $conditions,
      array( array( 'key' => $k_pre . 'bg_upper_type', 'op' => '!=', 'value' => 'none' ) )
    ),
    'controls'   => array(
      $control_bg_upper_color,
      cs_amend_control( $control_bg_upper_image, array( 'options' => array( 'height' => 5 ) ) ),
      $control_bg_upper_video,
      cs_amend_control( $control_bg_upper_video_poster, array( 'options' => array( 'height' => 4 ) ) ),
    ),
  );


  // Compose Controls
  // ----------------

  return array(
    'controls' => array(
      $control_group_bg_adv_lower_layer,
      $control_group_bg_adv_upper_layer,
      $control_group_bg_adv_parallax,
      cs_control( 'border-radius', $k_pre . 'bg', array(
        'label_prefix' => __( 'Background', '__x__' ),
        'group'        => $group,
        'conditions'   => $conditions,
      ) )
    ),
    'controls_std_content' => array(),
    'controls_std_design_setup' => array(
      $control_group_bg_std_lower_layer,
      $control_group_bg_std_upper_layer
    ),
    'controls_std_design_colors' => array(),
  );

}

cs_register_control_partial( 'bg', 'x_control_partial_bg' );

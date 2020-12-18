<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-LIST.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'comment_list_type'                          => cs_value( 'all', 'markup' ),
    'comment_list_style'                         => cs_value( 'ol', 'markup' ),
    'comment_list_order'                         => cs_value( 'oldest', 'markup' ),
    'comment_list_messages'                      => cs_value( true, 'all' ),
    // 'comment_list_base_font_size'                => cs_value( '1em', 'style' ),
    // 'comment_list_width'                         => cs_value( 'auto', 'style' ),
    // 'comment_list_max_width'                     => cs_value( 'none', 'style' ),
    // 'comment_list_bg_color'                      => cs_value( 'transparent', 'style:color' ),
    'comment_list_margin'                        => cs_value( '!0em', 'style' ),
    // 'comment_list_padding'                       => cs_value( '!0em', 'style' ),
    // 'comment_list_border_width'                  => cs_value( '!0px', 'style' ),
    // 'comment_list_border_style'                  => cs_value( 'solid', 'style' ),
    // 'comment_list_border_color'                  => cs_value( 'transparent', 'style:color' ),
    // 'comment_list_border_radius'                 => cs_value( '!0px', 'style' ),
    // 'comment_list_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em', 'style' ),
    // 'comment_list_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),
    'comment_list_no_comments_content'           => cs_value( __( 'There are currently no comments. Why don\'t you kick things off?' , '__x__' ), 'markup' ),
    'comment_list_closed_content'                => cs_value( __( 'Comments are closed at this time.' , '__x__' ), 'markup' ),
    'comment_list_message_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'comment_list_message_padding'               => cs_value( '1.25em', 'style' ),
    'comment_list_message_border_width'          => cs_value( '!0px', 'style' ),
    'comment_list_message_border_style'          => cs_value( 'solid', 'style' ),
    'comment_list_message_border_color'          => cs_value( 'transparent', 'style:color' ),
    'comment_list_message_border_radius'         => cs_value( '4px', 'style' ),
    'comment_list_message_box_shadow_dimensions' => cs_value( '0em 0.65em 1.5em 0em', 'style' ),
    'comment_list_message_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'comment_list_message_font_family'           => cs_value( 'inherit', 'style:font-family' ),
    'comment_list_message_font_weight'           => cs_value( 'inherit:400', 'style:font-weight' ),
    'comment_list_message_font_size'             => cs_value( '1em', 'style' ),
    'comment_list_message_letter_spacing'        => cs_value( '0em', 'style' ),
    'comment_list_message_line_height'           => cs_value( '1.6', 'style' ),
    'comment_list_message_font_style'            => cs_value( 'normal', 'style' ),
    'comment_list_message_text_align'            => cs_value( 'center', 'style' ),
    'comment_list_message_text_decoration'       => cs_value( 'none', 'style' ),
    'comment_list_message_text_transform'        => cs_value( 'none', 'style' ),
    'comment_list_message_text_color'            => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_comment_list() {
  return x_get_view( 'styles/elements', 'comment-list', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_comment_list( $data ) {
  return x_get_view( 'elements', 'comment-list', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Comment List', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_comment_list',
  'style'   => 'x_element_style_comment_list',
  'render'  => 'x_element_render_comment_list',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_list() {

  // Groups
  // ------

  $group                = 'comment_list';
  $group_setup          = $group . ':setup';
  $group_design         = $group . ':design';
  $group_message        = $group . ':design';

  $group_message        = $group . '_message';
  $group_message_setup  = $group_message . ':setup';
  $group_message_design = $group_message . ':design';
  $group_message_text   = $group_message . ':text';


  // Conditions
  // ----------

  $condition_comment_list_messages = array( 'comment_list_messages' => true );


  // Options
  // -------

  $options_comment_list_type = array(
    'choices' => array(
      array( 'value' => 'all',       'label' => __( 'All', '__x__' )        ),
      array( 'value' => 'comment',   'label' => __( 'Comments', '__x__' )   ),
      array( 'value' => 'pingback',  'label' => __( 'Pingbacks', '__x__' )  ),
      array( 'value' => 'trackback', 'label' => __( 'Trackbacks', '__x__' ) ),
      array( 'value' => 'pings',     'label' => __( 'Pings', '__x__' )      ),
    )
  );

  $options_comment_list_style = array(
    'choices' => array(
      array( 'value' => 'ol', 'label' => '<ol>' ),
      array( 'value' => 'ul', 'label' => '<ul>' ),
    )
  );

  $options_comment_list_order = array(
    'choices' => array(
      array( 'value' => 'oldest', 'label' => __( 'Oldest', '__x__' ) ),
      array( 'value' => 'newest', 'label' => __( 'Newest', '__x__' ) ),
    )
  );

  $options_comment_list_links_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
      'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
    ),
  );

  $options_comment_list_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'auto' ),
    'fallback_value'  => 'auto',
    'ranges'          => array(
      'px'  => array( 'min' => 300, 'max' => 1200, 'step' => 10 ),
      'em'  => array( 'min' => 20,  'max' => 72,   'step' => 1  ),
      'rem' => array( 'min' => 20,  'max' => 72,   'step' => 1  ),
      '%'   => array( 'min' => 0,   'max' => 100,  'step' => 1  ),
    ),
  );

  $options_comment_list_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'none' ),
    'fallback_value'  => 'none',
    'ranges'          => array(
      'px'  => array( 'min' => 300, 'max' => 1200, 'step' => 10 ),
      'em'  => array( 'min' => 20,  'max' => 72,   'step' => 1  ),
      'rem' => array( 'min' => 20,  'max' => 72,   'step' => 1  ),
      '%'   => array( 'min' => 0,   'max' => 100,  'step' => 1  ),
    ),
  );

  $options_comment_list_no_comments_content = array(
    'height' => 2,
  );

  $options_comment_list_closed_content = array(
    'height' => 2,
  );


  // Settings
  // --------

  $settings_comment_list_design = array(
    'group' => $group_design,
  );

  $settings_comment_list_message_design = array(
    'group'     => $group_message_design,
    'condition' => $condition_comment_list_messages,
  );

  $settings_comment_list_message_text = array(
    'group'     => $group_message_text,
    'condition' => $condition_comment_list_messages,
  );


  // Individual Controls (Base)
  // --------------------------

  $control_comment_list_type = array(
    'key'     => 'comment_list_type',
    'type'    => 'select',
    'label'   => __( 'Type', '__x__' ),
    'options' => $options_comment_list_type,
  );

  $control_comment_list_style = array(
    'key'     => 'comment_list_style',
    'type'    => 'choose',
    'label'   => __( 'Markup', '__x__' ),
    'options' => $options_comment_list_style,
  );

  $control_comment_list_order = array(
    'key'     => 'comment_list_order',
    'type'    => 'choose',
    'label'   => __( 'Order By', '__x__' ),
    'options' => $options_comment_list_order,
  );

  $control_comment_list_messages = array(
    'key'     => 'comment_list_messages',
    'type'    => 'choose',
    'label'   => __( 'Messages', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_comment_list_base_font_size = array(
    'key'     => 'comment_list_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_comment_list_base_font_size,
  );

  $control_comment_list_width = array(
    'key'     => 'comment_list_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_comment_list_width,
  );

  $control_comment_list_max_width = array(
    'key'     => 'comment_list_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_comment_list_max_width,
  );


  $control_comment_list_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_comment_list_width,
      $control_comment_list_max_width,
    ),
  );

  $control_comment_list_bg_color = array(
    'keys' => array(
      'value' => 'comment_list_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Individual Controls (Message)
  // -----------------------------

  $control_comment_list_no_comments_content = array(
    'key'     => 'comment_list_no_comments_content',
    'type'    => 'textarea',
    'label'   => __( 'No Comments', '__x__' ),
    'options' => $options_comment_list_no_comments_content,
  );

  $control_comment_list_closed_content = array(
    'key'     => 'comment_list_closed_content',
    'type'    => 'textarea',
    'label'   => __( 'Closed', '__x__' ),
    'options' => $options_comment_list_closed_content,
  );

  $control_comment_list_message_bg_color = array(
    'keys' => array(
      'value' => 'comment_list_message_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(

      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => $group_setup,
          'controls' => array(
            $control_comment_list_type,
            $control_comment_list_style,
            $control_comment_list_order,
            $control_comment_list_messages,
            // $control_comment_list_base_font_size,
            // $control_comment_list_width,
            // $control_comment_list_max_width,
            // $control_comment_list_bg_color,
          ),
        ),
        cs_control( 'margin', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'padding', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'border', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'border-radius', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'box-shadow', 'comment_list', $settings_comment_list_design ),
        array(
          'type'      => 'group',
          'label'     => __( 'Setup', '__x__' ),
          'group'     => $group_message_setup,
          'condition' => $condition_comment_list_messages,
          'controls'  => array(
            $control_comment_list_no_comments_content,
            $control_comment_list_closed_content,
            $control_comment_list_message_bg_color,
          ),
        ),
        cs_control( 'padding', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'border', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'border-radius', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'box-shadow', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'text-format', 'comment_list_message', $settings_comment_list_message_text ),
      ),


      'controls_std_content' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Content Setup', '__x__' ),
          'controls' => array(

          ),
        ),
      ),


      'controls_std_design_setup' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Design Setup', '__x__' ),
          'controls' => array(

          ),
        ),
      ),


      'controls_std_design_colors' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Colors', '__x__' ),
          'controls' => array(

          ),
        ),
      ),


      'control_nav' => array(
        $group                => __( 'Comment List', '__x__' ),
        $group_setup          => __( 'Setup', '__x__' ),
        $group_design         => __( 'Design', '__x__' ),

        $group_message        => __( 'Message', '__x__' ),
        $group_message_setup  => __( 'Setup', '__x__' ),
        $group_message_design => __( 'Design', '__x__' ),
        $group_message_text   => __( 'Design', '__x__' ),
      ),

    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-list', $data );

<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-FORM.PHP
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
    'comment_form_title_reply_content'       => cs_value( __( 'Leave a Reply', '__x__' ), 'markup' ),
    'comment_form_title_reply_to_content'    => cs_value( __( 'Leave a Reply to %s', '__x__' ), 'markup' ),
    'comment_form_logged_in_as'              => cs_value( false, 'markup' ),
    'comment_form_cancel_reply_link_content' => cs_value( __( 'Cancel Reply', '__x__' ), 'markup' ),
    'comment_form_label_submit_content'      => cs_value( __( 'Submit', '__x__' ), 'markup' ),
    // 'comment_form_base_font_size'            => cs_value( '1em', 'style' ),
    // 'comment_form_width'                     => cs_value( 'auto', 'style' ),
    // 'comment_form_max_width'                 => cs_value( 'none', 'style' ),
    // 'comment_form_bg_color'                  => cs_value( 'transparent', 'style:color' ),
    'comment_form_margin'                    => cs_value( '!0em', 'style' ),
    // 'comment_form_padding'                   => cs_value( '!0em', 'style' ),
    // 'comment_form_border_width'              => cs_value( '!0px', 'style' ),
    // 'comment_form_border_style'              => cs_value( 'solid', 'style' ),
    // 'comment_form_border_color'              => cs_value( 'transparent', 'style:color' ),
    // 'comment_form_border_radius'             => cs_value( '!0px', 'style' ),
    // 'comment_form_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em', 'style' ),
    // 'comment_form_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_comment_form() {
  return x_get_view( 'styles/elements', 'comment-form', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_comment_form( $data ) {
  return x_get_view( 'elements', 'comment-form', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Comment Form', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_comment_form',
  'style'   => 'x_element_style_comment_form',
  'render'  => 'x_element_render_comment_form',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_form() {

  // Groups
  // ------

  $group        = 'comment_form';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Options
  // -------

  $options_comment_form_title_reply = array(
    'placeholder' => __( 'Leave a Reply', '__x__' )
  );

  $options_comment_form_title_reply_to = array(
    'placeholder' => __( 'Leave a Reply to %s', '__x__' )
  );

  $options_comment_form_logged_in_as = cs_recall( 'options_choices_off_on_bool' );

  $options_comment_form_cancel_reply_link_content = array(
    'placeholder' => __( 'Cancel Reply', '__x__' )
  );

  $options_comment_form_label_submit_content = array(
    'placeholder' => __( 'Submit', '__x__' )
  );

  $options_comment_form_links_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
      'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
    ),
  );

  $options_comment_form_width = array(
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

  $options_comment_form_max_width = array(
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


  // Settings
  // --------

  $settings_comment_form_design = array(
    'group' => $group_design,
  );


  // Individual Controls
  // -------------------

  $control_comment_form_title_reply_content = array(
    'key'     => 'comment_form_title_reply_content',
    'type'    => 'text',
    'label'   => __( 'Reply Title', '__x__' ),
    'options' => $options_comment_form_title_reply,
  );

  $control_comment_form_title_reply_to_content = array(
    'key'     => 'comment_form_title_reply_to_content',
    'type'    => 'text',
    'label'   => __( 'Reply To Title', '__x__' ),
    'options' => $options_comment_form_title_reply_to,
  );

  $control_comment_form_logged_in_as = array(
    'key'     => 'comment_form_logged_in_as',
    'type'    => 'choose',
    'label'   => __( 'Logged In As Label', '__x__' ),
    'options' => $options_comment_form_logged_in_as,
  );

  $control_comment_form_title_reply_to_content = array(
    'key'     => 'comment_form_title_reply_to_content',
    'type'    => 'text',
    'label'   => __( 'Reply To Title', '__x__' ),
    'options' => $options_comment_form_title_reply_to,
  );

  $control_comment_form_cancel_reply_link_content = array(
    'key'     => 'comment_form_cancel_reply_link_content',
    'type'    => 'text',
    'label'   => __( 'Cancel Reply Link', '__x__' ),
    'options' => $options_comment_form_cancel_reply_link_content,
  );

  $control_comment_form_label_submit_content = array(
    'key'     => 'comment_form_label_submit_content',
    'type'    => 'text',
    'label'   => __( 'Submit Label', '__x__' ),
    'options' => $options_comment_form_label_submit_content,
  );

  $control_comment_list_closed_content = array(
    'key'     => 'comment_list_closed_content',
    'type'    => 'text-editor',
    'label'   => __( 'Closed', '__x__' ),
    'options' => $options_comment_list_closed_content,
  );

  $control_comment_form_base_font_size = array(
    'key'     => 'comment_form_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_comment_form_base_font_size,
  );

  $control_comment_form_width = array(
    'key'     => 'comment_form_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_comment_form_width,
  );

  $control_comment_form_max_width = array(
    'key'     => 'comment_form_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_comment_form_max_width,
  );


  $control_comment_form_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_comment_form_width,
      $control_comment_form_max_width,
    ),
  );

  $control_comment_form_bg_color = array(
    'keys' => array(
      'value' => 'comment_form_bg_color',
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
            $control_comment_form_title_reply_content,
            $control_comment_form_title_reply_to_content,
            $control_comment_form_logged_in_as,
            $control_comment_form_cancel_reply_link_content,
            $control_comment_form_label_submit_content,
            // $control_comment_form_base_font_size,
            // $control_comment_form_width,
            // $control_comment_form_max_width,
            // $control_comment_form_bg_color,
          ),
        ),
        cs_control( 'margin', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'padding', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'border', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'border-radius', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'box-shadow', 'comment_form', $settings_comment_form_design ),
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
        $group        => __( 'Comment Form', '__x__' ),
        $group_setup  => __( 'Setup', '__x__' ),
        $group_design => __( 'Design', '__x__' ),
      ),

    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-form', $data );

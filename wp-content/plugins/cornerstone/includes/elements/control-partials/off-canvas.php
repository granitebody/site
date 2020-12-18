<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OFF-CANVAS.PHP
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

function x_control_partial_off_canvas( $settings ) {


  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'off_canvas';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Off Canvas', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : array();
  $lr_only     = ( isset( $settings['lr_only'] )     ) ? $settings['lr_only']     : false;
  $tb_only     = ( isset( $settings['tb_only'] )     ) ? $settings['tb_only']     : false;
  $tbf_only    = ( isset( $settings['tbf_only'] )    ) ? $settings['tbf_only']    : false;
  $ctbf_only   = ( isset( $settings['ctbf_only'] )   ) ? $settings['ctbf_only']   : false;



  // Groups
  // ------

  $group_off_canvas_setup  = $group . ':setup';
  $group_off_canvas_design = $group . ':design';



  // Conditions
  // ----------

  $lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
  $tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
  $tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
  $ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

  $conditions = array_merge( $conditions, array( $lr_only, $tb_only, $tbf_only, $ctbf_only ) );



  // Options
  // -------

  $options_off_canvas_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
  );

  $options_off_canvas_content_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '400px',
    'valid_keywords'  => array( 'none' ),
  );

  $options_off_canvas_body_scroll = array(
    'choices' => array(
      array( 'value' => 'allow',   'label' => __( 'Allow', '__x__' )   ),
      array( 'value' => 'disable', 'label' => __( 'Disable', '__x__' ) ),
    ),
  );

  $options_off_canvas_location = array(
    'choices' => array(
      array( 'value' => 'left',  'label' => __( 'Left', '__x__' )  ),
      array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
    ),
  );

  $options_off_canvas_close_dimensions = array(
    'choices' => array(
      array( 'value' => '1',   'label' => __( 'Small', '__x__' ) ),
      array( 'value' => '1.5', 'label' => __( 'Medium', '__x__' ) ),
      array( 'value' => '2',   'label' => __( 'Large', '__x__' ) ),
    ),
  );


  // Settings
  // --------

  $settings_off_canvas_content = array(
    'k_pre'        => 'off_canvas_content',
    'label_prefix' => __( 'Content', '__x__' ),
    'group'        => $group,
    'conditions'   => $conditions
  );



  // Individual Controls
  // -------------------

  $control_off_canvas_base_font_size = array(
    'key'     => 'off_canvas_base_font_size',
    'type'    => 'unit',
    'options' => $options_off_canvas_font_size,
  );

  $control_off_canvas_content_max_width = array(
    'key'     => 'off_canvas_content_max_width',
    'type'    => 'unit',
    'options' => $options_off_canvas_content_max_width,
  );

  $control_off_canvas_base_font_size_and_content_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_off_canvas_base_font_size,
      $control_off_canvas_content_max_width,
    ),
  );

  $control_off_canvas_body_scroll = array(
    'key'     => 'off_canvas_body_scroll',
    'type'    => 'choose',
    'label'   => __( 'Body Scroll', '__x__' ),
    'options' => $options_off_canvas_body_scroll,
  );

  $control_off_canvas_location = array(
    'key'     => 'off_canvas_location',
    'type'    => 'choose',
    'label'   => __( 'Location', '__x__' ),
    'options' => $options_off_canvas_location,
  );

  $control_off_canvas_close_size_and_dimensions = array(
    'type'     => 'group',
    'label'    => __( 'Close Size', '__x__' ),
    'controls' => array(
      array(
        'key'     => 'off_canvas_close_font_size',
        'type'    => 'unit',
        'options' => $options_off_canvas_font_size,
      ),
      array(
        'key'     => 'off_canvas_close_dimensions',
        'type'    => 'select',
        'options' => $options_off_canvas_close_dimensions,
      ),
    ),
  );

  $control_off_canvas_bg_color = array(
    'key'   => 'off_canvas_bg_color',
    'type'  => 'color',
    'label' => __( 'Overlay Background', '__x__' ),
  );

  $control_off_canvas_close_colors = array(
    'keys' => array(
      'value' => 'off_canvas_close_color',
      'alt'   => 'off_canvas_close_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Close Button', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_off_canvas_content_bg_color = array(
    'key'   => 'off_canvas_content_bg_color',
    'type'  => 'color',
    'label' => __( 'Content Background', '__x__' ),
  );


  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_off_canvas_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_off_canvas_base_font_size_and_content_max_width,
            $control_off_canvas_body_scroll,
            $control_off_canvas_location,
            $control_off_canvas_close_size_and_dimensions,
            array(
              'type' => 'transition',
              'keys' => array(
                'duration' => 'off_canvas_duration',
                'timing'   => 'off_canvas_timing_function'
              ),
            ),
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Colors', '__x__' ),
          'group'      => $group_off_canvas_design,
          'conditions' => $conditions,
          'controls'   => array(
            $control_off_canvas_bg_color,
            $control_off_canvas_close_colors,
            $control_off_canvas_content_bg_color,
          ),
        ),
        cs_control( 'border', 'off_canvas_content', $settings_off_canvas_content ),
        cs_control( 'box-shadow', 'off_canvas_content', $settings_off_canvas_content ),
        array(
          'key'        => 'off_canvas_custom_atts',
          'type'       => 'attributes',
          'conditions' => $conditions,
          'group'      => 'omega:setup',
          'label'      => __( '{{prefix}} Custom Attributes', '__x__' ),
          'label_vars' => array( 'prefix' =>  __( 'Off Canvas', '__x__' ) )
        )
      )
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Off Canvas Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_off_canvas_base_font_size,
          $control_off_canvas_content_max_width,
        ),
      ),
    ),
    'controls_std_design_colors' => array(
      array(
        'type'     => 'group',
        'label'    => __( 'Off Canvas Base Colors', '__x__' ),
        'controls' => array(
          $control_off_canvas_bg_color,
          $control_off_canvas_close_colors,
          array(
            'keys'      => array( 'value' => 'off_canvas_content_box_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Box<br>Shadow', '__x__' ),
            'condition' => array( 'key' => 'off_canvas_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
          ),
          $control_off_canvas_content_bg_color,
        ),
      ),
      cs_control( 'border', 'off_canvas_content', array_merge( $settings_off_canvas_content, array(
        'options'   => array( 'color_only' => true ),
        'conditions' => array_merge( $conditions, array(
          array( 'key' => 'off_canvas_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'off_canvas_border_style', 'op' => '!=', 'value' => 'none' ),
        ) ),
      )) )
    ),
    'control_nav' => array(
      $group                   => $group_title,
      $group_off_canvas_setup  => __( 'Setup', '__x__' ),
      $group_off_canvas_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'off-canvas', 'x_control_partial_off_canvas' );

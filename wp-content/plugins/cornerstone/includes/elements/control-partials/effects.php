<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OMEGA.PHP
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

function x_control_partial_effects( $settings ) {

  // Setup
  // -----

  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();
  $has_provider = ( isset( $settings['has_provider'] ) ) ? $settings['has_provider'] : false;


  // Groups
  // ------

  $group_effects       = 'effects';
  $group_effects_setup = $group_effects . ':setup';


  // Conditions
  // ----------

  $conditions_effects_alt              = array_merge( $conditions, array( array( 'effects_alt' => true ) ) );
  $conditions_effects_alt_animation    = array_merge( $conditions, array( array( 'effects_alt' => true ), array( 'effects_type_alt' => 'animation' ) ) );
  $conditions_effects_alt_transform    = array_merge( $conditions, array( array( 'effects_alt' => true ), array( 'effects_type_alt' => 'transform' ) ) );
  $conditions_effects_scroll           = array_merge( $conditions, array( array( 'effects_scroll' => true ) ) );
  $conditions_effects_scroll_animation = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_scroll' => 'animation' ) ) );
  $conditions_effects_scroll_transform = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_scroll' => 'transform' ) ) );
  $conditions_effects_enter_animation  = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_enter' => 'animation' ) ) );
  $conditions_effects_enter_transform  = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_enter' => 'transform' ) ) );
  $conditions_effects_exit_animation   = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_exit' => 'animation' ) ) );
  $conditions_effects_exit_transform   = array_merge( $conditions, array( array( 'effects_scroll' => true ), array( 'effects_type_exit' => 'transform' ) ) );


  // Options
  // -------

  $options_effects_opacity = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => 1,
    'min'            => 0,
    'max'            => 1,
    'step'           => 0.025,
  );

  $options_effects_offset = array(
    'available_units' => array( 'px', '%' ),
    'fallback_value'  => '50%',
    'ranges'          => array(
      'px' => array( 'min' => 0, 'max' => 200, 'step' => 10 ),
      '%'  => array( 'min' => 0, 'max' => 100, 'step' => 5  ),
    ),
  );

  $options_effects_behavior = array(
    'choices' => array(
      array( 'value' => 'fire-once', 'label' => __( 'Once', '__x__' )    ),
      array( 'value' => 'reset',     'label' => __( 'Reset', '__x__' )        ),
      array( 'value' => 'in-n-out',  'label' => __( 'In-Out', '__x__' ) ),
    )
  );

  $options_effects_perspective = array(
    'available_units' => array( 'px' ),
    'fallback_value'  => '1000px',
    'ranges'          => array(
      'px' => array( 'min' => 500, 'max' => 1500, 'step' => 50 ),
    ),
  );

  $options_effects_type = array(
    'choices' => array(
      array( 'value' => 'transform', 'label' => __( 'Transform', '__x__' ) ),
      array( 'value' => 'animation', 'label' => __( 'Animation', '__x__' ) ),
    )
  );

  $options_effects_transform = array(
    'placeholder' => __( 'translate3d(50%, 0, 0)' )
  );

  $options_effects_transform_origin = array(
    'choices' => array(
      array( 'value' => '50% 100%',  'label' => __( 'Bottom', '__x__' )       ),
      array( 'value' => '0% 100%',   'label' => __( 'Bottom Left', '__x__' )  ),
      array( 'value' => '100% 100%', 'label' => __( 'Bottom Right', '__x__' ) ),
      array( 'value' => '50% 50%',   'label' => __( 'Center', '__x__' )       ),
      array( 'value' => '0% 50%',    'label' => __( 'Left', '__x__' )         ),
      array( 'value' => '100% 50%',  'label' => __( 'Right', '__x__' )        ),
      array( 'value' => '50% 0%',    'label' => __( 'Top', '__x__' )          ),
      array( 'value' => '0% 0%',     'label' => __( 'Top Left', '__x__' )     ),
      array( 'value' => '100% 0%',   'label' => __( 'Top Right', '__x__' )    ),
    )
  );

  $options_effects_filter = array(
    'placeholder' => __( 'grayscale(1)' )
  );

  $options_effects_mix_blend_mode = array(
    'choices' => array(
      array( 'value' => 'normal',      'label' => __( 'Normal', '__x__' )      ),
      array( 'value' => 'multiply',    'label' => __( 'Multiply', '__x__' )    ),
      array( 'value' => 'screen',      'label' => __( 'Screen', '__x__' )      ),
      array( 'value' => 'overlay',     'label' => __( 'Overlay', '__x__' )     ),
      array( 'value' => 'darken',      'label' => __( 'Darken', '__x__' )      ),
      array( 'value' => 'lighten',     'label' => __( 'Lighten', '__x__' )     ),
      array( 'value' => 'color-dodge', 'label' => __( 'Color Dodge', '__x__' ) ),
      array( 'value' => 'color-burn',  'label' => __( 'Color Burn', '__x__' )  ),
      array( 'value' => 'hard-light',  'label' => __( 'Hard Light', '__x__' )  ),
      array( 'value' => 'soft-light',  'label' => __( 'Soft Light', '__x__' )  ),
      array( 'value' => 'difference',  'label' => __( 'Difference', '__x__' )  ),
      array( 'value' => 'exclusion',   'label' => __( 'Exclusion', '__x__' )   ),
      array( 'value' => 'hue',         'label' => __( 'Hue', '__x__' )         ),
      array( 'value' => 'saturation',  'label' => __( 'Saturation', '__x__' )  ),
      array( 'value' => 'color',       'label' => __( 'Color', '__x__' )       ),
      array( 'value' => 'luminosity',  'label' => __( 'Luminosity', '__x__' )  ),
    )
  );

  $options_effects_animate_choices_attention_seekers = array(
    array( 'value' => 'bounce',       'label' => 'Bounce'          ), // transform, animation-timing-function | transform-origin
    array( 'value' => 'flash',        'label' => 'Flash'           ), // opacity
    array( 'value' => 'flip',         'label' => 'Flip'            ), // transform, animation-timing-function | background-visibility: visible
    array( 'value' => 'headShake',    'label' => 'Head Shake'      ), // transform
    array( 'value' => 'heartBeat',    'label' => 'Heartbeat'       ), // transform
    array( 'value' => 'jackInTheBox', 'label' => 'Jack In The Box' ), // opacity, transform, transform-origin
    array( 'value' => 'jello',        'label' => 'Jello'           ), // transform | transform-origin
    array( 'value' => 'pulse',        'label' => 'Pulse'           ), // transform
    array( 'value' => 'rubberBand',   'label' => 'Rubber Band'     ), // transform
    array( 'value' => 'shakeX',       'label' => 'Shake X'         ), // transform
    array( 'value' => 'shakeY',       'label' => 'Shake Y'         ), // transform
    array( 'value' => 'swing',        'label' => 'Swing'           ), // transform | transform-origin
    array( 'value' => 'tada',         'label' => 'Tada'            ), // transform
    array( 'value' => 'wobble',       'label' => 'Wobble'          ), // transform
  );

  $options_effects_animate_choices_enter = array_merge(
    array(
      array( 'value' => 'backInDown',        'label' => 'Back In Down'         ), // opacity, transform
      array( 'value' => 'backInLeft',        'label' => 'Back In Left'         ), // opacity, transform
      array( 'value' => 'backInRight',       'label' => 'Back In Right'        ), // opacity, transform
      array( 'value' => 'backInUp',          'label' => 'Back In Up'           ), // opacity, transform

      array( 'value' => 'bounceIn',          'label' => 'Bounce In'            ), // opacity, transform, animation-timing-function
      array( 'value' => 'bounceInDown',      'label' => 'Bounce In Down'       ), // opacity, transform, animation-timing-function
      array( 'value' => 'bounceInLeft',      'label' => 'Bounce In Left'       ), // opacity, transform, animation-timing-function
      array( 'value' => 'bounceInRight',     'label' => 'Bounce In Right'      ), // opacity, transform, animation-timing-function
      array( 'value' => 'bounceInUp',        'label' => 'Bounce In Up'         ), // opacity, transform, animation-timing-function

      array( 'value' => 'fadeIn',            'label' => 'Fade In'              ), // opacity
      array( 'value' => 'fadeInDown',        'label' => 'Fade In Down'         ), // opacity, transform
      array( 'value' => 'fadeInDownBig',     'label' => 'Fade In Down Big'     ), // opacity, transform
      array( 'value' => 'fadeInLeft',        'label' => 'Fade In Left'         ), // opacity, transform
      array( 'value' => 'fadeInLeftBig',     'label' => 'Fade In Left Big'     ), // opacity, transform
      array( 'value' => 'fadeInRight',       'label' => 'Fade In Right'        ), // opacity, transform
      array( 'value' => 'fadeInRightBig',    'label' => 'Fade In Right Big'    ), // opacity, transform
      array( 'value' => 'fadeInUp',          'label' => 'Fade In Up'           ), // opacity, transform
      array( 'value' => 'fadeInUpBig',       'label' => 'Fade In Up Big'       ), // opacity, transform
      array( 'value' => 'fadeInTopLeft',     'label' => 'Fade In Top Left'     ), // opacity, transform
      array( 'value' => 'fadeInTopRight',    'label' => 'Fade In Top Right'    ), // opacity, transform
      array( 'value' => 'fadeInBottomLeft',  'label' => 'Fade In Bottom Left'  ), // opacity, transform
      array( 'value' => 'fadeInBottomRight', 'label' => 'Fade In Bottom Right' ), // opacity, transform

      array( 'value' => 'flipInX',           'label' => 'Flip In X'            ), // opacity, transform, animation-timing-function | background-visibility: visible
      array( 'value' => 'flipInY',           'label' => 'Flip In Y'            ), // opacity, transform, animation-timing-function | background-visibility: visible

      array( 'value' => 'lightSpeedInRight', 'label' => 'Light Speed In Right' ), // opacity, transform
      array( 'value' => 'lightSpeedInLeft',  'label' => 'Light Speed In Left'  ), // opacity, transform

      array( 'value' => 'rotateIn',          'label' => 'Rotate In'            ), // opacity, transform | transform-origin
      array( 'value' => 'rotateInDownLeft',  'label' => 'Rotate In Down Left'  ), // opacity, transform | transform-origin
      array( 'value' => 'rotateInDownRight', 'label' => 'Rotate In Down Right' ), // opacity, transform | transform-origin
      array( 'value' => 'rotateInUpLeft',    'label' => 'Rotate In Up Left'    ), // opacity, transform | transform-origin
      array( 'value' => 'rotateInUpRight',   'label' => 'Rotate In Up Right'   ), // opacity, transform | transform-origin

      array( 'value' => 'rollIn',            'label' => 'Roll In'              ), // opacity, transform

      array( 'value' => 'slideInDown',       'label' => 'Slide In Down'        ), // transform, visibility
      array( 'value' => 'slideInLeft',       'label' => 'Slide In Left'        ), // transform, visibility
      array( 'value' => 'slideInRight',      'label' => 'Slide In Right'       ), // transform, visibility
      array( 'value' => 'slideInUp',         'label' => 'Slide In Up'          ), // transform, visibility

      array( 'value' => 'zoomIn',            'label' => 'Zoom In'              ), // opacity, transform
      array( 'value' => 'zoomInDown',        'label' => 'Zoom In Down'         ), // opacity, transform, animation-timing-function
      array( 'value' => 'zoomInLeft',        'label' => 'Zoom In Left'         ), // opacity, transform, animation-timing-function
      array( 'value' => 'zoomInRight',       'label' => 'Zoom In Right'        ), // opacity, transform, animation-timing-function
      array( 'value' => 'zoomInUp',          'label' => 'Zoom In Up'           ), // opacity, transform, animation-timing-function
    ),
    $options_effects_animate_choices_attention_seekers
  );

  $options_effects_animate_choices_exit = array_merge(
    array(
      // array( 'value' => 'hinge',              'label' => 'Hinge'                 ), // opacity, transform, animation-timing-function | transform-origin

      array( 'value' => 'backOutDown',        'label' => 'Back Out Down'         ), // opacity, transform
      array( 'value' => 'backOutLeft',        'label' => 'Back Out Left'         ), // opacity, transform
      array( 'value' => 'backOutRight',       'label' => 'Back Out Right'        ), // opacity, transform
      array( 'value' => 'backOutUp',          'label' => 'Back Out Up'           ), // opacity, transform

      array( 'value' => 'bounceOut',          'label' => 'Bounce Out'            ), // opacity, transform
      array( 'value' => 'bounceOutDown',      'label' => 'Bounce Out Down'       ), // opacity, transform
      array( 'value' => 'bounceOutLeft',      'label' => 'Bounce Out Left'       ), // opacity, transform
      array( 'value' => 'bounceOutRight',     'label' => 'Bounce Out Right'      ), // opacity, transform
      array( 'value' => 'bounceOutUp',        'label' => 'Bounce Out Up'         ), // opacity, transform

      array( 'value' => 'fadeOut',            'label' => 'Fade Out'              ), // opacity
      array( 'value' => 'fadeOutDown',        'label' => 'Fade Out Down'         ), // opacity, transform
      array( 'value' => 'fadeOutDownBig',     'label' => 'Fade Out Down Big'     ), // opacity, transform
      array( 'value' => 'fadeOutLeft',        'label' => 'Fade Out Left'         ), // opacity, transform
      array( 'value' => 'fadeOutLeftBig',     'label' => 'Fade Out Left Big'     ), // opacity, transform
      array( 'value' => 'fadeOutRight',       'label' => 'Fade Out Right'        ), // opacity, transform
      array( 'value' => 'fadeOutRightBig',    'label' => 'Fade Out Right Big'    ), // opacity, transform
      array( 'value' => 'fadeOutUp',          'label' => 'Fade Out Up'           ), // opacity, transform
      array( 'value' => 'fadeOutUpBig',       'label' => 'Fade Out Up Big'       ), // opacity, transform
      array( 'value' => 'fadeOutTopLeft',     'label' => 'Fade Out Top Left'     ), // opacity, transform
      array( 'value' => 'fadeOutTopRight',    'label' => 'Fade Out Top Right'    ), // opacity, transform
      array( 'value' => 'fadeOutBottomRight', 'label' => 'Fade Out Bottom Right' ), // opacity, transform
      array( 'value' => 'fadeOutBottomLeft',  'label' => 'Fade Out Bottom Left'  ), // opacity, transform

      array( 'value' => 'flipOutX',           'label' => 'Flip Out X'            ), // opacity, transform | background-visibility: visible
      array( 'value' => 'flipOutY',           'label' => 'Flip Out Y'            ), // opacity, transform | background-visibility: visible

      array( 'value' => 'lightSpeedOutRight', 'label' => 'Light Speed Out Right' ), // opacity, transform
      array( 'value' => 'lightSpeedOutLeft',  'label' => 'Light Speed Out Left'  ), // opacity, transform

      array( 'value' => 'rotateOut',          'label' => 'Rotate Out'            ), // opacity, transform | transform-origin
      array( 'value' => 'rotateOutDownLeft',  'label' => 'Rotate Out Down Left'  ), // opacity, transform | transform-origin
      array( 'value' => 'rotateOutDownRight', 'label' => 'Rotate Out Down Right' ), // opacity, transform | transform-origin
      array( 'value' => 'rotateOutUpLeft',    'label' => 'Rotate Out Up Left'    ), // opacity, transform | transform-origin
      array( 'value' => 'rotateOutUpRight',   'label' => 'Rotate Out Up Right'   ), // opacity, transform | transform-origin

      array( 'value' => 'rollOut',            'label' => 'Roll Out'              ), // opacity, transform

      array( 'value' => 'slideOutDown',       'label' => 'Slide Out Down'        ), // transform, visibility
      array( 'value' => 'slideOutLeft',       'label' => 'Slide Out Left'        ), // transform, visibility
      array( 'value' => 'slideOutRight',      'label' => 'Slide Out Right'       ), // transform, visibility
      array( 'value' => 'slideOutUp',         'label' => 'Slide Out Up'          ), // transform, visibility

      array( 'value' => 'zoomOut',            'label' => 'Zoom Out'              ), // opacity, transform
      array( 'value' => 'zoomOutDown',        'label' => 'Zoom Out Down'         ), // opacity, transform, animation-timing-function | transform-origin
      array( 'value' => 'zoomOutLeft',        'label' => 'Zoom Out Left'         ), // opacity, transform, animation-timing-function | transform-origin
      array( 'value' => 'zoomOutRight',       'label' => 'Zoom Out Right'        ), // opacity, transform, animation-timing-function | transform-origin
      array( 'value' => 'zoomOutUp',          'label' => 'Zoom Out Up'           ), // opacity, transform, animation-timing-function | transform-origin
    ),
    $options_effects_animate_choices_attention_seekers
  );

  $options_effects_animate_alt   = array( 'choices' => $options_effects_animate_choices_attention_seekers );
  $options_effects_animate_enter = array( 'choices' => $options_effects_animate_choices_enter             );
  $options_effects_animate_exit  = array( 'choices' => $options_effects_animate_choices_exit              );


  // Control Nav
  // -----------

  $control_nav = array(
    $group_effects       => __( 'Effects', '__x__' ),
    $group_effects_setup => __( 'Setup', '__x__' ),
  );


  // Control Group: Interaction Provider
  // -----------------------------------

  $control_group_interaction_provider = array();

  if ( $has_provider ) {
    $control_group_interaction_provider = array(
      'key'        => 'effects_provider',
      'type'       => 'group',
      'label'      => __( 'Link Child Interactions', '__x__' ),
      'group'      => $group_effects_setup,
      'options'    => cs_recall( 'options_group_toggle_off_on_bool' ),
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'key'     => 'effects_provider_targets',
          'type'    => 'multi-choose',
          'label'   => __( 'Select Targets', '__x__' ),
          'options' => array(
            'weighted' => true,
            'choices'  => array(
              array( 'value' => 'colors',    'label' => __( 'Colors', '__x__' )    ),
              array( 'value' => 'particles', 'label' => __( 'Particles', '__x__' ) ),
              array( 'value' => 'effects',   'label' => __( 'Effects', '__x__' )   ),
            ),
          ),
        ),
      ),
    );
  }


  // Controls
  // --------

  $controls = array(

    // Provider
    // --------

    $control_group_interaction_provider,


    // Base
    // ----

    array(
      'type'       => 'group',
      'label'      => __( 'Base', '__x__' ),
      'group'      => $group_effects_setup,
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'key'     => 'effects_opacity',
          'type'    => 'unit-slider',
          'label'   => __( 'Opacity', '__x__' ),
          'options' => $options_effects_opacity,
        ),
        array(
          'key'     => 'effects_filter',
          'type'    => 'filter',
          'label'   => __( 'Filter', '__x__' ),
          'options' => $options_effects_filter,
        ),
        array(
          'key'     => 'effects_transform',
          'type'    => 'transform',
          'label'   => __( 'Transform', '__x__' ),
          'options' => $options_effects_transform,
        ),
        array(
          'key'     => 'effects_transform_origin',
          'type'    => 'select',
          'label'   => __( 'Transform Origin', '__x__' ),
          'options' => $options_effects_transform_origin,
        ),
        // array(
        //   'key'     => 'effects_perspective',
        //   'type'    => 'unit-slider',
        //   'label'   => __( 'Perspective', '__x__' ),
        //   'options' => $options_effects_perspective,
        // ),
        // array(
        //   'key'   => 'effects_perspective_origin',
        //   'type'  => 'text',
        //   'label' => __( 'Perspective Origin', '__x__' ),
        // ),
        array(
          'type' => 'transition',
          'keys' => array(
            'duration' => 'effects_duration',
            // 'delay'    => 'effects_delay',
            'timing'   => 'effects_timing_function'
          ),
        ),
      ),
    ),


    // Interaction
    // -----------

    array(
      'key'      => 'effects_alt',
      'type'     => 'group',
      'label'    => __( 'Interaction', '__x__' ),
      'group'    => $group_effects_setup,
      'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
      'controls' => array(
        array(
          'key'        => 'effects_type_alt',
          'type'       => 'choose',
          'label'      => __( 'Type', '__x__' ),
          'conditions' => $conditions_effects_alt,
          'options'    => $options_effects_type,
        ),
        array(
          'key'        => 'effects_opacity_alt',
          'type'       => 'unit-slider',
          'label'      => __( 'Opacity', '__x__' ),
          'conditions' => $conditions_effects_alt,
          'options'    => $options_effects_opacity,
        ),
        array(
          'key'        => 'effects_filter_alt',
          'type'       => 'filter',
          'label'      => __( 'Filter', '__x__' ),
          'conditions' => $conditions_effects_alt,
          'options'    => $options_effects_filter,
        ),
        array(
          'key'        => 'effects_animation_alt',
          'type'       => 'select',
          'label'      => __( 'Animation', '__x__' ),
          'conditions' => $conditions_effects_alt_animation,
          'options'    => $options_effects_animate_alt,
        ),
        array(
          'key'        => 'effects_transform_alt',
          'type'       => 'transform',
          'label'      => __( 'Transform', '__x__' ),
          'conditions' => $conditions_effects_alt_transform,
          'options'    => $options_effects_transform,
        ),
        array(
          'type'       => 'transition',
          'label'      => __( 'Animation Transition', '__x__' ),
          'conditions' => $conditions_effects_alt_animation,
          'keys'       => array(
            'duration' => 'effects_duration_animation_alt',
            // 'delay'    => 'effects_delay_animation_alt',
            'timing'   => 'effects_timing_function_animation_alt'
          ),
        ),
      ),
    ),


    // Scroll
    // ------

    array(
      'key'      => 'effects_scroll',
      'type'     => 'group',
      'label'    => __( 'Scroll', '__x__' ),
      'group'    => $group_effects_setup,
      'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
      'controls' => array(

        array(
          'key'        => 'effects_type_scroll',
          'type'       => 'choose',
          'label'      => __( 'Type', '__x__' ),
          'conditions' => $conditions_effects_scroll,
          'options'    => $options_effects_type,
        ),

        array(
          'type'       => 'group',
          'conditions' => $conditions_effects_scroll,
          'label'      => '&nbsp;',
          'controls'   => array(
            array(
              'type'    => 'label',
              'label'   => __( 'In', '__x__' ),
              'options' => array(
                'columns' => 3
              )
            ),
            array(
              'type'    => 'label',
              'label'   => __( 'Out', '__x__' ),
              'options' => array(
                'columns' => 3
              )
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'label'      => __( 'Opacity', '__x__' ),
          'conditions' => $conditions_effects_scroll,
          'options'    => array( 'grouped' => true ),
          'controls'   => array(
            array(
              'key'        => 'effects_opacity_enter',
              'type'       => 'unit',
              'label'      => __( 'Opacity<br/>Enter', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_opacity,
            ),
            array(
              'key'        => 'effects_opacity_exit',
              'type'       => 'unit',
              'label'      => __( 'Opacity<br/>Exit', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_opacity,
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'label'      => __( 'Filter', '__x__' ),
          'conditions' => $conditions_effects_scroll,
          'options'    => array( 'grouped' => true ),
          'controls'   => array(
            array(
              'key'        => 'effects_filter_enter',
              'type'       => 'filter',
              'label'      => __( 'Filter<br/>Enter', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_filter,
            ),
            array(
              'key'        => 'effects_filter_exit',
              'type'       => 'filter',
              'label'      => __( 'Filter<br/>Exit', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_filter,
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'label'      => __( 'Animation', '__x__' ),
          'conditions' => $conditions_effects_scroll_animation,
          'options'    => array( 'grouped' => true ),
          'controls'   => array(
            array(
              'key'        => 'effects_animation_enter',
              'type'       => 'select',
              'label'      => __( 'Animation<br/>Enter', '__x__' ),
              'conditions' => $conditions_effects_scroll_animation,
              'options'    => $options_effects_animate_enter,
            ),
            array(
              'key'        => 'effects_animation_exit',
              'type'       => 'select',
              'label'      => __( 'Animation<br/>Exit', '__x__' ),
              'conditions' => $conditions_effects_scroll_animation,
              'options'    => $options_effects_animate_exit,
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'label'      => __( 'Transform', '__x__' ),
          'conditions' => $conditions_effects_scroll_transform,
          'options'    => array( 'grouped' => true ),
          'controls'   => array(
            array(
              'key'        => 'effects_transform_enter',
              'type'       => 'transform',
              'label'      => __( 'Transform<br/>Enter', '__x__' ),
              'conditions' => $conditions_effects_scroll_transform,
              'options'    => $options_effects_transform,
            ),
            array(
              'key'        => 'effects_transform_exit',
              'type'       => 'transform',
              'label'      => __( 'Transform<br/>Exit', '__x__' ),
              'conditions' => $conditions_effects_scroll_transform,
              'options'    => $options_effects_transform,
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'conditions' => $conditions_effects_scroll,
          'label'      => '&nbsp;',
          'controls'   => array(
            array(
              'type'    => 'label',
              'label'   => __( 'Top', '__x__' ),
              'options' => array(
                'columns' => 1
              )
            ),
            array(
              'type'    => 'label',
              'label'   => __( 'Bottom', '__x__' ),
              'options' => array(
                'columns' => 1
              )
            ),
          ),
        ),

        array(
          'type'       => 'group',
          'label'      => __( 'Offset', '__x__' ),
          'conditions' => $conditions_effects_scroll,
          'options'    => array( 'grouped' => true ),
          'controls'   => array(
            array(
              'key'        => 'effects_offset_top',
              'type'       => 'unit',
              'label'      => __( 'Top<br/>Offset', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_offset,
            ),
            array(
              'key'        => 'effects_offset_bottom',
              'type'       => 'unit',
              'label'      => __( 'Bottom<br/>Offset', '__x__' ),
              'conditions' => $conditions_effects_scroll,
              'options'    => $options_effects_offset,
            ),
          ),
        ),

        array(
          'key'        => 'effects_behavior_scroll',
          'type'       => 'choose',
          'label'      => __( 'Behavior', '__x__' ),
          'conditions' => $conditions_effects_scroll,
          'options'    => $options_effects_behavior,
        ),

        array(
          'type' => 'transition',
          'keys' => array(
            'duration' => 'effects_duration_scroll',
            'delay'    => 'effects_delay_scroll',
            'timing'   => 'effects_timing_function_scroll'
          ),
        ),

      ),
    ),


    // Specialty
    // ---------

    array(
      'type'        => 'group',
      'label'       => __( 'Specialty', '__x__' ),
      'group'       => $group_effects_setup,
      'description' => __( 'Mix Blend Mode and Backdrop Filter do not work in IE11. Additionally, Backdrop Filter is not supported in Firefox by default, so we recommend using this as more of a progressive enhancement for your designs.', '__x__' ),
      'controls'    => array(
        array(
          'key'     => 'effects_mix_blend_mode',
          'type'    => 'select',
          'label'   => __( 'Mix Blend Mode', '__x__' ),
          'options' => $options_effects_mix_blend_mode,
        ),
        array(
          'key'     => 'effects_backdrop_filter',
          'type'    => 'filter',
          'label'   => __( 'Backdrop Filter', '__x__' ),
          'options' => $options_effects_filter,
        ),
      ),
    ),

  );


  // Output
  // ------

  return array(
    'controls'    => $controls,
    'control_nav' => $control_nav
  );
}

cs_register_control_partial( 'effects', 'x_control_partial_effects' );

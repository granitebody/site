<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-DIV.PHP
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
    'layout_div_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_div_tag'                   => cs_value( 'div', 'markup' ),
    'layout_div_text_align'            => cs_value( 'none', 'style' ),
    'layout_div_pointer_events'        => cs_value( 'auto', 'style' ),
    'layout_div_overflow'              => cs_value( 'visible', 'style' ),
    'layout_div_z_index'               => cs_value( 'auto', 'style' ),
    'layout_div_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_div_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_div_bg_advanced'           => cs_value( false, 'all' ),

    'layout_div_href'                  => cs_value( '', 'markup', true ),
    'layout_div_blank'                 => cs_value( false, 'markup', true ),
    'layout_div_nofollow'              => cs_value( false, 'markup', true ),

    'layout_div_width'                 => cs_value( 'auto', 'style' ),
    'layout_div_min_width'             => cs_value( '0px', 'style' ),
    'layout_div_max_width'             => cs_value( 'none', 'style' ),
    'layout_div_height'                => cs_value( 'auto', 'style' ),
    'layout_div_min_height'            => cs_value( '0px', 'style' ),
    'layout_div_max_height'            => cs_value( 'none', 'style' ),
    'layout_div_flex'                  => cs_value( '0 1 auto', 'style' ),

    'layout_div_position'              => cs_value( 'relative', 'style' ),
    'layout_div_top'                   => cs_value( 'auto', 'style' ),
    'layout_div_left'                  => cs_value( 'auto', 'style' ),
    'layout_div_right'                 => cs_value( 'auto', 'style' ),
    'layout_div_bottom'                => cs_value( 'auto', 'style' ),
    'layout_div_overflow_x'            => cs_value( 'visible', 'style' ),
    'layout_div_overflow_y'            => cs_value( 'visible', 'style' ),

    'layout_div_flexbox'               => cs_value( false, 'style' ),
    'layout_div_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_div_flex_wrap'             => cs_value( true, 'style' ),
    'layout_div_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_div_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_div_margin'                => cs_value( '!0px', 'style' ),
    'layout_div_padding'               => cs_value( '!0px', 'style' ),
    'layout_div_border_width'          => cs_value( '!0px', 'style' ),
    'layout_div_border_style'          => cs_value( 'solid', 'style' ),
    'layout_div_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_div_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_div_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_div_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'layout_div_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_div_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  'bg',
  cs_values( 'particle', 'layout_div_primary' ),
  cs_values( 'particle', 'layout_div_secondary' ),
  'effects',
  'effects:provider',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_layout_div() {
  return x_get_view( 'styles/elements', 'layout-div', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_div( $data ) {
  return x_get_view( 'elements', 'layout-div', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'    => __( 'Div', '__x__' ),
  'values'   => $values,
  'builder'  => 'x_element_builder_setup_layout_div',
  'style'    => 'x_element_style_layout_div',
  'render'   => 'x_element_render_layout_div',
  'icon'     => 'native',
  'children' => 'x_layout_div',
  'options' => array(
    'valid_children'    => array( '*' ),
    'index_labels'      => false,
    'library'           => true,
    'empty_placeholder' => false,
    'fallback_content'  => '&nbsp;',
    'dropzone'          => array(
      'enabled'     => true,
      'z_index_key' => 'layout_div_z_index'
    ),
    'contrast_keys'     => array(
      'bg:layout_div_bg_advanced',
      'layout_div_bg_color'
    ),
    'side_effects' => [
      [
        'observe' => 'layout_div_bg_advanced',
        'conditions' => [
          ['key' => 'layout_div_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_div_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_div_z_index' => '1'
        ]
      ]
    ]
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_div() {

  // Conditions
  // ----------

  $condition_layout_div_is_anchor     = array( 'layout_div_tag' => 'a' );
  $condition_layout_div_is_not_anchor = array( 'key' => 'layout_div_tag', 'op' => '!=', 'value' => 'a' );


  // Groups
  // ------

  $group           = 'layout_div';
  $group_setup     = $group . ':setup';
  $group_size      = $group . ':size';
  $group_position  = $group . ':position';
  $group_design    = $group . ':design';
  $group_particles = $group . ':particles';


  // Settings
  // --------

  $settings_layout_div_design_no_color = array(
    'group'  => $group_design,
  );

  $settings_layout_div_design_with_color = array(
    'group'     => $group_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );

  $settings_layout_div_design_flexbox = array(
    'group'   => $group_design,
    'toggle'  => 'layout_div_flexbox',
    'flex'    => false,
    'no_self' => true,
  );


  // Conditions
  // ----------

  $condition_layout_div_position_not_static = array( 'key' => 'layout_div_position', 'op' => '!=', 'value' => 'static' );


  // Options
  // -------

  $options_layout_div_pointer_events = array(
    'off_value' => 'auto',
    'choices'   => array(
      array( 'value' => 'none-self', 'label' => __( 'Self Only', '__x__' )   ),
      array( 'value' => 'none-all',  'label' => __( 'All Content', '__x__' ) ),
    ),
  );

  $options_layout_div_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
  );

  $options_layout_div_min_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'calc' ),
  );

  $options_layout_div_max_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
  );

  $options_layout_div_overflow = array(
    'choices' => array(
      array( 'value' => 'visible', 'label' => __( 'Visible', '__x__' ) ),
      array( 'value' => 'hidden',  'label' => __( 'Hidden', '__x__' )  ),
      array( 'value' => 'auto',    'label' => __( 'Auto', '__x__' )    ),
      array( 'value' => 'scroll',  'label' => __( 'Scroll', '__x__' )  ),
    ),
  );

  $options_layout_div_position = array(
    'choices' => array(
      array( 'value' => 'static',   'label' => __( 'Static', '__x__' )   ),
      array( 'value' => 'relative', 'label' => __( 'Relative', '__x__' ) ),
      array( 'value' => 'absolute', 'label' => __( 'Absolute', '__x__' ) ),
      array( 'value' => 'fixed',    'label' => __( 'Fixed', '__x__' )    ),
      // array( 'value' => 'sticky',   'label' => __( 'Sticky', '__x__' )   ),
    ),
  );

  $options_layout_div_top_left_right_and_bottom = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
      '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_layout_div_sortable = array(
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => $group_setup
  );

  $control_layout_div_base_font_size = array(
    'key'     => 'layout_div_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
    ),
  );

  $control_layout_div_tag = array(
    'key'     => 'layout_div_tag',
    'type'    => 'select',
    'label'   => __( 'Tag', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_tags' ),
  );

  $control_layout_div_font_size_and_tag = array(
    'type'     => 'group',
    'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
    'controls' => array(
      $control_layout_div_base_font_size,
      $control_layout_div_tag,
    ),
  );

  $control_layout_div_z_index = array(
    'key'     => 'layout_div_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_div_text_align = array(
    'key'   => 'layout_div_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_layout_div_pointer_events = array(
    'key'     => 'layout_div_pointer_events',
    'type'    => 'choose',
    'label'   => __( 'No Pointer Events', '__x__' ),
    'options' => $options_layout_div_pointer_events,
  );

  $control_layout_div_bg_color = array(
    'keys' => array(
      'value' => 'layout_div_bg_color',
      'alt'   => 'layout_div_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_layout_div_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_div_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_div_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_div_bg_color,
      $control_layout_div_bg_advanced
    ),
  );

  $control_layout_div_link = array(
    'keys' => array(
      'url'      => 'layout_div_href',
      'new_tab'  => 'layout_div_blank',
      'nofollow' => 'layout_div_nofollow',
    ),
    'type'      => 'link',
    'label'     => __( 'Link', '__x__' ),
    'group'     => $group_setup,
    'condition' => $condition_layout_div_is_anchor,
  );


  // Controls (Overflow)
  // -------------------

  $control_layout_div_overflow_labels = array(
    'type'     => 'group',
    'label'    => '&nbsp;',
    'controls' => array(
      array(
        'type'    => 'label',
        'label'   => __( 'X', '__x__' ),
        'options' => array(
          'columns' => 1
        )
      ),
      array(
        'type'    => 'label',
        'label'   => __( 'Y', '__x__' ),
        'options' => array(
          'columns' => 1
        )
      ),
    ),
  );

  $control_layout_div_overflow_x = array(
    'key'     => 'layout_div_overflow_x',
    'type'    => 'select',
    'options' => $options_layout_div_overflow,
  );

  $control_layout_div_overflow_y = array(
    'key'     => 'layout_div_overflow_y',
    'type'    => 'select',
    'options' => $options_layout_div_overflow,
  );

  $control_layout_div_overflow = array(
    'type'     => 'group',
    'label'    => __( 'Overflow', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_div_overflow_x,
      $control_layout_div_overflow_y,
    ),
  );


  // Controls (Size)
  // ---------------

  $control_layout_div_width_and_height_column_labels = array(
    'type'     => 'group',
    'label'    => '&nbsp;',
    'controls' => array(
      array(
        'type'    => 'label',
        'label'   => __( 'Width', '__x__' ),
        'options' => array(
          'columns' => 3
        )
      ),
      array(
        'type'    => 'label',
        'label'   => __( 'Height', '__x__' ),
        'options' => array(
          'columns' => 3
        )
      ),
    ),
  );

  $control_layout_div_width = array(
    'key'     => 'layout_div_width',
    'type'    => 'unit',
    'options' => $options_layout_div_width_and_height,
  );

  $control_layout_div_height = array(
    'key'     => 'layout_div_height',
    'type'    => 'unit',
    'options' => $options_layout_div_width_and_height,
  );

  $control_layout_div_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Base', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_div_width,
      $control_layout_div_height,
    ),
  );

  $control_layout_div_min_width = array(
    'key'     => 'layout_div_min_width',
    'type'    => 'unit',
    'options' => $options_layout_div_min_width_and_height,
  );

  $control_layout_div_min_height = array(
    'key'     => 'layout_div_min_height',
    'type'    => 'unit',
    'options' => $options_layout_div_min_width_and_height,
  );

  $control_layout_div_min_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Minimum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_div_min_width,
      $control_layout_div_min_height,
    ),
  );

  $control_layout_div_max_width = array(
    'key'     => 'layout_div_max_width',
    'type'    => 'unit',
    'options' => $options_layout_div_max_width_and_height,
  );

  $control_layout_div_max_height = array(
    'key'     => 'layout_div_max_height',
    'type'    => 'unit',
    'options' => $options_layout_div_max_width_and_height,
  );

  $control_layout_div_max_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Maximum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_div_max_width,
      $control_layout_div_max_height,
    ),
  );

  $control_layout_div_flex = array(
    'key'   => 'layout_div_flex',
    'label' => __( 'Flex', '__x__' ),
    'type'  => 'flex',
  );


  // Controls (Position / Overflow)
  // ------------------------------

  $control_layout_div_position = array(
    'key'     => 'layout_div_position',
    'label'   => __( 'Position', '__x__' ),
    'type'    => 'select',
    'options' => $options_layout_div_position,
  );

  $control_layout_div_top = array(
    'key'     => 'layout_div_top',
    'type'    => 'unit',
    'options' => $options_layout_div_top_left_right_and_bottom,
  );

  $control_layout_div_bottom = array(
    'key'     => 'layout_div_bottom',
    'type'    => 'unit',
    'options' => $options_layout_div_top_left_right_and_bottom,
  );

  $control_layout_div_top_and_bottom = array(
    'type'      => 'group',
    'label'     => __( 'Top &amp;<br/>Bottom', '__x__' ),
    'condition' => $condition_layout_div_position_not_static,
    'controls'  => array(
      $control_layout_div_top,
      $control_layout_div_bottom,
    ),
  );

  $control_layout_div_left = array(
    'key'     => 'layout_div_left',
    'type'    => 'unit',
    'options' => $options_layout_div_top_left_right_and_bottom,
  );

  $control_layout_div_right = array(
    'key'     => 'layout_div_right',
    'type'    => 'unit',
    'options' => $options_layout_div_top_left_right_and_bottom,
  );

  $control_layout_div_left_and_right = array(
    'type'      => 'group',
    'label'     => __( 'Left &amp;<br/>Right', '__x__' ),
    'condition' => $condition_layout_div_position_not_static,
    'controls'  => array(
      $control_layout_div_left,
      $control_layout_div_right,
    ),
  );


  // Control Groups
  // --------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_div_sortable,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => $group_setup,
          'controls' => array(
            $control_layout_div_font_size_and_tag,
            $control_layout_div_text_align,
            $control_layout_div_pointer_events,
            $control_layout_div_overflow_labels,
            $control_layout_div_overflow,
            $control_layout_div_z_index,
            $control_layout_div_background,
          ),
        ),
        $control_layout_div_link,
      ),
    ),
    cs_partial_controls( 'bg', array(
      'group'     => $group_design,
      'condition' => array( 'layout_div_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Size', '__x__' ),
          'group'    => $group_size,
          'controls' => array(
            $control_layout_div_width_and_height_column_labels,
            $control_layout_div_width_and_height,
            $control_layout_div_min_width_and_height,
            $control_layout_div_max_width_and_height,
            $control_layout_div_flex,
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Position', '__x__' ),
          'group'    => $group_position,
          'controls' => array(
            $control_layout_div_position,
            $control_layout_div_top_and_bottom,
            $control_layout_div_left_and_right,
          ),
        ),
      ),
      'controls_std_design_setup' => array(

      ),
      'controls_std_design_colors' => array(

      ),
      'control_nav' => array(
        $group           => __( 'Div', '__x__' ),
        $group_setup     => __( 'Setup', '__x__' ),
        $group_size      => __( 'Size', '__x__' ),
        $group_position  => __( 'Position', '__x__' ),
        $group_design    => __( 'Design', '__x__' ),
        $group_particles => __( 'Particles', '__x__' ),
      )
    ),
    array(
      'controls' => array(
        cs_control( 'flexbox', 'layout_div', $settings_layout_div_design_flexbox ),
        cs_control( 'margin', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'padding', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'border', 'layout_div', $settings_layout_div_design_with_color ),
        cs_control( 'border-radius', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'box-shadow', 'layout_div', $settings_layout_div_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Primary', '__x__' ),
      'k_pre'        => 'layout_div_primary',
      'group'        => $group_particles,
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Secondary', '__x__' ),
      'k_pre'        => 'layout_div_secondary',
      'group'        => $group_particles,
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'effects', array( 'has_provider' => true ) ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-div', $data );

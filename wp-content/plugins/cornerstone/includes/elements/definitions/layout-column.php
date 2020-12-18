<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-COLUMN.PHP
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
    'layout_column_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_column_tag'                   => cs_value( 'div', 'markup' ),
    'layout_column_width'                 => cs_value( 'auto', 'style' ),
    'layout_column_min_width'             => cs_value( '0px', 'style' ),
    'layout_column_max_width'             => cs_value( 'none', 'style' ),
    'layout_column_height'                => cs_value( 'auto', 'style' ),
    'layout_column_min_height'            => cs_value( '0px', 'style' ),
    'layout_column_max_height'            => cs_value( 'none', 'style' ),
    'layout_column_text_align'            => cs_value( 'none', 'style' ),
    'layout_column_overflow'              => cs_value( 'visible', 'style' ),
    'layout_column_z_index'               => cs_value( 'auto', 'style' ),
    'layout_column_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_column_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_column_bg_advanced'           => cs_value( false, 'all' ),

    'layout_column_href'                  => cs_value( '', 'markup', true ),
    'layout_column_blank'                 => cs_value( false, 'markup', true ),
    'layout_column_nofollow'              => cs_value( false, 'markup', true ),

    'layout_column_flexbox'               => cs_value( false, 'style' ),
    'layout_column_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_column_flex_wrap'             => cs_value( true, 'style' ),
    'layout_column_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_column_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_column_padding'               => cs_value( '!0px', 'style' ),
    'layout_column_border_width'          => cs_value( '!0px', 'style' ),
    'layout_column_border_style'          => cs_value( 'solid', 'style' ),
    'layout_column_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_column_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_column_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_column_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'layout_column_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_column_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  'bg',
  cs_values( 'particle', 'layout_column_primary' ),
  cs_values( 'particle', 'layout_column_secondary' ),
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

function x_element_style_layout_column() {
  return x_get_view( 'styles/elements', 'layout-column', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_column( $data ) {
  return x_get_view( 'elements', 'layout-column', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Column', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_layout_column',
  'style'   => 'x_element_style_layout_column',
  'render'  => 'x_element_render_layout_column',
  'icon'    => 'native',
  'children' => 'x_layout_column',
  'tag_key'  => 'layout_column_tag',
  'options' => array(
    'valid_children'    => array( '*' ),
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'fallback_content'  => '&nbsp;',
    'dropzone'          => array(
      'enabled'     => true,
      'z_index_key' => 'layout_column_z_index'
    ),
    'contrast_keys'     => array(
      'bg:layout_column_bg_advanced',
      'layout_column_bg_color'
    ),
    'side_effects' => [
      [
        'observe' => 'layout_column_bg_advanced',
        'conditions' => [
          ['key' => 'layout_column_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_column_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_column_z_index' => '1'
        ]
      ]
    ]
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_column() {

  // Conditions
  // ----------

  $condition_layout_column_is_anchor     = array( 'layout_column_tag' => 'a' );
  $condition_layout_column_is_not_anchor = array( 'key' => 'layout_column_tag', 'op' => '!=', 'value' => 'a' );


  // Settings
  // --------

  $settings_layout_column_design_no_color = array(
    'group' => 'layout_column:design',
  );

  $settings_layout_column_design_flexbox = array(
    'group'  => 'layout_column:design',
    'toggle' => 'layout_column_flexbox',
  );

  $settings_layout_column_design_with_color = array(
    'group'     => 'layout_column:design',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Options
  // -------

  $available_units_layout_column           = array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' );
  $ranges_layout_column_widths_and_heights = array(
    'px'   => array( 'min' => 0, 'max' => 1000, 'step' => 20 ),
    'em'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'rem'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    '%'    => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vw'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vh'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vmin' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vmax' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
  );

  $options_layout_column_width_and_height = array(
    'available_units' => $available_units_layout_column,
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => $ranges_layout_column_widths_and_heights,
  );

  $options_layout_column_min_width_and_min_height = array(
    'available_units' => $available_units_layout_column,
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => $ranges_layout_column_widths_and_heights,
  );

  $options_layout_column_max_width_and_max_height = array(
    'available_units' => $available_units_layout_column,
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => $ranges_layout_column_widths_and_heights,
  );


  // Individual Controls
  // -------------------

  $control_layout_column_sortable = array(
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => 'layout_column:setup'
  );

  $control_layout_column_base_font_size = array(
    'key'     => 'layout_column_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
    ),
  );

  $control_layout_column_tag = array(
    'key'     => 'layout_column_tag',
    'type'    => 'select',
    'label'   => __( 'Tag', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_tags' ),
  );

  $control_layout_column_font_size_and_tag = array(
    'type'     => 'group',
    'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
    'controls' => array(
      $control_layout_column_base_font_size,
      $control_layout_column_tag,
    ),
  );

  $control_layout_column_columns = array(
    'type'       => 'group',
    'label'      => '&nbsp;',
    'controls'   => array(
      array(
        'type'    => 'label',
        'label'   => __( 'Width', '__x__' ),
        'options' => array(
          'columns' => 3
        ),
      ),
      array(
        'type'    => 'label',
        'label'   => __( 'Height', '__x__' ),
        'options' => array(
          'columns' => 3
        ),
      ),
    ),
  );

  $control_layout_column_width = array(
    'key'     => 'layout_column_width',
    'type'    => 'unit',
    'options' => $options_layout_column_width_and_height,
  );

  $control_layout_column_height = array(
    'key'     => 'layout_column_height',
    'type'    => 'unit',
    'options' => $options_layout_column_width_and_height,
  );

  $control_layout_column_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Base', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_column_width,
      $control_layout_column_height,
    ),
  );

  $control_layout_column_min_width = array(
    'key'     => 'layout_column_min_width',
    'type'    => 'unit',
    'options' => $options_layout_column_min_width_and_min_height,
  );

  $control_layout_column_min_height = array(
    'key'     => 'layout_column_min_height',
    'type'    => 'unit',
    'options' => $options_layout_column_min_width_and_min_height,
  );

  $control_layout_column_min_width_and_min_height = array(
    'type'     => 'group',
    'label'    => __( 'Minimum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_column_min_width,
      $control_layout_column_min_height,
    ),
  );

  $control_layout_column_max_width = array(
    'key'     => 'layout_column_max_width',
    'type'    => 'unit',
    'options' => $options_layout_column_max_width_and_max_height,
  );

  $control_layout_column_max_height = array(
    'key'     => 'layout_column_max_height',
    'type'    => 'unit',
    'options' => $options_layout_column_max_width_and_max_height,
  );

  $control_layout_column_max_width_and_max_height = array(
    'type'     => 'group',
    'label'    => __( 'Maximum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_column_max_width,
      $control_layout_column_max_height,
    ),
  );

  $control_layout_column_text_align = array(
    'key'   => 'layout_column_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_layout_column_overflow = array(
    'key'     => 'layout_column_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  );

  $control_layout_column_z_index = array(
    'key'     => 'layout_column_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_column_overflow_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Overflow &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_column_overflow,
      $control_layout_column_z_index,
    ),
  );

  $control_layout_column_bg_color = array(
    'keys' => array(
      'value' => 'layout_column_bg_color',
      'alt'   => 'layout_column_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_layout_column_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_column_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_column_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_column_bg_color,
      $control_layout_column_bg_advanced
    ),
  );

  $control_layout_column_link = array(
    'keys' => array(
      'url'      => 'layout_column_href',
      'new_tab'  => 'layout_column_blank',
      'nofollow' => 'layout_column_nofollow',
    ),
    'type'      => 'link',
    'label'     => __( 'Link', '__x__' ),
    'group'     => 'layout_column:setup',
    'condition' => $condition_layout_column_is_anchor,
  );


  // Control Groups (Advanced)
  // -------------------------

  $control_group_layout_column_adv_setup = array(

  );


  // Control Groups (Standard)
  // -------------------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_column_sortable,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'layout_column:setup',
          'controls' => array(
            $control_layout_column_font_size_and_tag,
            $control_layout_column_columns,
            $control_layout_column_width_and_height,
            $control_layout_column_min_width_and_min_height,
            $control_layout_column_max_width_and_max_height,
            $control_layout_column_text_align,
            $control_layout_column_overflow_and_z_index,
            $control_layout_column_background,
          ),
        ),
        $control_layout_column_link,
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_layout_column_base_font_size,
            $control_layout_column_columns,
            $control_layout_column_width_and_height,
            $control_layout_column_min_width_and_min_height,
            $control_layout_column_max_width_and_max_height,
            $control_layout_column_text_align,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'layout_column_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'layout_column_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_layout_column_bg_color
          ),
        ),
        cs_control( 'border', 'layout_column', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'layout_column_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'layout_column_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'layout_column'           => __( 'Column', '__x__' ),
        'layout_column:setup'     => __( 'Setup', '__x__' ),
        'layout_column:design'    => __( 'Design', '__x__' ),
        'layout_column:particles' => __( 'Particles', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'group'     => 'layout_column:design',
      'condition' => array( 'layout_column_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'flexbox', 'layout_column', $settings_layout_column_design_flexbox ),
        cs_control( 'padding', 'layout_column', $settings_layout_column_design_no_color ),
        cs_control( 'border', 'layout_column', $settings_layout_column_design_with_color ),
        cs_control( 'border-radius', 'layout_column', $settings_layout_column_design_no_color ),
        cs_control( 'box-shadow', 'layout_column', $settings_layout_column_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Primary', '__x__' ),
      'k_pre'        => 'layout_column_primary',
      'group'        => 'layout_column:particles',
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Secondary', '__x__' ),
      'k_pre'        => 'layout_column_secondary',
      'group'        => 'layout_column:particles',
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'effects', array( 'has_provider' => true ) ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-column', $data );

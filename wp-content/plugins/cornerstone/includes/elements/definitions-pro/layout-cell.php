<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/LAYOUT-CELL.PHP
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
    'layout_cell_column_start_xs'       => cs_value( '', 'style', true ),
    'layout_cell_column_start_sm'       => cs_value( '', 'style', true ),
    'layout_cell_column_start_md'       => cs_value( '', 'style', true ),
    'layout_cell_column_start_lg'       => cs_value( '', 'style', true ),
    'layout_cell_column_start_xl'       => cs_value( '', 'style', true ),

    'layout_cell_column_end_xs'         => cs_value( '', 'style', true ),
    'layout_cell_column_end_sm'         => cs_value( '', 'style', true ),
    'layout_cell_column_end_md'         => cs_value( '', 'style', true ),
    'layout_cell_column_end_lg'         => cs_value( '', 'style', true ),
    'layout_cell_column_end_xl'         => cs_value( '', 'style', true ),

    'layout_cell_row_start_xs'          => cs_value( '', 'style', true ),
    'layout_cell_row_start_sm'          => cs_value( '', 'style', true ),
    'layout_cell_row_start_md'          => cs_value( '', 'style', true ),
    'layout_cell_row_start_lg'          => cs_value( '', 'style', true ),
    'layout_cell_row_start_xl'          => cs_value( '', 'style', true ),

    'layout_cell_row_end_xs'            => cs_value( '', 'style', true ),
    'layout_cell_row_end_sm'            => cs_value( '', 'style', true ),
    'layout_cell_row_end_md'            => cs_value( '', 'style', true ),
    'layout_cell_row_end_lg'            => cs_value( '', 'style', true ),
    'layout_cell_row_end_xl'            => cs_value( '', 'style', true ),

    'layout_cell_justify_self_xs'       => cs_value( 'auto', 'style', true ),
    'layout_cell_justify_self_sm'       => cs_value( 'auto', 'style', true ),
    'layout_cell_justify_self_md'       => cs_value( 'auto', 'style', true ),
    'layout_cell_justify_self_lg'       => cs_value( 'auto', 'style', true ),
    'layout_cell_justify_self_xl'       => cs_value( 'auto', 'style', true ),

    'layout_cell_align_self_xs'         => cs_value( 'auto', 'style', true ),
    'layout_cell_align_self_sm'         => cs_value( 'auto', 'style', true ),
    'layout_cell_align_self_md'         => cs_value( 'auto', 'style', true ),
    'layout_cell_align_self_lg'         => cs_value( 'auto', 'style', true ),
    'layout_cell_align_self_xl'         => cs_value( 'auto', 'style', true ),

    'layout_cell_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_cell_tag'                   => cs_value( 'div', 'markup' ),
    'layout_cell_width'                 => cs_value( 'auto', 'style' ),
    'layout_cell_min_width'             => cs_value( '0px', 'style' ),
    'layout_cell_max_width'             => cs_value( 'none', 'style' ),
    'layout_cell_height'                => cs_value( 'auto', 'style' ),
    'layout_cell_min_height'            => cs_value( '0px', 'style' ),
    'layout_cell_max_height'            => cs_value( 'none', 'style' ),
    'layout_cell_overflow'              => cs_value( 'visible', 'style' ),
    'layout_cell_z_index'               => cs_value( 'auto', 'style' ),
    'layout_cell_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_cell_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_cell_bg_advanced'           => cs_value( false, 'all' ),

    'layout_cell_href'                  => cs_value( '', 'markup', true ),
    'layout_cell_blank'                 => cs_value( false, 'markup', true ),
    'layout_cell_nofollow'              => cs_value( false, 'markup', true ),

    'layout_cell_flexbox'               => cs_value( false, 'style' ),
    'layout_cell_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_cell_flex_wrap'             => cs_value( true, 'style' ),
    'layout_cell_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_cell_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_cell_padding'               => cs_value( '!0px', 'style' ),
    'layout_cell_border_width'          => cs_value( '!0px', 'style' ),
    'layout_cell_border_style'          => cs_value( 'solid', 'style' ),
    'layout_cell_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_cell_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_cell_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_cell_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'layout_cell_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_cell_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  'bg',
  cs_values( 'particle', 'layout_cell_primary' ),
  cs_values( 'particle', 'layout_cell_secondary' ),
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

function x_element_style_layout_cell() {
  return x_get_view( 'styles/elements-pro', 'layout-cell', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_cell( $data ) {
  return x_get_view( 'elements-pro', 'layout-cell', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'    => __( 'Cell', '__x__' ),
  'values'   => $values,
  'builder'  => 'x_element_builder_setup_layout_cell',
  'style'    => 'x_element_style_layout_cell',
  'render'   => 'x_element_render_layout_cell',
  'icon'     => 'native',
  'children' => 'x_layout_cell',
  'tag_key'  => 'layout_cell_tag',
  'options'  => array(
    'valid_children'    => array( '*' ),
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'fallback_content'  => '&nbsp;',
    'dropzone'          => array(
      'enabled'     => true,
      'z_index_key' => 'layout_cell_z_index'
    ),
    'contrast_keys'     => array(
      'bg:layout_cell_bg_advanced',
      'layout_cell_bg_color'
    ),
    'side_effects' => [
      [
        'observe' => 'layout_cell_bg_advanced',
        'conditions' => [
          ['key' => 'layout_cell_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_cell_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_cell_z_index' => '1'
        ]
      ]
    ]
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_cell() {

  // Conditions
  // ----------

  $condition_layout_cell_is_anchor     = array( 'layout_cell_tag' => 'a' );
  $condition_layout_cell_is_not_anchor = array( 'key' => 'layout_cell_tag', 'op' => '!=', 'value' => 'a' );


  // Settings
  // --------

  $settings_layout_cell_design_no_color = array(
    'group' => 'layout_cell:design',
  );

  $settings_layout_cell_design_flexbox = array(
    'group'  => 'layout_cell:design',
    'toggle' => 'layout_cell_flexbox',
  );

  $settings_layout_cell_design_with_color = array(
    'group'     => 'layout_cell:design',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Options
  // -------

  $available_units_layout_cell           = array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' );
  $ranges_layout_cell_widths_and_heights = array(
    'px'   => array( 'min' => 0, 'max' => 1000, 'step' => 20 ),
    'em'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'rem'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    '%'    => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vw'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vh'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vmin' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    'vmax' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
  );

  $options_layout_cell_width_and_height = array(
    'available_units' => $available_units_layout_cell,
    'fallback_value'  => 'auto',
    'valid_keywords'  => array( 'auto', 'calc' ),
    'ranges'          => $ranges_layout_cell_widths_and_heights,
  );

  $options_layout_cell_min_width_and_min_height = array(
    'available_units' => $available_units_layout_cell,
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => $ranges_layout_cell_widths_and_heights,
  );

  $options_layout_cell_max_width_and_max_height = array(
    'available_units' => $available_units_layout_cell,
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => $ranges_layout_cell_widths_and_heights,
  );


  // Individual Controls
  // -------------------

  $control_layout_cell_sortable = array(
    'type'  => 'sortable',
    'label' => __( 'Children', '__x__' ),
    'group' => 'layout_cell:setup'
  );

  $control_layout_cell_layout = array(
    'keys' => array(
      'column_start_xs' => 'layout_cell_column_start_xs',
      'column_start_sm' => 'layout_cell_column_start_sm',
      'column_start_md' => 'layout_cell_column_start_md',
      'column_start_lg' => 'layout_cell_column_start_lg',
      'column_start_xl' => 'layout_cell_column_start_xl',
      'column_end_xs'   => 'layout_cell_column_end_xs',
      'column_end_sm'   => 'layout_cell_column_end_sm',
      'column_end_md'   => 'layout_cell_column_end_md',
      'column_end_lg'   => 'layout_cell_column_end_lg',
      'column_end_xl'   => 'layout_cell_column_end_xl',
      'row_start_xs'    => 'layout_cell_row_start_xs',
      'row_start_sm'    => 'layout_cell_row_start_sm',
      'row_start_md'    => 'layout_cell_row_start_md',
      'row_start_lg'    => 'layout_cell_row_start_lg',
      'row_start_xl'    => 'layout_cell_row_start_xl',
      'row_end_xs'      => 'layout_cell_row_end_xs',
      'row_end_sm'      => 'layout_cell_row_end_sm',
      'row_end_md'      => 'layout_cell_row_end_md',
      'row_end_lg'      => 'layout_cell_row_end_lg',
      'row_end_xl'      => 'layout_cell_row_end_xl',
      'justify_self_xs' => 'layout_cell_justify_self_xs',
      'justify_self_sm' => 'layout_cell_justify_self_sm',
      'justify_self_md' => 'layout_cell_justify_self_md',
      'justify_self_lg' => 'layout_cell_justify_self_lg',
      'justify_self_xl' => 'layout_cell_justify_self_xl',
      'align_self_xs'   => 'layout_cell_align_self_xs',
      'align_self_sm'   => 'layout_cell_align_self_sm',
      'align_self_md'   => 'layout_cell_align_self_md',
      'align_self_lg'   => 'layout_cell_align_self_lg',
      'align_self_xl'   => 'layout_cell_align_self_xl',
    ),
    'type'  => 'layout-cell',
    'label' => __( 'Cell Layout', '__x__' ),
    'group' => 'layout_cell:setup',
  );

  $control_layout_cell_base_font_size = array(
    'key'     => 'layout_cell_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
    ),
  );

  $control_layout_cell_tag = array(
    'key'     => 'layout_cell_tag',
    'type'    => 'select',
    'label'   => __( 'Tag', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_tags' ),
  );

  $control_layout_cell_font_size_and_tag = array(
    'type'     => 'group',
    'label'    => __( 'Base Font Size &amp; Tag', '__x__' ),
    'controls' => array(
      $control_layout_cell_base_font_size,
      $control_layout_cell_tag,
    ),
  );

  $control_layout_cell_columns = array(
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

  $control_layout_cell_width = array(
    'key'     => 'layout_cell_width',
    'type'    => 'unit',
    'options' => $options_layout_cell_width_and_height,
  );

  $control_layout_cell_height = array(
    'key'     => 'layout_cell_height',
    'type'    => 'unit',
    'options' => $options_layout_cell_width_and_height,
  );

  $control_layout_cell_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Base', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_cell_width,
      $control_layout_cell_height,
    ),
  );

  $control_layout_cell_min_width = array(
    'key'     => 'layout_cell_min_width',
    'type'    => 'unit',
    'options' => $options_layout_cell_min_width_and_min_height,
  );

  $control_layout_cell_min_height = array(
    'key'     => 'layout_cell_min_height',
    'type'    => 'unit',
    'options' => $options_layout_cell_min_width_and_min_height,
  );

  $control_layout_cell_min_width_and_min_height = array(
    'type'     => 'group',
    'label'    => __( 'Minimum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_cell_min_width,
      $control_layout_cell_min_height,
    ),
  );

  $control_layout_cell_max_width = array(
    'key'     => 'layout_cell_max_width',
    'type'    => 'unit',
    'options' => $options_layout_cell_max_width_and_max_height,
  );

  $control_layout_cell_max_height = array(
    'key'     => 'layout_cell_max_height',
    'type'    => 'unit',
    'options' => $options_layout_cell_max_width_and_max_height,
  );

  $control_layout_cell_max_width_and_max_height = array(
    'type'     => 'group',
    'label'    => __( 'Maximum', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_layout_cell_max_width,
      $control_layout_cell_max_height,
    ),
  );

  $control_layout_cell_overflow = array(
    'key'     => 'layout_cell_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => cs_recall( 'options_choices_layout_overflow' ),
  );

  $control_layout_cell_z_index = array(
    'key'     => 'layout_cell_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_cell_overflow_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Overflow &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_cell_overflow,
      $control_layout_cell_z_index,
    ),
  );

  $control_layout_cell_bg_color = array(
    'keys' => array(
      'value' => 'layout_cell_bg_color',
      'alt'   => 'layout_cell_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_layout_cell_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_cell_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_cell_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_cell_bg_color,
      $control_layout_cell_bg_advanced
    ),
  );

  $control_layout_cell_link = array(
    'keys' => array(
      'url'      => 'layout_cell_href',
      'new_tab'  => 'layout_cell_blank',
      'nofollow' => 'layout_cell_nofollow',
    ),
    'type'      => 'link',
    'label'     => __( 'Link', '__x__' ),
    'group'     => 'layout_cell:setup',
    'condition' => $condition_layout_cell_is_anchor,
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_cell_sortable,
        $control_layout_cell_layout,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'layout_cell:setup',
          'controls' => array(
            $control_layout_cell_font_size_and_tag,
            $control_layout_cell_columns,
            $control_layout_cell_width_and_height,
            $control_layout_cell_min_width_and_min_height,
            $control_layout_cell_max_width_and_max_height,
            $control_layout_cell_overflow_and_z_index,
            $control_layout_cell_background,
          ),
        ),
        $control_layout_cell_link,
      ),
      'controls_std_design_setup' => array(
        $control_layout_cell_layout,
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_layout_cell_base_font_size,
            $control_layout_cell_columns,
            $control_layout_cell_width_and_height,
            $control_layout_cell_min_width_and_min_height,
            $control_layout_cell_max_width_and_max_height,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'layout_cell_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'layout_cell_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_layout_cell_bg_color
          ),
        ),

        cs_control( 'border', 'layout_cell', array(
          'k_pre' => 'layout_cell',
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'layout_cell_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'layout_cell_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )

      ),
      'control_nav' => array(
        'layout_cell'           => __( 'Cell', '__x__' ),
        'layout_cell:setup'     => __( 'Setup', '__x__' ),
        'layout_cell:design'    => __( 'Design', '__x__' ),
        'layout_cell:particles' => __( 'Particles', '__x__' ),
      ),
    ),
    cs_partial_controls( 'bg', array(
      'group'      => 'layout_cell:design',
      'condition' => array( 'layout_cell_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'flexbox', 'layout_cell', $settings_layout_cell_design_flexbox ),
        cs_control( 'padding', 'layout_cell', $settings_layout_cell_design_no_color ),
        cs_control( 'border', 'layout_cell', $settings_layout_cell_design_with_color ),
        cs_control( 'border-radius', 'layout_cell', $settings_layout_cell_design_no_color ),
        cs_control( 'box-shadow', 'layout_cell', $settings_layout_cell_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Primary', '__x__' ),
      'k_pre'        => 'layout_cell_primary',
      'group'        => 'layout_cell:particles',
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'particle', array(
      'label_prefix' => __( 'Secondary', '__x__' ),
      'k_pre'        => 'layout_cell_secondary',
      'group'        => 'layout_cell:particles',
      'conditions'   => $conditions,
    ) ),
    cs_partial_controls( 'effects', array( 'has_provider' => true ) ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-cell', $data );

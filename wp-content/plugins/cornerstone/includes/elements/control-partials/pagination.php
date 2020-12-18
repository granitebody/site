<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PAGINATION.PHP
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

function x_control_partial_pagination( $settings ) {

  // Setup
  // -----
  // 01. Types available include...
  //     - 'comment'  : for paginating comments, can be numbered
  //     - 'post'     : for paginating posts on indexes, can be numbered
  //     - 'product'  : for paginating products on indexes, can be numbered
  //     - 'post-nav' : for navigating amongst posts while on single posts

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'post'; // 01


  // Groups
  // ------

  $group           = 'pagination';
  $group_setup     = $group . ':setup';
  $group_design    = $group . ':design';
  $group_items     = $group . ':items';
  $group_current   = $group . ':current';
  $group_dots      = $group . ':dots';
  $group_prev_next = $group . ':prevnext';


  // Conditions
  // ----------

  $condition_pagination_is_numbered      = array( 'key' => 'pagination_numbered_hide', 'op' => 'IN', 'value' => array( 'none', 'xs', 'sm', 'md', 'lg' ) );
  $condition_pagination_items_type_text  = array( 'pagination_items_prev_next_type' => 'text' );
  $condition_pagination_items_type_icon  = array( 'pagination_items_prev_next_type' => 'icon' );


  // Options
  // -------

  $options_pagination_numbered_hide = array(
    'off_value' => 'none',
    'choices'   => array(
      array( 'value' => 'xl', 'icon' => 'ui:size-xl' ),
      array( 'value' => 'lg', 'icon' => 'ui:size-lg' ),
      array( 'value' => 'md', 'icon' => 'ui:size-md' ),
      array( 'value' => 'sm', 'icon' => 'ui:size-sm' ),
      array( 'value' => 'xs', 'icon' => 'ui:size-xs' ),
    ),
  );

  $options_pagination_end_and_mid_size = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => 1,
    'min'            => 0,
    'max'            => 5,
    'step'           => 1,
  );

  $options_pagination_base_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 14,  'max' => 32, 'step' => 1   ),
      'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
      'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
    ),
  );

  $options_pagination_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'auto' ),
    'fallback_value'  => 'auto',
  );

  $options_pagination_max_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'valid_keywords'  => array( 'none' ),
    'fallback_value'  => 'none',
  );

  $options_pagination_flex_justify = array(
    'choices' => array(
      array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )         ),
      array( 'value' => 'center',        'label' => __( 'Center', '__x__' )        ),
      array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )           ),
      array( 'value' => 'space-between', 'label' => __( 'Space Between', '__x__' ) ),
      array( 'value' => 'space-around',  'label' => __( 'Space Around', '__x__' )  ),
      array( 'value' => 'space-evenly',  'label' => __( 'Space Evenly', '__x__' )  ),
    ),
  );

  $options_pagination_items_prev_next_type = array(
    'choices' => array(
      array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
      array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
    ),
  );

  $options_pagination_items_min_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '2em',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 5,   'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 5,   'step' => 0.1 ),
    ),
  );

  $options_pagination_items_gap = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '0px',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 10, 'step' => 1   ),
      'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
      'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
    ),
  );

  $options_pagination_items_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 14,  'max' => 32, 'step' => 1   ),
      'em'  => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
      'rem' => array( 'min' => 0.5, 'max' => 2,  'step' => 0.1 ),
    ),
  );


  // Settings
  // --------

  $settings_pagination_design = array(
    'group' => $group_design,
  );

  $settings_pagination_items_text = array(
    'group'              => $group_items,
    'label_prefix'       => __( 'Items', '__x__' ),
    'no_letter_spacing'  => true,
    'no_line_height'     => true,
    'no_text_align'      => true,
    'no_text_decoration' => true,
    'no_text_transform'  => true,
    'alt_color'          => true,
    'options'            => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );

  $settings_pagination_items_design = array(
    'group'        => $group_items,
    'label_prefix' => __( 'Items', '__x__' ),
  );

  $settings_pagination_items_design_color = array(
    'group'        => $group_items,
    'label_prefix' => __( 'Items', '__x__' ),
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Base
  // --------------------------

  $control_pagination_numbered_hide = array(
    'key'     => 'pagination_numbered_hide',
    'type'    => 'choose',
    'label'   => __( 'Breakpoint to Hide #', '__x__' ),
    'options' => $options_pagination_numbered_hide,
  );

  $control_pagination_numbered_end_size = array(
    'key'     => 'pagination_numbered_end_size',
    'type'    => 'unit',
    'label'   => __( 'End # Count', '__x__' ),
    'options' => $options_pagination_end_and_mid_size,
  );

  $control_pagination_numbered_mid_size = array(
    'key'     => 'pagination_numbered_mid_size',
    'type'    => 'unit',
    'label'   => __( 'Mid # Count', '__x__' ),
    'options' => $options_pagination_end_and_mid_size,
  );

  $control_pagination_numbered_end_and_mid_size = array(
    'type'      => 'group',
    'label'     => __( 'End &amp; Mid # Count', '__x__' ),
    'condition' => $condition_pagination_is_numbered,
    'controls'  => array(
      $control_pagination_numbered_end_size,
      $control_pagination_numbered_mid_size,
    ),
  );

  $control_pagination_base_font_size = array(
    'key'     => 'pagination_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => $options_pagination_base_font_size,
  );

  $control_pagination_width = array(
    'key'     => 'pagination_width',
    'type'    => 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_pagination_width,
  );

  $control_pagination_max_width = array(
    'key'     => 'pagination_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => $options_pagination_max_width,
  );

  $control_pagination_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_pagination_width,
      $control_pagination_max_width,
    ),
  );

  $control_pagination_flex_justify = array(
    'key'     => 'pagination_flex_justify',
    'type'    => 'select',
    'label'   => __( 'Justify', '__x__' ),
    'options' => $options_pagination_flex_justify,
  );

  $control_pagination_bg_color = array(
    'keys' => array(
      'value' => 'pagination_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_pagination_justify_and_background = array(
    'type'     => 'group',
    'label'    => __( 'Justify &amp; Background', '__x__' ),
    'controls' => array(
      $control_pagination_flex_justify,
      $control_pagination_bg_color,
    ),
  );


  // Individual Controls - Items
  // ---------------------------

  $control_pagination_items_prev_next_type = array(
    'key'     => 'pagination_items_prev_next_type',
    'type'    => 'choose',
    'label'   => __( 'Prev / Next Type', '__x__' ),
    'options' => $options_pagination_items_prev_next_type,
  );

  $control_pagination_items_prev_icon = array(
    'key'       => 'pagination_items_prev_icon',
    'type'      => 'icon',
    'label'     => __( 'Previous', '__x__' ),
    'condition' => $condition_pagination_items_type_icon,
  );

  $control_pagination_items_next_icon = array(
    'key'       => 'pagination_items_next_icon',
    'type'      => 'icon',
    'label'     => __( 'Next', '__x__' ),
    'condition' => $condition_pagination_items_type_icon,
  );

  $control_pagination_items_prev_next_icon = array(
    'type'      => 'group',
    'label'     => __( 'Prev / Next Icons', '__x__' ),
    'condition' => $condition_pagination_items_type_icon,
    'controls'  => array(
      $control_pagination_items_prev_icon,
      $control_pagination_items_next_icon,
    ),
  );

  $control_pagination_items_prev_text = array(
    'key'       => 'pagination_items_prev_text',
    'type'      => 'text',
    'label'     => __( 'Previous', '__x__' ),
    'condition' => $condition_pagination_items_type_text,
  );

  $control_pagination_items_next_text = array(
    'key'       => 'pagination_items_next_text',
    'type'      => 'text',
    'label'     => __( 'Next', '__x__' ),
    'condition' => $condition_pagination_items_type_text,
  );

  $control_pagination_items_prev_next_text = array(
    'type'      => 'group',
    'label'     => __( 'Prev / Next Text', '__x__' ),
    'condition' => $condition_pagination_items_type_text,
    'controls'  => array(
      $control_pagination_items_prev_text,
      $control_pagination_items_next_text,
    ),
  );

  $control_pagination_items_min_width = array(
    'key'     => 'pagination_items_min_width',
    'type'    => 'unit',
    'label'   => __( 'Min Width', '__x__' ),
    'options' => $options_pagination_items_min_width_and_height,
  );

  $control_pagination_items_min_height = array(
    'key'     => 'pagination_items_min_height',
    'type'    => 'unit',
    'label'   => __( 'Min Height', '__x__' ),
    'options' => $options_pagination_items_min_width_and_height,
  );

  $control_pagination_items_min_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Min Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_pagination_items_min_width,
      $control_pagination_items_min_height,
    ),
  );

  $control_pagination_items_gap = array(
    'key'     => 'pagination_items_gap',
    'type'    => 'unit',
    'label'   => __( 'Gap', '__x__' ),
    'options' => $options_pagination_items_gap,
  );

  $control_pagination_items_grow = array(
    'keys' => array(
      'grow' => 'pagination_items_grow',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Grow', '__x__' ),
    'options' => array(
      'list' => array(
        array( 'key' => 'grow', 'label' => __( 'Fill Space', '__x__' ) ),
      ),
    ),
  );

  $control_pagination_items_gap_and_grow = array(
    'type'     => 'group',
    'label'    => __( 'Gap &amp; Grow', '__x__' ),
    'controls' => array(
      $control_pagination_items_gap,
      $control_pagination_items_grow,
    ),
  );

  $control_pagination_items_bg_colors = array(
    'keys' => array(
      'value' => 'pagination_items_bg_color',
      'alt'   => 'pagination_items_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Current
  // -----------------------------

  $control_pagination_current_text_color = array(
    'keys' => array(
      'value' => 'pagination_current_text_color',
    ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  );

  $control_pagination_current_border_color = array(
    'keys' => array(
      'value' => 'pagination_current_border_color',
    ),
    'type'  => 'color',
    'label' => __( 'Border', '__x__' ),
  );

  $control_pagination_current_box_shadow_color = array(
    'keys' => array(
      'value' => 'pagination_current_box_shadow_color',
    ),
    'type'  => 'color',
    'label' => __( 'Box Shadow', '__x__' ),
  );

  $control_pagination_current_bg_color = array(
    'keys' => array(
      'value' => 'pagination_current_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Individual Controls - Dots
  // --------------------------

  $control_pagination_dots_text_color = array(
    'keys' => array(
      'value' => 'pagination_dots_text_color',
    ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  );

  $control_pagination_dots_border_color = array(
    'keys' => array(
      'value' => 'pagination_dots_border_color',
    ),
    'type'  => 'color',
    'label' => __( 'Border', '__x__' ),
  );

  $control_pagination_dots_box_shadow_color = array(
    'keys' => array(
      'value' => 'pagination_dots_box_shadow_color',
    ),
    'type'  => 'color',
    'label' => __( 'Box Shadow', '__x__' ),
  );

  $control_pagination_dots_bg_color = array(
    'keys' => array(
      'value' => 'pagination_dots_bg_color',
    ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Individual Controls - Prev / Next
  // ---------------------------------

  $control_pagination_prev_next_text_color = array(
    'keys' => array(
      'value' => 'pagination_prev_next_text_color',
      'alt'   => 'pagination_prev_next_text_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_pagination_prev_next_border_color = array(
    'keys' => array(
      'value' => 'pagination_prev_next_border_color',
      'alt'   => 'pagination_prev_next_border_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Border', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_pagination_prev_next_box_shadow_color = array(
    'keys' => array(
      'value' => 'pagination_prev_next_box_shadow_color',
      'alt'   => 'pagination_prev_next_box_shadow_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Box Shadow', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );

  $control_pagination_prev_next_bg_color = array(
    'keys' => array(
      'value' => 'pagination_prev_next_bg_color',
      'alt'   => 'pagination_prev_next_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
  );


  // Compose Controls
  // ----------------

  $controls_pagination_setup = array();

  if ( $type !== 'post-nav' ) {
    $controls_pagination_setup[] = $control_pagination_numbered_hide;
    $controls_pagination_setup[] = $control_pagination_numbered_end_and_mid_size;
  }

  $controls_pagination_setup[] = $control_pagination_base_font_size;
  $controls_pagination_setup[] = $control_pagination_width_and_max_width;
  $controls_pagination_setup[] = $control_pagination_justify_and_background;

  return array(

    'controls' => array(
      array(
        'type'     => 'group',
        'label'    => __( 'Setup', '__x__' ),
        'group'    => $group_setup,
        'controls' => $controls_pagination_setup,
      ),
      cs_control( 'margin', 'pagination', $settings_pagination_design ),
      cs_control( 'padding', 'pagination', $settings_pagination_design ),
      cs_control( 'border', 'pagination', $settings_pagination_design ),
      cs_control( 'border-radius', 'pagination', $settings_pagination_design ),
      cs_control( 'box-shadow', 'pagination', $settings_pagination_design ),
      array(
        'type'     => 'group',
        'label'    => __( 'Items Setup', '__x__' ),
        'group'    => $group_items,
        'controls' => array(
          $control_pagination_items_prev_next_type,
          $control_pagination_items_prev_next_icon,
          $control_pagination_items_prev_next_text,
          $control_pagination_items_min_width_and_height,
          $control_pagination_items_gap_and_grow,
          $control_pagination_items_bg_colors,
        ),
      ),
      cs_control( 'padding', 'pagination_items', $settings_pagination_items_design ),
      cs_control( 'border', 'pagination_items', $settings_pagination_items_design_color ),
      cs_control( 'border-radius', 'pagination_items', $settings_pagination_items_design ),
      cs_control( 'box-shadow', 'pagination_items', $settings_pagination_items_design_color ),
      cs_control( 'text-format', 'pagination_items', $settings_pagination_items_text ),
      array(
        'type'      => 'group',
        'label'     => __( 'Current', '__x__' ),
        'group'     => $group_current,
        'condition' => $condition_pagination_is_numbered,
        'controls'  => array(
          $control_pagination_current_text_color,
          $control_pagination_current_border_color,
          $control_pagination_current_box_shadow_color,
          $control_pagination_current_bg_color,
        ),
      ),
      array(
        'key'       => 'pagination_dots',
        'type'      => 'group',
        'label'     => __( 'Dots', '__x__' ),
        'group'     => $group_dots,
        'options'   => cs_recall( 'options_group_toggle_off_on_bool' ),
        'condition' => $condition_pagination_is_numbered,
        'controls'  => array(
          $control_pagination_dots_text_color,
          $control_pagination_dots_border_color,
          $control_pagination_dots_box_shadow_color,
          $control_pagination_dots_bg_color,
        ),
      ),
      array(
        'key'       => 'pagination_prev_next',
        'type'      => 'group',
        'label'     => __( 'Prev / Next', '__x__' ),
        'group'     => $group_prev_next,
        'options'   => cs_recall( 'options_group_toggle_off_on_bool' ),
        'condition' => $condition_pagination_is_numbered,
        'controls'  => array(
          $control_pagination_prev_next_text_color,
          $control_pagination_prev_next_border_color,
          $control_pagination_prev_next_box_shadow_color,
          $control_pagination_prev_next_bg_color,
        ),
      ),
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
          array(
            'key'     => 'pagination_font_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '1em',
              'ranges'          => array(
                'px'  => array( 'min' => 14,  'max' => 64, 'step' => 1    ),
                'em'  => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
                'rem' => array( 'min' => 0.5, 'max' => 5,  'step' => 0.05 ),
              ),
            ),
          ),
          cs_amend_control( $control_pagination_width, array( 'type' => 'unit-slider') ),
          cs_amend_control( $control_pagination_max_width, array( 'type' => 'unit-slider') ),
        ),
      ),
      cs_control( 'margin', 'pagination' )
    ),


    'controls_std_design_colors' => array(
      array(
        'type'     => 'group',
        'label'    => __( 'Base Colors', '__x__' ),
        'controls' => array(
          array(
            'keys'      => array( 'value' => 'pagination_box_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Box<br>Shadow', '__x__' ),
            'condition' => array( 'key' => 'pagination_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
          ),
          $control_pagination_bg_color,
        ),
      ),
    ),


    'control_nav' => array(
      $group           => __( 'Pagination', '__x__' ),
      $group_setup     => __( 'Setup', '__x__' ),
      $group_design    => __( 'Design', '__x__' ),
      $group_items     => __( 'Items', '__x__' ),
      $group_current   => __( 'Current', '__x__' ),
      $group_dots      => __( 'Dots', '__x__' ),
      $group_prev_next => __( 'Prev / Next', '__x__' ),
    ),
  );

}

cs_register_control_partial( 'pagination', 'x_control_partial_pagination' );

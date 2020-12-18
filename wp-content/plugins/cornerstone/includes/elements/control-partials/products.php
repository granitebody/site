<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PRODUCTS.PHP
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

function x_control_partial_products( $settings ) {

  // Setup
  // -----
  // 01. Types available include...
  //     - 'cross-sells'
  //     - 'upsells'
  //     - 'related'

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'related'; // 01


  // Groups
  // ------

  $group        = 'products';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Conditions
  // ----------

  $condition_products_is_numbered      = array( 'key' => 'products_numbered_hide', 'op' => 'IN', 'value' => array( 'none', 'xs', 'sm', 'md', 'lg' ) );
  $condition_products_items_type_text  = array( 'products_items_prev_next_type' => 'text' );
  $condition_products_items_type_icon  = array( 'products_items_prev_next_type' => 'icon' );


  // Options
  // -------

  $options_products_count_choose = array(
    'choices' => array(
      array( 'value' => 1, 'label' => '1' ),
      array( 'value' => 2, 'label' => '2' ),
      array( 'value' => 3, 'label' => '3' ),
      array( 'value' => 4, 'label' => '4' ),
    ),
  );

  $options_products_count_slider = array(
    'unit_mode'      => 'unitless',
    'fallback_value' => 4,
    'min'            => 1,
    'max'            => 12,
    'step'           => 1,
  );

  $options_products_columns = array(
    'choices' => array(
      array( 'value' => 1, 'label' => '1' ),
      array( 'value' => 2, 'label' => '2' ),
      array( 'value' => 3, 'label' => '3' ),
      array( 'value' => 4, 'label' => '4' ),
    ),
  );

  $options_products_orderby = array(
    'choices' => array(
      array( 'value' => 'rand',       'label' => __( 'Random', '__x__' )     ),
      array( 'value' => 'title',      'label' => __( 'Title', '__x__' )      ),
      array( 'value' => 'ID',         'label' => __( 'ID', '__x__' )         ),
      array( 'value' => 'date',       'label' => __( 'Date', '__x__' )       ),
      array( 'value' => 'modified',   'label' => __( 'Modified', '__x__' )   ),
      array( 'value' => 'menu_order', 'label' => __( 'Menu Order', '__x__' ) ),
      array( 'value' => 'price',      'label' => __( 'Price', '__x__' )      ),
    ),
  );

  $options_products_order = array(
    'choices' => array(
      array( 'value' => 'desc', 'label' => __( 'Desc', '__x__' ) ),
      array( 'value' => 'asc',  'label' => __( 'Asc', '__x__' )  ),
    ),
  );


  // Settings
  // --------

  $settings_products_design = array(
    'group' => $group_design,
  );


  // Individual Controls - Base
  // --------------------------

  $control_products_count_choose = array(
    'key'     => 'products_count',
    'type'    => 'choose',
    'label'   => __( 'Count', '__x__' ),
    'options' => $options_products_count_choose,
  );

  $control_products_count_slider = array(
    'key'     => 'products_count',
    'type'    => 'unit-slider',
    'label'   => __( 'Count', '__x__' ),
    'options' => $options_products_count_slider,
  );

  $control_products_columns = array(
    'key'     => 'products_columns',
    'type'    => 'choose',
    'label'   => __( 'Columns', '__x__' ),
    'options' => $options_products_columns,
  );

  $control_products_orderby = array(
    'key'     => 'products_orderby',
    'type'    => 'select',
    'label'   => __( 'Orderby', '__x__' ),
    'options' => $options_products_orderby,
  );

  $control_products_order = array(
    'key'     => 'products_order',
    'type'    => 'choose',
    'label'   => __( 'Order', '__x__' ),
    'options' => $options_products_order,
  );


  // Compose Controls
  // ----------------

  $controls_products_setup = array(
    $control_products_count_slider,
    $control_products_columns,
    $control_products_orderby,
    $control_products_order,
  );

  return array(

    'controls' => array(
      array(
        'type'     => 'group',
        'label'    => __( 'Setup', '__x__' ),
        'group'    => $group_setup,
        'controls' => $controls_products_setup,
      ),
      cs_control( 'margin', 'products', $settings_products_design ),
    ),


    'controls_std_content' => array(

    ),


    'controls_std_design_setup' => array(

    ),


    'controls_std_design_colors' => array(

    ),


    'control_nav' => array(
      $group           => __( 'Products', '__x__' ),
      $group_setup     => __( 'Setup', '__x__' ),
      $group_design    => __( 'Design', '__x__' ),
    ),
  );

}

cs_register_control_partial( 'products', 'x_control_partial_products' );

<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/CONTENT-AREA.PHP
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

function x_control_partial_content_area( $settings ) {

  // Setup
  // -----

  // 01. Available types:
  //     -- 'standard'
  //     -- 'dropdown'
  //     -- 'modal'
  //     -- 'off-canvas'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'content_area';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : __( 'Content Area', '__x__' );
  $condition    = ( isset( $settings['condition'] )    ) ? $settings['condition']    : array();
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'standard'; // 01


  // Groups
  // ------

  $group_content_area_setup  = $group . ':setup';
  $group_content_area_design = $group . ':design';


  // Individual Controls
  // -------------------

  $control_content_area_content = array(
    'key'     => $k_pre . 'content',
    'type'    => 'text-editor',
    'label'   => __( 'Content', '__x__' ),
    'group'   => $group_content_area_setup,
    'options' => array(
      'mode'   => 'html',
      'height' => $type != 'standard' ? 4 : 5,
    ),
  );

  $control_content_area_dynamic_rendering = array(
    'keys' => array(
      'dynamic_rendering' => $k_pre . 'content_dynamic_rendering',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Dynamic Rendering', '__x__' ),
    'group'   => $group_content_area_setup,
    'options' => array(
      'list' => array(
        array( 'key' => 'dynamic_rendering', 'label' => __( 'Load / reset on element toggle', '__x__' ), 'full' => true ),
      ),
    ),
  );



  // Control Groups
  // --------------

  $controls_content_area = array();

  if ( $type != 'standard' ) {

    $controls_content_area[] = array(
      'type'     => 'group',
      'label'      => __( '{{prefix}} Content', '__x__' ),
      'label_vars' => array( 'prefix' => $label_prefix ),
      'group'    => $group_content_area_setup,
      'controls' => array(
        $control_content_area_content,
        $control_content_area_dynamic_rendering,
      ),
    );

  } else {

    $controls_content_area[] = $control_content_area_content;
    $controls_content_area[] = cs_control( 'margin', 'content', array( 'group' => $group_content_area_design ) );

  }


  // Control Nav
  // -----------

  $control_nav_content_area = array(
    $group                    => $group_title,
    $group_content_area_setup => __( 'Setup', '__x__' ),
  );

  if ( $type == 'standard' ) {
    $control_nav_content_area[$group_content_area_design] = __( 'Design', '__x__' );
  }



  // Compose Controls
  // ----------------

  return array(
    'controls'             => $controls_content_area,
    'controls_std_content' => $controls_content_area,
    'control_nav'          => $control_nav_content_area
  );
}

cs_register_control_partial( 'content-area', 'x_control_partial_content_area' );

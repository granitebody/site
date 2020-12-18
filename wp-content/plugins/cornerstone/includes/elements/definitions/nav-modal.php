<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-MODAL.PHP
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
  'menu-modal',
  'toggle',
  'modal',
  'menu-item',
  array(
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_nav_modal() {
  $style = cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-anchor-toggle',
    'key_prefix' => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor-toggle',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'], // '[data-x-particle]'
  ) );

  $style .= cs_get_partial_style( 'modal' );
  $style .= cs_get_partial_style( 'menu' );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-menu .x-anchor',
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_nav_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', '__x__' ),
    ), $data['id'], $data['unique_id'] )
  );

  cs_defer_partial( 'x_before_site_end', 'modal', array_merge(
    cs_extract( $data, array( 'modal' => '' ) ),
    array(
      'modal_content' => cs_get_partial_view(
        'menu',
        cs_extract( $data, array( 'menu' => '', 'anchor' => '', 'sub_anchor' => '' ) )
      )
    )
  ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ) ) );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Navigation Modal', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_nav_modal',
  'style'   => 'x_element_style_nav_modal',
  'render'  => 'x_element_render_nav_modal',
  'icon'    => 'native'
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'modal' ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'group'            => 'menu_item_anchor',
      'group_title'      => __( 'Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-modal', $data );

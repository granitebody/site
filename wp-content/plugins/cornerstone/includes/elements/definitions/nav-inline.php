<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-INLINE.PHP
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
  'menu-inline',
  'dropdown',
  'menu-item',
  cs_values( 'menu-item', 'sub' ),
  array(
    'anchor_padding'          => cs_value( '0.75em', 'style' ),
    'sub_anchor_padding'      => cs_value( '0.75em', 'style' ),
    'sub_anchor_text_margin'  => cs_value( '5px auto 5px 5px', 'style' ),
    'sub_anchor_flex_justify' => cs_value( 'flex-start', 'style' )    
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega'
);



// Style
// =============================================================================

function x_element_style_nav_inline() {
  $style = cs_get_partial_style( 'menu' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-menu',
    'children' => [],
  ) );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector'   => '.x-menu > li > .x-anchor',
    'key_prefix' => ''
  ) );

  $style .= cs_get_partial_style( 'dropdown' );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector'   => ' .sub-menu .x-anchor',
    'key_prefix' => 'sub'
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_nav_inline( $data ) {
  return cs_get_partial_view( 'menu', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Navigation Inline', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_nav_inline',
  'style'   => 'x_element_style_nav_inline',
  'render'  => 'x_element_render_nav_inline',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_inline() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', array( 'type' => 'inline' ) ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'group'            => 'top_menu_item_anchor',
      'group_title'      => __( 'Top Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Top Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'menu-item',
      'k_pre'            => 'sub',
      'group'            => 'sub_menu_item_anchor',
      'group_title'      => __( 'Sub Links', '__x__' ),
      'is_nested'        => true,
      'label_prefix_std' => __( 'Sub Menu Items', '__x__' )
    ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-inline', $data );

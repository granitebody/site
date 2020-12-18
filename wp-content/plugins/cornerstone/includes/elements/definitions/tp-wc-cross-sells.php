<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CROSS-SELLS.PHP
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
  'products:cross-sells',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_cross_sells() {
  $style = cs_get_partial_style( 'products' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-wc-products',
    'children'   => [],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_wc_cross_sells( $data ) {
  return cs_get_partial_view( 'products', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Cross Sells', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tp_wc_cross_sells',
  'style'   => 'x_element_style_tp_wc_cross_sells',
  'render'  => 'x_element_render_tp_wc_cross_sells',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cross_sells() {
  return cs_compose_controls(
    cs_partial_controls( 'products', array( 'type' => 'cross-sells' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cross-sells', $data );

<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-SHOP-NOTICES.PHP
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
    'shop_notices_margin' => cs_value( '0em', 'style' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_notices() {
  return x_get_view( 'styles/elements', 'tp-wc-shop-notices', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tp_wc_notices( $data ) {
  return x_get_view( 'elements', 'tp-wc-shop-notices', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Shop Notices', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tp_wc_notices',
  'style'   => 'x_element_style_tp_wc_notices',
  'render'  => 'x_element_render_tp_wc_notices',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_notices() {

  return cs_compose_controls(
    array(
      'controls' => array(
        cs_control( 'margin', 'shop_notices', array( 'group' => 'shop_notices:design') ),
      ),
      'control_nav' => array(
        'shop_notices'        => __( 'Shop Notices', '__x__' ),
        'shop_notices:setup'  => __( 'Setup', '__x__' ),
        'shop_notices:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-shop-notices', $data );

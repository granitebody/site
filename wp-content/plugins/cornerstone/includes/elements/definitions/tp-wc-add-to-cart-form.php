<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-ADD-TO-CART-FORM.PHP
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
    'add_to_cart_form_margin' => cs_value( '0em', 'style' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_add_to_cart_form() {
  return x_get_view( 'styles/elements', 'tp-wc-add-to-cart-form', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tp_wc_add_to_cart_form( $data ) {
  return x_get_view( 'elements', 'tp-wc-add-to-cart-form', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Add to Cart Form', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tp_wc_add_to_cart_form',
  'style'   => 'x_element_style_tp_wc_add_to_cart_form',
  'render'  => 'x_element_render_tp_wc_add_to_cart_form',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_add_to_cart_form() {

  return cs_compose_controls(
    array(
      'controls' => array(
        cs_control( 'margin', 'add_to_cart_form', array( 'group' => 'add_to_cart_form:design') ),
      ),
      'control_nav' => array(
        'add_to_cart_form'        => __( 'Add to Cart Form', '__x__' ),
        'add_to_cart_form:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-add-to-cart-form', $data );

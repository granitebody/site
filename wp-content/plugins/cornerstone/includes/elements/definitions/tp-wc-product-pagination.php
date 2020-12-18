<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-PRODUCT-PAGINATION.PHP
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
  'pagination:product',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_product_pagination() {
  $style = cs_get_partial_style( 'pagination' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-paginate',
    'children'   => ['.x-paginate-inner > *'],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_product_pagination( $data ) {
  return cs_get_partial_view( 'pagination', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Product Pagination', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_product_pagination',
  'style'   => 'x_element_style_product_pagination',
  'render'  => 'x_element_render_product_pagination',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_product_pagination() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', array( 'type' => 'product' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-product-pagination', $data );

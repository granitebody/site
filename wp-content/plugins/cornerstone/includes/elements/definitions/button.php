<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BUTTON.PHP
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
// Prefixed: cs_values('effects', 'button')

$values = cs_compose_values(
  'anchor-button',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_button() {
  $style = cs_get_partial_style( 'anchor' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector' => '.x-anchor',
    'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'], // '[data-x-particle]'
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_button( $data ) {
  return cs_get_partial_view( 'anchor', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Button', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_button',
  'render'  => 'x_element_render_button',
  'style'   => 'x_element_style_button',
  'icon'    => 'native',
  'options' => array(
    'inline' => array(
      'anchor_text_primary_content' => array(
        'selector' => '.x-anchor-text-primary'
      ),
      'anchor_text_secondary_content' => array(
        'selector' => '.x-anchor-text-secondary'
      )
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_button() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', array(
      'type'             => 'button',
      'has_link_control' => true,
      'group'            => 'button_anchor',
      'group_title'      => __( 'Button', '__x__' ),
    ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'button', $data );

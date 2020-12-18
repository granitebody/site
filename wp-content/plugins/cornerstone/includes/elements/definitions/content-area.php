<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA.PHP
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
  'content-area',
  'content-area-margin',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_style_content_area() {
  $style = cs_get_partial_style( 'content-area' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-content-area',
    'children'   => [],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_content_area( $data ) {
  return x_get_view( 'elements', 'content-area', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Content Area', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_content_area',
  'style'   => 'x_element_style_content_area',
  'render'  => 'x_element_render_content_area',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area() {
  return array_merge(
    cs_compose_controls(
      cs_partial_controls( 'content-area', array( 'type' => 'standard' ) ),
      cs_partial_controls( 'effects' ),
      cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
    ),
    array(
      'options' => array(
        'inline' => array(
          'content' => array(
            'selector' => 'root'
          ),
        )
      )
    )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area', $data );

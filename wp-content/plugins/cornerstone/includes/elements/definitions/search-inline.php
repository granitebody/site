<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-INLINE.PHP
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
  'search-inline',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega'
);



// Style
// =============================================================================

function x_element_style_search_inline() {
  $style = cs_get_partial_style( 'search' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-search',
    'children'   => [],
    'key_prefix' => ''
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_search_inline( $data ) {
  return cs_get_partial_view( 'search', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Search Inline', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_search_inline',
  'style'   => 'x_element_style_search_inline',
  'render'  => 'x_element_render_search_inline',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_inline() {
  return cs_compose_controls(
    cs_partial_controls( 'search', array( 'type' => 'inline' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-inline', $data );

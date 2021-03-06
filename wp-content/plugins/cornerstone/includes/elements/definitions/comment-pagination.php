<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-PAGINATION.PHP
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
  'pagination:comment',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_comment_pagination() {
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

function x_element_render_comment_pagination( $data ) {
  return cs_get_partial_view( 'pagination', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Comment Pagination', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_comment_pagination',
  'style'   => 'x_element_style_comment_pagination',
  'render'  => 'x_element_render_comment_pagination',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_pagination() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', array( 'type' => 'comment' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-pagination', $data );

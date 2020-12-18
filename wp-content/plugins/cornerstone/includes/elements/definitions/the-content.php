<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/RAW-CONTENT.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Render
//   02. Define Element
//   03. Builder Setup
//   04. Register Element
// =============================================================================

// Render
// =============================================================================

function x_element_render_the_content( $data ) {

  $is_preview = apply_filters( 'cs_is_preview', false );

  if ( $is_preview ) {
    add_filter( 'cs_content_atts', 'x_element_render_the_content_atts', 10, 3 );
  }

  $result = apply_filters('cs_dynamic_content', '{{dc:post:the_content}}' );

  if ( $is_preview ) {
    remove_filter( 'cs_content_atts', 'x_element_render_the_content_atts', 10, 3 );
  }

  $classes = [ 'x-the-content' ];
  $classes[] = 'entry-content'; // Note: entry-content This will be added wheneber using Stacks (not after Theme Options update and non original stack selected)

  $atts = x_atts( [ 'class' => x_attr_class( $classes ) ] );
  return "<div $atts>$result</div>";

}


function x_element_render_the_content_atts( $atts, $id, $post_type ) {
  $post_type_obj = get_post_type_object( $post_type );

  $atts['data-cs-nav-btn'] = cs_prepare_json_att( array(
    'action' => array(
      'route'   => "content/$id",
      'context' => $post_type_obj->labels->singular_name
    ),
    'label' => sprintf( csi18n( 'common.edit' ), $post_type_obj->labels->singular_name ),
    'icon' => 'edit'
  ) );

  return $atts;
}


// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'The Content', '__x__' ),
  'values'  => array(),
  'builder' => 'x_element_builder_setup_the_content',
  'render'  => 'x_element_render_the_content',
  'icon'    => 'native',
  'options' => array(
    'library'     => false, // added via prefabs
    'preview_nav' => true
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_the_content() {
  return cs_compose_controls();
}



// Register Element
// =============================================================================

cs_register_element( 'the-content', $data );

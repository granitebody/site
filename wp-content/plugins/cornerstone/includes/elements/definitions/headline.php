<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/HEADLINE.PHP
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
  'text-headline',
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================
// 01. These data points were setup as flags initially to distinguish between
//     non-alt/interactive Elements (e.g. Headline) and alt/interactive
//     Elements (e.g. Anchors) with graphics. Since these were setup as
//     "virtual" controls and cannot be changed at a control level, this meant
//     that all old Headline Elements are stuck in a `false` state for these
//     values.
//
//     As of Pro v4.0.0, X v8.0.0, and Cornerstone v5.0.0, we are using
//     graphics with alt/interactive values for both of these Elements to allow
//     for custom transitions everywhere, and need to flag these on for them to
//     work as expected. At this time, we didn't want to rip all of that old
//     breakout code out, and this will allow us to not have to rename anything
//     at a base level or introduce any breaking changes.

function x_element_style_headline( $data ) {
  $style = cs_get_partial_style( 'text' );

  $style .= cs_get_partial_style( 'effects', array(
    'selector'   => '.x-text',
    'children'   => ['.x-text-content-text-primary', '.x-text-content-text-subheadline', '.x-text-typing', '.typed-cursor', '.x-graphic-child'],
    'key_prefix' => ''
  ) );

  return $style;
}

function x_element_preprocess_css_data_headline( $data ) {
  $data['text_graphic_has_alt']          = true; // 01
  $data['text_graphic_has_interactions'] = true; // 01

  return $data;
}



// Render
// =============================================================================
// 01. See notes above.

function x_element_render_headline( $data ) {
  $data['text_graphic_has_alt']          = true; // 01
  $data['text_graphic_has_interactions'] = true; // 01

  return cs_get_partial_view( 'text', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'               => __( 'Headline', '__x__' ),
  'values'              => $values,
  'builder'             => 'x_element_builder_setup_headline',
  'style'               => 'x_element_style_headline',
  'preprocess_css_data' => 'x_element_preprocess_css_data_headline',
  'render'              => 'x_element_render_headline',
  'icon'                => 'native',
  'options' => array(
    'inline' => array(
      'text_content' => array(
        'selector' => '.x-text-content-text-primary'
      ),
      'text_subheadline_content' => array(
        'selector' => '.x-text-content-text-subheadline'
      ),
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_headline() {
  return cs_compose_controls(
    cs_partial_controls( 'text', array( 'type' => 'headline', 'group_title' => __( 'Headline', '__x__' ) ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'headline', $data );

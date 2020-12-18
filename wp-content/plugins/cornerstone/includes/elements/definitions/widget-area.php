<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/WIDGET-AREA.PHP
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
    'widget_area_sidebar'               => cs_value( '', 'markup', true ),
    'widget_area_base_font_size'        => cs_value( '1rem', 'style' ),
    'widget_area_spacing'               => cs_value( '2.5rem', 'style' ),
    'widget_area_headline_spacing'      => cs_value( '0.5em', 'style' ),
    'widget_area_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'widget_area_margin'                => cs_value( '!0em', 'style' ),
    'widget_area_padding'               => cs_value( '!0em', 'style' ),
    'widget_area_border_width'          => cs_value( '!0px', 'style' ),
    'widget_area_border_style'          => cs_value( 'solid', 'style' ),
    'widget_area_border_color'          => cs_value( 'transparent', 'style:color' ),
    'widget_area_border_radius'         => cs_value( '!0px', 'style' ),
    'widget_area_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'widget_area_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_style_widget_area() {
  return x_get_view( 'styles/elements', 'widget-area', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_widget_area( $data ) {
  $classes = x_attr_class( array( $data['style_id'], 'x-widget-area', $data['class'] ) );

  $atts = array( 'class' => $classes );

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  $atts = cs_apply_effect( $atts, $data );

  ob_start(); ?>
  <div <?php echo x_atts( $atts, $data['custom_atts'] ); ?>>
    <?php dynamic_sidebar( $data['widget_area_sidebar'] ); ?>
  </div>

  <?php
  return ob_get_clean();
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Widget Area', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_widget_area',
  'style'   => 'x_element_style_widget_area',
  'render'  => 'x_element_render_widget_area',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_widget_area() {

  $control_widget_area_sidebar = array(
    'key'   => 'widget_area_sidebar',
    'type'  => 'sidebar',
    'label' => __( 'Widget<br/>Area', '__x__' ),
  );

  $control_widget_area_base_font_size = array(
    'key'     => 'widget_area_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '1rem',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => '10', 'max' => '24',  'step' => '1'    ),
        'em'  => array( 'min' => '1',  'max' => '2.5', 'step' => '0.25' ),
        'rem' => array( 'min' => '1',  'max' => '2.5', 'step' => '0.25' ),
      ),
    ),
  );

  $control_widget_area_columns = array(
    'type'       => 'group',
    'label'      => '&nbsp;',
    'controls'   => array(
      array(
        'type'    => 'label',
        'label'   => __( 'Widgets', '__x__' ),
        'options' => array(
          'columns' => 1
        ),
      ),
      array(
        'type'    => 'label',
        'label'   => __( 'Headlines', '__x__' ),
        'options' => array(
          'columns' => 1
        ),
      ),
    ),
  );

  $control_widget_area_spacing = array(
    'key'     => 'widget_area_spacing',
    'type'    => 'unit',
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '2.5rem',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => '0', 'max' => '50', 'step' => '1'    ),
        'em'  => array( 'min' => '0', 'max' => '5',  'step' => '0.25' ),
        'rem' => array( 'min' => '0', 'max' => '5',  'step' => '0.25' ),
      ),
    ),
  );

  $control_widget_area_headline_spacing = array(
    'key'     => 'widget_area_headline_spacing',
    'type'    => 'unit',
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'fallback_value'  => '0.5em',
      'valid_keywords'  => array( 'calc' ),
      'ranges'          => array(
        'px'  => array( 'min' => '0', 'max' => '50', 'step' => '1'    ),
        'em'  => array( 'min' => '0', 'max' => '5',  'step' => '0.25' ),
        'rem' => array( 'min' => '0', 'max' => '5',  'step' => '0.25' ),
      ),
    ),
  );

  $control_widget_area_spacing_and_headline_spacing = array(
    'type'     => 'group',
    'label'    => __( 'Spacing', '__x__' ),
    'options'  => array( 'grouped' => true ),
    'controls' => array(
      $control_widget_area_spacing,
      $control_widget_area_headline_spacing,
    ),
  );

  $control_widget_area_bg_color = array(
    'keys'  => array( 'value' => 'widget_area_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'widget_area:setup',
          'controls' => array(
            $control_widget_area_sidebar,
            $control_widget_area_base_font_size,
            $control_widget_area_columns,
            $control_widget_area_spacing_and_headline_spacing,
            $control_widget_area_bg_color,
          ),
        ),
        cs_control( 'margin', 'widget_area', array( 'group' => 'widget_area:design' ) ),
        cs_control( 'padding', 'widget_area', array( 'group' => 'widget_area:design' ) ),
        cs_control( 'border', 'widget_area', array( 'group' => 'widget_area:design' ) ),
        cs_control( 'border-radius', 'widget_area', array( 'group' => 'widget_area:design' ) ),
        cs_control( 'box-shadow', 'widget_area', array( 'group' => 'widget_area:design' ) )
      ),
      'controls_std_content' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Content Setup', '__x__' ),
          'controls'   => array(
            $control_widget_area_sidebar,
          ),
        )
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_widget_area_base_font_size,
          ),
        ),
        cs_control( 'margin', 'widget_area' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'widget_area_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'widget_area_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_widget_area_bg_color,
          ),
        ),
        cs_control( 'border', 'widget_area', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'widget_area_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'widget_area_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'widget_area'        => __( __( 'Widget Area', '__x__' ), '__x__' ),
        'widget_area:setup'  => __( 'Setup', '__x__' ),
        'widget_area:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'widget-area', $data );

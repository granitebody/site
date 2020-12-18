<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-PRODUCT-GALLERY.PHP
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
    'product_gallery_base_font_size'        => cs_value( '1em', 'style' ),
    'product_gallery_max_width'             => cs_value( 'none', 'style' ),
    'product_gallery_overflow'              => cs_value( 'visible', 'style' ),
    'product_gallery_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'product_gallery_margin'                => cs_value( '!0em', 'style' ),
    'product_gallery_padding'               => cs_value( '!0em', 'style' ),
    'product_gallery_border_width'          => cs_value( '!0px', 'style' ),
    'product_gallery_border_style'          => cs_value( 'solid', 'style' ),
    'product_gallery_border_color'          => cs_value( 'transparent', 'style:color' ),
    'product_gallery_border_radius'         => cs_value( '!0px', 'style' ),
    'product_gallery_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'product_gallery_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'effects',
  'effects:alt',
  'effects:scroll',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_product_gallery( $data ) {
  return x_get_view( 'styles/elements', 'tp-wc-product-gallery', 'css', $data, false );
}



// Render
// =============================================================================

function x_tp_wc_product_gallery_update_class( $classes ) {
	array_shift( $classes );
	array_unshift( $classes, 'x-woocommerce-product-gallery');
	return $classes;
}

function x_element_render_tp_wc_product_gallery( $data ) {

  add_filter( 'woocommerce_single_product_image_gallery_classes', 'x_tp_wc_product_gallery_update_class' );

  ob_start();
  woocommerce_show_product_images();
  $data['gallery_content'] = ob_get_clean();

  remove_filter( 'woocommerce_single_product_image_gallery_classes', 'x_tp_wc_product_gallery_update_class' );

  return x_get_view( 'elements', 'tp-wc', 'product-gallery', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Product Gallery', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tp_wc_product_gallery',
  'style'   => 'x_element_style_tp_wc_product_gallery',
  'render'  => 'x_element_render_tp_wc_product_gallery',
  'icon'    => 'native',
  'active'  => class_exists( 'WC_API' ),
  'group'   => 'woocommerce',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_product_gallery() {

  // Groups
  // ------

  $group           = 'product_gallery';
  $group_setup     = $group . ':setup';
  $group_design    = $group . ':design';


  // Controls
  // --------

  $control_product_gallery_base_font_size = array(
    'key'     => 'product_gallery_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      ),
    ),
  );

  $control_product_gallery_max_width = array(
    'key'     => 'product_gallery_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
      'valid_keywords'  => array( 'none', 'calc' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'   => array( 'min' => 300, 'max' => 600, 'step' => 10 ),
        'em'   => array( 'min' => 15,  'max' => 36,  'step' => 1  ),
        'rem'  => array( 'min' => 15,  'max' => 36,  'step' => 1  ),
        '%'    => array( 'min' => 1,   'max' => 100, 'step' => 1  ),
        'vw'   => array( 'min' => 1,   'max' => 100, 'step' => 1  ),
        'vh'   => array( 'min' => 1,   'max' => 100, 'step' => 1  ),
        'vmin' => array( 'min' => 1,   'max' => 100, 'step' => 1  ),
        'vmax' => array( 'min' => 1,   'max' => 100, 'step' => 1  ),
      ),
    ),
  );

  $control_product_gallery_overflow = array(
    'key'     => 'product_gallery_overflow',
    'type'    => 'choose',
    'label'   => __( 'Overflow', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'visible', 'label' => __( 'Visible', '__x__' ) ),
        array( 'value' => 'hidden',  'label' => __( 'Hidden', '__x__' ) ),
      ),
    ),
  );

  $control_product_gallery_bg_color = array(
    'key'   => 'product_gallery_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Settings
  // --------

  $settings_product_gallery_design = array(
    'group' => $group_design,
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_setup,
          'controls'   => array(
            $control_product_gallery_base_font_size,
            $control_product_gallery_max_width,
            $control_product_gallery_overflow,
            $control_product_gallery_bg_color,
          ),
        ),
        cs_control( 'margin', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'padding', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'border', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'border-radius', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'box-shadow', 'product_gallery', $settings_product_gallery_design ),
      ),
      'controls_std_content'       => array(),
      'controls_std_design_setup'  => array(),
      'controls_std_design_colors' => array(),
      'control_nav'                => array(
        $group        => __( 'Product Gallery', '__x__' ),
        $group_setup  => __( 'Setup', '__x__' ),
        $group_design => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-product-gallery', $data );

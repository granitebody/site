<?php

// Options
// =============================================================================

$label_off = __( 'Off', '__x__' );
$label_on = __( 'On', '__x__' );

cs_remember( 'options_choices_off_on_bool', array(
  'choices' => array(
    array( 'value' => false, 'label' => $label_off ),
    array( 'value' => true,  'label' => $label_on ),
  ),
) );

cs_remember( 'options_choices_off_on_string', array(
  'choices' => array(
    array( 'value' => '',   'label' => $label_off ),
    array( 'value' => 'on', 'label' => $label_on  ),
  )
) );

cs_remember( 'options_choices_off_on_bool_string', array(
  'choices' => array(
    array( 'value' => '',  'label' => $label_off ),
    array( 'value' => '1', 'label' => $label_on ),
  ),
) );

cs_remember( 'options_choices_layout_tags', array(
  'choices' => array(
    array( 'value' => 'div',     'label' => __( '<div>', '__x__' )     ),
    array( 'value' => 'section', 'label' => __( '<section>', '__x__' ) ),
    array( 'value' => 'article', 'label' => __( '<article>', '__x__' ) ),
    array( 'value' => 'aside',   'label' => __( '<aside>', '__x__' )   ),
    array( 'value' => 'header',  'label' => __( '<header>', '__x__' )  ),
    array( 'value' => 'footer',  'label' => __( '<footer>', '__x__' )  ),
    array( 'value' => 'figure',  'label' => __( '<figure>', '__x__' )  ),
    array( 'value' => 'ul',      'label' => __( '<ul>', '__x__' )      ),
    array( 'value' => 'ol',      'label' => __( '<ol>', '__x__' )      ),
    array( 'value' => 'li',      'label' => __( '<li>', '__x__' )      ),
    array( 'value' => 'a',       'label' => __( '<a>', '__x__' )       ),
  ),
) );

cs_remember( 'options_choices_layout_overflow', array(
  'choices' => array(
    array( 'value' => 'visible', 'icon' => 'ui:visible' ),
    array( 'value' => 'hidden',  'icon' => 'ui:hidden' ),
  ),
) );

$label_swatch      = __( 'Select', '__x__' );
$label_base        = __( 'Base', '__x__' );
$label_interaction = __( 'Interaction', '__x__' );

cs_remember( 'options_base_interaction_labels', array(
  'label'     => $label_base,
  'alt_label' => $label_interaction,
) );

cs_remember( 'options_swatch_base_interaction_labels', array(
  'swatch_label' => $label_swatch,
  'label'        => $label_base,
  'alt_label'    => $label_interaction,
) );

cs_remember( 'options_color_base_interaction_labels', array(
  'color' => array(
    'label'        => $label_base,
    'alt_label'    => $label_interaction,
  )
) );

cs_remember( 'options_color_swatch_base_interaction_labels', array(
  'color' => array(
    'swatch_label' => $label_swatch,
    'label'        => $label_base,
    'alt_label'    => $label_interaction,
  )
) );

cs_remember( 'options_color_base_interaction_labels_color_only', array(
  'color_only' => true,
  'color'      => array(
    'label'     => $label_base,
    'alt_label' => $label_interaction,
  )
) );

cs_remember( 'options_group_toggle_off_on_bool', [
  'toggle' => [ 'on' => true, 'off' => false ]
] );

cs_remember( 'options_group_toggle_off_on_string', [
  'toggle' => [ 'on' => 'on', 'off' => '' ]
]);

cs_remember( 'options_group_toggle_off_on_bool_string', [
  'toggle' => [ 'on' => '1', 'off' => '' ]
]);



// Settings
// =============================================================================

cs_remember( 'settings_anchor:toggle', array(
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'toggle_anchor',
  'group_title'      => __( 'Toggle', '__x__' ),
  'label_prefix_std' => __( 'Toggle', '__x__' ),
  'add_custom_atts'  => true
) );

cs_remember( 'settings_anchor:cart-toggle', array(
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'cart_toggle_anchor',
  'group_title'      => __( 'Toggle', '__x__' ),
  'label_prefix_std' => __( 'Toggle', '__x__' ),
  'add_custom_atts'  => true
) );

cs_remember( 'settings_anchor:cart-button', array(
  'type'             => 'button',
  'k_pre'            => 'cart',
  'group'            => 'cart_button_anchor',
  'group_title'      => __( 'Cart Buttons', '__x__' ),
  'has_template'     => false,
  'label_prefix_std' => __( 'Cart Buttons', '__x__' )
) );

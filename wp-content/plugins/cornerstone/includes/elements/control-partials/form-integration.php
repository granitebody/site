<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/FORM-INTEGRATION.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_form_integration( $settings ) {

  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'form_integration';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Form Integration', 'cornerstone' );
  $condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();


  // Messaging
  // ---------

  $message_activate_plugin = __( 'Activate Plugin', 'cornerstone' );
  $message_required        = __( '%s must be installed and activated to use this form type.', 'cornerstone' );

  $title_wpforms           = __( 'WPForms', 'cornerstone' );
  $title_contact_form_7    = __( 'Contact Form 7', 'cornerstone' );
  $title_gravity_forms     = __( 'Gravity Forms', 'cornerstone' );

  $label_form              = __( 'Form', 'cornerstone' );
  $label_show              = __( 'Show', 'cornerstone' );
  $label_title             = __( 'Title', 'cornerstone' );
  $label_description       = __( 'Description', 'cornerstone' );


  // Conditions
  // ----------

  $conditions_form_integration_embed          = array_merge( $condition, array( array( 'form_integration_type' => 'embed' ) ) );
  $conditions_form_integration_wpforms        = array_merge( $condition, array( array( 'form_integration_type' => 'wpforms' ) ) );
  $conditions_form_integration_contact_form_7 = array_merge( $condition, array( array( 'form_integration_type' => 'contact-form-7' ) ) );
  $conditions_form_integration_gravity_forms  = array_merge( $condition, array( array( 'form_integration_type' => 'gravity-forms' ) ) );


  // Groups
  // ------

  $group_form_integration_setup  = $group . ':setup';
  $group_form_integration_design = $group . ':design';


  // Controls
  // --------

  $controls_form_integration = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Setup', 'cornerstone' ),
      'group'      => $group_form_integration_setup,
      'controls'   => array(
        array(
          'key'     => 'form_integration_type',
          'type'    => 'select',
          'label'   => __( 'Type', 'cornerstone' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'embed',          'label' => __( 'Embed', 'cornerstone' ) ),
              array( 'value' => 'wpforms',        'label' => __( 'WPForms', 'cornerstone' ) ),
              array( 'value' => 'contact-form-7', 'label' => __( 'Contact Form 7', 'cornerstone' ) ),
              array( 'value' => 'gravity-forms',  'label' => __( 'Gravity Forms', 'cornerstone' ) ),
            ),
          ),
        ),
        array(
          'key'        => 'form_integration_embed_content',
          'type'       => 'text-editor',
          'label'      => __( 'Content', 'cornerstone' ),
          'conditions' => $conditions_form_integration_embed,
          'options'    => array(
            'mode'   => 'html',
            'height' => 2,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => '&nbsp;',
          'controls'   => array(
            array(
              'type'    => 'label',
              'label'   => __( 'Base', '__x__' ),
              'options' => array(
                'columns' => 1
              ),
            ),
            array(
              'type'    => 'label',
              'label'   => __( 'Max', '__x__' ),
              'options' => array(
                'columns' => 1
              ),
            ),
          ),
        ),
        array(
          'type'     => 'group',
          'label'    => __( 'Width', 'cornerstone' ),
          'options'  => array( 'grouped' => true ),
          'controls' => array(
            array(
              'key'     => 'form_integration_width',
              'type'    => 'unit',
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
                'fallback_value'  => 'auto',
                'valid_keywords'  => array( 'auto', 'calc' ),
              ),
            ),
            array(
              'key'     => 'form_integration_max_width',
              'type'    => 'unit',
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ),
                'fallback_value'  => 'none',
                'valid_keywords'  => array( 'none', 'calc' ),
              ),
            ),
          ),
        ),
      ),
    ),
  );


  // WPForms
  // -------

  if ( function_exists( 'wpforms' ) ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'controls'   => array(
        array(
          'key'     => 'form_integration_wpforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:wpforms'
          ),
        ),
        array(
          'keys' => array(
            'title'       => 'form_integration_wpforms_title',
            'description' => 'form_integration_wpforms_description',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title',       'label' => $label_title ),
              array( 'key' => 'description', 'label' => $label_description ),
            ),
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_wpforms )
      )
    );

  }


  // Contact Form 7
  // --------------

  if ( class_exists('WPCF7_ContactForm') ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'controls'   => array(
        array(
          'key'     => 'form_integration_contact_form_7_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:contact_form_7'
          ),
        ),
        array(
          'keys' => array(
            'title' => 'form_integration_contact_form_7_title',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title', 'label' => $label_title ),
            ),
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_contact_form_7 )
      ),
    );

  }


  // Gravity Forms
  // -------------

  if ( class_exists( 'GFForms' ) ) {

    $controls_form_integration[] = array(
      'type'       => 'group',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'controls'   => array(
        array(
          'key'     => 'form_integration_gravityforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => array(
            'choices' => 'dynamic:gravityforms'
          ),
        ),
        array(
          'keys' => array(
            'title'       => 'form_integration_gravityforms_title',
            'description' => 'form_integration_gravityforms_description',
          ),
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => array(
            'list' => array(
              array( 'key' => 'title',       'label' => $label_title ),
              array( 'key' => 'description', 'label' => $label_description ),
            ),
          ),
        ),
        array(
          'keys' => array(
            'ajax' => 'form_integration_gravityforms_ajax',
          ),
          'type'    => 'checkbox-list',
          'label'   => __( 'Ajax', 'cornerstone' ),
          'options' => array(
            'list' => array(
              array( 'key' => 'ajax', 'label' => __( 'Enabled', 'cornerstone' ) ),
            ),
          ),
        ),
        array(
          'key'     => 'form_integration_gravityforms_tabindex',
          'type'    => 'text',
          'label'   => __( 'Tab Index', 'cornerstone' ),
          'options' => array(
            'placeholder' => __( 'Starting tab index', 'cornerstone' )
          ),
        ),
        array(
          'key'     => 'form_integration_gravityforms_field_values',
          'type'    => 'text',
          'label'   => __( 'Field Values', 'cornerstone' ),
          'options' => array(
            'placeholder' => __( 'Prefill field values', 'cornerstone' )
          ),
        ),
      ),
    );

  } else {

    $controls_form_integration[] = array(
      'type'       => 'message',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'options'    => array(
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_gravity_forms )
      ),
    );

  }


  // Design
  // ------

  $controls_form_integration[] = cs_control( 'margin', 'form_integration', array( 'group' => $group_form_integration_design ) );


  // Compose Controls
  // ----------------

  return array(
    'controls'             => $controls_form_integration,
    'controls_std_content' => $controls_form_integration,
    'control_nav'          => array(
      $group                         => $group_title,
      $group_form_integration_setup  => __( 'Setup', 'cornerstone' ),
      $group_form_integration_design => __( 'Design', 'cornerstone' ),
    ),
  );
}

cs_register_control_partial( 'form-integration', 'x_control_partial_form_integration' );

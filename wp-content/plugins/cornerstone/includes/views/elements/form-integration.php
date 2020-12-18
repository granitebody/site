<?php

// =============================================================================
// VIEWS/ELEMENTS/FORM-INTEGRATION.PHP
// -----------------------------------------------------------------------------
// Form Integration element.
// =============================================================================

$classes = x_attr_class( array( $style_id, 'x-form-integration', 'x-form-integration-' . $form_integration_type, $class ) );


// Prepare Atts
// ------------

$atts = array(
  'class' => $classes
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Content
// -------

$content = '';


// Embed
// -----

if ( $form_integration_type === 'embed' ) {
  $content = $form_integration_embed_content;
} else {
  $message_inactive = sprintf( '<div class="x-form-integration-message">%s</div>', __( '%s not active', 'cornerstone' ) );
  $message_select   = sprintf( '<div class="x-form-integration-message">%s</div>', __( 'Select a form (%s)', 'cornerstone' ) );
  $message_error    = '<div class="x-form-integration-message x-form-integration-message-error">%s</div>';


  // WPForms
  // -------

  if ( $form_integration_type === 'wpforms' ) {
    $plugin_title = __( 'WPForms', 'cornerstone' );

    if ( function_exists( 'wpforms' ) ) {
      if ( $form_integration_wpforms_id ) {
        $content = cs_build_shortcode( 'wpforms', array(
          'id'          => $form_integration_wpforms_id,
          'title'       => $form_integration_wpforms_title ? 'true' : 'false',
          'description' => $form_integration_wpforms_description ? 'true' : 'false',
        ));
      } else {
        $content = sprintf( $message_select, $plugin_title );
      }
    } else {
      $content = sprintf( $message_inactive, $plugin_title );
    }
  }


  // Contact Form 7
  // --------------

  if ( $form_integration_type === 'contact-form-7' ) {
    $plugin_title = __( 'Contact Form 7', 'cornerstone' );

    if ( class_exists('WPCF7_ContactForm') ) {
      if ( $form_integration_contact_form_7_id ) {
        $items = WPCF7_ContactForm::find( array( 'p' => $form_integration_contact_form_7_id ) );
        $shortcode_atts  = array( 'id' => $items[0]->id() );

        if ( $form_integration_contact_form_7_title ) {
          $shortcode_atts['title'] = $items[0]->title();
        }

        $content = cs_build_shortcode( 'contact-form-7', $shortcode_atts );
      } else {
        $content = sprintf( $message_select, $plugin_title );
      }
    } else {
      $content = sprintf( $message_inactive, $plugin_title );
    }
  }


  // Gravity Forms
  // -------------

  if ( $form_integration_type === 'gravity-forms' ) {
    $plugin_title = __( 'Gravity Forms', 'cornerstone' );

    if ( class_exists( 'GFForms' ) ) {
      if ( $form_integration_gravityforms_id ) {
        $shortcode_atts = array(
          'id'          => $form_integration_gravityforms_id,
          'title'       => $form_integration_gravityforms_title ? 'true' : 'false',
          'description' => $form_integration_gravityforms_description ? 'true' : 'false',
        );

        if ( $form_integration_gravityforms_tabindex ) {
          $shortcode_atts['tabindex'] = $form_integration_gravityforms_tabindex;
        }

        if ( $form_integration_gravityforms_field_values ) {
          $shortcode_atts['field_values'] = $form_integration_gravityforms_field_values;
        }

        $content = cs_build_shortcode( 'gravityform', $shortcode_atts );
      } else {
        $content = sprintf( $message_select, $plugin_title );
      }
    } else {
      $content = sprintf( $message_inactive, $plugin_title );
    }
  }
}


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo do_shortcode( $content ); ?>
</div>

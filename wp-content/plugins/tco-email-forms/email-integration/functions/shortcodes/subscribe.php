<?php
// =============================================================================
// EMAIL-INTEGRATION/FUNCTIONS/SHORTCODES/SUBSCRIBE.PHP
// -----------------------------------------------------------------------------
// Shortcode logic.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Class Setup
// =============================================================================

// Class Setup
// =============================================================================

class Tco_Shortcode_Tco_Subscribe {

  protected $name, $plugin;

  function __construct( $name, $plugin ) {

    $this->name   = $name;
    $this->plugin = $plugin;

    add_shortcode( $name, array( $this, 'handler' ) );

    add_action( 'wp_ajax_tco_subscribe', array( $this, 'ajax') );
    add_action( 'wp_ajax_nopriv_tco_subscribe', array( $this, 'ajax' ) );

  }


  //
  // Shortcode handler.
  //

  function handler( $atts, $content = '' ) {

    //
    // If we don't have a form, retrieve the default.
    //

    $form = ( ! isset( $atts['form'] ) || $atts['form'] == '' ) ? $this->plugin->options->get( 'default_form' ) : $atts['form'];
    $meta = $this->clean_array_keys( get_post_meta( $form ), 'email_forms_' );


    //
    // Simplify some items for the view.
    //

    if (! isset($meta['show_labels'])) {
        return '<strong>Not an Email Forms valid form.</strong>';
    }


    $meta['show_labels']   = ( 'Yes' == $meta['show_labels'] );
    $meta['name_required'] = ( 'Yes' == $meta['name_required'] );
    $meta['id']            = 'tco-subscribe-' . $form;

    switch ( $meta['name_display'] ) {
      case 'None':
        $meta['name_display'] = 'none';
        break;
      case 'First':
        $meta['name_display'] = 'first';
        break;
      case 'Last':
        $meta['name_display'] = 'last';
        break;
      case 'Full (Separate)':
        $meta['name_display'] = 'first-last';
        break;
      case 'Full (Combined)':
        $meta['name_display'] = 'full';
        break;
    }


    //
    // Set shortcode defaults.
    //

    $atts = shortcode_atts( array(
      'id'      => '',
      'class'   => $meta['class'],
      'style'   => '',
      'form_id' => $form
    ), $atts );

    $view_data = wp_parse_args( $atts, $meta );

    return $this->plugin->view->make('site/shortcode-tco-subscribe', $view_data );

  }


  //
  // AJAX handler.
  //

  function ajax() {

    if ( ! isset( $_REQUEST['data'] ) ) {
      die( 0 );
    }

    $response = array();
    $data     = $_REQUEST['data'];
    $meta     = $this->clean_array_keys( get_post_meta( $data['form_id'] ), 'email_forms_' );
    $list     = $parts = explode( '**', $meta['list'] );

    ob_start();

    $result = $this->plugin->subscribe( $list[0], $data );

    if ( is_wp_error( $result ) ) {

      $message = $result->get_error_message() == 'Member Exists'
               ? __( 'We were unable to add your email to the list: this email is already on the list.', '__tco__' )
               : $result->get_error_message(); //__( 'We\'re sorry! Something went wrong. We were unable to add your email to the list. Please try again later.', '__tco__' );

      $response = array(
        'error'       => true,
        'log_message' => $result->get_error_message(),
        'message'     => $message
      );
    }

    ob_get_clean();

    echo json_encode( $response );

    die( 0 );

  }


  //
  // Helper functions.
  //

  //
  // This will escape our attributes making them safe for the front end
  // It will also remove "email_forms_" from the keys making them easier
  // to use within view files.
  //

  function clean_array_keys( $array, $remove ) {

    $new_array = array();

    foreach ( $array as $key => $value ) {
      if ( $key === 'email_forms_custom_fields' ||  $key === 'email_forms_mailchimp_groups') {
        $new_array[str_replace( $remove, '', $key )] = unserialize($value[0]);
        continue;
      }
      $new_array[str_replace( $remove, '', $key )] = esc_attr( (is_array( $value ) && count( $value ) <= 1 ) ? $value[0] : $value );
    }

    return $new_array;

  }

}

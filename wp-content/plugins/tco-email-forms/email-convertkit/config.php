<?php

// =============================================================================
// EMAIL-CONVERTKIT/CONFIG.PHP
// -----------------------------------------------------------------------------
// The provider configuration sets up general information, metaboxes, default
// options, and about items to be used specifically for the provider.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Configuration
// =============================================================================

// Configuration
// =============================================================================

return array(

  //
  // General info.
  //

  'name'  => 'convertkit',
  'title' => 'ConvertKit',


  //
  // Default options.
  //

  'default_options' => array(
    'ck_api_key'            => '',
    'ck_list_cache'         => array(),
  ),


  //
  // Settings page metaboxes.
  //

  'settings_metaboxes' => array(
    'ck_general' => array(
      'title' => __( 'Settings', '__tco__' ),
      'view'  => 'admin/metabox-settings'
    ),
    'ck_lists' => array(
      'title' => __( 'Forms', '__tco__' ),
      'view'  => 'admin/metabox-lists'
    )
  ),


  //
  // About items.
  //

  'about_items' => array(
    'ck_api_key' => array(
      'title'   => __( 'API Key', '__tco__' ),
      'content' => __( 'ConvertKit requires an API key. You can generate one from your <a href="https://app.convertkit.com/account/edit" target="_blank">ConvertKit account</a>. ', '__tco__' ),
    ),
    'ck_lists' => array(
      'title'   => __( 'Forms', '__tco__' ),
      'content' => __( 'You will need to create a form with ConvertKit. You can do that from your <a href="https://app.convertkit.com/landing_pages" target="_blank">ConvertKit Landing Page</a>. Any preexisting forms should be shown, otherwise you can use the <b>Refresh</b> button to check for recently created ones.', '__tco__' ),
    ),
    'ck_fields' => array(
      'title'   => __( 'Custom Fields', '__tco__' ),
      'content' => __( 'You can add new fields for subscribers on ConvertKit. After selecting a subscriber on <a href="https://app.convertkit.com/subscribers" target="_blank">ConvertKit Subscribers Lists</a> you can "+Add new field"". Heads up: "Last Name" is already populated by this plugin if exists.', '__tco__' ),
    ),
    'ck_support' => array(
      'title'   => __( 'Support', '__tco__' ),
      'content' => __( 'Please visit our <a href="https://theme.co/docs/email-forms" target="_blank">Docs article</a> for this plugin if you have any questions.', '__tco__' ),
    )
  ),

);

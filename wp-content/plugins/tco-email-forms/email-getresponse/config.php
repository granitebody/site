<?php

// =============================================================================
// EMAIL-GETRESPONSE/CONFIG.PHP
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

  'name'  => 'getresponse',
  'title' => 'GetResponse',


  //
  // Default options.
  //

  'default_options' => array(
    'gr_api_key'    => '',
    'gr_list_cache' => array(),
  ),


  //
  // Settings page metaboxes.
  //

  'settings_metaboxes' => array(
    'gr_general' => array(
      'title' => __( 'Settings', '__tco__' ),
      'view'  => 'admin/metabox-settings'
    ),
    'gr_lists' => array(
      'title' => __( 'Campaigns', '__tco__' ),
      'view'  => 'admin/metabox-lists'
    )
  ),


  //
  // About items.
  //

  'about_items' => array(
    'gr_api_key' => array(
      'title'   => __( 'API Key', '__tco__' ),
      'content' => __( 'GetResponse requires an API key. You can generate one from your <a href="https://app.getresponse.com/manage_api.html" target="_blank">GetResponse API & OAuth Page</a>. ', '__tco__' ),
    ),
    'gr_lists' => array(
      'title'   => __( 'Campaigns', '__tco__' ),
      'content' => __( 'You will need to create a campaign with GetResponse. You can do that from your <a href="https://app.getresponse.com/campaign_list.html" target="_blank">GetResponse My Campaigns Page</a>. Any preexisting campaigns should be shown, otherwise you can use the <b>Refresh</b> button to check for recently created ones.', '__tco__' ),
    ),
    'ck_fields' => array(
      'title'   => __( 'Custom Fields', '__tco__' ),
      'content' => __( 'You can add new fields for subscribers on GetResponse on <a href="https://app.getresponse.com/custom_fields.html" target="_blank">GetResponse My Custom Fields Page</a>. The defaul list is already loaded by this plugin.', '__tco__' ),
    ),
    'gr_support' => array(
      'title'   => __( 'Support', '__tco__' ),
      'content' => __( 'Please visit our <a href="https://theme.co/docs/email-forms" target="_blank">Docs article</a> for this plugin if you have any questions.', '__tco__' ),
    )
  ),

);

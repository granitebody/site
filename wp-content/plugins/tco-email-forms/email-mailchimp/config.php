<?php

// =============================================================================
// EMAIL-MAILCHIMP/CONFIG.PHP
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

  'name'  => 'mailchimp',
  'title' => 'MailChimp',


  //
  // Default options.
  //

  'default_options' => array(
    'mc_api_key'    => '',
    'mc_list_cache' => array(),
  ),


  //
  // Settings page metaboxes.
  //

  'settings_metaboxes' => array(
    'mc_general' => array(
      'title' => __( 'Settings', '__tco__' ),
      'view'  => 'admin/metabox-settings'
    ),
    'mc_lists' => array(
      'title' => __( 'Campaigns', '__tco__' ),
      'view'  => 'admin/metabox-lists'
    )
  ),


  //
  // About items.
  //

  'about_items' => array(
    'mc_api_key' => array(
      'title'   => __( 'API Key', '__tco__' ),
      'content' => __( 'MailChimp requires an API key. You can generate one from your <a href="https://admin.mailchimp.com/account/api/" target="_blank">MailChimp account</a>. ', '__tco__' ),
    ),
    'mc_lists' => array(
      'title'   => __( 'Lists', '__tco__' ),
      'content' => __( 'You will need to create a list with Mailchimp. You can do that from your <a href="https://admin.mailchimp.com/lists/" target="_blank">MailChimp Lists Page</a>. Any preexisting lists should be shown, otherwise you can use the <b>Refresh</b> button to check for recently created ones.', '__tco__' ),
    ),
    'mc_fields' => array(
      'title'   => __( 'Custom Fields', '__tco__' ),
      'content' => __( 'You can add new fields on each list you created with Mailchimp. After selecting a list on <a href="https://admin.mailchimp.com/lists/" target="_blank">MailChimp Lists Page</a> go to "Settings" => "List fields and *|MERGE|* tags". Heads up: "FNAME" and "LNAME" are default and already populated by this plugin.', '__tco__' ),
    ),
    'mc_support' => array(
      'title'   => __( 'Support', '__tco__' ),
      'content' => __( 'Please visit our <a href="https://theme.co/docs/email-forms" target="_blank">Docs article</a> for this plugin if you have any questions.', '__tco__' ),
    )
  ),

);

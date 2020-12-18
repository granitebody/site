<?php
/*
Plugin Name: Cornerstone
Plugin URI: https://theme.co/cornerstone
Description: The WordPress Page Builder
Author: Themeco
Author URI: https://theme.co/
Version: 5.0.4
Text Domain: cornerstone
Domain Path: lang
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Setup Localization
function cornerstone_plugin_init() {
  load_plugin_textdomain( 'cornerstone', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

add_action( 'init', 'cornerstone_plugin_init' );

// Fire it up
require_once 'includes/boot.php';
cornerstone_boot( __FILE__ );

if ( ! defined('CS_ASSET_REV') ) {
  define( 'CS_ASSET_REV', 'd5e7052' );
}


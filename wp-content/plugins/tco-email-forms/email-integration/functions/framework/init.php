<?php

// =============================================================================
// EMAIL-INTEGRATION/FUNCTIONS/FRAMEWORK/INIT.PHP
// -----------------------------------------------------------------------------
// The view-handler.php file is so the plugin and providers can easily load
// view files that are injected with shared data from the plugin.
//
// The options-handler.php file is for saving and validating options. It allows
// the providers to simply "declare" what they want to use, and the plugin will
// handle their storage and initialization.
//
// The plugin-base.php file performs essential bootstrap like hooks that will
// always be used (i.e. loading the config file, instantiating any declared
// widgets, instantiating any declared shortcodes, et cetera). It is what
// powers the plugin's config file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Require Files
// =============================================================================

// Require Files
// =============================================================================

require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/includes/cs/helpers.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/includes/cs/section.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/includes/cs/column.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/includes/cs/row.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/view-handler.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/options-handler.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/plugin-base.php';
require_once TCO_EMAIL_INTEGRATION_PATH . '/functions/framework/setup.php';
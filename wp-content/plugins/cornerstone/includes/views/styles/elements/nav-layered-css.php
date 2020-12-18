<?php

// =============================================================================
// NAV-LAYERED-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Include Partial CSS
// =============================================================================

// Include Partial CSS
// =============================================================================

?>

@if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
  <?php

    echo cs_get_partial_style( 'anchor', array(
      'selector'   => '.x-anchor-toggle',
      'key_prefix' => 'toggle'
    ) );

    echo cs_get_partial_style( 'effects', array(
      'selector' => '.x-anchor-toggle',
      'children' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'], // '[data-x-particle]'
    ) );

    echo cs_get_partial_style( 'off-canvas' );

  ?>
}

@if $_region === 'left' || $_region === 'right' || $_region === 'content' || $_region === 'layout' {
  <?php

  echo cs_get_partial_style( 'effects', array(
    'selector' => '.x-menu',
    'children' => [],
  ) );

  ?>
}

<?php

echo cs_get_partial_style( 'menu' );

echo cs_get_partial_style( 'anchor', array(
  'selector'   => '.x-menu .x-anchor',
  'key_prefix' => ''
) );

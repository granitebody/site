<?php

// =============================================================================
// FORM-INTEGRATION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base
//   02. Effects
// =============================================================================

// Base
// =============================================================================

?>

.$_el.x-form-integration {
  @if $form_integration_width !== 'auto' {
    width: $form_integration_width;
  }
  @unless $form_integration_max_width?? {
    max-width: $form_integration_max_width;
  }
  @unless $form_integration_margin?? {
    margin: $form_integration_margin;
  }
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-form-integration',
  'children' => [],
) );

?>

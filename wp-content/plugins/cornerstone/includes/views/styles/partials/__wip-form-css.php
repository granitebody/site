<?php

// =============================================================================
// _FORM-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Controls
//   04. Inputtable
//   05. Focusable
// =============================================================================

// Setup
// =============================================================================

$selector            = ( isset( $selector ) && $selector != ''                       ) ? $selector            : '';
$has_base            = ( isset( $has_base ) && $has_base != ''                       ) ? $has_base            : true;
$has_fields          = ( isset( $has_fields ) && $has_fields != ''                   ) ? $has_fields          : false;
$has_control_groups  = ( isset( $has_control_groups ) && $has_control_groups != ''   ) ? $has_control_groups  : false;
$has_spaced_controls = ( isset( $has_spaced_controls ) && $has_spaced_controls != '' ) ? $has_spaced_controls : false;
$has_inline_controls = ( isset( $has_inline_controls ) && $has_inline_controls != '' ) ? $has_inline_controls : false;
$has_inputtable      = ( isset( $has_inputtable ) && $has_inputtable != ''           ) ? $has_inputtable      : true;
$has_radios          = ( isset( $has_radios ) && $has_radios != ''                   ) ? $has_radios          : false;
$has_checkboxes      = ( isset( $has_checkboxes ) && $has_checkboxes != ''           ) ? $has_checkboxes      : false;

$data_border = array(
  'width'  => 'form_border_width',
  'style'  => 'form_border_style',
  'base'   => 'form_border_color',
  'radius' => 'form_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'form_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'form_box_shadow_dimensions',
  'base'       => 'form_box_shadow_color',
);



// Base
// =============================================================================

?>

<?php if ( $has_base === true ) : ?>

.$_el<?php echo $selector; ?> .x-form {
    
}

<?php endif; ?>



<?php

// Fields
// =============================================================================

?>

<?php if ( $has_fields === true ) : ?>

.$_el<?php echo $selector; ?> .x-form-field {
    
}

<?php endif; ?>



<?php

// Controls
// =============================================================================

?>

<?php if ( $has_control_groups === true ) : ?>

.$_el<?php echo $selector; ?> .x-form-controls {
    
}

<?php endif; ?>



<?php

// Inputtable
// =============================================================================

?>

<?php if ( $has_inputtable === true ) : ?>

.$_el<?php echo $selector; ?> .x-form-inputtable {
    
}

<?php endif; ?>



<?php

// Focusable
// =============================================================================

?>

<?php if ( $has_inputtable === true || $has_radios === true || $has_checkboxes === true ) : ?>

.$_el<?php echo $selector; ?> .x-form-focusable {
    
}

<?php endif; ?>

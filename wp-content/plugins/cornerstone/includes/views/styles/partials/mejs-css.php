<?php

// =============================================================================
// _MEJS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Buttons
//   04. Time
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Base
// ----

$data_border = array(
  'width'  => $key_prefix . 'mejs_controls_border_width',
  'style'  => $key_prefix . 'mejs_controls_border_style',
  'base'   => $key_prefix . 'mejs_controls_border_color',
  'radius' => $key_prefix . 'mejs_controls_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'mejs_controls_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'mejs_controls_box_shadow_dimensions',
  'base'       => $key_prefix . 'mejs_controls_box_shadow_color',
);


// Buttons
// -------

$data_buttons_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'mejs_controls_button_color',
  'alt'  => $key_prefix . 'mejs_controls_button_color_alt',
);


// Time Total
// ----------

$data_time_total_border = array(
  'radius' => $key_prefix . 'mejs_controls_time_rail_border_radius',
);

$data_time_total_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'mejs_controls_time_total_bg_color',
);

$data_time_total_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'mejs_controls_time_rail_box_shadow_dimensions',
  'base'       => $key_prefix . 'mejs_controls_time_rail_box_shadow_color',
);


// Time Loaded
// -----------

$data_time_loaded_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'mejs_controls_time_loaded_bg_color',
);


// Time Current
// ------------

$data_time_current_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'mejs_controls_time_current_bg_color',
);


// Time
// ----

$data_time_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'mejs_controls_color',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mejs .mejs-controls {
  @if $<?php echo $key_prefix; ?>mejs_type === 'video' {
    margin: $<?php echo $key_prefix; ?>mejs_controls_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $<?php echo $key_prefix; ?>mejs_controls_padding?? {
    padding: $<?php echo $key_prefix; ?>mejs_controls_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Buttons
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mejs .mejs-button button {
  <?php echo cs_get_partial_style( '_color-base', $data_buttons_color ); ?>
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-button button:hover,
.$_el<?php echo $selector; ?> .x-mejs .mejs-button button:focus {
  <?php echo cs_get_partial_style( '_alt-base', $data_buttons_color ); ?>
}



<?php

// Time
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-total {
  <?php
  echo cs_get_partial_style( '_border-base', $data_time_total_border );
  echo cs_get_partial_style( '_color-base', $data_time_total_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_time_total_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-loaded {
  <?php echo cs_get_partial_style( '_color-base', $data_time_loaded_background_color ); ?>
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time-current {
  <?php echo cs_get_partial_style( '_color-base', $data_time_current_background_color ); ?>
}

.$_el<?php echo $selector; ?> .x-mejs .mejs-time {
  <?php echo cs_get_partial_style( '_color-base', $data_time_color ); ?>
}

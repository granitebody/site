<?php

// =============================================================================
// _SEARCH-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Input
//   04. Submit
//   05. Clear
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Base
// ----

$data_linotype = array(
  'ff'     => $key_prefix . 'search_input_font_family',
  'fsize'  => $key_prefix . 'search_input_font_size',
  'fstyle' => $key_prefix . 'search_input_font_style',
  'fw'     => $key_prefix . 'search_input_font_weight',
  'lh'     => $key_prefix . 'search_input_line_height',
  'ls'     => $key_prefix . 'search_input_letter_spacing',
  'ta'     => $key_prefix . 'search_input_text_align',
  'td'     => $key_prefix . 'search_input_text_decoration',
  'tt'     => $key_prefix . 'search_input_text_transform',
);

$data_border = array(
  'width'  => $key_prefix . 'search_border_width',
  'style'  => $key_prefix . 'search_border_style',
  'base'   => $key_prefix . 'search_border_color',
  'alt'    => $key_prefix . 'search_border_color_alt',
  'radius' => $key_prefix . 'search_border_radius',
);

$data_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'search_input_text_color',
  'alt'  => $key_prefix . 'search_input_text_color_alt',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'search_bg_color',
  'alt'  => $key_prefix . 'search_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'search_box_shadow_dimensions',
  'base'       => $key_prefix . 'search_box_shadow_color',
  'alt'        => $key_prefix . 'search_box_shadow_color_alt',
);


// Submit
// ------

$data_submit_border = array(
  'width'  => $key_prefix . 'search_submit_border_width',
  'style'  => $key_prefix . 'search_submit_border_style',
  'base'   => $key_prefix . 'search_submit_border_color',
  'alt'    => $key_prefix . 'search_submit_border_color_alt',
  'radius' => $key_prefix . 'search_submit_border_radius',
);

$data_submit_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'search_submit_color',
  'alt'  => $key_prefix . 'search_submit_color_alt',
);

$data_submit_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'search_submit_bg_color',
  'alt'  => $key_prefix . 'search_submit_bg_color_alt',
);

$data_submit_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'search_submit_box_shadow_dimensions',
  'base'       => $key_prefix . 'search_submit_box_shadow_color',
  'alt'        => $key_prefix . 'search_submit_box_shadow_color_alt',
);


// Clear
// -----

$data_clear_border = array(
  'width'  => $key_prefix . 'search_clear_border_width',
  'style'  => $key_prefix . 'search_clear_border_style',
  'base'   => $key_prefix . 'search_clear_border_color',
  'alt'    => $key_prefix . 'search_clear_border_color_alt',
  'radius' => $key_prefix . 'search_clear_border_radius',
);

$data_clear_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'search_clear_color',
  'alt'  => $key_prefix . 'search_clear_color_alt',
);

$data_clear_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'search_clear_bg_color',
  'alt'  => $key_prefix . 'search_clear_bg_color_alt',
);

$data_clear_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'search_clear_box_shadow_dimensions',
  'base'       => $key_prefix . 'search_clear_box_shadow_color',
  'alt'        => $key_prefix . 'search_clear_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search {
  width: $<?php echo $key_prefix; ?>search_width;
  max-width: $<?php echo $key_prefix; ?>search_max_width;
  height: $<?php echo $key_prefix; ?>search_height;
  @unless $<?php echo $key_prefix; ?>search_margin?? {
    margin: $<?php echo $key_prefix; ?>search_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  font-size: $<?php echo $key_prefix; ?>search_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?>.x-search.x-search-focused {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  ?>
}



<?php

// Input
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search .x-search-input {
  order: $<?php echo $key_prefix; ?>search_order_input;
  @unless $<?php echo $key_prefix; ?>search_input_margin?? {
    margin: $<?php echo $key_prefix; ?>search_input_margin;
  }
  @if $<?php echo $key_prefix; ?>search_input_margin?? {
    margin: 0px;
  }
  <?php
  echo cs_get_partial_style( '_linotype', $data_linotype );
  echo cs_get_partial_style( '_color-base', $data_color );
  ?>
}

.$_el<?php echo $selector; ?>.x-search.x-search-has-content .x-search-input {
  <?php echo cs_get_partial_style( '_color-alt', $data_color ); ?>
}



<?php

// Submit
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit {
  order: $<?php echo $key_prefix; ?>search_order_submit;
  width: $<?php echo $key_prefix; ?>search_submit_width;
  height: $<?php echo $key_prefix; ?>search_submit_height;
  @unless $<?php echo $key_prefix; ?>search_submit_margin?? {
    margin: $<?php echo $key_prefix; ?>search_submit_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_submit_border ); ?>
  font-size: $<?php echo $key_prefix; ?>search_submit_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_submit_color );
  echo cs_get_partial_style( '_color-base', $data_submit_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_submit_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit:hover,
.$_el<?php echo $selector; ?>.x-search .x-search-btn-submit:focus {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_submit_color );
  echo cs_get_partial_style( '_border-alt', $data_submit_border );
  echo cs_get_partial_style( '_color-alt', $data_submit_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_submit_box_shadow );
  ?>
}



<?php

// Clear
// =============================================================================

?>

.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear {
  order: $<?php echo $key_prefix; ?>search_order_clear;
  width: $<?php echo $key_prefix; ?>search_clear_width;
  height: $<?php echo $key_prefix; ?>search_clear_height;
  @unless $<?php echo $key_prefix; ?>search_clear_margin?? {
    margin: $<?php echo $key_prefix; ?>search_clear_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_clear_border ); ?>
  font-size: $<?php echo $key_prefix; ?>search_clear_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_clear_color );
  echo cs_get_partial_style( '_color-base', $data_clear_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_clear_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear:hover,
.$_el<?php echo $selector; ?>.x-search .x-search-btn-clear:focus {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_clear_color );
  echo cs_get_partial_style( '_border-alt', $data_clear_border );
  echo cs_get_partial_style( '_color-alt', $data_clear_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_clear_box_shadow );
  ?>
}

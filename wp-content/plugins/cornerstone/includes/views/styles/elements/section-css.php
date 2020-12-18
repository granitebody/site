<?php

// =============================================================================
// SECTION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Particles
//   04. Effects
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'section_border_width',
  'style'  => 'section_border_style',
  'base'   => 'section_border_color',
  'alt'    => 'section_border_color_alt',
  'radius' => 'section_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'section_bg_color',
  'alt'  => 'section_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'section_box_shadow_dimensions',
  'base'       => 'section_box_shadow_color',
  'alt'        => 'section_box_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el.x-section {
  @if $section_overflow !== 'visible' {
    overflow: $section_overflow;
  }
  @unless $section_margin?? {
    margin: $section_margin;
  }
  @if $section_margin?? {
    margin: 0px;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $section_padding?? {
    padding: $section_padding;
  }
  @if $section_padding?? {
    padding: 0px;
  }
  @unless $section_base_font_size === '1em' {
    font-size: $section_base_font_size;
  }
  @unless $section_text_align?? {
    text-align: $section_text_align;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
  z-index: $section_z_index;
}

.$_el.x-section:hover,
.$_el.x-section[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el.x-section {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  ?>
}



<?php

// Particles
// =============================================================================

?>

@if $section_primary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-section',
    'particle'            => '.is-primary',
    'particle_key_prefix' => 'section_primary',
    'is_direct_child'     => true,
  ) );

  ?>
}

@if $section_secondary_particle === true {
  <?php

  echo cs_get_partial_style( 'particle', array(
    'context'             => 'layout',
    'selector'            => '.x-section',
    'particle'            => '.is-secondary',
    'particle_key_prefix' => 'section_secondary',
    'is_direct_child'     => true,
  ) );

  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-section',
  'children' => [],
) );

?>

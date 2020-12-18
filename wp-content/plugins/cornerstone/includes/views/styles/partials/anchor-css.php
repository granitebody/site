<?php

// =============================================================================
// _ANCHOR-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Text
//   04. Graphic
//   05. Sub Indicator
//   06. Particles
//   07. Menu Item Transitions
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '.x-anchor';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Particles
// ---------

$particle_primary = array(
  'selector'            => $selector,
  'particle'            => '.is-primary',
  'particle_key_prefix' => $key_prefix . 'anchor_primary',
  'anchor_key_prefix'   => $key_prefix,
  'is_direct_child'     => true,
);

$particle_secondary = array(
  'selector'            => $selector,
  'particle'            => '.is-secondary',
  'particle_key_prefix' => $key_prefix . 'anchor_secondary',
  'anchor_key_prefix'   => $key_prefix,
  'is_direct_child'     => true,
);


// Appearance
// ----------

$data_border = array(
  'width'  => $key_prefix . 'anchor_border_width',
  'style'  => $key_prefix . 'anchor_border_style',
  'base'   => $key_prefix . 'anchor_border_color',
  'alt'    => $key_prefix . 'anchor_border_color_alt',
  'radius' => $key_prefix . 'anchor_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'anchor_bg_color',
  'alt'  => $key_prefix . 'anchor_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'anchor_box_shadow_dimensions',
  'base'       => $key_prefix . 'anchor_box_shadow_color',
  'alt'        => $key_prefix . 'anchor_box_shadow_color_alt',
);

$data_motion_transition = array(
  'type'            => 'transition',
  // 'delay'           => $key_prefix . 'anchor_delay',
  'duration'        => $key_prefix . 'anchor_duration',
  'timing_function' => $key_prefix . 'anchor_timing_function',
);


// Primary Text
// ------------

$data_primary_linotype = array(
  'ff'            => $key_prefix . 'anchor_primary_font_family',
  'fsize'         => $key_prefix . 'anchor_primary_font_size',
  'fstyle'        => $key_prefix . 'anchor_primary_font_style',
  'fw'            => $key_prefix . 'anchor_primary_font_weight',
  'lh'            => $key_prefix . 'anchor_primary_line_height',
  'ls'            => $key_prefix . 'anchor_primary_letter_spacing',
  'ta'            => $key_prefix . 'anchor_primary_text_align',
  'td'            => $key_prefix . 'anchor_primary_text_decoration',
  'tt'            => $key_prefix . 'anchor_primary_text_transform',
  'ls_has_offset' => true,
);

$data_primary_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'anchor_primary_text_color',
  'alt'  => $key_prefix . 'anchor_primary_text_color_alt',
);

$data_primary_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'anchor_primary_text_shadow_dimensions',
  'base'       => $key_prefix . 'anchor_primary_text_shadow_color',
  'alt'        => $key_prefix . 'anchor_primary_text_shadow_color_alt',
);


// Secondary Text
// --------------

$data_secondary_linotype = array(
  'ff'            => $key_prefix . 'anchor_secondary_font_family',
  'fsize'         => $key_prefix . 'anchor_secondary_font_size',
  'fstyle'        => $key_prefix . 'anchor_secondary_font_style',
  'fw'            => $key_prefix . 'anchor_secondary_font_weight',
  'lh'            => $key_prefix . 'anchor_secondary_line_height',
  'ls'            => $key_prefix . 'anchor_secondary_letter_spacing',
  'ta'            => $key_prefix . 'anchor_secondary_text_align',
  'td'            => $key_prefix . 'anchor_secondary_text_decoration',
  'tt'            => $key_prefix . 'anchor_secondary_text_transform',
  'ls_has_offset' => true,
);

$data_secondary_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'anchor_secondary_text_color',
  'alt'  => $key_prefix . 'anchor_secondary_text_color_alt',
);

$data_secondary_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'anchor_secondary_text_shadow_dimensions',
  'base'       => $key_prefix . 'anchor_secondary_text_shadow_color',
  'alt'        => $key_prefix . 'anchor_secondary_text_shadow_color_alt',
);


// Sub Indicator
// -------------

$data_sub_indicator_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'anchor_sub_indicator_color',
  'alt'  => $key_prefix . 'anchor_sub_indicator_color_alt',
);

$data_sub_indicator_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'anchor_sub_indicator_text_shadow_dimensions',
  'base'       => $key_prefix . 'anchor_sub_indicator_text_shadow_color',
  'alt'        => $key_prefix . 'anchor_sub_indicator_text_shadow_color_alt',
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  @if $<?php echo $key_prefix; ?>anchor_width !== 'auto' {
    width: $<?php echo $key_prefix; ?>anchor_width;
  }
  @unless $<?php echo $key_prefix; ?>anchor_min_width?? {
    min-width: $<?php echo $key_prefix; ?>anchor_min_width;
  }
  @unless $<?php echo $key_prefix; ?>anchor_max_width?? {
    max-width: $<?php echo $key_prefix; ?>anchor_max_width;
  }
  @if $<?php echo $key_prefix; ?>anchor_height !== 'auto' {
    height: $<?php echo $key_prefix; ?>anchor_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_min_height?? {
    min-height: $<?php echo $key_prefix; ?>anchor_min_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_max_height?? {
    max-height: $<?php echo $key_prefix; ?>anchor_max_height;
  }
  @unless $<?php echo $key_prefix; ?>anchor_margin?? {
    margin: $<?php echo $key_prefix; ?>anchor_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  font-size: $<?php echo $key_prefix; ?>anchor_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}


.$_el<?php echo $selector; ?> .x-anchor-content {
  flex-direction: $<?php echo $key_prefix; ?>anchor_flex_direction;
  justify-content: $<?php echo $key_prefix; ?>anchor_flex_justify;
  align-items: $<?php echo $key_prefix; ?>anchor_flex_align;
  @if $<?php echo $key_prefix; ?>anchor_flex_wrap === true {
    flex-wrap: wrap;
    align-content: $<?php echo $key_prefix; ?>anchor_flex_align;
  }
  @unless $<?php echo $key_prefix; ?>anchor_padding?? {
    padding: $<?php echo $key_prefix; ?>anchor_padding;
  }
}


.$_el<?php echo $selector; ?>:hover,
.$_el<?php echo $selector; ?>[class*="active"],
[data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_border );
  echo cs_get_partial_style( '_color-alt', $data_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
  ?>
}



<?php

// Text
// =============================================================================

?>

@unless $<?php echo $key_prefix; ?>anchor_text === false {
  .$_el<?php echo $selector; ?> .x-anchor-text {
    @if $<?php echo $key_prefix; ?>anchor_text_overflow === true && $<?php echo $key_prefix; ?>anchor_flex_direction === 'column' {
      width: 100%;
    }
    @unless $<?php echo $key_prefix; ?>anchor_text_margin?? {
      margin: $<?php echo $key_prefix; ?>anchor_text_margin;
    }
  }

  @if $<?php echo $key_prefix; ?>anchor_text_overflow === true {
    .$_el<?php echo $selector; ?> .x-anchor-text-primary,
    .$_el<?php echo $selector; ?> .x-anchor-text-secondary {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }

  .$_el<?php echo $selector; ?> .x-anchor-text-primary {
    <?php
    echo cs_get_partial_style( '_linotype', $data_primary_linotype );
    echo cs_get_partial_style( '_shadow-base', $data_primary_text_shadow );
    echo cs_get_partial_style( '_color-base', $data_primary_color );
    ?>
  }

  .$_el<?php echo $selector; ?>:hover .x-anchor-text-primary,
  .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-text-primary,
  [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-anchor-text-primary {
    <?php echo cs_get_partial_style( '_color-alt', $data_primary_color ); ?>
    <?php echo cs_get_partial_style( '_shadow-alt', $data_primary_text_shadow ); ?>
  }

  @if $<?php echo $key_prefix; ?>anchor_has_template === true {
    @if $<?php echo $key_prefix; ?>anchor_text_secondary_content !== '' || $<?php echo $key_prefix; ?>anchor_interactive_content_text_secondary_content !== '' {
      .$_el<?php echo $selector; ?> .x-anchor-text-secondary {
        @if $<?php echo $key_prefix; ?>anchor_text_reverse === true {
          margin-bottom: $<?php echo $key_prefix; ?>anchor_text_spacing;
        }
        @if $<?php echo $key_prefix; ?>anchor_text_reverse === false {
          margin-top: $<?php echo $key_prefix; ?>anchor_text_spacing;
        }
        <?php
        echo cs_get_partial_style( '_linotype', $data_secondary_linotype );
        echo cs_get_partial_style( '_shadow-base', $data_secondary_text_shadow );
        echo cs_get_partial_style( '_color-base', $data_secondary_color );
        ?>
      }

      .$_el<?php echo $selector; ?>:hover .x-anchor-text-secondary,
      .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-text-secondary,
      [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-anchor-text-secondary {
        <?php echo cs_get_partial_style( '_color-alt', $data_secondary_color ); ?>
        <?php echo cs_get_partial_style( '_shadow-alt', $data_secondary_text_shadow ); ?>
      }
    }
  }
}



<?php

// Graphic
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>anchor_has_template === true && $<?php echo $key_prefix; ?>anchor_graphic === true {
  <?php

  echo cs_get_partial_style( 'graphic', array(
    'no_base'    => false,
    'selector'   => $selector,
    'key_prefix' => $key_prefix . 'anchor'
  ) );

  ?>
}



<?php

// Sub Indicator
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>anchor_has_template === true && $<?php echo $key_prefix; ?>anchor_type === 'menu-item' && $<?php echo $key_prefix; ?>anchor_sub_indicator === true {

  .$_el<?php echo $selector; ?> .x-anchor-sub-indicator {
    @if $<?php echo $key_prefix; ?>anchor_sub_indicator_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>anchor_sub_indicator_width;
    }
    @if $<?php echo $key_prefix; ?>anchor_sub_indicator_height !== 'auto' {
      height: $<?php echo $key_prefix; ?>anchor_sub_indicator_height;
      line-height: $<?php echo $key_prefix; ?>anchor_sub_indicator_height;
    }
    @unless $<?php echo $key_prefix; ?>anchor_sub_indicator_margin?? {
      margin: $<?php echo $key_prefix; ?>anchor_sub_indicator_margin;
    }
    font-size: $<?php echo $key_prefix; ?>anchor_sub_indicator_font_size;
    <?php echo cs_get_partial_style( '_shadow-base', $data_sub_indicator_text_shadow ); ?>
    <?php echo cs_get_partial_style( '_color-base', $data_sub_indicator_color ); ?>
  }

  .$_el<?php echo $selector; ?>:hover .x-anchor-sub-indicator,
  .$_el<?php echo $selector; ?>[class*="active"] .x-anchor-sub-indicator,
  [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-anchor-sub-indicator {
    <?php echo cs_get_partial_style( '_color-alt', $data_sub_indicator_color ); ?>
    <?php echo cs_get_partial_style( '_shadow-alt', $data_sub_indicator_text_shadow ); ?>
  }

}



<?php

// Particles
// =============================================================================
// 01. Need to call 2 sets of particles differently as the `context` tells us
//     which duration / delay values to pull in and use for dynamic styling.

?>

@if $<?php echo $key_prefix; ?>anchor_type === 'menu-item' {
  @if $<?php echo $key_prefix; ?>anchor_primary_particle === true {
    <?php echo cs_get_partial_style( 'particle', array_merge( $particle_primary, array( 'context' => 'menu-item' ) ) ); ?>
  }
  @if $<?php echo $key_prefix; ?>anchor_secondary_particle === true {
    <?php echo cs_get_partial_style( 'particle', array_merge( $particle_secondary, array( 'context' => 'menu-item' ) ) ); ?>
  }
}

@if $<?php echo $key_prefix; ?>anchor_type !== 'menu-item' {
  @if $<?php echo $key_prefix; ?>anchor_primary_particle === true {
    <?php echo cs_get_partial_style( 'particle', array_merge( $particle_primary, array( 'context' => 'anchor' ) ) ); ?>
  }
  @if $<?php echo $key_prefix; ?>anchor_secondary_particle === true {
    <?php echo cs_get_partial_style( 'particle', array_merge( $particle_secondary, array( 'context' => 'anchor' ) ) ); ?>
  }
}



<?php

// Menu Item Transitions
// =============================================================================
// .$_el{ $selector },
// .$_el{ $selector } .x-anchor-content,
// .$_el{ $selector } .x-anchor-text-primary,
// .$_el{ $selector } .x-anchor-text-secondary,
// .$_el{ $selector } .x-graphic-child,
// .$_el{ $selector } .x-anchor-sub-indicator,
// .$_el{ $selector } .x-anchor-primary-particle,
// .$_el{ $selector } .x-anchor-secondary-particle {
//
// .$_el<?php echo $selector; ? *
// .$_el<?php echo $selector; ? :not([data-x-particle])

?>

@if $<?php echo $key_prefix; ?>anchor_type === 'menu-item' {
  .$_el<?php echo $selector; ?>,
  .$_el<?php echo $selector; ?> :not([data-x-particle]) {
    <?php echo cs_get_partial_style( '_motion', $data_motion_transition ); ?>
  }
}

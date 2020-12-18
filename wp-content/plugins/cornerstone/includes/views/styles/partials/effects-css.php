<?php

// =============================================================================
// _EFFECTS-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Scroll
//   04. Interaction
// =============================================================================

// Setup
// =============================================================================

$selector        = ( isset( $selector )        ) ? $selector        : '';
$children        = ( isset( $children )        ) ? $children        : [];
$animation_base  = ( isset( $animation_base )  ) ? $animation_base  : 1000;
$transition_base = ( isset( $transition_base ) ) ? $transition_base : 300;

$data_motion_animation = array(
  'type'            => 'animation',
  // 'delay'           => 'effects_delay_animation_alt',
  'duration'        => 'effects_duration_animation_alt',
  'timing_function' => 'effects_timing_function_animation_alt',
  'animation_base'  => $animation_base,
);

$data_motion_transition = array(
  'type'            => 'transition',
  // 'delay'           => 'effects_delay',
  'duration'        => 'effects_duration',
  'timing_function' => 'effects_timing_function',
  'transition_base' => $transition_base,
);



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?> {
  @if $effects_opacity !== 1 {
    opacity: $effects_opacity;
  }
  @unless $effects_filter?? {
    filter: $effects_filter;
  }
  @unless $effects_transform === '' {
    transform: $effects_transform;
  }
  @if $effects_transform_origin !== '50% 50%' {
    transform-origin: $effects_transform_origin;
  }
  @if $effects_transform LIKE '%3d%' || $effects_transform LIKE '%Z%' || $effects_transform_alt LIKE '%3d%' || $effects_transform_alt LIKE '%Z%' || $effects_transform_enter LIKE '%3d%' || $effects_transform_enter LIKE '%Z%' || $effects_transform_exit LIKE '%3d%' || $effects_transform_exit LIKE '%Z%' {
    transform-style: preserve-3d;
  }
  @if $effects_mix_blend_mode !== 'normal' {
    mix-blend-mode: $effects_mix_blend_mode;
  }
  @unless $effects_backdrop_filter?? {
    -webkit-backdrop-filter: $effects_backdrop_filter;
    backdrop-filter: $effects_backdrop_filter;
  }
  @if $effects_alt === true && $effects_type_alt === 'animation' {
    <?php echo cs_get_partial_style( '_motion', $data_motion_animation ); ?>
  }
  <?php echo cs_get_partial_style( '_motion', $data_motion_transition ); ?>
}

<?php if ( ! empty( $children ) ) : ?>
  <?php foreach ( $children as $child ) : ?>
    .$_el<?php echo $selector; ?> <?php echo $child; ?> {
      <?php echo cs_get_partial_style( '_motion', $data_motion_transition ); ?>
    }
  <?php endforeach; ?>
<?php endif; ?>



<?php

// Scroll
// =============================================================================

?>

@if $effects_scroll === true {

  @unless $_preview_interaction === true {
    .$_el<?php echo $selector; ?>.x-effect-exit,
    .$_el<?php echo $selector; ?>.x-effect-entering,
    .$_el<?php echo $selector; ?>.x-effect-exiting {
      animation: $effects_duration_scroll $effects_timing_function_scroll $effects_delay_scroll;
      transition: $effects_duration_scroll $effects_timing_function_scroll $effects_delay_scroll;
    }
  }

  .$_el<?php echo $selector; ?>.x-effect-enter {
    @if $effects_opacity_enter !== 1 || $effects_opacity_exit !== 1 {
      opacity: $effects_opacity_enter;
    }
    @unless $effects_filter_enter?? {
      filter: $effects_filter_enter;
    }
    @unless $effects_transform_enter === '' {
      @if $effects_type_scroll === 'transform' {
        transform: $effects_transform_enter;
      }
    }
  }

  @unless $_preview_interaction === true {
    .$_el<?php echo $selector; ?>.x-effect-exit {
      @if $effects_opacity_exit !== 1 || $effects_opacity_enter !== 1 {
        opacity: $effects_opacity_exit;
      }
      @unless $effects_filter_exit?? {
        filter: $effects_filter_exit;
      }
      @unless $effects_transform_exit === '' {
        @if $effects_type_scroll === 'transform' {
          transform: $effects_transform_exit;
        }
      }
    }
  }

}



<?php

// Interaction
// =============================================================================

?>



@if $effects_alt === true && $_preview_interaction !== true {
  .$_el<?php echo $selector; ?>:hover,
  [data-x-effect-provider*="effects"]:hover .$_el<?php echo $selector; ?>:not(.x-effect-exit) {
    @if $effects_opacity_alt !== 1 || $effects_opacity !== 1 {
      opacity: $effects_opacity_alt;
    }
    @unless $effects_filter_alt?? {
      filter: $effects_filter_alt;
    }
    @unless $effects_transform_alt === '' {
      @if $effects_type_alt === 'transform' {
        transform: $effects_transform_alt;
      }
    }
  }
}

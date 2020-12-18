<?php

// =============================================================================
// _PARTICLE-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Interactions
// =============================================================================

// Setup
// =============================================================================

$context             = ( isset( $context )                                           ) ? $context                   : 'layout';
$selector            = ( isset( $selector )                                          ) ? $selector                  : '';
$particle            = ( isset( $particle )                                          ) ? $particle                  : '.x-particle';
$particle_key_prefix = ( isset( $particle_key_prefix ) && $particle_key_prefix != '' ) ? $particle_key_prefix . '_' : '';
$anchor_key_prefix   = ( isset( $anchor_key_prefix ) && $anchor_key_prefix != ''     ) ? $anchor_key_prefix         : '';
$is_direct_child     = ( isset( $is_direct_child ) && $is_direct_child == true       ) ? ' > '                      : ' ';



// Base
// =============================================================================

?>

.$_el<?php echo $selector; ?><?php echo $is_direct_child; ?><?php echo $particle; ?> {

  width: $<?php echo $particle_key_prefix; ?>particle_width;
  height: $<?php echo $particle_key_prefix; ?>particle_height;
  @unless $<?php echo $particle_key_prefix; ?>particle_border_radius?? {
    border-radius: $<?php echo $particle_key_prefix; ?>particle_border_radius;
  }
  color: $<?php echo $particle_key_prefix; ?>particle_color;
  transform-origin: $<?php echo $particle_key_prefix; ?>particle_transform_origin;

  <?php if ( $context !== 'menu-item' ) : ?>
    @if $effects_duration !== '300ms' {
      transition-duration: $effects_duration;
    }
    @if $effects_timing_function !== 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' {
      transition-timing-function: $effects_timing_function;
    }
  <?php endif; ?>

  <?php if ( $context === 'menu-item' ) : ?>
    @if $anchor_duration !== '300ms' {
      transition-duration: $<?php echo $anchor_key_prefix; ?>anchor_duration;
    }
    @if $anchor_timing_function !== 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' {
      transition-timing-function: $<?php echo $anchor_key_prefix; ?>anchor_timing_function;
    }
  <?php endif; ?>

}



<?php

// Interactions
// =============================================================================
// .$_el<?php echo $selector; ?![class*="active"]<?php echo $is_direct_child; ?!<?php echo $particle; ?!,

?>

.$_el<?php echo $selector; ?>:hover<?php echo $is_direct_child; ?><?php echo $particle; ?>,
[data-x-effect-provider*="particles"]:hover .$_el<?php echo $selector; ?><?php echo $is_direct_child; ?><?php echo $particle; ?> {

  @unless $<?php echo $particle_key_prefix; ?>particle_delay?? {
    transition-delay: $<?php echo $particle_key_prefix; ?>particle_delay;
  }

  @if $<?php echo $particle_key_prefix; ?>particle_scale === 'none' {
    <?php if ( $context !== 'menu-item' ) : ?>
      @if $effects_duration !== '300ms' {
        transition-duration: $effects_duration;
      }
    <?php endif; ?>
    <?php if ( $context === 'menu-item' ) : ?>
      @if $<?php echo $anchor_key_prefix; ?>anchor_duration !== '300ms' {
        transition-duration: $<?php echo $anchor_key_prefix; ?>anchor_duration;
      }
    <?php endif; ?>
  }

  @if $<?php echo $particle_key_prefix; ?>particle_scale !== 'none' {
    <?php if ( $context !== 'menu-item' ) : ?>
      @if $effects_duration !== '300ms' {
        transition-duration: 0ms, $effects_duration;
      }
    <?php endif; ?>
    <?php if ( $context === 'menu-item' ) : ?>
      @if $<?php echo $anchor_key_prefix; ?>anchor_duration !== '300ms' {
        transition-duration: 0ms, $<?php echo $anchor_key_prefix; ?>anchor_duration;
      }
    <?php endif; ?>
  }

}

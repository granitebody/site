<?php

// =============================================================================
// _MOTION-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
// =============================================================================

// Setup
// =============================================================================

$type            = ( isset( $type )            ) ? $type            : 'transition';
$delay           = ( isset( $delay )           ) ? $delay           : '';
$duration        = ( isset( $duration )        ) ? $duration        : '';
$timing_function = ( isset( $timing_function ) ) ? $timing_function : '';
$combined        = ( isset( $combined )        ) ? $combined        : false;
$animation_base  = ( isset( $animation_base )  ) ? $animation_base  : 1000;
$transition_base = ( isset( $transition_base ) ) ? $transition_base : 300;

$d1 = ( $type === 'transition' ) ? $transition_base . 'ms' : $animation_base . 'ms';



// Base
// =============================================================================

?>

<?php if ( $combined === true ) : ?>

  <?php echo $type; ?>:
    <?php if ( ! empty ( $duration ) ) : ?>
      @if $<?php echo $duration ?> !== '<?php echo $d1; ?>' {
        $<?php echo $duration ?>
      }
    <?php endif; ?>
    <?php if ( ! empty ( $timing_function ) ) : ?>
      @if $<?php echo $timing_function ?> !== 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' {
        $<?php echo $timing_function ?>
      }
    <?php endif; ?>
    <?php if ( ! empty ( $delay ) ) : ?>
      @if $<?php echo $delay; ?> !== '0ms' && $<?php echo $delay; ?> !== '0s' {
        $<?php echo $delay; ?>
      }
    <?php endif; ?>
  ;

<?php else : ?>

  <?php if ( ! empty ( $delay ) ) : ?>
    @if $<?php echo $delay; ?> !== '0ms' && $<?php echo $delay; ?> !== '0s' {
      <?php echo $type; ?>-delay: $<?php echo $delay; ?>;
    }
  <?php endif; ?>

  <?php if ( ! empty ( $duration ) ) : ?>
    @if $<?php echo $duration ?> !== '<?php echo $d1; ?>' {
      <?php echo $type; ?>-duration: $<?php echo $duration ?>;
    }
  <?php endif; ?>

  <?php if ( ! empty ( $timing_function ) ) : ?>
    @if $<?php echo $timing_function ?> !== 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' {
      <?php echo $type; ?>-timing-function: $<?php echo $timing_function ?>;
    }
  <?php endif; ?>

<?php endif; ?>

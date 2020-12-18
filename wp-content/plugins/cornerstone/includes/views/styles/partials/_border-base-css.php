<?php

// =============================================================================
// _BORDER-BASE-CSS.PHP
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

$width      = ( isset( $width )      ) ? $width      : '';
$style      = ( isset( $style )      ) ? $style      : '';
$base       = ( isset( $base )       ) ? $base       : '';
$alt        = ( isset( $alt )        ) ? $alt        : false;
$radius     = ( isset( $radius )     ) ? $radius     : '';
$color_only = ( isset( $color_only ) ) ? $color_only : false;
$fallback   = ( isset( $fallback )   ) ? $fallback   : false;



// Base
// =============================================================================
// 01. There are times where we just want to output the border color for a
//     previously declared width and style (e.g. Pagination Element).

?>

<?php if ( ! empty ( $width ) && ! empty ( $style ) ) : ?>

  @unless $<?php echo $width; ?>?? || $<?php echo $style; ?>?? {
    <?php if ( $color_only === true ) : // 01 ?>
      border-color: $<?php echo $base; ?>;
    <?php else : ?>
      border-width: $<?php echo $width; ?>;
      border-style: $<?php echo $style; ?>;
      border-color: $<?php echo $base; ?>;
    <?php endif; ?>
  }

  <?php if ( $fallback === true ) : ?>

    @if $<?php echo $width; ?>?? || $<?php echo $style; ?>?? {
      <?php if ( $color_only === true ) : ?>
        border-color: transparent;
      <?php else : ?>
        border: 0;
      <?php endif; ?>
    }

  <?php endif; ?>

<?php endif; ?>

<?php if ( ! empty ( $radius ) ) : ?>

  @unless $<?php echo $radius; ?>?? {
    border-radius: $<?php echo $radius; ?>;
  }

  <?php if ( $fallback === true ) : ?>
    @if $<?php echo $radius; ?>?? {
      border-radius: 0;
    }
  <?php endif; ?>

<?php endif; ?>

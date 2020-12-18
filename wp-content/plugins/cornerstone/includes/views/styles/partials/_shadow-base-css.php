<?php

// =============================================================================
// _SHADOW-BASE-CSS.PHP
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

$type              = ( isset( $type )              ) ? $type              : 'box';
$dimensions        = ( isset( $dimensions )        ) ? $dimensions        : '';
$base              = ( isset( $base )              ) ? $base              : '';
$alt               = ( isset( $alt )               ) ? $alt               : false;
$no_alt_allow_none = ( isset( $no_alt_allow_none ) ) ? $no_alt_allow_none : false;
$fallback          = ( isset( $fallback )          ) ? $fallback          : false;



// Base
// =============================================================================
// 01. If $dimensions are not empty, proceed.
// 
// 02. If no $alt, use this block.
// 03. There are times when we want to force `box-shadow: none;` in certain
//     situations to ensure an overwrite (e.g. Pagination Element).
// 04. If $base is not transparent, proceed.
// 
// 05. If $alt is present, use this block.
// 06. If $base and $alt are not both transparent, proceed.

?>

@unless $<?php echo $dimensions; ?>?? { <?php // 01 ?>

  <?php if ( $alt === false ) : // 02 ?>

    <?php if ( $no_alt_allow_none === true ) : // 03 ?>
      @if $<?php echo $base; ?> LIKE '%transparent%' {
        <?php echo $type; ?>-shadow: none;
      }
    <?php endif; ?>

    @unless $<?php echo $base; ?> LIKE '%transparent%' { <?php // 04 ?>
      <?php echo $type; ?>-shadow: $<?php echo $dimensions; ?> $<?php echo $base; ?>;
    }

  <?php else : // 05 ?>

    @unless $<?php echo $base; ?> LIKE '%transparent%' && $<?php echo $alt; ?> LIKE '%transparent%' { <?php // 06 ?>

      @if $<?php echo $base; ?> LIKE '%transparent%' {
        <?php echo $type; ?>-shadow: none;
      }

      @unless $<?php echo $base; ?> LIKE '%transparent%' {
        <?php echo $type; ?>-shadow: $<?php echo $dimensions; ?> $<?php echo $base; ?>;
      }

    }

  <?php endif; ?>

}

<?php if ( $fallback ) : ?>

  @if $<?php echo $dimensions; ?>?? {
    <?php echo $type; ?>-shadow: none;
  }

<?php endif; ?>

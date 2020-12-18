<?php

// =============================================================================
// _SHADOW-ALT-CSS.PHP
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

$type       = ( isset( $type )       ) ? $type       : 'box';
$dimensions = ( isset( $dimensions ) ) ? $dimensions : '';
$base       = ( isset( $base )       ) ? $base       : '';
$alt        = ( isset( $alt )        ) ? $alt        : '';



// Base
// =============================================================================
// 01. If $dimensions are not empty and $alt is not an empty string, proceed.
// 02. If $base and $alt are not both transparent, proceed.

?>

@unless $<?php echo $dimensions; ?>?? || $<?php echo $alt; ?> === '' { <?php // 01 ?>
  @unless $<?php echo $base; ?> LIKE '%transparent%' && $<?php echo $alt; ?> LIKE '%transparent%' { <?php // 02 ?>

    @if $<?php echo $alt; ?> LIKE '%transparent%' && $<?php echo $alt; ?> !== $<?php echo $base; ?> {
      <?php echo $type; ?>-shadow: none;
    }

    @unless $<?php echo $alt; ?> LIKE '%transparent%' && $<?php echo $alt; ?> !== $<?php echo $base; ?> {
      <?php echo $type; ?>-shadow: $<?php echo $dimensions; ?> $<?php echo $alt; ?>;
    }

  }
}

<?php

// =============================================================================
// _COLOR-BASE-CSS.PHP
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

$type = ( isset( $type ) && $type === 'color' ) ? $type : $type . '-color';
$base = ( isset( $base )                      ) ? $base : '';
$alt  = ( isset( $alt )                       ) ? $alt  : false;



// Base
// =============================================================================
// 01. If $type is "color," output immediately.
// 02. $type can be "color" or "background," and if necessary will be appended
//     with a dash via the ternary above.
// 03. If there is no $alt, proceed.
// 04. If $base and $alt are not both transparent, proceed.

?>

<?php if ( $type === 'color' ) : // 01 ?>

  <?php echo $type; ?>: $<?php echo $base; ?>;

<?php else : // 02 ?>
  <?php if ( $alt === false ) : // 03 ?>

    @unless $<?php echo $base; ?> LIKE '%transparent%' {
      <?php echo $type; ?>: $<?php echo $base; ?>;
    }

  <?php else : ?>

    @unless $<?php echo $base; ?> LIKE '%transparent%' && $<?php echo $alt; ?> LIKE '%transparent%' { <?php // 04 ?>
      <?php echo $type; ?>: $<?php echo $base; ?>;
    }

  <?php endif; ?>
<?php endif; ?>

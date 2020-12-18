<?php

// =============================================================================
// _LINOTYPE-CSS.PHP
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

$ff            = ( isset( $ff )            ) ? $ff            : '';
$fsize         = ( isset( $fsize )         ) ? $fsize         : '';
$fstyle        = ( isset( $fstyle )        ) ? $fstyle        : '';
$fw            = ( isset( $fw )            ) ? $fw            : '';
$lh            = ( isset( $lh )            ) ? $lh            : '';
$ls            = ( isset( $ls )            ) ? $ls            : '';
$ta            = ( isset( $ta )            ) ? $ta            : '';
$td            = ( isset( $td )            ) ? $td            : '';
$tt            = ( isset( $tt )            ) ? $tt            : '';
$ls_force      = ( isset( $ls_force )      ) ? $ls_force      : false;
$ls_has_offset = ( isset( $ls_has_offset ) ) ? $ls_has_offset : false;
$ta_force      = ( isset( $ta_force )      ) ? $ta_force      : false;
$tt_force      = ( isset( $tt_force )      ) ? $tt_force      : false;



// Base
// =============================================================================

?>

<?php if ( ! empty( $ff ) ) : ?>
  font-family: $<?php echo $ff; ?>;
<?php endif; ?>

<?php if ( ! empty( $fsize ) ) : ?>
  font-size: $<?php echo $fsize; ?>;
<?php endif; ?>

<?php if ( ! empty( $fstyle ) ) : ?>
  font-style: $<?php echo $fstyle; ?>;
<?php endif; ?>

<?php if ( ! empty( $fw ) ) : ?>
  font-weight: $<?php echo $fw; ?>;
<?php endif; ?>

<?php if ( ! empty( $lh ) ) : ?>
  line-height: $<?php echo $lh; ?>;
<?php endif; ?>

<?php if ( ! empty( $ls ) ) : ?>
  <?php if ( $ls_force === true ) : ?>
    letter-spacing: $<?php echo $ls; ?>;
    <?php if ( $ls_has_offset === true ) : ?>
      margin-right: calc($<?php echo $ls; ?> * -1);
    <?php endif; ?>
  <?php else : ?>
    @unless $<?php echo $ls; ?>?? {
      letter-spacing: $<?php echo $ls; ?>;
      <?php if ( $ls_has_offset === true ) : ?>
        margin-right: calc($<?php echo $ls; ?> * -1);
      <?php endif; ?>
    }
  <?php endif; ?>
<?php endif; ?>

<?php if ( ! empty( $ta ) ) : ?>
  <?php if ( $ta_force === true ) : ?>
    text-align: $<?php echo $ta; ?>;
  <?php else : ?>
    @unless $<?php echo $ta; ?>?? {
      text-align: $<?php echo $ta; ?>;
    }
  <?php endif; ?>
<?php endif; ?>

<?php if ( ! empty( $td ) ) : ?>
  @unless $<?php echo $td; ?>?? {
    text-decoration: $<?php echo $td; ?>;
  }
<?php endif; ?>

<?php if ( ! empty( $tt ) ) : ?>
  <?php if ( $tt_force === true ) : ?>
    text-transform: $<?php echo $tt; ?>;
  <?php else : ?>
    @unless $<?php echo $tt; ?>?? {
      text-transform: $<?php echo $tt; ?>;
    }
  <?php endif; ?>
<?php endif; ?>

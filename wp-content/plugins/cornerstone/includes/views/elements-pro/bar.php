<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/BAR.PHP
// -----------------------------------------------------------------------------
// Bar element.
// =============================================================================

$bar_region_is_lr  = $_region === 'left' || $_region === 'right';
$bar_region_is_tbf = $_region === 'top' || $_region === 'bottom' || $_region === 'footer';
$bar_is_sticky     = $_region === 'top' && $bar_sticky === true;

$is_preview = apply_filters( 'cs_is_preview', false );

$bar_position = cs_identity_bar_position( $_view_data );


// Prepare Classes
// ---------------

$class_region_specific = 'x-bar-' . $_region;
$class_region_general  = ( $bar_region_is_lr ) ? 'x-bar-v' : 'x-bar-h';
$class_position        = 'x-bar-' . $bar_position;
$class_sticky          = ( $bar_is_sticky ) ? 'x-bar-is-sticky' : '';
$class_hide_initially  = ( $bar_is_sticky && $bar_sticky_hide_initially ) ? 'x-bar-is-initially-hidden' : '';

$classes = array( $style_id, 'x-bar', $class_region_specific, $class_region_general, $class_position, $class_sticky, $class_hide_initially, $class );

if ( $bar_scroll === false ) {
  $classes[] = 'x-bar-outer-spacers';
}


// Prepare Data
// ------------

$bar_data = array(
  'id'     => $unique_id,
  'region' => $_region,
);

if ( $bar_region_is_lr ) {
  $bar_data['width'] = $bar_width;
}

if ( $bar_region_is_tbf ) {
  $bar_data['height'] = $bar_height;
}

if ( $bar_is_sticky ) {
  $bar_data['keepMargin']      = $bar_sticky_keep_margin;
  $bar_data['hideInitially']   = $bar_sticky_hide_initially;
  $bar_data['zStack']          = $bar_sticky_z_stack;
  $bar_data['triggerOffset']   = $bar_sticky_trigger_offset;
  $bar_data['triggerSelector'] = $bar_sticky_trigger_selector;
  $bar_data['shrink']          = $bar_sticky_shrink;
}


// Atts: Bar
// ---------

$atts_bar = array(
  'class'      => x_attr_class( $classes ),
  'data-x-bar' => x_attr_json( $bar_data ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_bar['id'] = $id;
}


// Atts: Bar Scroll
// ----------------

$bar_scroll_begin = '';
$bar_scroll_end   = '';

if ( $bar_scroll === true && $bar_height !== 'auto' ) {

  $suppress_scroll      = ( $bar_region_is_tbf ) ? 'suppressScrollY' : 'suppressScrollX';
  $atts_bar_scroll_data = array( $suppress_scroll => true );
  $atts_bar_scroll      = array( 'class' => x_attr_class( array( $style_id, 'x-bar-scroll', 'x-bar-outer-spacers' ) ), 'data-x-scrollbar' => x_attr_json( $atts_bar_scroll_data ) );

  $bar_scroll_begin = '<div ' . x_atts( $atts_bar_scroll ) . '>';
  $bar_scroll_end   = '</div>';

  // $atts_bar_scroll_outer = array( 'class' => x_attr_class( array( $style_id, 'x-bar-scroll-outer' ) ) );
  // $atts_bar_scroll_inner = array( 'class' => x_attr_class( array( $style_id, 'x-bar-scroll-inner', 'x-bar-outer-spacers' ) ) );

  // $bar_scroll_begin = '<div ' . x_atts( $atts_bar_scroll_outer ) . '><div ' . x_atts( $atts_bar_scroll_inner ) . '>';
  // $bar_scroll_end   = '</div></div>';

}


// Defer Bar Spaces
// ----------------
// Runs concurrently with code from the bar setup functions to allow for
// proper output of spaces to hooks.
//
// 01. Always tie bottom bars into the footer
// 02. If we are previewing, attach the hooks for left and right bars
//     Right bars have a different action in the preview.

if ( $bar_position === 'fixed' ) {

  if ( 'bottom' === $_region ) { // 01
    cs_defer_view( 'x_before_site_end', 'elements-pro', 'bar', 'space', $_view_data );
  }

  if ( apply_filters( 'cs_is_preview', false )) { // 02

    $preview_bar_space_actions = array(
      'top'  => 'x_before_site_begin',
      'left'   => 'x_before_site_begin',
      'right'  => 'x_after_site_end', // 02
    );

    if ( isset( $preview_bar_space_actions[$_region] ) ) {
      cs_defer_view( $preview_bar_space_actions[$_region], 'elements-pro', 'bar', 'space', $_view_data );
    }

  }

}


// Background Partial
// ------------------

if ( $bar_bg_advanced == true ) {
  $bar_bg  = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

if ( $bar_position_top === 'relative' && $bar_is_sticky && ! $bar_sticky_hide_initially ) {
  ob_start();
  x_get_view( 'elements-pro', 'bar', 'space', $_view_data );
  $top_bar_space = ob_get_clean();
  if ( ! $is_preview ) {
    echo $top_bar_space;
  }
}

?>

<?php ob_start(); ?>

<div <?php echo x_atts( $atts_bar, $custom_atts ); ?>>

  <?php if ( isset( $top_bar_space ) && $is_preview ) { echo $top_bar_space; } ?>
  <?php if ( isset( $bar_bg ) ) { echo $bar_bg; } ?>

  <?php echo $bar_scroll_begin; ?>
    <div class="<?php echo $style_id; ?> x-bar-content">
      <?php do_action( 'x_bar', $_modules, $_view_data ); ?>
    </div>
  <?php echo $bar_scroll_end; ?>

</div>


<?php echo apply_filters('cs_render_bar_output', ob_get_clean()); ?>

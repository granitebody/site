<?php

// =============================================================================
// VIEWS/ELEMENTS/COLUMN.PHP
// -----------------------------------------------------------------------------
// Column element.
// =============================================================================


$style_id = ( isset( $style_id ) ) ? $style_id : '';
$atts     = ( isset( $atts )   ) ? $atts   : array();


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-column', 'x-sm', 'x-' . str_replace( '/', '-', $size ), $class );


// Atts
// ----

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( $column_fade ) {

  $atts['data-fade'] = true;
  $atts = array_merge( $atts, cs_element_js_atts( 'column', array( 'fade' => true ) ) ); // 02

  switch ( $column_fade_animation ) {
    case 'in' :
      $column_fade_animation_offset = '';
      break;
    case 'in-from-top' :
      $column_fade_animation_offset = ' transform: translate(0, -' . $column_fade_animation_offset . '); ';
      break;
    case 'in-from-left' :
      $column_fade_animation_offset = ' transform: translate(-' . $column_fade_animation_offset . ', 0); ';
      break;
    case 'in-from-right' :
      $column_fade_animation_offset = ' transform: translate(' . $column_fade_animation_offset . ', 0); ';
      break;
    case 'in-from-bottom' :
      $column_fade_animation_offset = ' transform: translate(0, ' . $column_fade_animation_offset . '); ';
      break;
  }

  $column_fade_style = 'opacity: 0;' . $column_fade_animation_offset . 'transition-duration: ' . $column_fade_duration . ';';

  if ( isset( $atts['style'] ) ) {
    $atts['style'] .= ' ' . $column_fade_style;
  } else {
    $atts['style'] = $column_fade_style;
  }

}


// Background Partial
// ------------------

$column_bg = NULL;

if ( $column_bg_advanced === true ) {
  $data_bg   = cs_extract( $_view_data, array( 'bg' => '' ) );
  $column_bg = cs_get_partial_view( 'bg', $data_bg );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo $column_bg; ?>
  <?php do_action( 'x_column', $_modules, $_view_data ); ?>
</div>

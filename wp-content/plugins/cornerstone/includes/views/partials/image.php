<?php

// =============================================================================
// VIEWS/PARTIALS/IMAGE.PHP
// -----------------------------------------------------------------------------
// Image partial.
// =============================================================================

// Notes
// -----
// 01. Sometimes the image source key passed down will end with "_alt", so we
//     account for and allow this if it is the value provided.
// 02. Sometimes the image alt text key passed down will end with "_alt", so we
//     account for and allow this if it is the value provided. A default alt
//     text value is generated in case one is not provided.

$style_id    = ( isset( $style_id )      ) ? $style_id        : '';
$atts        = ( isset( $atts )          ) ? $atts          : array();
$custom_atts = ( isset( $custom_atts )   ) ? $custom_atts   : null;
$image_src   = ( isset( $image_src_alt ) ) ? $image_src_alt : $image_src; // 01


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-image', $class );


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


if ( isset( $image_alt_alt ) && ! empty( $image_alt_alt ) ) { // 02
  $image_alt = $image_alt_alt;
} else if ( isset( $image_alt ) && ! empty( $image_alt ) ) {
  $image_alt = $image_alt;
} else {
  $image_alt = '';
}

$atts_image = cs_apply_image_atts([
  'src'    => $image_src,
  'retina' => $image_retina,
  'width'  => $image_width,
  'height' => $image_height,
  'alt'    => $image_alt
]);


// Scaling
// -------

if ( ( isset( $_region ) && $_region === 'top' ) && ( isset( $image_type ) && $image_type === 'scaling' ) && ! empty( $atts_image['width'] ) && ! empty( $atts_image['height'] ) ) {

  $scaling_style = 'width: 100%; max-width: ' . $atts_image['width'] . 'px;';

  if ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' ) {
    $scaling_style = 'height: 100%; max-height: ' . $atts_image['height'] . 'px;';
  }

  $atts['class'] .= ' x-image-preserve-ratio';

  if ( isset( $atts['style'] ) ) {
    $atts['style'] .= ' ' . $scaling_style;
  } else {
    $atts['style'] = $scaling_style;
  }

}


// Linked vs. Not
// --------------

$is_in_link = apply_filters( 'cs_in_link', false );

if ( isset( $image_link ) && $image_link === true && ! $is_in_link ) {
  $tag  = 'a';
  $atts = cs_apply_link( $atts, $_view_data, 'image' );
} else {
  $tag = 'span';
}



// Output
// ------

?>

<<?php echo $tag; ?> <?php echo x_atts( $atts, $custom_atts ); ?>>
  <img <?php echo x_atts( $atts_image ); ?>>
</<?php echo $tag; ?>>

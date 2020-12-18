<?php

// =============================================================================
// VIEWS/ELEMENTS/MAP-MARKER.PHP
// -----------------------------------------------------------------------------
// Map marker element.
// =============================================================================

// Prepare Atts
// ------------

$atts = array(
  'style' => 'position: absolute; visibility: hidden;',
);

$data = array(
  'lat'          => $map_marker_lat,
  'lng'          => $map_marker_lng,
  'content'      => cs_decode_shortcode_attribute( $map_marker_content ),
  'contentStart' => $map_marker_content_start,
);

if ( $map_marker_image_src !== '' ) {
  $atts_image = cs_apply_image_atts( [
    'src'    => $map_marker_image_src,
    'width'  => $map_marker_image_width,
    'height' => $map_marker_image_height
  ] );

  $data = array_merge( $data, array(
    'imageSrc'     => isset( $atts_image['src'] )    ? $atts_image['src'] : '',
    'imageWidth'   => isset( $atts_image['width'] )  ? $atts_image['width'] : '',
    'imageHeight'  => isset( $atts_image['height'] ) ? $atts_image['height'] : '',
    'imageRetina'  => $map_marker_image_retina,
    'imageOffsetX' => $map_marker_offset_x,
    'imageOffsetY' => $map_marker_offset_y,
  ) );
}

$atts = array_merge( $atts, cs_element_js_atts( 'map_google_marker', $data ) );

?>

<div <?php echo x_atts( $atts ); ?>></div>

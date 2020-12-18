<?php

// =============================================================================
// VIEWS/ELEMENTS/ALERT.PHP
// -----------------------------------------------------------------------------
// Alert element.
// =============================================================================

$style_id = ( isset( $style_id ) ) ? $style_id : '';
$class    = ( isset( $class )    ) ? $class    : '';


// Prepare Attr Values
// -------------------

$classes = array( $style_id, 'x-alert' );

if ( $alert_close === true ) {
  $classes[] = 'fade';
  $classes[] = 'in';
} else {
  $classes[] = 'x-alert-block';
}

$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Content
// -------

$alert_close_content = NULL;

if ( $alert_close === true ) {
  $alert_close_content = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts, $custom_atts ); ?>>
  <?php echo $alert_close_content; ?>
  <div class="x-alert-content"><?php echo do_shortcode( $alert_content ); ?></div>
</div>

<?php

// =============================================================================
// VIEWS/ELEMENTS/ACCORDION.PHP
// -----------------------------------------------------------------------------
// Accordion element.
// =============================================================================

$unique_id = ( isset( $unique_id ) ) ? $unique_id : '';
$style_id  = ( isset( $style_id ) ) ? $style_id : '';
$class     = ( isset( $class )  ) ? $class  : '';


// Atts: Accordion
// ---------------

$atts_accordion = array(
  'class' => x_attr_class( array( $style_id, 'x-acc', $class ) ),
  'role'  => 'tablist',
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_accordion['id'] = $id;
} else {
  $atts_accordion['id'] = 'x-acc-' . $unique_id;
}

$atts_accordion = cs_apply_effect( $atts_accordion, $_view_data );


// Output
// ------

?>

<div <?php echo x_atts( $atts_accordion, $custom_atts ); ?>>
  <?php do_action( 'x_render_children', $_modules, $_view_data ); ?>
</div>

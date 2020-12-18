<?php

// =============================================================================
// VIEWS/ELEMENTS/ACCORDION-ITEM.PHP
// -----------------------------------------------------------------------------
// Accordion Item element.
// =============================================================================

$unique_id = ( isset( $unique_id ) ) ? $unique_id : '';
$style_id  = ( isset( $style_id ) ) ? $style_id : '';
$class     = ( isset( $class )  ) ? $class  : '';

// Atts: Accordion Item
// --------------------

$atts_accordion_item = array(
  'class' => x_attr_class( array( $style_id, 'x-acc-item', $class ) ),
);

if (isset($id) && $id) {
  $atts_accordion_item['id'] = $id;
}

// Atts: Accordion Header
// ----------------------

$accordion_item_header_class = array( 'x-acc-header' );

if ( $accordion_item_starts_open ) {
  $accordion_item_header_class[] = 'x-active';
}

$atts_accordion_header = array(
  'id'                => 'tab-' . $unique_id,
  'class'             => x_attr_class( $accordion_item_header_class ),
  'role'              => 'tab',
  'type'              => 'button',
  'aria-selected'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
  'aria-expanded'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
  'aria-controls'     => 'panel-' . $unique_id,
  'data-x-toggle'     => 'collapse',
  'data-x-toggleable' => $unique_id,
);

if ( $accordion_grouped ) {
  if ( ! empty( $accordion_group ) ) {
    $atts_accordion_header['data-x-toggle-group'] = $accordion_group;
  } else {
    $atts_accordion_header['data-x-toggle-group'] = $p_unique_id;
  }
}

if ( ! empty( $toggle_hash ) ) {
  $atts_accordion_header['data-x-toggle-hash'] = $toggle_hash;
}


// Atts: Accordion Collapse
// ------------------------

$atts_accordion_collapse = array(
  'id'                     => 'panel-' . $unique_id,
  'role'                   => 'tabpanel',
  'aria-hidden'            => ( $accordion_item_starts_open ) ? 'false' : 'true',
  'aria-labelledby'        => 'tab-' . $unique_id,
  'data-x-toggleable'      => $unique_id,
  'data-x-toggle-collapse' => true,
);

if ( ! $accordion_item_starts_open ) {
  $atts_accordion_collapse['class'] = 'x-collapsed';
}


// Header Indicator
// ----------------

$accordion_header_indicator_content = '';

if ( $accordion_header_indicator === true ) {
  
  $_view_data['id'] = ''; // Make sure icon partial view doesn't inherit the accordion item ID.

  $accordion_header_indicator_content = ( $accordion_header_indicator_type === 'text' ) ? $accordion_header_indicator_text : cs_get_partial_view( 'icon', cs_extract( $_view_data, array( 'accordion_header_indicator_icon' => 'icon' ) ) );
  $accordion_header_indicator_content = '<span class="x-acc-header-indicator">' . $accordion_header_indicator_content . '</span>';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts_accordion_item, $custom_atts ); ?>>
  <button <?php echo x_atts( $atts_accordion_header ); ?>>
    <span class="x-acc-header-content">
      <?php echo $accordion_header_indicator_content; ?>
      <span class="x-acc-header-text"><?php echo do_shortcode( $accordion_item_header_content ); ?></span>
    </span>
  </button>
  <div <?php echo x_atts( $atts_accordion_collapse ); ?>>
    <div class="x-acc-content">
      <?php echo do_shortcode( $accordion_item_content ); ?>
    </div>
  </div>
</div>

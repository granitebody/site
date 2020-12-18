<?php

// =============================================================================
// TP-WC-PRODUCT-GALLERY-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Base
//   03. Effects
// =============================================================================

// Setup
// =============================================================================

$data_border = array(
  'width'  => 'product_gallery_border_width',
  'style'  => 'product_gallery_border_style',
  'base'   => 'product_gallery_border_color',
  'radius' => 'product_gallery_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => 'product_gallery_bg_color',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => 'product_gallery_box_shadow_dimensions',
  'base'       => 'product_gallery_box_shadow_color',
);



// Base
// =============================================================================

?>

.$_el.x-wc-product-gallery {
  @if $product_gallery_overflow !== 'visible' {
    overflow: $product_gallery_overflow;
  }
  @unless $product_gallery_max_width?? {
    max-width: $product_gallery_max_width;
  }
  @unless $product_gallery_margin?? {
    margin: $product_gallery_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
  @unless $product_gallery_padding?? {
    padding: $product_gallery_padding;
  }
  font-size: $product_gallery_base_font_size;
  <?php
  echo cs_get_partial_style( '_color-base', $data_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
  ?>
}



<?php

// Effects
// =============================================================================

echo cs_get_partial_style( 'effects', array(
  'selector' => '.x-wc-product-gallery',
  'children' => [],
) );

?>

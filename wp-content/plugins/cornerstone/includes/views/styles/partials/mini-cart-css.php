<?php

// =============================================================================
// _MINI-CART-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Title
//   03. Items
//   04. Thumbnails
//   05. Links
//   06. Quantity
//   07. Total
//   08. Buttons
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Title
// -----

$data_title_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'cart_title_text_color',
);

$data_title_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'cart_title_text_shadow_dimensions',
  'base'       => $key_prefix . 'cart_title_text_shadow_color',
);


// Items
// -----

$data_items_border = array(
  'width'  => $key_prefix . 'cart_items_border_width',
  'style'  => $key_prefix . 'cart_items_border_style',
  'base'   => $key_prefix . 'cart_items_border_color',
  'alt'    => $key_prefix . 'cart_items_border_color_alt',
  'radius' => $key_prefix . 'cart_items_border_radius',
);

$data_items_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'cart_items_bg',
  'alt'  => $key_prefix . 'cart_items_bg_alt',
);

$data_items_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'cart_items_box_shadow_dimensions',
  'base'       => $key_prefix . 'cart_items_box_shadow_color',
  'alt'        => $key_prefix . 'cart_items_box_shadow_color_alt',
);


// Thumbnails
// ----------

$data_thumbs_border = array(
  'radius' => $key_prefix . 'cart_thumbs_border_radius',
);

$data_thumbs_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'cart_thumbs_box_shadow_dimensions',
  'base'       => $key_prefix . 'cart_thumbs_box_shadow_color',
);


// Links
// -----

$data_links_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'cart_links_text_color',
  'alt'  => $key_prefix . 'cart_links_text_color_alt',
);

$data_links_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'cart_links_text_shadow_dimensions',
  'base'       => $key_prefix . 'cart_links_text_shadow_color',
  'alt'        => $key_prefix . 'cart_links_text_shadow_color_alt',
);


// Quantity
// --------

$data_quantity_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'cart_quantity_text_color',
);

$data_quantity_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'cart_quantity_text_shadow_dimensions',
  'base'       => $key_prefix . 'cart_quantity_text_shadow_color',
);


// Total
// -----

$data_total_border = array(
  'width'  => $key_prefix . 'cart_total_border_width',
  'style'  => $key_prefix . 'cart_total_border_style',
  'base'   => $key_prefix . 'cart_total_border_color',
  'radius' => $key_prefix . 'cart_total_border_radius',
);

$data_total_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'cart_total_text_color',
);

$data_total_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'cart_total_bg',
);

$data_total_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'cart_total_box_shadow_dimensions',
  'base'       => $key_prefix . 'cart_total_box_shadow_color',
);

$data_total_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'cart_total_text_shadow_dimensions',
  'base'       => $key_prefix . 'cart_total_text_shadow_color',
);


// Buttons
// -------

$data_buttons_border = array(
  'width'  => $key_prefix . 'cart_buttons_border_width',
  'style'  => $key_prefix . 'cart_buttons_border_style',
  'base'   => $key_prefix . 'cart_buttons_border_color',
  'radius' => $key_prefix . 'cart_buttons_border_radius',
);

$data_buttons_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'cart_buttons_bg',
);

$data_buttons_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'cart_buttons_box_shadow_dimensions',
  'base'       => $key_prefix . 'cart_buttons_box_shadow_color',
);



// Title
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>cart_title != '' {

  .$_el<?php echo $selector; ?> .x-mini-cart-title {
    margin: $<?php echo $key_prefix; ?>cart_title_margin;
    font-family: $<?php echo $key_prefix; ?>cart_title_font_family;
    font-size: $<?php echo $key_prefix; ?>cart_title_font_size;
    font-style: $<?php echo $key_prefix; ?>cart_title_font_style;
    font-weight: $<?php echo $key_prefix; ?>cart_title_font_weight;
    line-height: $<?php echo $key_prefix; ?>cart_title_line_height;
    @unless $<?php echo $key_prefix; ?>cart_title_letter_spacing?? {
      letter-spacing: $<?php echo $key_prefix; ?>cart_title_letter_spacing;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_align?? {
      text-align: $<?php echo $key_prefix; ?>cart_title_text_align;
    }
    @unless $<?php echo $key_prefix; ?>cart_title_text_decoration?? {
      text-decoration: $<?php echo $key_prefix; ?>cart_title_text_decoration;
    }
    <?php echo cs_get_partial_style( '_shadow-base', $data_title_text_shadow ); ?>
    @unless $<?php echo $key_prefix; ?>cart_title_text_transform?? {
      text-transform: $<?php echo $key_prefix; ?>cart_title_text_transform;
    }
    <?php echo cs_get_partial_style( '_color-base', $data_title_color ); ?>
  }

}

.$_el<?php echo $selector; ?> .x-mini-cart li.empty {
  line-height: $<?php echo $key_prefix; ?>cart_links_line_height;
  @unless $<?php echo $key_prefix; ?>cart_title_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_title_text_align;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_links_color ); ?>
}



<?php

// Items
// =============================================================================

?>

.$_el<?php echo $selector; ?> .cart_list {
  order: $<?php echo $key_prefix; ?>cart_order_items;
}

.$_el<?php echo $selector; ?> .mini_cart_item {
  @unless $<?php echo $key_prefix; ?>cart_items_margin?? {
    margin: $<?php echo $key_prefix; ?>cart_items_margin;
  }
  <?php echo cs_get_partial_style( '_border-base', $data_items_border ); ?>
  @unless $<?php echo $key_prefix; ?>cart_items_padding?? {
    padding: $<?php echo $key_prefix; ?>cart_items_padding;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_items_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_items_box_shadow );
  ?>
}

.$_el<?php echo $selector; ?> .mini_cart_item:hover {
  <?php
  echo cs_get_partial_style( '_border-alt', $data_items_border );
  echo cs_get_partial_style( '_color-alt', $data_items_background_color );
  echo cs_get_partial_style( '_shadow-alt', $data_items_box_shadow );
  ?>
}

@if $<?php echo $key_prefix; ?>cart_items_display_remove == false {
  .$_el<?php echo $selector; ?> .mini_cart_item .remove {
    display: none !important;
    visibility: hidden !important;
  }
}



<?php

// Thumbnails
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item img {
  width: $<?php echo $key_prefix; ?>cart_thumbs_width;
  margin-right: $<?php echo $key_prefix; ?>cart_items_content_spacing;
  <?php echo cs_get_partial_style( '_border-base', $data_thumbs_border ); ?>
  <?php echo cs_get_partial_style( '_shadow-base', $data_thumbs_box_shadow ); ?>
}

.rtl .$_el<?php echo $selector; ?> .mini_cart_item img {
  margin-left: $<?php echo $key_prefix; ?>cart_items_content_spacing;
  margin-right: 0;
}



<?php

// Links
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item a {
  font-family: $<?php echo $key_prefix; ?>cart_links_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_links_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_links_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_links_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_links_line_height;
  @unless $<?php echo $key_prefix; ?>cart_links_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_links_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_links_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_links_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_links_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_links_text_shadow ); ?>
  @unless $<?php echo $key_prefix; ?>cart_links_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_links_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_links_color ); ?>
}

.$_el<?php echo $selector; ?> .mini_cart_item a:hover,
.$_el<?php echo $selector; ?> .mini_cart_item a:focus {
  <?php
  echo cs_get_partial_style( '_color-alt', $data_links_color );
  echo cs_get_partial_style( '_shadow-alt', $data_links_text_shadow );
  ?>
}

.$_el<?php echo $selector; ?> .mini_cart_item .remove {
  width: calc(1em * $<?php echo $key_prefix; ?>cart_links_line_height);
  margin-left: $<?php echo $key_prefix; ?>cart_items_content_spacing;
}

.rtl .$_el<?php echo $selector; ?> .mini_cart_item .remove {
  margin-left: 0;
  margin-right: $<?php echo $key_prefix; ?>cart_items_content_spacing;
}



<?php

// Quantity
// =============================================================================

?>

.$_el<?php echo $selector; ?> .mini_cart_item .quantity {
  font-family: $<?php echo $key_prefix; ?>cart_quantity_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_quantity_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_quantity_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_quantity_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_quantity_line_height;
  @unless $<?php echo $key_prefix; ?>cart_quantity_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_quantity_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_quantity_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_quantity_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_quantity_text_shadow ); ?>
  @unless $<?php echo $key_prefix; ?>cart_quantity_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_quantity_text_transform;
  }
  <?php echo cs_get_partial_style( '_color-base', $data_quantity_color ); ?>
}



<?php

// Total
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mini-cart .total {
  order: $<?php echo $key_prefix; ?>cart_order_total;
  margin: $<?php echo $key_prefix; ?>cart_total_margin;
  <?php echo cs_get_partial_style( '_border-base', $data_total_border ); ?>
  padding: $<?php echo $key_prefix; ?>cart_total_padding;
  font-family: $<?php echo $key_prefix; ?>cart_total_font_family;
  font-size: $<?php echo $key_prefix; ?>cart_total_font_size;
  font-style: $<?php echo $key_prefix; ?>cart_total_font_style;
  font-weight: $<?php echo $key_prefix; ?>cart_total_font_weight;
  line-height: $<?php echo $key_prefix; ?>cart_total_line_height;
  @unless $<?php echo $key_prefix; ?>cart_total_letter_spacing?? {
    letter-spacing: $<?php echo $key_prefix; ?>cart_total_letter_spacing;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_align?? {
    text-align: $<?php echo $key_prefix; ?>cart_total_text_align;
  }
  @unless $<?php echo $key_prefix; ?>cart_total_text_decoration?? {
    text-decoration: $<?php echo $key_prefix; ?>cart_total_text_decoration;
  }
  <?php echo cs_get_partial_style( '_shadow-base', $data_total_text_shadow ); ?>
  @unless $<?php echo $key_prefix; ?>cart_total_text_transform?? {
    text-transform: $<?php echo $key_prefix; ?>cart_total_text_transform;
  }
  <?php
  echo cs_get_partial_style( '_color-base', $data_total_color );
  echo cs_get_partial_style( '_color-base', $data_total_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_total_box_shadow );
  ?>
}



<?php

// Buttons
// =============================================================================

?>

.$_el<?php echo $selector; ?> .x-mini-cart .buttons {
  order: $<?php echo $key_prefix; ?>cart_order_buttons;
  justify-content: $<?php echo $key_prefix; ?>cart_buttons_justify_content;
  margin: $<?php echo $key_prefix; ?>cart_buttons_margin;
  <?php echo cs_get_partial_style( '_border-base', $data_buttons_border ); ?>
  padding: $<?php echo $key_prefix; ?>cart_buttons_padding;
  <?php
  echo cs_get_partial_style( '_color-base', $data_buttons_background_color );
  echo cs_get_partial_style( '_shadow-base', $data_buttons_box_shadow );
  ?>
}

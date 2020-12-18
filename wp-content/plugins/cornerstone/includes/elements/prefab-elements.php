<?php

// =============================================================================
// PREFAB-ELEMENTS.PHP
// -----------------------------------------------------------------------------
// It's a bunch of prefab elements, yo.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Register Groups
//   02. Dynamic Elements: Global
//   03. Dynamic Elements: Archive
//   04. Dynamic Elements: Post
//   05. Dynamic Elements: WooCommerce
//   06. Recent Posts Elements
// =============================================================================

// Register Groups
// =============================================================================
// Available Scopes:
//   - all
//   - content (Content / Global Blocks)
//   - bars (Headers / Footers)
//   - layout-single
//   - layout-archive
//   - layout-single-wc
//   - layout-archive-wc

cs_register_element_group( 'dynamic', __( 'Dynamic', 'cornerstone' ) );

if ( class_exists( 'WC_API' ) ) {
  cs_register_element_group( 'woocommerce', __( 'WooCommerce', 'cornerstone' ) );
}

if ( class_exists( 'BuddyPress' ) ) {
  cs_register_element_group( 'buddypress', __( 'BuddyPress', 'cornerstone' ) );
}

if ( class_exists( 'bbPress' ) ) {
  cs_register_element_group( 'bbpress', __( 'bbPress', 'cornerstone' ) );
}





// Dynamic Elements: Global
// =============================================================================

cs_register_prefab_element( 'dynamic', 'site-title' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Site Title', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:global:site_title}}',
  )
));

cs_register_prefab_element( 'dynamic', 'site-tagline' , array(
  'type'   => 'text',
  'scope'  => ['all'],
  'title'  => __( 'Site Tagline', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:global:site_tagline}}',
  )
));

cs_register_prefab_element( 'dynamic', 'site-home-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Site Home Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => 'Home',
    'anchor_href'                 => '{{dc:global:home_url}}',
  )
));

cs_register_prefab_element( 'dynamic', 'site-admin-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Site Admin Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => 'Admin',
    'anchor_href'                 => '{{dc:global:admin_url}}',
  )
));



// Dynamic Elements: Archive
// =============================================================================

cs_register_prefab_element( 'dynamic', 'archive-title' , array(
  'type'   => 'headline',
  'scope'  => ['layout-archive', 'bars'],
  'title'  => __( 'Archive Title', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:archive:title}}',
  )
));


// Description
// -----------

cs_register_prefab_element( 'dynamic', 'archive-description' , array(
  'type'   => 'text',
  'scope'  => ['layout-archive', 'bars'],
  'title'  => __( 'Archive Description', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:archive:description}}',
  )
));


// Link
// ----

cs_register_prefab_element( 'dynamic', 'archive-link' , array(
  'type'   => 'button',
  'scope'  => ['layout-archive', 'bars'],
  'title'  => __( 'Archive Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => '{{dc:archive:title}}',
    'anchor_href'                 => '{{dc:archive:url}}',
  )
));



// Dynamic Elements: Post
// =============================================================================

cs_register_prefab_element( 'dynamic', 'the-title' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'The Title', 'cornerstone' ),
  'values' => array(
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:post:title}}',
  )
));

cs_register_prefab_element( 'dynamic', 'the-content' , array(
  'type'   => 'the-content',
  'scope'  => ['layout-single'],
  'title'  => __( 'The Content', 'cornerstone' ),
  'values' => []
));

cs_register_prefab_element( 'dynamic', 'the-excerpt' , array(
  'type'   => 'text',
  'scope'  => ['all'],
  'title'  => __( 'The Excerpt', 'cornerstone' ),
  'values' => array(
    'text_content' => sprintf('{{dc:post:excerpt fallback="%s"}}', __('No excerpt', 'cornerstone')),
  )
));


cs_register_prefab_element( 'dynamic', 'featured-image' , array(
  'type'   => 'image',
  'scope'  => ['all'],
  'title'  => __( 'Featured Image', 'cornerstone' ),
  'values' => array(
    'image_src' => '{{dc:post:featured_image_id}}',
  )
));

// cs_register_prefab_element( 'dynamic', 'faux-comment-area' , array(
//   'type'   => 'div',
//   'scope'  => ['all'],
//   'title'  => __( 'Faux Comment Area', 'cornerstone' ),
//   'values' => array(
//     'div_bg_color' => 'red',
//     '_modules'     => array(
//       array(
//         '_type'              => 'comment-nav',
//         'comment_nav_margin' => '0 0 2em 0',
//       ),
//       array(
//         '_type' => 'comment-list',
//       ),
//       array(
//         '_type'              => 'comment-nav',
//         'comment_nav_margin' => '2em 0 0 0',
//       ),
//       array(
//         '_type' => 'comment-form',
//       ),
//     ),
//   )
// ));



// Dynamic Elements: WooCommerce
// =============================================================================

// Add to Cart
// -----------

if ( class_exists( 'WC_API' ) ) :

cs_register_prefab_element( 'woocommerce', 'add-to-cart-button' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Add to Cart Button', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => 'Add to Cart',
    'anchor_href'                 => '?add-to-cart={{dc:woocommerce:product_id}}',
    'class'                       => 'add_to_cart_button ajax_add_to_cart',
    'custom_atts'                 => '{"data-quantity":"1","data-product_id":"{{dc:woocommerce:product_id}}","data-product_sku":"{{dc:woocommerce:product_sku}}","aria-label":"Add “{{dc:woocommerce:product_title}}” to your cart","rel":"nofollow"}'
  )
));

// cs_register_prefab_element( 'woocommerce', 'add-to-cart-with-quantity' , array(
//   'type'   => 'button',
//   'scope'  => ['all'],
//   'title'  => __( 'Add to Cart Button', 'cornerstone' ),
//   'values' => array(

//   )
// ));


// Products
// --------

cs_register_prefab_element( 'woocommerce', 'shop-title' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Shop Title', 'cornerstone' ),
  'values' => array(
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:woocommerce:page_title}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-title' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Product Title', 'cornerstone' ),
  'values' => array(
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:woocommerce:product_title}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-long-description' , array(
  'type'   => 'the-content',
  'scope'  => ['all'],
  'title'  => __( 'Product Long Description', 'cornerstone' ),
  'values' => []
));

cs_register_prefab_element( 'woocommerce', 'product-short-description' , array(
  'type'   => 'text',
  'scope'  => ['all'],
  'title'  => __( 'Product Short Description', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:woocommerce:product_short_description}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-additional-information' , array(
  'type'   => 'content-area',
  'scope'  => ['all'],
  'title'  => __( 'Product Additional Information', 'cornerstone' ),
  'values' => array(
    'content' => '{{dc:woocommerce:product_additional_information}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-reviews' , array(
  'type'   => 'content-area',
  'scope'  => ['all'],
  'title'  => __( 'Product Reviews', 'cornerstone' ),
  'values' => array(
    'content' => '{{dc:woocommerce:product_reviews}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-image' , array(
  'type'   => 'image',
  'scope'  => ['all'],
  'title'  => __( 'Product Image', 'cornerstone' ),
  'values' => array(
    'image_src' => '{{dc:woocommerce:product_image_id}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'product-price' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Product Price', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:woocommerce:product_price}}',
  )
));


cs_register_prefab_element( 'woocommerce', 'product-rating' , array(
  'type'   => 'rating',
  'scope'  => ['all'],
  'title'  => __( 'Product Rating', 'cornerstone' ),
  'values' => array(
    'rating_value_content' => '{{dc:woocommerce:product_average_rating}}',
  )
));


// Cart
// ----

cs_register_prefab_element( 'woocommerce', 'cart-total' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Cart Total', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:woocommerce:cart_total}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'cart-items' , array(
  'type'   => 'headline',
  'scope'  => ['all'],
  'title'  => __( 'Cart Items', 'cornerstone' ),
  'values' => array(
    'text_content' => '{{dc:woocommerce:cart_items}}',
  )
));


// Links
// -----

cs_register_prefab_element( 'woocommerce', 'shop-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Shop Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => __( 'Shop', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:shop_url}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'cart-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Cart Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => __( 'Cart', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:cart_url}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'checkout-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Checkout Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => __( 'Checkout', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:checkout_url}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'account-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Account Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => __( 'Account', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:account_url}}',
  )
));

cs_register_prefab_element( 'woocommerce', 'terms-link' , array(
  'type'   => 'button',
  'scope'  => ['all'],
  'title'  => __( 'Terms Link', 'cornerstone' ),
  'values' => array(
    'anchor_text_primary_content' => __( 'Terms', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:terms_url}}',
  )
));


// Tabs
// ----

cs_register_prefab_element( 'woocommerce', 'product-tabs' , array(
  'type'   => 'tabs',
  'scope'  => ['all'],
  'title'  => __( 'Product Tabs', 'cornerstone' ),
  'values' => array(
    '_modules' => array(
      array(
        '_type'             => 'tab',
        'tab_label_content' => __( 'Description', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_description fallback="No Description"}}',
      ),
      array(
        '_type'             => 'tab',
        'tab_label_content' => __( 'Additional Information', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_additional_information fallback="No Additional Information"}}',
      ),
      array(
        '_type'             => 'tab',
        'tab_label_content' => __( 'Reviews ({{dc:woocommerce:product_review_count}})', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_reviews fallback="No Reviews"}}',
      ),
    ),
  )
));

endif;



// Recent Posts Elements
// =============================================================================

// Tiles
// -----

cs_register_prefab_element( 'dynamic', 'posts-tiles' , array(
  'type'   => 'layout-row',
  'scope'  => ['all'],
  'title'  => __( 'Posts (Tiles)', 'cornerstone' ),
  'values' => array(
    'layout_row_layout_xl'        => '28em',
    'layout_row_layout_lg'        => '28em',
    'layout_row_layout_md'        => '28em',
    'layout_row_layout_sm'        => '28em',
    'layout_row_layout_xs'        => '28em',
    'layout_row_base_font_size'   => '1rem',
    'layout_row_flex_justify'     => 'center',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'layout_row_grow'             => true,
    'looper_provider'             => true,
    'looper_provider_query_count' => '3',
    '_type'                       => 'layout-row',
    '_label'                      => 'Posts',
    '_modules'                    => array(
      array(
        'layout_column_tag'                                 => 'a',
        'layout_column_height'                              => '44vh',
        'layout_column_min_height'                          => '320px',
        'layout_column_max_height'                          => '400px',
        'layout_column_overflow'                            => 'hidden',
        'layout_column_z_index'                             => '1',
        'layout_column_bg_color'                            => '#000000',
        'layout_column_href'                                => '{{dc:post:permalink}}',
        'layout_column_padding'                             => '!0em',
        'layout_column_border_radius'                       => '2px',
        'layout_column_box_shadow_dimensions'               => '0em 0.65em 1.5em 0em',
        'layout_column_box_shadow_color'                    => 'rgba(0, 0, 0, 0.22)',
        'layout_column_primary_particle'                    => true,
        'layout_column_primary_particle_location'           => 't_r',
        'layout_column_primary_particle_scale'              => 'scale-x',
        'layout_column_primary_particle_transform_origin'   => '100% 0%',
        'layout_column_primary_particle_width'              => '16px',
        'layout_column_primary_particle_color'              => '#ffba00',
        'layout_column_secondary_particle'                  => true,
        'layout_column_secondary_particle_location'         => 't_r',
        'layout_column_secondary_particle_delay'            => '150ms',
        'layout_column_secondary_particle_transform_origin' => '100% 0%',
        'layout_column_secondary_particle_width'            => '3px',
        'layout_column_secondary_particle_height'           => '16px',
        'layout_column_secondary_particle_color'            => '#ffba00',
        'effects_provider'                                  => true,
        'looper_consumer'                                   => true,
        '_type'                                             => 'layout-column',
        '_label'                                            => 'Post',
        '_modules'                                          => array(
          array(
            'layout_div_tag'          => 'article',
            'layout_div_bg_color'     => 'rgba(0, 0, 0, 0.66)',
            'layout_div_bg_color_alt' => 'rgba(0, 0, 0, 0.33)',
            'layout_div_width'        => '100%',
            'layout_div_height'       => '100%',
            'layout_div_position'     => 'static',
            'layout_div_flexbox'      => true,
            'layout_div_padding'      => '2.441em',
            'effects_duration'        => '650ms',
            '_type'                   => 'layout-div',
            '_label'                  => 'Article',
            '_modules'                => array(
              array(
                'text_font_size'      => '0.8em',
                'text_line_height'    => '1',
                'text_letter_spacing' => '0.15em',
                'text_text_transform' => 'uppercase',
                'text_text_color'     => 'rgba(255, 255, 255, 0.55)',
                'text_text_color_alt' => '#ffffff',
                'text_content'        => '{{dc:post:publish_date format=\'M / Y\'}}',
                'effects_duration'    => '650ms',
                '_type'               => 'text',
                '_label'              => 'Published'
              ),
              array(
                'text_max_width'      => '21em',
                'text_margin'         => 'auto 0em 0em 0em',
                'text_line_height'    => '1.25',
                'text_text_color'     => '#ffffff',
                'text_content'        => '{{dc:post:title}}',
                'text_base_font_size' => '1.563em',
                'text_tag'            => 'h2',
                'text_flex_direction' => 'column',
                'text_flex_justify'   => 'flex-start',
                'text_flex_align'     => 'flex-start',
                '_type'               => 'headline',
                '_label'              => 'The Title'
              ),
              array(
                'layout_div_tag'        => 'figure',
                'layout_div_z_index'    => '-1',
                'layout_div_position'   => 'absolute',
                'layout_div_top'        => '0px',
                'layout_div_left'       => '0px',
                'layout_div_right'      => '0px',
                'layout_div_bottom'     => '0px',
                'effects_transform'     => 'translate3d(0, 0, 0)',
                'effects_duration'      => '650ms',
                'effects_alt'           => true,
                'effects_transform_alt' => 'translate3d(0, 0, 0) scale(1.05)',
                'show_condition'        => array(
                  array(
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => ''
                  ),
                ),
                '_type'    => 'layout-div',
                '_label'   => 'Figure',
                '_modules' => array(
                  array(
                    'image_display'       => 'block',
                    'image_styled_width'  => '100%',
                    'image_styled_height' => '100%',
                    'image_src'           => '{{dc:post:featured_image_id}}',
                    'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                    'image_object_fit'    => 'cover',
                    '_type'               => 'image',
                    '_label'              => 'Featured Image',
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  )
));


// Minimal
// -------

cs_register_prefab_element( 'dynamic', 'posts-minimal' , array(
  'type'   => 'layout-row',
  'scope'  => ['all'],
  'title'  => __( 'Posts (Minimal)', 'cornerstone' ),
  'values' => array(
    'layout_row_layout_xl'        => '22em',
    'layout_row_layout_lg'        => '22em',
    'layout_row_layout_md'        => '22em',
    'layout_row_layout_sm'        => '22em',
    'layout_row_layout_xs'        => '22em',
    'layout_row_base_font_size'   => '1rem',
    'layout_row_flex_justify'     => 'center',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'looper_provider'             => true,
    'looper_provider_query_count' => '6',
    '_type'                       => 'layout-row',
    '_label'                      => 'Posts',
    '_modules'                    => array(
      array(
        'layout_column_tag'                   => 'a',
        'layout_column_overflow'              => 'hidden',
        'layout_column_href'                  => '{{dc:post:permalink}}',
        'layout_column_flexbox'               => true,
        'layout_column_flex_align'            => 'stretch',
        'layout_column_padding'               => '1em',
        'layout_column_border_radius'         => '6px',
        'layout_column_box_shadow_dimensions' => '0em 0.65em 1.35em 0em',
        'layout_column_box_shadow_color_alt'  => 'rgba(0, 0, 0, 0.16)',
        'effects_duration'                    => '400ms',
        'effects_timing_function'             => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
        'effects_provider'                    => true,
        'effects_alt'                         => true,
        'effects_transform_alt'               => 'translate(0em, -0.5em)',
        'looper_consumer'                     => true,
        '_type'                               => 'layout-column',
        '_label'                              => 'Post',
        '_modules'                            => array(
          array(
            'layout_div_tag'           => 'figure',
            'layout_div_bg_color'      => '#d5d5d5',
            'layout_div_height'        => '44vh',
            'layout_div_min_height'    => '210px',
            'layout_div_max_height'    => '240px',
            'layout_div_flex'          => '0 0 auto',
            'layout_div_overflow_x'    => 'hidden',
            'layout_div_overflow_y'    => 'hidden',
            'layout_div_margin'        => '0em 0em 1em 0em',
            'layout_div_border_radius' => '3px',
            'show_condition'           => array(
              array(
                'group'     => true,
                'condition' => 'current-post:featured-image',
                'value'     => '',
                'toggle'    => true
              ),
            ),
            '_type'    => 'layout-div',
            '_label'   => 'Figure',
            '_modules' => array(
              array(
                'image_display'             => 'block',
                'image_styled_width'        => '100%',
                'image_styled_height'       => '100%',
                'image_margin'              => '!0em',
                'image_outer_border_radius' => '!0px',
                'image_inner_border_radius' => '!0px',
                'image_src'                 => '{{dc:post:featured_image_id}}',
                'image_alt'                 => 'Featured image for “{{dc:post:title}}”',
                'image_object_fit'          => 'cover',
                '_type'                     => 'image',
                '_label'                    => 'Featured Image'
              ),
            ),
          ),
          array(
            'layout_div_tag'     => 'article',
            'layout_div_flex'    => '1 1 auto',
            'layout_div_flexbox' => true,
            'layout_div_padding' => '0em',
            '_type'              => 'layout-div',
            '_label'             => 'Article',
            '_modules'           => array(
              array(
                'text_max_width'          => '21em',
                'text_margin'             => '0em 0em 0.512em 0em',
                'text_font_weight'        => 'inherit:700',
                'text_line_height'        => '1.5',
                'text_text_color_alt'     => '#f45c00',
                'text_content'            => '{{dc:post:title}}',
                'text_tag'                => 'h2',
                'effects_duration'        => '400ms',
                'effects_timing_function' => 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
                '_type'                   => 'headline',
                '_label'                  => 'The Title'
              ),
              array(
                'text_margin'      => '0em 0em auto 0em',
                'text_line_height' => '1.6',
                'text_text_color'  => 'rgba(0, 0, 0, 0.55)',
                'text_content'     => '{{dc:post:excerpt length=\'20\' fallback=\'No excerpt\'}}&hellip;',
                '_type'            => 'text',
                '_label'           => 'The Excerpt'
              ),
              array(
                'text_margin'                  => '1.563em 0em 0em 0em',
                'text_font_weight'             => 'inherit:700',
                'text_font_size'               => '0.64em',
                'text_line_height'             => '1',
                'text_letter_spacing'          => '0.065em',
                'text_text_transform'          => 'uppercase',
                'text_text_color'              => '#000000',
                'text_content'                 => '{{dc:author:display_name}}',
                'text_overflow'                => true,
                'text_graphic'                 => true,
                'text_graphic_margin'          => '0em 0.409em 0em 0em',
                'text_graphic_icon'            => 'o-user-circle',
                'text_graphic_icon_font_size'  => '1em',
                'text_graphic_icon_width'      => '1em',
                'text_graphic_icon_height'     => '1em',
                'text_graphic_icon_color'      => '#000000',
                'text_graphic_icon_alt_enable' => true,
                'text_graphic_icon_alt'        => 'user-circle',
                'text_graphic_interaction'     => 'x-anchor-flip-y',
                'effects_duration'             => '400ms',
                'effects_timing_function'      => 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
                '_type'                        => 'headline',
                '_label'                       => 'The Author'
              ),
            ),
          ),
        ),
      ),
    ),
  )
));


// List
// ----

cs_register_prefab_element( 'dynamic', 'posts-list' , array(
  'type'   => 'layout-row',
  'scope'  => ['all'],
  'title'  => __( 'Posts (List)', 'cornerstone' ),
  'values' => array(
    'layout_row_layout_xl'        => '100%',
    'layout_row_layout_lg'        => '100%',
    'layout_row_layout_md'        => '100%',
    'layout_row_base_font_size'   => '1rem',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'looper_provider'             => true,
    'looper_provider_query_count' => '5',
    '_type'                       => 'layout-row',
    '_label'                      => 'Posts',
    '_modules'                    => array(
      array(
        'layout_column_tag'            => 'a',
        'layout_column_href'           => '{{dc:post:permalink}}',
        'layout_column_flexbox'        => true,
        'layout_column_flex_direction' => 'row',
        'layout_column_flex_wrap'      => false,
        'layout_column_flex_align'     => 'center',
        'effects_provider'             => true,
        'looper_consumer'              => true,
        '_type'                        => 'layout-column',
        '_label'                       => 'Post',
        '_modules'                     => array(
          array(
            'layout_div_tag'                   => 'figure',
            'layout_div_bg_color'              => '#4c3be9',
            'layout_div_width'                 => '4em',
            'layout_div_height'                => '4em',
            'layout_div_flex'                  => '0 0 auto',
            'layout_div_overflow_x'            => 'hidden',
            'layout_div_overflow_y'            => 'hidden',
            'layout_div_flexbox'               => true,
            'layout_div_flex_justify'          => 'center',
            'layout_div_flex_align'            => 'center',
            'layout_div_margin'                => '0em 1em 0em 0em',
            'layout_div_border_radius'         => '4px',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.65em 0em',
            'layout_div_box_shadow_color'      => 'rgba(0, 0, 0, 0.11)',
            '_type'                            => 'layout-div',
            '_label'                           => 'Figure',
            '_modules'                         => array(
              array(
                'image_display'       => 'block',
                'image_styled_width'  => '100%',
                'image_styled_height' => '100%',
                'image_src'           => '{{dc:post:featured_image_id}}',
                'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                'image_object_fit'    => 'cover',
                'show_condition'      => array(
                  array(
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => ''
                  ),
                ),
                '_type'  => 'image',
                '_label' => 'Featured Image',
              ),
              array(
                'icon'           => 'o-arrow-right',
                'icon_width'     => '1em',
                'icon_height'    => '1em',
                'icon_color'     => '#ffffff',
                'show_condition' => array(
                  array(
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => '',
                    'toggle'    => false
                  ),
                ),
                '_type' => 'icon'
              ),
            ),
          ),
          array(
            'layout_div_tag'       => 'article',
            'layout_div_min_width' => '1px',
            'layout_div_flex'      => '1 1 12em',
            '_type'                => 'layout-div',
            '_label'               => 'Article',
            '_modules'             => array(
              array(
                'text_font_weight'                => 'inherit:700',
                'text_text_color'                 => '#000000',
                'text_text_color_alt'             => '#4c3be9',
                'text_content'                    => '{{dc:post:title}}',
                'text_tag'                        => 'h2',
                'text_subheadline'                => true,
                'text_subheadline_content'        => '{{dc:post:publish_date format=\'M. d, Y\'}}',
                'text_subheadline_spacing'        => '0.512em',
                'text_subheadline_reverse'        => true,
                'text_subheadline_font_weight'    => 'inherit:700',
                'text_subheadline_font_size'      => '0.64em',
                'text_subheadline_line_height'    => '1.6',
                'text_subheadline_letter_spacing' => '0.125em',
                'text_subheadline_text_transform' => 'uppercase',
                'text_subheadline_text_color'     => 'rgba(0, 0, 0, 0.55)',
                'effects_duration'                => '0ms',
                '_type'                           => 'headline',
                '_label'                          => 'The Title'
              ),
            ),
          ),
        ),
      ),
    ),
  )
));

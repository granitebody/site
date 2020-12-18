<?php

class Cornerstone_WooCommerce extends Cornerstone_Plugin_Component {

  public function setup() {

    if( !class_exists( 'WC_API' ) ){
        return;
    }

    add_filter( 'cs_app_data', [ $this, 'app_data' ], 10, 2 );

    add_filter( 'cs_layout_default_preview_url', [ $this, 'set_default_preview_url' ], 10, 2 );
    add_filter( 'cs_looper_main_query', [ $this, 'setup_main_looper_query' ] );

    add_filter( 'cs_layout_output_before_single', [ $this, 'before_product'] );
    add_filter( 'cs_layout_output_after_single',  [ $this, 'after_product'] );

    add_filter( 'cs_assignment_context_post_types', [$this, 'unset_preview_post_type' ] );
    add_filter( 'cs_preview_context_post_types', [$this, 'unset_preview_post_type' ] );

    add_filter( 'cs_assignment_contexts', [$this, 'assignment_contexts'] );
    add_filter( 'cs_preview_contexts', [$this, 'preview_contexts'] );
    add_filter( 'cs_condition_contexts', [$this, 'condition_contexts'] );

    add_filter( 'cs_condition_rule_single_product', [ $this, 'condition_rule_single_product' ] );
    add_filter( 'cs_condition_rule_archive_shop', [ $this, 'condition_rule_archive_shop' ] );
    add_filter( 'cs_condition_rule_wc_product_has', [ $this, 'condition_rule_wc_product_has' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_product_is', [ $this, 'condition_rule_wc_product_is' ], 10, 2 );

    add_filter( 'cs_detect_layout_type', [ $this, 'detect_layout_type'] );
  }

  public function setup_main_looper_query( $provider ) {
    if (is_shop() || is_product_tag() || is_product_category() ) {
      return new Cornerstone_Looper_Provider_Shop();
    }

    return $provider;
  }

  public function app_data( $data, $is_preview ) {

    if ( ! $is_preview ) {
      $data['woocommerce'] = true;
    }

    return $data;

  }

  public function set_default_preview_url( $url, $settings ) {
    if ($settings['layout_type'] === 'single-wc') {
      $posts = get_posts( ['numberposts' => 1, 'post_type' => 'product' ] );
      if (!empty($posts[0])) {
        return get_permalink( $posts[0]->ID );
      }
    }

    if ($settings['layout_type'] === 'archive-wc') {
      return get_permalink( wc_get_page_id( 'shop' ) );
    }

    return $url;
  }

  public function before_product( $content ) {
    if ( is_singular( 'product' )) {
      global $product;
      ob_start();
      ?><div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>><?php
      return ob_get_clean();
    }

    return $content;
  }

  public function after_product( $content ) {

    if ( is_singular( 'product' )) {
      return '</div>';
    }

    return $content;
  }

  public function unset_preview_post_type( $post_types ) {
    unset($post_types['product']);
    return $post_types;
  }

  public function assignment_contexts( $contexts ) {

    $contexts['labels']['single-wc' ] = __( 'WooCommerce Single', 'cornerstone' );
    $contexts['labels']['archive-wc'] = __( 'WooCommerce Archive', 'cornerstone' );

    $contexts['controls']['single-wc' ] = $this->assignment_context_single();
    $contexts['controls']['archive-wc'] = $this->assignment_context_archive();

    return $contexts;
  }

  public function preview_contexts( $contexts ) {

    $contexts['labels']['single-wc' ] = __( 'WooCommerce Single', 'cornerstone' );
    $contexts['labels']['archive-wc'] = __( 'WooCommerce Archive', 'cornerstone' );

    $contexts['controls']['single-wc' ] = $this->preview_context_single();
    $contexts['controls']['archive-wc'] = $this->preview_context_archive();

    return $contexts;
  }

  public function condition_contexts( $contexts ) {

    $contexts['labels']['wc' ] = __( 'WooCommerce', 'cornerstone' );
    $contexts['labels']['archive-wc'] = __( 'WooCommerce Archive', 'cornerstone' );

    $contexts['controls']['wc'] = $this->condition_contexts_wc();

    return $contexts;
  }

  public function condition_contexts_wc() {

    return [
      [
        'key'   => 'wc:product-is',
        'label' => __('Product (is)', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            [ 'value' => 'is-downloadable', 'label' => __('Downloadable', 'cornerstone') ],
            [ 'value' => 'is-featured', 'label' => __('Featured', 'cornerstone') ],
            [ 'value' => 'is-in-stock', 'label' => __('In Stock', 'cornerstone') ],
            [ 'value' => 'is-on-backorder', 'label' => __('On Backorder', 'cornerstone') ],
            [ 'value' => 'is-on-sale', 'label' => __('On Sale', 'cornerstone') ],
            [ 'value' => 'is-purchasable', 'label' => __('Purchasable', 'cornerstone') ],
            [ 'value' => 'is-shipping-taxable', 'label' => __('Shipping Taxable', 'cornerstone') ],
            [ 'value' => 'is-sold-individually', 'label' => __('Sold Individually', 'cornerstone') ],
            [ 'value' => 'is-taxable', 'label' => __('Taxable', 'cornerstone') ],
            [ 'value' => 'is-virtual', 'label' => __('Virtual', 'cornerstone') ],
            [ 'value' => 'is-visible', 'label' => __('Visible', 'cornerstone') ],
          ]
        ]
      ], [
        'key'   => 'wc:product-has',
        'label' => __('Product (has)', 'cornerstone'),
        'toggle' => [
          'type' => 'boolean',
          'labels' => [
            __('has', 'cornerstone'),
            __('has not', 'cornerstone'),
          ]
        ],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            [ 'value' => 'has-image', 'label' => __('Image', 'cornerstone') ],
            [ 'value' => 'has-gallery', 'label' => __('Gallery', 'cornerstone') ],
            [ 'value' => 'has-reviews', 'label' => __('Reviews', 'cornerstone') ],
            [ 'value' => 'has-attributes', 'label' => __('Attributes', 'cornerstone') ],
            [ 'value' => 'has-child', 'label' => __('Child', 'cornerstone') ],
            [ 'value' => 'has-default-attributes', 'label' => __('Default Attributes', 'cornerstone') ],
            [ 'value' => 'has-dimensions', 'label' => __('Dimensions', 'cornerstone') ],
            [ 'value' => 'has-options', 'label' => __('Options', 'cornerstone') ],
            [ 'value' => 'has-weight', 'label' => __('Weight', 'cornerstone') ]
          ]
        ]
      ]
    ];
  }

  public function assignment_context_single() {

    $conditions = [
      [
        'key'    => "single:product",
        'label'  => __('All Products'),
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( $post_type );

    $conditions[] = [
      'key'    => "single:specific-post-of-type|$post_type",
      'label'  => sprintf(__('%s (Specific)', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => "posts:$post_type"
      ]
    ];

    $post_type_taxonomies = get_object_taxonomies($post_type);

    foreach ($post_type_taxonomies as $taxonomy) {
      if ($taxonomy === 'post_format') {
        continue;
      }

      $taxonomy_obj = get_taxonomy($taxonomy);

      $conditions[] = [
        'key'    => "single:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    if ($post_type_obj->hierarchical) {

      $conditions[] = [
        'key'    => "single:parent|$post_type",
        'label'  => sprintf(__('%s Parent', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

      $conditions[] = [
        'key'    => "single:ancestor|$post_type",
        'label'  => sprintf(__('%s Ancestor', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

      if (post_type_supports($post_type, 'page-attributes')) {
        $conditions[] = [
          'key'    => "single:page-template|$post_type",
          'label'  => sprintf(__('%s Template', 'cornerstone'), $post_type_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => cs_get_page_template_options($post_type)
          ]
        ];
      }
    }

    if (post_type_supports($post_type, 'post-formats')) {
      $conditions[] = [
        'key'    => "single:format|$post_type",
        'label'  => sprintf(__('%s Format', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => cs_get_post_format_options()
        ]
      ];
    }

    $conditions[] = [
      'key'    => "single:publish-date|$post_type",
      'label'  => sprintf(__('%s Publish Date', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => [
        'type'   => 'boolean',
        'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
      ],
      'criteria' => ['type' => 'date-picker'],
    ];

    $conditions[] = [
      'key'    => "single:status|$post_type",
      'label'  => sprintf(__('%s Status', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => cs_get_post_status_options()
      ]
    ];

    return $conditions;
  }

  public function assignment_context_archive() {

    $conditions = [
      [
        'key'    => "archive:shop",
        'label'  => __('Shop'),
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( $post_type );
    $post_type_taxonomies = get_object_taxonomies($post_type);

    foreach ($post_type_taxonomies as $taxonomy) {
      if ($taxonomy === 'post_format') {
        continue;
      }

      $taxonomy_obj = get_taxonomy($taxonomy);

      $conditions[] = [
        'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    return $conditions;
  }

  public function preview_context_single() {

    $post_type_obj = get_post_type_object( 'product' );

    return [
      [
        'key'    => "single:post-type|product",
        'label'  => $post_type_obj->labels->singular_name,
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:product"
        ]
      ]
    ];

  }

  public function preview_context_archive() {

    $archive = [
      [
        'key'      => 'archive:front-page',
        'label'    => __('Shop', 'cornerstone'),
        'criteria' => [
          'url' => wc_get_page_permalink( 'shop' )
        ]
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( 'product' );
    $post_type_taxonomies = get_object_taxonomies($post_type);

    foreach ($post_type_taxonomies as $taxonomy) {
      if ($taxonomy === 'post_format') {
        continue;
      }

      $taxonomy_obj = get_taxonomy($taxonomy);

      $archive[] = [
        'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    return $archive;
  }

  public function is_wc_archive() {
    return is_shop() || is_product_tag() || is_product_category();
  }

  public function detect_layout_type( $type ) {

    if ( is_woocommerce() ) {

      if ( $this->is_wc_archive() ) {
        return 'layout-archive-wc';
      }

      return 'layout-single-wc';

    }

    return $type;

  }

  public function condition_rule_single_product() {
    return is_singular('product');
  }

  public function condition_rule_archive_shop() {
    return $this->is_wc_archive();
  }

  public function condition_rule_wc_product_is( $result, $args ) {

    list($type) = $args;

    global $product;

    if (empty($product)) {
      return false;
    }

    switch ($type) {
      case 'is-downloadable': {
        return $product->is_downloadable();
      }
      case 'is-featured': {
        return $product->is_featured();
      }
      case 'is-in-stock': {
        return $product->is_in_stock();
      }
      case 'is-on-backorder': {
        return $product->is_on_backorder();
      }
      case 'is-on-sale': {
        return $product->is_on_sale();
      }
      case 'is-purchasable': {
        return $product->is_purchasable();
      }
      case 'is-shipping-taxable': {
        return $product->is_shipping_taxable();
      }
      case 'is-sold-individually': {
        return $product->is_sold_individually();
      }
      case 'is-taxable': {
        return $product->is_taxable();
      }
      case 'is-virtual': {
        return $product->is_virtual();
      }
      case 'is-visible': {
        return $product->is_visible();
      }
    }

    return $result;

  }

  public function condition_rule_wc_product_has( $result, $args ) {

    list($type) = $args;

    global $product;

    if (empty($product)) {
      return false;
    }

    switch ($type) {
      case 'has-image': {
        return !empty( $product->get_image_id() );
      }
      case 'has-gallery': {
        return !empty( $product->get_gallery_image_ids() );
      }
      case 'has-reviews': {
        return ! empty( get_comments_number( $product->get_id()) );
      }
      case 'has-attributes': {
        return $product->has_attributes();
      }
      case 'has-child': {
        return $product->has_child();
      }
      case 'has-default-attributes': {
        return $product->has_default_attributes();
      }
      case 'has-dimensions': {
        return $product->has_dimensions();
      }
      case 'has-options': {
        return $product->has_options();
      }
      case 'has-weight': {
        return $product->has_weight();
      }
    }

    return $result;

  }

}

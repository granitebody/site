<?php

class Cornerstone_Query_Builder extends Cornerstone_Plugin_Component {

  public function get_controls() {
    return [
      'posts' => $this->get_post_controls(),
      'taxonomies' => $this->get_taxonomy_controls(),
      'authors' => $this->get_author_controls()
    ];
  }

  public function get_post_controls() {

    if (! isset( $this->post_controls ) ) {
      $this->post_controls = $this->post_controls();
    }

    return $this->post_controls;

  }

  public function get_taxonomy_controls() {

    if (! isset( $this->taxonomy_controls ) ) {
      $this->taxonomy_controls = $this->taxonomy_controls();
    }

    return $this->taxonomy_controls;

  }

  public function get_author_controls() {

    if (! isset( $this->author_controls ) ) {
      $this->author_controls = $this->author_controls();
    }

    return $this->author_controls;

  }

  public function post_controls() {
    $controls = [
      [
        'key'   => 'post-type',
        'label' => __('Post Type', 'cornerstone'),
        'toggle' => ['type' => 'static'],
        'criteria' => [
          'type'    => 'select',
          'choices' => $this->plugin->component('Locator')->get_post_type_options()
        ]
      ]
    ];

    $post_types = apply_filters( 'cs_query_builder_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {

      $controls[] = [
        'key'    => "specific-post-of-type|$post_type",
        'label'  => sprintf(__('%s (Specific)', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

    }

    return $controls;

  }

  public function taxonomy_controls() {
    return [];
  }

  public function author_controls() {
    return [];
  }

}

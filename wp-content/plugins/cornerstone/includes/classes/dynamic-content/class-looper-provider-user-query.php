<?php

// Used to power
// query-string
// recent-posts
// query-builder

class Cornerstone_Looper_Provider_User_Query extends Cornerstone_Looper_Provider_Wp_Query {

  protected $query = null;
  protected $args = [];

  public function setup_query( $element, $config ) {

    $this->args = apply_filters( 'cs_looper_provider_query_args', $this->make_query( $element, array_merge( [
      'is_recent' => false,
      'is_builder' => false,
      'is_string' => false,
    ], $config ) ), $element );

  }

  public function make_query( $element, $config ) {

    if ( $config['is_string'] ) {
      return isset($element['looper_provider_query_string']) && $element['looper_provider_query_string'] ? cs_dynamic_content( $element['looper_provider_query_string'] ) : '';
    }

    $args = [ 'ignore_sticky_posts' => true ];

    $posts_per_page = intval( get_option('posts_per_page') );
    $count = intval( cs_dynamic_content( $element['looper_provider_query_count'] ) );

    if ($count !== 0 && $count !== $posts_per_page) {
      $args['posts_per_page'] = max(1, $count);
    }

    if ( $config['is_recent'] ) {
      return $args;
    }

    $args['order'] = $element['looper_provider_query_order'];
    $args['orderby'] = $element['looper_provider_query_orderby'];

    if ($element['looper_provider_query_include_sticky']) {
      $args['ignore_sticky_posts'] = false;
    }


    if ($element['looper_provider_query_before'] || $element['looper_provider_query_after']) {

      $date_query = [];

      if ($element['looper_provider_query_before']) {
        $date_query['before'] = $element['looper_provider_query_before'];
      }

      if ($element['looper_provider_query_after']) {
        $date_query['after'] = $element['looper_provider_query_after'];
      }

      $args['date_query'] = $date_query;
    }

    if ( !empty($element['looper_provider_query_post_types'] ) ) {
      $args['post_type'] = $element['looper_provider_query_post_types'];
    }

    if ( !empty($element['looper_provider_query_post_ids'] ) ) {

      $key = isset( $element['looper_provider_query_post_in'] ) && $element['looper_provider_query_post_in']
        ? 'post__in'
        : 'post__not_in';

      $args[$key] = $element['looper_provider_query_post_ids'];

    }

    if ( !empty($element['looper_provider_query_term_ids'] ) ) {

      $taxonomies = [];

      foreach ($element['looper_provider_query_term_ids'] as $term) {
        list($taxonomy, $term_id) = explode('|', $term);
        if ( ! isset( $taxonomies[$taxonomy] ) ) {
          $taxonomies[$taxonomy] = [
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => [],
          ];
          if ( isset($element['looper_provider_query_term_in']) && ! $element['looper_provider_query_term_in'] ) {
            $taxonomies[$taxonomy]['operator'] = 'NOT IN';
          }
        }
        $taxonomies[$taxonomy]['terms'][] = $term_id;
      }

      $tax_query = array_values($taxonomies);
      if (count( $tax_query) > 0) {

        if (count($tax_query) > 1) {
          $tax_query['relation'] = isset($element['looper_provider_query_term_and']) && $element['looper_provider_query_term_and'] ? 'AND' : 'OR';
        }

        $args['tax_query'] = $tax_query;
      }


    }

    if ( !empty($element['looper_provider_query_author_ids'] ) ) {

      $key = isset( $element['looper_provider_query_author_in'] ) && $element['looper_provider_query_author_in']
        ? 'author__in'
        : 'author__not_in';

      $args[$key] = $element['looper_provider_query_author_ids'];

    }

    return $args;

  }

  public function query_begin() {
    $this->query = new WP_Query( $this->args );
  }

  public function query_resume() {
    $this->query->reset_postdata();
  }

  public function get_index() {
    return $this->query->current_post;
  }

  public function get_size() {
    return $this->query->post_count;
  }

  protected function query_advance() {
    if ($this->query && $this->query->have_posts()) {
      $this->query->the_post();
      return true;
    } else {
      return false;
    }
  }
}

<?php

class Cornerstone_Looper_Provider_Wp_Query extends Cornerstone_Looper_Provider {

  public function __construct( $element = [], $config = []) {
    $this->setup_query( $element, $config );
  }

  public function setup_query($element, $config) {

  }

  public function begin() {
    $this->set_in_loop( true );
    $this->query_begin();
  }

  public function set_in_loop( $in ) {
    if ($in) {
      if ( !has_filter( 'cs_looper_in_wp_query', '__return_true' ) ) {
        add_filter( 'cs_looper_in_wp_query', '__return_true' );
      }
    } else {
      remove_filter('cs_looper_in_wp_query', '__return_true' );
    }
  }

  public function resume() {
    $this->set_in_loop( true );
    $this->query_resume();
  }

  public function end() {
    $this->set_in_loop( false );
    $this->query_end();
  }

  public function advance() {
    return $this->query_advance();
  }

  public function query_begin() {

  }

  public function query_end() {

  }

  public function query_resume() {
    wp_reset_postdata();
  }

  public function get_index() {
    global $wp_query;
    return $wp_query->current_post;
  }

  public function get_size() {
    global $wp_query;
    return $wp_query->post_count;
  }

  protected function query_advance() {
    if (!is_singular() && have_posts()) {
      the_post();
      return true;
    } else {
      return false;
    }
  }

}

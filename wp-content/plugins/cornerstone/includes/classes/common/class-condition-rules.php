<?php

class Cornerstone_Condition_Rules {

  //
  // Site
  //

  public static function site_entire_site() {
    return true;
  }

  //
  // Single
  //

  public static function single_singular_all() {
    return is_singular();
  }

  public static function single_front_page() {
    return is_singular() && is_front_page();
  }

  public static function single_post_type( $post_type ) {
    return is_singular( $post_type );
  }

  public static function single_specific_post_of_type( $post_type, $post_id ) {
    return is_singular( $post_type ) && get_queried_object_id() === $post_id;
  }

  public static function single_post_type_with_term( $post_type, $taxonomy, $term_id ) {
    return is_singular( $post_type ) && has_term( $term_id, $taxonomy );
  }

  public static function single_parent( $post_type, $parent_id ) {
    global $post;
    return is_singular( $post_type ) && wp_get_post_parent_id( $post ) === $parent_id;
  }

  public static function single_ancestor( $post_type, $ancestor_id) {
    global $post;
    return is_singular( $post_type ) && in_array( $ancestor_id, get_post_ancestors( $post ), true );
  }

  public static function single_page_template( $post_type, $page_template ) {

    if ( ! is_singular( $post_type ) ) {
      return false;
    }

    $current = basename(get_page_template());
    $is_default = $current === 'page.php' && $page_template === 'default';
    return $is_default || $current === $page_template;

  }

  public static function single_format( $post_type, $post_format ) {
    return is_singular( $post_type ) && get_post_format() === $post_format;
  }

  public static function single_publish_date( $post_type, $date ) {
    return is_singular( $post_type ) && strtotime(get_the_date('c')) < strtotime( $date );
  }

  public static function single_status( $post_type, $status ) {
    return is_singular( $post_type ) && get_post_status() === $status;
  }

  public static function single_term( $term_id ) {
    $term = get_term($term_id);
    return has_term( $term_id, $term->taxonomy );
  }

  public static function single_page_404() {
    return is_404();
  }

  //
  // Archive
  //

  public static function archive_all() {
    return is_archive() && !is_home() && !is_front_page();
  }

  public static function archive_front_page() {

    if ( get_option( 'show_on_front' ) === 'page' ) {
      return is_home();
    }

    return is_front_page();
  }

  public static function archive_query_type( $type ) {

    if ($type === 'date') {
      return is_date();
    }

    if ($type === 'first-page') {
      return !is_paged();
    }

    return false;
  }

  public static function archive_post_type( $post_type ) {
    return ! is_singular() && get_post_type() === $post_type;
  }

  public static function archive_post_type_with_term( $post_type, $taxonomy, $term) {

    if (get_post_type() !== $post_type) {
      return false;
    }

    if ( $taxonomy === 'category' ) {
      return $term ? is_category( $term ) : is_category();
    }

    if ( $taxonomy === 'post_tag' ) {
      return $term ? is_tag( $term ) : is_tag();
    }

    return is_tax( $taxonomy, $term );
  }

  public static function archive_taxonomy( $post_type, $taxonomy ) {
    if (get_post_type() !== $post_type) {
      return false;
    }

    if ( $taxonomy === 'category' ) {
      return is_category( $term );
    }

    if ( $taxonomy === 'post_tag' ) {
      return is_tag();
    }

    return is_tax( $taxonomy );
  }

  public static function archive_author() {
    return is_author();
  }

  public static function archive_specific_author( $user_id ) {
    return is_author($user_id);
  }

  public static function archive_search() {
    return is_search();
  }

  public static function archive_term( $term_id ) {
    return is_tax( '', $term_id );
  }

  //
  // Current Post
  //

  public static function current_post_post_type( $post_type ) {
    return get_post_type() === $post_type;
  }

  public static function current_post_specific_post_of_type( $post_type, $post_id ) {
    return get_post_type() === $post_type && get_queried_object_id() === $post_id;
  }

  public static function current_post_parent( $parent_id ) {
    return wp_get_post_parent_id( $post ) === $parent_id;
  }

  public static function current_post_ancestor( $ancestor_id) {
    global $post;
    return in_array( $ancestor_id, get_post_ancestors( $post ), true );
  }

  public static function current_post_page_template( $page_template ) {
    $current = basename(get_page_template());
    $is_default = $current === 'page.php' && $page_template === 'default';
    return $is_default || $current === $page_template;
  }

  public static function current_post_format( $post_format ) {
    return get_post_format() === $post_format;
  }

  public static function current_post_publish_date( $date ) {
    return strtotime(get_the_date('c')) < strtotime( $date );
  }

  public static function current_post_modified_date( $date ) {
    return strtotime(get_the_modified_date('c')) < strtotime( $date );
  }

  public static function current_post_status( $status ) {
    return get_post_status() === $status;
  }

  public static function current_post_featured_image() {
    return has_post_thumbnail();
  }

  public static function current_post_taxonomy( $taxonomy ) {
    return has_term( '', $taxonomy );
  }

  public static function current_post_term( $term_id ) {
    $term = get_term($term_id);
    return has_term( $term_id, $term->taxonomy );
  }

  //
  // Current Query
  //

  public static function current_query_query_type( $type ) {

    if ($type === 'date') {
      return is_date();
    }

    if ($type === 'first-page') {
      return !is_paged();
    }

    return false;
  }

  public static function current_query_is_404() {
    return is_404();
  }

  public static function current_query_is_search() {
    return is_search();
  }

  public static function current_query_is_front_page() {
    return is_front_page();
  }

  //
  // Global
  //

  public static function global_today( $date ) {
    return current_time('timestamp') < strtotime( $date );
  }

  public static function global_user_loggedin() {
    return is_user_logged_in();
  }

  public static function global_user_role( $role ) {
    $user = wp_get_current_user();
    return in_array( $role, $user->roles, true);
  }

  //
  // Looper
  //

  public static function looper_index( $type ) {

    $index = CS('Looper_Manager')->get_index();
    $size = CS('Looper_Manager')->get_size();

    switch ($type) {
      case 'first':
        return $index === 0;
      case 'last':
        return $index === $size - 1;
      case 'odd':
        return $index % 2 !== 0;
      case 'even':
        return $index % 2 === 0;
    }

    return false;

  }

  public static function looper_consumed_item() {
    return ! apply_filters( 'cs_render_looper_is_virtual', false );
  }

}

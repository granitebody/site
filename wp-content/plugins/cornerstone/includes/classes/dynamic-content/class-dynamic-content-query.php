<?php
/**
 * site-title
 * site-tagline
 * site-url
 */

class Cornerstone_Dynamic_Content_Query extends Cornerstone_Plugin_Component {

  protected $cache = array();

  public function setup() {
    add_filter('cs_dynamic_content_query', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'query',
      'label' => csi18n('app.dc.group-title-query')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'current_page',
      'group' => 'query',
      'label' => csi18n( 'app.dc.query.current-page' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'total_pages',
      'group' => 'query',
      'label' => csi18n( 'app.dc.query.total-pages' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'total_pages',
      'group' => 'query',
      'label' => csi18n( 'app.dc.query.total-pages' )
    ));

  }

  public function supply_field( $result, $field, $args) {

    switch ($field) {
      case 'current_page':
        $result = (get_query_var('paged')) ? get_query_var('paged') : 1;
        break;
      case 'total_pages':
        global $wp_query;
        $result = $wp_query->max_num_pages;
        break;
    }

    return $result;
  }

}

<?php
/**
 * site-title
 * site-tagline
 * site-url
 */

class Cornerstone_Dynamic_Content_Looper extends Cornerstone_Plugin_Component {

  protected $cache = array();

  public function setup() {
    add_filter('cs_dynamic_content_looper', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'looper',
      'label' => csi18n('app.dc.group-title-looper')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'index',
      'group' => 'looper',
      'label' => csi18n( 'app.dc.looper.index' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'count',
      'group' => 'looper',
      'label' => csi18n( 'app.dc.looper.count' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'field',
      'group' => 'looper',
      'label' => csi18n( 'app.dc.looper.field' ),
      'controls' => array(
        array(
          'key' => 'key',
          'type' => 'text',
          'label' => csi18n('app.dc.key'),
          'options' => array( 'placeholder' => csi18n('app.dc.key') )
        ),
        array(
          'key' => 'fallback',
          'type' => 'text',
          'label' => csi18n('app.dc.fallback'),
          'options' => array( 'placeholder' => csi18n('app.dc.fallback') )
        )
      ),
      'options' => array(
        'supports' => array( 'image' ),
        'always_customize' => true
      ),
    ));

  }

  public function supply_field( $result, $field, $args) {

    switch ($field) {
      case 'index':
        $result = $this->plugin->component('Looper_Manager')->get_index() + 1;
        break;
      case 'count':
        $result = $this->plugin->component('Looper_Manager')->get_size();
        break;
      case 'field':
        $data = $this->plugin->component('Looper_Manager')->get_current_data();
        if ($args['key'] && isset($data[$args['key']])) {
          $result = $data[$args['key']];
        }
        break;
    }

    return $result;
  }

}

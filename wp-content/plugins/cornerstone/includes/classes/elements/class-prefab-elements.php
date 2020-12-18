<?php

class Cornerstone_Prefab_Elements extends Cornerstone_Plugin_Component {

  protected $prefabs = array();
  protected $groups = array();

  public function register_prefab_group( $name, $title ) {
    $this->groups[ $name ] = $title;
  }

  public function register_element( $group, $name, $options ) {
    if ( ! isset( $this->prefab[ $group ] ) ) {
      $this->prefab[ $group ] = array();
    }

    try {
      $this->prefabs[ $group ][ $name ] = $this->normalize_element( $options );
    } catch (Exception $e) {
      trigger_error('Unabled to register prefab: ' . $e->getMessage( ) );
    }

  }

  public function normalize_element( $options ) {

    if (!isset($options['type'])) {
      throw new Exception('type required');
    }

    $options = array_merge( array(
      'scope'  => 'all',
      'title'  => $options['type'],
      'values' => array()
    ), $options );

    return $options;
  }

  public function unregister_element( $group, $name ) {
    if (isset( $this->prefab[ $group ] ) ) {
      unset( $this->prefabs[ $group][ $name ] );
    }
  }

  public function get_prefabs() {

    if ( !did_action( 'cs_register_dynamic_elements') ) {
      require_once( $this->path( 'includes/elements/prefab-elements.php' ) );
      do_action( 'cs_register_prefab_elements' );
    }

    return array(
      'groups' => array_intersect_key($this->groups, $this->prefabs),
      'elements' => array_intersect_key($this->prefabs, $this->groups),
    );

  }

}

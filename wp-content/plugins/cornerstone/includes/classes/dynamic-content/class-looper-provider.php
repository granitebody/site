<?php

abstract class Cornerstone_Looper_Provider {

  protected $current_data = array();
  protected $index = 0;
  protected $disposed = false;
  protected $manager = null;
  protected $current_consumer = false;
  public function __construct( $element = array() ) {}

  public function begin() {}

  public function pause() {}

  public function resume() {}

  public function end() {}

  public function dispose() {
    if ( ! $this->disposed ) {
      $this->end();
    }
  }

  protected function advance() {}

  final public function consume() {
    $result = $this->advance();
    $this->current_data = $result ? $result : array();
    $complete = empty($result);
    if ( $complete ) {
      $this->dispose();
      return false;
    }
    return true;
  }

  public function set_current_consumer( $current_consumer ) {
    $this->current_consumer = $current_consumer;
  }

  public function current_consumer() {
    return $this->current_consumer;
  }

  final public function get_current_data() {
    return $this->current_data;
  }

  public function get_index() {
    return 0;
  }

  public function get_size() {
    return 0;
  }

  public function set_manager( $manager ) {
    $this->manager = $manager;
  }

  static public function create( $element, $manager ) {
    $provider = null;

    switch ($element['looper_provider_type']) {
      case 'query-recent':
        $provider = new Cornerstone_Looper_Provider_User_Query( $element, [ 'is_recent' => true ] );
        break;
      case 'query-builder':
        $provider = new Cornerstone_Looper_Provider_User_Query( $element, [ 'is_builder' => true ] );
        break;
      case 'query-string':
        $provider = new Cornerstone_Looper_Provider_User_Query( $element, [ 'is_string' => true ] );
        break;
      case 'terms':
        $provider = new Cornerstone_Looper_Provider_Terms( $element );
        break;
      case 'json':
        $provider = new Cornerstone_Looper_Provider_Json( $element );
        break;
    }

    /**
     * Can be used to supply an instance of an external class that extends Cornerstone_Looper_Provider
     add_filter('cs_resolve_looper_provider', function($value, $element) {
        return new My_Custom_Data_Source( $element );
      }, 10, 2 );
     */

    $provider = apply_filters('cs_resolve_looper_provider', $provider, $element );

    if ( is_a( $provider, 'Cornerstone_Looper_Provider' ) ) {
      $provider->set_manager( $manager );
      return $provider;
    }

    throw new Exception('Unable to determine source type');
  }

}

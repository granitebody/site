<?php

class Cornerstone_Looper_Manager extends Cornerstone_Plugin_Component {

  protected $element_stack = array();
  protected $current_element = null;
  protected $provider_stack = array();
  protected $current_provider = null;

  public function setup() {
    add_action( 'cs_preview_archive_setup', [$this, 'setup_main_looper_provider' ] );
    add_action( 'cs_layout_before_archive', [$this, 'setup_main_looper_provider' ] );
    add_filter( 'cs_render_element_data', [ $this, 'update_unique_id' ] );
  }

  public function setup_main_looper_provider() {
    $main_provider = apply_filters( 'cs_looper_main_query', new Cornerstone_Looper_Provider_Wp_Query() );
    $main_provider->begin();
    $this->provider_stack[] = $main_provider;
    $this->current_provider = $main_provider;
  }

  public function maybe_start_element( $element ) {

    $is_provider = isset( $element['looper_provider'] ) && $element['looper_provider'];
    $is_consumer = isset( $element['looper_consumer'] ) && $element['looper_consumer'];

    if ( $is_provider || $is_consumer ) {

      $looper_element = new Cornerstone_Looper_Element( $element['unique_id'] );

      if ( $is_provider ) {

        try {
          $looper_element->set_is_provider();

          $provider = Cornerstone_Looper_Provider::create($element, $this);

          if ($this->current_provider) {
            $this->current_provider->pause();
          }

          $provider->begin();
          $this->provider_stack[] = $provider;
          $this->current_provider = $provider;

        } catch (Exception $e) {
          trigger_error( $e->getMessage(), E_USER_WARNING );
          $is_provider = false;
        }

      }


      if ( $is_consumer && $this->current_provider && ! $this->current_provider->current_consumer() ) {

        $this->current_provider->set_current_consumer( $element['_id'] );
        $looper_element->set_is_consumer();

        if ( isset( $element['looper_consumer_repeat'] ) ) {
          $looper_element->set_repeat( (int) $element['looper_consumer_repeat'] );
        }

      } else {
        $is_consumer = false;
      }

      if ( $is_provider || $is_consumer ) {
        $looper_element->set_provider( $this->current_provider );
        $this->element_stack[] = $looper_element;
        $this->current_element = $looper_element;
      }

    }

    if ($is_consumer) return 'consumer';
    if ($is_provider) return 'provider';

    return false;

  }

  public function iterate() {
    if ($this->current_element && $this->current_element->is_consumer()) {
      return $this->current_element->consume();
    }
    return false;
  }

  public function end_element() {
    $element_removal = array_pop($this->element_stack);

    if ($element_removal) {

      if ($element_removal->is_provider()) {
        $latest_provider = array_pop($this->provider_stack);
        $latest_provider->dispose();

        $this->current_provider = end($this->provider_stack);
        if ($this->current_provider) {
          $this->current_provider->resume();
        }
      }

      if ($element_removal->is_consumer()) {
        if ($this->current_provider) {
          $this->current_provider->set_current_consumer(null);
        }
      }

    }

    $this->current_element = end($this->element_stack);


  }

  public function get_current_data() {
    return $this->current_provider ? $this->current_provider->get_current_data() : array();
  }

  public function get_index() {
    return $this->current_provider ? $this->current_provider->get_index() : 0;
  }

  public function get_size() {
    return $this->current_provider ? $this->current_provider->get_size() : 0;
  }

  public function update_unique_id( $data ) {
    $indexes = array_map(function( $consumer ) {
      return $consumer->provider()->get_index();
    }, array_filter($this->element_stack, function($looper_element) {
      return $looper_element->is_consumer();
    }) );

    $index_id = implode('-', $indexes);
    if ($index_id !== '') $data['unique_id'] .= "-$index_id";

    return $data;
  }

}

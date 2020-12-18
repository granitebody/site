<?php

class Cornerstone_Looper_Provider_Array extends Cornerstone_Looper_Provider {

  protected $items = [];
  protected $size = 0;

  public function __construct( $element ) {

    $items = $this->get_array_items( $element );

    if ( is_array( $items ) ) {
      $this->items = $items;
      $this->size = count($items);
    }

  }

  protected function advance() {
    return array_shift($this->items);
  }

  public function get_index() {
    return $this->size - count($this->items);
  }

  public function get_size() {
    return $this->size;
  }
}

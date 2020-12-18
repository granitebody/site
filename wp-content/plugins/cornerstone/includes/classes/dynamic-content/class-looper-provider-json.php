<?php

class Cornerstone_Looper_Provider_Json extends Cornerstone_Looper_Provider_Array {

  public function get_array_items( $element ) {
    return json_decode( $element['looper_provider_json'], true );
  }

}

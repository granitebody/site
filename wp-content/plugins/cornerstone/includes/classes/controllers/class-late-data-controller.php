<?php

class Cornerstone_Late_Data_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'late-data', [$this, 'get_late_data']);
  }

  public function get_late_data( $params ) {

    $data = $this->plugin->component( 'App' )->get_late_data();
    $signed = array();
    foreach ($data as $key => $value ) {
      $signed[$key] = $this->sign_preload( $value );
    }

    $result = array( 'lateData' => $signed );

    if ( isset( $params['state'] ) ) {
      foreach ( $params['state'] as $key => $value ) {
        $parts = explode(':', $key);
        $group = $parts[0];
        $id = $parts[1];
        if (isset($result[$group]) &&
          isset($result[$group][$id]) &&
          $result[$group][$id][0] === $value) {
            $result[$group][$id] = array( $value ); // don't send values that didn't change
        }
      }
    }

    return $result;
  }

  public function sign_preload( $data ) {

    $content = json_encode( $data );

    if ( function_exists('gzcompress') ) {
      $content = base64_encode( gzcompress( $content, 9 ) );
    }

    return array( md5($content), $content );
  }

}

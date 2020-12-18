<?php

foreach (glob( CS()->path('_dev') . '/*.php' ) as $filename ) {
  require_once( $filename);
}

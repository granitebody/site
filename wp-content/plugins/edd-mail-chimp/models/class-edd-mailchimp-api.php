<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

use \DrewM\MailChimp\MailChimp;

class EDD_MailChimp_API {

	public $api;
	protected $_endpoint;
	protected $_resource;

	public function __construct() {
		$this->connect_api();
	}

	/**
	 * Connect to the MailChimp API
	 *
	 * @throws Exception
	 */
	protected function connect_api() {
		$key = edd_get_option('eddmc_api', false);

		if ( $key ) {
			$this->api = new MailChimp( trim( $key ) );

			if ( defined('EDD_MC_VERIFY_SSL') && EDD_MC_VERIFY_SSL === false ) {
				$this->api->verify_ssl = false;
			}
		}
	}

	/**
	 * Verify if the API is connected by seeing if the value is `null`
	 * @return bool
	 */
	protected function api_connected() {
		return ! empty( $this->api );
	}

}

<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class EDD_MailChimp_Store extends EDD_MailChimp_Model {

	public $id;
	public $list_id;
	protected $_endpoint = 'ecommerce/stores';
	protected $_has_many = array(
		'products'  => 'EDD_MailChimp_Product',
		'carts'     => 'EDD_MailChimp_Cart',
		'orders'    => 'EDD_MailChimp_Order',
		'customers' => 'EDD_MailChimp_Customer',
	);

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Find or create a store record based on the provided MailChimp list.
	 *
	 * @param  mixed $list EDD_MailChimp_List | string $list_id | bool
	 * @return mixed EDD_MailChimp_Store | Exception
	 */
	public static function find_or_create( $list = false ) {
		$klass = new static;

		if ( ! $klass->api_connected() ) {
			return false;
		}


		$klass->_set_list( $list );
		$klass->_set_resource();

		if ( $klass->exists() ) {
			$response = $klass->api->getLastResponse();
			$klass->_record = json_decode( $response['body'], true );
			return $klass;
		}

		$klass->_build();
		$result = $klass->api->post( $klass->_endpoint, $klass->_record );

		if ( $klass->api->success() ) {
			$klass->_record = $result;
			return $klass;
		}

		/*
		 * We are now going to get a full list of stores and determine which list ID this domain is connected to
		 */

		$all_stores = $klass->all();

		if( ! empty( $all_stores['stores'] ) ) {

			foreach( $all_stores['stores'] as $store ) {

				if( home_url() == $store['domain'] ) {

					edd_debug_log( home_url() . ' is already connected to list ID ' . $store['list_id'] . '. Connect that list then click Disconnect to delete the store.' );

				}

			}

		}


		$error = $klass->api->getLastError();

		edd_debug_log( 'Exception occurred while looking up or creating store in MailChimp: ' . var_export( $error, true ) );

		return false;

	}


	/**
	 * Assign the list which this store is associated with.
	 *
	 * @param mixed $list EDD_MailChimp_List | string $list_id
	 */
	protected function _set_list( $list = false  ) {
		if ( $list === false ) {
			$list = EDD_MailChimp_List::get_default();
			$this->list_id = $list->remote_id;
		} elseif ( is_string( $list ) ) {
			$this->list_id = $list;
		} elseif ( is_object( $list ) && get_class( $list ) === 'EDD_MailChimp_List' ) {
			$this->list_id = $list->remote_id;
		}
	}


	/**
	 * The store ID is a combination of the home url hash and the list ID, as the list cannot be
	 * changed for a store in the new api.
	 *
	 * @return void
	 */
	protected function _set_resource() {
		$id = md5( home_url() )  . '-' . $this->list_id;
		$this->id = apply_filters('edd.mailchimp.store.id', $id, $this->list_id);
		$this->_resource = $this->_endpoint . '/' . $this->id;
	}

	/**
	 * Resource getter
	 *
	 * @return [type] [description]
	 */
	public function get_resource() {
		return $this->_resource;
	}


	/**
	 * Build the store record based on sensible defaults.
	 *
	 * @return $this
	 */
	protected function _build( $args = array() ) {
		$record = array_merge(
			array(
				'id'             => $this->id,
				'list_id'        => $this->list_id,
				'name'           => get_bloginfo('name'),
				'platform'       => __('Easy Digital Downloads', 'easy-digital-downloads'),
				'domain'         => $this->get_site_domain(),
				'is_syncing'     => true,
				'email_address'  => get_site_option('admin_email'),
				'currency_code'  => edd_get_currency(),
				'money_format'   => edd_currency_filter( '' ),
				'primary_locale' => substr( get_locale(), 0, 2 ),
				'timezone'       => edd_get_timezone_id(),
			),
			$args
		);

		$this->_record = apply_filters('edd.mailchimp.store', $record);
		return $this;
	}

	/**
	* Since MailChimp does not allow connecting two sites that share the same domain (they strip off the entire subdirectory part) we generate a unique domain here.
	* @return string
	*/
	private function get_site_domain() {
		$domain = str_ireplace( array( 'https://', 'http://', '://' ), '', get_option( 'siteurl' ) );

		if( is_multisite() && strpos( $domain, '/' ) > strpos( $domain, '.' ) ) {
			$subdir_pos = strpos( $domain, '/' );
			$subdir = substr( $domain, $subdir_pos + 1 );
			$domain = substr( $domain, 0, $subdir_pos );
			$domain = $subdir . '.' . $domain;
		}

		$domain .= '.' . $this->list_id;


		return $domain;
	}

	/**
	 * Sync the EDD store with MailChimp
	 *
	 * @return void
	 */
	public function sync( $model = '' ) {
		global $wpdb;
		$batch_size   = 25;
		$is_full_sync = $model === '' ? true : false;

	 // Figure out how many records of a certain type we have to deal with
	 // in our job and chunks up the workload for use in multiple tasks.
		switch ( $model ) {
			case '':
			case 'products':
				$sync_type = 'products';
				$total_sql = "SELECT COUNT(ID) as total FROM $wpdb->posts WHERE post_type = 'download'";
				$edd_wrapper_class_name = 'EDD_Download';
				$edd_mailchimp_model_name = 'EDD_MailChimp_Product';
				break;
			case 'orders':
				$sync_type = 'orders';
				$total_sql = "SELECT COUNT(ID) as total FROM $wpdb->posts WHERE post_type = 'edd_payment'";
				$edd_wrapper_class_name = 'EDD_Payment';
				$edd_mailchimp_model_name = 'EDD_MailChimp_Order';
				break;
			default:
				return false;
		}

		$results = $wpdb->get_row( $total_sql, 0 );
		$pages   = ceil( $results->total / $batch_size );

		// No work to be done? Don't schedule a job.
		if ( $pages == 0 ) {

			$wpdb->update(
				$wpdb->edd_mailchimp_lists,
				array(
					'sync_status' => 'finished',
					'synced_at' => current_time( 'mysql' )
				),
				array( 'remote_id' => $data['payload']['list_id'] ),
				array( '%s', '%s' ),
				array( '%s' )
			);

			$this->is_syncing( false );
			return;
		}

		// Init the job class
		$job = new EDD_MailChimp_Sync;

		// Push items to the queue
		for( $page = 1; $page <= $pages; $page++ ) {

			$offset = ( $page - 1 ) * $batch_size;

			$data = array(
				'status' => 'queued',
				'payload' => array(
					'is_full_sync' => $is_full_sync,
					'sync_type'    => $sync_type,
					'total_records'=> $results->total,
					'batch_size'   => $batch_size,
					'offset'       => $offset,
					'list_id'      => $this->list_id,
					'edd_wrapper_class_name'   => $edd_wrapper_class_name,
					'edd_mailchimp_model_name' => $edd_mailchimp_model_name,
				)
			);

			$job->push_to_queue( $data );
		}

		// Save and dispatch the queue
		$job->save()->dispatch();
	}


	/**
	 * Set the store's remote sync status
	 *
	 * @param  boolean $status [description]
	 * @return boolean         [description]
	 */
	public function is_syncing( $status = true ) {
		$this->_record['is_syncing'] = $status;
		$this->save();
	}

}

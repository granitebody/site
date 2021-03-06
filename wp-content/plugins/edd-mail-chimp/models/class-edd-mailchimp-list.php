<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class EDD_MailChimp_List extends EDD_MailChimp_Model {

	protected $_endpoint = 'lists';
	public $remote_id;

	public function __construct( $remote_list_id = '' ) {
		parent::__construct();

		$this->remote_id = $remote_list_id;
		$this->_resource = $this->_endpoint . '/' . $this->remote_id;
		$this->_set_record();
	}

	/**
	 * Fetch the connected list that is specified as default
	 *
	 *   $default_list = EDD_MailChimp_List::get_default();
	 *
	 * @return mixed  EDD_MailChimp_List | null
	 */
	public static function get_default() {
		global $wpdb;

		$result = $wpdb->get_row(
			"SELECT * FROM $wpdb->edd_mailchimp_lists WHERE is_default = 1 LIMIT 1"
		);

		if ( $result ) {
			return new static( $result->remote_id );
		}

		return $result;
	}


	/**
	 * Fetch all lists that have been connected locally.
	 *
	 *   $connected_lists = EDD_MailChimp_List::connected();
	 *
	 * @return array
	 */
	public static function connected() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM $wpdb->edd_mailchimp_lists");
	}


	/**
	 * Determine if this list has already been connected locally.
	 *
	 * @return boolean
	 */
	public function is_connected() {
		return ! empty( $this->_record );
	}


	/**
	 * Connect a list locally.
	 *
	 * @param  boolean $default Should this be specified as the default list?
	 * @return EDD_MailChimp_List
	 */
	public function connect( $default = false ) {
		global $wpdb;

		$is_default = $default === true ? 1 : 0;

		$wpdb->insert( $wpdb->edd_mailchimp_lists, array(
			'remote_id'    => $this->remote_id,
			'name'         => $this->name,
			'is_default'   => $is_default,
			'sync_status'  => 'pending',
			'connected_at' => current_time('mysql')
		), array(
			'%s', '%s', '%d', '%s', '%s'
		) );

		$this->_set_record();
		$this->sync_interests();
		return $this;
	}

	/**
	 * Disconnect a list from the local EDD install.
	 *
	 * @return bool
	 */
	public function disconnect() {
		global $wpdb;

		edd_debug_log( 'disconnect_list(): attempting to disconnect list ' . $this->remote_id );

		try {

			$store = EDD_MailChimp_Store::find_or_create( $this->remote_id );

			if( $store ) {

				$store->delete();

				edd_debug_log( 'Store deleted in MailChimp' );

			} else {

				edd_debug_log( 'Store not deleted in MailChimp' );
			}

		} catch (Exception $e) {
			edd_debug_log( 'Exception occurred while deleting store in MailChimp: ' . $e->getMessage() );
			return;
		}

		$wpdb->delete(
			$wpdb->edd_mailchimp_lists,
			array( 'id' => $this->id ),
			array( '%d' )
		);

		$wpdb->delete(
			$wpdb->edd_mailchimp_interests,
			array( 'list_id' => $this->id ),
			array( '%d' )
		);

		$wpdb->delete(
			$wpdb->edd_mailchimp_downloads_lists,
			array( 'list_id' => $this->id ),
			array( '%d' )
		);

		edd_debug_log( 'disconnect_list(): list ' . $this->remote_id . ' disconnected' );

		return true;
	}


	/**
	 * Subscribe an email to a list.
	 *
	 * @return [type] [description]
	 */
	public function subscribe( $user_info = array(), $options = array() ) {

		// Make sure an API key and list ID has been entered
		if ( empty( $this->api ) || ! $this->remote_id ) {
			return false;
		}

		$merge_fields = array(
			'FNAME' => $user_info['first_name'],
			'LNAME' => $user_info['last_name']
		);

		$interests = array();

		$replace_interests = edd_get_option('eddmc_replace_interests');

		if ( $replace_interests ) {
			$records = $this->interests();

			if ( ! empty( $records ) ) {
				foreach( $records as $row ) {
					$interests[$row->interest_remote_id] = false;
				}
			}
		}

		if ( isset( $options['interests'] ) ) {
			foreach( $options['interests'] as $interest ) {
				$interests[$interest['remote_id']] = true;
			}
		}

		// Send both status and status_if_new
		$args = array(
			'email_address' => $user_info['email'],
			'merge_fields'  => $merge_fields,
		);

		if ( ! empty( $interests ) ) {
			$args['interests'] = $interests;
		}

		$subscriber_hash = $this->api->subscriberHash( $user_info['email'] );
		$subscriber      = $this->api->get( $this->_resource . "/members/$subscriber_hash" );

		if ( isset( $options['double_opt_in'] ) ) {
			$double_opt_in = (bool) $options['double_opt_in'];
		} else {
			$double_opt_in = edd_get_option( 'eddmc_double_opt_in' );
		}

		$status = $double_opt_in ? 'pending' : 'subscribed';

		/**
		 * If the subscriber hash already exists due to the customer creation, determine if the user is already subscribed or
		 * needs to be added as pending.
		 * 
		 * If the user is not found, just use the status beign passed.
		 */
		if ( ! empty( $subscriber['status'] ) && $subscriber['status'] === 404 ) {
			$args['status'] = $status;
		} else {
			if ( ! empty( $subscriber['status'] ) && $subscriber['status'] === 'subscribed' ) {
				$args['status'] = '';
			} else {
				$args['status'] = $status;
			}
		}

		$payload = apply_filters( 'edd_mc_subscribe_vars', $args );

		$this->api->put( $this->_resource . "/members/$subscriber_hash", $payload );

		return $this->api->success();
	}


	/**
	 * Fetch all of the associated interests for a connected list.
	 *
	 * @return array
	 */
	public function interests() {
		global $wpdb;
		$local_id = $this->_record['id'];
		return $wpdb->get_results("SELECT * FROM $wpdb->edd_mailchimp_interests WHERE list_id = $local_id");
	}


	/**
	 * Sync a list's interests locally
	 *
	 * @return boolean  Did it work?
	 */
	public function sync_interests() {
		global $wpdb;

		if ( ! $this->is_connected() ) {
			return false;
		}

		$interest_categories = $this->get_remote_interests();

		if ( empty( $interest_categories ) ) {
			return true;
		}

		foreach ( $interest_categories as $category ) {

			foreach ( $category['interests'] as $interest ) {

				$record = array(
					'list_id' => $this->id,
					'interest_category_remote_id' => $category['id'],
					'interest_category_name' => $category['name'],
					'interest_remote_id' => $interest['id'],
					'interest_name' => $interest['name'],
				);

				// Check if local interest record exists
				$row = $wpdb->get_row( $wpdb->prepare(
					"SELECT * FROM $wpdb->edd_mailchimp_interests WHERE interest_remote_id = %s",
					$interest['id']
				) );

				if ( empty( $row ) ) {

					// If not, insert a new record.
					$wpdb->insert( $wpdb->edd_mailchimp_interests, $record, array(
						'%d', '%s', '%s', '%s', '%s'
					) );

				} else {

					// If it does, update it with any changed info
					$wpdb->update(
						$wpdb->edd_mailchimp_interests,
						$record,
						array( 'interest_remote_id' => $interest['id'] ),
						array( '%d', '%s', '%s', '%s', '%s' ),
						array( '%s' )
					);

				}

			}
		}

		return true;
	}


	/**
	 * Fetch remote interests for a list.
	 *
	 * @return array
	 */
	public function get_remote_interests() {
		$all_category_data = array();

		if ( ! $this->api_connected() ) {
			$this->connect_api();
			if ( ! $this->api_connected() ) {
				return array();
			}
		}

		$result = $this->api->get( $this->_resource . "/interest-categories", array( 'count' => 100 ) );

		if ( $this->api->success() && ! empty( $result['categories'] ) ) {

			foreach( $result['categories'] as $category ) {

				$category_data = array(
					'id'   => $category['id'],
					'name' => $category['title'],
					'interests' => array(),
				);

				$endpoint = $this->_resource . '/interest-categories/' . $category['id'] . '/interests';
				$interests = $this->api->get( $endpoint, array( 'count' => 100 ) );

				if ( $interests && ! empty( $interests['interests'] ) ) {
					foreach ( $interests['interests'] as $interest ) {
						$interest_id   = $interest['id'];
						$interest_name = $interest['name'];

						$interest_data = array(
							'id'   => $interest['id'],
							'name' => $interest['name'],
						);

						$category_data['interests'][] = $interest_data;
					}
				}

				$all_category_data[] = $category_data;
			}
		}

		return $all_category_data;
	}


	/**
	 * Determines if the current list was the recipient of a
	 * specific campaign based on the MailChimp campaign id.
	 *
	 * @param  string $campaign_id A 10-character alphanumeric MailChimp Campaign ID
	 * @return boolean was the current list the recipient of the provided campaign?
	 */
	public function recipient_of_campaign( $campaign_id = '' ) {
		if ( $campaign_id === '' ) {
			return false;
		}

		$endpoint = '/campaigns/' . $campaign_id;
		$campaign = $this->api->get( $endpoint, array('fields' => 'recipients.list_id') );

		if ( ! $this->api->success() ) {
			return false;
		}

		return $this->remote_id == $campaign['recipients']['list_id'];
	}


	/**
	 * Sets the class `_record` property if the list has been connected locally.
	 *
	 * @return EDD_MailChimp_List
	 */
	private function _set_record() {
		global $wpdb;

		$result = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM $wpdb->edd_mailchimp_lists WHERE remote_id = %s LIMIT 1",
			$this->remote_id
		), ARRAY_A );

		if ( $result !== null ) {
			$this->_record = $result;
		}

		return $this;
	}

}

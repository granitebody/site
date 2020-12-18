<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Affiliate_WP_Zapier_DB base class
 *
 * @since   1.0
*/
abstract class Affiliate_WP_Zapier_DB {

	/**
	 * Database table name.
	 *
	 * @access  public
	 * @since   1.0
	 */
	public $table_name;

	/**
	 * The version of the database table.
	 *
	 * @access  public
	 * @since   1.0
	 */
	public $version;

	/**
	 * Primary column name.
	 *
	 * @access  public
	 * @since   1.0
	 */
	public $primary_key;

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	 */
	public function __construct() {}

	/**
	 * Whitelist of columns
	 *
	 * @access  public
	 * @since   1.0
	 * @return  array
	 */
	public function get_columns() {
		return array();
	}

	/**
	 * Default column values
	 *
	 * @access  public
	 * @since   1.0
	 * @return  array
	 */
	public function get_column_defaults() {
		return array();
	}

	/**
	 * Retrieve a row by the primary key
	 *
	 * @access  public
	 * @since   1.0
	 * @return  object
	 */
	public function get( $row_id ) {
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE $this->primary_key = %s LIMIT 1;", $row_id ) );
	}

	/**
	 * Retrieve a row by a specific column or value
	 *
	 * @access  public
	 * @since   1.0
	 * @return  object
	 */
	public function get_by( $column, $row_id ) {
		global $wpdb;
		$column = esc_sql( $column );
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE $column = %s LIMIT 1;", $row_id ) );
	}

	/**
	 * Retrieve a specific column  value by the primary key
	 *
	 * @access  public
	 * @since   1.0
	 * @return  string
	 */
	public function get_column( $column, $row_id ) {
		global $wpdb;
		$column = esc_sql( $column );
		return $wpdb->get_var( $wpdb->prepare( "SELECT $column FROM $this->table_name WHERE $this->primary_key = %s LIMIT 1;", $row_id ) );
	}

	/**
	 * Retrieve a specific column value by the the specified column / value
	 *
	 * @access  public
	 * @since   1.0
	 * @return  string
	 */
	public function get_column_by( $column, $column_where, $column_value ) {
		global $wpdb;
		$column_where = esc_sql( $column_where );
		$column       = esc_sql( $column );
		return $wpdb->get_var( $wpdb->prepare( "SELECT $column FROM $this->table_name WHERE $column_where = %s LIMIT 1;", $column_value ) );
	}

	/**
	 * Insert a new row
	 *
	 * @access  public
	 * @since   1.0
	 * @return  int
	 */
	public function insert( $data, $type = '' ) {
		global $wpdb;

		// Set default values
		$data = wp_parse_args( $data, $this->get_column_defaults() );

		/**
		 * Filters the data array to be used for inserting a new object of a given type.
		 *
		 * The dynamic portion of the hook, `$type`, refers to the data type, such as
		 * 'affiliate', 'creative', 'referral', 'payout', etc.
		 *
		 * Passing a falsey value back via a filter callback will effectively allow
		 * insertion of the new object to be short-circuited. Example:
		 *
		 *     add_filter( 'affwp_zapier_pre_insert_payout_data', '__return_empty_array' );
		 *
		 * @since 1.2
		 *
		 * @param array $data Data to be inserted for the new object.
		 */
		$data = apply_filters( "affwp_zapier_pre_insert_{$type}_data", $data );

		if ( empty( $data ) ) {

			if ( has_filter( "affwp_zapier_pre_insert_{$type}_data" ) ) {
				$message = sprintf( 'affwp_zapier_pre_insert_%1$s_data: The \'%2$s\' object could not be inserted by virtue of lack of data.', $type, $type );
			} else {
				$message = sprintf( 'Affiliate_WP_Zapier_DB::insert(): The \'%1$s\' object could not be inserted by virtue of lack of data.', $type );
			}

			affiliate_wp()->utils->log( $message, $data );

			return false;

		} else {

			/**
			 * Fires immediately before inserting a new object of a given type.
			 *
			 * The dynamic portion of the hook name, `$type`, refers to the data type, such as
			 * 'affiliate', 'creative', 'referral', 'payout', etc.
			 *
			 * @since 1.0
			 *
			 * @param array $data Data to be inserted for the new object.
			 */
			do_action( 'affwp_zapier_pre_insert_' . $type, $data );

			// Initialise column format array
			$column_formats = $this->get_columns();

			// Force fields to lower case
			$data = array_change_key_case( $data );

			// White list columns
			$data = array_intersect_key( $data, $column_formats );

			// Reorder $column_formats to match the order of columns given in $data
			$data_keys      = array_keys( $data );
			$column_formats = array_merge( array_flip( $data_keys ), $column_formats );
			$object_id      = absint( $data['object_id'] );

			$wpdb->insert( $this->table_name, $data, $column_formats );

			/**
			 * Fires immediately following insertion of a new object of a given type.
			 *
			 * The dynamic portion of the hook name, `$type`, refers to the data type, such as
			 * 'affiliate', 'creative', 'referral', 'payout', etc.
			 *
			 * @since 1.0
			 *
			 * @param array $data Data that was inserted for the new object.
			 */
			do_action( 'affwp_zapier_post_insert_' . $type, $wpdb->insert_id, $data );

			return $wpdb->insert_id;
		}
	}

	/**
	 * Update a row
	 *
	 * @access  public
	 * @since   1.0
	 * @return  bool
	 */
	public function update( $row_id, $data = array(), $where = '' ) {

		global $wpdb;

		// Row ID must be positive integer
		$row_id = absint( $row_id );

		if( empty( $row_id ) ) {
			return false;
		}

		if( empty( $where ) ) {
			$where = $this->primary_key;
		}

		// Initialise column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$data = array_change_key_case( $data );

		// White list columns
		$data = array_intersect_key( $data, $column_formats );

		// Reorder $column_formats to match the order of columns given in $data
		$data_keys = array_keys( $data );
		$column_formats = array_merge( array_flip( $data_keys ), $column_formats );

		if ( false === $wpdb->update( $this->table_name, $data, array( $where => $row_id ), $column_formats ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Delete a row identified by the primary key
	 *
	 * @access  public
	 * @since   1.0
	 * @return  bool
	 */
	public function delete( $row_id = 0 ) {

		global $wpdb;

		// Row ID must be positive integer
		$row_id = absint( $row_id );

		if( empty( $row_id ) ) {
			return false;
		}

		if ( false === $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table_name WHERE $this->primary_key = %d", $row_id ) ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if the given table exists
	 *
	 * @since  1.0
	 * @param  string $table The table name
	 * @return bool          If the table name exists
	 */
	public function table_exists( $table ) {
		global $wpdb;
		$table = sanitize_text_field( $table );

		return $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE '%s'", $table ) ) === $table;
	}

}

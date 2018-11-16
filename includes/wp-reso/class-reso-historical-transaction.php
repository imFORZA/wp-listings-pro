<?php
/**
 * RESO History Transactional
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO History Transactional Class.
 *
 * @package wp-reso-history-transactional
 */
class ResoHistoryTransaction {

	/**
	 * Change Type.
	 *
	 * @var mixed
	 * @access private
	 */
	private $change_type;

	/**
	 * Change by Member ID.
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_id;

	/**
	 * Change by Member Key.
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_key;

	/**
	 * Change by Member Key Numeric.
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_key_numeric;

	/**
	 * Class Name.
	 *
	 * @var mixed
	 * @access private
	 */
	private $class_name;

	/**
	 * Field Key.
	 *
	 * @var mixed
	 * @access private
	 */
	private $field_key;

	/**
	 * fieldkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $field_key_numeric;

	/**
	 * Field Name.
	 *
	 * @var mixed
	 * @access private
	 */
	private $field_name;

	/**
	 * historytransactionalkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $history_transactional_key;

	/**
	 * historytransactionalkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $history_transactional_key_numeric;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modification_timestamp;

	/**
	 * newvalue
	 *
	 * @var mixed
	 * @access private
	 */
	private $new_value;

	/**
	 * originatingsystemhistorykey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_history_key;

	/**
	 * originatingsystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_id;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_name;

	/**
	 * previousvalue
	 *
	 * @var mixed
	 * @access private
	 */
	private $previous_value;

	/**
	 * resourcename
	 *
	 * @var mixed
	 * @access private
	 */
	private $resource_name;

	/**
	 * resourcerecordid
	 *
	 * @var mixed
	 * @access private
	 */
	private $resource_record_id;

	/**
	 * resourcerecordkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $resource_record_key;

	/**
	 * resourcerecordkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $resource_record_key_numeric;

	/**
	 * Source System History Key.
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_history_key;

	/**
	 * Source System ID.
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_id;

	/**
	 * Source System Name.
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_name;

	/**
	 * history transactional constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get History Transactional Fields.
	 *
	 * @access public
	 * @return void
	 */
	public function get_history_transactional_fields() {
		return array(
			'changed_by_member_id',
			'changed_by_member_key',
			'changed_by_member_key_numeric',
			'change_type',
			'class_name',
			'field_key',
			'field_key_numeric',
			'field_name',
			'history_transactional_key',
			'history_transactional_key_numeric',
			'modification_timestamp',
			'new_value',
			'originating_system_history_key',
			'originating_system_id',
			'originating_system_name',
			'previous_value',
			'resource_name',
			'resource_record_id',
			'resource_record_key',
			'resource_record_key_numeric',
			'source_system_history_key',
			'source_system_id',
			'source_system_name',
		);
	}
}

<?php
/**
 * RESO Open House
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Open House Class.
 *
 * @package wp-reso-openhouse
 */
class ResoOpenHouse {

	/**
	 * Indicates whether or not the openhouse requires an appointment.
	 *
	 * @var [boolean]
	 */
	private $appointment_required_yn;

	/**
	 * The well known identifier for the listing related to this open house.
	 * the value may be identical to that of the listing key, but the listing id is intended
	 * to be the value used by a human to retrieve the information about a specific listing.
	 * in a multiple originating system or a merged system, this value may not be unique and
	 * may require the use of the provider system to create a synthetic unique value.
	 *
	 * @var [string]
	 */
	private $listing_id;

	/**
	 * A unique identifier for the listing record related to this open house. this may be a number,
	 * or string that can include uri or other forms.  this is the system you are connecting to
	 * and not necessarily the original source of the record. this may be a foreign key from
	 * the resource selected in the resourcename field.
	 *
	 * @var [string]
	 */
	private $listing_key;

	/**
	 * A unique identifier for the listing record related to this open house. this may be a number,
	 * or string that can include uri or other forms.  this is the system you are connecting to
	 * and not necessarily the original source of the record. this may be a foreign key from
	 * the resource selected in the resourcename field.  this is the numeric only key and used
	 * as an alternative to the listingkey field.
	 *
	 * @var [string]
	 */
	private $listing_key_numeric;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modification_timestamp;

	/**
	 * openhouseattendedby
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_attended_by;

	/**
	 * openhousedate
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_date;

	/**
	 * openhouseendtime
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_end_time;

	/**
	 * openhouseid
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_id;

	/**
	 * openhousekey
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_key;

	/**
	 * openhousekeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_key_numeric;

	/**
	 * openhouseremarks
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_remarks;

	/**
	 * openhousestarttime
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_start_time;

	/**
	 * openhousestatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_status;

	/**
	 * openhousetype
	 *
	 * @var mixed
	 * @access private
	 */
	private $openhouse_type;

	/**
	 * originalentrytimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $original_entry_timestamp;

	/**
	 * originatingsystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_id;

	/**
	 * originatingsystemkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_key;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_name;

	/**
	 * refreshments
	 *
	 * @var mixed
	 * @access private
	 */
	private $refreshments;

	/**
	 * showingagentfirstname
	 *
	 * @var mixed
	 * @access private
	 */
	private $showing_agent_first_name;

	/**
	 * showingagentkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $showing_agent_key;

	/**
	 * showingagentkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $showing_agent_key_numeric;

	/**
	 * showingagentlastname
	 *
	 * @var mixed
	 * @access private
	 */
	private $showing_agent_last_name;

	/**
	 * showingagentmlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $showing_agent_mls_id;

	/**
	 * sourcesystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_id;

	/**
	 * sourcesystemkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_key;

	/**
	 * sourcesystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_name;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get all open house fields.
	 *
	 * @access public
	 * @return void
	 */
	public function get_open_house_fields() {
		return array(
			'appointment_required_yn',
			'listing_id',
			'listing_key',
			'listing_key_numeric',
			'modification_timestamp',
			'openhouse_attended_by',
			'openhouse_date',
			'openhouse_endtime',
			'openhouse_id',
			'openhouse_key',
			'openhouse_key_numeric',
			'openhouse_remarks',
			'openhouse_start_time',
			'openhouse_status',
			'openhouse_type',
			'original_entry_timestamp',
			'originating_system_id',
			'originating_system_key',
			'originating_system_name',
			'refreshments',
			'showing-agent_first_name',
			'showing_agent_key',
			'showing_agent_key_numeric',
			'showing_agent_last_name',
			'showing_agentmls_id',
			'source_system_id',
			'source_system_key',
			'source_system_name',
		);
	}

	/**
	 * open_house_remarks function.
	 *
	 * @access public
	 * @param mixed $remarks
	 * @return void
	 */
	public function open_house_remarks( $remarks ) {
		if ( strlen( $remarks ) <= 500 ) {
			return $remarks;
		} else {
			 return new WP_Error( 'Not Valid', __( 'Your remarks is too long, please keep it under 500 characters.', 'wp-reso' ) );
		}

	}
}

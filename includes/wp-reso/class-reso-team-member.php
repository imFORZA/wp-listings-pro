<?php
/**
 * RESO Team Member
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Team Member Class.
 *
 * @package wp-reso-team-member
 */
class ResoTeamMember {

	/**
	 * MemberKey
	 *
	 * @var mixed
	 * @access private
	 * @certlevel Platinum
	 */
	private $member_key;

	/**
	 * MemberKeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_key_numeric;

	/**
	 * MemberLoginId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_login_id;

	/**
	 * MemberMlsId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_mls_id;

	/**
	 * ModificationTimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modification_timestamp;

	/**
	 * OriginalEntryTimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $original_entry_timestamp;

	/**
	 * OriginatingSystemID
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_id;

	/**
	 * OriginatingSystemKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_key;

	/**
	 * OriginatingSystemName
	 *
	 * @var mixed
	 * @access private
	 */
	private $originating_system_name;

	/**
	 * SourceSystemID
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_id;

	/**
	 * SourceSystemKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_key;

	/**
	 * SourceSystemName
	 *
	 * @var mixed
	 * @access private
	 */
	private $source_system_name;

	/**
	 * TeamImpersonationLevel
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_impersonation_level;

	/**
	 * TeamKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_key;

	/**
	 * TeamKeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_key_numeric;

	/**
	 * TeamMemberKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_member_key;

	/**
	 * TeamMemberKeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_member_key_numeric;

	/**
	 * TeamMemberNationalAssociationId
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_member_national_association_id;

	/**
	 * TeamMemberStateLicense
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_member_state_license;

	/**
	 * TeamMemberType
	 *
	 * @var mixed
	 * @access private
	 */
	private $team_member_type;

	/**
	 * Team Member constructor
	 */
	public function __construct() {
	}

	/**
	 * Get Team Member Fields.
	 *
	 * @access public
	 * @return Array of all team member key fields.
	 */
	public function get_available_fields() {
		return array(
			'member_key',
			'member_key_numeric',
			'member_login_id',
			'member_mls_id',
			'modification_timestamp',
			'original_entry_timestamp',
			'originating_system_id',
			'originating_system_key',
			'originating_system_name',
			'source_system_id',
			'source_system_key',
			'source_system_name',
			'team_impersonation_level',
			'team_key',
			'team_key_numeric',
			'team_member_key',
			'team_member_key_numeric',
			'team_member_national_association_id',
			'team_member_state_license',
			'team_member_type',
		);
	}

	/**
	 * Member Key.
	 *
	 * @access public
	 * @param mixed $member_key Member Key.
	 * @return void
	 */
	public function member_key( $member_key ) {

		$sanitized_member_key = sanitize_text_field( $member_key );

		if ( strlen( $sanitized_member_key ) <= 255 ) {
			return $sanitized_member_key;
		} else {
			return new WP_Error( 'invalid length', __( 'Your Member key is too long, please make it 255 characters or less.', 'wp-reso' ) );
			// or wp_trim_words( $sanitized_member_key, $num_words = 255, $more = null );
		}

	}
}

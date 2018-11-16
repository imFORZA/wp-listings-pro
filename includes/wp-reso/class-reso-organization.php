<?php
/**
 * RESO Organization
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Organization Class.
 *
 * @package wp-reso-organization
 */
class ResoOrganization {

	/**
	 * changedbymemberid
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_id;

	/**
	 * changedbymemberkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_key;

	/**
	 * changedbymemberkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $changed_by_member_key_numeric;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modification_timestamp;

	/**
	 * organizationaor
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_aor;

	/**
	 * organizationaddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_address1;

	/**
	 * organizationaddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_address2;

	/**
	 * organizationaorouid
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_aor_ouid;

	/**
	 * organizationaorouidkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_aor_ouid_key;

	/**
	 * organizationaorouidkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_aor_ouid_key_numeric;

	/**
	 * organizationcarrierroute
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_carrier_route;

	/**
	 * organizationcity
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_city;

	/**
	 * organizationcomments
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_comments;

	/**
	 * organizationcontactemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_email;

	/**
	 * organizationcontactfax
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_fax;

	/**
	 * organizationcontactfirstname
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_first_name;

	/**
	 * organizationcontactfullname
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_full_name;

	/**
	 * organizationcontactjobtitle
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_job_title;

	/**
	 * organizationcontactlastname
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_last_name;

	/**
	 * organizationcontactmiddlename
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_middle_name;

	/**
	 * organizationcontactnameprefix
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_name_prefix;

	/**
	 * organizationcontactnamesuffix
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_name_suffix;

	/**
	 * organizationcontactphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_phone;

	/**
	 * organizationcontactphoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_contact_phone_ext;

	/**
	 * organizationcountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_country;

	/**
	 * organizationcountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_countyorparish;

	/**
	 * organizationmembercount
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_membercount;

	/**
	 * organizationmlscode
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_mlscode;

	/**
	 * organizationmlsvendorname
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_mlsvendorname;

	/**
	 * organizationmlsvendorouid
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_mlsvendorouid;

	/**
	 * organizationname
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_name;

	/**
	 * organizationnationalassociationid
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_nationalassociationid;

	/**
	 * organizationpostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_postalcode;

	/**
	 * organizationpostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_postalcodeplus4;

	/**
	 * organizationsocialmedia
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_socialmedia;

	/**
	 * organizationsocialmediatype
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_socialmediatype;

	/**
	 * organizationstatelicense
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_statelicense;

	/**
	 * organizationstatelicensestate
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_statelicensestate;

	/**
	 * organizationstateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_stateorprovince;

	/**
	 * organizationstatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_status;

	/**
	 * organizationstatuschangetimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_statuschangetimestamp;

	/**
	 * organizationtype
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_type;

	/**
	 * organizationuniqueid
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_uniqueid;

	/**
	 * organizationuniqueidkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_uniqueidkey;

	/**
	 * organizationuniqueidkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $organization_uniqueidkeynumeric;

	/**
	 * originalentrytimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $originalentrytimestamp;

	/**
	 * organization constructor
	 */
	public function __construct() {
	}

	/**
	 * get_ouid_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_ouid_fields() {
		return array(
			'changed_by_member_id',
			'changed_by_member_key',
			'changed_by_member_key_numeric',
			'modification_timestamp',
			'organization_address1',
			'organization_address2',
			'organization_aor',
			'organization_aorouid',
			'organization_aorouidkey',
			'organization_aorouidkeynumeric',
			'organization_carrierroute',
			'organization_city',
			'organization_comments',
			'organization_contactemail',
			'organization_contactfax',
			'organization_contactfirstname',
			'organization_contactfullname',
			'organization_contactjobtitle',
			'organization_contactlastname',
			'organization_contactmiddlename',
			'organization_contactnameprefix',
			'organization_contactnamesuffix',
			'organization_contactphoneext',
			'organization_contactphone',
			'organization_country',
			'organization_countyorparish',
			'organization_membercount',
			'organization_mlscode',
			'organization_mlsvendorname',
			'organization_mlsvendorouid',
			'organization_name',
			'organization_nationalassociationid',
			'organization_postalcode',
			'organization_postalcodeplus4',
			'organization_socialmedia[type]urlorid',
			'organization_socialmediatype',
			'organization_statelicense',
			'organization_statelicensestate',
			'organization_stateorprovince',
			'organization_statuschangetimestamp',
			'organization_status',
			'organization_type',
			'organization_uniqueid',
			'organization_uniqueidkey',
			'organization_uniqueidkeynumeric',
			'original_entry_timestamp',
		);
	}
}

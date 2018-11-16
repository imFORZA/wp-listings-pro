<?php
/**
 * RESO Contact
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Contact Class.
 *
 * @package wp-reso-contact
 */
class ResoContact {

	/**
	 * anniversary
	 *
	 * @var mixed
	 * @access private
	 */
	private $anniversary;

	/**
	 * assistantemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $assistant_email;

	/**
	 * assistantname
	 *
	 * @var mixed
	 * @access private
	 */
	private $assistant_name;

	/**
	 * assistantphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $assistant_phone;

	/**
	 * assistantphoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $assistant_phone_ext;

	/**
	 * birthdate
	 *
	 * @var mixed
	 * @access private
	 */
	private $birthdate;

	/**
	 * businessfax
	 *
	 * @var mixed
	 * @access private
	 */
	private $business_fax;

	/**
	 * children
	 *
	 * @var mixed
	 * @access private
	 */
	private $children;

	/**
	 * company
	 *
	 * @var mixed
	 * @access private
	 */
	private $company;

	/**
	 * contactkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_key;

	/**
	 * contactkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_key_numeric;

	/**
	 * contactloginid
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_login_id;

	/**
	 * contactpassword
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_password;

	/**
	 * contactstatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_status;

	/**
	 * contacttype
	 *
	 * @var mixed
	 * @access private
	 */
	private $contact_type;

	/**
	 * department
	 *
	 * @var mixed
	 * @access private
	 */
	private $department;

	/**
	 * directphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $direct_phone;

	/**
	 * email
	 *
	 * @var mixed
	 * @access private
	 */
	private $email;

	/**
	 * email2
	 *
	 * @var mixed
	 * @access private
	 */
	private $email2;

	/**
	 * email3
	 *
	 * @var mixed
	 * @access private
	 */
	private $email3;

	/**
	 * firstname
	 *
	 * @var mixed
	 * @access private
	 */
	private $first_name;

	/**
	 * fullname
	 *
	 * @var mixed
	 * @access private
	 */
	private $full_name;

	/**
	 * gender
	 *
	 * @var mixed
	 * @access private
	 */
	private $gender;

	/**
	 * groups
	 *
	 * @var mixed
	 * @access private
	 */
	private $groups;

	/**
	 * homeaddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_address1;

	/**
	 * homeaddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_address2;

	/**
	 * homecarrierroute
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_carrier_route;

	/**
	 * homecity
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_city;

	/**
	 * homecountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_country;

	/**
	 * homecountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_county_or_parish;

	/**
	 * homefax
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_fax;

	/**
	 * homephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_phone;

	/**
	 * homepostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_postalcode;

	/**
	 * homepostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_postalcode_plus4;

	/**
	 * homestateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $home_state_or_province;

	/**
	 * jobtitle
	 *
	 * @var mixed
	 * @access private
	 */
	private $job_title;

	/**
	 * language
	 *
	 * @var mixed
	 * @access private
	 */
	private $language;

	/**
	 * lastname
	 *
	 * @var mixed
	 * @access private
	 */
	private $last_name;

	/**
	 * middlename
	 *
	 * @var mixed
	 * @access private
	 */
	private $middle_name;

	/**
	 * mobilephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $mobile_phone;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modification_timestamp;

	/**
	 * nameprefix
	 *
	 * @var mixed
	 * @access private
	 */
	private $name_prefix;

	/**
	 * namesuffix
	 *
	 * @var mixed
	 * @access private
	 */
	private $name_suffix;

	/**
	 * nickname
	 *
	 * @var mixed
	 * @access private
	 */
	private $nickname;

	/**
	 * notes
	 *
	 * @var mixed
	 * @access private
	 */
	private $notes;

	/**
	 * officephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $officephone;

	/**
	 * officephoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $officephoneext;

	/**
	 * originalentrytimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $originalentrytimestamp;

	/**
	 * originatingsystemcontactkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemcontactkey;

	/**
	 * originatingsystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemid;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemname;

	/**
	 * otheraddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $otheraddress1;

	/**
	 * otheraddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $otheraddress2;

	/**
	 * othercarrierroute
	 *
	 * @var mixed
	 * @access private
	 */
	private $othercarrierroute;

	/**
	 * othercity
	 *
	 * @var mixed
	 * @access private
	 */
	private $othercity;

	/**
	 * othercountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $othercountry;

	/**
	 * othercountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $othercountyorparish;

	/**
	 * otherphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $otherphone;

	/**
	 * otherphonetype
	 *
	 * @var mixed
	 * @access private
	 */
	private $otherphonetype;

	/**
	 * otherpostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $otherpostalcode;

	/**
	 * otherpostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $otherpostalcodeplus4;

	/**
	 * otherstateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $otherstateorprovince;

	/**
	 * ownermemberid
	 *
	 * @var mixed
	 * @access private
	 */
	private $ownermemberid;

	/**
	 * ownermemberkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $ownermemberkey;

	/**
	 * ownermemberkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $ownermemberkeynumeric;

	/**
	 * pager
	 *
	 * @var mixed
	 * @access private
	 */
	private $pager;

	/**
	 * phonettyttd
	 *
	 * @var mixed
	 * @access private
	 */
	private $phonettyttd;

	/**
	 * preferredaddress
	 *
	 * @var mixed
	 * @access private
	 */
	private $preferredaddress;

	/**
	 * preferredphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $preferredphone;

	/**
	 * referredby
	 *
	 * @var mixed
	 * @access private
	 */
	private $referredby;

	/**
	 * socialmedia
	 *
	 * @var mixed
	 * @access private
	 */
	private $socialmedia;

	/**
	 * socialmediatype
	 *
	 * @var mixed
	 * @access private
	 */
	private $socialmediatype;

	/**
	 * sourcesystemcontactkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemcontactkey;

	/**
	 * sourcesystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemid;

	/**
	 * sourcesystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemname;

	/**
	 * spousepartnername
	 *
	 * @var mixed
	 * @access private
	 */
	private $spousepartnername;

	/**
	 * tollfreephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $tollfreephone;

	/**
	 * userdefinedfieldname
	 *
	 * @var mixed
	 * @access private
	 */
	private $userdefinedfieldname;

	/**
	 * userdefinedfieldvalue
	 *
	 * @var mixed
	 * @access private
	 */
	private $userdefinedfieldvalue;

	/**
	 * voicemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $voicemail;

	/**
	 * voicemailext
	 *
	 * @var mixed
	 * @access private
	 */
	private $voicemailext;

	/**
	 * workaddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $workaddress1;

	/**
	 * workaddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $workaddress2;

	/**
	 * workcarrierroute
	 *
	 * @var mixed
	 * @access private
	 */
	private $workcarrierroute;

	/**
	 * workcity
	 *
	 * @var mixed
	 * @access private
	 */
	private $workcity;

	/**
	 * workcountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $workcountry;

	/**
	 * workcountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $workcountyorparish;

	/**
	 * workpostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $workpostalcode;

	/**
	 * workpostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $workpostalcodeplus4;

	/**
	 * workstateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $workstateorprovince;

	/**
	 * contact constructor
	 */
	public function __construct() {
	}

	/**
	 * get_contacts_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_contacts_fields() {
		return array(
			'anniversary',
			'assistantemail',
			'assistantname',
			'assistantphoneext',
			'assistantphone',
			'birthdate',
			'businessfax',
			'children',
			'company',
			'contactkey',
			'contactkeynumeric',
			'contactloginid',
			'contactpassword',
			'contactstatus',
			'contacttype',
			'department',
			'directphone',
			'email2',
			'email3',
			'email',
			'firstname',
			'fullname',
			'gender',
			'groups',
			'homeaddress1',
			'homeaddress2',
			'homecarrierroute',
			'homecity',
			'homecountry',
			'homecountyorparish',
			'homefax',
			'homephone',
			'homepostalcode',
			'homepostalcodeplus4',
			'homestateorprovince',
			'jobtitle',
			'language',
			'lastname',
			'middlename',
			'mobilephone',
			'modificationtimestamp',
			'nameprefix',
			'namesuffix',
			'nickname',
			'notes',
			'officephone',
			'officephoneext',
			'originalentrytimestamp',
			'originatingsystemcontactkey',
			'originatingsystemid',
			'originatingsystemname',
			'otheraddress1',
			'otheraddress2',
			'othercarrierroute',
			'othercity',
			'othercountry',
			'othercountyorparish',
			'otherphone[type]ext',
			'otherphone[type]number',
			'otherphonetype',
			'otherpostalcode',
			'otherpostalcodeplus4',
			'otherstateorprovince',
			'ownermemberid',
			'ownermemberkey',
			'ownermemberkeynumeric',
			'pager',
			'phonettyttd',
			'preferredaddress',
			'preferredphone',
			'referredby',
			'socialmedia[type]urlorid',
			'socialmediatype',
			'sourcesystemcontactkey',
			'sourcesystemid',
			'sourcesystemname',
			'spousepartnername',
			'tollfreephone',
			'userdefinedfieldname[#]',
			'userdefinedfieldvalue[#]',
			'voicemailext',
			'voicemail',
			'workaddress1',
			'workaddress2',
			'workcarrierroute',
			'workcity',
			'workcountry',
			'workcountyorparish',
			'workpostalcode',
			'workpostalcodeplus4',
			'workstateorprovince',
		);
	}
}

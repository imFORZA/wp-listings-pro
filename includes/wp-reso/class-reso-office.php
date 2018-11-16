<?php
/**
 * RESO Office
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Office Class.
 *
 * @package wp-reso-office
 */
class ResoOffice {

	/**
	 * franchiseaffiliation
	 *
	 * @var mixed
	 * @access private
	 */
	private $franchiseaffiliation;

	/**
	 * idxofficeparticipationyn
	 *
	 * @var mixed
	 * @access private
	 */
	private $idxofficeparticipationyn;

	/**
	 * mainofficekey
	 *
	 * @var mixed
	 * @access private
	 */
	private $mainofficekey;

	/**
	 * mainofficekeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $mainofficekeynumeric;

	/**
	 * mainofficemlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $mainofficemlsid;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modificationtimestamp;

	/**
	 * officeaor
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_aor;

	/**
	 * officeaormlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_aormlsid;

	/**
	 * officeaorkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_aorkey;

	/**
	 * officeaorkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_aorkeynumeric;

	/**
	 * officeaddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_address1;

	/**
	 * officeaddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_address2;

	/**
	 * officeassociationcomments
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_associationcomments;

	/**
	 * officebranchtype
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_branchtype;

	/**
	 * officebrokerkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_brokerkey;

	/**
	 * officebrokerkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_brokerkeynumeric;

	/**
	 * officebrokermlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_brokermlsid;

	/**
	 * officecity
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_city;

	/**
	 * officecorporatelicense
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_corporatelicense;

	/**
	 * officecountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_countyorparish;

	/**
	 * officeemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_email;

	/**
	 * officefax
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_fax;

	/**
	 * officekey
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_key;

	/**
	 * officekeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_keynumeric;

	/**
	 * officemanagerkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_managerkey;

	/**
	 * officemanagerkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_managerkeynumeric;

	/**
	 * officemanagermlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_managermlsid;

	/**
	 * officemlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_mlsid;

	/**
	 * officename
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_name;

	/**
	 * officenationalassociationid
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_nationalassociationid;

	/**
	 * officephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_phone;

	/**
	 * officephoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_phoneext;

	/**
	 * officepostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_postalcode;

	/**
	 * officepostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_postalcodeplus4;

	/**
	 * officestateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_stateorprovince;

	/**
	 * officestatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_status;

	/**
	 * officetype
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_type;

	/**
	 * originalentrytimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $originalentrytimestamp;

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
	 * originatingsystemofficekey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemofficekey;

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
	 * sourcesystemofficekey
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemofficekey;

	/**
	 * syndicateagentoption
	 *
	 * @var mixed
	 * @access private
	 */
	private $syndicateagentoption;

	/**
	 * syndicateto
	 *
	 * @var mixed
	 * @access private
	 */
	private $syndicateto;

	/**
	 * office constructor
	 */
	public function __construct() {
	}

	/**
	 * get_office_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_office_fields() {
		return array(
			'franchiseaffiliation',
			'idxofficeparticipationyn',
			'mainofficekey',
			'mainofficekeynumeric',
			'mainofficemlsid',
			'modificationtimestamp',
			'office_address1',
			'office_address2',
			'office_aor',
			'office_aorkey',
			'office_aorkeynumeric',
			'office_aormlsid',
			'office_associationcomments',
			'office_branchtype',
			'office_brokerkey',
			'office_brokerkeynumeric',
			'office_brokermlsid',
			'office_city',
			'office_corporatelicense',
			'office_countyorparish',
			'office_email',
			'office_fax',
			'office_key',
			'office_keynumeric',
			'office_managerkey',
			'office_managerkeynumeric',
			'office_managermlsid',
			'office_mlsid',
			'office_name',
			'office_nationalassociationid',
			'office_phoneext',
			'office_phone',
			'office_postalcode',
			'office_postalcodeplus4',
			'office_stateorprovince',
			'office_status',
			'office_type',
			'originalentrytimestamp',
			'originatingsystemid',
			'originatingsystemname',
			'originatingsystemofficekey',
			'socialmedia[type]urlorid',
			'socialmediatype',
			'sourcesystemid',
			'sourcesystemname',
			'sourcesystemofficekey',
			'syndicateagentoption',
			'syndicateto',
		);
	}
}

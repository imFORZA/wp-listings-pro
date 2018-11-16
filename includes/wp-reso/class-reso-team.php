<?php
/**
 * RESO Team
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Team Class.
 *
 * @package wp-reso-team-member
 */
class ResoTeam {

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modificationtimestamp;

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
	 * originatingsystemkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemkey;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemname;

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
	 * sourcesystemkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemkey;

	/**
	 * sourcesystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemname;

	/**
	 * teamaddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamaddress1;

	/**
	 * teamaddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamaddress2;

	/**
	 * teamcarrierroute
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamcarrierroute;

	/**
	 * teamcity
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamcity;

	/**
	 * teamcountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamcountry;

	/**
	 * teamcountyorparish
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamcountyorparish;

	/**
	 * teamdescription
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamdescription;

	/**
	 * teamdirectphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamdirectphone;

	/**
	 * teamemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamemail;

	/**
	 * teamfax
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamfax;

	/**
	 * teamkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamkey;

	/**
	 * teamkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamkeynumeric;

	/**
	 * teamleadkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadkey;

	/**
	 * teamleadkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadkeynumeric;

	/**
	 * teamleadloginid
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadloginid;

	/**
	 * teamleadmlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadmlsid;

	/**
	 * teamleadnationalassociationid
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadnationalassociationid;

	/**
	 * teamleadstatelicense
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadstatelicense;

	/**
	 * teamleadstatelicensestate
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamleadstatelicensestate;

	/**
	 * teammobilephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $teammobilephone;

	/**
	 * teamname
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamname;

	/**
	 * teamofficephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamofficephone;

	/**
	 * teamofficephoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamofficephoneext;

	/**
	 * teampostalcode
	 *
	 * @var mixed
	 * @access private
	 */
	private $teampostalcode;

	/**
	 * teampostalcodeplus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $teampostalcodeplus4;

	/**
	 * teampreferredphone
	 *
	 * @var mixed
	 * @access private
	 */
	private $teampreferredphone;

	/**
	 * teampreferredphoneext
	 *
	 * @var mixed
	 * @access private
	 */
	private $teampreferredphoneext;

	/**
	 * teamstateorprovince
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamstateorprovince;

	/**
	 * teamstatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamstatus;

	/**
	 * teamtollfreephone
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamtollfreephone;

	/**
	 * teamvoicemail
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamvoicemail;

	/**
	 * teamvoicemailext
	 *
	 * @var mixed
	 * @access private
	 */
	private $teamvoicemailext;

	/**
	 * team constructor
	 */
	public function __construct() {
	}

	public function get_teams_fields() {
		return array(
			'modificationtimestamp',
			'originalentrytimestamp',
			'originatingsystemid',
			'originatingsystemkey',
			'originatingsystemname',
			'socialmedia[type]urlorid',
			'socialmediatype',
			'sourcesystemid',
			'sourcesystemkey',
			'sourcesystemname',
			'teamaddress1',
			'teamaddress2',
			'teamcarrierroute',
			'teamcity',
			'teamcountry',
			'teamcountyorparish',
			'teamdescription',
			'teamdirectphone',
			'teamemail',
			'teamfax',
			'teamkey',
			'teamkeynumeric',
			'teamleadkey',
			'teamleadkeynumeric',
			'teamleadloginid',
			'teamleadmlsid',
			'teamleadnationalassociationid',
			'teamleadstatelicense',
			'teamleadstatelicensestate',
			'teammobilephone',
			'teamname',
			'teamofficephoneext',
			'teamofficephone',
			'teampostalcode',
			'teampostalcodeplus4',
			'teampreferredphoneext',
			'teampreferredphone',
			'teamstateorprovince',
			'teamstatus',
			'teamtollfreephone',
			'teamvoicemailext',
			'teamvoicemail',
		);
	}


}

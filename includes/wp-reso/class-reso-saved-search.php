<?php
/**
 * RESO Saved Search
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Saved Search Class.
 *
 * @package wp-reso-saved-search
 */
class ResoSavedSearch {

	/**
	 * classname
	 *
	 * @var mixed
	 * @access private
	 */
	private $classname;

	/**
	 * memberkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $memberkey;

	/**
	 * memberkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $memberkeynumeric;

	/**
	 * membermlsid
	 *
	 * @var mixed
	 * @access private
	 */
	private $membermlsid;

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
	 * originatingsystemmemberkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemmemberkey;

	/**
	 * originatingsystemmembername
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemmembername;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemname;

	/**
	 * resourcename
	 *
	 * @var mixed
	 * @access private
	 */
	private $resourcename;

	/**
	 * savedsearchdescription
	 *
	 * @var mixed
	 * @access private
	 */
	private $savedsearchdescription;

	/**
	 * savedsearchkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $savedsearchkey;

	/**
	 * savedsearchkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $savedsearchkeynumeric;

	/**
	 * savedsearchname
	 *
	 * @var mixed
	 * @access private
	 */
	private $savedsearchname;

	/**
	 * savedsearchtype
	 *
	 * @var mixed
	 * @access private
	 */
	private $savedsearchtype;

	/**
	 * searchquery
	 *
	 * @var mixed
	 * @access private
	 */
	private $searchquery;

	/**
	 * searchqueryexceptiondetails
	 *
	 * @var mixed
	 * @access private
	 */
	private $searchqueryexceptiondetails;

	/**
	 * searchqueryexceptions
	 *
	 * @var mixed
	 * @access private
	 */
	private $searchqueryexceptions;

	/**
	 * searchqueryhumanreadable
	 *
	 * @var mixed
	 * @access private
	 */
	private $searchqueryhumanreadable;

	/**
	 * searchquerytype
	 *
	 * @var mixed
	 * @access private
	 */
	private $searchquerytype;

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
	 * saved search constructor
	 */
	public function __construct() {
	}

	/**
	 * get_saved_search_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_saved_search_fields() {
		return array(
			'classname',
			'memberkey',
			'memberkeynumeric',
			'membermlsid',
			'modificationtimestamp',
			'originalentrytimestamp',
			'originatingsystemid',
			'originatingsystemkey',
			'originatingsystemmemberkey',
			'originatingsystemmembername',
			'originatingsystemname',
			'resourcename',
			'savedsearchdescription',
			'savedsearchkey',
			'savedsearchkeynumeric',
			'savedsearchname',
			'savedsearchtype',
			'searchqueryexceptiondetails',
			'searchqueryexceptions',
			'searchquery',
			'searchqueryhumanreadable',
			'searchquerytype',
			'sourcesystemid',
			'sourcesystemkey',
			'sourcesystemname',
		);
	}
}

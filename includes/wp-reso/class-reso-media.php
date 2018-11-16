<?php
/**
 * RESO Media
 *
 * @package wp-reso
 */

	// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }


/**
 * RESO Media Class.
 *
 * @package wp-reso-media
 */
class ResoMedia {

	/**
	 * changedbymemberid
	 *
	 * @var mixed
	 * @access private
	 */
	private $changedbymemberid;

	/**
	 * changedbymemberkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $changedbymemberkey;

	/**
	 * changedbymemberkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $changedbymemberkeynumeric;

	/**
	 * classname
	 *
	 * @var mixed
	 * @access private
	 */
	private $classname;

	/**
	 * group
	 *
	 * @var mixed
	 * @access private
	 */
	private $group;

	/**
	 * imageheight
	 *
	 * @var mixed
	 * @access private
	 */
	private $imageheight;

	/**
	 * imageof
	 *
	 * @var mixed
	 * @access private
	 */
	private $imageof;

	/**
	 * imagesizedescription
	 *
	 * @var mixed
	 * @access private
	 */
	private $imagesizedescription;

	/**
	 * imagewidth
	 *
	 * @var mixed
	 * @access private
	 */
	private $imagewidth;

	/**
	 * longdescription
	 *
	 * @var mixed
	 * @access private
	 */
	private $longdescription;

	/**
	 * mediacategory
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediacategory;

	/**
	 * mediahtml
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediahtml;

	/**
	 * mediakey
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediakey;

	/**
	 * mediakeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediakeynumeric;

	/**
	 * mediamodificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediamodificationtimestamp;

	/**
	 * mediaobjectid
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediaobjectid;

	/**
	 * mediastatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediastatus;

	/**
	 * mediatype
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediatype;

	/**
	 * mediaurl
	 *
	 * @var mixed
	 * @access private
	 */
	private $mediaurl;

	/**
	 * modificationtimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $modificationtimestamp;

	/**
	 * order
	 *
	 * @var mixed
	 * @access private
	 */
	private $order;

	/**
	 * originatingsystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemid;

	/**
	 * originatingsystemmediakey
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemmediakey;

	/**
	 * originatingsystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $originatingsystemname;

	/**
	 * permission
	 *
	 * @var mixed
	 * @access private
	 */
	private $permission;

	/**
	 * preferredphotoyn
	 *
	 * @var mixed
	 * @access private
	 */
	private $preferredphotoyn;

	/**
	 * resourcename
	 *
	 * @var mixed
	 * @access private
	 */
	private $resourcename;

	/**
	 * resourcerecordid
	 *
	 * @var mixed
	 * @access private
	 */
	private $resourcerecordid;

	/**
	 * resourcerecordkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $resourcerecordkey;

	/**
	 * resourcerecordkeynumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $resourcerecordkeynumeric;

	/**
	 * shortdescription
	 *
	 * @var mixed
	 * @access private
	 */
	private $shortdescription;

	/**
	 * sourcesystemid
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemid;

	/**
	 * sourcesystemmediakey
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemmediakey;

	/**
	 * sourcesystemname
	 *
	 * @var mixed
	 * @access private
	 */
	private $sourcesystemname;

	/**
	 * media constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * get_media_resource_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_media_resource_fields() {
		return array(
			'changedbymemberid',
			'changedbymemberkey',
			'changedbymemberkeynumeric',
			'classname',
			'group',
			'imageheight',
			'imageof',
			'imagesizedescription',
			'imagewidth',
			'longdescription',
			'mediacategory',
			'mediahtml',
			'mediakey',
			'mediakeynumeric',
			'mediamodificationtimestamp',
			'mediaobjectid',
			'mediastatus',
			'mediatype',
			'mediaurl',
			'modificationtimestamp',
			'order',
			'originatingsystemid',
			'originatingsystemmediakey',
			'originatingsystemname',
			'permission',
			'preferredphotoyn',
			'resourcename',
			'resourcerecordid',
			'resourcerecordkey',
			'resourcerecordkeynumeric',
			'shortdescription',
			'sourcesystemid',
			'sourcesystemmediakey',
			'sourcesystemname',
		);
	}
}

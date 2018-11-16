<?php
/**
 * RESO Certifications
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }


/**
 * ResoCerts class.
 */
class ResoCerts {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get Data Dictionary Certification Levels.
	 *
	 * @access public
	 * @return void
	 */
	public function get_cert_levels() {
		return array(
			__( 'Core', 'wp-reso' ),
			__( 'Bronze', 'wp-reso' ),
			__( 'Silver', 'wp-reso' ),
			__( 'Gold', 'wp-reso' ),
			__( 'Platinum', 'wp-reso' ),
		);
	}

}

<?php
/**
 * WP RESO.
 *
 * @package WP-Reso
 */
/**
 * Plugin Name: WP RESO
 * Plugin URI: https://github.com/imFORZA/wp-reso
 * Description: A WordPress class for the RESO standard.
 * Author: imFORZA
 * Author URI: https://www.imforza.com
 * Text Domain: wp-reso
 *
 * Version: 1.0.0
 *
 * License: GNU General Public License v3.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

/**
 * Get Current Data Dictionary Versions.
 *
 * @access public
 * @return void
 */
function get_data_dictionary_version() {
	return '1.5';
}

/**
 * Get array of all Data Dictionary Versions.
 *
 * @access public
 * @return void
 */
function get_all_data_dictionary_versions() {
	return array(
		'1.5',
		'1.4',
	);
}

/* Include all of our classes. */
require_once 'class-reso-contact.php';
require_once 'class-reso-historical-transaction.php';
require_once 'class-reso-lookups.php';
/*
include_once('class-reso-media.php');
include_once('class-reso-member.php');
include_once('class-reso-office.php');
include_once('class-reso-open-house.php');
include_once('class-reso-organization.php');
include_once('class-reso-property.php');
include_once('class-reso-saved-search.php');
include_once('class-reso-team-member.php');
include_once('class-reso-team.php');
*/


<?php
/**
 * REST API for retirement calculator.
 *
 * @package retirement-calc
 */
/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
add_action( 'rest_api_init', function () {
	register_rest_route( 'wp-listings-pro/v1', 'delete-listing/', array(
		'methods'	 => 'POST',
		'callback' => 'wplpro_send_delete_listing',
	));
} );

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp-listings-pro/v1', 'import-listings/', array(
		'methods'	 => 'GET',
		'callback' => 'wplpro_send_listings',
	));
} );

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_send_delete_listing( $data ) {
	return rest_ensure_response( wp_listings_idx_listing_delete($data['id']) );
}

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_send_listings( $data ) {
	return rest_ensure_response( WPL_Idx_Listing::wp_listings_idx_create_post( explode("z",$data['mlses']) ) );
}

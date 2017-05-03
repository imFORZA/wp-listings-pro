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

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp-listings-pro/v1', 'sync-all/', array(
		'methods'	 => 'GET',
		'callback' => 'wplpro_sync_listings_and_agents',
	));
} );

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_send_delete_listing( $data ) {
	return rest_ensure_response( wp_listings_idx_listing_delete( $data['id'] ) );
}

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_send_listings( $data ) {
	return rest_ensure_response( WPL_Idx_Listing::wp_listings_idx_create_post( explode( 'z',$data['mlses'] ) ) );
}

function wplpro_sync_listings_and_agents( $data ) {
	WPLPRO_Agents_Import::wplpro_agents_update_post();
	WPL_Idx_Listing::wp_listings_update_post();

	// Can take an unreasonable amount of time to get here, should force it to use WP Background Processing
	return rest_ensure_response( 'success' );
}

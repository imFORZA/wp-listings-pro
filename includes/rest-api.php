<?php
/**
 * REST API for retirement calculator.
 *
 * @package retirement-calc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// TODO Just use Delete method on /listings.
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'wp-listings-pro/v1',
			'delete-listing/',
			array(
				'methods'             => 'POST',
				'callback'            => 'wplpro_rest_delete_listing',
				'permission_callback' => 'wplpro_rest_permission_check',
			)
		);
	}
);

// TODO Just use Put/Post method on /listings.
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'wp-listings-pro/v1',
			'import-listings/',
			array(
				'methods'             => 'GET',
				'callback'            => 'wplpro_rest_import_listings',
				'permission_callback' => 'wplpro_rest_permission_check',
			)
		);
	}
);

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'wp-listings-pro/v1',
			'sync-all/',
			array(
				'methods'             => 'GET',
				'callback'            => 'wplpro_sync_listings_and_agents',
				'permission_callback' => 'wplpro_rest_permission_check',
			)
		);
	}
);

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_rest_delete_listing( $data ) {
	return rest_ensure_response( wp_listings_idx_listing_delete( $data['id'] ) );
}

/**
 * REST api call, returns formatted html block
 *
 * @param  array $data  array block of data.
 * @return string       Formatted HTML block
 */
function wplpro_rest_import_listings( $data ) {
	return rest_ensure_response( WPLPROIdxListing::wp_listings_idx_create_post( explode( ',', $data['mlses'] ) ) );
}

/**
 * Sync Listings and Agents.
 *
 * @access public
 * @param mixed $data Data.
 * @return Rest Response.
 */
function wplpro_sync_listings_and_agents( $data ) {
	wplpro_clear_transient_cache();
	WPLPROAgentsImport::WPLPROAgents_update_post();
	WPLPROIdxListing::wp_listings_update_post();

	// Can take an unreasonable amount of time to get here, should force it to use WP Background Processing.
	return rest_ensure_response( 'success' );
}

/**
 * wplpro_rest_permission_check function.
 *
 * @access public
 * @return void
 */
function wplpro_rest_permission_check() {
	return current_user_can( 'edit_posts' );
}

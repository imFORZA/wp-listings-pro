<?php



register_meta(
	'listing',
	'_listing_sync_update',
	array(
		'sanitize_callback' => 'sanitize_listing_sync_update',
		'auth_callback'     => 'authorize_listing_sync_update',
		'type'              => 'string',
		'description'       => __( 'My registered meta key', 'wp-listings-pro' ),
		'single'            => true,
		'show_in_rest'      => true,
	)
);


function authorize_listing_sync_update() {

}

function sanitize_listing_sync_update() {

}

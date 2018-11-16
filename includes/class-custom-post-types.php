<?php

if ( ! function_exists( 'listing_country_cpt' ) ) {

	// Register Custom Post Type
	function listing_country_cpt() {

		$labels = array(
			'name'                      => _x( 'Countries', 'Post Type General Name', 'wp-listing-pro' ),
			'singular_name'             => _x( 'Country', 'Post Type Singular Name', 'wp-listing-pro' ),
			'menu_name'                 => __( 'Countries', 'wp-listing-pro' ),
			'name_admin_bar'            => __( 'Countries', 'wp-listing-pro' ),
			'archives'                  => __( 'Country Archives', 'wp-listing-pro' ),
			'attributes'                => __( 'Country Attributes', 'wp-listing-pro' ),
			'parent_Country_colon'      => __( 'Parent Country:', 'wp-listing-pro' ),
			'all_Countries'             => __( 'All Countries', 'wp-listing-pro' ),
			'add_new_Country'           => __( 'Add New Country', 'wp-listing-pro' ),
			'add_new'                   => __( 'Add New', 'wp-listing-pro' ),
			'new_Country'               => __( 'New Country', 'wp-listing-pro' ),
			'edit_Country'              => __( 'Edit Country', 'wp-listing-pro' ),
			'update_Country'            => __( 'Update Country', 'wp-listing-pro' ),
			'view_Country'              => __( 'View Country', 'wp-listing-pro' ),
			'view_Countries'            => __( 'View Countries', 'wp-listing-pro' ),
			'search_Countries'          => __( 'Search Country', 'wp-listing-pro' ),
			'not_found'                 => __( 'Not found', 'wp-listing-pro' ),
			'not_found_in_trash'        => __( 'Not found in Trash', 'wp-listing-pro' ),
			'featured_image'            => __( 'Featured Country Image', 'wp-listing-pro' ),
			'set_featured_image'        => __( 'Set Featured Country Image', 'wp-listing-pro' ),
			'remove_featured_image'     => __( 'Remove Featured Country Image', 'wp-listing-pro' ),
			'use_featured_image'        => __( 'Use as Featured Country Image', 'wp-listing-pro' ),
			'insert_into_Country'       => __( 'Insert into Country', 'wp-listing-pro' ),
			'uploaded_to_this_Country'  => __( 'Uploaded to this Country', 'wp-listing-pro' ),
			'Countries_list'            => __( 'Countries list', 'wp-listing-pro' ),
			'Countries_list_navigation' => __( 'Countries list navigation', 'wp-listing-pro' ),
			'filter_Countries_list'     => __( 'Filter Countries list', 'wp-listing-pro' ),
		);
		$args   = array(
			'label'               => __( 'Country', 'wp-listing-pro' ),
			'description'         => __( 'The country for listing or agents.', 'wp-listing-pro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-location',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'rest_base'           => 'country',
		);
		register_post_type( 'country', $args );

	}
	add_action( 'init', 'listing_country_cpt', 0 );

}


function import_reso_countries() {

	$lookups = new ResoLookupFieldValues();

	$countries = $lookups->country();

	foreach ( $countries as $country ) {

		$country_args = array(
			'post_title'  => $country,
			'post_status' => 'publish',
			'post_type'   => 'country',
		);

		// Insert the post into the database.
		wp_insert_post( $country_args );

	}

}
// add_action( 'wp_head', 'import_reso_countries' );



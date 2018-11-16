<?php
/**
 * Saved Searches.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wplpro_saved_searches' ) ) {

	/**
	 * Register Saved Searches CPT.
	 *
	 * @access public
	 * @return void
	 */
	function wplpro_saved_searches() {

		$labels   = array(
			'name'                  => _x( 'Saved Searches', 'Post Type General Name', 'wp-listings-pro' ),
			'singular_name'         => _x( 'Saved Search', 'Post Type Singular Name', 'wp-listings-pro' ),
			'menu_name'             => __( 'Saved Searches', 'wp-listings-pro' ),
			'name_admin_bar'        => __( 'Saved Search', 'wp-listings-pro' ),
			'archives'              => __( 'Saved Search Archives', 'wp-listings-pro' ),
			'attributes'            => __( 'Saved Search Attributes', 'wp-listings-pro' ),
			'parent_item_colon'     => __( 'Parent Saved Search:', 'wp-listings-pro' ),
			'all_items'             => __( 'Saved Searches', 'wp-listings-pro' ),
			'add_new_item'          => __( 'Add New Saved Search', 'wp-listings-pro' ),
			'add_new'               => __( 'Add New', 'wp-listings-pro' ),
			'new_item'              => __( 'New Saved Search', 'wp-listings-pro' ),
			'edit_item'             => __( 'Edit Saved Search', 'wp-listings-pro' ),
			'update_item'           => __( 'Update Saved Search', 'wp-listings-pro' ),
			'view_item'             => __( 'View Saved Search', 'wp-listings-pro' ),
			'view_items'            => __( 'View Saved Searches', 'wp-listings-pro' ),
			'search_items'          => __( 'Search Saved Search', 'wp-listings-pro' ),
			'not_found'             => __( 'Not found', 'wp-listings-pro' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-listings-pro' ),
			'featured_image'        => __( 'Featured Image', 'wp-listings-pro' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-listings-pro' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-listings-pro' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-listings-pro' ),
			'insert_into_item'      => __( 'Insert into Saved Search', 'wp-listings-pro' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Saved Search', 'wp-listings-pro' ),
			'items_list'            => __( 'Saved Searches list', 'wp-listings-pro' ),
			'items_list_navigation' => __( 'Saved Searches list navigation', 'wp-listings-pro' ),
			'filter_items_list'     => __( 'Filter Saved Searches list', 'wp-listings-pro' ),
		);
			$args = array(
				'label'               => __( 'Saved Search', 'wp-listings-pro' ),
				'description'         => __( 'A Saved Search.', 'wp-listings-pro' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'revisions' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => false,
				'show_in_menu'        => 'users.php',
				'menu_position'       => 70,
				'menu_icon'           => 'dashicons-search',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
				'show_in_rest'        => true,
				'rest_base'           => 'saved-search',
			);
			register_post_type( 'saved-search', $args );

	}
	add_action( 'init', 'wplpro_saved_searches', 0 );

}

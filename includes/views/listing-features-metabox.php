<?php
/**
 * Page for listing features
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Post.
global $post;


	// Featured On.
	echo '<label><strong>' . __( 'Featured on:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_featured_on]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_featured_on', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any details about where this listings has been featured, such as media sites.', 'wp-listings-pro' ) . '</p>';

	// Home Summary.
	echo '<label><strong>' . __( 'Home Summary:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_home_sum]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_home_sum', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any quick home summary details.', 'wp-listings-pro' ) . '</p>';

	// Kitchen Summary.
	echo '<label><strong>' . __( 'Kitchen Summary:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_kitchen_sum]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_kitchen_sum', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any quick kitchen summary details.', 'wp-listings-pro' ) . '</p>';


	// Living Room.
	echo '<label><strong>' . __( 'Living Room:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_living_room]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_living_room', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any quick living room summary details.', 'wp-listings-pro' ) . '</p>';


	// Master Suite.
	echo '<label><strong>' . __( 'Master Suite:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_master_suite]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_master_suite', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any quick master suite summary details.', 'wp-listings-pro' ) . '</p>';

	// School and Neighborhood Info.
	echo '<label><strong>' . __( 'School and Neighborhood:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_school_neighborhood]" id="" placeholder="" class="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display any quick school and neighborhood summary details.', 'wp-listings-pro' ) . '</p>';


	// Disclaimer.
	echo '<label><strong>' . __( 'Disclaimer:', 'wp-listings-pro' ) . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_disclaimer]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_disclaimer', true ) ) . '</textarea>';
	echo '<p class="description">' . __( 'This field allows you to display a disclaimer for the listing.', 'wp-listings-pro' ) . '</p>';


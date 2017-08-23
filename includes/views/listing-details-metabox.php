<?php
/**
 * Page for listing details
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}

wp_nonce_field( 'wp_listings_metabox_save', 'wp_listings_metabox_nonce' );

global $post;


	// Sold Date
	echo '<label><strong>' . __('Sold Date:','wp-listings-pro') . '</strong></label>';
	echo '<input name="wp_listings[_listing_sold_date]" id="" type="date" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_sold_date', true ) ) . '</input>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	echo '<h3>'. __( 'Location', 'wp-listings-pro') .'</h3>';
	echo '<hr>';

	// Address.
	echo '<label><strong>' . __('Address:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_address]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_address', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// City.
	echo '<label><strong>' . __('City:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_city]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_city', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// County.
	echo '<label><strong>' . __('County:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_county]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_county', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// State.
	echo '<label><strong>' . __('State:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_state]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_state', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Country.
	echo '<label><strong>' . __('Country:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_country]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_country', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Zip.
	echo '<label><strong>' . __('Zip:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_zip]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_zip', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Latitude.
	echo '<label><strong>' . __('Latitude:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_latitude]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_latitude', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Longitude.
	echo '<label><strong>' . __('Longitude:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_longitude]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_longitude', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Location.
	echo '<label><strong>' . __('Location:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_location]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_location', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';



	echo '<h3>'. __( 'Extended Details', 'wp-listings-pro') .'</h3>';
	echo '<hr>';


	// MLS.
	echo '<label><strong>' . __('MLS:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_mls]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_mls', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Open House.
	echo '<label><strong>' . __('Open House:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_open_house]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_open_house', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';




	// Year Built.
	echo '<label><strong>' . __('Year Built:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_year_built]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_year_built', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Floors
	echo '<label><strong>' . __('Floors:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_floors]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_floors', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// SQFT
	echo '<label><strong>' . __('SqFt:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_sqft]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_sqft', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Lot SqFT
	echo '<label><strong>' . __('Lot SqFT:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_lot_sqft]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Bedrooms.
	echo '<label><strong>' . __('Bedrooms:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_bedrooms]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_bedrooms', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Bathrooms.
	echo '<label><strong>' . __('Bathrooms:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_bathrooms]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_bathrooms', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Half Bath.
	echo '<label><strong>' . __('Half Bath:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_half_bath]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_half_bath', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Garage.
	echo '<label><strong>' . __('Garage:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_garage]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_garage', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Pool.
	echo '<label><strong>' . __('Pool:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_pool]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_pool', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Living Space.
	echo '<label><strong>' . __('Living Space:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_living_space]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_living_space', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Land Size.
	echo '<label><strong>' . __('Land Size:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_land_size]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_land_size', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Currency.
	echo '<label><strong>' . __('Currency:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_list_currency]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_list_currency', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';




	// Lot Size.
	echo '<label><strong>' . __('Lot Size:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_lotsize]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_lotsize', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Scenery.
	echo '<label><strong>' . __('Scenery:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_scenery]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_scenery', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Community.
	echo '<label><strong>' . __('Community:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_community]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_community', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Recreation.
	echo '<label><strong>' . __('Recreation:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_recreation]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_recreation', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// General.
	echo '<label><strong>' . __('General:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_general]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_general', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Inclusions.
	echo '<label><strong>' . __('Inclusions:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_inclusions]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_inclusions', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Parking
	echo '<label><strong>' . __('Parking:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_parking]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_parking', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Rooms.
	echo '<label><strong>' . __('Rooms:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_rooms]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_rooms', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Laundry
	echo '<label><strong>' . __('Laundry:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_laundry]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_laundry', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';

	// Utilities
	echo '<label><strong>' . __('Utilities:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_utilities]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_utilities', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Virtual Tour
	echo '<label><strong>' . __('Virtual Tour:','wp-listings-pro') . '</strong></label>';
	echo '<textarea name="wp_listings[_listing_virtualtour]" id="" class="" placeholder="" rows="3" cols="18" style="width:100%;">' . htmlentities( get_post_meta( $post->ID, '_listing_virtualtour', true ) ) . '</textarea>';
	echo '<p class="description">'. __( '', 'wp-listings-pro') .'</p>';


	// Custom Overlay Text.
	_e( '<h4>Custom Overlay Text</h4>', 'wp-listings-pro' );
	echo '<input type="text" placeholder="" name="wp_listings[_listing_text]" value="'. htmlentities( get_post_meta( $post->ID, '_listing_text', true ) ) .'" />';
	echo '<p class="description">'. __( 'Custom text to display as overlay on featured listings.', 'wp-listings-pro') .'</p>';

	// Video Embed.
	echo '<textarea name="wp_listings[_listing_video]" rows="5" cols="18" placeholder="" style="width:100%;">'.htmlentities( get_post_meta( $post->ID, '_listing_video', true ) ).'</textarea>';
	echo '<p class="description">'. __( 'Enter Video or Virtual Tour Embed Code.', 'wp-listings-pro') .'</p>';








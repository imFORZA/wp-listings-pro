<?php
/**
 * Page for listing details
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_nonce_field( 'wp_listings_metabox_save', 'wp_listings_metabox_nonce' );

global $post;

// Sold Date
echo '<label><strong>' . esc_html__( 'Sold Date:', 'wp-listings-pro' ) . '</strong></label>';
echo '<input name="wp_listings[_listing_sold_date]" id="wp_listings[_listing_sold_date]" type="date" class="" placeholder="" style="width:100%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_sold_date', true ) ) . '">';


echo '<div style="width: 90%; float: left;">';

echo '<h3>' . esc_html__( 'Extended Details', 'wp-listings-pro' ) . '</h3>';
echo '<hr>';


// MLS.
echo '<label><strong>' . esc_html__( 'MLS:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_mls]" id="wp_listings[_listing_mls]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_mls', true ) ) . '"></p>';

// Open House.
echo '<label><strong>' . esc_html__( 'Open House:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_open_house]" id="wp_listings[_listing_open_house]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_open_house', true ) ) . '"></p>';

// Year Built.
echo '<label><strong>' . esc_html__( 'Year Built:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_year_built]" id="wp_listings[_listing_year_built]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_year_built', true ) ) . '"></p>';

// Floors
echo '<label><strong>' . esc_html__( 'Floors:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_floors]" id="wp_listings[_listing_floors]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_floors', true ) ) . '"></p>';

// SQFT
echo '<label><strong>' . esc_html__( 'SqFt:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_sqft]" id="wp_listings[_listing_sqft]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_sqft', true ) ) . '"></p>';

// Lot SqFT
echo '<label><strong>' . esc_html__( 'Lot SqFT:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_lot_sqft]" id="wp_listings[_listing_lot_sqft]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) . '"></p>';

// Bedrooms.
echo '<label><strong>' . esc_html__( 'Bedrooms:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_bedrooms]" id="wp_listings[_listing_bedrooms]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_bedrooms', true ) ) . '"></p>';

// Bathrooms.
echo '<label><strong>' . esc_html__( 'Bathrooms:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_bathrooms]" id="wp_listings[_listing_bathrooms]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_bathrooms', true ) ) . '"></p>';

// Half Bath.
echo '<label><strong>' . esc_html__( 'Half Bath:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_half_bath]" id="wp_listings[_listing_half_bath]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_half_bath', true ) ) . '"></p>';

// Garage.
echo '<label><strong>' . esc_html__( 'Garage:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_garage]" id="wp_listings[_listing_garage]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_garage', true ) ) . '"></p>';

// Pool.
echo '<label><strong>' . esc_html__( 'Pool:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_pool]" id="wp_listings[_listing_pool]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_pool', true ) ) . '"></p>';

// Living Space.
echo '<label><strong>' . esc_html__( 'Living Space:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_living_space]" id="wp_listings[_listing_living_space]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_living_space', true ) ) . '"></p>';

// Land Size.
echo '<label><strong>' . esc_html__( 'Land Size:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_land_size]" id="wp_listings[_listing_land_size]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_land_size', true ) ) . '"></p>';

// Currency.
echo '<label><strong>' . esc_html__( 'Currency:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_list_currency]" id="wp_listings[_listing_list_currency]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_list_currency', true ) ) . '"></p>';


// Lot Size.
echo '<label><strong>' . esc_html__( 'Lot Size:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_lotsize]" id="wp_listings[_listing_lotsize]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_lotsize', true ) ) . '"></p>';


// Scenery.
echo '<label><strong>' . esc_html__( 'Scenery:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_scenery]" id="wp_listings[_listing_scenery]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_scenery', true ) ) . '"></p>';

// Community.
echo '<label><strong>' . esc_html__( 'Community:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_community]" id="wp_listings[_listing_community]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_community', true ) ) . '"></p>';

// Recreation.
echo '<label><strong>' . esc_html__( 'Recreation:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_recreation]" id="wp_listings[_listing_recreation]" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_recreation', true ) ) . '"></p>';


// General.
echo '<label><strong>' . esc_html__( 'General:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_general]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_general', true ) ) . '"></p>';

// Inclusions.
echo '<label><strong>' . esc_html__( 'Inclusions:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_inclusions]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_inclusions', true ) ) . '"></p>';


// Parking
echo '<label><strong>' . esc_html__( 'Parking:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_parking]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_parking', true ) ) . '"></p>';

// Rooms.
echo '<label><strong>' . esc_html__( 'Rooms:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_rooms]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_rooms', true ) ) . '"></p>';

// Laundry
echo '<label><strong>' . esc_html__( 'Laundry:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_laundry]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_laundry', true ) ) . '"></p>';

// Utilities
echo '<label><strong>' . esc_html__( 'Utilities:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_utilities]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_utilities', true ) ) . '"></p>';


// Virtual Tour
echo '<label><strong>' . esc_html__( 'Virtual Tour:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_virtualtour]" id="" class="" style="width:80%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_virtualtour', true ) ) . '"></p>';

// Custom Overlay Text.
echo '<label><strong>' . esc_html__( 'Custom Overlay Text:', 'wp-listings-pro' ) . '</strong></label>';
echo '<p><input type="text" name="wp_listings[_listing_text]" style="width: 80%" value="' . htmlentities( get_post_meta( $post->ID, '_listing_text', true ) ) . '" /></p>';
echo '<p class="description">' . esc_html__( 'Custom text to display as overlay on featured listings.', 'wp-listings-pro' ) . '</p>';

echo '<label><strong>' . esc_html__( 'Video Embed:', 'wp-listings-pro' ) . '</strong></label>';

echo '</div>';

// Video Embed.
echo '<p><input type="text" name="wp_listings[_listing_video]" style="width:72%;" value="' . htmlentities( get_post_meta( $post->ID, '_listing_video', true ) ) . '"></p>'; // 0.8 * 0.9 = 0.72. Also, so for some really annoying reason, I cannot get this fricking element to move into the div above. I have no idea why.

echo '<p class="description">' . esc_html__( 'Enter Video or Virtual Tour Embed Code.', 'wp-listings-pro' ) . '</p>';

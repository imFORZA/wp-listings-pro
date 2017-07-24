<?php
/**
 * Metabox for listing contact information
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

echo '<div>';

		echo '<h4>' . __( 'Location Details', 'wp-listings-pro' ) . '</h4>';

		if ( get_post_meta( $post->ID, '_listing_automap', 1 ) === false ) {
			update_post_meta( $post->ID, '_listing_automap', 'y' );
		}

		echo '<p>';

		echo '<label>' . __( 'Automatically insert map based on latitude/longitude?', 'wp-listings-pro' ) . '</label>';

		echo '</p>';

		echo __( 'Will be overridden if a shortode is entered below.', 'wp-listings-pro');

		echo '<input type="radio" name="wp_listings[_listing_automap]" value="y" '. checked( get_post_meta( $post->ID, '_listing_automap', true ), 'y', 0 ) .'>Yes</input>';

		echo '<input type="radio" name="wp_listings[_listing_automap]" value="n" '. checked( get_post_meta( $post->ID, '_listing_automap', true ), 'n', 0 ) .'>No</input>';


		echo '<p>';
		echo '<label>' . __('Latitude','') . '</label>';
		echo '<input type="text" name="wp_listings[_listing_latitude]" placeholder="" value="'. get_post_meta( $post->ID, '_listing_latitude', true ) .'" />';

		echo '</p>';

		echo '<p>';
		echo '<label>' . __('Longitude','') . '</label>';
		echo '<input type="text" name="wp_listings[_listing_longitude]" placeholder="" value="' . get_post_meta( $post->ID, '_listing_longitude', true ) . '" />';

		echo '</p><p>';

		_e( 'Enter a Map Embed Code or shortcode from any map plugin.<br>', 'wp-listings-pro' );

		_e( 'Recommend size: 660x300 (If possible, use 100% width, or your themes content width)', 'wp-listings-pro' );

		echo '</p>';

		echo '<textarea name="wp_listings[_listing_map]" rows="5" cols="18">'. htmlentities( get_post_meta( $post->ID, '_listing_map', true ) )  .'</textarea>';

		echo '<ul>';
		echo '<li><a href="https://jetpack.me/support/shortcode-embeds/" target="_blank" rel="nofollow">Jetpack Shortcodes</a></li>';
		echo '<li><a href="https://wordpress.org/plugins/simple-google-maps-short-code/" target="_blank" rel="nofollow">Simple Google Maps Short Code</a></li>';
		echo '<li><a href="https://wordpress.org/plugins/mappress-google-maps-for-wordpress/" target="_blank" rel="nofollow">MapPress</a></li>';
		echo '</ul>';



echo '</div>';

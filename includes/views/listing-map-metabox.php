<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}

echo '<div style="width: 90%; float: left;">';

	echo '<div style="width: 45%; float: left">';
		_e( '<h4>Map Options</h4>', 'wp-listings-pro' );

if ( get_post_meta( $post->ID, '_listing_automap', 1 ) == false ) {
	update_post_meta( $post->ID, '_listing_automap', 'y' );
}
		printf( __( '<p><label>Automatically insert map based on latitude/longitude? <strong>Will be overridden if a shortode is entered below.</strong><br /> <input type="radio" name="wp_listings[_listing_automap]" value="y" %1$s>Yes</input> <input type="radio" name="wp_listings[_listing_automap]" value="n" %1$s>No</input></label></p>' ),
			checked( get_post_meta( $post->ID, '_listing_automap', true ), 'y', 0 ),
		checked( get_post_meta( $post->ID, '_listing_automap', true ), 'n', 0 ) );
		echo '</div>';
		echo '<div style="clear: both; width: 45%; float: left;">';
		printf( __( '<p><label>Latitude: <br /><input type="text" name="wp_listings[_listing_latitude]" value="%s" /></label></p>', 'wp-listings-pro' ), get_post_meta( $post->ID, '_listing_latitude', true ) );
		echo '</div>';
		echo '<div style="width: 45%; float: right;">';
		printf( __( '<p><label>Longitude: <br /><input type="text" name="wp_listings[_listing_longitude]" value="%s" /></label></p>', 'wp-listings-pro' ), get_post_meta( $post->ID, '_listing_longitude', true ) );
		echo '</div><br style="clear: both;" />';

		_e( '<p><label>Or enter Map Embed Code or shortcode from Map plugin (such as <a href="http://jetpack.me/support/shortcode-embeds/" target="_blank" rel="nofollow">Jetpack Shortcodes</a>, <a href="https://wordpress.org/plugins/simple-google-maps-short-code/" target="_blank" rel="nofollow">Simple Google Maps Short Code</a> or <a href="https://wordpress.org/plugins/mappress-google-maps-for-wordpress/" target="_blank" rel="nofollow">MapPress</a>):<br /><em>Recommend size: 660x300 (If possible, use 100% width, or your themes content width)</em><br />', 'wp-listings-pro' );
		printf( __( '<textarea name="wp_listings[_listing_map]" rows="5" cols="18" style="%1$s">%2$s</textarea></label></p>', 'wp-listings-pro' ), 'width: 99%;', htmlentities( get_post_meta( $post->ID, '_listing_map', true ) ) );

		echo '</div>';

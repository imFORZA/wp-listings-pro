<?php
/**
 * Page for the location metabox on single listings.
 *
 * @package WP-Listings-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

// Form fields.
echo '<table class="form-table">';

// Carrier Route.
echo '	<tr>';
echo '		<th><label for="listing_carrier_route" class="listing_carrier_route_label">' . __( 'Carrier Route', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_carrier_route]" name="wp_listings[_listing_carrier_route]" class="listing_carrier_route_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_carrier_route', true ) ) . '">';
echo '			<p class="description">' . __( 'The group of addresses to which the USPS assigns the same code to aid in mail delivery. For the USPS, these codes are 9 digits: 5 numbers for the ZIP Code, one letter for the carrier route type, and 3 numbers for the carrier route number.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// City.
echo '	<tr>';
echo '		<th><label for="listing_city" class="listing_city_label">' . __( 'City', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_city]" name="wp_listings[_listing_city]" class="listing_city_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_city', true ) ) . '">';
echo '			<p class="description">' . __( 'The city in listing address.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Country.
echo '	<tr>';
echo '		<th><label for="listing_country" class="listing_country_label">' . __( 'Country', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_country]" name="wp_listings[_listing_country]" class="listing_country_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_country', true ) ) . '">';
echo '			<p class="description">' . __( 'The country abbreviation in a postal address.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// County or Parish.
echo '	<tr>';
echo '		<th><label for="listing_county_or_parish" class="listing_county_or_parish_label">' . __( 'County or Parish', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_county]" name="wp_listings[_listing_county]" class="listing_county_or_parish_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_county', true ) ) . '">';
echo '			<p class="description">' . __( 'The County, Parish or other regional authority', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Postal City
echo '	<tr>';
echo '		<th><label for="listing_postal_city" class="listing_postal_city_label">' . __( 'Postal City', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_postal_city]" name="wp_listings[_listing_postal_city]" class="listing_postal_city_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_postal_city', true ) ) . '">';
echo '			<p class="description">' . __( 'The official city per the USPS. May be different from the "City".', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Postal Code
echo '	<tr>';
echo '		<th><label for="listing_postal_code" class="listing_postal_code_label">' . __( 'Postal Code', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_zip]" name="wp_listings[_listing_zip]" class="listing_postal_code_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_zip', true ) ) . '">';
echo '			<p class="description">' . __( 'The postal code portion of a street or mailing address.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// PostalCode +4
echo '	<tr>';
echo '		<th><label for="listing_postalcode_plus4" class="listing_postalcode_plus4_label">' . __( 'Postal Code plus 4', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_zip_plus_4]" name="wp_listings[_listing_zip_plus_4]" class="listing_postalcode_plus4_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_zip_plus_4', true ) ) . '">';
echo '			<p class="description">' . __( 'The postal code +4 portion of a street or mailing address.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Listing State or Province.
echo '	<tr>';
echo '		<th><label for="listing_state_or_province" class="listing_state_or_province_label">' . __( 'State or Province', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_state]" name="wp_listings[_listing_state]" class="listing_state_or_province_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_state', true ) ) . '">';
echo '			<p class="description">' . __( 'Text field containing the accepted postal abbreviation for the state or province.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Listing Street Additional Info.
echo '	<tr>';
echo '		<th><label for="listing_street_additional_info" class="listing_street_additional_info_label">' . __( 'Street Additional Info', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_street_additional_info]" name="wp_listings[_listing_street_additional_info]" class="listing_street_additional_info_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_street_additional_info', true ) ) . '">';
echo '			<p class="description">' . __( 'Information other than a prefix or suffix for the street portion of a postal address.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

echo '</table>';



echo '<table class="form-table">';

echo '<tr><th>' . __( 'Map Details', 'wp-listings-pro' ) . '</th><td><hr></td></tr>';

if ( get_post_meta( $post->ID, '_listing_automap', 1 ) === false ) {
	update_post_meta( $post->ID, '_listing_automap', 'y' );
}

// Listing Street Additional Info.
echo '	<tr>';
echo '		<th><label for="listing_street_additional_info" class="listing_street_additional_info_label">' . __( 'Automatically Insert Map', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="radio" name="wp_listings[_listing_automap]" value="y" ' . checked( get_post_meta( $post->ID, '_listing_automap', true ), 'y', 0 ) . '>Yes</input>';
echo '			<input type="radio" name="wp_listings[_listing_automap]" value="n" ' . checked( get_post_meta( $post->ID, '_listing_automap', true ), 'n', 0 ) . '>No</input>';
echo '			<p class="description">' . __( 'Automatically insert map based on latitude/longitude?', 'wp-listings-pro' ) . '</p>';
echo '			<p class="description">' . __( 'Will be overridden if a shortode is entered below.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

echo '	<tr>';
echo '		<th><label for="_listing_latitude" class="_listing_latitude_label">' . __( 'Latitude', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_latitude]" name="wp_listings[_listing_latitude]" class="_listing_latitude_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_latitude', true ) ) . '">';
echo '		</td>';
echo '	</tr>';

echo '	<tr>';
echo '		<th><label for="_listing_longitude" class="_listing_longitude_label">' . __( 'Longitude', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_longitude]" name="wp_listings[_listing_longitude]" class="_listing_longitude_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_longitude', true ) ) . '">';
echo '		</td>';
echo '	</tr>';

echo '	<tr>';
echo '		<th><label for="_listing_map" class="_listing_map_label">' . __( 'Map Shortcode', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="wp_listings[_listing_map]" name="wp_listings[_listing_map]" class="_listing_map_field" value="' . esc_attr( get_post_meta( $post->ID, '_listing_map', true ) ) . '">';
echo '			<p class="description">' . __( 'Enter a Map Embed Code or shortcode from any map plugin.', 'wp-listings-pro' ) . '</p>';
echo '			<p class="description">' . __( 'Recommend size: 660x300 (If possible, use 100% width, or your themes content width).', 'wp-listings-pro' ) . '</p>';
echo '			<p class="description">' . __( '<a href="https://jetpack.me/support/shortcode-embeds/" target="_blank" rel="nofollow">Jetpack Shortcodes</a>', 'wp-listings-pro' ) . '</p>';
echo '			<p class="description">' . __( '<a href="https://wordpress.org/plugins/simple-google-maps-short-code/" target="_blank" rel="nofollow">Simple Google Maps Short Code</a>', 'wp-listings-pro' ) . '</p>';
echo '			<p class="description">' . __( '<a href="https://wordpress.org/plugins/mappress-google-maps-for-wordpress/" target="_blank" rel="nofollow">MapPress</a>', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

echo '</table>';

<?php
/**
 * Page for the pricing metabox on listings
 *
 * @package WP-Listings-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

global $post;

// Form fields.
echo '<table class="form-table">';

// List Price.
echo '	<tr>';
echo '		<th><label for="listing_list_price" class="listing_list_price_label">' . __( 'List Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_price]" name="wp_listings[_listing_price]" class="listing_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_price', true ) ) . '">';
echo '			<p class="description">' . __( 'The current price of the property as determined by the seller and the seller\'s broker. For auctions this is the minimum or reserve price.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// List Low Price.
echo '	<tr>';
echo '		<th><label for="listing_list_price_low" class="listing_list_price_low_label">' . __( 'Low List Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_list_price_low]" name="wp_listings[_listing_list_price_low]" class="listing_list_price_low_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_list_price_low', true ) ) . '">';
echo '			<p class="description">' . __( 'The lower price used for Value Range Pricing. The List Price must be greater than or equal to the ListPriceLow.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Original List Price.
echo '	<tr>';
echo '		<th><label for="listing_original_list_price" class="listing_original_list_price_label">' . __( 'Original List Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_original_list_price]" name="wp_listings[_listing_original_list_price]" class="listing_original_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_original_list_price', true ) ) . '">';
echo '			<p class="description">' . __( 'The original price of the property on the initial agreement between the seller and the seller\'s broker.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Previous List Price.
echo '	<tr>';
echo '		<th><label for="listing_previous_list_price" class="listing_previous_list_price_label">' . __( 'Previous List Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_previous_list_price]" name="wp_listings[_listing_previous_list_price]" class="listing_previous_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_previous_list_price', true ) ) . '">';
echo '			<p class="description">' . __( 'The most recent previous ListPrice of the listing.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Close Price Field.
echo '	<tr>';
echo '		<th><label for="listing_close_price" class="listing_close_price_label">' . __( 'Closing Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_sold_price]" name="wp_listings[_listing_sold_price]" class="listing_close_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_sold_price', true ) ) . '">';
echo '			<p class="description">' . __( 'The amount of money paid by the purchaser to the seller for the property under the agreement.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Total Actual Rent
echo '	<tr>';
echo '		<th><label for="listing_total_actual_rent" class="listing_total_actual_rent_label">' . __( 'Rental Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="number" min="0" max="99999999999999" step="1" id="wp_listings[_listing_rent_price]" name="wp_listings[_listing_rent_price]" class="listing_total_actual_rent" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( get_post_meta( $post->ID, '_listing_rent_price', true ) ) . '">';
echo '			<p class="description">' . __( 'Total actual rent currently being collected from tenants of the income property.', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Hide Price from Visitors?
echo '	<tr>';
echo '		<th><label for="listing_total_actual_rent" class="listing_total_actual_rent_label">' . __( 'Hide Price', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
wp_nonce_field( 'wp-hide-price-action', 'wp-hide-price-name' );
echo '			<input type="checkbox" name="wp_listings[_listing_hide_price]" value="1" ' . checked( get_post_meta( $post->ID, '_listing_hide_price', true ), 1, 0 ) . ' />';
echo '			<p class="description">' . __( 'Hide the price from visitors?', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';

// Alternate Text for Price
echo '	<tr>';
echo '		<th><label for="listing_total_actual_rent" class="listing_total_actual_rent_label">' . __( 'Alternate Text to Display', 'wp-listings-pro' ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" placeholder="" name="wp_listings[_listing_price_alt]" value="' . htmlentities( get_post_meta( $post->ID, '_listing_price_alt', true ) ) . '" />';
echo '			<p class="description">' . __( 'Text to display instead of price (or leave blank).', 'wp-listings-pro' ) . '</p>';
echo '		</td>';
echo '	</tr>';


echo '</table>';

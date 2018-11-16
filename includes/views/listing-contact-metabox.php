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


echo '<label><strong>' . __( 'Contact Form:', 'wp-listings-pro' ) . '</strong></label>';

echo '<textarea name="wp_listings[_listing_contact_form]" rows="1" cols="18" placeholder="" style="width:100%">' . htmlentities( get_post_meta( $post->ID, '_listing_contact_form', true ) ) . '</textarea>';

echo '<p class="description">' . __( 'If you wish to use a custom form from for your listing you can add a shortcode.', 'wp-listings-pro' ) . '</p>';

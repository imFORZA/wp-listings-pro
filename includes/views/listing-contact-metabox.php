<?php


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


global $post;

echo '<div style="width: 90%; float: left;">';
_e( '<h4>Contact Form</h4>', 'wp-listings-pro' );

_e( '<p><label>If you use a Contact Form plugin, you may enter the Contact Form shortcode here.', 'wp-listings-pro' );
printf( __( '<textarea name="wp_listings[_listing_contact_form]" rows="1" cols="18" style="%s">%s</textarea></label></p>', 'wp-listings-pro' ), 'width: 99%', htmlentities( get_post_meta( $post->ID, '_listing_contact_form', true ) ) );

echo '</div><br style="clear: both;" />';

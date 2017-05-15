<?php
/**
 * Page for listing details
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}

wp_nonce_field( 'wp_listings_metabox_save', 'wp_listings_metabox_nonce' );

global $post;

$pattern = '<p><label>%s<br /><input type="text" name="wp_listings[%s]" value="%s" /></label></p>';

echo '<div style="width: 45%; float: left">';

foreach ( (array) $this->property_details['col1'] as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div>';

echo '<div style="width: 45%; float: right;">';

foreach ( (array) $this->property_details['col2'] as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div><br style="clear: both;" />';

$pattern = '<p><label>%s<br /><textarea type="text" name="wp_listings[%s]" value="%s" rows="2" style="width: 100&#37;;">%s</textarea></label></p>';

_e( '<h4>Extended Details:</h4>', 'wp-listings-pro' );
echo '<div style="width: 45%; float: left">';

foreach ( (array) $this->extended_property_details['col1'] as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ), esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div>';

echo '<div style="width: 45%; float: right;">';

foreach ( (array) $this->extended_property_details['col2'] as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ), esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div><br style="clear: both;" />';

	// Price Options.
	echo '<div style="width: 45%; float: left">';
	_e( '<h4>Price Options</h4>', 'wp-listings-pro' );
	wp_nonce_field( 'wp-hide-price-action', 'wp-hide-price-name' );
	printf( __( '<p><label>Hide the price from visitors?<br /> <input type="checkbox" name="wp_listings[_listing_hide_price]" value="1" %s /></label></p>' ),
	checked( get_post_meta( $post->ID, '_listing_hide_price', true ), 1, 0 ) );

	_e( '<p><label>Text to display instead of price (or leave blank):<br />', 'wp-listings-pro' );
	printf( __( '<input type="text" name="wp_listings[_listing_price_alt]" value="%s" /></label></p>', 'wp-listings-pro' ), htmlentities( get_post_meta( $post->ID, '_listing_price_alt', true ) ) );
	echo '</div>';

	echo '<div style="width: 90%; float: left;">';

	_e( '<h4>Custom Overlay Text</h4>', 'wp-listings-pro' );
	_e( '<p><label>Custom text to display as overlay on featured listings<br />', 'wp-listings-pro' );
	printf( __( '<input type="text" name="wp_listings[_listing_text]" value="%s" /></label></p>', 'wp-listings-pro' ), htmlentities( get_post_meta( $post->ID, '_listing_text', true ) ) );

	echo '</div><br style="clear: both;" /><br /><br /><hr>';

	// echo '<div style="width: 100%; float: left;">';
	//
	// $wplistings_gallery_content = get_post_meta( $post->ID, '_listing_gallery', true );
	//
	// // Hide Legacy Gallery Meta Field if empty.
	// if ( ! empty( $wplistings_gallery_content ) ) {
	//
	// _e( '<p><label>Photo Gallery (use Add Media button to insert Gallery):<br />', 'wp-listings-pro' );
	//
	// $wplistings_gallery_editor_id = '_listing_gallery';
	//
	// $wplistings_gallery_editor_settings = array(
	// 'wpautop'           => false,
	// 'textarea_name'     => 'wp_listings[_listing_gallery]',
	// 'editor_class'      => 'wplistings_gallery',
	// 'textarea_rows'     => 20,
	// 'tinymce'           => true,
	// 'quicktags'         => true,
	// 'drag_drop_upload'  => true,
	// );
	//
	// wp_editor( $wplistings_gallery_content, $wplistings_gallery_editor_id, $wplistings_gallery_editor_settings );
	//
	// }
	//
	// echo '</div><br style="clear: both;" /><br /><br />';
	echo '<div style="width: 90%; float: left;">';

	_e( '<p><label>Enter Video or Virtual Tour Embed Code (<a href="https://wordpress.org/plugins/jetpack/" target="_blank" rel="nofollow">Jetpack</a> offers several <a href="http://jetpack.me/support/shortcode-embeds/" target="_blank" rel="nofollow">video shortcodes</a>.):<br />', 'wp-listings-pro' );
	printf( __( '<textarea name="wp_listings[_listing_video]" rows="5" cols="18" style="%1$s">%2$s</textarea></label></p>', 'wp-listings-pro' ), 'width: 99%;', htmlentities( get_post_meta( $post->ID, '_listing_video', true ) ) );

	echo '</div><br style="clear: both;" />';

<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}

global $post;
$string = get_post_meta( $post->ID, '_listing_featured_on', true );
if ( null == get_post_meta( $post->ID, '_listing_sync_update', true ) || '' == get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
	update_post_meta( $post->ID, '_listing_sync_update', 'update-useglobal' );
}
$sync_setting = get_post_meta( $post->ID, '_listing_sync_update', true );

$settings = get_option( 'wplpro_plugin_settings' );
$global_sync_setting;
if ( isset( $settings['wplpro_idx_update'] ) ) {
	$global_sync_setting = $settings['wplpro_idx_update'];
} else {
	$global_sync_setting = 'update-all';
}

$current_setting = 'everything';
if ( $global_sync_setting != 'update-custom' ) {
	if ( $global_sync_setting == 'update-none' ) {
		$current_setting = 'nothing';
	}
} else {
	$current_setting = ' custom settings';
}



echo "<div class='idx-import-wrap'>";
echo "<div class='fixer' style='width:99%;overflow: auto'>";
_e( '<p>Override global options for syncing with IDX feed. Occurs twice daily, select "Custom Sync Settings" to choose specific fields to update (or not to update).</p>', 'wp-listings-pro' );
_e( '<div class="idx-import-option ' . $global_sync_setting . '"><label><h4>Follow Global Settings</h4> <span class="dashicons ' . ($global_sync_setting == 'update-none' ? 'dashicons-dismiss' : 'dashicons-update' ) . '"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_global" type="radio" value="update-useglobal" class="code" ' . checked( 'update-useglobal', $sync_setting, false ) . ' /> <p>Follow global settings for updates (is currently set to update ' . ($current_setting) . ').</p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_all" type="radio" value="update-all" class="code" ' . checked( 'update-all', $sync_setting, false ) . ' /> <p>Keep everything up to date. <br /></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_none" type="radio" value="update-none" class="code" ' . checked( 'update-none', $sync_setting, false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Does not update any fields.<br /><em>* Listing will be changed to sold status if it exists in the sold data feed.</em></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-custom"><label><h4>Custom Sync Settings</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_custom" type="radio" value="update-custom" class="code" ' . checked( 'update-custom', $sync_setting, false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Updates fields chosen via checkboxes below.<br /><em>* Listing will be changed to sold status if it exists in the sold data feed.</em></p></label></div>', 'wp-listings-pro' );
echo '</div></div>';

echo '<div class"custom-inputs"><fieldset id="listing_custom_inputs">';
_e( '<p><label><input name="wp_listings[_listing_custom_sync_featured]" id="_listing_custom_sync_featured" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_featured', true ), false ) . ' /> Keep the featured image in sync</p>', 'wp-listings-pro' );
_e( '<p><label><input name="wp_listings[_listing_custom_sync_gallery]" id="_listing_custom_sync_gallery" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_gallery', true ), false ) . ' /> Keep image gallery in sync</p>', 'wp-listings-pro' );
_e( '<p><label><input name="wp_listings[_listing_custom_sync_details]" id="_listing_custom_sync_details" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_details', true ), false ) . ' /> Keep listing details in sync</p>', 'wp-listings-pro' );
_e( '</fieldset></div>' );

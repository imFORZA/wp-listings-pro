<?php
/**
 * Metabox for listing synchronization settings
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}

global $post;
$string = get_post_meta( $post->ID, '_listing_featured_on', true );
if ( null === get_post_meta( $post->ID, '_listing_sync_update', true ) || '' === get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
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
if ( 'update-custom' !== $global_sync_setting ) {
	if ( 'update-none' === $global_sync_setting ) {
		$current_setting = 'nothing';
	}
} else {
	$current_setting = ' custom settings';
}




_e( '<p>Override global options for syncing with IDX feed. Occurs twice daily, select "Custom Sync Settings" to choose specific fields to update (or not to update).</p>', 'wp-listings-pro' );

// TODO: Make a simple Dropdown, only show custom options when its choosen.

echo '<select name="wp_listings[_listing_sync_update]" id="sync-select" style="width:100%;">';
echo '<option value="update-useglobal">Use Global Settings</option>';
echo '<option value="update-all">Sync All</option>';
echo '<option value="update-none">Do Not Sync</option>';
echo '<option value="update-custom">Custom</option>';
echo '</select>';



echo '<ul class="custom-options" style="display:none;">';
_e( '<li><label><input name="wp_listings[_listing_custom_sync_featured]" id="_listing_custom_sync_featured" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_featured', true ), false ) . ' /> Keep the featured image in sync</li>', 'wp-listings-pro' );
_e( '<li><label><input name="wp_listings[_listing_custom_sync_gallery]" id="_listing_custom_sync_gallery" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_gallery', true ), false ) . ' /> Keep image gallery in sync</li>', 'wp-listings-pro' );
_e( '<li><label><input name="wp_listings[_listing_custom_sync_details]" id="_listing_custom_sync_details" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_details', true ), false ) . ' /> Keep listing details in sync</li>', 'wp-listings-pro' );
echo '</ul>';

?>

<script>
jQuery('#sync-select').on('change',function(){
    if(jQuery(this).val()=='update-custom'){
        jQuery('.custom-options').show();
    } else {
        jQuery('.custom-options').hide();
    }
});
</script>

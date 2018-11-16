<?php
/**
 * Metabox for listing synchronization settings
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

// Fancy logic to compare listing setting to the global setting.
$string = get_post_meta( $post->ID, '_listing_featured_on', true );
if ( null === get_post_meta( $post->ID, '_listing_sync_update', true ) || '' === get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
	update_post_meta( $post->ID, '_listing_sync_update', 'update-useglobal' );
}
$sync_setting = get_post_meta( $post->ID, '_listing_sync_update', true );

_e( '<p>Override global options for syncing with IDX feed. Occurs twice daily, select "Custom Sync Settings" to choose specific fields to update (or not to update).</p>', 'wp-listings-pro' );

echo '<select name="wp_listings[_listing_sync_update]" id="sync-select" style="width:100%;">';
echo '<option value="update-useglobal" ' . ( 'update-useglobal' === $sync_setting ? 'selected' : '' ) . '>' . esc_html__( 'Use Global Settings', 'wp-listings-pro' ) . '</option>';
echo '<option value="update-all" ' . ( 'update-all' === $sync_setting ? 'selected' : '' ) . '>' . esc_html__( 'Sync All', 'wp-listings-pro' ) . '</option>';
echo '<option value="update-none" ' . ( 'update-none' === $sync_setting ? 'selected' : '' ) . '>' . esc_html__( 'Do Not Sync', 'wp-listings-pro' ) . '</option>';
echo '<option value="update-custom" ' . ( 'update-custom' === $sync_setting ? 'selected' : '' ) . '>' . esc_html__( 'Custom', 'wp-listings-pro' ) . '</option>';
echo '</select>';


echo '<ul class="custom-options" style="display:none;">';
echo '<li><label><input name="wp_listings[_listing_custom_sync_featured]" id="_listing_custom_sync_featured" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_featured', true ), false ) . ' />' . esc_html__( 'Keep the featured image in sync', 'wp-listings-pro' ) . '</li>';
echo '<li><label><input name="wp_listings[_listing_custom_sync_gallery]" id="_listing_custom_sync_gallery" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_gallery', true ), false ) . ' />' . esc_html__( 'Keep image gallery in sync', 'wp-listings-pro' ) . '</li>';
echo '<li><label><input name="wp_listings[_listing_custom_sync_details]" id="_listing_custom_sync_details" type="checkbox" value="1" ' . checked( 1, get_post_meta( $post->ID, '_listing_custom_sync_details', true ), false ) . ' />' . esc_html__( 'Keep listing details in sync', 'wp-listings-pro' ) . '</li>';
echo '</ul>';

?>

<script>
jQuery(function(){
	jQuery('#sync-select').on('change',function(){
		if(jQuery(this).val()=='update-custom'){
			jQuery('.custom-options').show();
		} else {
			jQuery('.custom-options').hide();
		}
	});

	// Initial check.
	if( jQuery('#sync-select').val() === 'update-custom' ){
		jQuery('.custom-options').show();
	}
});
</script>

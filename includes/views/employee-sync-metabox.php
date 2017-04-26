<?php

global $post;
$string =  get_post_meta( $post->ID, '_listing_featured_on', true );
if( null == get_post_meta( $post->ID, '_listing_sync_update', true ) || '' == get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
	update_post_meta( $post->ID, '_listing_sync_update', 'update-useglobal' );
}
$sync_setting = get_post_meta( $post->ID, '_listing_sync_update', true );
$options = get_option('wp');
$plugin_options = get_option( 'wplpro_plugin_settings' );
if( ! isset( $plugin_options['wplpro_idx_update_agents'] ) ) {
	$plugin_options['wplpro_idx_update_agents'] = 'update-all';
}
$global_sync_setting = get_option( 'wplpro_plugin_settings' )['wplpro_idx_update_agents'];

if($global_sync_setting == 'update-none'){
	$current_setting = 'nothing';
}else{
	$current_setting = 'everything';
}



echo "<div class='idx-import-wrap' style='height:600px;'>";
echo "<div class='fixer' style='width:99%;overflow: auto'>";
_e( '<h2>Update Listings</h2>', 'wp-listings-pro' );
_e( '<div class="idx-import-option ' . $global_sync_setting .  '"><label><h4>Follow Global Settings</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_global" type="radio" value="update-useglobal" class="code" ' . checked( 'update-useglobal', $sync_setting, false ) . ' /> <p>Follow global settings for updates (is currently set to update ' . ($current_setting) . ').</p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_all" type="radio" value="update-all" class="code" ' . checked( 'update-all', $sync_setting, false ) . ' /> <p>Keep everything up to date. <br /></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update_none" type="radio" value="update-none" class="code" ' . checked( 'update-none', $sync_setting, false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Does not update any fields.<br /><em>* Listing will be changed to sold status if it exists in the sold data feed.</em></p></label></div>', 'wp-listings-pro' );
echo "</div></div>";

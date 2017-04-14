<?php

global $post;
$string =  get_post_meta( $post->ID, '_listing_featured_on', true );
if( null == get_post_meta( $post->ID, '_listing_sync_update', true ) || '' == get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
	update_post_meta( $post->ID, '_listing_sync_update', 'update-useglobal' );
}
$sync_setting = get_post_meta( $post->ID, '_listing_sync_update', true );

echo "<div class='idx-import-wrap' style='height:600px;'>";
echo "<div class='fixer'>";
_e( '<h2>Update Listings</h2>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-useglobal"><label><h4>Follow Global Settings</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update" type="radio" value="update-useglobal" class="code" ' . checked( 'update-useglobal', $sync_setting, false ) . ' /> <p>Follow global settings for updates (is currently WHAT IS IT BRADLEY, HUH?!).</p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update" type="radio" value="update-all" class="code" ' . checked( 'update-all', $sync_setting, false ) . ' /> <p>Update all imported fields including gallery and featured image. <br /><em>* Excludes Post Title and Post Content</em></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-noimage"><label><h4>Update Excluding Images</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update" type="radio" value="update-noimage" class="code" ' . checked( 'update-noimage', $sync_setting, false ) . ' /> <p>Update all imported fields, but excluding the gallery and featured image.<br /><em>* Also excludes Post Title and Post Content</em></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-nodetails"><label><h4>Update Excluding Details</h4> <span class="dashicons dashicons-update"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update" type="radio" value="update-nodetails" class="code" ' . checked( 'update-nodetails', $sync_setting, false ) . ' /> <p>Update only images, including the gallery and featured image.<br /></p></label></div>', 'wp-listings-pro' );
_e( '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="wp_listings[_listing_sync_update]" id="_listing_sync_update" type="radio" value="update-none" class="code" ' . checked( 'update-none', $sync_setting, false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Does not update any fields.<br /><em>* Listing will be changed to sold status if it exists in the sold data feed.</em></p></label></div>', 'wp-listings-pro' );

echo "</div></div>";

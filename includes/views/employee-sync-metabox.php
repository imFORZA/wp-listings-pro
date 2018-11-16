<?php
/**
 * Metabox for employee synchronization settings.
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$string = get_post_meta( $post->ID, '_listing_featured_on', true );
if ( null === get_post_meta( $post->ID, '_listing_sync_update', true ) || '' === get_post_meta( $post->ID, '_listing_sync_update', true ) ) {
	update_post_meta( $post->ID, '_listing_sync_update', 'update-useglobal' );
}
$sync_setting   = get_post_meta( $post->ID, '_listing_sync_update', true );
$options        = get_option( 'wp' );
$plugin_options = get_option( 'wplpro_plugin_settings' );
if ( ! isset( $plugin_options['wplpro_idx_update_agents'] ) ) {
	$plugin_options['wplpro_idx_update_agents'] = 'update-useglobal';
}
$wplrpo_settings = get_option( 'wplpro_plugin_settings' );
$global_sync_setting;
if ( isset( $wplrpo_settings['wplpro_idx_update_agents'] ) ) {
	$global_sync_setting = $wplrpo_settings['wplpro_idx_update_agents'];
} else {
	$global_sync_setting = 'update-all';
}

if ( 'update-none' === $global_sync_setting ) {
	$current_setting = 'nothing';
} else {
	$current_setting = 'everything';
}



echo "<div class='idx-import-wrap' style='overflow: auto'>";
echo "<div class='fixer' style='width:99%;overflow: auto'>";
echo '<p>Override global options for syncing with IDX feed. Occurs twice daily.</p>';
echo '<div class="idx-import-option ' . esc_attr( $global_sync_setting ) . '"><label><h4>Follow Global Settings</h4> <span class="dashicons ' . ( 'update-all' === $global_sync_setting ? 'dashicons-update' : 'dashicons-dismiss' ) . '"></span><input name="WPLPROAgents[_listing_sync_update]" id="_listing_sync_update_global" type="radio" value="update-useglobal" class="code" ' . checked( 'update-useglobal', $sync_setting, false ) . ' /> <p>' . esc_html__( 'Follow global settings for updates', 'wp-listings-pro' ) . ' (is currently set to update ' . esc_html( $current_setting ) . ').</p></label></div>';
echo '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="WPLPROAgents[_listing_sync_update]" id="_listing_sync_update_all" type="radio" value="update-all" class="code" ' . checked( 'update-all', $sync_setting, false ) . ' /> <p>' . esc_html__( 'Keep everything up to date.', 'wp-listings-pro' ) . ' <br /></p></label></div>';
echo '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="WPLPROAgents[_listing_sync_update]" id="_listing_sync_update_none" type="radio" value="update-none" class="code" ' . checked( 'update-none', $sync_setting, false ) . ' /> <p><strong>' . esc_html__( 'Not recommended as displaying inaccurate MLS data may violate your IDX agreement.', 'wp-listings-pro' ) . '</strong><br />' . esc_html__( 'Do not update any fields.', 'wp-listings-pro' ) . '<br /></p></label></div>';
echo '</div></div>';

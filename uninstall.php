<?php
/**
 * Uninstall
 *
 * @package WP-Listings-Pro
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit(); }

$settings = get_option( 'wplpro_plugin_settings' );

if ( true === $settings['wplpro_uninstall_delete'] ) {

	wplpro_delete_listings();

	// Delete our Options.
	delete_site_option( 'wplpro_plugin_settings' );
	delete_site_option( 'wplpro_idx_featured_listing_wp_options' );
	delete_site_option( 'WPLPRO_Taxonomies' );
	delete_site_option( 'WPLPROAgents_taxonomies' );
	delete_site_option( 'widget_wplistings-featured-listings' );
	delete_site_option( 'widget_listings-search' );

	// Delete cron job.
	wp_clear_scheduled_hook( 'wplpro_idx_update' );

}

/**
 * Find and Delete all Listings.
 *
 * @access public
 * @return void
 */
function wplpro_delete_listings() {
	global $wpdb;

	// Get all Listings.
	$args = array(
		'post_type' => array( 'listing' ),
		'nopaging'  => true,
	);

	// Remove all Listings.
	$query = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		$identifier   = get_the_ID();
		$taxonomies   = array( 'status', 'locations', 'features', 'property-types' );
		$post_feat_id = get_post_thumbnail_id( $identifier );

		wp_delete_attachment( $post_feat_id );
		delete_post_meta_by_key( ! empty( $identifier->ID ) );
		wp_delete_object_term_relationships( $identifier, $taxonomies );
		wp_delete_post( $identifier, true );
	}

	$wpdb->query( "DELETE FROM `{$wpdb->prefix}options` WHERE option_name LIKE '_transient_equity_listing_%'" );

	// Reset PostData.
	wp_reset_postdata();
}

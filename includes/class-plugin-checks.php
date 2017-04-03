<?php


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );




// Check for IMPress for IDX Broker.
// Check for IMPress Listings (aka WP-Listings).
// Check for IMPress Agents.
// Check for WP Property.
// Check for WPL Real Estate.
// Check for Contempo Real Estate Custom Posts.
// Check for Simple Real Estate Pack.
// Check for Easy Property Listings.
// Check for Essential Real Estate.
// Check for Genesis Agent Profiles Plugin.
function is_genesis_agent_profiles_active() {
	if ( is_plugin_active( 'genesis-agent-profiles/plugin.php' ) ) {
		return true;
	} else {
		return false;
	}
}

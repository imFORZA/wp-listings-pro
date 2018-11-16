<?php
/**
 * Plugin Checks.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';


// TODO: Check for IMPress for IDX Broker.
// TODO: Check for IMPress Listings (aka WP-Listings).
// TODO: Check for IMPress Agents.
// TODO: Check for WP Property.
// TODO: Check for WPL Real Estate.
// TODO: Check for Contempo Real Estate Custom Posts.
// TODO: Check for Simple Real Estate Pack.
// TODO: Check for Easy Property Listings.
// TODO: Check for Essential Real Estate.
/**
 * Check for Genesis Agent Profiles Plugin.
 *
 * @access public
 * @return True or False.
 */
function is_genesis_agent_profiles_active() {
	if ( is_plugin_active( 'genesis-agent-profiles/plugin.php' ) ) {
		return true;
	} else {
		return false;
	}
}

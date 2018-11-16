<?php
/**
 * Welcome Logic
 *
 * @since 1.0.0
 * @package WPW
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome page redirect.
 *
 * Only happens once and if the site is not a network or multisite.
 *
 * @since 1.0.0
 */
function wplpro_safe_welcome_redirect() {

	// Bail if no activation redirect transient is present.
	if ( ! get_transient( '_welcome_redirect_wplpro' ) ) {

		return;

	}

	// Delete the redirect transient.
	delete_transient( '_welcome_redirect_wplpro' );

	// Bail if activating from network or bulk sites.
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	// Redirect to Welcome Page.
	// Redirects to `your-domain.com/wp-admin/plugin.php?page=wplpro_welcome_page`.
	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'wplpro_welcome_page',
			),
			admin_url( 'plugins.php' )
		)
	);

}

add_action( 'admin_init', 'wplpro_safe_welcome_redirect' );

/**
 * Adds welcome page sub menu.
 *
 * @since 1.0.0
 */
function wplpro_welcome_page() {

	global $wplpro_sub_menu;

	$wplpro_sub_menu = add_submenu_page(
		'plugins.php', // The slug name for the parent menu (or the file name of a standard WordPress admin page).
		__( 'Welcome to WP Listings Pro', 'wp-listings-pro' ), // The text to be displayed in the title tags of the page when the menu is selected.
		__( 'WP Listing Pro', 'wp-listings-pro' ), // The text to be used for the menu.
		'read', // The capability required for this menu to be displayed to the user.
		'wplpro_welcome_page', // The slug name to refer to this menu by (should be unique for this menu).
		'wplpro_welcome_page_content' // The function to be called to output the content for this page.
	);

}
add_action( 'admin_menu', 'wplpro_welcome_page' );

add_action( 'admin_head', 'remove_menu_entry' );


/**
 * Remove Menu Entry.
 *
 * @access public
 * @return void
 */
function remove_menu_entry() {
	remove_submenu_page( 'plugins.php', 'wplpro_welcome_page' );
}

/**
 * Welcome page content.
 *
 * @since 1.0.0
 */
function wplpro_welcome_page_content() {

	if ( file_exists( WPLPRO_DIR . '/welcome/welcome-view.php' ) ) {

		require_once WPLPRO_DIR . '/welcome/welcome-view.php';

	}
}

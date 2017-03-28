<?php
/**
 * Main Plugin File.
 *
 * @package WP-Listings-Pro
 */

/**
 * Plugin Name: WP Listings Pro
 * Plugin URI: http://wordpress.org/plugins/wp-listings/
 * Description: Creates a real estate listing management system. Designed to work with any theme using built-in templates.
 * Author: imFORZA
 * Author URI: https://www.imforza.com
 * Text Domain: wp-listings-pro
 *
 * Version: 2.2.2
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

register_activation_hook( __FILE__, 'wplpro_activation' );
/**
 * This function runs on plugin activation. It flushes the rewrite rules to prevent 404's
 *
 * @since 0.1.0
 */
function wplpro_activation() {

	wplpro_init();

	/** Flush rewrite rules */
	if ( ! post_type_exists( 'listing' ) ) {

		global $_wp_listings, $_wplpro_taxonomies, $_wp_listings_templates;
		$_wp_listings->create_post_type();
		$_wplpro_taxonomies->register_taxonomies();
	}

	/** Flush rewrite rules */
	if ( ! post_type_exists( 'employee' ) ) {
		global $_wplpro_agents, $_wplpro_agents_taxonomies;
		$_wplpro_agents->create_post_type();
		$_wplpro_agents_taxonomies->register_taxonomies();
	}

	flush_rewrite_rules();

	$notice_keys = array( 'wpl_notice_idx', 'wpl_listing_notice_idx', 'wpl_notice_equity' );
	foreach ( $notice_keys as $notice ) {
		delete_user_meta( get_current_user_id(), $notice );
	}
}

register_deactivation_hook( __FILE__, 'wplpro_deactivation' );
/**
 * This function runs on plugin deactivation. It flushes the rewrite rules to get rid of remnants
 *
 * @since 1.0.8
 */
function wplpro_deactivation() {

	flush_rewrite_rules();

	$notice_keys = array( 'wpl_notice_idx', 'wpl_listing_notice_idx', 'wpl_notice_equity' );
	foreach ( $notice_keys as $notice ) {
		delete_user_meta( get_current_user_id(), $notice );
	}
}

add_action( 'after_setup_theme', 'wplpro_init' );

/**
 * Initialize Listings.
 *
 * Include the libraries, define global variables, instantiate the classes.
 *
 * @since 0.1.0
 */
function wplpro_init() {

	global $_wp_listings, $_wplpro_taxonomies, $_wp_listings_templates, $_wplpro_agents, $_wplpro_agents_taxonomies;

	define( 'wplpro_AGENTS_URL', plugin_dir_url( __FILE__ ) );
	define( 'wplpro_AGENTS_VERSION', '1.1.3' );

	define( 'WP_LISTINGS_URL', plugin_dir_url( __FILE__ ) );
	define( 'WP_LISTINGS_DIR', plugin_dir_path( __FILE__ ) );
	define( 'WP_LISTINGS_VERSION', '2.2.2' );

	/** Load textdomain for translation */
	load_plugin_textdomain( 'wp-listings-pro', false, basename( dirname( __FILE__ ) ) . '/languages/' );


	/** Make sure is_plugin_active() can be called */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if ( is_plugin_active( 'genesis-agent-profiles/plugin.php' ) ) {
		add_action( 'wp_loaded', 'wplpro_agents_migrate' );
	}

	/** Includes. */
	require_once( dirname( __FILE__ ) . '/includes/class-listings.php' );
	require_once( dirname( __FILE__ ) . '/includes/class-agents.php' );

	require_once( dirname( __FILE__ ) . '/includes/helpers.php' );
	require_once( dirname( __FILE__ ) . '/includes/functions.php' );
	require_once( dirname( __FILE__ ) . '/includes/shortcodes.php' );

	require_once( dirname( __FILE__ ) . '/includes/class-taxonomies.php' );
	require_once( dirname( __FILE__ ) . '/includes/class-listing-template.php' );

	require_once( dirname( __FILE__ ) . '/includes/class-admin-notice.php' );
	require_once( dirname( __FILE__ ) . '/includes/wp-api.php' );

	require_once( dirname( __FILE__ ) . '/includes/widgets/class-listings-search-widget.php' );
	require_once( dirname( __FILE__ ) . '/includes/widgets/class-featured-listings-widget.php' );
	require_once( dirname( __FILE__ ) . '/includes/widgets/class-employee-widget.php' );

	require_once( dirname( __FILE__ ) . '/includes/class-listing-import.php' );
	require_once( dirname( __FILE__ ) . '/includes/class-agent-import.php' );

	require_once( dirname( __FILE__ ) . '/includes/class-migrate-old-posts.php' );

	/** Instantiate */
	$_wplpro_agents = new wplpro_Agents;
	$_wplpro_agents_taxonomies = new WPLPRO_Agents_Taxonomies;

	/** Add theme support for post thumbnails if it does not exist */
	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		add_theme_support( 'post-thumbnails' );
	}



	/**
	 * Add_wp_listings_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	function wplpro_add_scripts() {
		wp_register_script( 'wp-listings-single', WP_LISTINGS_URL . 'assets/js/single-listing.min.js', array( 'jquery' ), null, true ); // Enqueued only on single listings.
		wp_register_script( 'jquery-validate', WP_LISTINGS_URL . 'assets/js/jquery.validate.min.js', array( 'jquery' ), null, true ); // Enqueued only on single listings.
		wp_register_script( 'fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), null, true ); // Enqueued only on single listings.
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs', array( 'jquery' ) );
	}

	/** Registers and enqueues scripts for single listings. */
	add_action( 'wp_enqueue_scripts', 'wplpro_add_scripts' );

	/** Enqueues wp-listings.css style file if it exists and is not deregistered in settings */
	add_action( 'wp_enqueue_scripts', 'add_wp_listings_main_styles' );

	/**
	 * Add_wp_listings_main_styles function.
	 *
	 * @access public
	 * @return void
	 */
	function add_wp_listings_main_styles() {

		$options = get_option( 'wplpro_plugin_settings' );

		$options = get_option( 'wplpro_agents_settings' );

		if ( ! isset( $options['wplpro_stylesheet_load'] ) ) {
			$options['wplpro_stylesheet_load'] = 0;
		}

		if ( '1' === $options['wplpro_stylesheet_load'] ) {
			return;
		}

		wp_register_style( 'agents-css', WP_LISTINGS_URL . 'assets/css/wplpro-agents.min.css', '', null, 'all' );
		wp_enqueue_style( 'agents-css' );

		/** Register single styles but don't enqueue them */
		wp_register_style( 'wp-listings-single', WP_LISTINGS_URL . 'assets/css/wp-listings-single.min.css', '', null, 'all' );

		/** Register Font Awesome icons but don't enqueue them */
		wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', '', null, 'all' );
		wp_enqueue_style( 'font-awesome' );

		/** Register Properticons but don't enqueue them */
		wp_register_style( 'properticons', 'https://s3.amazonaws.com/properticons/css/properticons.css', '', null, 'all' );

		if ( ! isset( $options['wplpro_stylesheet_load'] ) ) {
			$options['wplpro_stylesheet_load'] = 0;
		}

		if ( '1' === $options['wplpro_stylesheet_load'] ) {
			return;
		}

		if ( file_exists( dirname( __FILE__ ) . '/assets/css/wp-listings.css' ) ) {
			wp_register_style( 'wp_listings', WP_LISTINGS_URL . 'assets/css/wp-listings.css', '', null, 'all' );
			wp_enqueue_style( 'wp_listings' );
		}

	}

	/**
	 * wplpro_agents_admin_scripts_styles function.
	 *
	 * @access public
	 * @return void
	 */
	function wplpro_agents_admin_scripts_styles() {
		wp_enqueue_style( 'wplpro_agents_admin_css', WP_LISTINGS_URL . 'assets/css/wplpro-agents-admin.min.css' );

		wp_enqueue_script( 'wplpro-agents-admin', WP_LISTINGS_URL . 'assets/js/admin.min.js', 'media-views' );

		$localize_script = array(
			'title'        => __( 'Set Term Image', 'wp-listings-pro' ),
			'button'       => __( 'Set term image', 'wp-listings-pro' ),
		);

		/* Pass custom variables to the script. */
		wp_localize_script( 'wplpro-agents-admin', 'impa_term_image', $localize_script );

		wp_enqueue_media();

	}
	add_action( 'admin_enqueue_scripts', 'wplpro_agents_admin_scripts_styles' );

	/** Enqueues wp-listings-widgets.css style file if it exists and is not deregistered in settings. */
	add_action( 'wp_enqueue_scripts', 'add_wp_listings_widgets_styles' );

	/**
	 * Add_wp_listings_widgets_styles function.
	 *
	 * @access public
	 * @return void
	 */
	function add_wp_listings_widgets_styles() {

		$options = get_option( 'wplpro_plugin_settings' );

		if ( ! isset( $options['wplpro_widgets_stylesheet_load'] ) ) {
			$options['wplpro_widgets_stylesheet_load'] = 0;
		}

		if ( '1' === $options['wplpro_widgets_stylesheet_load'] ) {
			return;
		}

		if ( file_exists( dirname( __FILE__ ) . '/assets/css/wp-listings-widgets.css' ) ) {
			wp_register_style( 'wp_listings_widgets', WP_LISTINGS_URL . 'assets/css/wp-listings-widgets.css', '', null, 'all' );
			wp_enqueue_style( 'wp_listings_widgets' );
		}
	}

	/**
	 * Add admin scripts and styles
	 *
	 * @access public
	 * @return void
	 */
	function wp_listings_admin_scripts_styles() {
		wp_enqueue_style( 'wp_listings_admin_css', WP_LISTINGS_URL . 'assets/css/wp-listings-admin.css' );

		/** Enqueue Font Awesome in the Admin if IDX Broker is not installed */
		if ( ! class_exists( 'Idx_Broker_Plugin' ) ) {
			wp_register_style( 'font-awesome-admin', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', '', null, 'all' );
			wp_enqueue_style( 'font-awesome-admin' );
			wp_enqueue_style( 'upgrade-icon', WP_LISTINGS_URL . 'assets/css/wp-listings-upgrade.css' );
		}

		global $wp_version;
		$nonce_action = 'wp_listings_admin_notice';

		wp_enqueue_style( 'wp-listings-admin-notice', WP_LISTINGS_URL . 'assets/css/wp-listings-admin-notice.css' );
		wp_enqueue_script( 'wp-listings-admin', WP_LISTINGS_URL . 'assets/js/admin.min.js', 'media-views' );
		wp_localize_script( 'wp-listings-admin', 'wp_listings_adminL10n', array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( $nonce_action ),
			'wp_version' => $wp_version,
			'dismiss'    => __( 'Dismiss this notice', 'wp-listings-pro' ),
		) );

		$localize_script = array(
			'title'        => __( 'Set Term Image', 'wp-listings-pro' ),
			'button'       => __( 'Set term image', 'wp-listings-pro' ),
		);

		/* Pass custom variables to the script. */
		wp_localize_script( 'wp-listings-admin', 'wplpro_term_image', $localize_script );

		wp_enqueue_media();

	}
	add_action( 'admin_enqueue_scripts', 'wp_listings_admin_scripts_styles' );

	/** Instantiate */
	$_wp_listings = new WP_Listings;
	$_wplpro_taxonomies = new wplpro_taxonomies;
	$_wp_listings_templates = new Single_Listing_Template;

	add_action( 'widgets_init', 'wp_listings_register_widgets' );

	/**
	 * Function to add admin notices
	 *
	 * @param  string  $message    the error messag text.
	 * @param  boolean $error      html class - true for error false for updated.
	 * @param  string  $cap_check  required capability.
	 * @param  boolean $ignore_key ignore key.
	 * @return string              HTML of admin notice.
	 *
	 * @since  1.3
	 */
	function wp_listings_admin_notice( $message, $error = false, $cap_check = 'activate_plugins', $ignore_key = false ) {
		$_wp_listings_admin = new WP_Listings_Admin_Notice;
		return $_wp_listings_admin->notice( $message, $error, $cap_check, $ignore_key );
	}

	/**
	 * Admin notice AJAX callback
	 *
	 * @since  1.3
	 */
	add_action( 'wp_ajax_wp_listings_admin_notice', 'wp_listings_admin_notice_cb' );

	/**
	 * Wp_listings_admin_notice_cb function.
	 *
	 * @access public
	 * @return ajax call.
	 */
	function wp_listings_admin_notice_cb() {
		$_wp_listings_admin = new WP_Listings_Admin_Notice;
		return $_wp_listings_admin->ajax_cb();
	}

}

/**
 * Register Widgets that will be used in the WP Listings plugin
 *
 * @since 0.1.0
 */
function wp_listings_register_widgets() {

	$listing_widgets = array( 'WP_Listings_Featured_Listings_Widget', 'WP_Listings_Search_Widget' );

	$agent_widgets = array( 'wplpro_Agents_Widget' );

	foreach ( (array) $listing_widgets as $listing_widget ) {
		register_widget( $listing_widget );
	}


	foreach ( (array) $agent_widgets as $agent_widget ) {
		register_widget( $agent_widget );
	}


}

/**
 * wplpro_agents_migrate function.
 *
 * @access public
 * @return void
 */
function wplpro_agents_migrate() {
	new wplpro_Agents_Migrate();
}


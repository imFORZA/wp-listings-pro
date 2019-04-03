<?php
/**
 * Main Plugin File.
 *
 * @package WP-Listings-Pro
 */

/**
 * Plugin Name: WP Listings Pro
 * Plugin URI: http://wordpress.org/plugins/wp-listings/
 * Description: Manages both listings and agents through an IDX broker or invidually, along with linking them together.
 * Author: imFORZA
 * Author URI: https://www.imforza.com
 * Text Domain: wp-listings-pro
 *
 * Version: 3.0.14
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// require_once('modules/class-wplpro-settings.php');
// Register Activation Hook.
register_activation_hook( __FILE__, 'wplpro_activation' );

/**
 * This function runs on plugin activation. It flushes the rewrite rules to prevent 404's
 *
 * @since 0.1.0
 */
function wplpro_activation() {

	if ( function_exists( 'wp_listings_init' ) || function_exists( 'impress_agents_init' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( 'WP-Listings-Pro cannot be activated while either IMPress Listings or Agents is active. Please press the back button in your browser, and make sure both of those plugins are not enabled before reactivating WP Listings Pro.' );
	}

	wplpro_init();

	wplpro_import_image_gallery();

	$options = get_option( 'wplpro_plugin_settings' );
	if ( ! isset( $options['wplpro_api_key'] ) || get_option( 'idx_broker_apikey' ) !== false ) {
		$options['wplpro_api_key'] = get_option( 'idx_broker_apikey' );
		update_option( 'wplpro_plugin_settings', $options );
	}

	wplpro_setall_hidden_price();

	wplpro_add_user_role_lead();

	/** Flush rewrite rules. */
	if ( ! post_type_exists( 'listing' ) ) {

		global $_wp_listings, $_wplpro_taxonomies, $_wp_listings_templ;
		$_wp_listings->create_post_type();
		$_wplpro_taxonomies->register_taxonomies();
	}

	/** Flush rewrite rules. */
	if ( ! post_type_exists( 'employee' ) ) {
		global $_wplpro_agents, $_wplpro_agents_tax;
		$_wplpro_agents->create_post_type();
		$_wplpro_agents_tax->register_taxonomies();
	}

	if ( ! wp_next_scheduled( 'wplpro_clear_transients' ) ) {
		wp_schedule_event( time(), 'daily', 'wplpro_clear_transients' );
	}

	flush_rewrite_rules();

	$notice_keys = array( 'wpl_notice_idx', 'wpl_listing_notice_idx', 'wpl_notice_equity' );
	foreach ( $notice_keys as $notice ) {
		delete_user_meta( get_current_user_id(), $notice );
	}

	update_option( 'wplpro_idx_featured_listing_wp_options', get_option( 'wp_listings_idx_featured_listing_wp_options' ) );

	// Welcome Page Transient max age is 60 seconds.
	set_transient( '_welcome_redirect_wplpro', true, 60 );
}


/**
 * WPLPRO Import Image Gallery.
 *
 * @access public
 * @return void
 */
function wplpro_import_image_gallery() {

	// Get all old listings.
	$old_listings = get_posts(
		array(
			'post_type'      => 'listing',
			'posts_per_page' => -1,
		)
	);
	foreach ( $old_listings as $listing ) {
		$old_gallery = get_post_meta( $listing->ID, '_listing_gallery', true );

		// Get all http or https urls within the block gallery.
		preg_match_all( '/(http|https)?:\/\/[^ ]+?(?:\.jpg|\.png|\.gif|\.jpeg|\.svg)/', $old_gallery, $matches );

		// Check for current listings.
		$ids = array();
		foreach ( $matches[0] as $image_url_dirty ) {
			$pattern     = '/\-*(\d+)x(\d+)\.(.*)$/';
			$replacement = '.$3';
			// Filter out URL from their form.
			$image_url_clean = preg_replace( $pattern, $replacement, $image_url_dirty );
			$image_id        = wplpro_get_image_id( $image_url_clean );

			// Note: this only works if the image already exists in WordPress.
			//
			// It does not create the image if it can't find it.
			$ids[ count( $ids ) ] = $image_id;
		}

		// If we already have a gallery, get it.
		$listing_gallery;
		$wplpro_images;
		if ( metadata_exists( 'post', $listing->ID, '_listing_image_gallery' ) ) {
			$listing_gallery = get_post_meta( $listing->ID, '_listing_image_gallery', true );
			$wplpro_images   = array_filter( explode( ',', $listing_gallery ) );
		} else {
			$wplpro_images = array();
		}
		// $wplpro_images = array_filter( explode( ',', $listing_image_gallery ) );
		// Only add images that aren't already in the listing (in case the client jumps around plugins, this is a non-duplicating merging).
		$images_to_append = $ids;
		$length_images    = count( $wplpro_images );
		$length_ids       = count( $ids );
		for ( $i = 0; $i < $length_images; $i++ ) {
			for ( $j = 0; $j < $length_ids; $j++ ) {
				if ( $ids[ $j ] === $wplpro_images[ $i ] ) {
					$images_to_append[ $j ] = -1;
					$j                      = count( $ids );
				}
			}
		}

		// Now have array of what we need, only add elements that we need.
		// Could probably also be done using array_filter...
		foreach ( $images_to_append as $image ) {
			if ( -1 !== $image ) {
				$wplpro_images[ count( $wplpro_images ) ] = $image;
			}
		}

		update_post_meta( $listing->ID, '_listing_image_gallery', implode( ',', $wplpro_images ) );
	}
}

register_deactivation_hook( __FILE__, 'wplpro_deactivation' );
/**
 * This function runs on plugin deactivation. It flushes the rewrite rules to get rid of remnants.
 *
 * @since 1.0.8
 */
function wplpro_deactivation() {

	wp_clear_scheduled_hook( 'wplpro_clear_transients' );

	flush_rewrite_rules();

	$notice_keys = array( 'wpl_notice_idx', 'wpl_listing_notice_idx', 'wpl_notice_equity' );
	foreach ( $notice_keys as $notice ) {
		delete_user_meta( get_current_user_id(), $notice );
	}

	delete_transient( '_welcome_redirect_wplpro' );
}

/**
 *  Displays nag stating that plugin has been disabled (in-case of incompatibility with other plugins that could try handling the same information we are).
 */
function wplpro_disable_notice() {
	?>
	<div class="update-nag notice dismissable">
		<p>WP Listings Pro has been rendered non-functional (though not deactivated yet), since it appears you've re-enabled IMPress Listings or Agents. Unfortunately, WP Listings Pro is incompatible with either of these plugins, and we've disabled it for your safety. If you'd wish to re-enable it, please go to your plugins page, and make sure both IMPress Agents and Listings are not enabled, and then re-enable WP Listings Pro. Otherwise, to make this notice go away, please go to your plugins page, and disable WP Listings Pro</p>
	</div>
	<?php
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

	if ( function_exists( 'wp_listings_init' ) || function_exists( 'impress_agents_init' ) ) {
		deactivate_plugins( basename( __FILE__ ) );

		// Since sometimes deactivate_plugins doesn't work so hot.
		add_action( 'admin_notices', 'wplpro_disable_notice' );
		return;
	}

	global $_wp_listings, $_wplpro_taxonomies, $_wp_listings_templ, $_wplpro_agents, $_wplpro_agents_tax;

	define( 'WPLPRO_URL', plugin_dir_url( __FILE__ ) );
	define( 'WPLPRO_DIR', plugin_dir_path( __FILE__ ) );
	define( 'WPLPRO_VERSION', '3.0.4' );
	define( 'WPLPRO_DB_VERSION', '1.0.0' );

	/** Load textdomain for translation. */
	load_plugin_textdomain( 'wp-listings-pro', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	/** Make sure is_plugin_active() can be called. */
	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	// Check for Genesis Agent Profiles Plugin.
	if ( is_plugin_active( 'genesis-agent-profiles/plugin.php' ) ) {
		add_action( 'wp_loaded', 'wplpro_agents_migrate' );
	}

	/** Includes. */
	require_once plugin_dir_path( __FILE__ ) . 'includes/wp-reso/wp-reso.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-post-types.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-listings.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agents.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/helpers.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/rest-api.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-taxonomies.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-notice.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/wp-api.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/class-wp-listings-search-widget.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/class-wp-listings-featured-listings-widget.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/class-wplproagents-widget.php';

	include_once plugin_dir_path( __FILE__ ) . 'includes/class-listing-register-meta.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-listing-gallery-metabox.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-listing-import.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agent-import.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wplpro-idx-api.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-saved-searches.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-migrate-old-posts.php';

	require_once plugin_dir_path( __FILE__ ) . 'welcome/welcome-logic.php';

	/** Instantiate */
	$_wplpro_agents     = new WPLPROAgents();
	$_wplpro_agents_tax = new WPLPROAgents_Taxonomies();

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
		wp_register_script( 'wp-listings-single', WPLPRO_URL . 'assets/js/single-listing.min.js', array( 'jquery' ), '1.0.0', true ); // Enqueued only on single listings.
		wp_register_script( 'fitvids', 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js', array( 'jquery' ), '1.2.0', true ); // Enqueued only on single listings.
		wp_register_script( 'bxslider', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js', array( 'jquery' ), '4.2.15', true );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs', array( 'jquery' ), '', '1.0.0', true );
	}

	/** Registers and enqueues scripts for single listings. */
	add_action( 'wp_enqueue_scripts', 'wplpro_add_scripts' );

	/** Enqueues wp-listings.css style file if it exists and is not deregistered in settings. */
	add_action( 'wp_enqueue_scripts', 'add_wp_listings_main_styles' );

	/**
	 * Add_wp_listings_main_styles function.
	 *
	 * @access public
	 * @return void
	 */
	function add_wp_listings_main_styles() {

		$options = get_option( 'wplpro_plugin_settings' );

		if ( ! isset( $options['disable_css'] ) ) {
			$options['disable_css'] = 0;
		}
		if ( '1' !== $options['disable_css'] ) {
			wp_register_style( 'wp_listings', WPLPRO_URL . 'assets/css/wp-listings-pro.css', '', '1.0.0', 'all' );
			wp_enqueue_style( 'wp_listings' );
		}

		/** Register Font Awesome icons but don't enqueue them. */
		if ( ! isset( $options['disable_fontawesome'] ) ) {
			$options['disable_fontawesome'] = 0;
		}
		if ( '1' !== $options['disable_fontawesome'] ) {
			wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', '', '5.5.0', 'all' );
			wp_enqueue_style( 'fontawesome' );
		}

		/** Register Properticons but don't enqueue them. */
		if ( ! isset( $options['disable_properticons'] ) ) {
			$options['disable_properticons'] = 0;
		}
		if ( '1' !== $options['disable_properticons'] ) {
			wp_register_style( 'properticons', WPLPRO_URL . 'assets/css/properticons.min.css', '', '1.0.0', 'all' );
		}

		/** Register single styles but don't enqueue them. */
		wp_register_style( 'wp-listings-single', WPLPRO_URL . 'assets/css/wp-listings-single.min.css', '', '1.0.0', 'all' );
		wp_register_style( 'bxslider', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css', '', '4.2.15', 'all' );

	}

	/**
	 * WPLPRO Admin Scripts & Styles.
	 *
	 * @access public
	 * @return void
	 */
	function wplpro_admin_scripts_styles() {
		$localize_script = array(
			'title'  => __( 'Set Term Image', 'wp-listings-pro' ),
			'button' => __( 'Set term image', 'wp-listings-pro' ),
		);

		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_style( 'wp_listings_admin_css', WPLPRO_URL . 'assets/css/wplpro-admin.min.css', '', '1.0.0', 'all' );

		wp_enqueue_script( 'wp_listings_idx_listing_lazyload', WPLPRO_URL . 'assets/js/jquery.lazyload.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'images-loaded', WPLPRO_URL . 'assets/js/imagesloaded.min.js', array( 'jquery' ), '1.0.0', true );
		/** Enqueue Font Awesome in the Admin if IDX Broker is not installed */
		if ( ! class_exists( 'Idx_Broker_Plugin' ) ) {
			wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', '', '5.5.0', 'all' );
			wp_enqueue_style( 'fontawesome' );
			wp_enqueue_style( 'upgrade-icon', WPLPRO_URL . 'assets/css/wp-listings-upgrade.css', '', '1.0.0', 'all' );
		}

		global $wp_version;
		$nonce_action = 'WPLPRO_Admin_Notice';
		wp_enqueue_script( 'wp-listings-admin', WPLPRO_URL . 'assets/js/admin.min.js', 'media-views', '1.0.0', true );
		wp_localize_script(
			'wp-listings-admin',
			'wp_listings_adminL10n',
			array(
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'othernonce' => wp_create_nonce( $nonce_action ),
				'wp_version' => $wp_version,
				'dismiss'    => __( 'Dismiss this notice', 'wp-listings-pro' ),
				'root'       => esc_url_raw( rest_url() ),
				'nonce'      => wp_create_nonce( 'wp_rest' ),
			)
		);

		/* Pass custom variables to the script. */
		wp_localize_script( 'wp-listings-admin', 'wplpro_term_image', $localize_script );

		wp_enqueue_media();

	}

	// Add our Widget Styles.
	add_action( 'wp_enqueue_scripts', 'wplpro_add_widget_styles' );

	/**
	 * Add Widget Styles.
	 *
	 * @access public
	 * @return void
	 */
	function wplpro_add_widget_styles() {

		$options = get_option( 'wplpro_plugin_settings' );

		if ( ! isset( $options['wplpro_widgets_stylesheet_load'] ) ) {
			$options['wplpro_widgets_stylesheet_load'] = 0;
		}

		if ( '1' === $options['wplpro_widgets_stylesheet_load'] ) {
			return;
		}

		if ( file_exists( dirname( __FILE__ ) . '/assets/css/wp-listings-widgets.css' ) ) {
			wp_register_style( 'wp_listings_widgets', WPLPRO_URL . 'assets/css/wp-listings-widgets.css', '', '1.0.0', 'all' );
			wp_enqueue_style( 'wp_listings_widgets' );
		}
	}

	/** Instantiate. */
	$_wp_listings       = new WP_Listings();
	$_wplpro_taxonomies = new WPLPRO_Taxonomies();

	add_action( 'widgets_init', 'wplpro_register_widgets' );

	/**
	 * Function to add admin notices
	 *
	 * @param  string  $message    the error message text.
	 * @param  boolean $error      html class - true for error false for updated.
	 * @param  string  $cap_check  required capability.
	 * @param  boolean $ignore_key ignore key.
	 * @return string              HTML of admin notice.
	 *
	 * @since  1.3
	 */
	function WPLPRO_Admin_Notice( $message, $error = false, $cap_check = 'activate_plugins', $ignore_key = false ) {
		$_wp_listings_admin = new WPLPRO_Admin_Notice();
		return $_wp_listings_admin->notice( $message, $error, $cap_check, $ignore_key );
	}

	/**
	 * Admin notice AJAX callback.
	 *
	 * @since  1.3
	 */
	add_action( 'wp_ajax_WPLPRO_Admin_Notice', 'wplpro_adminnotice_cb' );

	/**
	 * WPLPRO Admin notice callback function.
	 *
	 * @access public
	 * @return ajax call.
	 */
	function wplpro_adminnotice_cb() {
		$_wp_listings_admin = new WPLPRO_Admin_Notice();
		return $_wp_listings_admin->ajax_cb();
	}

}

/**
 * Register Widgets that will be used in the WP Listings plugin.
 *
 * @since 0.1.0
 */
function wplpro_register_widgets() {

	$listing_widgets = array( 'WP_Listings_Featured_Listings_Widget', 'WP_Listings_Search_Widget' );

	$agent_widgets = array( 'WPLPROAgents_Widget' );

	foreach ( (array) $listing_widgets as $listing_widget ) {
		register_widget( $listing_widget );
	}

	foreach ( (array) $agent_widgets as $agent_widget ) {
		register_widget( $agent_widget );
	}

}

/**
 * WPLPRO Agents Migrate.
 *
 * @access public
 * @return void
 */
function wplpro_agents_migrate() {
	new WPLPROAgents_Migrate();
}

add_action( 'save_post', 'wplpro_save_post', 10, 2 );

/**
 * Save price without extra chars.
 *
 * @param  [int]    $post_id  : WP post ID.
 * @param  [Object] $post   : WP post object.
 */
function wplpro_save_post( $post_id, $post ) {
	// Check the post type .
	if ( 'listing' === $post->post_type ) {
		// Check if price field has been set.
		if ( isset( $_POST['wp_listings']['_listing_price'] ) && isset( $_POST['wp-hide-price-name'] ) && wp_verify_nonce( $_POST['wp-hide-price-name'], 'wp-hide-price-action' ) ) {
			// Set hidden price meta_field.
			$price = filter_var( $_POST['wp_listings']['_listing_price'], FILTER_SANITIZE_STRING ); // Sanitize data, only allow it to be certain characters.
			wplpro_set_hidden_price( $post_id, $price );
		}
	}
}

/**
 * Set hidden price for a single listing.
 *
 * @param [int]    $post_id  : WP post ID.
 * @param [string] $price    : Price string to sanitize and save.
 * @param [array]  $posts    : Array of pinned posts.
 */
function wplpro_set_hidden_price( $post_id, $price, $posts = null ) {
	static $pinned;

	if ( ! isset( $pinned ) ) {  // Only set $pinned static var once.
		// If posts passed in use those.
		if ( isset( $posts ) ) {
			$pinned = $posts;
		} else {
			$options = get_option( 'wplpro_plugin_settings' );
			$pinned  = ( isset( $options['pinned'] ) ) ? $options['pinned'] : array();
		}
	}

	// Sanitize price.
	$price = wplpro_strip_price( $price );

	// If pinned set hidden price really really high so they show up on top when sorting by price.
	if ( in_array( (int) $post_id, $pinned, true ) ) {
			$price = 500000000;
	}
	if ( empty( $price ) ) {
		$price = 0;
	}

	update_post_meta( $post_id, '_listing_hidden_price', $price );
}

/**
 * Save hidden price on all listings.
 */
function wplpro_setall_hidden_price() {
	// Grab all listings.
	$listings = get_posts(
		array(
			'post_type'              => 'listing',
			'orderby'                => 'post_id',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			// TODO: Don't use -1, https://10up.github.io/Engineering-Best-Practices/php/ !
			'posts_per_page'         => -1,
		)
	);

	// Loop and set hidden price.
	foreach ( $listings as $listing ) {
		$price = get_post_meta( $listing->ID, '_listing_price', true );
		wplpro_set_hidden_price( $listing->ID, $price );
	}
}

$options = get_option( 'wplpro_plugin_settings' );
if ( ! isset( $options['enable_sort'] ) ) {
	$options['enable_sort'] = 0;
}
if ( ! empty( $options ) && $options['enable_sort'] ) {
	add_action( 'pre_get_posts', 'wplpro_pre_get_listings', 99999 );
}

/**
 * Modify listing search query.
 *
 * @param  [Object] $query : WP query object.
 * @return [Object]        : Modified query.
 */
function wplpro_pre_get_listings( $query ) {
	// Do not modify queries in the admin.
	if ( is_admin() || is_feed() ) {
		return $query;
	}

	if ( $query->is_tax() ) {
		// Do a fully inclusive search for currently registered post types of queried taxonomies.
		$post_type  = array();
		$taxonomies = array_keys( $query->tax_query->queried_terms );
		foreach ( get_post_types( array( 'exclude_from_search' => false ) ) as $pt ) {
			$object_taxonomies = 'attachment' === $pt ? get_taxonomies_for_attachments() : get_object_taxonomies( $pt );
			if ( array_intersect( $taxonomies, $object_taxonomies ) ) {
				$post_type[] = $pt;
			}
		}
		if ( ! $post_type ) {
			$post_type = 'any';
		} elseif ( 1 === count( $post_type ) ) {
			$post_type = $post_type[0];
		}
		// Totally stolen from class-wp-query.
	} else {
		$post_type = false;
	}

	// Only modify queries for 'listing' post type.
	if ( 'listing' === $post_type || ( isset( $query->query_vars['post_type'] ) && 'listing' === $query->query_vars['post_type'] ) ) {
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', '_listing_hidden_price' );
		$query->set( 'order', 'DESC' );
	}

	return $query;
}

/**
 * Wplpro_add_user_role_lead function.
 *
 * @access public
 * @return void
 */
function wplpro_add_user_role_lead() {
	add_role(
		'lead',
		'Lead',
		array(
			'read'    => true,
			'level_0' => true,
		)
	);
}


/**
 * Runs after option is saved. Will set hidden price for pinned listings.
 *
 * @param [Array] $option : Array of options to be saved.
 */
function wplpro_set_sort( $option ) {
	$pinned = ( isset( $option['pinned'] ) ) ? $option['pinned'] : array();

	foreach ( $pinned as $post_id ) {
		$price = get_post_meta( $post_id, '_listing_price', true );
		wplpro_set_hidden_price( $post_id, $price, $pinned );
	}

	return $option;
}


/**
 * WPL Pro - Add User Roles.
 *
 * @access public
 * @return void
 */
function wplpro_add_user_roles() {
	add_role(
		'lead',
		'Lead',
		array(
			'read'    => true,
			'level_0' => true,
		)
	);

}
register_activation_hook( __FILE__, 'wplpro_add_user_roles' );



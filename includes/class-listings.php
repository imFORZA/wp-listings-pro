<?php
/**
 * Listings Class
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( function_exists( 'WP_listings' ) ) {
	exit;
}
/**
 * This class handles the creation of the "Listings" post type, and creates a
 * UI to display the Listing-specific data on the admin screens.
 */
class WP_Listings {
	/**
	 * Settings page to load
	 *
	 * @var string
	 */
	var $settings_page = 'wp-listings-settings';
	/**
	 * Taxonomies list
	 *
	 * @var string
	 */
	var $settings_field = 'WPLPRO_Taxonomies';
	/**
	 * Page to register taxonomies
	 *
	 * @var string
	 */
	var $menu_page = 'register-taxonomies';
	/**
	 * Object to hold options, filled in __contrust
	 *
	 * @var object
	 */
	var $options;

	/**
	 * Property details array.
	 *
	 * @var object
	 */
	var $property_details;

	/**
	 * Construct Method.
	 */
	function __construct() {

		$this->options = get_option( 'wplpro_plugin_settings' );

		$this->property_details = apply_filters(
			'wp_listings_property_details',
			array(
				'col1' => array(
					__( 'Price:', 'wp-listings-pro' )      => '_listing_price',
					__( 'Sold Price:', 'wp-listings-pro' ) => '_listing_sold_price',
					__( 'Sold Date:', 'wp_listings' )      => '_listing_sold_date',
					__( 'Rent Price:', 'wp-listings-pro' ) => '_listing_rent_price',
					__( 'Address:', 'wp-listings-pro' )    => '_listing_address',
					__( 'City:', 'wp-listings-pro' )       => '_listing_city',
					__( 'County:', 'wp-listings-pro' )     => '_listing_county',
					__( 'State:', 'wp-listings-pro' )      => '_listing_state',
					__( 'Country:', 'wp-listings-pro' )    => '_listing_country',
					__( 'ZIP:', 'wp-listings-pro' )        => '_listing_zip',
					__( 'MLS #:', 'wp-listings-pro' )      => '_listing_mls',
					__( 'Open House Time & Date:', 'wp-listings-pro' ) => '_listing_open_house',
					__( 'Latitude:', 'wp_listings' )       => '_listing_latitude',
					__( 'Longitude:', 'wp_listings' )      => '_listing_longitude',
				),
				'col2' => array(
					__( 'Year Built:', 'wp-listings-pro' ) => '_listing_year_built',
					__( 'Floors:', 'wp-listings-pro' )     => '_listing_floors',
					__( 'Square Feet:', 'wp-listings-pro' ) => '_listing_sqft',
					__( 'Lot Square Feet:', 'wp-listings-pro' ) => '_listing_lot_sqft',
					__( 'Bedrooms:', 'wp-listings-pro' )   => '_listing_bedrooms',
					__( 'Bathrooms:', 'wp-listings-pro' )  => '_listing_bathrooms',
					__( 'Half Bathrooms:', 'wp-listings-pro' ) => '_listing_half_bath',
					__( 'Garage:', 'wp-listings-pro' )     => '_listing_garage',
					__( 'Pool:', 'wp-listings-pro' )       => '_listing_pool',
					__( 'Constructed Area:', 'wp_listings' ) => '_listing_living_space',
					__( 'Land Size:', 'wp_listings' )      => '_listing_land_size',
					__( 'Currency:', 'wp_listings' )       => '_listing_list_currency',
				),
			)
		);

		$this->extended_property_details = apply_filters(
			'wp_listings_extended_property_details',
			array(
				'col1' => array(
					__( 'Property Type:', 'wp-listings-pro' ) => '_listing_proptype',
					__( 'Condo:', 'wp-listings-pro' )     => '_listing_condo',
					__( 'Financial:', 'wp-listings-pro' ) => '_listing_financial',
					__( 'Condition:', 'wp-listings-pro' ) => '_listing_condition',
					__( 'Construction:', 'wp-listings-pro' ) => '_listing_construction',
					__( 'Exterior:', 'wp-listings-pro' )  => '_listing_exterior',
					__( 'Fencing:', 'wp-listings-pro' )   => '_listing_fencing',
					__( 'Interior:', 'wp-listings-pro' )  => '_listing_interior',
					__( 'Flooring:', 'wp-listings-pro' )  => '_listing_flooring',
					__( 'Heat/Cool:', 'wp-listings-pro' ) => '_listing_heatcool',
				),
				'col2' => array(
					__( 'Lot size:', 'wp-listings-pro' )   => '_listing_lotsize',
					__( 'Location:', 'wp-listings-pro' )   => '_listing_location',
					__( 'Scenery:', 'wp-listings-pro' )    => '_listing_scenery',
					__( 'Community:', 'wp-listings-pro' )  => '_listing_community',
					__( 'Recreation:', 'wp-listings-pro' ) => '_listing_recreation',
					__( 'General:', 'wp-listings-pro' )    => '_listing_general',
					__( 'Inclusions:', 'wp-listings-pro' ) => '_listing_inclusions',
					__( 'Parking:', 'wp-listings-pro' )    => '_listing_parking',
					__( 'Rooms:', 'wp-listings-pro' )      => '_listing_rooms',
					__( 'Laundry:', 'wp-listings-pro' )    => '_listing_laundry',
					__( 'Utilities:', 'wp-listings-pro' )  => '_listing_utilities',
					__( 'Virtual Tour Link:', 'wp_listings' ) => '_listing_virtualtour',
				),
			)
		);

		add_action( 'init', array( $this, 'create_post_type' ) );

		add_filter( 'manage_edit-listing_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );

		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ), 5 );
		add_action( 'save_post', array( $this, 'metabox_save' ), 1, 2 );

		add_action( 'save_post', array( $this, 'save_post' ), 1, 3 );

		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		add_action( 'admin_init', array( &$this, 'add_options' ) );
		add_action( 'admin_menu', array( &$this, 'settings_init' ), 15 );

		add_action( 'save_post', 'WPLPROMetaBoxListing_Images::save', 20, 2 );
		add_action( 'save_post', 'WPLPROMetaBoxListing_Docs::save', 20, 2 );
	}

	/**
	 * Registers the option to load the stylesheet
	 */
	function register_settings() {
		register_setting( 'wp_listings_options', 'wplpro_plugin_settings', 'wplpro_set_sort' );
	}

	/**
	 * Sets default slug and default post number in options
	 */
	function add_options() {

		$new_options = array(
			'wplpro_archive_posts_num' => 9,
			'wplpro_listings_slug'     => 'listings',
			'wplpro_archive_agent_num' => 9,
			'wplpro_employee_slug'     => 'employees',
		);

		if ( empty( $this->options['wplpro_listings_slug'] ) && empty( $this->options['wplpro_archive_posts_num'] ) ) {
			add_option( 'wplpro_plugin_settings', $new_options );
		}

		if ( empty( $this->options['wplpro_employee_slug'] ) && empty( $this->options['wplpro_archive_agent_num'] ) ) {
			add_option( 'wplpro_plugin_settings', $new_options );
		}
	}

	/**
	 * Adds settings page and IDX Import page to admin menu
	 */
	function settings_init() {
		add_submenu_page( 'options-general.php', __( 'WPL PRO', 'wp-listings-pro' ), __( 'WPL PRO', 'wp-listings-pro' ), 'manage_options', $this->settings_page, array( &$this, 'settings_page' ) );
	}

	/**
	 * Creates display of settings page along with form fields
	 */
	function settings_page() {
		wplpro_admin_scripts_styles();
		include dirname( __FILE__ ) . '/views/wp-listings-settings.php';
	}

	/**
	 * Creates our "Listing" post type.
	 */
	function create_post_type() {

		$args = apply_filters(
			'wp_listings_post_type_args',
			array(
				'labels'                => array(
					'name'                  => __( 'Listings', 'wp-listings-pro' ),
					'singular_name'         => __( 'Listing', 'wp-listings-pro' ),
					'add_new'               => __( 'Add New', 'wp-listings-pro' ),
					'add_new_item'          => __( 'Add New Listing', 'wp-listings-pro' ),
					'edit'                  => __( 'Edit', 'wp-listings-pro' ),
					'edit_item'             => __( 'Edit Listing', 'wp-listings-pro' ),
					'new_item'              => __( 'New Listing', 'wp-listings-pro' ),
					'view'                  => __( 'View Listing', 'wp-listings-pro' ),
					'view_item'             => __( 'View Listing', 'wp-listings-pro' ),
					'search_items'          => __( 'Search Listings', 'wp-listings-pro' ),
					'not_found'             => __( 'No listings found', 'wp-listings-pro' ),
					'not_found_in_trash'    => __( 'No listings found in Trash', 'wp-listings-pro' ),
					'filter_items_list'     => __( 'Filter Listings', 'wp-listings-pro' ),
					'items_list_navigation' => __( 'Listings navigation', 'wp-listings-pro' ),
					'items_list'            => __( 'Listings list', 'wp-listings-pro' ),
				),
				'public'                => true,
				'query_var'             => true,
				'show_in_rest'          => true,
				'rest_base'             => 'listing',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-admin-home',
				'has_archive'           => true,
				'supports'              => array( 'title', 'editor', 'author', 'comments', 'excerpt', 'thumbnail', 'revisions', 'equity-layouts', 'equity-cpt-archives-settings', 'genesis-seo', 'genesis-layouts', 'genesis-simple-sidebars', 'genesis-cpt-archives-settings', 'publicize', 'wpcom-markdown' ),
				// 'rewrite'     => array( 'slug' => $this->options['wplpro_listings_slug'], 'feeds' => true, 'with_front' => false ),
			)
		);

		register_post_type( 'listing', $args );

	}
	/**
	 * Register Meta Boxes
	 *
	 * @return void
	 */
	function register_meta_boxes() {
		add_meta_box( 'listing_sync_metabox', __( 'Sync Settings', 'wp-listings-pro' ), array( &$this, 'listing_sync_metabox' ), 'listing', 'side', 'high' );
		add_meta_box( 'listing_details_metabox', __( 'Property Details', 'wp-listings-pro' ), array( &$this, 'listing_details_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_features_metabox', __( 'Additional Details', 'wp-listings-pro' ), array( &$this, 'listing_features_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box(
			'listing_location_metabox',
			__( 'Map and Location', 'wp-listings-pro' ),
			array( $this, 'listing_location_metabox' ),
			'listing',
			'advanced',
			'core'
		);
		add_meta_box( 'listing_pricing_metabox', __( 'Pricing', 'wp-listings-pro' ), array( &$this, 'listing_price_metabox' ), 'listing', 'advanced', 'default' );
		// add_meta_box( 'listing_map_metabox', __( 'Location', 'wp-listings-pro' ), array( &$this, 'listing_map_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_contact_metabox', __( 'Lead Tools', 'wp-listings-pro' ), array( &$this, 'listing_contact_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_assignment_metabox', __( 'Agent Assignments', 'wp-listings-pro' ), array( &$this, 'listing_assignments_metabox' ), 'listing', 'normal', 'high' );

		add_meta_box( 'wplpro-listing-images', __( 'Photo Gallery', 'wp-listings-pro' ), 'WPLPROMetaBoxListing_Images::output', 'listing', 'normal', 'high' );
		add_meta_box( 'wplpro-listing-docs', __( 'Documents', 'wp-listings-pro' ), 'WPLPROMetaBoxListing_Docs::output', 'listing', 'normal', 'high' );

	}

	/**
	 * Metabox for listing sync settings
	 *
	 * @access public
	 * @return void
	 */
	function listing_sync_metabox() {
		include dirname( __FILE__ ) . '/views/listing-sync-metabox.php';
	}

	/**
	 * Metabox for listing details
	 *
	 * @access public
	 * @return void
	 */
	function listing_details_metabox() {
		include dirname( __FILE__ ) . '/views/listing-details-metabox.php';
	}

	/**
	 * Metabox for listing features
	 */
	function listing_features_metabox() {
		include dirname( __FILE__ ) . '/views/listing-features-metabox.php';
	}

	/**
	 * Metabox for location fields
	 *
	 * @return void
	 */
	function listing_location_metabox() {
		include dirname( __FILE__ ) . '/views/listing-location-metabox.php';
	}

	/**
	 * Metabox for pricing settings
	 *
	 * @return void
	 */
	function listing_price_metabox() {
		include dirname( __FILE__ ) . '/views/listing-price-metabox.php';
	}

	/**
	 * Metabox for map options
	 */
	function listing_map_metabox() {
		include dirname( __FILE__ ) . '/views/listing-map-metabox.php';
	}

	/**
	 * Metabox for lead/contact forms
	 */
	function listing_contact_metabox() {
		include dirname( __FILE__ ) . '/views/listing-contact-metabox.php';
	}

	/**
	 * Metabox for agents being assigned to listing
	 */
	function listing_assignments_metabox() {
		include dirname( __FILE__ ) . '/views/listing-assignments-metabox.php';
	}

	/**
	 * [metabox_save description]
	 *
	 * @param  int     $post_id    ID of the post.
	 * @param  WP_POST $post       Object containing the post itself.
	 * @return int                      ID of the post if nonce fails.
	 */
	function metabox_save( $post_id, $post ) {
		/** Run only on listings post type save */
		if ( 'listing' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['wp_listings_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['wp_listings_metabox_nonce'], 'wp_listings_metabox_save' ) ) {
			return $post_id;
		}

		/** Don't try to save the data under autosave, ajax, or future post */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
			return;
		}

		/** Check permissions. */
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			  return;
		}

		$dets = $_POST['wp_listings']; // Grab informmation object from post, and validate before entering it.
									   // dets => Details
									   // Like ya know. Gimme the dets.
									   // (Sometimes spelled as deets).
									   // Shortened so that data validation is easier to read.
		// Sync settings.
		update_post_meta( $post->ID, '_listing_sync_update', ( isset( $dets['_listing_sync_update'] ) ? $dets['_listing_sync_update'] : '' ) );
		update_post_meta( $post->ID, '_listing_custom_sync_featured', ( isset( $dets['_listing_custom_sync_featured'] ) ? 1 : 0 ) );
		update_post_meta( $post->ID, '_listing_custom_sync_gallery', ( isset( $dets['_listing_custom_sync_gallery'] ) ? 1 : 0 ) );
		update_post_meta( $post->ID, '_listing_custom_sync_details', ( isset( $dets['_listing_custom_sync_details'] ) ? 1 : 0 ) );

		// Saving Agent Assignments.
		$agents = get_posts(
			array(
				'post_type'      => 'employee',
				'posts_per_page' => -1,
			)
		);
		$ids    = array();
		foreach ( $agents as $agent ) {
			if ( isset( $dets[ '_employee_responsibility_' . $agent->ID ] ) ) {
				$ids[ count( $ids ) ] = $agent->ID;
			}
		}
		update_post_meta( $post->ID, '_employee_responsibility', implode( ',', $ids ) );

		// Map and Location
		update_post_meta( $post->ID, '_listing_carrier_route', ( isset( $dets['_listing_carrier_route'] ) ? $dets['_listing_carrier_route'] : '' ) ); // Hm, need a regex for this... maybe something like, preg_match( '/\d{5}(-|)[a-zA-Z]\d{3}/', $string )?
		update_post_meta( $post->ID, '_listing_city', ( isset( $dets['_listing_city'] ) ? sanitize_text_field( $dets['_listing_city'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_country', ( isset( $dets['_listing_country'] ) ? sanitize_text_field( $dets['_listing_country'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_county', ( isset( $dets['_listing_county'] ) ? sanitize_text_field( $dets['_listing_county'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_postal_city', ( isset( $dets['_listing_postal_city'] ) ? sanitize_text_field( $dets['_listing_postal_city'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_zip', ( isset( $dets['_listing_zip'] ) ? $dets['_listing_zip'] : '' ) ); // && preg_match( '/(^\d{5}$)/', $dets['_listing_zip_plus_4'] ) validates 5 digits.
		update_post_meta( $post->ID, '_listing_zip_plus_4', ( isset( $dets['_listing_zip_plus_4'] ) ? $dets['_listing_zip_plus_4'] : '' ) ); // && preg_match( '/(^\d{5}-\d4}$)/', $dets['_listing_zip_plus_4'] ) validates 5 digits, a tack, then 4 digits.
		update_post_meta( $post->ID, '_listing_state', ( isset( $dets['_listing_state'] ) ? $dets['_listing_state'] : '' ) );
		update_post_meta( $post->ID, '_listing_street_additional_info', ( isset( $dets['_listing_street_additional_info'] ) ? $dets['_listing_street_additional_info'] : '' ) );
		update_post_meta( $post->ID, '_listing_automap', ( isset( $dets['_listing_automap'] ) ? $dets['_listing_automap'] : '' ) );
		update_post_meta( $post->ID, '_listing_latitude', ( isset( $dets['_listing_latitude'] ) ? $dets['_listing_latitude'] : '' ) ); // && preg_match( '/(^\d+$)|(^\d+.\d+$)/', $dets['_listing_latitude'] ) Makes sure is only digits (integer, or float).
		update_post_meta( $post->ID, '_listing_longitude', ( isset( $dets['_listing_longitude'] ) ? $dets['_listing_longitude'] : '' ) ); // && preg_match( '/(^\d+$)|(^\d+.\d+$)/', $dets['_listing_longitude'] ) ^^
		update_post_meta( $post->ID, '_listing_map', ( isset( $dets['_listing_map'] ) ? sanitize_text_field( $dets['_listing_map'] ) : '' ) );

		// Price - sanitized
		update_post_meta( $post->ID, '_listing_price', ( isset( $dets['_listing_price'] ) ? floatval( $dets['_listing_price'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_list_price_low', ( isset( $dets['_listing_list_price_low'] ) ? floatval( $dets['_listing_list_price_low'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_original_list_price', ( isset( $dets['_listing_original_list_price'] ) ? floatval( $dets['_listing_original_list_price'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_previous_list_price', ( isset( $dets['_listing_previous_list_price'] ) ? floatval( $dets['_listing_previous_list_price'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_sold_price', ( isset( $dets['_listing_sold_price'] ) ? floatval( $dets['_listing_sold_price'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_rent_price', ( isset( $dets['_listing_rent_price'] ) ? floatval( $dets['_listing_rent_price'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_hide_price', ( isset( $dets['_listing_hide_price'] ) ? 1 : 0 ) );

		update_post_meta( $post->ID, '_listing_price_alt', ( isset( $dets['_listing_price_alt'] ) ? sanitize_text_field( $dets['_listing_price_alt'] ) : '' ) );

		// Details
		update_post_meta( $post->ID, '_listing_sold_date', ( isset( $dets['_listing_sold_date'] ) ? sanitize_text_field( $dets['_listing_sold_date'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_mls', ( isset( $dets['_listing_mls'] ) ? $dets['_listing_mls'] : '' ) ); // && preg_match( '/(^\d+$)|(^\d+-\d+$)/', $dets['_listing_mls'] )
		update_post_meta( $post->ID, '_listing_open_house', ( isset( $dets['_listing_open_house'] ) ? $dets['_listing_open_house'] : '' ) );
		update_post_meta( $post->ID, '_listing_year_built', ( isset( $dets['_listing_year_built'] ) ? intval( $dets['_listing_year_built'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_floors', ( isset( $dets['_listing_floors'] ) ? floatval( $dets['_listing_floors'] ) : '' ) ); // You never know when someone might have 2.718 floors.
		update_post_meta( $post->ID, '_listing_sqft', ( isset( $dets['_listing_sqft'] ) ? intval( $dets['_listing_sqft'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_lot_sqft', ( isset( $dets['_listing_lot_sqft'] ) ? $dets['_listing_lot_sqft'] : '' ) );
		update_post_meta( $post->ID, '_listing_bedrooms', ( isset( $dets['_listing_bedrooms'] ) ? intval( $dets['_listing_bedrooms'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_bathrooms', ( isset( $dets['_listing_bathrooms'] ) ? intval( $dets['_listing_bathrooms'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_half_bath', ( isset( $dets['_listing_half_bath'] ) ? intval( $dets['_listing_half_bath'] ) : '' ) );
		update_post_meta( $post->ID, '_listing_garage', ( isset( $dets['_listing_garage'] ) ? $dets['_listing_garage'] : '' ) );
		update_post_meta( $post->ID, '_listing_pool', ( isset( $dets['_listing_pool'] ) ? $dets['_listing_pool'] : '' ) );
		update_post_meta( $post->ID, '_listing_living_space', ( isset( $dets['_listing_living_space'] ) ? $dets['_listing_living_space'] : '' ) );
		update_post_meta( $post->ID, '_listing_land_size', ( isset( $dets['_listing_land_size'] ) ? $dets['_listing_land_size'] : '' ) );
		update_post_meta( $post->ID, '_listing_list_currency', ( isset( $dets['_listing_list_currency'] ) ? $dets['_listing_list_currency'] : '' ) );
		update_post_meta( $post->ID, '_listing_lotsize', ( isset( $dets['_listing_lotsize'] ) ? $dets['_listing_lotsize'] : '' ) );
		update_post_meta( $post->ID, '_listing_scenery', ( isset( $dets['_listing_scenery'] ) ? $dets['_listing_scenery'] : '' ) );
		update_post_meta( $post->ID, '_listing_community', ( isset( $dets['_listing_community'] ) ? $dets['_listing_community'] : '' ) );
		update_post_meta( $post->ID, '_listing_recreation', ( isset( $dets['_listing_recreation'] ) ? $dets['_listing_recreation'] : '' ) );
		update_post_meta( $post->ID, '_listing_general', ( isset( $dets['_listing_general'] ) ? $dets['_listing_general'] : '' ) );
		update_post_meta( $post->ID, '_listing_inclusions', ( isset( $dets['_listing_inclusions'] ) ? $dets['_listing_inclusions'] : '' ) );
		update_post_meta( $post->ID, '_listing_parking', ( isset( $dets['_listing_parking'] ) ? $dets['_listing_parking'] : '' ) );
		update_post_meta( $post->ID, '_listing_rooms', ( isset( $dets['_listing_rooms'] ) ? $dets['_listing_rooms'] : '' ) );
		update_post_meta( $post->ID, '_listing_laundry', ( isset( $dets['_listing_laundry'] ) ? $dets['_listing_laundry'] : '' ) );
		update_post_meta( $post->ID, '_listing_utilities', ( isset( $dets['_listing_utilities'] ) ? $dets['_listing_utilities'] : '' ) );
		update_post_meta( $post->ID, '_listing_virtualtour', ( isset( $dets['_listing_virtualtour'] ) ? $dets['_listing_virtualtour'] : '' ) );
		update_post_meta( $post->ID, '_listing_text', ( isset( $dets['_listing_text'] ) ? $dets['_listing_text'] : '' ) );
		update_post_meta( $post->ID, '_listing_video', ( isset( $dets['_listing_video'] ) ? $dets['_listing_video'] : '' ) );

		// Features
		update_post_meta( $post->ID, '_listing_featured_on', ( isset( $dets['_listing_featured_on'] ) ? $dets['_listing_featured_on'] : '' ) );
		update_post_meta( $post->ID, '_listing_home_sum', ( isset( $dets['_listing_home_sum'] ) ? $dets['_listing_home_sum'] : '' ) );
		update_post_meta( $post->ID, '_listing_kitchen_sum', ( isset( $dets['_listing_kitchen_sum'] ) ? $dets['_listing_kitchen_sum'] : '' ) );
		update_post_meta( $post->ID, '_listing_living_room', ( isset( $dets['_listing_living_room'] ) ? $dets['_listing_living_room'] : '' ) );
		update_post_meta( $post->ID, '_listing_master_suite', ( isset( $dets['_listing_master_suite'] ) ? $dets['_listing_master_suite'] : '' ) );
		update_post_meta( $post->ID, '_listing_school_neighborhood', ( isset( $dets['_listing_school_neighborhood'] ) ? $dets['_listing_school_neighborhood'] : '' ) );
		update_post_meta( $post->ID, '_listing_disclaimer', ( isset( $dets['_listing_disclaimer'] ) ? $dets['_listing_disclaimer'] : '' ) );

		// Contact
		update_post_meta( $post->ID, '_listing_contact_form', ( isset( $dets['_listing_contact_form'] ) ? sanitize_text_field( $dets['_listing_contact_form'] ) : '' ) );

	}

	/**
	 * Filter the columns in the "Listings" screen, define our own.
	 *
	 * @param object $columns    Array containing listing details.
	 * @return object                   Modified array.
	 */
	function columns_filter( $columns ) {

		$columns = array(
			'cb'                => '<input type="checkbox" />',
			'listing_thumbnail' => __( 'Thumbnail', 'wp-listings-pro' ),
			'title'             => __( 'Listing Title', 'wp-listings-pro' ),
			'listing_details'   => __( 'Details', 'wp-listings-pro' ),
			'listing_tags'      => __( 'Tags', 'wp-listings-pro' ),
		);

		return $columns;

	}

	/**
	 * Filter the data that shows up in the columns in the "Listings" screen, define our own.
	 *
	 * @param string $column Object name to be tested for type and which different data will be returned based on.
	 */
	function columns_data( $column ) {

		global $post, $wp_taxonomies;

		// So because of the way that esc_attr works, quotation marks will break it. OK then.
		$image_size = 'style=min-width:150px;min-height:150px;width:150px;height:150px';

		apply_filters( 'wp_listings_admin_listing_details', $admin_details = $this->property_details['col1'] );

		if ( isset( $_GET['mode'] ) && trim( $_GET['mode'] ) === 'excerpt' ) {
			apply_filters( 'wp_listings_admin_extended_details', $admin_details = $this->property_details['col1'] + $this->property_details['col2'] );
		}

		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );

		// Adds support for nophoto, as defined in the customizer.
		if ( '' === $image || null === $image[0] ) {
			$options = get_option( 'wplpro_plugin_settings' );

			$image_url;

			if ( isset( get_option( 'wplpro_plugin_settings' )['listing_nophoto'] ) ) {

				$image_url = get_option( 'wplpro_plugin_settings' )['listing_nophoto'];
			} else {
				$image_url = plugin_dir_url( __FILE__ ) . '../assets/images/listing-nophoto.jpg';
			}

			$image = array(
				$image_url,
			);
		}

		switch ( $column ) {
			case 'listing_thumbnail':
				echo '<p><img src="' . esc_url( $image[0] ) . '" alt="listing-thumbnail" ' . esc_attr( $image_size ) . '/></p>';
				break;
			case 'listing_details':
				foreach ( (array) $admin_details as $label => $key ) {
					printf( '<b>%s</b> %s<br />', esc_html( $label ), esc_html( get_post_meta( $post->ID, $key, true ) ) );
				}
				break;
			case 'listing_tags':
				echo '<b>Status</b>: ' . get_the_term_list( $post->ID, 'status', '', ', ', '' ) . '<br />';
				echo '<b>Property Type:</b> ' . get_the_term_list( $post->ID, 'property-types', '', ', ', '' ) . '<br />';
				echo '<b>Location:</b> ' . get_the_term_list( $post->ID, 'locations', '', ', ', '' ) . '<br />';
				echo '<b>Features:</b> ' . get_the_term_list( $post->ID, 'features', '', ', ', '' );
				break;
		}

	}

	/**
	 * Adds query var on saving post to show notice
	 *
	 * @param  int     $post_id ID of the post.
	 * @param  WP_POST $post    Object containing post data.
	 * @param  object  $update  New version of the post.
	 */
	function save_post( $post_id, $post, $update ) {
		if ( 'listing' !== $post->post_type ) {
			return;
		}

		add_filter( 'redirect_post_location', array( &$this, 'add_notice_query_var' ), 99 );
	}

	/**
	 * Add notice query var
	 *
	 * @param object $location WP stored format of location.
	 */
	function add_notice_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( &$this, 'add_notice_query_var' ), 99 );
		return add_query_arg( array( 'wp-listings-pro' => 'show-notice' ), $location );
	}
}

<?php
/**
 * Listings Class
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit;
}


if ( ! function_exists( 'WP_listings' ) ) {
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

		$this->property_details = apply_filters( 'wp_listings_property_details', array(
			'col1' => array(
			    __( 'Price:', 'wp-listings-pro' ) 					=> '_listing_price',
			    __( 'Sold Price:', 'wp-listings-pro' ) 				=> '_listing_sold_price',
			    __( 'Sold Date:', 'wp_listings' ) 					=> '_listing_sold_date',
			    __( 'Rent Price:', 'wp-listings-pro' ) 				=> '_listing_rent_price',
			    __( 'Address:', 'wp-listings-pro' )					=> '_listing_address',
			    __( 'City:', 'wp-listings-pro' )					=> '_listing_city',
			    __( 'County:', 'wp-listings-pro' )					=> '_listing_county',
			    __( 'State:', 'wp-listings-pro' )					=> '_listing_state',
			    __( 'Country:', 'wp-listings-pro' )					=> '_listing_country',
			    __( 'ZIP:', 'wp-listings-pro' )						=> '_listing_zip',
			    __( 'MLS #:', 'wp-listings-pro' ) 					=> '_listing_mls',
				__( 'Open House Time & Date:', 'wp-listings-pro' ) 	=> '_listing_open_house',
				__( 'Latitude:', 'wp_listings' )					=> '_listing_latitude',
				__( 'Longitude:', 'wp_listings' )					=> '_listing_longitude',
			),
			'col2' => array(
			    __( 'Year Built:', 'wp-listings-pro' ) 				=> '_listing_year_built',
			    __( 'Floors:', 'wp-listings-pro' ) 					=> '_listing_floors',
			    __( 'Square Feet:', 'wp-listings-pro' )				=> '_listing_sqft',
				__( 'Lot Square Feet:', 'wp-listings-pro' )			=> '_listing_lot_sqft',
			    __( 'Bedrooms:', 'wp-listings-pro' )				=> '_listing_bedrooms',
			    __( 'Bathrooms:', 'wp-listings-pro' )				=> '_listing_bathrooms',
			    __( 'Half Bathrooms:', 'wp-listings-pro' )			=> '_listing_half_bath',
			    __( 'Garage:', 'wp-listings-pro' )					=> '_listing_garage',
			    __( 'Pool:', 'wp-listings-pro' )					=> '_listing_pool',
			    __( 'Constructed Area:', 'wp_listings' ) 			=> '_listing_living_space',
			    __( 'Land Size:', 'wp_listings' ) 					=> '_listing_land_size',
			    __( 'Currency:', 'wp_listings' ) 					=> '_listing_list_currency',
			),
		) );

		$this->extended_property_details = apply_filters( 'wp_listings_extended_property_details', array(
			'col1' => array(
			    __( 'Property Type:', 'wp-listings-pro' ) 			=> '_listing_proptype',
			    __( 'Condo:', 'wp-listings-pro' )					=> '_listing_condo',
			    __( 'Financial:', 'wp-listings-pro' )				=> '_listing_financial',
			    __( 'Condition:', 'wp-listings-pro' )				=> '_listing_condition',
			    __( 'Construction:', 'wp-listings-pro' )			=> '_listing_construction',
			    __( 'Exterior:', 'wp-listings-pro' )				=> '_listing_exterior',
			    __( 'Fencing:', 'wp-listings-pro' ) 				=> '_listing_fencing',
				__( 'Interior:', 'wp-listings-pro' ) 				=> '_listing_interior',
				__( 'Flooring:', 'wp-listings-pro' ) 				=> '_listing_flooring',
				__( 'Heat/Cool:', 'wp-listings-pro' ) 				=> '_listing_heatcool',
			),
			'col2' => array(
				__( 'Lot size:', 'wp-listings-pro' ) 				=> '_listing_lotsize',
				__( 'Location:', 'wp-listings-pro' ) 				=> '_listing_location',
				__( 'Scenery:', 'wp-listings-pro' )					=> '_listing_scenery',
				__( 'Community:', 'wp-listings-pro' )				=> '_listing_community',
				__( 'Recreation:', 'wp-listings-pro' )				=> '_listing_recreation',
				__( 'General:', 'wp-listings-pro' )					=> '_listing_general',
				__( 'Inclusions:', 'wp-listings-pro' )				=> '_listing_inclusions',
				__( 'Parking:', 'wp-listings-pro' )					=> '_listing_parking',
				__( 'Rooms:', 'wp-listings-pro' )					=> '_listing_rooms',
				__( 'Laundry:', 'wp-listings-pro' )					=> '_listing_laundry',
				__( 'Utilities:', 'wp-listings-pro' )				=> '_listing_utilities',
				__( 'Virtual Tour Link:', 'wp_listings' )			=> '_listing_virtualtour',
			),
		) );

		add_action( 'init', array( $this, 'create_post_type' ) );

		add_filter( 'manage_edit-listing_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );

		add_action( 'admin_menu', array( $this, 'register_meta_boxes' ), 5 );
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
			'wplpro_listings_slug' => 'listings',
			'wplpro_archive_agent_num' => 9,
			'wplpro_employee_slug' => 'employees',
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
		include( dirname( __FILE__ ) . '/views/wp-listings-settings.php' );
	}

	/**
	 * Creates our "Listing" post type.
	 */
	function create_post_type() {

		$args = apply_filters( 'wp_listings_post_type_args',
			array(
				'labels' => array(
					'name'					=> __( 'Listings', 'wp-listings-pro' ),
					'singular_name'			=> __( 'Listing', 'wp-listings-pro' ),
					'add_new'				=> __( 'Add New', 'wp-listings-pro' ),
					'add_new_item'			=> __( 'Add New Listing', 'wp-listings-pro' ),
					'edit'					=> __( 'Edit', 'wp-listings-pro' ),
					'edit_item'				=> __( 'Edit Listing', 'wp-listings-pro' ),
					'new_item'				=> __( 'New Listing', 'wp-listings-pro' ),
					'view'					=> __( 'View Listing', 'wp-listings-pro' ),
					'view_item'				=> __( 'View Listing', 'wp-listings-pro' ),
					'search_items'			=> __( 'Search Listings', 'wp-listings-pro' ),
					'not_found'				=> __( 'No listings found', 'wp-listings-pro' ),
					'not_found_in_trash'	=> __( 'No listings found in Trash', 'wp-listings-pro' ),
					'filter_items_list'     => __( 'Filter Listings', 'wp-listings-pro' ),
					'items_list_navigation' => __( 'Listings navigation', 'wp-listings-pro' ),
					'items_list'            => __( 'Listings list', 'wp-listings-pro' ),
				),
				'public'		=> true,
				'query_var'		=> true,
				'show_in_rest'  => true,
				'rest_base'     => 'listing',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'menu_position'	=> 5,
				'menu_icon'		=> 'dashicons-admin-home',
				'has_archive'	=> true,
				'supports'		=> array( 'title', 'editor', 'author', 'comments', 'excerpt', 'thumbnail', 'revisions', 'equity-layouts', 'equity-cpt-archives-settings', 'genesis-seo', 'genesis-layouts', 'genesis-simple-sidebars', 'genesis-cpt-archives-settings', 'publicize', 'wpcom-markdown' ),
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
		add_meta_box( 'listing_sync_metabox' , __( 'Sync Settings', 'wp-listings-pro' ), array( &$this, 'listing_sync_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_details_metabox', __( 'Property Details', 'wp-listings-pro' ), array( &$this, 'listing_details_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_features_metabox', __( 'Additional Details', 'wp-listings-pro' ), array( &$this, 'listing_features_metabox' ), 'listing', 'normal', 'high' );
		add_meta_box( 'listing_map_metabox', __( 'Map Options', 'wp-listings-pro' ), array( &$this, 'listing_features_metabox' ), 'listing', 'normal', 'high' );
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
		include( dirname( __FILE__ ) . '/views/listing-sync-metabox.php' );
	}

	/**
	 * Metabox for listing details
	 *
	 * @access public
	 * @return void
	 */
	function listing_details_metabox() {
		include( dirname( __FILE__ ) . '/views/listing-details-metabox.php' );
	}

	/**
	 * Metabox for listing features
	 */
	function listing_features_metabox() {
		include( dirname( __FILE__ ) . '/views/listing-features-metabox.php' );
	}

	/**
	 * Metabox for map options
	 */
	function listing_map_metabox() {
		include( dirname( __FILE__ ) . '/views/listing-map-metabox.php' );
	}

	/**
	 * Metabox for lead/contact forms
	 */
	function listing_contact_metabox() {
		include( dirname( __FILE__ ) . '/views/listing-contact-metabox.php' );
	}

	/**
	 * Metabox for agents being assigned to listing
	 */
	function listing_assignments_metabox() {
		include( dirname( __FILE__ ) . '/views/listing-assignments-metabox.php' );
	}

	/**
	 * [metabox_save description]
	 *
	 * @param  int     $post_id    ID of the post.
	 * @param  WP_POST $post       Object containing the post itself.
	 * @return int         				ID of the post if nonce fails.
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

		$property_details = $_POST['wp_listings']; // Grab informmation object from post, and validate before entering it.

		if ( ! isset( $property_details['_listing_hide_price'] ) ) {
			$property_details['_listing_hide_price'] = 0;
		}

		if ( ! isset( $property_details['_listing_custom_sync_featured'] ) ) {
			$property_details['_listing_custom_sync_featured'] = 0;
		}
		if ( ! isset( $property_details['_listing_custom_sync_gallery'] ) ) {
			$property_details['_listing_custom_sync_gallery'] = 0;
		}
		if ( ! isset( $property_details['_listing_custom_sync_details'] ) ) {
			$property_details['_listing_custom_sync_details'] = 0;
		}

		// Saving Agent Assignments.
		$stuff = get_posts(array(
			'post_type'       => 'employee',
			'posts_per_page'  => -1,
		));
		$ids = array();
		foreach ( $stuff as $agent ) {
			if ( isset( $property_details[ '_employee_responsibility_' . $agent->ID ] ) ) {
				$ids[ count( $ids ) ] = $agent->ID;
			}
		}
		$property_details['_employee_responsibility'] = implode( ',',$ids );

		/** Validate and store the property details custom fields */
		foreach ( (array) $property_details as $key => $value ) {

			$key = sanitize_key( $key );

			if ( '_employee_email' === $key ) {
				$value = sanitize_email( $value );
			} else {
				$value = sanitize_text_field( $value );
			}

			  /** Save/Update/Delete */
			if ( $value ) {
				update_post_meta( $post->ID,  $key, $value );
			} else {
				  delete_post_meta( $post->ID, $key );
			}
		}

	}

	/**
	 * Filter the columns in the "Listings" screen, define our own.
	 *
	 * @param object $columns    Array containing listing details.
	 * @return object 					Modified array.
	 */
	function columns_filter( $columns ) {

		$columns = array(
			'cb'					=> '<input type="checkbox" />',
			'listing_thumbnail'		=> __( 'Thumbnail', 'wp-listings-pro' ),
			'title'					=> __( 'Listing Title', 'wp-listings-pro' ),
			'listing_details'		=> __( 'Details', 'wp-listings-pro' ),
			'listing_tags'			=> __( 'Tags', 'wp-listings-pro' ),
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
}

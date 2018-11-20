<?php
/**
 * This file contains the WPLPRO_Taxonomies class.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class handles all the aspects of displaying, creating, and editing the
 * user-created taxonomies for the "Listings" post-type.
 */
class WPLPRO_Taxonomies {

	/**
	 * Settings_field
	 *
	 * (default value: 'WPLPRO_Taxonomies')
	 *
	 * @var string
	 * @access public
	 */
	var $settings_field = 'WPLPRO_Taxonomies';

	/**
	 * Menu_page
	 *
	 * (default value: 'register-taxonomies')
	 *
	 * @var string
	 * @access public
	 */
	var $menu_page = 'register-taxonomies';

	/**
	 * Construct Method.
	 */
	function __construct() {

		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		add_action( 'admin_menu', array( &$this, 'settings_init' ), 15 );
		add_action( 'admin_init', array( &$this, 'actions' ) );
		add_action( 'admin_notices', array( &$this, 'notices' ) );
		// * add_action( 'admin_enqueue_scripts', array( &$this, 'tax_reorder_enqueue' ) );
		add_action( 'init', array( &$this, 'register_taxonomies' ), 15 );
		add_action( 'init', array( $this, 'create_terms' ), 16 );
		add_action( 'init', array( $this, 'register_term_meta' ), 17 );

		if ( function_exists( 'get_term_meta' ) ) {
			add_action( 'init', array( $this, 'register_term_meta' ), 17 );

			foreach ( (array) $this->get_taxonomies() as $slug => $data ) {
				add_action( "{$slug}_add_form_fields", array( $this, 'wp_listings_new_term_image_field' ) );
				add_action( "{$slug}_edit_form_fields", array( $this, 'wp_listings_edit_term_image_field' ) );
				add_action( "create_{$slug}", array( $this, 'wp_listings_save_term_image' ) );
				add_action( "edit_{$slug}", array( $this, 'wp_listings_save_term_image' ) );
				add_filter( "manage_edit-{$slug}_columns", array( $this, 'wp_listings_edit_term_columns' ) );
				add_action( "manage_{$slug}_custom_column", array( $this, 'wp_listings_manage_term_custom_column' ), 10, 3 );
			}
		}

		add_action( 'restrict_manage_posts', array( $this, 'wp_listings_filter_post_type_by_taxonomy' ) );
		add_filter( 'parse_query', array( $this, 'wp_listings_convert_id_to_term_in_query' ) );

	}

	/**
	 * Register_settings function.
	 *
	 * @access public
	 * @return void
	 */
	function register_settings() {
		register_setting( $this->settings_field, $this->settings_field );
		add_option( $this->settings_field, __return_empty_array(), '', 'yes' );
	}

	/**
	 * Settings_init function.
	 *
	 * @access public
	 * @return void
	 */
	function settings_init() {
		  add_submenu_page( 'edit.php?post_type=listing', __( 'Register Taxonomies', 'wp-listings-pro' ), __( 'Register Taxonomies', 'wp-listings-pro' ), 'manage_options', $this->menu_page, array( &$this, 'admin' ) );
	}

	/**
	 * Actions function.
	 *
	 * @access public
	 * @return void
	 */
	function actions() {
		if ( ! isset( $_REQUEST['page'] ) || sanitize_text_field( $_REQUEST['page'] ) !== $this->menu_page ) {
			return;
		}

		/** This section handles the data if a new taxonomy is created */

		if ( isset( $_REQUEST['action'] ) && 'create' === sanitize_text_field( $_REQUEST['action'] ) && isset( $_POST['wp_listings_taxonomy']['id'] ) && isset( $_POST['wp_listings-action_create-taxonomy'] ) && wp_verify_nonce( $_POST['wp_listings-action_create-taxonomy'], 'wp_listings-action_create-taxonomy' ) ) { // && isset( $_POST['wp_listings_taxonomy_nonce_name'] ) ) {

			$obj = array(
				'id'            => sanitize_key( $_POST['wp_listings_taxonomy']['id'] ),
				'name'          => sanitize_text_field( $_POST['wp_listings_taxonomy']['name'] ),
				'singular_name' => sanitize_text_field( $_POST['wp_listings_taxonomy']['singular_name'] ),
			);
			$this->create_taxonomy( $obj );
		}

		/** This section handles the data if a taxonomy is deleted */
		if ( isset( $_REQUEST['action'] ) && 'delete' === sanitize_text_field( $_REQUEST['action'] ) ) {
			$this->delete_taxonomy( sanitize_key( $_REQUEST['id'] ) );
		}

		/** This section handles the data if a taxonomy is being edited */
		if ( isset( $_REQUEST['action'] ) && 'edit' === sanitize_text_field( $_REQUEST['action'] ) && isset( $_POST['wp_listings_taxonomy'] ) && isset( $_POST['wp_listings-action_edit-taxonomy'] ) && wp_verify_nonce( $_POST['wp_listings-action_edit-taxonomy'], 'wp_listings-action_edit-taxonomy' ) ) {
			$obj = array(
				'id'            => sanitize_key( $_POST['wp_listings_taxonomy']['id'] ),
				'name'          => sanitize_text_field( $_POST['wp_listings_taxonomy']['name'] ),
				'singular_name' => sanitize_text_field( $_POST['wp_listings_taxonomy']['singular_name'] ),
			);
			$this->edit_taxonomy( $obj );
		}
	}


	/**
	 * Admin function.
	 *
	 * @access public
	 * @return void
	 */
	function admin() {

		echo '<div class="wrap">';
		if ( isset( $_REQUEST['view'] ) && 'edit' === $_REQUEST['view'] ) {
			require dirname( __FILE__ ) . '/views/edit-tax.php';
		} else {
			 require dirname( __FILE__ ) . '/views/create-tax.php';
		}

		echo '</div>';
	}

	/**
	 * Create_taxonomy function.
	 *
	 * @access public
	 * @param array $args (default: array()).
	 * @return void
	 */
	function create_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE. */

		/** No empty fields. */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}

		$labels = array(
			'name'                  => wp_strip_all_tags( $args['name'] ),
			'singular_name'         => wp_strip_all_tags( $args['singular_name'] ),
			'menu_name'             => wp_strip_all_tags( $args['name'] ),

			'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['name'] ) ),
			'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['name'] ) ),
			'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['name'] ) ),
			'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['singular_name'] ) ),
			'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['singular_name'] ) ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['singular_name'] ) ),
			'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $args['singular_name'] ) ),
			'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['name'] ) ),
			'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $args['name'] ) ),
		);

		$identifier = $args['id'];

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => $args['id'],
				'with_front' => false,
			),
			'editable'     => 1,
		);

		$tax = array( $identifier => $args );

		$options = get_option( $this->settings_field );

		/** Update the options. */
		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

		/** Flush rewrite rules. */
		$this->register_taxonomies();
		flush_rewrite_rules();

	}

	/**
	 * Delete_taxonomy function.
	 *
	 * @access public
	 * @param string $id (default: '').
	 * @return void
	 */
	function delete_taxonomy( $identifier = '' ) {

		/**** VERIFY THE NONCE */

		/** No empty ID */
		if ( ! isset( $identifier ) || empty( $identifier ) ) {
			wp_die( esc_html__( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );
		}

		$options = get_option( $this->settings_field );

		/** Look for the ID, delete if it exists */
		if ( array_key_exists( $identifier, (array) $options ) ) {
			unset( $options[ $identifier ] );
		} else {
			wp_die( esc_html__( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );
		}

		/** Update the DB */
		update_option( $this->settings_field, $options );

	}

	/**
	 * Edit_taxonomy function.
	 *
	 * @access public
	 * @param array $args Argument list (default: array()).
	 * @return void
	 */
	function edit_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE */

		/** No empty fields */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}

		$name          = $args['name'];
		$singular_name = $args['singular_name'];
		$identifier    = $args['id'];

		$labels = array(
			'name'                  => wp_strip_all_tags( $name ),
			'singular_name'         => wp_strip_all_tags( $singular_name ),
			'menu_name'             => wp_strip_all_tags( $name ),

			'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => $identifier,
				'with_front' => false,
			),
			'editable'     => 1,
		);

		$tax = array( $identifier => $args );

		$options = get_option( $this->settings_field );

		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

	}

	/**
	 * Notices function.
	 *
	 * @access public
	 * @return void
	 */
	function notices() {

		if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] !== $this->menu_page ) {
			return;
		}

		$format = '<div id="message" class="updated"><p><strong>%s</strong></p></div>';

		if ( isset( $_REQUEST['created'] ) && 'true' === $_REQUEST['created'] ) {
			printf( $format, esc_html__( 'New taxonomy successfully created!', 'wp-listings-pro' ) );
			return;
		}

		if ( isset( $_REQUEST['edited'] ) && 'true' === $_REQUEST['edited'] ) {
			printf( $format, esc_html__( 'Taxonomy successfully edited!', 'wp-listings-pro' ) );
			return;
		}

		if ( isset( $_REQUEST['deleted'] ) && 'true' === $_REQUEST['deleted'] ) {
			printf( $format, esc_html__( 'Taxonomy successfully deleted.', 'wp-listings-pro' ) );
			return;
		}
	}

	/**
	 * Register the status taxonomy, manually.
	 */
	function listing_status_taxonomy() {

		$name          = __( 'Status', 'wp-listings-pro' );
		$singular_name = __( 'Status', 'wp-listings-pro' );

		return array(
			'status' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => true,
				'rewrite'               => array(
					__( 'status', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'status',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);
	}

	/**
	 * Register the property-types taxonomy, manually.
	 */
	function property_type_taxonomy() {

		$name          = __( 'Property Types', 'wp-listings-pro' );
		$singular_name = __( 'Property Type', 'wp-listings-pro' );

		return array(
			'property-types' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => true,
				'rewrite'               => array(
					__( 'property-types', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'property-types',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);

	}

	/**
	 * Register the location taxonomy, manually.
	 */
	function listing_location_taxonomy() {

		$name          = __( 'Locations', 'wp-listings-pro' );
		$singular_name = __( 'Location', 'wp-listings-pro' );

		return array(
			'locations' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => true,
				'rewrite'               => array(
					__( 'locations', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'locations',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);

	}

	/**
	 * Register the property features taxonomy, manually.
	 */
	function property_features_taxonomy() {

		$name          = __( 'Features', 'wp-listings-pro' );
		$singular_name = __( 'Feature', 'wp-listings-pro' );

		return array(
			'features' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => 0,
				'rewrite'               => array(
					__( 'features', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'features',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);

	}

	/**
	 * Create the taxonomies.
	 */
	function register_taxonomies() {
		foreach ( (array) $this->get_taxonomies() as $identifier => $data ) {
			register_taxonomy( $identifier, array( 'listing' ), $data );
		}
	}

	  /**
	   * Get the taxonomies.
	   */
	function get_taxonomies() {
		  return array_merge( $this->listing_status_taxonomy(), $this->listing_location_taxonomy(), $this->property_type_taxonomy(), $this->property_features_taxonomy(), (array) get_option( $this->settings_field ) );
	}

	  /**
	   * Create the default terms
	   *
	   * @uses  wp_listings_default_status_terms filter to add or remove default taxonomy terms
	   * @uses  wp_listings_default_property_type_terms filter to add or remove default taxonomy terms
	   */
	function create_terms() {

		/** Default terms for status. */
		$status_terms = apply_filters(
			'wp_listings_default_status_terms',
			array(
				'Active'                => 'active',
				'Pending'               => 'pending',
				'Active Under Contract' => 'active-under-contract',
				'Canceled'              => 'canceled',
				'Closed'                => 'closed',
				'Coming Soon'           => 'coming-soon',
				'Sold'                  => 'sold', // Not RESO Standard.
			// 'Delete'  => 'delete', // RESO Standard.
				'Expired'               => 'expired',
				'Hold'                  => 'hold',
				'Incomplete'            => 'incomplete',
				'Withdrawn'             => 'withdrawn',
			)
		);
		foreach ( $status_terms as $term => $slug ) {
			if ( term_exists( $term, 'status' ) ) {
				continue;
			}
			wp_insert_term( $term, 'status', array( 'slug' => $slug ) );
		}

			/** Default terms for property-type */
		$property_type_terms = apply_filters(
			'wp_listings_default_property_type_terms',
			array(
				'Residential'          => 'resi',
				'Residential Lease'    => 'rlse',
				'Residential Income'   => 'rinc',
				'Mobile Home'          => 'mobi',
				'Land'                 => 'land',
				'Farm Land'            => 'farm',
				'Commercial'           => 'coms',
				'Commerical Lease'     => 'coml',
				'Business Opportunity' => 'buso',
			)
		);
		foreach ( $property_type_terms as $term => $slug ) {
			if ( term_exists( $term, 'property-types' ) ) {
				continue;
			}
			wp_insert_term( $term, 'property-types', array( 'slug' => $slug ) );
		}
	}

	/**
	 * Register term meta for a featured image
	 */
	function register_term_meta() {
		  register_meta( 'term', 'wplpro_term_image', 'wp_listings_sanitize_term_image' );
	}

	/**
	 * Callback to retrieve the term image
	 *
	 * @param WP_Image $wplpro_term_image Term Image.
	 * @return termImage A completely unsanitized copy of whatever you sent it.
	 */
	function wp_listings_sanitize_term_image( $wplpro_term_image ) {
		return $wplpro_term_image;
	}

	/**
	 * Get the term featured image id
	 *
	 * @param int  $term_id ID of the term to check.
	 * @param bool $html Whether to use html wrapper.
	 * @uses  wp_get_attachment_image to return image id wrapped in markup.
	 */
	function wp_listings_get_term_image( $term_id, $html = true ) {
		  $image_id = get_term_meta( $term_id, 'wplpro_term_image', true );
		  return $image_id && $html ? wp_get_attachment_image( $image_id, 'thumbnail' ) : $image_id;
	}

	  /**
	   * Save the image uploaded
	   *
	   * @param  string $term_id term slug.
	   */
	function wp_listings_save_term_image( $term_id ) {

		if ( ! isset( $_POST['wplpro_term_image_nonce'] ) || ! wp_verify_nonce( $_POST['wplpro_term_image_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$old_image = $this->wp_listings_get_term_image( $term_id );
		$new_image = isset( $_POST['wpl-term-image'] ) ? $_POST['wpl-term-image'] : '';

		if ( $old_image && '' === $new_image ) {
			delete_term_meta( $term_id, 'wplpro_term_image' );

		} elseif ( $old_image !== $new_image ) {
			update_term_meta( $term_id, 'wplpro_term_image', $new_image );
		}

		return $term_id;

	}

	/**
	 * Filter the edit term columns
	 *
	 * @param array $columns    Object to have term image subobj added.
	 * @return array $columns Original given array returned with the necessary typing added.
	 */
	function wp_listings_edit_term_columns( $columns ) {

		$columns['wplpro_term_image'] = __( 'Image', 'wp-listings-pro' );

		return $columns;
	}

	/**
	 * Display the new column
	 * These functions really should be combined into each other
	 *
	 * @param image_markup $out        Formatted html image block to be returned.
	 * @param object       $column     Type checking if already in.
	 * @param int          $term_id    Term id for image.
	 *
	 * @return object           $out                Returns original $out object changed if can be.
	 */
	function wp_listings_manage_term_custom_column( $out, $column, $term_id ) {

		if ( 'wplpro_term_image' === $column ) {
			$image_id = $this->wp_listings_get_term_image( $term_id, false );

			if ( ! $image_id ) {
				return $out;
			}
			$image_markup = wp_get_attachment_image( $image_id, 'thumbnail', true, array( 'class' => 'wpl-term-image' ) );
			$out          = $image_markup;
		}

		return $out;
	}

	/**
	 * Display a custom taxonomy dropdown in admin
	 */
	function wp_listings_filter_post_type_by_taxonomy() {
		global $typenow;
		$post_type  = 'listing';
		$taxonomies = array( 'property-types', 'status', 'locations' );
		foreach ( $taxonomies as $taxonomy ) {
			if ( $typenow === $post_type ) {
				$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
				$info_taxonomy = get_taxonomy( $taxonomy );
				wp_dropdown_categories(
					array(
						'show_option_all' => esc_html__( "Show All {$info_taxonomy->label}" ),
						'taxonomy'        => $taxonomy,
						'name'            => $taxonomy,
						'orderby'         => 'name',
						'selected'        => $selected,
						'show_count'      => true,
						'hide_empty'      => true,
					)
				);
			};
		}
	}

	/**
	 * Filter posts by taxonomy in admin
	 *
	 * @param object $query Query request.
	 */
	function wp_listings_convert_id_to_term_in_query( $query ) {
		global $pagenow;
		$post_type  = 'listing';
		$taxonomies = array( 'property-types', 'status', 'locations' );
		$q_vars     = &$query->query_vars;
		foreach ( $taxonomies as $taxonomy ) {
			if ( 'edit.php' === $pagenow && isset( $q_vars['post_type'] ) && $q_vars['post_type'] === $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && 0 !== $q_vars[ $taxonomy ] ) {
				$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
				$q_vars[ $taxonomy ] = $term->slug;
			}
		}
	}

	/**
	 * Field for adding a new image on a term
	 *
	 * @param object $term WP Meta term object.
	 */
	function wp_listings_new_term_image_field( $term ) {

		  $image_id = '';

		  wp_nonce_field( basename( __FILE__ ), 'wplpro_term_image_nonce' );

		?>
			 <div class="form-field wpl-term-image-wrap">
				 <label for="wpl-term-image"><?php esc_html_e( 'Image', 'wp-listings-pro' ); ?></label>
				 <!-- Begin term image -->
				 <p>
					 <input type="hidden" name="wpl-term-image" id="wpl-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
					 <a href="#" class="wpl-add-media wpl-add-media-img"><img class="wpl-term-image-url" src="" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
					 <a href="#" class="wpl-add-media wpl-add-media-text"><?php esc_html_e( 'Set term image', 'wp-listings-pro' ); ?></a>
					 <a href="#" class="wpl-remove-media"><?php esc_html_e( 'Remove term image', 'wp-listings-pro' ); ?></a>
				 </p>
				 <!-- End term image -->
			 </div>
			<?php
	}

	/**
	 * Field for editing an image on a term
	 *
	 * @param object $term WP Meta term object.
	 */
	function wp_listings_edit_term_image_field( $term ) {

		$image_id  = $this->wp_listings_get_term_image( $term->term_id, false );
		$image_url = wp_get_attachment_url( $image_id );

		if ( ! $image_url ) {
			$image_url = '';
		}
		?>

			<tr class="form-field wpl-term-image-wrap">
			<th scope="row"><label for="wpl-term-image"><?php esc_html_e( 'Image', 'wp-listings-pro' ); ?></label></th>
			<td>
				<?php wp_nonce_field( basename( __FILE__ ), 'wplpro_term_image_nonce' ); ?>
				<!-- Begin term image -->
				<p>
					<input type="hidden" name="wpl-term-image" id="wpl-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
					<a href="#" class="wpl-add-media wpl-add-media-img"><img class="wpl-term-image-url" src="<?php echo esc_url( $image_url ); ?>" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
					<a href="#" class="wpl-add-media wpl-add-media-text"><?php esc_html_e( 'Set term image', 'wp-listings-pro' ); ?></a>
					<a href="#" class="wpl-remove-media"><?php esc_html_e( 'Remove term image', 'wp-listings-pro' ); ?></a>
				</p>
				<!-- End term image -->
			</td>
			</tr>
		<?php
	}
}



/**
 * This class handles all the aspects of displaying, creating, and editing the
 * user-created taxonomies for the "Employees" post-type.
 */
class WPLPROAgents_Taxonomies {

	/**
	 * Settings fields
	 *
	 * @var string
	 */
	var $settings_field = 'WPLPROAgents_taxonomies';
	/**
	 * Menu Page
	 *
	 * @var string
	 */
	var $menu_page = 'wplpro-agents-taxonomies';

	/**
	 * Construct Method.
	 */
	function __construct() {

		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		add_action( 'admin_menu', array( &$this, 'settings_init' ), 15 );
		add_action( 'admin_init', array( &$this, 'actions' ) );
		add_action( 'admin_notices', array( &$this, 'notices' ) );

		add_action( 'init', array( &$this, 'register_taxonomies' ), 15 );

		if ( function_exists( 'get_term_meta' ) ) {
			add_action( 'init', array( $this, 'register_term_meta' ), 17 );

			foreach ( (array) $this->get_taxonomies() as $slug => $data ) {
				add_action( "{$slug}_add_form_fields", array( $this, 'WPLPROAgents_new_term_image_field' ) );
				add_action( "{$slug}_edit_form_fields", array( $this, 'WPLPROAgents_edit_term_image_field' ) );
				add_action( "create_{$slug}", array( $this, 'WPLPROAgents_save_term_image' ) );
				add_action( "edit_{$slug}", array( $this, 'WPLPROAgents_save_term_image' ) );
				add_filter( "manage_edit-{$slug}_columns", array( $this, 'WPLPROAgents_edit_term_columns' ) );
				add_action( "manage_{$slug}_custom_column", array( $this, 'WPLPROAgents_manage_term_custom_column' ), 10, 3 );
			}
		}

		add_action( 'restrict_manage_posts', array( $this, 'WPLPROAgents_filter_post_type_by_taxonomy' ) );
		add_filter( 'parse_query', array( $this, 'WPLPROAgents_convert_id_to_term_in_query' ) );

	}

	/**
	 * Register settings field through WordPress
	 *
	 * @return void
	 */
	function register_settings() {
		register_setting( $this->settings_field, $this->settings_field );
		add_option( $this->settings_field, __return_empty_array(), '', 'yes' );
	}

	/**
	 * Initialize settings page through WordPress
	 *
	 * @return void
	 */
	function settings_init() {
		add_submenu_page( 'edit.php?post_type=employee', __( 'Register Taxonomies', 'wp-listings-pro' ), __( 'Register Taxonomies', 'wp-listings-pro' ), 'manage_options', $this->menu_page, array( &$this, 'admin' ) );
	}

	/**
	 * Actions function.
	 *
	 * @access public
	 * @return void
	 */
	function actions() {

		if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] !== $this->menu_page ) {
			return;
		}

		/** This section handles the data if a new taxonomy is created */
		if ( isset( $_REQUEST['action'] ) && 'create' === $_REQUEST['action'] && isset( $_POST['WPLPROAgents_taxonomy']['id'] ) && isset( $_POST['WPLPROAgents-action_create-taxonomy'] ) && wp_verify_nonce( $_POST['WPLPROAgents-action_create-taxonomy'], 'WPLPROAgents-action_create-taxonomy' ) ) {
			$obj = array(
				'id'            => sanitize_key( $_POST['WPLPROAgents_taxonomy']['id'] ),
				'name'          => sanitize_text_field( $_POST['WPLPROAgents_taxonomy']['name'] ),
				'singular_name' => sanitize_text_field( $_POST['WPLPROAgents_taxonomy']['singular_name'] ),
			);
			$this->create_taxonomy( $obj );
		}

		/** This section handles the data if a taxonomy is deleted */
		if ( isset( $_REQUEST['action'] ) && 'delete' === $_REQUEST['action'] ) {
			$this->delete_taxonomy( $_REQUEST['id'] );
		}

		/** This section handles the data if a taxonomy is being edited */
		if ( isset( $_REQUEST['action'] ) && 'edit' === $_REQUEST['action'] && isset( $_POST['WPLPROAgents_taxonomy'] ) && isset( $_POST['WPLPROAgents-action_edit-taxonomy'] ) && wp_verify_nonce( $_POST['WPLPROAgents-action_edit-taxonomy'], 'WPLPROAgents-action_edit-taxonomy' ) ) {
			$obj = array(
				'id'            => sanitize_key( $_POST['WPLPROAgents_taxonomy']['id'] ),
				'name'          => sanitize_text_field( $_POST['WPLPROAgents_taxonomy']['name'] ),
				'singular_name' => sanitize_text_field( $_POST['WPLPROAgents_taxonomy']['singular_name'] ),
			);
			$this->edit_taxonomy( $obj );
		}
	}

	/**
	 * Admin function.
	 *
	 * @access public
	 * @return void
	 */
	function admin() {

		echo '<div class="wrap">';

		if ( isset( $_REQUEST['view'] ) && 'edit' === $_REQUEST['view'] ) {
			require dirname( __FILE__ ) . '/views/agents-edit-tax.php';

		} else {
			require dirname( __FILE__ ) . '/views/agents-create-tax.php';
		}

		echo '</div>';

	}

	/**
	 * Display the new column
	 *
	 * @param image_markup $out            Formatted html image block to be returned.
	 * @param object       $column     Type checking if already in.
	 * @param int          $term_id    Term id for image.
	 */
	function WPLPROAgents_manage_term_custom_column( $out, $column, $term_id ) {

		if ( 'wpmlpro_term_image' === $column ) {
			$image_id = $this->WPLPROAgents_get_term_image( $term_id, false );

			if ( ! $image_id ) {
				return $out;
			}

			$image_markup = wp_get_attachment_image( $image_id, 'thumbnail', true, array( 'class' => 'wplpro-term-image' ) );

			$out = $image_markup;
		}

		return $out;
	}

	/**
	 * Create_taxonomy function.
	 *
	 * @access public
	 * @param array $args (default: array()).
	 * @return void
	 */
	function create_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE */

		/** No empty fields */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}

		$name          = $args['name'];
		$singular_name = $args['singular_name'];
		$identifier    = $args['id'];

		$labels = array(
			'name'                  => wp_strip_all_tags( $name ),
			'singular_name'         => wp_strip_all_tags( $singular_name ),
			'menu_name'             => wp_strip_all_tags( $name ),

			'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => $identifier,
				'with_front' => false,
			),
			'editable'     => 1,
		);

		$tax = array( $identifier => $args );

		$options = get_option( $this->settings_field );

		/** Update the options */
		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

		/** Flush rewrite rules */
		$this->register_taxonomies();
		flush_rewrite_rules();
	}

	/**
	 * Delete a taxonomy.
	 *
	 * @access public
	 * @param string $id (default: '').
	 * @return void
	 */
	function delete_taxonomy( $identifier = '' ) {

		/**** VERIFY THE NONCE */

		/** No empty ID */
		if ( ! isset( $identifier ) || empty( $identifier ) ) {
			wp_die( esc_html__( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );
			// * Why don't we just give up pardner?
		}

		$options = get_option( $this->settings_field );

		/** Look for the ID, delete if it exists */
		if ( array_key_exists( $identifier, (array) $options ) ) {
			unset( $options[ $identifier ] );
		} else {
			wp_die( esc_html__( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );
		}

		/** Update the DB */
		update_option( $this->settings_field, $options );

	}

	/**
	 * Edit Taxonomy function.
	 *
	 * @access public
	 * @param array $args (default: array()).
	 * @return void
	 */
	function edit_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE */

		/** No empty fields */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) ) {
			wp_die( esc_html__( 'Please complete all required fields.', 'wp-listings-pro' ) );
		}

		$name          = $args['name'];
		$singular_name = $args['singular_name'];
		$id            = $args['id'];

		$labels = array(
			'name'                  => wp_strip_all_tags( $name ),
			'singular_name'         => wp_strip_all_tags( $singular_name ),
			'menu_name'             => wp_strip_all_tags( $name ),

			'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
			'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
			'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => $id,
				'with_front' => false,
			),
			'editable'     => 1,
		);

		$tax = array( $id => $args );

		$options = get_option( $this->settings_field );

		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

	}

	/**
	 * Notices function.
	 *
	 * @access public
	 * @return void
	 */
	function notices() {

		if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] !== $this->menu_page ) {
			return;
		}

		$format = '<div id="message" class="updated"><p><strong>%s</strong></p></div>';

		if ( isset( $_REQUEST['created'] ) && 'true' === $_REQUEST['created'] ) {
			printf( $format, __( 'New taxonomy successfully created!', 'wp-listings-pro' ) );
			return;
		}

		if ( isset( $_REQUEST['edited'] ) && 'true' === $_REQUEST['edited'] ) {
			printf( $format, __( 'Taxonomy successfully edited!', 'wp-listings-pro' ) );
			return;
		}

		if ( isset( $_REQUEST['deleted'] ) && 'true' === $_REQUEST['deleted'] ) {
			printf( $format, __( 'Taxonomy successfully deleted.', 'wp-listings-pro' ) );
			return;
		}

		return;

	}

	/**
	 * Register the job-types taxonomy, manually.
	 */
	function employee_job_type_taxonomy() {

		$name          = __( 'Job Types', 'wp-listings-pro' );
		$singular_name = __( 'Job Type', 'wp-listings-pro' );

		return array(
			'job-types' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => true,
				'rewrite'               => array(
					__( 'job-types', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'job-types',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);
	}

	/**
	 * Register the offices taxonomy, manually.
	 */
	function employee_offices_taxonomy() {

		$name          = __( 'Offices', 'wp-listings-pro' );
		$singular_name = __( 'Office', 'wp-listings-pro' );

		return array(
			'offices' => array(
				'labels'                => array(
					'name'                  => wp_strip_all_tags( $name ),
					'singular_name'         => wp_strip_all_tags( $singular_name ),
					'menu_name'             => wp_strip_all_tags( $name ),

					'search_items'          => sprintf( __( 'Search %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'popular_items'         => sprintf( __( 'Popular %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'all_items'             => sprintf( __( 'All %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'edit_item'             => sprintf( __( 'Edit %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'update_item'           => sprintf( __( 'Update %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_new_item'          => sprintf( __( 'Add New %s', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'new_item_name'         => sprintf( __( 'New %s Name', 'wp-listings-pro' ), wp_strip_all_tags( $singular_name ) ),
					'add_or_remove_items'   => sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
					'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), wp_strip_all_tags( $name ) ),
				),
				'hierarchical'          => true,
				'rewrite'               => array(
					__( 'offices', 'wp-listings-pro' ),
					'with_front' => false,
				),
				'editable'              => 0,
				'show_in_rest'          => true,
				'rest_base'             => 'offices',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			),
		);
	}

	/**
	 * Actually create the taxonomies.
	 */
	function register_taxonomies() {
		foreach ( (array) $this->get_taxonomies() as $id => $data ) {
			register_taxonomy( $id, array( 'employee' ), $data );
		}
	}

	/**
	 * Get the taxonomies.
	 *
	 * @return array Taxonomies.
	 */
	function get_taxonomies() {
		return array_merge( $this->employee_offices_taxonomy(), $this->employee_job_type_taxonomy(), (array) get_option( $this->settings_field ) );
	}

	/**
	 * Register term meta for a featured image
	 *
	 * @return void
	 */
	function register_term_meta() {
		register_meta( 'term', 'wpmlpro_term_image', 'WPLPROAgents_sanitize_term_image' );
	}

	/**
	 * Extraordinarily powerful and useful function to sanitize term images.
	 *
	 * @param object $wpmlpro_term_image    Object that you want returned to you.
	 * @return object                                       Object that will be returned exactly as it was without any actual sanitizing.
	 */
	function WPLPROAgents_sanitize_term_image( $wpmlpro_term_image ) {
		return $wpmlpro_term_image;
	}

	/**
	 * Get the term featured image id
	 *
	 * @param string $term_id               ID of term object.
	 * @param bool   $html            Whether to use html wrapper.
	 * @uses  wp_get_attachment_image To return image id wrapped in markup.
	 * @return string                               Formatted image to be injected, containing the image
	 */
	function WPLPROAgents_get_term_image( $term_id, $html = true ) {
		$image_id = get_term_meta( $term_id, 'wpmlpro_term_image', true );
		return $image_id && $html ? wp_get_attachment_image( $image_id, 'thumbnail' ) : $image_id;
	}

	/**
	 * Save the image uploaded
	 *
	 * @param  string $term_id  Term slug.
	 * @return string                   Term ID.
	 */
	function WPLPROAgents_save_term_image( $term_id ) {

		if ( ! isset( $_POST['wpmlpro_term_image_nonce'] ) || ! wp_verify_nonce( $_POST['wpmlpro_term_image_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$old_image = $this->WPLPROAgents_get_term_image( $term_id );
		$new_image = isset( $_POST['wplpro-term-image'] ) ? $_POST['wplpro-term-image'] : '';

		if ( $old_image && '' === $new_image ) {
			delete_term_meta( $term_id, 'wpmlpro_term_image' );

		} elseif ( $old_image !== $new_image ) {
			update_term_meta( $term_id, 'wpmlpro_term_image', $new_image );
		}

		return $term_id;

	}

	/**
	 * Filter the edit term columns
	 *
	 * @param object $columns Column object to append/add term image link to.
	 * @return object               Original column object with appended term image link.
	 */
	function WPLPROAgents_edit_term_columns( $columns ) {
		$columns['wpmlpro_term_image'] = __( 'Image', 'wp-listings-pro' );

		return $columns;
	}



	/**
	 * Display a custom taxonomy dropdown in admin
	 */
	function WPLPROAgents_filter_post_type_by_taxonomy() {
		global $typenow;
		$post_type  = 'employee';
		$taxonomies = array( 'job-types', 'offices' );
		foreach ( $taxonomies as $taxonomy ) {
			if ( $typenow === $post_type ) {
				$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
				$info_taxonomy = get_taxonomy( $taxonomy );
				wp_dropdown_categories(
					array(
						'show_option_all' => __( "Show All {$info_taxonomy->label}" ),
						'taxonomy'        => $taxonomy,
						'name'            => $taxonomy,
						'orderby'         => 'name',
						'selected'        => $selected,
						'show_count'      => true,
						'hide_empty'      => true,
					)
				);
			};
		}
	}

	/**
	 * Filter posts by taxonomy in admin
	 *
	 * @param object $query Query results to pass.
	 */
	function WPLPROAgents_convert_id_to_term_in_query( $query ) {
		global $pagenow;
		$post_type  = 'employee';
		$taxonomies = array( 'job-types', 'offices' );
		$q_vars     = &$query->query_vars;
		foreach ( $taxonomies as $taxonomy ) {
			if ( 'edit.php' === $pagenow && isset( $q_vars['post_type'] ) && $q_vars['post_type'] === $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && 0 !== $q_vars[ $taxonomy ] ) {
				$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
				$q_vars[ $taxonomy ] = $term->slug;
			}
		}
	}

	/**
	 * Field for adding a new image on a term.
	 *
	 * @access public
	 * @param mixed $term Term.
	 * @return void
	 */
	function WPLPROAgents_new_term_image_field( $term ) {

		$image_id = '';

		wp_nonce_field( basename( __FILE__ ), 'wpmlpro_term_image_nonce' );

		?>
			<div class="form-field wplpro-term-image-wrap">
				<label for="wplpro-term-image"><?php esc_html_e( 'Image', 'wp-listings-pro' ); ?></label>
				<!-- Begin term image -->
				<p>
					<input type="hidden" name="wplpro-term-image" id="wplpro-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
					<a href="#" class="wplpro-add-media wplpro-add-media-img"><img class="wplpro-term-image-url" src="" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
					<a href="#" class="wplpro-add-media wplpro-add-media-text"><?php esc_html_e( 'Set term image', 'wp-listings-pro' ); ?></a>
					<a href="#" class="wplpro-remove-media"><?php esc_html_e( 'Remove term image', 'wp-listings-pro' ); ?></a>
				</p>
				<!-- End term image -->
			</div>
		<?php
	}

	/**
	 * Field for editing an image on a term
	 *
	 * @param object $term Term image being passed for editing.
	 */
	function WPLPROAgents_edit_term_image_field( $term ) {

		$image_id  = $this->WPLPROAgents_get_term_image( $term->term_id, false );
		$image_url = wp_get_attachment_url( $image_id );

		if ( ! $image_url ) {
			$image_url = '';
		}
		?>
			<tr class="form-field wplpro-term-image-wrap">
			<th scope="row"><label for="wplpro-term-image"><?php esc_html_e( 'Image', 'wp-listings-pro' ); ?></label></th>
			<td>
				<?php wp_nonce_field( basename( __FILE__ ), 'wplpro_term_image_nonce' ); ?>
				<!-- Begin term image -->
				<p>
				<input type="hidden" name="wplpro-term-image" id="wplpro-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
				<a href="#" class="wplpro-add-media wplpro-add-media-img"><img class="wplpro-term-image-url" src="<?php echo esc_url( $image_url ); ?>" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
				<a href="#" class="wplpro-add-media wplpro-add-media-text"><?php esc_html_e( 'Set term image', 'wp-listings-pro' ); ?></a>
				<a href="#" class="wplpro-remove-media"><?php esc_html_e( 'Remove term image', 'wp-listings-pro' ); ?></a>
				</p>
				<!-- End term image -->
			</td>
			</tr>
		<?php
	}
}

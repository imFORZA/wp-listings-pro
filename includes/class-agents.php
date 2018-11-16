<?php
/**
 * This file contains the WPLPROAgents class.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class handles the creation of the "Employees" post type, and creates a
 * UI to display the Employee-specific data on the admin screens.
 */
class WPLPROAgents {

	/**
	 * Settings field
	 *
	 * @var string
	 */
	var $settings_field = 'WPLPROAgents_taxonomies';

	/**
	 * Page from which to be called
	 *
	 * @var string
	 */
	var $menu_page = 'wplpro-agents-taxonomies';

	/**
	 * Global access var for options, loaded from WPLPROAgents_settings.
	 *
	 * @var object
	 */
	var $options;

	/**
	 * Employee details array.
	 *
	 * @var object
	 */
	var $employee_details;

	/**
	 * Employee Social Contact Info object
	 *
	 * @var object
	 */
	var $employee_social;

	/**
	 * Construct Method.
	 */
	function __construct() {

		$this->options = get_option( 'WPLPROAgents_settings' );

		$this->employee_details = apply_filters(
			'WPLPROAgents_employee_details',
			array(
				'col1' => array(
					__( 'First Name:', 'wp-listings-pro' ) => '_employee_first_name',
					__( 'Last Name:', 'wp-listings-pro' )  => '_employee_last_name',
					__( 'Title:', 'wp-listings-pro' )      => '_employee_title',
					__( 'Email:', 'wp-listings-pro' )      => '_employee_email',
					__( 'Website:', 'wp-listings-pro' )    => '_employee_website',
					__( 'Phone:', 'wp-listings-pro' )      => '_employee_phone',
					__( 'Mobile:', 'wp-listings-pro' )     => '_employee_mobile',
				),
				'col2' => array(
					__( 'License #:', 'wp-listings-pro' ) => '_employee_license',
					__( 'Agent ID:', 'wp-listings-pro' )  => '_employee_agent_id',
					__( 'Designations:', 'wp-listings-pro' ) => '_employee_designations',
					__( 'Address:', 'wp-listings-pro' )   => '_employee_address',
					__( 'City:', 'wp-listings-pro' )      => '_employee_city',
					__( 'State:', 'wp-listings-pro' )     => '_employee_state',
					__( 'Zip:', 'wp-listings-pro' )       => '_employee_zip',
				),
			)
		);

		$this->employee_social = apply_filters(
			'WPLPROAgents_employee_social',
			array(
				__( 'Facebook URL:', 'wp-listings-pro' )  => '_employee_facebook',
				__( 'Twitter URL:', 'wp-listings-pro' )   => '_employee_twitter',
				__( 'LinkedIn URL:', 'wp-listings-pro' )  => '_employee_linkedin',
				__( 'Google+ URL:', 'wp-listings-pro' )   => '_employee_googleplus',
				__( 'Pinterest URL:', 'wp-listings-pro' ) => '_employee_pinterest',
				__( 'YouTube URL:', 'wp-listings-pro' )   => '_employee_youtube',
				__( 'Instagram URL:', 'wp-listings-pro' ) => '_employee_instagram',
			)
		);

		add_action( 'init', array( $this, 'create_post_type' ) );

		add_filter( 'manage_edit-employee_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );

		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ), 5 );
		add_action( 'save_post', array( $this, 'metabox_save' ), 1, 2 );

	}



	/**
	 * Creates our "Employee" post type.
	 */
	function create_post_type() {

		$args = apply_filters(
			'WPLPROAgents_post_type_args',
			array(
				'labels'                => array(
					'name'                  => __( 'Employees', 'wp-listings-pro' ),
					'singular_name'         => __( 'Employee', 'wp-listings-pro' ),
					'add_new'               => __( 'Add New', 'wp-listings-pro' ),
					'add_new_item'          => __( 'Add New Employee', 'wp-listings-pro' ),
					'edit'                  => __( 'Edit', 'wp-listings-pro' ),
					'edit_item'             => __( 'Edit Employee', 'wp-listings-pro' ),
					'new_item'              => __( 'New Employee', 'wp-listings-pro' ),
					'view'                  => __( 'View Employee', 'wp-listings-pro' ),
					'view_item'             => __( 'View Employee', 'wp-listings-pro' ),
					'search_items'          => __( 'Search Employees', 'wp-listings-pro' ),
					'not_found'             => __( 'No employees found', 'wp-listings-pro' ),
					'not_found_in_trash'    => __( 'No employees found in Trash', 'wp-listings-pro' ),
					'filter_items_list'     => __( 'Filter Employees', 'wp-listings-pro' ),
					'items_list_navigation' => __( 'Employees navigation', 'wp-listings-pro' ),
					'items_list'            => __( 'Employees list', 'wp-listings-pro' ),
				),
				'public'                => true,
				'query_var'             => true,
				'show_in_rest'          => true,
				'rest_base'             => 'employee',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-groups',
				'has_archive'           => true,
				'supports'              => array( 'title', 'editor', 'author', 'comments', 'excerpt', 'thumbnail', 'revisions', 'equity-layouts', 'equity-cpt-archives-settings', 'genesis-seo', 'genesis-layouts', 'genesis-simple-sidebars', 'genesis-cpt-archives-settings', 'publicize', 'wpcom-markdown' ),
				'rewrite'               => array(
					'slug'       => $this->options['wplpro_slug'],
					'feeds'      => true,
					'with_front' => false,
				),
			)
		);

		register_post_type( 'employee', $args );

	}

	/**
	 * Register meta boxes function.
	 *
	 * @access public
	 * @return void
	 */
	function register_meta_boxes() {
		wplpro_admin_scripts_styles();
		add_meta_box( 'employee_details_metabox', __( 'Employee Info', 'wp-listings-pro' ), array( &$this, 'employee_details_metabox' ), 'employee', 'normal', 'high' );
		add_meta_box( 'employee_sync_metabox', __( 'Synchronization Settings', 'wp-listings-pro' ), array( &$this, 'employee_sync_metabox' ), 'employee', 'normal', 'high' );
	}

	/**
	 * Employee details metabox function.
	 *
	 * @access public
	 * @return void
	 */
	function employee_details_metabox() {
		include dirname( __FILE__ ) . '/views/employee-details-metabox.php';
	}

	/**
	 *  Employee sync settings metabox function
	 *
	 *  @access public
	 *  @return void
	 */
	function employee_sync_metabox() {
		include dirname( __FILE__ ) . '/views/employee-sync-metabox.php';
	}

	/**
	 * Should be what gets called to save the meta boxes right?
	 *
	 * @param  int     $post_id    ID of the post.
	 * @param  WP_Post $post       Object containing the post.
	 */
	function metabox_save( $post_id, $post ) {

		/** Run only on employees post type save. */
		if ( 'employee' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['WPLPROAgents_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['WPLPROAgents_metabox_nonce'], 'WPLPROAgents_metabox_save' ) ) {
			return $post_id;
		}

		/** Don't try to save the data under autosave, ajax, or future post. */
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

		$employee_details = $_POST['WPLPROAgents'];
		/** Validate and store the employee details custom fields */
		foreach ( (array) $employee_details as $key => $value ) {

			$key = sanitize_key( $key );

			if ( '_employee_email' === $key ) {
				$value = sanitize_email( $value );
			} else {
				$value = sanitize_text_field( $value );
			}

			  /** Save/Update/Delete. */
			if ( $value ) {
				  update_post_meta( $post->ID, $key, $value );
			} else {
				  delete_post_meta( $post->ID, $key );
			}
		}
	}

	/**
	 * Filter the columns in the "Employees" screen, define our own.
	 *
	 * @param  array $columns Array of employee data stuff.
	 * @return array $columns New array of employee data stuff.
	 */
	function columns_filter( $columns ) {

		$columns = array(
			'cb'                 => '<input type="checkbox" />',
			'employee_thumbnail' => __( 'Thumbnail', 'wp-listings-pro' ),
			'title'              => __( 'Employee Name', 'wp-listings-pro' ),
			'employee_details'   => __( 'Details', 'wp-listings-pro' ),
			'employee_tags'      => __( 'Categories', 'wp-listings-pro' ),
		);

		return $columns;

	}

	/**
	 * Filter the data that shows up in the columns in the "Employees" screen, define our own.
	 *
	 * @param string $column Object name to be tested for type and which different data will be returned based on.
	 */
	function columns_data( $column ) {

		global $post, $wp_taxonomies;

		// So because of the way that esc_attr works, quotation marks will break it. OK then.
		$image_size = 'style=min-width:150px;min-height:150px;width:150px;height:150px';

		apply_filters( 'WPLPROAgents_admin_employee_details', $admin_details = $this->employee_details['col1'] );

		if ( isset( $_GET['mode'] ) && trim( $_GET['mode'] ) === 'excerpt' ) {
			apply_filters( 'WPLPROAgents_admin_extended_details', $admin_details = $this->employee_details['col1'] + $this->employee_details['col2'] );
		}

		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );

		// Adds support for nophoto, as defined in the customizer.
		if ( ! isset( $image[0] ) || '' === $image[0] ) {
			$options = get_option( 'wplpro_plugin_settings' );

			$image_url;
			if ( isset( get_option( 'wplpro_plugin_settings' )['employee_nophoto'] ) ) {
				$image_url = get_option( 'wplpro_plugin_settings' )['employee_nophoto'];
			} else {
				$image_url = plugin_dir_url( __FILE__ ) . '../assets/images/default.gif';
			}

			$image = array(
				$image_url,
			);
		}

		switch ( $column ) {
			case 'employee_thumbnail':
				echo '<p><img src="' . esc_url( $image[0] ) . '" alt="employee-thumbnail" ' . esc_attr( $image_size ) . ' /></p>';
				break;
			case 'employee_details':
				foreach ( (array) $admin_details as $label => $key ) {
					printf( '<b>%s</b> %s<br />', esc_html( $label ), esc_html( get_post_meta( $post->ID, $key, true ) ) );
				}
				break;
			case 'employee_tags':
				echo '<b>Job Type:</b> ' . get_the_term_list( $post->ID, 'job-types', '', ', ', '' ) . '<br />';
				echo '<b>Office:</b> ' . get_the_term_list( $post->ID, 'offices', '', ', ', '' ) . '<br />';
				break;
		}

	}

}

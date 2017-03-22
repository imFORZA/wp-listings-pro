<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * This file contains the IMPress_Agents_Taxonomies class.
 */

/**
 * This class handles all the aspects of displaying, creating, and editing the
 * user-created taxonomies for the "Employees" post-type.
 *
 */
class IMPress_Agents_Taxonomies {

	var $settings_field = 'impress_agents_taxonomies';
	var $menu_page = 'impress-agents-taxonomies';

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

			foreach( (array) $this->get_taxonomies() as $slug => $data ) {
				add_action( "{$slug}_add_form_fields", array( $this, 'impress_agents_new_term_image_field') );
				add_action( "{$slug}_edit_form_fields", array( $this, 'impress_agents_edit_term_image_field') );
				add_action( "create_{$slug}", array( $this, 'impress_agents_save_term_image') );
				add_action( "edit_{$slug}", array( $this, 'impress_agents_save_term_image') );
				add_filter( "manage_edit-{$slug}_columns", array( $this, 'impress_agents_edit_term_columns' ) );
				add_action( "manage_{$slug}_custom_column", array( $this, 'impress_agents_manage_term_custom_column' ), 10, 3 );
			}
		}

		add_action('restrict_manage_posts', array($this, 'impress_agents_filter_post_type_by_taxonomy') );
		add_filter('parse_query', array($this, 'impress_agents_convert_id_to_term_in_query') );

	}

	function register_settings() {

		register_setting( $this->settings_field, $this->settings_field );
		add_option( $this->settings_field, __return_empty_array(), '', 'yes' );

	}

	function settings_init() {

		add_submenu_page( 'edit.php?post_type=employee', __( 'Register Taxonomies', 'wp-listings-pro' ), __( 'Register Taxonomies', 'wp-listings-pro' ), 'manage_options', $this->menu_page, array( &$this, 'admin' ) );
	}

	function actions() {

		if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != $this->menu_page ) {
			return;
		}

		/** This section handles the data if a new taxonomy is created */
		if ( isset( $_REQUEST['action'] ) && 'create' == $_REQUEST['action'] ) {
			$this->create_taxonomy( $_POST['impress_agents_taxonomy'] );
		}

		/** This section handles the data if a taxonomy is deleted */
		if ( isset( $_REQUEST['action'] ) && 'delete' == $_REQUEST['action'] ) {
			$this->delete_taxonomy( $_REQUEST['id'] );
		}

		/** This section handles the data if a taxonomy is being edited */
		if ( isset( $_REQUEST['action'] ) && 'edit' == $_REQUEST['action'] ) {
			$this->edit_taxonomy( $_POST['impress_agents_taxonomy'] );
		}

	}

	function admin() {

		echo '<div class="wrap">';

			if ( isset( $_REQUEST['view'] ) && 'edit' == $_REQUEST['view'] ) {
				require( dirname( __FILE__ ) . '/views/edit-tax.php' );
			}
			else {
				require( dirname( __FILE__ ) . '/views/create-tax.php' );
			}

		echo '</div>';

	}

	function create_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE ****/

		/** No empty fields */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );

		extract( $args );

		$labels = array(
			'name'					=> strip_tags( $name ),
			'singular_name' 		=> strip_tags( $singular_name ),
			'menu_name'				=> strip_tags( $name ),

			'search_items'			=> sprintf( __( 'Search %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'popular_items'			=> sprintf( __( 'Popular %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'all_items'				=> sprintf( __( 'All %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'edit_item'				=> sprintf( __( 'Edit %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'update_item'			=> sprintf( __( 'Update %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'add_new_item'			=> sprintf( __( 'Add New %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'new_item_name'			=> sprintf( __( 'New %s Name', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'add_or_remove_items'	=> sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'choose_from_most_used'	=> sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), strip_tags( $name ) )
		);

		$args = array(
			'labels'		=> $labels,
			'hierarchical'	=> true,
			'rewrite'		=> array( 'slug' => $id, 'with_front' => false ),
			'editable'		=> 1
		);

		$tax = array( $id => $args );

		$options = get_option( $this->settings_field );

		/** Update the options */
		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

		/** Flush rewrite rules */
		$this->register_taxonomies();
		flush_rewrite_rules();

	}

	function delete_taxonomy( $id = '' ) {

		/**** VERIFY THE NONCE ****/

		/** No empty ID */
		if ( ! isset( $id ) || empty( $id ) )
			wp_die( __( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );

		$options = get_option( $this->settings_field );

		/** Look for the ID, delete if it exists */
		if ( array_key_exists( $id, (array) $options ) ) {
			unset( $options[$id] );
		} else {
			wp_die( __( "Nice try, partner. But that taxonomy doesn't exist. Click back and try again.", 'wp-listings-pro' ) );
		}

		/** Update the DB */
		update_option( $this->settings_field, $options );

	}

	function edit_taxonomy( $args = array() ) {

		/**** VERIFY THE NONCE ****/

		/** No empty fields */
		if ( ! isset( $args['id'] ) || empty( $args['id'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );
		if ( ! isset( $args['name'] ) || empty( $args['name'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );
		if ( ! isset( $args['singular_name'] ) || empty( $args['singular_name'] ) )
			wp_die( __( 'Please complete all required fields.', 'wp-listings-pro' ) );

		extract( $args );

		$labels = array(
			'name'					=> strip_tags( $name ),
			'singular_name' 		=> strip_tags( $singular_name ),
			'menu_name'				=> strip_tags( $name ),

			'search_items'			=> sprintf( __( 'Search %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'popular_items'			=> sprintf( __( 'Popular %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'all_items'				=> sprintf( __( 'All %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'edit_item'				=> sprintf( __( 'Edit %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'update_item'			=> sprintf( __( 'Update %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'add_new_item'			=> sprintf( __( 'Add New %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'new_item_name'			=> sprintf( __( 'New %s Name', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
			'add_or_remove_items'	=> sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), strip_tags( $name ) ),
			'choose_from_most_used'	=> sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), strip_tags( $name ) )
		);

		$args = array(
			'labels'		=> $labels,
			'hierarchical'	=> true,
			'rewrite'		=> array( 'slug' => $id, 'with_front' => false ),
			'editable'		=> 1
		);

		$tax = array( $id => $args );

		$options = get_option( $this->settings_field );

		update_option( $this->settings_field, wp_parse_args( $tax, $options ) );

	}

	function notices() {

		if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != $this->menu_page ) {
			return;
		}

		$format = '<div id="message" class="updated"><p><strong>%s</strong></p></div>';

		if ( isset( $_REQUEST['created'] ) && 'true' == $_REQUEST['created'] ) {
			printf( $format, __('New taxonomy successfully created!', 'wp-listings-pro') );
			return;
		}

		if ( isset( $_REQUEST['edited'] ) && 'true' == $_REQUEST['edited'] ) {
			printf( $format, __('Taxonomy successfully edited!', 'wp-listings-pro') );
			return;
		}

		if ( isset( $_REQUEST['deleted'] ) && 'true' == $_REQUEST['deleted'] ) {
			printf( $format, __('Taxonomy successfully deleted.', 'wp-listings-pro') );
			return;
		}

		return;

	}

	/**
	 * Register the job-types taxonomy, manually.
	 */
	function employee_job_type_taxonomy() {

		$name = __( 'Job Types', 'wp-listings-pro' );
		$singular_name = __( 'Job Type', 'wp-listings-pro' );

		return array(
			'job-types' => array(
				'labels' => array(
					'name'					=> strip_tags( $name ),
					'singular_name' 		=> strip_tags( $singular_name ),
					'menu_name'				=> strip_tags( $name ),

					'search_items'			=> sprintf( __( 'Search %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'popular_items'			=> sprintf( __( 'Popular %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'all_items'				=> sprintf( __( 'All %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'edit_item'				=> sprintf( __( 'Edit %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'update_item'			=> sprintf( __( 'Update %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'add_new_item'			=> sprintf( __( 'Add New %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'new_item_name'			=> sprintf( __( 'New %s Name', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'add_or_remove_items'	=> sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'choose_from_most_used'	=> sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), strip_tags( $name ) )
				),
				'hierarchical' => true,
				'rewrite'  => array( __( 'job-types', 'wp-listings-pro' ), 'with_front' => false ),
				'editable' => 0,
				'show_in_rest'  => true,
				'rest_base'     => 'job-types',
				'rest_controller_class' => 'WP_REST_Terms_Controller'
			)
		);

	}

	/**
	 * Register the offices taxonomy, manually.
	 */
	function employee_offices_taxonomy() {

		$name = __( 'Offices', 'wp-listings-pro' );
		$singular_name = __( 'Office', 'wp-listings-pro' );

		return array(
			'offices' => array(
				'labels' => array(
					'name'					=> strip_tags( $name ),
					'singular_name' 		=> strip_tags( $singular_name ),
					'menu_name'				=> strip_tags( $name ),

					'search_items'			=> sprintf( __( 'Search %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'popular_items'			=> sprintf( __( 'Popular %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'all_items'				=> sprintf( __( 'All %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'edit_item'				=> sprintf( __( 'Edit %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'update_item'			=> sprintf( __( 'Update %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'add_new_item'			=> sprintf( __( 'Add New %s', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'new_item_name'			=> sprintf( __( 'New %s Name', 'wp-listings-pro' ), strip_tags( $singular_name ) ),
					'add_or_remove_items'	=> sprintf( __( 'Add or Remove %s', 'wp-listings-pro' ), strip_tags( $name ) ),
					'choose_from_most_used'	=> sprintf( __( 'Choose from the most used %s', 'wp-listings-pro' ), strip_tags( $name ) )
				),
				'hierarchical' => true,
				'rewrite' => array( __( 'offices', 'wp-listings-pro' ), 'with_front' => false ),
				'editable' => 0,
				'show_in_rest'  => true,
				'rest_base'     => 'offices',
				'rest_controller_class' => 'WP_REST_Terms_Controller'
			)
		);

	}

	/**
	 * Create the taxonomies.
	 */
	function register_taxonomies() {

		foreach( (array) $this->get_taxonomies() as $id => $data ) {
			register_taxonomy( $id, array( 'employee' ), $data );
		}

	}

	/**
	 * Get the taxonomies.
	 */
	function get_taxonomies() {

		return array_merge( $this->employee_offices_taxonomy(), $this->employee_job_type_taxonomy(), (array) get_option( $this->settings_field ) );

	}

	/**
	 * Register term meta for a featured image
	 * @return [type] [description]
	 */
	function register_term_meta() {
		register_meta( 'term', 'impa_term_image', 'impress_agents_sanitize_term_image' );
	}

	/**
	 * Callback to retrieve the term image
	 * @return [type] [description]
	 */
	function impress_agents_sanitize_term_image( $impa_term_image ) {
		return $impa_term_image;
	}

	/**
	 * Get the term featured image id
	 * @param  $html bool whether to use html wrapper
	 * @uses  wp_get_attachment_image to return image id wrapped in markup
	 */
	function impress_agents_get_term_image( $term_id, $html = true ) {
		$image_id = get_term_meta( $term_id, 'impa_term_image', true );
		return $image_id && $html ? wp_get_attachment_image( $image_id, 'thumbnail' ) : $image_id;
	}

	/**
	 * Save the image uploaded
	 * @param  string $term_id term slug
	 */
	function impress_agents_save_term_image( $term_id ) {

	    if ( ! isset( $_POST['impa_term_image_nonce'] ) || ! wp_verify_nonce( $_POST['impa_term_image_nonce'], basename( __FILE__ ) ) )
	        return;

	    $old_image = $this->impress_agents_get_term_image( $term_id );
	    $new_image = isset( $_POST['impa-term-image'] ) ? $_POST['impa-term-image'] : '';

	    if ( $old_image && '' === $new_image )
	        delete_term_meta( $term_id, 'impa_term_image' );

	    else if ( $old_image !== $new_image )
	        update_term_meta( $term_id, 'impa_term_image', $new_image );

	    return $term_id;

	}

	/**
	 * Filter the edit term columns
	 */

	function impress_agents_edit_term_columns( $columns ) {

	    $columns['impa_term_image'] = __( 'Image', 'wp-listings-pro' );

	    return $columns;
	}

	/**
	 * Display the new column
	 */
	function impress_agents_manage_term_custom_column( $out, $column, $term_id ) {

	    if ( 'impa_term_image' === $column ) {

	        $image_id = $this->impress_agents_get_term_image( $term_id, false );

	        if (!$image_id)
	        	return $out;

	        $image_markup = wp_get_attachment_image( $image_id, 'thumbnail', true, array('class' => 'impa-term-image'));

	        $out = $image_markup;
	    }

	    return $out;
	}

	/**
	 * Display a custom taxonomy dropdown in admin
	 */
	function impress_agents_filter_post_type_by_taxonomy() {
		global $typenow;
		$post_type = 'employee';
		$taxonomies  = array('job-types', 'offices');
		foreach($taxonomies as $taxonomy) {
			if ($typenow == $post_type) {
				$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
				$info_taxonomy = get_taxonomy($taxonomy);
				wp_dropdown_categories(array(
					'show_option_all' => __("Show All {$info_taxonomy->label}"),
					'taxonomy'        => $taxonomy,
					'name'            => $taxonomy,
					'orderby'         => 'name',
					'selected'        => $selected,
					'show_count'      => true,
					'hide_empty'      => true,
				));
			};
		}
	}

	/**
	 * Filter posts by taxonomy in admin
	 */
	function impress_agents_convert_id_to_term_in_query($query) {
		global $pagenow;
		$post_type = 'employee';
		$taxonomies  = array('job-types', 'offices');
		$q_vars    = &$query->query_vars;
		foreach($taxonomies as $taxonomy) {
			if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
				$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
				$q_vars[$taxonomy] = $term->slug;
			}
		}
	}

	/**
	 * Field for adding a new image on a term
	 */
	function impress_agents_new_term_image_field( $term ) {

	    $image_id = '';

	    wp_nonce_field( basename( __FILE__ ), 'impa_term_image_nonce' ); ?>

	    <div class="form-field impa-term-image-wrap">
	        <label for="impa-term-image"><?php _e( 'Image', 'wp-listings-pro' ); ?></label>
	        <!-- Begin term image -->
			<p>
				<input type="hidden" name="impa-term-image" id="impa-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
				<a href="#" class="impa-add-media impa-add-media-img"><img class="impa-term-image-url" src="" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
				<a href="#" class="impa-add-media impa-add-media-text"><?php _e( 'Set term image', 'wp-listings-pro' ); ?></a>
				<a href="#" class="impa-remove-media"><?php _e( 'Remove term image', 'wp-listings-pro' ); ?></a>
			</p>
			<!-- End term image -->
	    </div>
	<?php }

	/**
	 * Field for editing an image on a term
	 */
	function impress_agents_edit_term_image_field( $term ) {

	    $image_id = $this->impress_agents_get_term_image( $term->term_id, false );
	    $image_url = wp_get_attachment_url($image_id);

	    if ( ! $image_url )
	    	$image_url = ''; ?>

	    <tr class="form-field impa-term-image-wrap">
	        <th scope="row"><label for="impa-term-image"><?php _e( 'Image', 'wp-listings-pro' ); ?></label></th>
	        <td>
	            <?php wp_nonce_field( basename( __FILE__ ), 'impa_term_image_nonce' ); ?>
	            <!-- Begin term image -->
				<p>
					<input type="hidden" name="impa-term-image" id="impa-term-image" value="<?php echo esc_attr( $image_id ); ?>" />
					<a href="#" class="impa-add-media impa-add-media-img"><img class="impa-term-image-url" src="<?php echo esc_url( $image_url ); ?>" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
					<a href="#" class="impa-add-media impa-add-media-text"><?php _e( 'Set term image', 'wp-listings-pro' ); ?></a>
					<a href="#" class="impa-remove-media"><?php _e( 'Remove term image', 'wp-listings-pro' ); ?></a>
				</p>
				<!-- End term image -->
	        </td>
	    </tr>
	<?php }

}

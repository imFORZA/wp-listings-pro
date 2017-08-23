<?php

/**
 * location_metabox class.
 */
class location_metabox {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	/**
	 * init_metabox function.
	 *
	 * @access public
	 * @return void
	 */
	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );

	}

	/**
	 * add_metabox function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_metabox() {

		add_meta_box(
			'location',
			__( 'Location', 'wp-listings-pro' ),
			array( $this, 'location_metabox' ),
			'listing',
			'advanced',
			'core'
		);

	}

	/**
	 * location_metabox function.
	 *
	 * @access public
	 * @param mixed $post
	 * @return void
	 */
	public function location_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'listing_nonce_action', 'listing_nonce' );

		//TODO - Finish Fields - http://ddwiki.reso.org/display/DDW16/Location+Group
		// State, City, Zip, should be taxonomies
		// TODO  _listing_address, _listing_city, _listing_county, _listing_state, _listing_country, _listing_zip

		// Retrieve an existing value from the database.
		$listing_carrier_route = get_post_meta( $post->ID, 'listing_carrier_route', true );
		$listing_city = get_post_meta( $post->ID, 'listing_city', true );
		$listing_country = get_post_meta( $post->ID, 'listing_country', true );
		$listing_county_or_parish = get_post_meta( $post->ID, 'listing_county_or_parish', true );
		$listing_postal_city = get_post_meta( $post->ID, 'listing_postal_city', true );
		$listing_postal_code = get_post_meta( $post->ID, 'listing_postal_code', true );
		$listing_postalcode_plus4 = get_post_meta( $post->ID, 'listing_postalcode_plus4', true );
		$listing_state_or_province = get_post_meta( $post->ID, 'listing_state_or_province', true );
		$listing_street_additional_info = get_post_meta( $post->ID, 'listing_street_additional_info', true );

		// Set default values.
		if( empty( $listing_carrier_route ) ) $listing_carrier_route = '';
		if( empty( $listing_city ) ) $listing_city = '';
		if( empty( $listing_country ) ) $listing_country = '';
		if( empty( $listing_county_or_parish ) ) $listing_county_or_parish = '';
		if( empty( $listing_postal_city ) ) $listing_postal_city = '';
		if( empty( $listing_postal_code ) ) $listing_postal_code = '';
		if( empty( $listing_postalcode_plus4 ) ) $listing_postalcode_plus4 = '';
		if( empty( $listing_state_or_province ) ) $listing_state_or_province = '';
		if( empty( $listing_street_additional_info ) ) $listing_street_additional_info = '';

		// Form fields.
		echo '<table class="form-table">';

		// Carrier Route.
		echo '	<tr>';
		echo '		<th><label for="listing_carrier_route" class="listing_carrier_route_label">' . __( 'Carrier Route', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_carrier_route" name="listing_carrier_route" class="listing_carrier_route_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_carrier_route ) . '">';
		echo '			<p class="description">' . __( 'The group of addresses to which the USPS assigns the same code to aid in mail delivery. For the USPS, these codes are 9 digits: 5 numbers for the ZIP Code, one letter for the carrier route type, and 3 numbers for the carrier route number.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// City.
		echo '	<tr>';
		echo '		<th><label for="listing_city" class="listing_city_label">' . __( 'City', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_city" name="listing_city" class="listing_city_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_city ) . '">';
		echo '			<p class="description">' . __( 'The city in listing address.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Country.
		echo '	<tr>';
		echo '		<th><label for="listing_country" class="listing_country_label">' . __( 'Country', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_country" name="listing_country" class="listing_country_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_country ) . '">';
		echo '			<p class="description">' . __( 'The country abbreviation in a postal address.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// County or Parish.
		echo '	<tr>';
		echo '		<th><label for="listing_county_or_parish" class="listing_county_or_parish_label">' . __( 'County or Parish', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_county_or_parish" name="listing_county_or_parish" class="listing_county_or_parish_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_county_or_parish ) . '">';
		echo '			<p class="description">' . __( 'The County, Parish or other regional authority', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Postal City
		echo '	<tr>';
		echo '		<th><label for="listing_postal_city" class="listing_postal_city_label">' . __( 'Postal City', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_postal_city" name="listing_postal_city" class="listing_postal_city_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_postal_city ) . '">';
		echo '			<p class="description">' . __( 'The official city per the USPS. May be different from the "City".', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Postal Code
		echo '	<tr>';
		echo '		<th><label for="listing_postal_code" class="listing_postal_code_label">' . __( 'Postal Code', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_postal_code" name="listing_postal_code" class="listing_postal_code_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_postal_code ) . '">';
		echo '			<p class="description">' . __( 'The postal code portion of a street or mailing address.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// PostalCode +4
		echo '	<tr>';
		echo '		<th><label for="listing_postalcode_plus4" class="listing_postalcode_plus4_label">' . __( 'Postal Code plus 4', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_postalcode_plus4" name="listing_postalcode_plus4" class="listing_postalcode_plus4_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_postalcode_plus4 ) . '">';
		echo '			<p class="description">' . __( 'The postal code +4 portion of a street or mailing address.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Listing State or Province.
		echo '	<tr>';
		echo '		<th><label for="listing_state_or_province" class="listing_state_or_province_label">' . __( 'State or Province', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_state_or_province" name="listing_state_or_province" class="listing_state_or_province_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_state_or_province ) . '">';
		echo '			<p class="description">' . __( 'Text field containing the accepted postal abbreviation for the state or province.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Listing Street Additional Info.
		echo '	<tr>';
		echo '		<th><label for="listing_street_additional_info" class="listing_street_additional_info_label">' . __( 'Street Additional Info', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="listing_street_additional_info" name="listing_street_additional_info" class="listing_street_additional_info_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_street_additional_info ) . '">';
		echo '			<p class="description">' . __( 'Information other than a prefix or suffix for the street portion of a postal address.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	/**
	 * save_metabox function.
	 *
	 * @access public
	 * @param mixed $post_id
	 * @param mixed $post
	 * @return void
	 */
	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['listing_nonce'] ) ? $_POST['listing_nonce'] : '';
		$nonce_action = 'listing_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$listing_new_carrier_route = isset( $_POST[ 'listing_carrier_route' ] ) ? sanitize_text_field( $_POST[ 'listing_carrier_route' ] ) : '';
		$listing_new_city = isset( $_POST[ 'listing_city' ] ) ? sanitize_text_field( $_POST[ 'listing_city' ] ) : '';
		$listing_new_country = isset( $_POST[ 'listing_country' ] ) ? sanitize_text_field( $_POST[ 'listing_country' ] ) : '';
		$listing_new_county_or_parish = isset( $_POST[ 'listing_county_or_parish' ] ) ? sanitize_text_field( $_POST[ 'listing_county_or_parish' ] ) : '';
		$listing_new_postal_city = isset( $_POST[ 'listing_postal_city' ] ) ? sanitize_text_field( $_POST[ 'listing_postal_city' ] ) : '';
		$listing_new_postal_code = isset( $_POST[ 'listing_postal_code' ] ) ? sanitize_text_field( $_POST[ 'listing_postal_code' ] ) : '';
		$listing_new_postalcode_plus4 = isset( $_POST[ 'listing_postalcode_plus4' ] ) ? sanitize_text_field( $_POST[ 'listing_postalcode_plus4' ] ) : '';
		$listing_new_state_or_province = isset( $_POST[ 'listing_state_or_province' ] ) ? sanitize_text_field( $_POST[ 'listing_state_or_province' ] ) : '';
		$listing_new_street_additional_info = isset( $_POST[ 'listing_street_additional_info' ] ) ? sanitize_text_field( $_POST[ 'listing_street_additional_info' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'listing_carrier_route', $listing_new_carrier_route );
		update_post_meta( $post_id, 'listing_city', $listing_new_city );
		update_post_meta( $post_id, 'listing_country', $listing_new_country );
		update_post_meta( $post_id, 'listing_county_or_parish', $listing_new_county_or_parish );
		update_post_meta( $post_id, 'listing_postal_city', $listing_new_postal_city );
		update_post_meta( $post_id, 'listing_postal_code', $listing_new_postal_code );
		update_post_meta( $post_id, 'listing_postalcode_plus4', $listing_new_postalcode_plus4 );
		update_post_meta( $post_id, 'listing_state_or_province', $listing_new_state_or_province );
		update_post_meta( $post_id, 'listing_street_additional_info', $listing_new_street_additional_info );

	}

}

new location_metabox;

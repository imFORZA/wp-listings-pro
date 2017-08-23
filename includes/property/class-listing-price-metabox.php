<?php

/**
 * listing_price_metabox class.
 */
class listing_price_metabox {

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
			'pricing',
			__( 'Pricing', 'wp-listings-pro' ),
			array( $this, 'price_metabox' ),
			'listing',
			'advanced',
			'default'
		);

	}

	/**
	 * price_metabox function.
	 *
	 * @access public
	 * @param mixed $post
	 * @return void
	 */
	public function price_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'listing_nonce_action', 'listing_nonce' );

		// TODO _listing_price -> listing_list_price
		// TODO _listing_sold_price -> listing_close_price
		// TODO listing_list_price Must be Greater or Equal to Low List Price
		// TODO _listing_rent_price -> listing_total_actual_rent
		// TODO Offer a easy UI to hide each field with alt text option, thinking maybe advanced section via jQuery?

		// Retrieve an existing value from the database.
		$listing_close_price = get_post_meta( $post->ID, 'listing_close_price', true );
		$listing_list_price = get_post_meta( $post->ID, 'listing_list_price', true );
		$listing_list_price_low = get_post_meta( $post->ID, 'listing_list_price_low', true );
		$listing_original_list_price = get_post_meta( $post->ID, 'listing_original_list_price', true );
		$listing_previous_list_price = get_post_meta( $post->ID, 'listing_previous_list_price', true );
		$listing_total_actual_rent = get_post_meta( $post->ID, 'listing_total_actual_rent ', true );

		// Set default values.
		if( empty( $listing_close_price ) ) $listing_close_price = '';
		if( empty( $listing_list_price ) ) $listing_list_price = '';
		if( empty( $listing_list_price_low ) ) $listing_list_price_low = '';
		if( empty( $listing_original_list_price ) ) $listing_original_list_price = '';
		if( empty( $listing_previous_list_price ) ) $listing_previous_list_price = '';
		if( empty( $listing_total_actual_rent ) ) $listing_total_actual_rent = '';

		// Form fields.
		echo '<table class="form-table">';

		// List Price.
		echo '	<tr>';
		echo '		<th><label for="listing_list_price" class="listing_list_price_label">' . __( 'List Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_list_price" name="listing_list_price" class="listing_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_list_price ) . '">';
		echo '			<p class="description">' . __( 'The current price of the property as determined by the seller and the seller\'s broker. For auctions this is the minimum or reserve price.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// List Low Price.
		echo '	<tr>';
		echo '		<th><label for="listing_list_price_low" class="listing_list_price_low_label">' . __( 'Low List Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_list_price_low" name="listing_list_price_low" class="listing_list_price_low_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_list_price_low ) . '">';
		echo '			<p class="description">' . __( 'The lower price used for Value Range Pricing. The List Price must be greater than or equal to the ListPriceLow.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Original List Price.
		echo '	<tr>';
		echo '		<th><label for="listing_original_list_price" class="listing_original_list_price_label">' . __( 'Original List Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_original_list_price" name="listing_original_list_price" class="listing_original_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_original_list_price ) . '">';
		echo '			<p class="description">' . __( 'The original price of the property on the initial agreement between the seller and the seller\'s broker.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Previous List Price.
		echo '	<tr>';
		echo '		<th><label for="listing_previous_list_price" class="listing_previous_list_price_label">' . __( 'Previous List Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_previous_list_price" name="listing_previous_list_price" class="listing_previous_list_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_previous_list_price ) . '">';
		echo '			<p class="description">' . __( 'The most recent previous ListPrice of the listing.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Close Price Field.
		echo '	<tr>';
		echo '		<th><label for="listing_close_price" class="listing_close_price_label">' . __( 'Closing Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_close_price" name="listing_close_price" class="listing_close_price_field" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_close_price ) . '">';
		echo '			<p class="description">' . __( 'The amount of money paid by the purchaser to the seller for the property under the agreement.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		// Total Actual Rent
		echo '	<tr>';
		echo '		<th><label for="listing_total_actual_rent" class="listing_total_actual_rent_label">' . __( 'Rental Price', 'wp-listings-pro' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" min="0" max="99999999999999" step="1" id="listing_total_actual_rent" name="listing_total_actual_rent" class="listing_total_actual_rent" placeholder="' . esc_attr__( '', 'wp-listings-pro' ) . '" value="' . esc_attr( $listing_close_price ) . '">';
		echo '			<p class="description">' . __( 'Total actual rent currently being collected from tenants of the income property.', 'wp-listings-pro' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';


		// Hide Price from Visitors?
		echo '<hr>';
		echo '<label><strong>' . __('Hide Price:','wp-listings-pro') . '</strong></label>';
	wp_nonce_field( 'wp-hide-price-action', 'wp-hide-price-name' );
		echo '<input type="checkbox" name="wp_listings[_listing_hide_price]" value="1" '. checked( get_post_meta( $post->ID, '_listing_hide_price', true ), 1, 0 ) .' />';
		echo '<p class="description">'. __( 'Hide the price from visitors?', 'wp-listings-pro') .'</p>';

		// Alt Text for Price.
		echo '<label><strong>' . __('Alternate Text to Display:','wp-listings-pro') . '</strong></label>';
		echo '<input type="text" placeholder="" name="wp_listings[_listing_price_alt]" value="'. htmlentities( get_post_meta( $post->ID, '_listing_price_alt', true ) ) .'" />';
		echo '<p class="description">'. __( 'Text to display instead of price (or leave blank)', 'wp-listings-pro') .'</p>';

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
		$listing_new_close_price = isset( $_POST[ 'listing_close_price' ] ) ? floatval( $_POST[ 'listing_close_price' ] ) : '';
		$listing_new_list_price = isset( $_POST[ 'listing_list_price' ] ) ? floatval( $_POST[ 'listing_list_price' ] ) : '';
		$listing_new_total_actual_rent = isset( $_POST[ 'listing_total_actual_rent' ] ) ? floatval( $_POST[ 'listing_total_actual_rent' ] ) : '';
		$listing_new_list_price_low = isset( $_POST[ 'listing_list_price_low' ] ) ? floatval( $_POST[ 'listing_list_price_low' ] ) : '';
		$listing_new_original_list_price = isset( $_POST[ 'listing_original_list_price' ] ) ? floatval( $_POST[ 'listing_original_list_price' ] ) : '';
		$listing_new_previous_list_price = isset( $_POST[ 'listing_previous_list_price' ] ) ? floatval( $_POST[ 'listing_previous_list_price' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'listing_close_price', $listing_new_close_price );
		update_post_meta( $post_id, 'listing_list_price', $listing_new_list_price );
		update_post_meta( $post_id, 'listing_list_price_low', $listing_new_list_price_low );
		update_post_meta( $post_id, 'listing_original_list_price', $listing_new_original_list_price );
		update_post_meta( $post_id, 'listing_previous_list_price', $listing_new_previous_list_price );
		update_post_meta( $post_id, 'listing_total_actual_rent', $listing_new_total_actual_rent );

	}

}

new listing_price_metabox;

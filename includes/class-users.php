<?php

// add_action( 'show_user_profile', 'wplpro_saved_property_field' );
// add_action( 'edit_user_profile', 'wplpro_saved_property_field' );
/**
 * Wplpro_saved_property_field function.
 *
 * @access public
 * @param mixed $user
 * @return void
 */
function wplpro_saved_property_field( $user ) {
	?>

	<h3>Saved Properties</h3>

	<table class="form-table">

		<tr>
			<th><label for="saved-properties">Saved Properties</label></th>

			<td>

				<?php echo wp_dropdown_pages( array( 'post_type' => 'listing' ) );

					$properties = get_posts( array( 'post_type' => 'listing', 'posts_per_page' => -1, 'suppress_filters' => true, 'post_status' => 'publish' ) );
					 // var_dump($properties);
					echo '<select multiple name="saved-properties" id="saved-properties" disabled="disabled">';
				foreach ( $properties as $property ) {
					echo '<option value="' . $property->ID . '">' . $property->post_title . '</option>';

				}
					echo '</select>';

						?>
					 <br />
				<span class="description">These are the selected properties you have saved.</span>
			</td>
		</tr>

	</table>
<?php }



// add_action( 'personal_options_update', 'wplpro_save_property_field' );
// add_action( 'edit_user_profile_update', 'wplpro_save_property_field' );
/**
 * wplpro_save_property_field function.
 *
 * @access public
 * @param mixed $user_id
 * @return void
 */
function wplpro_save_property_field( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	update_usermeta( $user_id, 'saved-properties', $_POST['saved-properties'] );
}

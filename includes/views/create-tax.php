<?php
/**
 * Page for creating generic taxonomy
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<h2><?php esc_html_e( 'Listing Taxonomies', 'wp-listings-pro' ); ?></h2>

<div id="col-container">

	<div id="col-right">
	<div class="col-wrap">

		<h3><?php esc_html_e( 'Current Listing Taxonomies', 'wp-listings-pro' ); ?></h3>
		<table class="widefat tag fixed" cellspacing="0">
			<thead>
			<tr>
			<th scope="col" class="manage-column column-slug"><?php esc_html_e( 'ID', 'wp-listings-pro' ); ?></th>
			<th scope="col" class="manage-column column-singular-name"><?php esc_html_e( 'Singular Name', 'wp-listings-pro' ); ?></th>
			<th scope="col" class="manage-column column-plural-name"><?php esc_html_e( 'Plural Name', 'wp-listings-pro' ); ?></th>
			</tr>
			</thead>

			<tfoot>
			<tr>
			<th scope="col" class="manage-column column-slug"><?php esc_html_e( 'ID', 'wp-listings-pro' ); ?></th>
			<th scope="col" class="manage-column column-singular-name"><?php esc_html_e( 'Singular Name', 'wp-listings-pro' ); ?></th>
			<th scope="col" class="manage-column column-plural-name"><?php esc_html_e( 'Plural Name', 'wp-listings-pro' ); ?></th>
			</tr>
			</tfoot>

			<tbody id="the-list" class="list:tag">

				<?php
				$alt = true;

				$listing_taxonomies = array_merge( $this->property_features_taxonomy(), $this->listing_status_taxonomy(), $this->property_type_taxonomy(), $this->listing_location_taxonomy(), get_option( $this->settings_field ) );

				foreach ( (array) $listing_taxonomies as $id => $data ) :
					?>

				<tr 
					<?php
					if ( $alt ) {
						echo 'class="alternate"';
						$alt = false;
					} else {
						$alt = true;
					}
					?>
				>
					<td class="slug column-slug">

					<?php if ( isset( $data['editable'] ) && 0 === $data['editable'] ) : ?>
						<?php echo '<strong>' . esc_html( $id ) . '</strong><br /><br />'; ?>
					<?php else : ?>
						<?php printf( '<a class="row-title" href="%s" title="Edit %s">%s</a>', admin_url( 'admin.php?page=' . $this->menu_page . '&amp;action=edit&amp;id=' . esc_html( $id ) ), esc_html( $id ), esc_html( $id ) ); ?>

						<br />

						<div class="row-actions">
							<span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->menu_page . '&amp;view=edit&amp;id=' . esc_html( $id ) ) ); ?>"><?php esc_html_e( 'Edit', 'wp-listings-pro' ); ?></a> | </span>
							<span class="delete"><a class="delete-tag" href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=' . $this->menu_page . '&amp;action=delete&amp;id=' . esc_html( $id ) ), 'wp_listings-action_delete-taxonomy' ); ?>"><?php esc_html_e( 'Delete', 'wp-listings-pro' ); ?></a></span>
						</div>
					<?php endif; ?>

					</td>
					<td class="singular-name column-singular-name"><?php echo esc_html( $data['labels']['singular_name'] ); ?></td>
					<td class="plural-name column-plural-name"><?php echo esc_html( $data['labels']['name'] ); ?></td>
				</tr>

				<?php endforeach; ?>

			</tbody>
		</table>

	</div>
	</div><!-- /col-right -->

	<div id="col-left">
	<div class="col-wrap">

		<div class="form-wrap">
			<h3><?php esc_html_e( 'Add New Listing Taxonomy', 'wp-listings-pro' ); ?></h3>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=register-taxonomies&amp;action=create' ) ); ?>">
			<?php wp_nonce_field( 'wp_listings-action_create-taxonomy', 'wp_listings-action_create-taxonomy' ); ?>

			<div class="form-field">
				<label for="taxonomy-id"><?php esc_html_e( 'ID', 'wp-listings-pro' ); ?></label>
				<input name="wp_listings_taxonomy[id]" id="taxonomy-id" type="text" value="" size="40" />
				<p><?php esc_html_e( 'The unique ID is used to register the taxonomy.', 'wp-listings-pro' ); ?><br /><?php esc_html_e( '(no spaces, underscores, or special characters)', 'wp-listings-pro' ); ?></p>
			</div>

			<div class="form-field form-required">
				<label for="taxonomy-name"><?php esc_html_e( 'Plural Name', 'wp-listings-pro' ); ?></label>
				<input name="wp_listings_taxonomy[name]" id="taxonomy-name" type="text" value="" size="40" />
				<p><?php esc_html_e( 'Example: "Property Types" or "Locations"', 'wp-listings-pro' ); ?></p>
			</div>

			<div class="form-field form-required">
				<label for="taxonomy-singular-name"><?php esc_html_e( 'Singular Name', 'wp-listings-pro' ); ?></label>
				<input name="wp_listings_taxonomy[singular_name]" id="taxonomy-singular-name" type="text" value="" size="40" />
				<p><?php esc_html_e( 'Example: "Property Type" or "Location"', 'wp-listings-pro' ); ?></p>
			</div>

			<?php submit_button( __( 'Add New Taxonomy', 'wp-listings-pro' ), 'secondary' ); ?>
			</form>
		</div>

	</div>
	</div><!-- /col-left -->

</div><!-- /col-container -->

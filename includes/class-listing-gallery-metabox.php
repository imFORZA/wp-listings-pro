<?php
/**
 * listing Images
 *
 * Display the listing images meta box.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Meta_Box_listing_Images Class.
 */
class WPLPRO_Meta_Box_listing_Images {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		?>
		<div id="listing_images_container">
			<ul class="listing_images">
				<?php
					if ( metadata_exists( 'post', $post->ID, '_listing_image_gallery' ) ) {
						$listing_image_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_wplpro_exclude_image&meta_value=0' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$listing_image_gallery = implode( ',', $attachment_ids );
					}

					$attachments         = array_filter( explode( ',', $listing_image_gallery ) );
					$update_meta         = false;
					$updated_gallery_ids = array();

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

							// if attachment is empty skip
							if ( empty( $attachment ) ) {
								$update_meta = true;
								continue;
							}

							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . $attachment . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'wp-listings-pro' ) . '">' . __( 'Delete', 'wp-listings-pro' ) . '</a></li>
								</ul>
							</li>';

							// rebuild ids to be saved
							$updated_gallery_ids[] = $attachment_id;
						}

						// need to update listing meta to set new gallery ids
						if ( $update_meta ) {
							update_post_meta( $post->ID, '_listing_image_gallery', implode( ',', $updated_gallery_ids ) );
						}
					}
				?>
			</ul>

			<input type="hidden" id="listing_image_gallery" name="listing_image_gallery" value="<?php echo esc_attr( $listing_image_gallery ); ?>" />

		</div>
		<p class="add_listing_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( 'Add images to listing gallery', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php _e( 'Add listing gallery images', 'wp-listings-pro' ); ?></a>
		</p>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {
		$attachment_ids = isset( $_POST['listing_image_gallery'] ) ? array_filter( explode( ',', wc_clean( $_POST['listing_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_listing_image_gallery', implode( ',', $attachment_ids ) );
	}
}

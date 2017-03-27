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
 * WPLPRO_Meta_Box_listing_Images Class.
 */
class WPLPRO_Meta_Box_Listing_Images {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post = null, $ok = null) {
		?>
		<div id="listing_images_container">

			<ul class="listing_images">
				<?php
					if ( metadata_exists( 'post', $post->ID, '_listing_image_gallery' ) ) {
						$listing_image_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
					} else {
						// Backwards compat
						$listing_image_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
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
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'wp-listings-pro' ) .
									'">' . __( 'Delete', 'wp-listings-pro' ) . '</a></li>
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
			<a href="#" data-choose="<?php esc_attr_e( 'Add images to listing gallery', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Adda to gallery', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php _e( 'Add listing gallery images', 'wp-listings-pro' ); ?></a>
		</p>

		<!-- This works -->
		<!-- <script src="/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js"></script> -->
		<!-- TODO: Turn it into a registered and then enqueued script with PROPER LINKING -->
		<?php
		wp_enqueue_script( 'class-listings', '/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js', array('jquery'), null, true );
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {

		error_log("in save");

		$attachment_ids = isset( $_POST['listing_image_gallery'] ) ? array_filter( explode( ',',  $_POST['listing_image_gallery'] ) ) : array();

		update_post_meta( $post_id, '_listing_image_gallery', implode( ',', $attachment_ids ) );
	}
}

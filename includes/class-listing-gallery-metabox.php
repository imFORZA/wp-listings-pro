<?php
/**
 * Listing Images
 *
 * Display the listing images meta box.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPLPROMetaBoxListing_Images Class.
 */
class WPLPROMetaBoxListing_Images {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post Post to be sent in.
	 */
	public static function output( $post = null ) {
		wplpro_admin_scripts_styles();
		wp_nonce_field( 'wplpro_image_gallery_metabox_save', 'wplpro_image_gallery_metabox_nonce' );
		?>
		<div id="listing_images_container">
			<ul class="listing_images">
				<?php
				if ( metadata_exists( 'post', $post->ID, '_listing_image_gallery' ) ) {
					$listing_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
				} else {
					// Backwards compatability.
					$listing_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
				}

				$attachments         = array_filter( explode( ',', $listing_gallery ) );
				$update_meta         = false;
				$updated_gallery_ids = array();

				if ( ! empty( $attachments ) ) {
					foreach ( $attachments as $attachment_id ) {
						$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
						// if attachment is empty skip.
						if ( empty( $attachment ) ) {
							$update_meta = true;
							continue;
						}
						// @codingStandardsIgnoreStart
						echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . $attachment . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'wp-listings-pro' ) .
								'">' . esc_attr__( 'Delete', 'wp-listings-pro' ) . '</a></li>
								</ul>
							</li>';
						// @codingStandardsIgnoreEnd

						// rebuild ids to be saved.
						$updated_gallery_ids[] = $attachment_id;
					}

					// need to update listing meta to set new gallery ids.
					if ( $update_meta ) {
						update_post_meta( $post->ID, '_listing_image_gallery', implode( ',', $updated_gallery_ids ) );
					}
				}
				?>
			</ul>

			<input type="hidden" id="listing_image_gallery" name="listing_image_gallery" value="<?php echo esc_attr( $listing_gallery ); ?>" />

		</div>
		<p class="add_listing_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( 'Add images to listing gallery', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php esc_attr_e( 'Add listing gallery images', 'wp-listings-pro' ); ?></a>
		</p>

		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int     $post_id  ID of post to save to.
	 * @param WP_Post $post         Post to attach to.
	 */
	public static function save( $post_id, $post ) {

		if ( ! isset( $_POST['wplpro_image_gallery_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['wplpro_image_gallery_metabox_nonce'], 'wplpro_image_gallery_metabox_save' ) ) {
			return $post_id;
		}

		$attachment_ids = isset( $_POST['listing_image_gallery'] ) ? array_filter( explode( ',', sanitize_text_field( $_POST['listing_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_listing_image_gallery', implode( ',', $attachment_ids ) );
		update_post_meta( $post_id, '_listing_gallery', static::backwards_compatibility_gallery( $attachment_ids ) );
	}

	/**
	 * Provides support for the way that wp-listings manages galleries.
	 *
	 * @param  array[post_ids] $ids        Array of IDs to be included in the gallery.
	 * @return string                               HTML block of images, following specifications of old wp-listings gallery.
	 */
	public static function backwards_compatibility_gallery( $ids ) {
		$s = '';
		foreach ( $ids as $image_id ) {
			$s .= '<p><img class="alignnone size-medium wp-image-' . $image_id . '" src="' . wp_get_attachment_url( $image_id ) . '" alt="" width="' . wp_get_attachment_image_src( $image_id )[1] . '" height="' . wp_get_attachment_image_src( $image_id )[2] . '" /></p>';
		}
		return $s;
	}
}

/**
 * WPLPROMetaBoxListing_Docs Class.
 */
class WPLPROMetaBoxListing_Docs {

		/**
		 * Output the metabox.
		 *
		 * @param WP_Post $post Given post.
		 */
	public static function output( $post = null ) {

			wp_nonce_field( 'wplpro_document_gallery_metabox_save', 'wplpro_document_gallery_metabox_nonce' );
		?>
			<div id="listing_docs_container">

				<ul class="listing_docs">
					<?php
					if ( metadata_exists( 'post', $post->ID, '_listing_doc_gallery' ) ) {
						$listing_doc_gallery = get_post_meta( $post->ID, '_listing_doc_gallery', true );
					} else {
						// Backwards compatability.
						$listing_doc_gallery = get_post_meta( $post->ID, '_listing_doc_gallery', true );
					}

					$attachments         = array_filter( explode( ',', $listing_doc_gallery ) );
					$update_meta         = false;
					$updated_gallery_ids = array();

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							$attachment_url      = wp_get_attachment_url( $attachment_id );
							$attachment_filetype = wp_check_filetype( $attachment_url )['ext']; // alternate is 'type', yeilds ie: "image/jpeg" instead of "jpg".

							if ( 'xls' === $attachment_filetype || 'xlsx' === $attachment_filetype ) { // Is spreadsheet.
								$image_thumbnail = site_url( '/wp-includes/images/media/spreadsheet.png' );
							} else { // Is doc/pdf.
								$image_thumbnail = site_url( '/wp-includes/images/media/document.png' );
							}

							$attachment = sprintf( '<img width="150" height="150" src="%s" class="attachment-thumbnail size-thumbnail" alt="" srcset="%s 150w, %s 100w" sizes="100vw" />', $image_thumbnail, $image_thumbnail, $image_thumbnail );

							// @codingStandardsIgnoreStart
							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
							' . $attachment .
							// @codingStandardsIgnoreEnd
							'<div class="filename"><div>' .
							get_the_title( $attachment_id ) . '.' . esc_attr( $attachment_filetype )
							. ' </div></div>

 								<ul class="actions">
 									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete doc', 'wp-listings-pro' ) .
									'">' . esc_attr__( 'Delete', 'wp-listings-pro' ) . '</a></li>
 								</ul>
 							</li>';

							// rebuild ids to be saved.
							$updated_gallery_ids[] = $attachment_id;
						}
					}
					?>
	</ul>


				<input type="hidden" id="listing_doc_gallery" name="listing_doc_gallery" value="<?php echo esc_attr( $listing_doc_gallery ); ?>" />

			</div>
			<p class="add_listing_docs hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( 'Add documents to listing', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to listing', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete document', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php esc_attr_e( 'Add listing documents', 'wp-listings-pro' ); ?></a>
			</p>
			<?php
	}

		/**
		 * Save meta box data.
		 *
		 * @param int     $post_id  ID of post.
		 * @param WP_Post $post         Given post.
		 */
	public static function save( $post_id, $post ) {

		if ( ! isset( $_POST['wplpro_image_gallery_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['wplpro_document_gallery_metabox_nonce'], 'wplpro_document_gallery_metabox_save' ) ) {
			return $post_id;
		}

		$attachment_ids = isset( $_POST['listing_doc_gallery'] ) ? array_filter( explode( ',', sanitize_text_field( $_POST['listing_doc_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_listing_doc_gallery', implode( ',', $attachment_ids ) );
	}
}

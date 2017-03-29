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
 * WPLPRO_Meta_Box_Listing_Images Class.
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
			<a href="#" data-choose="<?php esc_attr_e( 'Add images to listing gallery', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php _e( 'Add listing gallery images', 'wp-listings-pro' ); ?></a>
		</p>

		<!-- This works -->
		<!-- <script src="/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js"></script> -->
		<!-- TODO: Turn it into a registered and then enqueued script with PROPER LINKING -->
		<?php
		wp_enqueue_script( 'class-listings', '/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js', array('jquery'), null, true );
		// TODO: move enquement of it
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {

		$attachment_ids = isset( $_POST['listing_image_gallery'] ) ? array_filter( explode( ',',  $_POST['listing_image_gallery'] ) ) : array();

		update_post_meta( $post_id, '_listing_image_gallery', implode( ',', $attachment_ids ) );
	}
}

// class WPLPRO_Meta_Box_Listing_Videos {
//
// 	/**
// 	 * Output the metabox.
// 	 *
// 	 * @param WP_Post $post
// 	 */
// 	public static function output( $post = null, $ok = null) {
// 					? >
//<!--  		<div id="listing_videos_container">
//
// 			<ul class="listing_videos"> -->
// 					< ?php
// 					error_log(get_post_meta( $post->ID, '_listing_video_gallery', true));
// 					if ( metadata_exists( 'post', $post->ID, '_listing_video_gallery' ) ) {
// 						$listing_video_gallery = get_post_meta( $post->ID, '_listing_video_gallery', true );
// 					} else {
// 						// Backwards compat
// 						$listing_video_gallery = get_post_meta( $post->ID, '_listing_video_gallery', true );
// 					}
//
//
// 					$attachments         = array_filter( explode( ',', $listing_video_gallery ) );
// 					$update_meta         = false;
// 					$updated_gallery_ids = array();
//
// 					error_log("though not very fast");
// 					if ( ! empty( $attachments ) ) {
// 						error_log("eventually");
// 						foreach ( $attachments as $attachment_id ) {
// 							error_log("we're getting data: " . $attachment_id);
// 							$attachment = wp_get_attachment_image( $attachment_id );
//
// 							// if attachment is empty skip
// 							// if ( empty( $attachment ) ) {
// 							// 	$update_meta = true;
// 							// 	continue;
// 							// }
// 							error_log("or not");
//
// 							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
// 								' . get_the_title($attachment_id) . /*$attachment*/'
// 								<ul class="actions">
// 									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete video', 'wp-listings-pro' ) .
// 									'">' . __( 'Delete', 'wp-listings-pro' ) . '</a></li>
// 								</ul>
// 							</li>';
//
// 							// rebuild ids to be saved
// 							$updated_gallery_ids[] = $attachment_id;
// 							error_log("here");
// 						}
//
// 						// need to update listing meta to set new gallery ids
// 						// WAIT DO WE?!
// 						// if ( $update_meta ) {
// 						// 	update_post_meta( $post->ID, '_listing_video_gallery', implode( ',', $updated_gallery_ids ) );
// 						// }
//
// 					}
// 				? >
// <!-- // 			</ul>
//
//  			<input type="hidden" id="listing_video_gallery" name="listing_video_gallery" value="<?php// echo esc_attr( $listing_video_gallery ); ? >" />
//
//  		</div>
//  		<p class="add_listing_videos hide-if-no-js">
		// <a href="#" data-choose="< ?php //esc_attr_e( 'Add videos to listing gallery', 'wp-listings-pro' ); ? >" data-update="< ?php //esc_attr_e( 'Add to gallery', 'wp-listings-pro' ); ? >" data-delete="< ?php //esc_attr_e( 'Delete video', 'wp-listings-pro' ); ? >" data-text="< ?php //esc_attr_e( 'Delete', 'wp-listings-pro' ); ? >">< ?php //_e( 'Add listing gallery videos', 'wp-listings-pro' ); ? ></a>
		// </p>
  // -->
	// 	<!-- This works -->
 // 		<!-- <script src="/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js"></script> -->
 // 		<!-- TODO: Turn it into a registered and then enqueued script with PROPER LINKING -->
 // 		< ? 	php
// 		wp_enqueue_script( 'class-listings', '/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js', array('jquery'), null, true );
// 	}
//
// 	/**
// 	 * Save meta box data.
// 	 *
// 	 * @param int $post_id
// 	 * @param WP_Post $post
// 	 */
// 	public static function save( $post_id, $post ) {
//
// 		error_log($post_id);
//
// 		error_log($_POST['listing_video_gallery']);
//
// 		$attachment_ids = isset( $_POST['listing_video_gallery'] ) ? array_filter( explode( ',',  $_POST['listing_video_gallery'] ) ) : array();
//
// 		update_post_meta( $post_id, '_listing_video_gallery', implode( ',', $attachment_ids ) );
// 	}
// }
//
//

/**
 * WPLPRO_Meta_Box_Listing_Docs Class.
 */
 class WPLPRO_Meta_Box_Listing_Docs {

 	/**
 	 * Output the metabox.
 	 *
 	 * @param WP_Post $post
 	 */
 	public static function output( $post = null, $ok = null) {
 					?>
 		<div id="listing_docs_container">

 			<ul class="listing_docs">
 					<?php
 					if ( metadata_exists( 'post', $post->ID, '_listing_doc_gallery' ) ) {
 						$listing_doc_gallery = get_post_meta( $post->ID, '_listing_doc_gallery', true );
 					} else {
 						// Backwards compat
 						$listing_doc_gallery = get_post_meta( $post->ID, '_listing_doc_gallery', true );
 					}


 					$attachments         = array_filter( explode( ',', $listing_doc_gallery ) );
 					$update_meta         = false;
 					$updated_gallery_ids = array();

 					if ( ! empty( $attachments ) ) {
 						foreach ( $attachments as $attachment_id ) {
							$attachment_url = wp_get_attachment_url( $attachment_id );
							$attachment_filetype = wp_check_filetype( $attachment_url )['ext']; // alternate is 'type', yeilds ie: "image/jpeg" instead of "jpg"

							if($attachment_filetype == "xls" || $attachment_filetype == "xlsx"){ // spreadsheet
								$image_thumbnail = site_url("/wp-includes/images/media/spreadsheet.png");
							}else{ // doc/pdf
								$image_thumbnail = site_url("/wp-includes/images/media/document.png");
							}

							$attachment = sprintf('<img width="150" height="150" src="%s" class="attachment-thumbnail size-thumbnail" alt="" srcset="%s 150w, %s 100w" sizes="100vw" />', $image_thumbnail, $image_thumbnail, $image_thumbnail);

 							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
							' .  $attachment . '
							<div class="filename"><div>' .
								get_the_title($attachment_id) . '.' . $attachment_filetype
							. ' </div></div>

 								<ul class="actions">
 									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete doc', 'wp-listings-pro' ) .
 									'">' . __( 'Delete', 'wp-listings-pro' ) . '</a></li>
 								</ul>
 							</li>';

 							// rebuild ids to be saved
 							$updated_gallery_ids[] = $attachment_id;
 						}

 						// need to update listing meta to set new gallery ids
 						// WAIT DO WE?!
 						// if ( $update_meta ) {
 						// 	update_post_meta( $post->ID, '_listing_doc_gallery', implode( ',', $updated_gallery_ids ) );
 						// }

 					}
 				?>
	</ul>

  			<input type="hidden" id="listing_doc_gallery" name="listing_doc_gallery" value="<?php echo esc_attr( $listing_doc_gallery ); ?>" />

  		</div>
  		<p class="add_listing_docs hide-if-no-js">
 		<a href="#" data-choose="<?php esc_attr_e( 'Add documents to listing', 'wp-listings-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to listing', 'wp-listings-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete document', 'wp-listings-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'wp-listings-pro' ); ?>"><?php _e( 'Add listing documents', 'wp-listings-pro' ); ?></a>
 		</p>
 		<!-- This works -->
  		<!-- <script src="/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js"></script> -->
  		<!-- TODO: Turn it into a registered and then enqueued script with PROPER LINKING -->
  		<?php
 		//wp_enqueue_script( 'class-listings', '/wp-content/plugins/wp-listings-pro/assets/js/media-gallery.js', array('jquery'), null, true );
 	}

 	/**
 	 * Save meta box data.
 	 *
 	 * @param int $post_id
 	 * @param WP_Post $post
 	 */
 	public static function save( $post_id, $post ) {

 		$attachment_ids = isset( $_POST['listing_doc_gallery'] ) ? array_filter( explode( ',',  $_POST['listing_doc_gallery'] ) ) : array();

 		update_post_meta( $post_id, '_listing_doc_gallery', implode( ',', $attachment_ids ) );
 	}
 }

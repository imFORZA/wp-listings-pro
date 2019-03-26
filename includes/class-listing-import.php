<?php
/**
 * This file contains the methods for interacting with the IDX API
 * to import listing data.
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * WPLPROIdxListing class.
 */
class WPLPROIdxListing {

	/**
	 * _idx
	 *
	 * @var mixed
	 * @access public
	 */
	public $_idx;

	private $photos_import;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Function to get the array key (listingID+mlsID)
	 *
	 * @param  [type] $array  [description].
	 * @param  [type] $key    [description].
	 * @param  [type] $needle [description].
	 * @return [type]         [description].
	 */
	public static function get_key( $array, $key, $needle ) {
		if ( ! $array ) {
			return false;
		}
		foreach ( $array as $index => $value ) {
			if ( $value[ $key ] === $needle ) {
				return $index;
			}
		}
		return false;
	}

	/**
	 * Function to find the key in the array
	 *
	 * @param  [type]  $needle   [description].
	 * @param  [type]  $haystack [description].
	 * @param  boolean $strict   [description].
	 * @return [type]            [description].
	 */
	public static function in_array( $needle, $haystack, $strict = false ) {
		if ( ! $haystack ) {
			return false;
		}
		foreach ( $haystack as $item ) {
			if ( ( $strict ? $item === $needle : $item === $needle ) || ( is_array( $item ) && self::in_array( $needle, $item, $strict ) ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Creates a post of listing type using post data from options page.
	 *
	 * @param  array $listings listingID of the property. Contains each property that has a check on it.
	 * @return [type] $featured Featured.
	 */
	public static function wp_listings_idx_create_post( $listings ) {
		// Load IDX Broker API Class and retrieve featured properties.
		$_idx_api   = new WPLPRO_Idx_Api();
		$properties = $_idx_api->client_properties( 'featured?disclaimers=true' );

		// Load WP options.
		$maybe_feat_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
		$idx_feat_options = ( !is_array( $maybe_feat_options ) ) ? array() : $maybe_feat_options; // Set to array if empty for some reason.

		$wpl_options      = get_option( 'wplpro_plugin_settings' );
		update_option( 'wp_listings_import_progress', true );

		if ( is_array( $listings ) && is_array( $properties ) ) {

			// Loop through featured properties.
			$listings_queue = new WPLPROBackgroundListings();
			$item           = array();

			foreach ( $properties as $prop ) {
				// this is too dangerous of a command
				// Get the listing ID.
				$key = self::get_key( $properties, 'listingID', $prop['listingID'] );
				$listing_id = $prop['listingID'];

				// Add options.
				if ( ! in_array( $listing_id, $listings, true ) ) {
					$idx_feat_options[ $listing_id ]['listingID'] = $listing_id;
					$idx_feat_options[ $listing_id ]['status']    = '';
				}

				// Unset options if they don't exist.
				if ( isset( $idx_feat_options[ $listing_id ]['post_id'] ) && ! get_post( $idx_feat_options[ $listing_id ]['post_id'] ) ) {
					unset( $idx_feat_options[ $listing_id ]['post_id'] );
					unset( $idx_feat_options[ $listing_id ]['status'] );
				}

				// Add post and update post meta.
				if ( in_array( $listing_id, $listings, true ) && ! isset( $idx_feat_options[ $listing_id ]['post_id'] ) ) {

					if ( '' === $properties[ $key ]['address'] || null === $properties[ $key ]['address'] ) {
						$properties[ $key ]['address'] = 'Address unlisted';
					}
					if ( '' === $properties[ $key ]['remarksConcat'] || null === $properties[ $key ]['remarksConcat'] ) {
						$properties[ $key ]['remarksConcat'] = $properties[ $key ]['listingID'];
					}

					// Post creation options.
					$opts = array(
						'post_content' => $properties[ $key ]['remarksConcat'],
						'post_title'   => $properties[ $key ]['address'],
						'post_status'  => 'publish',
						'post_type'    => 'listing',
						'post_author'  => ( isset( $wpl_options['import_author'] ) ) ? $wpl_options['import_author'] : 1,
					);

					$item['opts']     = $opts;
					$item['prop']     = $prop;
					$item['key']      = $key;
					$item['property'] = $properties[ $key ];

					// Background processing.
					$listings_queue->push_to_queue( $item );
					update_option( 'wplpro_idx_featured_listing_wp_options', $idx_feat_options );

				} // End if().
				// Change status to publish if it's not already.
				elseif ( in_array( $listing_id, $listings, true ) && 'publish' !== $idx_feat_options[ $listing_id ]['status'] ) {
					self::wp_listings_idx_change_post_status( $idx_feat_options[ $listing_id ]['post_id'], 'publish' );
					$idx_feat_options[ $listing_id ]['status'] = 'publish';

				} // Change post status or delete post based on options.
				elseif ( ! in_array( $listing_id, $listings, true ) && isset( $idx_feat_options[ $listing_id ]['status'] ) && 'publish' === $idx_feat_options[ $listing_id ]['status'] ) {

					// Change to draft or delete listing if the post exists but is not in the listing array based on settings.
					if ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-draft' === $wpl_options['wplpro_idx_sold'] ) {

						// Change to draft.
						self::wp_listings_idx_change_post_status( $idx_feat_options[ $listing_id ]['post_id'], 'draft' );
						$idx_feat_options[ $listing_id ]['status'] = 'draft';
					} elseif ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-delete' === $wpl_options['wplpro_idx_sold'] ) {

						$idx_feat_options[ $listing_id ]['status'] = 'deleted';

						// Delete featured image.
						$post_feat_id = get_post_thumbnail_id( $idx_feat_options[ $listing_id ]['post_id'] );
						wp_delete_attachment( $post_feat_id );

						// Delete post.
						wp_delete_post( $idx_feat_options[ $listing_id ]['post_id'] );
					}
				}
			} // End foreach().
			$listings_queue->save()->dispatch();
		} // End if().
		// Lastly update our options.
		update_option( 'wplpro_idx_featured_listing_wp_options', $idx_feat_options );
		delete_option( 'wp_listings_import_progress' );
		return 'success';
	}

	/**
	 * Update existing post.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function wp_listings_update_post() {
		require_once ABSPATH . 'wp-content/plugins/idx-broker-platinum/idx/idx-api.php';

		// Load IDX Broker API Class and retrieve featured properties.
		$_idx_api   = new WPLPRO_Idx_Api();
		$properties = $_idx_api->client_properties( 'featured?disclaimers=true' );

		// Load WP options.
		$idx_feat_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
		$wpl_options      = get_option( 'wplpro_plugin_settings' );

		foreach ( $properties as $prop ) {
			$key = self::get_key( $properties, 'listingID', $prop['listingID'] );

			if ( isset( $idx_feat_options[ $prop['listingID'] ]['post_id'] ) ) {
				// Update property data.
				$global_setting;
				if ( isset( $wpl_options['wplpro_idx_update'] ) ) {
					$global_setting = $wpl_options['wplpro_idx_update'];
				} else {
					$global_setting = 'update-all';
				}

				$post_id = $idx_feat_options[ $prop['listingID'] ]['post_id'];

				$sync_setting = get_post_meta( $post_id, '_listing_sync_update', true );
				if ( 'update-useglobal' === $sync_setting || null === $sync_setting ) {
					$sync_setting = $global_setting;
				}

				$listing_setting = get_post_meta( $post_id, '_listing_sync_update', true );
				if ( ! isset( $sync_setting ) || isset( $sync_setting ) && 'update-none' !== $sync_setting ) {
					$update_image;
					$update_gallery;
					$update_details;
					if ( 'update-useglobal' === $listing_setting && 'update-custom' === $global_setting ) {
						if ( isset( $wpl_options['wplpro_custom_sync_featured'] ) ) {
							$update_image = $wpl_options['wplpro_custom_sync_featured'];
						} else {
							$update_image = 0;
						}

						if ( isset( $wpl_options['wplpro_custom_sync_gallery'] ) ) {
							$update_gallery = $wpl_options['wplpro_custom_sync_gallery'];
						} else {
							$update_gallery = 0;
						}

						if ( isset( $wpl_options['wplpro_custom_sync_details'] ) ) {
							$update_details = $wpl_options['wplpro_custom_sync_details'];
						} else {
							$update_details = 0;
						}
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true, $update_image, false, $update_details, $update_gallery );
					} elseif ( 'update-custom' === $listing_setting ) {
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true, get_post_meta( $post_id, '_listing_custom_sync_featured', true ), false, get_post_meta( $post_id, '_listing_custom_sync_details', true ), get_post_meta( $post_id, '_listing_custom_sync_gallery', true ) );
					} else {
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true, true, false, true, true );
					}
				}
				$idx_feat_options[ $prop['listingID'] ]['updated'] = date( 'm/d/Y h:i:sa' );
			} // End if().
		} // End foreach().

		// Load and loop through Sold properties.
		$sold_properties = $_idx_api->client_properties( 'soldpending' );
		foreach ( $sold_properties as $sold_prop ) {

			$key = self::get_key( $sold_properties, 'listingID', $sold_prop['listingID'] );

			if ( isset( $idx_feat_options[ $sold_prop['listingID'] ]['post_id'] ) ) {

				// Update property data.
				self::wp_listings_idx_insert_post_meta( $idx_feat_options[ $sold_prop['listingID'] ]['post_id'], $sold_properties[ $key ], true, ( 'update-noimage' === $wpl_options['wplpro_idx_update'] ) ? false : true, true );

				if ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-draft' === $wpl_options['wplpro_idx_sold'] ) {

					// Change to draft.
					self::wp_listings_idx_change_post_status( $idx_feat_options[ $sold_prop['listingID'] ]['post_id'], 'draft' );
				} elseif ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-delete' === $wpl_options['wplpro_idx_sold'] ) {

					// Delete featured image.
					$post_feat_id = get_post_thumbnail_id( $idx_feat_options[ $sold_prop['listingID'] ]['post_id'] );
					wp_delete_attachment( $post_feat_id );

					// Delete post.
					wp_delete_post( $idx_feat_options[ $sold_prop['listingID'] ]['post_id'] );
				}
			}
		}
		update_option( 'wplpro_idx_featured_listing_wp_options', $idx_feat_options );

	}

	/**
	 * Change post status.
	 *
	 * @access public
	 * @static
	 * @param mixed $post_id Post ID.
	 * @param mixed $status Status.
	 * @return void
	 */
	public static function wp_listings_idx_change_post_status( $post_id, $status ) {
		$current_post                = get_post( $post_id, 'ARRAY_A' );
		$current_post['post_status'] = $status;
		wp_update_post( $current_post );
	}


	/**
	 * Inserts post meta based on property data.
	 * API fields are mapped to post meta fields.
	 * prefixed with _listing_ and lowercased.
	 *
	 * @access public
	 * @static
	 * @param mixed $id ID.
	 * @param mixed $idx_featured_listing_data          IDX Featured Listing Data.
	 * @param bool  $update (default: false)                Whether this instance of insert media is being performed on an update.
	 * @param bool  $update_image (default: true)   Whether to update the listing image.
	 * @param bool  $sold (default: false)                  Sold.
	 * @param bool  $update_details (default: true) Whether to update the details of a listing.
	 * @param bool  $update_gallery (default: true) Whether to update the image gallery of a listing.
	 * @return void
	 */
	public static function wp_listings_idx_insert_post_meta( $id, $idx_featured_listing_data, $update = false, $update_image = true, $sold = false, $update_details = true, $update_gallery = true ) {
		if ( ( false === $update || true === $update_image ) && isset( $idx_featured_listing_data['image']['0']['url'] ) ) {
			$imgs           = '';
			$featured_image = $idx_featured_listing_data['image']['0']['url'];

			foreach ( $idx_featured_listing_data['image'] as $image_data => $img ) {
				if ( 'totalCount' === $image_data ) {
					continue;
				}
				$img_markup = sprintf( '<img src="%s" alt="%s" />', $img['url'], $idx_featured_listing_data['address'] );
				$imgs      .= apply_filters( 'wp_listings_imported_image_markup', $img_markup, $img, $idx_featured_listing_data );
			}
		} elseif ( isset( $idx_featured_listing_data['image']['0']['url'] ) ) {
			$featured_image = $idx_featured_listing_data['image']['0']['url'];
		}

		if ( true === $sold ) {
			$propstatus = ucfirst( $idx_featured_listing_data['archiveStatus'] );
		} else {
			if ( 'A' === $idx_featured_listing_data['propStatus'] ) {
				$propstatus = 'Active';
			} elseif ( 'S' === $idx_featured_listing_data['propStatus'] ) {
				$propstatus = 'Sold';
			} else {
				$propstatus = ucfirst( $idx_featured_listing_data['propStatus'] );
			}
		}
		if ( false === $update || true === $update_details ) {
			// Add or reset taxonomies for property-types, locations, and status.
			wp_set_object_terms( $id, $idx_featured_listing_data['idxPropType'], 'property-types', true );
			wp_set_object_terms( $id, $idx_featured_listing_data['cityName'], 'locations', true );
			wp_set_object_terms( $id, $propstatus, 'status', true );

			// Add post meta for existing WPL fields.
			update_post_meta( $id, '_listing_lot_sqft', isset( $idx_featured_listing_data['acres'] ) ? $idx_featured_listing_data['acres'] . ' acres' : '' );
			update_post_meta( $id, '_listing_price', isset( $idx_featured_listing_data['listingPrice'] ) ? $idx_featured_listing_data['listingPrice'] : '' );
			update_post_meta( $id, '_listing_hidden_price', wplpro_strip_price( isset( $idx_featured_listing_data['listingPrice'] ) ? $idx_featured_listing_data['listingPrice'] : '' ) );
			update_post_meta( $id, '_listing_address', isset( $idx_featured_listing_data['address'] ) ? $idx_featured_listing_data['address'] : '' );
			update_post_meta( $id, '_listing_city', isset( $idx_featured_listing_data['cityName'] ) ? $idx_featured_listing_data['cityName'] : '' );
			update_post_meta( $id, '_listing_county', isset( $idx_featured_listing_data['countyName'] ) ? $idx_featured_listing_data['countyName'] : '' );
			update_post_meta( $id, '_listing_state', isset( $idx_featured_listing_data['state'] ) ? $idx_featured_listing_data['state'] : '' );
			update_post_meta( $id, '_listing_zip', isset( $idx_featured_listing_data['zipcode'] ) ? $idx_featured_listing_data['zipcode'] : '' );
			update_post_meta( $id, '_listing_mls', isset( $idx_featured_listing_data['listingID'] ) ? $idx_featured_listing_data['listingID'] : '' );
			update_post_meta( $id, '_listing_sqft', isset( $idx_featured_listing_data['sqFt'] ) ? $idx_featured_listing_data['sqFt'] : '' );
			update_post_meta( $id, '_listing_year_built', isset( $idx_featured_listing_data['yearBuilt'] ) ? $idx_featured_listing_data['yearBuilt'] : '' );
			update_post_meta( $id, '_listing_bedrooms', isset( $idx_featured_listing_data['bedrooms'] ) ? $idx_featured_listing_data['bedrooms'] : '' );
			update_post_meta( $id, '_listing_bathrooms', isset( $idx_featured_listing_data['totalBaths'] ) ? $idx_featured_listing_data['totalBaths'] : '' );
			update_post_meta( $id, '_listing_half_bath', isset( $idx_featured_listing_data['partialBaths'] ) ? $idx_featured_listing_data['partialBaths'] : '' );
		}

		//TODO: Remove previous gallery images.
		// Inserts image tags into Old Listing Gallery Box.
		if ( $update_gallery ) {
			// Start background process for photo import.
			$photos_import = new WPLPROBackgroundPhotos();

			// Reset thumbnail.
			$feat_id = get_post_thumbnail_id( $id );
			self::delete_attch($id, array( $feat_id ) );

			// Possible timeout here?
			for ( $i = 0; $i < $idx_featured_listing_data['image']['totalCount']; $i++ ) {
				update_post_meta( $id, '_listing_image_gallery', '' );
				$image_url            = $idx_featured_listing_data['image'][ $i ];
				$image = array(
					'listing_id' => $id,
					'url'         => $image_url['url'],
					'name'        => $idx_featured_listing_data['address'] . '-' . $i . '.jpg',
					'title'       => $idx_featured_listing_data['address'] . '-' . $i,
					'content'     => '',
					'description' => '',
				);
				$photos_import->push_to_queue( $image );
			}

			$photos_import->save()->dispatch();
		}

		/**
		 * Pull featured image if it's not an update or update image is set to true.
		 */
		if ( false === $update || true === $update_image ) {
			// Delete previously attached image.
			if ( true === $update_image ) {
				$post_feat_id = get_post_thumbnail_id( $id );
				wp_delete_attachment( $post_feat_id );
			}

			// Add Featured Image to Post.
			if ( isset( $featured_image ) && '' !== $featured_image ) {
				$image_url  = $featured_image; // Define the image URL here.
				$upload_dir = wp_upload_dir(); // Set upload folder.

				$image_data = file_get_contents( $image_url ); // Get image data.
				$filename   = basename( $image_url . '/' . $idx_featured_listing_data['listingID'] . '.jpg' ); // Create image file name.

				// Check folder permission and define file location.
				if ( wp_mkdir_p( $upload_dir['path'] ) ) {
					$file = $upload_dir['path'] . '/' . $filename;
				} else {
					$file = $upload_dir['basedir'] . '/' . $filename;
				}

				// Create the image file on the server.
				if ( ! file_exists( $file ) ) {
					file_put_contents( $file, $image_data );
				}

				// Check image file type.
				$wp_filetype = wp_check_filetype( $filename, null );

				// Set attachment data.
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => $idx_featured_listing_data['listingID'] . ' - ' . $idx_featured_listing_data['address'],
					'post_content'   => '',
					'post_status'    => 'inherit',
				);

				// Create the attachment.
				$attach_id = wp_insert_attachment( $attachment, $file, $id );

				// Include image.php.
				require_once ABSPATH . 'wp-admin/includes/image.php';

				// Define attachment metadata.
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

				// Assign metadata to attachment.
				wp_update_attachment_metadata( $attach_id, $attach_data );

				// Assign featured image to post.
				set_post_thumbnail( $id, $attach_id );
			} // End if().
		} // End if().
	}

	public static function get_image_attchs( $post ) {
		$args = array(
			'post_type'       => 'attachment',
			'post_status'     => 'inherit',
			'post_mime_type'  => 'image',
			'posts_per_page'  => -1,
			'post_parent' => $post,
			'fields'          => 'ids',
		);
		$the_query = new WP_Query( $args );

		return $the_query->get_posts();
	}

	public static function delete_attch( $post, $excludes = array() ) {
	  $attachments = static::get_image_attchs( $post );
	  $attachments = array_diff($attachments, $excludes);
	  foreach ( $attachments as $image ) {
	  	wp_delete_post( $image, true );
	  }
  }

}

/**
 * Here is where my background processing stuff goes
 */
require_once plugin_dir_path( __FILE__ ) . 'wp-background-processing/wp-background-processing.php';

/**
 * Class for handling background importing of listings.
 */
class WPLPROBackgroundListings extends WP_Background_Process {

	/**
	 * Protected ID that is single title (for working with super::)
	 *
	 * @var protected 'background-processing-listings'
	 */
	protected $action = 'background-processing-listings';

	/**
	 * Task to be run each iteration
	 *
	 * @param  string $data     Information of listing to be imported.
	 * @return mixed                False if done, $data if to be re-run.
	 */
	protected function task( $data ) {

		// Get important data.
		$idx_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
		$property    = $data['property'];
		$prop        = $data['prop'];
		$key         = $data['key'];

		// Add the post (after checking to make sure it's not already there).
		$stuff = get_posts(
			array(
				'post_type' => 'listing',
			)
		);
		foreach ( $stuff as $p ) {
			if ( get_post_meta( $p->ID, '_listing_mls', true ) === $property['listingID'] ) {
				return false;
			}
		}
		$add_post = wp_insert_post( $data['opts'], true );

		// Show error if wp_insert_post fails.
		// add post meta and update options if success.
		if ( is_wp_error( $add_post ) ) {
			$error_string = $add_post->get_error_message();
			add_settings_error( 'wp_listings_idx_listing_settings_group', 'insert_post_failed', 'WordPress failed to insert the post. Error ' . $error_string, 'error' );
		} elseif ( $add_post ) {
			$idx_options[ $prop['listingID'] ]['post_id'] = $add_post;
			$idx_options[ $prop['listingID'] ]['status']  = 'publish';
			update_post_meta( $add_post, '_listing_details_url', $property['fullDetailsURL'] );

			update_option( 'wplpro_idx_featured_listing_wp_options', $idx_options );

			// Insert meta for post.
			WPLPROIdxListing::wp_listings_idx_insert_post_meta( $add_post, $property );
		}
		return false;
	}
}

/**
 * Class for handling background importing of listing photos.
 */
class WPLPROBackgroundPhotos extends WP_Background_Process {

	/**
	 * Protected ID that is single title (for working with super::)
	 *
	 * @var protected 'background-processing-listings'
	 */
	protected $action = 'background-processing-photos';

	/**
	 * Task to be run each iteration
	 *
	 * @param  string $data     Information of listing to be imported.
	 * @return mixed                False if done, $data if to be re-run.
	 */
	protected function task( $image ) {

		// Get gallery meta in order to append new images.
		$gallery = get_post_meta( $image['listing_id'], '_listing_image_gallery', true );
		$gallery_arr = ( empty( $gallery ) ) ? array() : explode( ',', $gallery );

		// Insert image.
		$id = wplpro_upload_image( $image, $image['listing_id'] );
		$gallery_arr[] = $id;
		$gallery = implode( ',', $gallery_arr );

		update_post_meta( $image['listing_id'], '_listing_image_gallery', $gallery );

		return false;
	}
}

add_action( 'admin_menu', 'wp_listings_idx_listing_register_menu_page' );
/**
 * Wp_listings_idx_listing_register_menu_page function.
 *
 * @access public
 * @return void
 */
function wp_listings_idx_listing_register_menu_page() {
	add_submenu_page( 'edit.php?post_type=listing', __( 'IDX Broker Import', 'wp-listings-pro' ), __( 'IDX Broker Import', 'wp-listings-pro' ), 'manage_options', 'wplistings-idx-listing', 'wp_listings_idx_listing_setting_page' );
}

add_action( 'admin_enqueue_scripts', 'wp_listings_idx_listing_scripts' );
/**
 * Wp_listings_idx_listing_scripts function.
 *
 * @access public
 * @return void
 */
function wp_listings_idx_listing_scripts() {
	$screen = get_current_screen();
	if ( 'listing_page_wplistings-idx-listing' !== $screen->id ) {
		return;
	}

	wp_localize_script( 'wp_listings_idx_listing_delete_script', 'DeleteListingAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_localize_script( 'wp_listings_idx_listing_delete_script', 'DeleteAllListingAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_style( 'wp_listings_idx_listing_style', WPLPRO_URL . 'assets/css/wplpro-import.min.css' );
}
add_action( 'wp_ajax_wp_listings_idx_listing_delete', 'wp_listings_idx_listing_delete' );


/**
 * Wp_listings_idx_listing_delete function.
 *
 * @access public
 * @param string $given_id ID of listing to delete.
 * @return string 'success'.
 */
function wp_listings_idx_listing_delete( $given_id ) {
	// Delete featured image.
	$post_feat_id = get_post_thumbnail_id( $given_id );
	wp_delete_attachment( $post_feat_id );

	// Delete images.
	$ids = get_attached_media( 'image/jpeg', $given_id );
	foreach ( $ids as $id ) {
		wp_delete_attachment( $id->ID );
	}
	delete_post_meta( $given_id, '_listing_image_gallery' );

	// Delete post.
	wp_delete_post( $given_id );
	return 'success';
}

add_action( 'wp_ajax_wp_listings_idx_listing_delete_all', 'wp_listings_idx_listing_delete_all' );


/**
 * Wp_listings_idx_listing_delete_all function.
 *
 * @access public
 * @return void
 */
function wp_listings_idx_listing_delete_all() {

	$permission = check_ajax_referer( 'wp_listings_idx_listing_delete_all_nonce', 'nonce', false );
	if ( false === $permission ) {
		echo 'error';
	} else {
		// Get listings.
		$idx_feat_options = get_option( 'wplpro_idx_featured_listing_wp_options' );

		foreach ( $idx_feat_options as $prop ) {
			if ( isset( $prop['post_id'] ) ) {
				// Delete featured image.
				$post_feat_id = get_post_thumbnail_id( $prop['post_id'] );
				wp_delete_attachment( $post_feat_id );

				// Delete post.
				wp_delete_post( $prop['post_id'] );
			}
		}

		echo 'success';
	}
}


/**
 * Wp_listings_idx_listing_setting_page function.
 *
 * @access public
 * @return void
 */
function wp_listings_idx_listing_setting_page() {
	wplpro_admin_scripts_styles();
	$do_button = true;
	if ( '' === get_option( 'permalink_structure' ) ) {
		add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_import_progress', 'Within WordPress settings, you have Permalinks set to "Plain". Unfortunately, the import page will not work unless permalinks have been set to something else. In order for the import page to work, please go to your Permalinks page under Settings, and change them to something else (we recommend "Post name").', 'error' );
		$do_button = false;
	}

	if ( get_option( 'wp_listings_import_progress' ) === true ) {
		add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_import_progress', 'Your listings are being imported in the background. This notice will dismiss when all selected listings have been imported.', 'updated' );
	}
	$idx_feat_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
	$idx_feat_options = ( !is_array( $idx_feat_options ) ) ? array() : $idx_feat_options; // Set to array if empty for some reason.

	?>
			<h1>IDX Broker: Import Listings</h1>
			<p>You can use this page to import listings from IDX Broker. Choose one or all, its up to you.</p>

			<p><strong>Please note: The time to import your listings will vary based on the number of listings you choose to import, and the number of images for each listing. You can come back and refresh the page at anytime to check the status.</strong></p>


			<form id="wplpro-idx-listing-import">
			<label for="selectall"><input type="checkbox" id="selectall"/>Select/Deselect All</label>

			<?php
			if ( $do_button ) {
				submit_button( 'Import Listings', 'primary submit-imports-button' );
			}

			settings_errors( 'wp_listings_idx_listing_settings_group' );
			?>

			<ol id="selectable" class="grid">
			<div class="grid-sizer"></div>

			<?php
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			$plugin_data = get_plugins();

			// Bail if IDX plugin version is not at least 2.0.
			// if ( $plugin_data['idx-broker-platinum/idx-broker-platinum.php']['Version'] < 2.0 ) {
			// add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_update', 'You must update to <a href="' . admin_url( 'update-core.php' ) . '">IMPress for IDX Broker</a> version 2.0.0 or higher to import listings.', 'error' );
			// settings_errors( 'wp_listings_idx_listing_settings_group' );
			// return;
			// }
			$_idx_api   = new WPLPRO_Idx_Api();
			$properties = $_idx_api->client_properties( 'featured' );
			if ( is_wp_error( $properties ) ) {
				$error_string = $properties->get_error_message();
				add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_update', $error_string, 'error' );
				settings_errors( 'wp_listings_idx_listing_settings_group' );
				return;
			}

			settings_fields( 'wp_listings_idx_listing_settings_group' );
			do_settings_sections( 'wp_listings_idx_listing_settings_group' );

			// No featured properties found.
			if ( ! $properties ) {
				echo 'No featured properties found.';
				return;
			}

			// Update references in case post is not listed properly.
			$stuff = get_posts(
				array(
					'post_type' => 'listing',
				)
			);
			foreach ( $stuff as $prop ) {
				if ( ! isset( $idx_feat_options[ get_post_meta( $prop->ID, '_listing_mls', true ) ]['post_id'] ) ) {
					$list_mls = get_post_meta( $prop->ID, '_listing_mls', true );
					$idx_feat_options[ $list_mls ]['post_id'] = $prop->ID;
					$idx_feat_options[ $list_mls ]['status']  = 'publish';
				}
			}
			// Loop through properties.
			foreach ( $properties as $prop ) {

				if ( isset( $prop['listingID'] ) ) {
					if ( ! isset( $idx_feat_options[ $prop['listingID'] ]['post_id'] ) || ! get_post( $idx_feat_options[ $prop['listingID'] ]['post_id'] ) ) {
						$idx_feat_options[ $prop['listingID'] ] = array(
							'listingID' => $prop['listingID'],
						);
					}

					if ( isset( $idx_feat_options[ $prop['listingID'] ]['post_id'] ) && get_post( $idx_feat_options[ $prop['listingID'] ]['post_id'] ) ) {
						$pid            = $idx_feat_options[ $prop['listingID'] ]['post_id'];
						$nonce          = wp_create_nonce( 'wp_listings_idx_listing_delete_nonce' );
						$delete_listing = sprintf(
							'<a data-id="%s" data-nonce="%s" class="delete-listing">Delete</a>',
							$pid,
							$nonce
						);
					} elseif ( isset( $idx_feat_options[ $prop['listingID'] ]['status'] ) && 'publish' === $idx_feat_options[ $prop['listingID'] ]['status'] ) {
						unset( $idx_feat_options[ $prop['listingID'] ]['status'] );
					}

					printf(
						'<div class="grid-item post"><label for="%s" class="idx-listing"><li class="%s"><img class="listing lazy" data-original="%s"><input type="checkbox" id="%s" class="checkbox" name="wplpro_idx_featured_listing_options[]" value="%s" %s />%s<p><span class="price">%s</span><br/><span class="address">%s</span><br/><span class="mls">MLS#: </span>%s</p>%s</li></label></div>',
						// @codingStandardsIgnoreStart
						$prop['listingID'],
						isset( $idx_feat_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_feat_options[ $prop['listingID'] ]['status'] ? 'imported' : '') : '',
						isset( $prop['image']['0']['url'] ) ? 'https://i0.wp.com/' . preg_replace( '#^https?://#', '', $prop['image']['0']['url'] ) : WPLPRO_URL . 'assets/images/no-photo-full.png',
						$prop['listingID'],
						$prop['listingID'],
						isset( $idx_feat_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_feat_options[ $prop['listingID'] ]['status'] ? 'checked' : '') : '',
						isset( $idx_feat_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_feat_options[ $prop['listingID'] ]['status'] ? "<span class='imported'><i class='dashicons dashicons-yes'></i>Imported</span>" : '') : '',
						$prop['listingPrice'],
						$prop['address'],
						$prop['listingID'],
						isset( $idx_feat_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_feat_options[ $prop['listingID'] ]['status'] ? $delete_listing : '') : ''
						// @codingStandardsIgnoreEnd
					);
				}
			} // End foreach().
			echo '</ol>';
			if ( $do_button ) {
				submit_button( 'Import Listings', 'primary submit-imports-button' );
			}
			?>
			</form>
	<?php
}

/**
 * Check if update is scheduled - if not, schedule it to run twice daily.
 * Only add if IDX plugin is installed
 *
 * @since 2.0
 */
if ( class_exists( 'IDX_Broker_Plugin' ) ) {
	add_action( 'admin_init', 'wplpro_idx_update_schedule' );
}


/**
 * Wplpro_idx_update_schedule function.
 *
 * @access public
 * @return void
 */
function wplpro_idx_update_schedule() {
	if ( ! wp_next_scheduled( 'wplpro_idx_update' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'wplpro_idx_update' );
	}
}
/**
 * On the scheduled update event, run wp_listings_update_post with activation status
 *
 * @since 2.0
 */
add_action( 'wplpro_idx_update', array( 'WPLPROIdxListing', 'wp_listings_update_post' ) );


new WPLPROBackgroundListings();
new WPLPROBackgroundPhotos();

<?php
/**
 * This file contains the methods for interacting with the IDX API
 * to import listing data.
 *
 * @package WP-Listings-Pro
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * WPL_Idx_Listing class.
 */
class WPL_Idx_Listing {

	/**
	 * _idx
	 *
	 * @var mixed
	 * @access public
	 */
	public $_idx;

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
		if ( ! $array ) { return false;
		}
		foreach ( $array as $index => $value ) {
			if ( $value[ $key ] === $needle ) { return $index;
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
		if ( ! $haystack ) { return false;
		}
		foreach ( $haystack as $item ) {
			if ( ($strict ? $item === $needle : $item == $needle) || (is_array( $item ) && self::in_array( $needle, $item, $strict )) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Creates a post of listing type using post data from options page.
	 *
	 * @param  array $listings listingID of the property. Contains each property that has a check on it
	 * @return [type] $featured Featured.
	 */
	public static function wp_listings_idx_create_post( $listings ) {
		if ( class_exists( 'IDX_Broker_Plugin' ) ) {
			require_once( ABSPATH . 'wp-content/plugins/idx-broker-platinum/idx/idx-api.php' );

			// Load Equity API if it exists.
			if ( class_exists( 'Equity_Idx_Api' ) ) {
				require_once( ABSPATH . 'wp-content/themes/equity/lib/idx/class.Equity_Idx_Api.inc.php' );
				$_equity_idx = new Equity_Idx_Api;
			}

			// Load IDX Broker API Class and retrieve featured properties.
			$_idx_api = new \IDX\Idx_Api();
			$properties = $_idx_api->client_properties( 'featured?disclaimers=true' );

			// Load WP options.
			$idx_featured_listing_wp_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
			$wpl_options = get_option( 'wplpro_plugin_settings' );
			update_option( 'wp_listings_import_progress', true );

			if ( is_array( $listings ) && is_array( $properties ) ) {


				// Loop through featured properties.
				$listings_queue = new WPLPRO_Background_Listings();
				$item = array();

				foreach ( $properties as $prop ) {
					// this is too dangerous of a command

					// Get the listing ID.
					$key = self::get_key( $properties, 'listingID', $prop['listingID'] );

					// Add options.
					if ( ! in_array( $prop['listingID'], $listings, true ) ) {
						$idx_featured_listing_wp_options[ $prop['listingID'] ]['listingID'] = $prop['listingID'];
						$idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] = '';
					}

					// Unset options if they don't exist.
					if ( isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) && ! get_post( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) ) {
						unset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] );
						unset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] );
				 	}

				 	// Add post and update post meta.
					if ( in_array( $prop['listingID'], $listings, true ) && ! isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) ) {
						$idx_featured_listing_wp_options = get_option('wplpro_idx_featured_listing_wp_options');


						if ( '' === $properties[ $key ]['address'] || null === $properties[ $key ]['address'] ) {
							$properties[ $key ]['address'] = 'Address unlisted';
						}
						if ( '' === $properties[ $key ]['remarksConcat'] || null === $properties[ $key ]['remarksConcat'] ) {
							$properties[ $key ]['remarksConcat'] = $properties[ $key ]['listingID'];
						}

						// Post creation options.
						$opts = array(
							'post_content' => $properties[ $key ]['remarksConcat'],
							'post_title' => $properties[ $key ]['address'],
							'post_status' => 'publish',
							'post_type' => 'listing',
							'post_author' => (isset( $wpl_options['import_author'] )) ? $wpl_options['import_author'] : 1,
						);
						// $item['properties'].push($prop);
						$item['opts'] = $opts;
						$item['prop'] = $prop;
						$item['key'] = $key;
						$item['property'] = $properties[$key];

						// Background processing
						error_log("pushing to queue");
				    $listings_queue->push_to_queue( $item );
						update_option( 'wplpro_idx_featured_listing_wp_options', $idx_featured_listing_wp_options );

					} // Change status to publish if it's not already.
					elseif ( in_array( $prop['listingID'], $listings, true ) && 'publish' !== $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) {
						self::wp_listings_idx_change_post_status( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'], 'publish' );
						$idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] = 'publish';

					} // Change post status or delete post based on options.
					elseif ( ! in_array( $prop['listingID'], $listings, true ) && isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) && 'publish' === $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) {

						// Change to draft or delete listing if the post exists but is not in the listing array based on settings.
						if ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-draft' === $wpl_options['wplpro_idx_sold'] ) {

							// Change to draft.
							self::wp_listings_idx_change_post_status( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'], 'draft' );
							$idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] = 'draft';
						} elseif ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-delete' === $wpl_options['wplpro_idx_sold'] ) {

							$idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] = 'deleted';

							// Delete featured image.
							$post_featured_image_id = get_post_thumbnail_id( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] );
							wp_delete_attachment( $post_featured_image_id );

							// Delete post.
							wp_delete_post( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] );
						}
					}
				}
				error_log("dispatching");
				$listings_queue->save()->dispatch();
			}
			// Lastly update our options.=
			update_option( 'wplpro_idx_featured_listing_wp_options', $idx_featured_listing_wp_options );
			delete_option( 'wp_listings_import_progress' );
			return "success";
			// return $idx_featured_listing_wp_options;
		}
	}

	/**
	 * Update existing post.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function wp_listings_update_post() {

		require_once( ABSPATH . 'wp-content/plugins/idx-broker-platinum/idx/idx-api.php' );

		// Load IDX Broker API Class and retrieve featured properties.
		$_idx_api = new \IDX\Idx_Api();
		$properties = $_idx_api->client_properties( 'featured?disclaimers=true' );

		// Load WP options.
		$idx_featured_listing_wp_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
		$wpl_options = get_option( 'wplpro_plugin_settings' );

		foreach ( $properties as $prop ) {

			$key = self::get_key( $properties, 'listingID', $prop['listingID'] );

			if ( isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) ) {
				// Update property data.
				$global_setting = $wpl_options['wplpro_idx_update'];

				$post_id = $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'];

				$sync_setting = get_post_meta( $post_id , '_listing_sync_update', true);
				if( $sync_setting === 'update-useglobal' || $sync_setting == null){
					$sync_setting = $global_setting;
				}

				if ( class_exists( 'Equity_Idx_Api' ) ) {
					require_once( ABSPATH . 'wp-content/themes/equity/lib/idx/class.Equity_Idx_Api.inc.php' );
					$_equity_idx = new Equity_Idx_Api;
					$equity_properties = $_equity_idx->equity_listing_ID( $prop['idxID'], $prop['listingID'] );
					if ( false === $equity_properties ) {
						$equity_properties = $properties[ $key ];
						delete_transient( 'equity_listing_' . $prop['listingID'] );
					}
				}

				$listing_setting = get_post_meta( $post_id , '_listing_sync_update', true);
				if ( ! isset( $sync_setting ) || isset( $sync_setting ) && 'update-none' !== $sync_setting ) {
					$update_image;
					$update_gallery;
					$update_details;
					if( $listing_setting === 'update-useglobal' ) {
						if ( isset ( $wpl_options['wplpro_custom_sync_featured'] ) ) {
							$update_image = $wpl_options['wplpro_custom_sync_featured'];
						}else{
							$update_image = 0;
						}

						if ( isset ( $wpl_options['wplpro_custom_sync_gallery'] ) ) {
							$update_gallery = $wpl_options['wplpro_custom_sync_gallery'];
						}else{
							$update_gallery = 0;
						}

						if ( isset ( $wpl_options['wplpro_custom_sync_details'] ) ) {
							$update_details = $wpl_options['wplpro_custom_sync_details'];
						}else{
							$update_details = 0;
						}
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true, $update_image , false, $update_details, $update_gallery );
					} else if ( $listing_setting === 'update-custom' ) {
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true,  get_post_meta( $post_id, '_listing_custom_sync_featured', true ) , false,  get_post_meta( $post_id, '_listing_custom_sync_details', true ),  get_post_meta( $post_id, '_listing_custom_sync_gallery', true ) );
					} else {
						self::wp_listings_idx_insert_post_meta( $post_id, $properties[ $key ], true, true , false, true, true );
					}
				}
				$idx_featured_listing_wp_options[ $prop['listingID'] ]['updated'] = date( 'm/d/Y h:i:sa' );
			}
		}

		// Load and loop through Sold properties.
		$sold_properties = $_idx_api->client_properties( 'soldpending' );
		foreach ( $sold_properties as $sold_prop ) {

			$key = self::get_key( $sold_properties, 'listingID', $sold_prop['listingID'] );

			if ( isset( $idx_featured_listing_wp_options[ $sold_prop['listingID'] ]['post_id'] ) ) {

				// Update property data.
				self::wp_listings_idx_insert_post_meta( $idx_featured_listing_wp_options[ $sold_prop['listingID'] ]['post_id'], $sold_properties[ $key ], true, ( 'update-noimage' === $wpl_options['wplpro_idx_update'] ) ? false : true, true );

				if ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-draft' === $wpl_options['wplpro_idx_sold'] ) {

					// Change to draft.
					self::wp_listings_idx_change_post_status( $idx_featured_listing_wp_options[ $sold_prop['listingID'] ]['post_id'], 'draft' );
				} elseif ( isset( $wpl_options['wplpro_idx_sold'] ) && 'sold-delete' === $wpl_options['wplpro_idx_sold'] ) {

					// Delete featured image.
					$post_featured_image_id = get_post_thumbnail_id( $idx_featured_listing_wp_options[ $sold_prop['listingID'] ]['post_id'] );
					wp_delete_attachment( $post_featured_image_id );

					// Delete post.
					wp_delete_post( $idx_featured_listing_wp_options[ $sold_prop['listingID'] ]['post_id'] );
				}
			}
		}
		update_option( 'wplpro_idx_featured_listing_wp_options', $idx_featured_listing_wp_options );

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
	    $current_post = get_post( $post_id, 'ARRAY_A' );
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
	 * @param mixed $idx_featured_listing_data IDX Featured Listing Data.
	 * @param bool  $update (default: false) Update.
	 * @param bool  $update_image (default: true) Update Image.
	 * @param bool  $sold (default: false) Sold.
	 * @return void
	 */
	public static function wp_listings_idx_insert_post_meta( $id, $idx_featured_listing_data, $update = false, $update_image = true, $sold = false, $update_details = true, $update_gallery = true ) {
		if ( false === $update  ||true === $update_image ) {
			$imgs = '';
			$featured_image = $idx_featured_listing_data['image']['0']['url'];

			foreach ( $idx_featured_listing_data['image'] as $image_data => $img ) {
				if ( 'totalCount' === $image_data ) { continue;
				}
				$img_markup = sprintf( '<img src="%s" alt="%s" />',  $img['url'], $idx_featured_listing_data['address'] );
				$imgs .= apply_filters( 'wp_listings_imported_image_markup', $img_markup, $img, $idx_featured_listing_data );
			}
		} else {
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
			update_post_meta( $id, '_listing_lot_sqft', $idx_featured_listing_data['acres'] . ' acres' );
			update_post_meta( $id, '_listing_price', $idx_featured_listing_data['listingPrice'] );
			update_post_meta( $id, '_listing_hidden_price', wplpro_strip_price( $idx_featured_listing_data['listingPrice'] ) );
			update_post_meta( $id, '_listing_address', $idx_featured_listing_data['address'] );
			update_post_meta( $id, '_listing_city', $idx_featured_listing_data['cityName'] );
			update_post_meta( $id, '_listing_county', $idx_featured_listing_data['countyName'] );
			update_post_meta( $id, '_listing_state', $idx_featured_listing_data['state'] );
			update_post_meta( $id, '_listing_zip', $idx_featured_listing_data['zipcode'] );
			update_post_meta( $id, '_listing_mls', $idx_featured_listing_data['listingID'] );
			update_post_meta( $id, '_listing_sqft', $idx_featured_listing_data['sqFt'] );
			update_post_meta( $id, '_listing_year_built', (isset( $idx_featured_listing_data['yearBuilt'] )) ? $idx_featured_listing_data['yearBuilt'] : '' );
			update_post_meta( $id, '_listing_bedrooms', $idx_featured_listing_data['bedrooms'] );
			update_post_meta( $id, '_listing_bathrooms', $idx_featured_listing_data['totalBaths'] );
			update_post_meta( $id, '_listing_half_bath', $idx_featured_listing_data['partialBaths'] );
		}

		// Inserts image tags into Old Listing Gallery Box.
		if ( false === $update || true === $update_gallery ) {
			$ids = array();
			for( $i = 0; $i < $idx_featured_listing_data['image']['totalCount']; $i++ ) {
				$image_url = $idx_featured_listing_data['image'][$i];
				$ids[count($ids)] = wplpro_upload_image(array(
					'url' => $image_url['url'],
					'name' => $idx_featured_listing_data['address'] . '-' . $i . '.jpg',
					'title' => $idx_featured_listing_data['address'] . '-' . $i,
					'content' => '',
					'description' => '',
				), $id);
			}
			update_post_meta( $id, '_listing_image_gallery', implode( ',', $ids ) );
		}

		// Add disclaimers and courtesies.
		// foreach ( $idx_featured_listing_data['disclaimer'] as $disclaimer ) {
		// 	if ( in_array( 'details', $disclaimer, true ) ) {
		// 		$disclaimer_logo = ($disclaimer['logoURL']) ? '<br /><img src="' . $disclaimer['logoURL'] . '" style="opacity: 1 !important; position: static !important;" />' : '';
		// 		$disclaimer_combined = $disclaimer['text'] . $disclaimer_logo;
		// 		update_post_meta( $id, '_listing_disclaimer', $disclaimer_combined );
		// 	}
		// 	if ( in_array( 'widget', $disclaimer, true ) ) {
		// 		$disclaimer_logo = ($disclaimer['logoURL']) ? '<br /><img src="' . $disclaimer['logoURL'] . '" style="opacity: 1 !important; position: static !important;" />' : '';
		// 		$disclaimer_combined = $disclaimer['text'] . $disclaimer_logo;
		// 		update_post_meta( $id, '_listing_disclaimer_widget', $disclaimer_combined );
		// 	}
		// }
		//
		// foreach ( $idx_featured_listing_data['courtesy'] as $courtesy ) {
		// 	if ( in_array( 'details', $courtesy, true ) ) {
		// 		update_post_meta( $id, '_listing_courtesy', $courtesy['text'] );
		// 	}
		// 	if ( in_array( 'widget', $courtesy, true ) ) {
		// 		update_post_meta( $id, '_listing_courtesy_widget', $courtesy['text'] );
		// 	}
		// }

		/**
		 * Pull featured image if it's not an update or update image is set to true.
		 */
		if ( false === $update || true === $update_image ) {
			// Delete previously attached image.
			if ( true === $update_image ) {
				$post_featured_image_id = get_post_thumbnail_id( $id );
				wp_delete_attachment( $post_featured_image_id );
			}

			// Add Featured Image to Post.
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
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Define attachment metadata.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

			// Assign metadata to attachment.
			wp_update_attachment_metadata( $attach_id, $attach_data );

			// Assign featured image to post.
			set_post_thumbnail( $id, $attach_id );
		}
	}

}

/**
 * Here is where my background processing stuff goes
 */
require_once plugin_dir_path( __FILE__ ) . 'wp-background-processing/wp-background-processing.php';

class WPLPRO_Background_Listings extends WP_Background_Process {

	protected $action = 'background-processing-listings';

	/**
	 * Task to be run each iteration
	 * @param  string 	$data 	ID of listing to be imported
	 * @return mixed       			False if done, $data if to be re-run
	 */
	protected function task($data){
		error_log('Task being run.');

		// Get important data.
		$idx_options 	= get_option('wplpro_idx_featured_listing_wp_options');
		$property 		= $data['property'];
		$prop 				= $data['prop'];
		$key 					= $data['key'];


		// Add the post (after checking to make sure it's not already there).
		$stuff = get_posts(array(
			'post_type'       => 'listing',
		));
		foreach($stuff as $p){
			if( $property['listingID'] == get_post_meta($p->ID, '_listing_mls', true) ){
				error_log( "Breaking from task, MLS listing already detected." );
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
			$idx_options[ $prop['listingID'] ]['status'] = 'publish';
			update_post_meta( $add_post, '_listing_details_url', $property['fullDetailsURL'] );

			update_option( 'wplpro_idx_featured_listing_wp_options', $idx_options );

			// Insert meta for post
			WPL_Idx_Listing::wp_listings_idx_insert_post_meta( $add_post, $property );
		}

		error_log('Task complete.');
		return false;
	}

	protected function complete(){
		parent::complete();

		error_log("Finished with import queue.");
	}
}

/**
 * Admin settings page.
 * Outputs clients/featured properties to import.
 * Enqueues scripts for display.
 * Deletes post and post thumbnail via ajax.
 */
add_action( 'admin_menu', 'wp_listings_idx_listing_register_menu_page' );


/**
 * Wp_listings_idx_listing_register_menu_page function.
 *
 * @access public
 * @return void
 */
function wp_listings_idx_listing_register_menu_page() {
	add_submenu_page( 'edit.php?post_type=listing', __( 'Import IDX Listings', 'wp-listings-pro' ), __( 'Import IDX Listings', 'wp-listings-pro' ), 'manage_options', 'wplistings-idx-listing', 'wp_listings_idx_listing_setting_page' );
	// add_action( 'admin_init', 'wp_listings_idx_listing_register_settings' );
}

/**
 * Wp_listings_idx_listing_register_settings function.
 *
 * @access public
 * @return void
 */
// function wp_listings_idx_listing_register_settings() {
// 	register_setting( 'wp_listings_idx_listing_settings_group', 'wplpro_idx_featured_listing_options', 'wp_listings_idx_create_post_cron' );
// }

/**
 * Do wp_cron job for importing listings.
 *
 * @access public
 * @param mixed $listings Listings.
 * @return void
 */
// function wp_listings_idx_create_post_cron( $listings ) {
// 	// wp_schedule_single_event( time(), 'wp_listings_idx_create_post_cron_hook', array( $listings ) );
// 	WPL_Idx_Listing::wp_listings_idx_create_post( $listings );
// }
// add_action( 'wp_listings_idx_create_post_cron_hook', array( 'WPL_Idx_Listing', 'wp_listings_idx_create_post' ) );



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
 * @return void
 */
function wp_listings_idx_listing_delete($given_id) {

	//$permission = check_ajax_referer( 'wp_listings_idx_listing_delete_nonce', 'nonce', false );
	$permission = true; // That's not good
	if ( false === $permission ) {
		return "error";
	} else {
		// Delete featured image.
		$post_featured_image_id = get_post_thumbnail_id( $given_id );
		wp_delete_attachment( $post_featured_image_id );

		// Delete images.
		$ids = get_attached_media( "image/jpeg", $given_id );
		foreach( $ids as $id ) {
			wp_delete_attachment($id->ID);
		}
		delete_post_meta( $given_id, '_listing_image_gallery' );

		// Delete post.
		wp_delete_post( $given_id );
		return "success";
	}
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
		$idx_featured_listing_wp_options = get_option( 'wplpro_idx_featured_listing_wp_options' );

		foreach ( $idx_featured_listing_wp_options as $prop ) {
			if ( isset( $prop['post_id'] ) ) {
				// Delete featured image.
				$post_featured_image_id = get_post_thumbnail_id( $prop['post_id'] );
				wp_delete_attachment( $post_featured_image_id );

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
	if ( get_option( 'wp_listings_import_progress' ) === true ) {
		add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_import_progress', 'Your listings are being imported in the background. This notice will dismiss when all selected listings have been imported.', 'updated' );
	}
	$idx_featured_listing_wp_options = get_option( 'wplpro_idx_featured_listing_wp_options' );

	?>
			<h1>Import IDX Listings</h1>
			<p>Select the listings to import.</p>
			<form id="wplpro-idx-listing-import">
			<label for="selectall"><input type="checkbox" id="selectall"/>Select/Deselect All<br/><em>If importing all listings, it may take some time. <strong class="error">Please be patient.</strong></em></label>
			<p>Please note that after pressing the "Import Listings" button, <em>there will be a time delay before all listings are visible depending on how many you are importing</em>. Don't worry, everything that was selected when you pressed "Import Listings" will still be imported, it just takes some time to pull multiple listings and their images from the API feed.</p>
			<?php
			if ( false ) { // leedle leedle leedle lee // https://media.giphy.com/media/eCgzPvuU3ZqX6/giphy.gif
				foreach ( $idx_featured_listing_wp_options as $prop ) {
					if ( isset( $prop['post_id'] ) ) {
						$nonce_all = wp_create_nonce( 'wp_listings_idx_listing_delete_all_nonce' );
						echo '<a class="delete-all" href="" data-nonce="' . $nonce_all . '">Delete All Imported Listings</a>';
						break;
					}
				}
			}
			submit_button( 'Import Listings', 'primary submit-imports-button' );

			settings_errors( 'wp_listings_idx_listing_settings_group' );
			?>

			<ol id="selectable" class="grid">
			<div class="grid-sizer"></div>

			<?php
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			$plugin_data = get_plugins();

			// Get properties from IDX Broker plugin.
			if ( class_exists( 'IDX_Broker_Plugin' ) ) {
				// Bail if IDX plugin version is not at least 2.0.
				if ( $plugin_data['idx-broker-platinum/idx-broker-platinum.php']['Version'] < 2.0 ) {
					add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_update', 'You must update to <a href="' . admin_url( 'update-core.php' ) . '">IMPress for IDX Broker</a> version 2.0.0 or higher to import listings.', 'error' );
					settings_errors( 'wp_listings_idx_listing_settings_group' );
					return;
				}

				$_idx_api = new \IDX\Idx_Api();
				$properties = $_idx_api->client_properties( 'featured' );
				if ( is_wp_error( $properties ) ) {
					$error_string = $properties->get_error_message();
					add_settings_error( 'wp_listings_idx_listing_settings_group', 'idx_listing_update', $error_string, 'error' );
					settings_errors( 'wp_listings_idx_listing_settings_group' );
					return;
				}
			} else {
				return;
			}

			settings_fields( 'wp_listings_idx_listing_settings_group' );
			do_settings_sections( 'wp_listings_idx_listing_settings_group' );

			// No featured properties found.
			if ( ! $properties ) {
				echo 'No featured properties found.';
				return;
			}

			// update references in case post is not listed properly
			$stuff = get_posts(array(
				'post_type'       => 'listing',
			));
			foreach($stuff as $prop){
				if( ! isset($idx_featured_listing_wp_options[ get_post_meta($prop->ID, '_listing_mls', true) ]['post_id'])){
					$idx_featured_listing_wp_options[ get_post_meta($prop->ID, '_listing_mls', true) ]['post_id'] = $prop->ID;
					$idx_featured_listing_wp_options[ get_post_meta($prop->ID, '_listing_mls', true) ]['status'] = 'publish';
				}
			}
			// update_option('wplpro_idx_featured_listing_wp_options', $idx_featured_listing_wp_options); // Don't need to update references globally, as references are just for output purposes

			// Loop through properties.
			foreach ( $properties as $prop ) {

				if( isset( $prop[ 'listingID' ] ) ) {
					$boolDOIT = false;
					if( isset($idx_featured_listing_wp_options[$prop['listingID']]['status'])){
						$boolDOIT = $idx_featured_listing_wp_options[$prop['listingID']]['status'];

					}
					if (  ! isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) || ! get_post( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) ) {
						$idx_featured_listing_wp_options[ $prop['listingID'] ] = array(
							'listingID' => $prop['listingID'],
							);
					}

					if($boolDOIT != false){
						$idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] = $boolDOIT;
					}

					if ( isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) && get_post( $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'] ) ) {
						$pid = $idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id'];
						$nonce = wp_create_nonce( 'wp_listings_idx_listing_delete_nonce' );
						$delete_listing = sprintf('<a data-id="%s" data-nonce="%s" class="delete-listing">Delete</a>',
							$pid,
							$nonce
						);
					}

					// if(16176526 == $prop['listingID'] || 16108388 == $prop['listingID'] || 17199990 == $prop['listingID']){
					// 	unset($idx_featured_listing_wp_options[ $prop['listingID'] ]['status']);
					// 	unset($idx_featured_listing_wp_options[ $prop['listingID'] ]['post_id']);
					// 	update_option( 'wplpro_idx_featured_listing_wp_options', $idx_featured_listing_wp_options );
					// }

					printf('<div class="grid-item post"><label for="%s" class="idx-listing"><li class="%s"><img class="listing lazy" data-original="%s"><input type="checkbox" id="%s" class="checkbox" name="wplpro_idx_featured_listing_options[]" value="%s" %s />%s<p><span class="price">%s</span><br/><span class="address">%s</span><br/><span class="mls">MLS#: </span>%s</p>%s</li></label></div>',
						$prop['listingID'],
						isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ? 'imported' : '') : '',
						isset( $prop['image']['0']['url'] ) ? 'https://i0.wp.com/'. preg_replace('#^https?://#', '', $prop['image']['0']['url'] ) : 'https://i0.wp.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png',
						$prop['listingID'],
						$prop['listingID'],
						isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ? 'checked' : '') : '',
						isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ? "<span class='imported'><i class='dashicons dashicons-yes'></i>Imported</span>" : '') : '',
						$prop['listingPrice'],
						$prop['address'],
						$prop['listingID'],
						isset( $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ) ? ( 'publish' === $idx_featured_listing_wp_options[ $prop['listingID'] ]['status'] ? $delete_listing : '') : ''
					);
				}
			}
			echo '</ol>';
			submit_button( 'Import Listings', 'primary submit-imports-button' );
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
add_action( 'wplpro_idx_update', array( 'WPL_Idx_Listing', 'wp_listings_update_post' ) );


new WPLPRO_Background_Listings();

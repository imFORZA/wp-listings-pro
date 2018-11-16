<?php
/**
 * This file contains the methods for interacting with the IDX API
 * to import agent data
 *
 * @package WP-Listing-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPLPROAgentsImport class.
 */
class WPLPROAgentsImport {

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
	 * In_array function.
	 *
	 * @access public
	 * @static
	 * @param mixed $needle Needle.
	 * @param mixed $haystack Haystack.
	 * @param bool  $strict (default: false) Strict.
	 * @return bool True or False.
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
	 * Creates a post of employee type using post data from options page.
	 *
	 * @param  array $agent_ids agentID of the property.
	 * @return [type] $featured Featured.
	 */
	public static function WPLPROAgents_idx_create_post( $agent_ids ) {
		// Load IDX Broker API Class and retrieve agents.
		$_idx_api             = new WPLPRO_Idx_Api();
		$agents               = $_idx_api->idx_api(
			'agents',
			$apiversion       = '1.2.2',
			$level            = 'clients',
			$params           = array(),
			$expiration       = 7200,
			$request_type     = 'GET',
			$json_decode_type = true
		);

		// Load WP options.
		$idx_agent_wp_options = get_option( 'WPLPROAgents_idx_agent_wp_options' );
		$wplpro_settings      = get_option( 'WPLPROAgents_settings' );

		$agents_queue = new WPLPROBackgroundAgents();

		// Object to be used with background_processing.
		$item = array();

		foreach ( $agents['agent'] as $a ) {
			if ( ! in_array( (string) $a['agentID'], $agent_ids, true ) ) {
				$idx_agent_wp_options[ $a['agentID'] ]['agentID'] = $a['agentID'];
				$idx_agent_wp_options[ $a['agentID'] ]['status']  = '';
			}

			if ( isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) && ! get_post( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) ) {
				unset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] );
				unset( $idx_agent_wp_options[ $a['agentID'] ]['status'] );
			}

			// TODO: have better handling for this.
			if ( ! isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) ) {
				$idx_agent_wp_options[ $a['agentID'] ]['status'] = '';
			}

			if ( in_array( (string) $a['agentID'], $agent_ids, true ) && ! isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) ) {

				$opts = array(
					'post_content' => $a['bioDetails'],
					'post_title'   => $a['agentDisplayName'],
					'post_status'  => 'publish',
					'post_type'    => 'employee',
				);

				$item['opts'] = $opts;
				$item['a']    = $a;
				$agents_queue->push_to_queue( $item );
				update_option( 'WPLPROAgents_idx_agent_wp_options', $idx_agent_wp_options );
			} elseif ( in_array( (string) $a['agentID'], $agent_ids, true ) && 'publish' !== $idx_agent_wp_options[ $a['agentID'] ]['status'] ) {
				self::WPLPROAgents_idx_change_post_status( $idx_agent_wp_options[ $a['agentID'] ]['post_id'], 'publish' );
				$idx_agent_wp_options[ $a['agentID'] ]['status'] = 'publish';
			} elseif ( ! in_array( (string) $a['agentID'], $agent_ids, true ) && 'publish' === $idx_agent_wp_options[ $a['agentID'] ]['status'] ) {

				// change to draft or delete agent if the post exists but is not in the agent array based on settings.
				if ( isset( $wplpro_settings['WPLPROAgents_idx_remove'] ) && 'remove-draft' === $wplpro_settings['WPLPROAgents_idx_remove'] ) {

					// Change to draft.
					self::WPLPROAgents_idx_change_post_status( $idx_agent_wp_options[ $a['agentID'] ]['post_id'], 'draft' );
					$idx_agent_wp_options[ $a['agentID'] ]['status'] = 'draft';
				} elseif ( isset( $wplpro_settings['WPLPROAgents_idx_remove'] ) && 'remove-delete' === $wplpro_settings['WPLPROAgents_idx_remove'] ) {

					$idx_agent_wp_options[ $a['agentID'] ]['status'] = 'deleted';

					// Delete featured image.
					$post_feat_image_id = get_post_thumbnail_id( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] );
					wp_delete_attachment( $post_feat_image_id );

					// Delete post.
					wp_delete_post( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] );
				}
			}
		}
		$agents_queue->save()->dispatch();
		update_option( 'WPLPROAgents_idx_agent_wp_options', $idx_agent_wp_options );
		return $idx_agent_wp_options;
	}

	/**
	 * Update existing post
	 */
	public static function WPLPROAgents_update_post() {

		// Load IDX Broker API Class and retrieve agents.
		$_idx_api             = new WPLPRO_Idx_Api();
		$agents               = $_idx_api->idx_api(
			'agents',
			$apiversion       = '1.2.2',
			$level            = 'clients',
			$params           = array(),
			$expiration       = 7200,
			$request_type     = 'GET',
			$json_decode_type = true
		);

		// Load WP options.
		$idx_agent_wp_options = get_option( 'WPLPROAgents_idx_agent_wp_options' );
		$plugin_settings      = get_option( 'wplpro_plugin_settings' );

		foreach ( $agents as $agent ) {
			foreach ( $agent as $a ) {

				if ( isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) ) {
					$current_setting = get_post_meta( $idx_agent_wp_options[ $a['agentID'] ]['post_id'], '_listing_sync_update', true );
					if ( '' === $current_setting || 'update-useglobal' === $current_setting ) {
						// Confirmed to follow global, or doesn't exist, need to set it to global.
						if ( isset( $plugin_settings['wplpro_idx_update_agents'] ) ) {
							$current_setting = $plugin_settings['wplpro_idx_update_agents'];
						} else {
							// Global doesn't exist, local setting doesn't exist, just sync it.
							$current_setting = 'update-all';
						}
					}
					// Update agent data.
					if ( 'update-none' !== $current_setting ) {
						self::WPLPROAgents_idx_insert_post_meta( $idx_agent_wp_options[ $a['agentID'] ]['post_id'], $a, true, false );
					}
					$idx_agent_wp_options[ $a['agentID'] ]['updated'] = date( 'm/d/Y h:i:sa' );
				}
			}
		}

		update_option( 'WPLPROAgents_idx_agent_wp_options', $idx_agent_wp_options );

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
	public static function WPLPROAgents_idx_change_post_status( $post_id, $status ) {
		$current_post                = get_post( $post_id, 'ARRAY_A' );
		$current_post['post_status'] = $status;
		wp_update_post( $current_post );
	}

	/**
	 * Inserts post meta based on property data API fields are mapped to post meta fields prefixed with _employee_ and lowercased.
	 *
	 * @access public
	 * @static
	 * @param mixed $id ID.
	 * @param mixed $idx_agent_data IDX Agent Data.
	 * @param bool  $update (default: false) Update.
	 * @param bool  $update_image (default: true) Update Image.
	 * @return bool true if featured image is set.
	 */
	public static function WPLPROAgents_idx_insert_post_meta( $id, $idx_agent_data, $update = false, $update_image = true ) {
		// Add or reset taxonomies terms for job-types = agentTitle.
		wp_set_object_terms( $id, $idx_agent_data['agentTitle'], 'job-types' );

		// Add post meta for existing fields.
		if ( get_post_meta( $id, '_employee_title' ) === array() ) {
			update_post_meta( $id, '_employee_title', isset( $idx_agent_data['agentTitle'] ) ? $idx_agent_data['agentTitle'] : '' ); }
		if ( get_post_meta( $id, '_employee_first_name' ) === array() ) {
			update_post_meta( $id, '_employee_first_name', isset( $idx_agent_data['agentFirstName'] ) ? $idx_agent_data['agentFirstName'] : '' ); }
		if ( get_post_meta( $id, '_employee_last_name' ) === array() ) {
			update_post_meta( $id, '_employee_last_name', isset( $idx_agent_data['agentLastName'] ) ? $idx_agent_data['agentLastName'] : '' ); }
		if ( get_post_meta( $id, '_employee_agent_id' ) === array() ) {
			update_post_meta( $id, '_employee_agent_id', isset( $idx_agent_data['agentID'] ) ? $idx_agent_data['agentID'] : '' ); }
		if ( get_post_meta( $id, '_employee_phone' ) === array() ) {
			update_post_meta( $id, '_employee_phone', isset( $idx_agent_data['agentContactPhone'] ) ? $idx_agent_data['agentContactPhone'] : '' ); }
		if ( get_post_meta( $id, '_employee_mobile' ) === array() ) {
			update_post_meta( $id, '_employee_mobile', isset( $idx_agent_data['agentCellPhone'] ) ? $idx_agent_data['agentCellPhone'] : '' ); }
		if ( get_post_meta( $id, '_employee_email' ) === array() ) {
			update_post_meta( $id, '_employee_email', isset( $idx_agent_data['agentEmail'] ) ? $idx_agent_data['agentEmail'] : '' ); }
		if ( get_post_meta( $id, '_employee_website' ) === array() ) {
			update_post_meta( $id, '_employee_website', isset( $idx_agent_data['agentURL'] ) ? $idx_agent_data['agentURL'] : '' ); }
		if ( get_post_meta( $id, '_employee_address' ) === array() ) {
			update_post_meta( $id, '_employee_address', isset( $idx_agent_data['address'] ) ? $idx_agent_data['address'] : '' ); }
		if ( get_post_meta( $id, '_employee_city' ) === array() ) {
			update_post_meta( $id, '_employee_city', isset( $idx_agent_data['city'] ) ? $idx_agent_data['city'] : '' ); }
		if ( get_post_meta( $id, '_employee_state' ) === array() ) {
			update_post_meta( $id, '_employee_state', isset( $idx_agent_data['stateProvince'] ) ? $idx_agent_data['stateProvince'] : '' ); }
		if ( get_post_meta( $id, '_employee_zip' ) === array() ) {
			update_post_meta( $id, '_employee_zip', isset( $idx_agent_data['zipCode'] ) ? $idx_agent_data['zipCode'] : '' ); }

		foreach ( $idx_agent_data as $metakey => $metavalue ) {
			if ( isset( $metavalue ) && ! is_array( $metavalue ) && '' !== $metavalue ) {
				if ( get_post_meta( $id, '_employee_' . strtolower( $metakey ) ) === false ) {
					update_post_meta( $id, '_employee_' . strtolower( $metakey ), $metavalue );
				}
			} elseif ( isset( $metavalue ) && is_array( $metavalue ) ) {
				foreach ( $metavalue as $key => $value ) {
					if ( get_post_meta( $id, '_employee_' . strtolower( $metakey ) ) ) {
						$oldvalue = get_post_meta( $id, '_employee_' . strtolower( $metakey ), true );
						$newvalue = $value . ', ' . $oldvalue;
						update_post_meta( $id, '_employee_' . strtolower( $metakey ), $newvalue );
					} else {
						update_post_meta( $id, '_employee_' . strtolower( $metakey ), $value );
					}
				}
			}
		}

		/**
		 * Pull featured image if it's not an update or update image is set to true.
		 */
		$featured_image = $idx_agent_data['agentPhotoURL'];

		if ( isset( $featured_image ) && null !== $featured_image ) {
			if ( false === $update || true === $update_image ) {
				// Delete previously attached image.
				$post_feat_id = get_post_thumbnail_id( $id );
				wp_delete_attachment( $post_feat_id );

				// Add Featured Image to Post.
				$image_url  = $featured_image;  // Define the image URL here.
				$upload_dir = wp_upload_dir();  // Set upload folder.

				if ( '' !== $image_url ) {
					$image_data = file_get_contents( $image_url ); // Get image data.

					$filename = basename( sanitize_file_name( strtolower( $idx_agent_data['agentDisplayName'] ) ) . '.jpg' ); // Create image file name.

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
						'post_title'     => $idx_agent_data['agentDisplayName'] . ' - ' . $idx_agent_data['agentID'],
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
				}
			}

			return true;
		}
		return false;
	}

}

/**
 * Here is where my background processing stuff goes
 */
require_once plugin_dir_path( __FILE__ ) . 'wp-background-processing/wp-background-processing.php';



/**
 * WPLPROBackgroundAgents class.
 *
 * @extends WP_Background_Process
 */
class WPLPROBackgroundAgents extends WP_Background_Process {

	/**
	 * Action.
	 *
	 * (default value: 'background-processing-agents')
	 *
	 * @var string
	 * @access protected
	 */
	protected $action = 'background-processing-agents';

	/**
	 * Task to be run each iteration.
	 *
	 * @param  string $data   ID of listing to be imported.
	 * @return mixed                False if done, $data if to be re-run.
	 */
	protected function task( $data ) {
		// Get important data.
		$idx_options = get_option( 'WPLPROAgents_idx_agent_wp_options' );
		$a           = $data['a'];

		// Check if it already exists.
		$stuff = get_posts(
			array(
				'post_type' => 'employee',
			)
		);
		foreach ( $stuff as $temp_agent ) {
			if ( get_post_meta( $temp_agent->ID, '_employee_agent_id', true ) === $a['agentID'] ) {
				// Already exists.
				return false;
			}
		}

		$add_post = wp_insert_post( $data['opts'], true );
		if ( is_wp_error( $add_post ) ) {
			$error_string = $add_post->get_error_message();
			add_settings_error( 'WPLPROAgents_idx_agent_settings_group', 'insert_post_failed', 'WordPress failed to insert the post. Error ' . $error_string, 'error' );
			return;
		} elseif ( $add_post ) {
			$idx_options[ $a['agentID'] ]['post_id'] = $add_post;
			$idx_options[ $a['agentID'] ]['status']  = 'publish';
			WPLPROAgentsImport::WPLPROAgents_idx_insert_post_meta( $add_post, $a );
			update_option( 'WPLPROAgents_idx_agent_wp_options', $idx_options );
		}
		return false;
	}

}


/**
 * Admin settings page.
 * Outputs cleints/agents api data to import.
 * Enqueues scripts for display. Deletes post and post thumbnail via ajax.
 */
add_action( 'admin_menu', 'WPLPROAgents_idx_agent_register_menu_page' );


/**
 * WPLPro Agents register menu page.
 *
 * @access public
 * @return void
 */
function WPLPROAgents_idx_agent_register_menu_page() {
	add_submenu_page( 'edit.php?post_type=employee', __( 'IDX Broker Import', 'wp-listings-pro' ), __( 'IDX Broker Import', 'wp-listings-pro' ), 'manage_options', 'wplpro-idx-agent', 'WPLPROAgents_idx_agent_setting_page' );
	add_action( 'admin_init', 'WPLPROAgents_idx_agent_register_settings' );
}

/**
 * WPLPRO agents register settings function.
 *
 * @access public
 * @return void
 */
function WPLPROAgents_idx_agent_register_settings() {
	register_setting( 'WPLPROAgents_idx_agent_settings_group', 'WPLPROAgents_idx_agent_options', array( 'WPLPROAgentsImport', 'WPLPROAgents_idx_create_post' ) );
}

add_action( 'admin_enqueue_scripts', 'WPLPROAgents_idx_agent_scripts' );


/**
 * WPLPRO agents register scripts function.
 *
 * @access public
 * @return void
 */
function WPLPROAgents_idx_agent_scripts() {
	$screen = get_current_screen();
	if ( 'employee_page_wplpro-idx-agent' !== $screen->id ) {
		return;
	}

	wp_enqueue_script( 'images-loaded', WPLPRO_URL . 'assets/js/imagesloaded.min.js' );
	wp_localize_script( 'WPLPROAgents_idx_agent_delete_script', 'DeleteAgentAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_style( 'WPLPROAgents_idx_agent_style', WPLPRO_URL . 'assets/css/wplpro-import.min.css' );
}
add_action( 'wp_ajax_impa_idx_agent_delete', 'impa_idx_agent_delete' );


/**
 * Agent Delete.
 *
 * @access public
 * @return void
 */
function impa_idx_agent_delete() {

	$permission = check_ajax_referer( 'impa_idx_agent_delete_nonce', 'nonce', false );
	if ( false === $permission ) {
		echo 'error';
	} else {
		// Delete featured image.
		$requested_id = intval( sanitize_text_field( $_REQUEST['id'] ) );
		$post_feat_id = get_post_thumbnail_id( $requested_id );
		wp_delete_attachment( $post_feat_id );

		// Delete post.
		wp_delete_post( $requested_id );
		echo 'success';
	}
	die();
}

/**
 * Agents Settings Page.
 *
 * @access public
 * @return void
 */
function WPLPROAgents_idx_agent_setting_page() {

	wplpro_admin_scripts_styles();

	$do_button = true;
	if ( '' === get_option( 'permalink_structure' ) ) {
		add_settings_error( 'WPLPROAgents_idx_agent_settings_group', 'idx_agent_import_progress', 'Within WordPress settings, you have Permalinks set to "Plain". Unfortunately, the import page will not work unless permalinks have been set to something else. In order for the import page to work, please go to your Permalinks page under Settings, and change them to something else (we recommend "Post name").', 'error' );
		$do_button = false;
	}
	?>
			<h1>IDX Broker: Import Agents</h1>
			<p>Select the agents to import.</p>
			<form id="wplpro-idx-agent-import" method="post" action="options.php">
				<label for="selectall"><input type="checkbox" id="selectall"/>Select/Deselect All<br/><em>If importing all agents, it may take some time. <strong class="error">Please be patient.</strong></em></label>
				<p>Please note that after pressing the "Import Agents" button, <em>there will be a time delay before all agents are visible depending on how many you are importing</em>. Don't worry, everything that was selected when you pressed "Import Agents" will still be imported, it just takes some time to pull multiple agents and their image from the API feed.</p>
				<?php
				if ( $do_button ) {
					submit_button( 'Import Agents' );}
				?>

			<?php

			settings_errors( 'WPLPROAgents_idx_agent_settings_group' );
			?>

			<ol id="selectable" class="grid">
			<div class="grid-sizer"></div>

			<?php
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			$plugin_data = get_plugins();

				// Bail if IDX plugin version is not at least 2.0.
				// if ( $plugin_data['idx-broker-platinum/idx-broker-platinum.php']['Version'] < 2.0 ) {
				// add_settings_error( 'WPLPROAgents_idx_agent_settings_group', 'idx_agent_update', 'You must update to <a href="' . admin_url( 'update-core.php' ) . '">IMPress for IDX Broker</a> version 2.0.0 or higher to import listings.', 'error' );
				// settings_errors( 'WPLPROAgents_idx_agent_settings_group' );
				// return;
				// }
			$_idx_api             = new WPLPRO_Idx_Api();
			$agents               = $_idx_api->idx_api(
				'agents',
				$apiversion       = '1.2.2',
				$level            = 'clients',
				$params           = array(),
				$expiration       = 7200,
				$request_type     = 'GET',
				$json_decode_type = true
			);
			// $agents = $_idx_api->idx_api('agents');
			$idx_agent_wp_options = get_option( 'WPLPROAgents_idx_agent_options' );

			settings_fields( 'WPLPROAgents_idx_agent_settings_group' );
			do_settings_sections( 'WPLPROAgents_idx_agent_settings_group' );

			// No agents found.
			if ( ! $agents ) {
				echo 'No agents found.';
				return;
			}

			$nophoto = isset( get_option( 'wplpro_customizer_settings' )['employee_nophoto'] ) ? get_option( 'wplpro_customizer_settings' )['employee_nophoto'] : '';

			// Loop through agents.
			foreach ( $agents as $agent ) {
				foreach ( $agent as $a ) {

					if ( ! isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) || ! get_post( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) ) {
						$idx_agent_wp_options[ $a['agentID'] ] = array(
							'agentID' => $a['agentID'],
						);
					}

					$stuff = get_posts(
						array(
							'post_type' => 'employee',
						)
					);
					foreach ( $stuff as $temp_agent ) {
						if ( get_post_meta( $temp_agent->ID, '_employee_agent_id', true ) === (string) $a['agentID'] ) {
							if ( ! isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) || ! '' !== $idx_agent_wp_options[ $a['agentID'] ]['status'] ) { // what.
								$idx_agent_wp_options[ $a['agentID'] ]['status'] = 'publish';
							}

							if ( ! isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) || '' === $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) {
								$idx_agent_wp_options[ $a['agentID'] ]['post_id'] = $temp_agent->ID;
							}
						}
					}

					if ( isset( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) && get_post( $idx_agent_wp_options[ $a['agentID'] ]['post_id'] ) ) {
						$pid          = $idx_agent_wp_options[ $a['agentID'] ]['post_id'];
						$nonce        = wp_create_nonce( 'impa_idx_agent_delete_nonce' );
						$delete_agent = sprintf(
							'<a href="" data-id="%s" data-nonce="%s" class="delete-agent">Delete</a>',
							$pid,
							$nonce
						);
					}

					printf(
						'<div class="grid-item post"><label for="%s" class="idx-agent"><li class="%s agent"><img class="agent" src="%s"><input type="checkbox" id="%s" class="checkbox" name="WPLPROAgents_idx_agent_options[]" value="%s" %s /><p><span class="agent-name">%s</span><br/><span class="agent-title">%s</span><br/><span class="agent-phone">%s</span><br/><span class="agent-id">Agent ID: %s</span></p><div class="controls">%s %s</div></li></label></div>',
						// @codingStandardsIgnoreStart
						$a['agentID'],
						isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) ? ( 'publish' === $idx_agent_wp_options[ $a['agentID'] ]['status'] ? 'imported' : '') : '',
						( isset( $a['agentPhotoURL'] ) && '' !== $a['agentPhotoURL'] ) ? $a['agentPhotoURL'] : ( $nophoto != "" ?  get_option('wplpro_customizer_settings')['employee_nophoto'] : WPLPRO_URL . 'assets/images/default.gif'),
						$a['agentID'],
						$a['agentID'],
						isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) ? ( 'publish' === $idx_agent_wp_options[ $a['agentID'] ]['status'] ? 'checked' : '') : '',
						$a['agentDisplayName'],
						$a['agentTitle'],
						isset( $a['agentContactPhone'] ) ? $a['agentContactPhone'] : '',
						$a['agentID'],
						isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) ? ( 'publish' === $idx_agent_wp_options[ $a['agentID'] ]['status'] ? "<span class='imported'>Imported</span>" : '') : '',
						isset( $idx_agent_wp_options[ $a['agentID'] ]['status'] ) ? ( 'publish' === $idx_agent_wp_options[ $a['agentID'] ]['status'] ? $delete_agent : '') : ''
						// @codingStandardsIgnoreEnd
					);

				}
			}
			echo '</ol>';
			if ( $do_button ) {
				submit_button( 'Import Agents' );
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
	add_action( 'admin_init', 'WPLPROAgents_idx_update_schedule' );
}


/**
 * Agents IDX Update Schedule.
 *
 * @access public
 * @return void
 */
function WPLPROAgents_idx_update_schedule() {
	if ( ! wp_next_scheduled( 'WPLPROAgents_idx_update' ) ) {
		wp_schedule_event( time(), 'daily', 'WPLPROAgents_idx_update' );
	}
}
/**
 * On the scheduled update event, run WPLPROAgents_update_post with activation status.
 *
 * @since 2.0
 */
add_action( 'WPLPROAgents_idx_update', array( 'WPLPROAgentsImport', 'WPLPROAgents_update_post' ) );

new WPLPROBackgroundAgents();

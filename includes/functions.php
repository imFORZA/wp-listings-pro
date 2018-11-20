<?php
/**
 * Functions.
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * WP Listing Pro Customizer Settings.
 *
 * @access public
 * @param mixed $wp_customize WP Customize.
 * @return void
 */
function wplpro_customize_register( $wp_customize ) {

	$wp_customize->add_section(
		'wplpro_customizer_settings',
		array(
			'title'    => __( 'WP Listings Pro', 'wplpro' ),
			'priority' => 120,
		)
	);

	// Image Upload Example.
	$wp_customize->add_setting(
		'wplpro_customizer_settings[employee_nophoto]',
		array(
			'default'    => plugin_dir_url( __FILE__ ) . '../assets/images/default.gif',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'employee_nophoto',
			array(
				'label'    => __( 'Default Employee Thumbnail', 'wplpro' ),
				'section'  => 'wplpro_customizer_settings',
				'settings' => 'wplpro_customizer_settings[employee_nophoto]',
			)
		)
	);

		$wp_customize->add_setting(
			'wplpro_customizer_settings[listing_nophoto]',
			array(
				'default'    => plugin_dir_url( __FILE__ ) . '../assets/images/listing-nophoto.jpg',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			)
		);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'listing_nophoto',
			array(
				'label'    => __( 'Default Listing Thumbnail', 'wplpro' ),
				'section'  => 'wplpro_customizer_settings',
				'settings' => 'wplpro_customizer_settings[listing_nophoto]',
			)
		)
	);

}
add_action( 'customize_register', 'wplpro_customize_register' );

/**
 * Holds miscellaneous functions for use in the WP Listings plugin
 */
add_image_size( 'listings-full', 1060, 9999, false );
add_image_size( 'listings', 560, 380, true );

add_filter( 'template_include', 'wplpro_template_include' );

add_action( 'before_delete_post', 'wplpro_clear_references' );

/**
 * Clear References.
 *
 * @access public
 * @param mixed $post_id Post ID.
 * @return void
 */
function wplpro_clear_references( $post_id ) {
	$post_type = get_post( $post_id )->post_type;
	if ( 'listing' === $post_type ) {
		// Delete references.
		$idx_options = get_option( 'wplpro_idx_featured_listing_wp_options' );
		if ( isset( $idx_options[ get_post_meta( $post_id, '_listing_mls', true ) ]['post_id'] ) ) {
			unset( $idx_options[ get_post_meta( $post_id, '_listing_mls', true ) ]['post_id'] );
		}
		if ( isset( $idx_options[ get_post_meta( $post_id, '_listing_mls', true ) ]['status'] ) ) {
			unset( $idx_options[ get_post_meta( $post_id, '_listing_mls', true ) ]['status'] );
		}
		update_option( 'wplpro_idx_featured_listing_wp_options', $idx_options );
	}
}
/**
 * Template Support.
 *
 * @access public
 * @param mixed $template Template.
 * @return Templates.
 */
function wplpro_template_include( $template ) {

	global $wp_query;

	$post_type = 'listing';

	if ( $wp_query->is_search && get_post_type() === 'listing' ) {
		if ( file_exists( get_stylesheet_directory() . '/search-' . $post_type . '.php' ) ) {
			$template = get_stylesheet_directory() . '/search-' . $post_type . '.php';
			return $template;
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}
	if ( wplpro_is_taxonomy_of( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/taxonomy-' . $post_type . '.php' ) ) {
			return get_stylesheet_directory() . '/taxonomy-' . $post_type . '.php';
		} elseif ( file_exists( get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
			return get_stylesheet_directory() . '/archive-' . $post_type . '.php';
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}

	if ( is_post_type_archive( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
			$template = get_stylesheet_directory() . '/archive-' . $post_type . '.php';
			return $template;
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}

	if ( is_single() && get_post_type() === $post_type ) {

		global $post;

		$custom_template = get_post_meta( $post->ID, '_wp_post_template', true );

		/** Prevent directory traversal. */
		$custom_template = str_replace( '..', '', $custom_template );

		if ( ! $custom_template ) {
			if ( file_exists( get_stylesheet_directory() . '/single-' . $post_type . '.php' ) ) {
				return $template;
			} else {
				return WPLPRO_DIR . '/templates/single-' . $post_type . '.php';
			}
		} elseif ( file_exists( get_stylesheet_directory() . "/{$custom_template}" ) ) {
				$template = get_stylesheet_directory() . "/{$custom_template}";
		} elseif ( file_exists( get_template_directory() . "/{$custom_template}" ) ) {
			$template = get_template_directory() . "/{$custom_template}";
		}
	}

	return $template;
}

/**
 * Controls output of default state for the state custom field if there is one set.
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return State.
 */
function wplpro_get_state( $post_id = null ) {
	$options = get_option( 'wplpro_plugin_settings' );
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$state = get_post_meta( $post_id, '_listing_state', true );
	if ( isset( $options['wplpro_default_state'] ) ) {
		$default_state = $options['wplpro_default_state'];
	}

	if ( empty( $default_state ) ) {
		$default_state = 'ST';
	}

	if ( empty( $state ) ) {
		return $default_state;
	}

	return $state;
}

/**
 * Controls output of city name
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return City.
 */
function wplpro_get_city( $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$city = get_post_meta( $post_id, '_listing_city', true );
	if ( '' === $city ) {
		$city = 'Cityname';
	}

	return $city;
}

/**
 * Controls output of address
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return Address.
 */
function wplpro_get_address( $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$address = get_post_meta( $post_id, '_listing_address', true );
	if ( '' === $address ) {
		$address = 'Address Unavailable';
	}

	return $address;
}

/**
 * Displays the status (active, pending, sold, for rent) of a listing
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @param int   $single (default: 0) Single.
 * @return void
 */
function wplpro_get_status( $post_id = null, $single = 0 ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$listing_status = wp_get_object_terms( $post_id, 'status' );
	if ( empty( $listing_status ) || is_wp_error( $listing_status ) ) {
		return;
	}

	$status = null;
	foreach ( $listing_status as $term ) {
		if ( 'Featured' !== $term->name ) {
			$status .= $term->name;
			if ( 0 === $single ) {
				return $status;
			}
			$status .= '<br />';
		}
	}

	return $status;
}

/**
 * Displays the property type (residential, condo, comemrcial, etc) of a listing.
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return void
 */
function wplpro_get_property_types( $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$listing_prop_types = wp_get_object_terms( $post_id, 'property-types' );
	if ( empty( $listing_prop_types ) || is_wp_error( $listing_prop_types ) ) {
		return;
	}

	foreach ( $listing_prop_types as $type ) {
		return $type->name;
	}
}

/**
 * Displays the location term of a listing.
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return void
 */
function wplpro_get_locations( $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$listing_locations = wp_get_object_terms( $post_id, 'locations' );
	if ( empty( $listing_locations ) || is_wp_error( $listing_locations ) ) {
		return;
	}

	foreach ( $listing_locations as $location ) {
		return $location->name;
	}
}

/**
 * Clears cached listings/agents from importing.
 *
 * @return void
 */
function wplpro_clear_transient_cache() {
	$idx_api = new WPLPRO_IDX_API();

	$idx_api->idx_clean_transients();
}
add_action( 'wplpro_clear_transients', 'wplpro_clear_transient_cache' );

/**
 * Add Listings to "At a glance" Dashboard widget.
 */
add_filter( 'dashboard_glance_items', 'wplpro_glance_items', 10, 1 );


/**
 * Glance Items.
 *
 * @access public
 * @param array $items (default: array()) Items.
 * @return Items.
 */
function wplpro_glance_items( $items = array() ) {

	$post_types = array( 'listing', 'employee' );

	foreach ( $post_types as $type ) {

		if ( ! post_type_exists( $type ) ) {
			continue;
		}

		$num_posts = wp_count_posts( $type );

		if ( $num_posts ) {

			$published = intval( $num_posts->publish );
			$post_type = get_post_type_object( $type );

			// Clever... unfortunately not wp standards :/ that's a hard one.
			// @codingStandardsIgnoreStart
			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'wp-listings-pro' );
			// @codingStandardsIgnoreEnd
			$text = sprintf( $text, number_format_i18n( $published ) );

			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $type, $text ) . "\n";
			} else {
				$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $type, $text ) . "\n";
			}
		}
	}

	return $items;
}

/**
 * Better Jetpack Related Posts Support for Listings
 *
 * @access public
 * @param mixed $headline Headline.
 * @return Headline.
 */
function wplpro_jetpack_relatedposts( $headline ) {
	if ( is_singular( 'listing' ) ) {
		$headline = sprintf(
			'<h3 class="jp-relatedposts-headline"><em>%s</em></h3>',
			esc_html( 'Similar Listings' )
		);
	}
	return $headline;
}
add_filter( 'jetpack_relatedposts_filter_headline', 'wplpro_jetpack_relatedposts' );

/**
 * Add Listings to Jetpack Omnisearch
 */
if ( class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
	new Jetpack_Omnisearch_Posts( 'listing' );
}

/**
 * Add Listings to Jetpack sitemap
 */
add_filter( 'jetpack_sitemap_post_types', 'wplpro_jetpack_sitemap' );


/**
 * Add Listings to Jetpack sitemap
 *
 * @access public
 * @return array new array( 'listing', 'employee' ).
 */
function wplpro_jetpack_sitemap() {
	$post_types = array( 'listing', 'employee' );
	return $post_types;
}

/**
 * Function to return term image for use on front end.
 *
 * @access public
 * @param mixed  $term_id Term ID.
 * @param bool   $html (default: true) HTML.
 * @param string $size (default: 'full') Size.
 * @return object Term image if it exist, else image ID that it's supposed to be (possible undefined/null).
 */
function wplpro_term_image( $term_id, $html = true, $size = 'full' ) {
	$image_id = get_term_meta( $term_id, 'wplpro_term_image', true );
	return $image_id && $html ? wp_get_attachment_image( $image_id, $size, false, array( 'class' => 'wp-listings-term-image' ) ) : $image_id;
}

/**
 * Holds miscellaneous functions for use with Agents.
 */
add_image_size( 'employee-thumbnail', 150, 200, true );
add_image_size( 'employee-full', 300, 400, true );

add_filter( 'template_include', 'wplpro_template_include_employee' );


/**
 * Employee Templates.
 *
 * @access public
 * @param mixed $template Template.
 * @return Templates.
 */
function wplpro_template_include_employee( $template ) {

	global $wp_query;

	$post_type = 'employee';

	if ( $wp_query->is_search && get_post_type() === 'employee' ) {
		if ( file_exists( get_stylesheet_directory() . '/search-' . $post_type . '.php' ) ) {
			$template = get_stylesheet_directory() . '/search-' . $post_type . '.php';
			return $template;
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}
	if ( wplpro_is_taxonomy_of( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/taxonomy-' . $post_type . '.php' ) ) {
			return get_stylesheet_directory() . '/taxonomy-' . $post_type . '.php';
		} elseif ( file_exists( get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
			return get_stylesheet_directory() . '/archive-' . $post_type . '.php';
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}

	if ( is_post_type_archive( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
			$template = get_stylesheet_directory() . '/archive-' . $post_type . '.php';
			return $template;
		} else {
			return WPLPRO_DIR . '/templates/archive-' . $post_type . '.php';
		}
	}

	if ( is_single() && get_post_type() === $post_type ) {
		if ( file_exists( get_stylesheet_directory() . '/single-' . $post_type . '.php' ) ) {
			return $template;
		} else {
			return WPLPRO_DIR . '/templates/single-' . $post_type . '.php';
		}
	}

	return $template;
}

/**
 * WPLPRO Get Employee Details.
 *
 * @access public
 * @return string Formatted HTML block of employee details.
 */
function wplpro_employee_details() {
	global $post;

	$output = '';

	if ( get_post_meta( $post->ID, '_employee_title', true ) !== '' ) {
		$output .= sprintf( '<p class="title" itemprop="jobTitle">%s</p>', get_post_meta( $post->ID, '_employee_title', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_license', true ) !== '' ) {
		$output .= sprintf( '<p class="license">%s</p>', get_post_meta( $post->ID, '_employee_license', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_designations', true ) !== '' ) {
		$output .= sprintf( '<p class="designations" itemprop="awards">%s</p>', get_post_meta( $post->ID, '_employee_designations', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_phone', true ) !== '' ) {
		$output .= sprintf( '<p class="tel" itemprop="telephone"><span class="type">Office</span>: <span class="value">%s</span></p>', get_post_meta( $post->ID, '_employee_phone', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_mobile', true ) !== '' ) {
		$output .= sprintf( '<p class="tel" itemprop="telephone"><span class="type">Cell</span>: <span class="value">%s</span></p>', get_post_meta( $post->ID, '_employee_mobile', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_email', true ) !== '' ) {
		$email   = get_post_meta( $post->ID, '_employee_email', true );
		$output .= sprintf( '<p><a class="email" itemprop="email" href="mailto:%s">%s</a></p>', antispambot( $email ), antispambot( $email ) );
	}

	if ( get_post_meta( $post->ID, '_employee_website', true ) !== '' ) {
		$website         = get_post_meta( $post->ID, '_employee_website', true );
		$website_no_http = preg_replace( '#^https?://#', '', rtrim( $website, '/' ) );
		$output         .= sprintf( '<p><a class="website" itemprop="url" href="%s">%s</a></p>', $website, $website_no_http );
	}

	if ( get_post_meta( $post->ID, '_employee_city', true ) !== '' || get_post_meta( $post->ID, '_employee_address', true ) !== '' || get_post_meta( $post->ID, '_employee_state', true ) !== '' || get_post_meta( $post->ID, '_employee_zip', true ) !== '' ) {

		$address = '<p class="adr" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">';

		if ( get_post_meta( $post->ID, '_employee_address', true ) !== '' ) {
			$address .= '<span class="street-address" itemprop="streetAddress">' . get_post_meta( $post->ID, '_employee_address', true ) . '</span><br />';
		}

		if ( get_post_meta( $post->ID, '_employee_city', true ) !== '' ) {
			$address .= '<span class="locality" itemprop="addressLocality">' . get_post_meta( $post->ID, '_employee_city', true ) . '</span>, ';
		}

		if ( get_post_meta( $post->ID, '_employee_state', true ) !== '' ) {
			$address .= '<abbr class="region" itemprop="addressRegion">' . get_post_meta( $post->ID, '_employee_state', true ) . '</abbr> ';
		}

		if ( get_post_meta( $post->ID, '_employee_zip', true ) !== '' ) {
			$address .= '<span class="postal-code" itemprop="postalCode">' . get_post_meta( $post->ID, '_employee_zip', true ) . '</span>';
		}

		$address .= '</p>';

		if ( get_post_meta( $post->ID, '_employee_address', true ) !== '' || get_post_meta( $post->ID, '_employee_city', true ) !== '' || get_post_meta( $post->ID, '_employee_state', true ) !== '' || get_post_meta( $post->ID, '_employee_zip', true ) !== '' ) {
			$output .= $address;
		}
	}

	return $output;
}

/**
 * WPLPRO Employee Archive Details Boxes
 *
 * @access public
 * @return string Generated html for employee archive details.
 */
function wplpro_employee_archive_details() {
	global $post;

	$output = '';

	if ( get_post_meta( $post->ID, '_employee_title', true ) !== '' ) {
		$output .= sprintf( '<p class="title" itemprop="jobTitle">%s</p>', get_post_meta( $post->ID, '_employee_title', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_phone', true ) !== '' ) {
		$output .= sprintf( '<p class="tel" itemprop="telephone"><span class="type">Office</span>: <span class="value">%s</span></p>', get_post_meta( $post->ID, '_employee_phone', true ) );
	}

	if ( get_post_meta( $post->ID, '_employee_email', true ) !== '' ) {
		$email   = get_post_meta( $post->ID, '_employee_email', true );
		$output .= sprintf( '<p><a class="email" itemprop="email" href="mailto:%s">%s</a></p>', antispambot( $email ), antispambot( $email ) );
	}

	if ( function_exists( '_p2p_init' ) && function_exists( 'agentpress_listings_init' ) || function_exists( '_p2p_init' ) && function_exists( 'wplpro_init' ) ) {
		$listings = wplpro_get_connected_posts_of_type( 'agents_to_listings' );
		if ( ! empty( $listings ) ) {
			echo '<p><a class="agent-listings-link" href="' . esc_url( get_permalink() ) . '#agent-listings">View My Listings</a></p>';
		}
	}

	return $output;
}

/**
 * WPLPRO Employee Social Information.
 *
 * @access public
 * @return string   If employee has social information, a formatted HTMl block with their information.
 */
function wplpro_employee_social() {
	global $post;

	if ( get_post_meta( $post->ID, '_employee_facebook', true ) !== '' || get_post_meta( $post->ID, '_employee_twitter', true ) !== '' || get_post_meta( $post->ID, '_employee_linkedin', true ) !== '' || get_post_meta( $post->ID, '_employee_googleplus', true ) !== '' || get_post_meta( $post->ID, '_employee_pinterest', true ) !== '' || get_post_meta( $post->ID, '_employee_youtube', true ) !== '' || get_post_meta( $post->ID, '_employee_instagram', true ) !== '' ) {

		$output = '<div class="agent-social-profiles">';

		if ( get_post_meta( $post->ID, '_employee_facebook', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-facebook" rel="me" itemprop="sameAs" href="%s" title="Facebook Profile"></a>', get_post_meta( $post->ID, '_employee_facebook', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_twitter', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-twitter" rel="me" itemprop="sameAs" href="%s" title="Twitter Profile"></a>', get_post_meta( $post->ID, '_employee_twitter', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_linkedin', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-linkedin" rel="me" itemprop="sameAs" href="%s" title="LinkedIn Profile"></a>', get_post_meta( $post->ID, '_employee_linkedin', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_googleplus', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-google-plus" rel="me" itemprop="sameAs" href="%s" title="Google+ Profile"></a>', get_post_meta( $post->ID, '_employee_googleplus', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_pinterest', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-pinterest" rel="me" itemprop="sameAs" href="%s" title="Pinterest Profile"></a>', get_post_meta( $post->ID, '_employee_pinterest', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_youtube', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-youtube" rel="me" itemprop="sameAs" href="%s" title="YouTube Profile"></a>', get_post_meta( $post->ID, '_employee_youtube', true ) );
		}

		if ( get_post_meta( $post->ID, '_employee_instagram', true ) !== '' ) {
			$output .= sprintf( '<a class="fa fa-instagram" rel="me" itemprop="sameAs" href="%s" title="Instagram Profile"></a>', get_post_meta( $post->ID, '_employee_instagram', true ) );
		}

		$output .= '</div><!-- .employee-social-profiles -->';

		return $output;
	} // End if().
	return '';
}

/**
 * Displays the job type of a employee.
 *
 * @access public
 * @param mixed $post_id (default: null) Post ID.
 * @return Job Types.
 */
function wplpro_get_job_types( $post_id = null ) {

	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$employee_job_types = wp_get_object_terms( $post_id, 'job-types' );

	if ( empty( $employee_job_types ) || is_wp_error( $employee_job_types ) ) {
		return;
	}

	foreach ( $employee_job_types as $type ) {
		return $type->name;
	}
}

/**
 * Displays the office of a employee.
 *
 * @param int $post_id ID of the employee (Def. null).
 */
function wplpro_get_offices( $post_id = null ) {

	if ( null === $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$employee_occifcs = wp_get_object_terms( $post_id, 'occifcs' );

	if ( empty( $employee_occifcs ) || is_wp_error( $employee_occifcs ) ) {
		return;
	}

	foreach ( $employee_occifcs as $office ) {
		return $office->name;
	}
}

/**
 * WPLPRO Post Number.
 *
 * @access public
 * @param mixed $query Query.
 * @return void
 */
function wplpro_post_number( $query ) {

	if ( ! $query->is_main_query() || is_admin() || ! is_post_type_archive( 'employee' ) || ! is_post_type_archive( 'listing' ) ) {
		return;
	}

	$options = get_option( 'wplpro_plugin_settings' );

	$archive_posts_num = $options['wplpro_archive_posts_num'];

	if ( empty( $archive_posts_num ) ) {
		$archive_posts_num = '9';
	}

	$query->query_vars['posts_per_page'] = $archive_posts_num;

}
add_action( 'pre_get_posts', 'wplpro_post_number' );

/**
 * Add Employees to Jetpack Omnisearch.
 */
if ( class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
	new Jetpack_Omnisearch_Posts( 'employee' );
}

/**
 * Generate a Multiple post select for a specific post type.
 *
 * @param  [String] $select_id : id and name attribute for select field.
 * @param  [String] $post_type : Post type to populate.
 * @param  [Array]  $selected  : Array of selected posts.
 */
function wplpro_post_select( $select_id, $post_type, $selected = array() ) {
	// Grab posts.
	$posts = get_posts(
		array(
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'suppress_filters' => false,
			// TODO: Don't use -1, https://10up.github.io/Engineering-Best-Practices/php/.
			'posts_per_page'   => -1,
		)
	);

	// Print Select box.
	echo '<select name="' . esc_attr( $select_id ) . '" id="' . esc_attr( $select_id ) . '" multiple="multiple" class="feed-select widefat">';
	foreach ( $posts as $post ) {
		echo '<option value="', esc_attr( $post->ID ), '"', in_array( $post->ID, $selected ) ? ' selected="selected"' : '', '>', esc_html( $post->ID . ' - ' . $post->post_title ), '</option>';
	}
	echo '</select>';
}

/**
 * Strip all characters from price.
 *
 * @param  [String] $price : Price to strip.
 * @return [String]        : Price without chars.
 */
function wplpro_strip_price( $price ) {
	return sanitize_text_field( preg_replace( '/[^0-9.]/', '', $price ) );
}

<?php
/**
 * Support Shortcodes
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds shortcode to display listings
 * Adds shortcode to display post meta
 */
add_shortcode( 'listings', 'wplpro_shortcode' );

/**
 * WPL Pro Shortcode.
 *
 * @access public
 * @param mixed $atts ATTS.
 * @param mixed $content (default: null) Content.
 * @return Shortcode.
 */
function wplpro_shortcode( $atts, $content = null ) {

	$obj        = shortcode_atts(
		array(
			'id'       => '',
			'taxonomy' => '',
			'term'     => '',
			'limit'    => '',
			'columns'  => '',
		),
		$atts
	);
	$identifier = $obj['id'];
	$taxonomy   = $obj['taxonomy'];
	$term       = $obj['term'];
	$limit      = $obj['limit'];
	$columns    = $obj['columns'];

	 // If limit is empty set to all.
	if ( ! $limit ) {
		$limit = -1;
	}

	// If columns is empty set to 0.
	if ( ! $columns ) {
		$columns = 0;
	}

	// Query args based on parameters.
	$query_args = array(
		'post_type'      => 'listing',
		'posts_per_page' => $limit,
	);

	if ( $identifier ) {
		$query_args = array(
			'post_type' => 'listing',
			'post__in'  => explode( ',', $identifier ),
		);
	}

	if ( $term && $taxonomy ) {
		$query_args = array(
			'post_type'      => 'listing',
			'posts_per_page' => $limit,
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term,
				),
			),
		);
	}

	// Start Loop.
	global $post;

	$listings_array = get_posts( $query_args );

	$count = 0;

	$output = '<div class="wplpro wplpro-shortcode">';

	foreach ( $listings_array as $post ) :
		setup_postdata( $post );

		$count = ( $count === $columns ) ? 1 : $count + 1;

		$first_class = ( 1 === $count ) ? 'first' : '';

		$output .= '<div class="listing-wrap ' . get_column_class( $columns ) . ' ' . $first_class . '"><div class="listing-widget-thumb"><a href="' . get_permalink() . '" class="listing-image-link">' . get_the_post_thumbnail( $post->ID, 'listings' ) . '</a>';

		if ( '' !== wplpro_get_status() ) {
			$output .= '<span class="listing-status ' . strtolower( str_replace( ' ', '-', wplpro_get_status() ) ) . '">' . wplpro_get_status() . '</span>';
		}

		$output .= '<div class="listing-thumb-meta">';

		if ( '' !== get_post_meta( $post->ID, '_listing_text', true ) ) {
			$output .= '<span class="listing-text">' . get_post_meta( $post->ID, '_listing_text', true ) . '</span>';
		} elseif ( '' !== wplpro_get_property_types() ) {
			$output .= '<span class="listing-property-type">' . wplpro_get_property_types() . '</span>';
		}

		if ( '' !== get_post_meta( $post->ID, '_listing_price', true ) ) {
			$output .= '<span class="listing-price">' . get_post_meta( $post->ID, '_listing_price', true ) . '</span>';
		}

		$output .= '</div><!-- .listing-thumb-meta --></div><!-- .listing-widget-thumb -->';

		if ( '' !== get_post_meta( $post->ID, '_listing_open_house', true ) ) {
			$output .= '<span class="listing-open-house">' . __( 'Open House', 'wp-listings-pro' ) . ': ' . get_post_meta( $post->ID, '_listing_open_house', true ) . '</span>';
		}

		$output .= '<div class="listing-widget-details"><h3 class="listing-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		$output .= '<p class="listing-address"><span class="listing-address">' . wplpro_get_address() . '</span><br />';
		$output .= '<span class="listing-city-state-zip">' . wplpro_get_city() . ', ' . wplpro_get_state() . ' ' . get_post_meta( $post->ID, '_listing_zip', true ) . '</span></p>';

		if ( '' !== get_post_meta( $post->ID, '_listing_bedrooms', true ) || '' !== get_post_meta( $post->ID, '_listing_bathrooms', true ) || '' !== get_post_meta( $post->ID, '_listing_sqft', true ) ) {
			$output .= '<ul class="listing-beds-baths-sqft"><li class="beds">' . get_post_meta( $post->ID, '_listing_bedrooms', true ) . '<span>' . __( 'Beds', 'wp-listings-pro' ) . '</span></li> <li class="baths">' . get_post_meta( $post->ID, '_listing_bathrooms', true ) . '<span>' . __( 'Baths', 'wp-listings-pro' ) . '</span></li> <li class="sqft">' . get_post_meta( $post->ID, '_listing_sqft', true ) . '<span>' . __( 'Square Feet', 'wp-listings-pro' ) . '</span></li></ul>';
		}

		$output .= '</div><!-- .listing-widget-details --></div><!-- .listing-wrap -->';

	endforeach;

	$output .= '</div><!-- .wp-listings-shortcode -->';

	wp_reset_postdata();

	return $output;

}

add_shortcode( 'wp_listings_meta', 'wplpro_meta_shortcode' );

/**
 * Returns meta data for listings
 *
 * @param  array $atts meta key.
 * @return string meta value wrapped in span.
 */
function wplpro_meta_shortcode( $atts ) {
	$key    = shortcode_atts(
		array(
			'key' => '',
		),
		$atts
	)['key'];
	$postid = get_the_id();

	return '<span class=' . $key . '>' . get_post_meta( $postid, '_listing_' . $key, true ) . '</span>';
}


/**
 * Adds shortcode to display agent profiles.
 */
add_shortcode( 'employee_profiles', 'wplpro_profile_shortcode' );

/**
 * Profile Shortcode.
 *
 * @access public
 * @param mixed $atts ATTS.
 * @param mixed $content (default: null) Content.
 * @return Profile Shortcode.
 */
function wplpro_profile_shortcode( $atts, $content = null ) {

	$obj     = shortcode_atts(
		array(
			'id'      => '',
			'orderby' => 'menu_order',
			'order'   => 'ASC',
		),
		$atts
	);
	$id      = $obj['id'];
	$orderby = $obj['orderby'];
	$order   = $obj['order'];

	if ( '' === $id ) {
		$query_args = array(
			'post_type'      => 'employee',
			'posts_per_page' => -1,
			'orderby'        => $orderby,
			'order'          => $order,

		);
	} else {
		$query_args = array(
			'post_type'      => 'employee',
			'post__in'       => explode( ',', $id ),
			'posts_per_page' => -1,
			'orderby'        => $orderby,
			'order'          => $order,

		);
	}

	global $post;

	$profiles_array = get_posts( $query_args );

	$output = '';

	foreach ( $profiles_array as $post ) :
		setup_postdata( $post );

		$output .= '<div class="shortcode-agent-wrap">';
		$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'employee-thumbnail' ) . '</a>';
		$output .= '<div class="shortcode-agent-details"><a class="fn" href="' . get_permalink() . '">' . get_the_title() . '</a>';
		$output .= wplpro_employee_details();
		if ( function_exists( '_p2p_init' ) && function_exists( 'agentpress_listings_init' ) || function_exists( '_p2p_init' ) && function_exists( 'wplpro_init' ) ) {
			$has_listings = wplpro_has_listings( $post->ID );
			if ( ! empty( $has_listings ) ) {
				echo '<p><a class="agent-listings-link" href="' . esc_url( get_permalink() ) . '#agent-listings">View My Listings</a></p>';
			}
		}

		$output .= '</div>';
		$output .= wplpro_employee_social();

		$output .= '</div><!-- .shortcode-agent-wrap -->';

	endforeach;
	wp_reset_postdata();

	return $output;

}

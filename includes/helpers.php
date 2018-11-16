<?php
/**
 * Helpers
 *
 * @package WP-Listings-Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lists all the terms of a given taxonomy.
 *
 * Adds the taxonomy title and a list of the terms associated with that taxonomy
 * used in custom post type templates.
 *
 * @access public
 * @param mixed $taxonomy Taxonomy.
 * @return void
 */
function wplpro_list_terms( $taxonomy ) {
	$the_tax_object = get_taxonomy( $taxonomy );
	$terms          = get_terms( $taxonomy );
	$term_list      = '';

	$count = count( $terms );
	$i     = 0;
	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			$i++;
			$term_list .= '<li><a href="' . site_url( $taxonomy . '/' . $term->slug ) . '" title="' . sprintf( __( 'View all post filed under %s', 'gbd' ), $term->name ) . '">' . $term->name . ' (' . $term->count . ')</a></li>';
		}
		echo '<div class="' . esc_attr( $taxonomy ) . ' term-list-container">';
		echo '<h3 class="taxonomy-name">' . esc_html( $the_tax_object->label ) . '</h3>';
		echo '<ul class="term-list">' . $term_list . '</ul>';
		echo '</div> <!-- .' . esc_html( $taxonomy ) . ' .term-list-container -->'; // eh.
	}
}

/**
 * Uploads an image to media folder and attaches it to a post
 *
 * @param  [Mixed] $image   : Array with image data. Requires url, name, title, content, and description.
 * @param  [Mixed] $post_id : ID of post to atttach to. Send blank string if
 *                            you do not want to attach it to a post.
 * @return [Mixed]          : Post id of attachment on success, false on error.
 */
function wplpro_upload_image( $image, $post_id = '' ) {
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$attachment_id = false;
	$image_tmp     = download_url( $image['url'] );
	if ( is_wp_error( $image_tmp ) ) {
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			error_log( 'WPLPRO Image Import Fail' );
		}
	} else {
		$image_size = filesize( $image_tmp );
		// Download complete now upload in your project.
		$file = array(
			'name'     => sanitize_file_name( $image['name'] ),
			'type'     => 'image/jpg',
			'tmp_name' => $image_tmp,
			'error'    => 0,
			'size'     => $image_size,
		);

		// Set attachment data.
		$post_data = array(
			'post_title'   => sanitize_title( $image['title'] ),
			'post_content' => '',
			'post_status'  => 'inherit',
		);

		// This image/file will show on media page...
		$attachment_id = media_handle_sideload( $file, $post_id, $image['description'], $post_data );
	}

	return $attachment_id;
}

/**
 * Get Image ID by URL.
 *
 * @access public
 * @param mixed $image_url Image URL.
 * @return string Image ID.
 */
function wplpro_get_image_id( $image_url ) {
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
	if ( isset( $attachment[0] ) ) {
		return $attachment[0];
	}
}

/**
 * Returns true if the queried taxonomy is a taxonomy of the given post type
 *
 * @param string $post_type Post type.
 * @return bool                         ^^
 */
function wplpro_is_taxonomy_of( $post_type ) {
	$taxonomies  = get_object_taxonomies( $post_type );
	$queried_tax = get_query_var( 'taxonomy' );

	if ( in_array( $queried_tax, $taxonomies, true ) ) {
		return true;
	}

	return false;
}

/**
 * Display navigation to next/previous listing when applicable.
 *
 * @since 0.1.0
 */
function wplpro_post_nav_listing() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation listing-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Listing navigation', 'wp-listings-pro' ); ?></h1>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'wp-listings-pro' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav">Previous Listing</span>%title', 'wp-listings-pro' ) );
				next_post_link( '%link', __( '<span class="meta-nav">Next Listing</span>%title', 'wp-listings-pro' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Display navigation to next/previous employee when applicable.
 *
 * @since 0.1.0
 */
function wplpro_post_nav_employee() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation employee-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Agents navigation', 'wp-listings-pro' ); ?></h1>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'wp-listings-pro' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav">Previous Agent</span>%title', 'wp-listings-pro' ) );
				next_post_link( '%link', __( '<span class="meta-nav">Next Agent</span>%title', 'wp-listings-pro' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}


/**
 * Display navigation to next/previous set of listings when applicable.
 *
 * @since 0.1.0
 */
function wplpro_paging_nav_listing() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links(
		array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'wp-listings-pro' ),
			'next_text' => __( 'Next &rarr;', 'wp-listings-pro' ),
		)
	);

	if ( $links ) :

		?>
	<nav class="navigation archive-listing-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Listings navigation', 'wp-listings-pro' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination. -->
	</nav><!-- .navigation. -->
		<?php
	endif;
}
/**
 * Display navigation to next/previous set of employees when applicable.
 *
 * @since 0.1.0
 */
function wplpro_paging_nav_employee() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links(
		array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'wp-listings-pro' ),
			'next_text' => __( 'Next &rarr;', 'wp-listings-pro' ),
		)
	);

	if ( $links ) :

		?>
	<nav class="navigation archive-employee-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_attr_e( 'Agents navigation', 'wp-listings-pro' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
		<?php
	endif;
}

/**
 * Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 1.0.1
 *
 * @global array $_wp_add_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function wplpro_get_additional_image_sizes() {

	global $_wp_add_image_sizes;

	if ( $_wp_add_image_sizes ) {
		return $_wp_add_image_sizes;
	}

	return array();

}

/**
 * Set column classes based on parameter.
 *
 * @access public
 * @param mixed $columns Columns.
 * @return $column_class Column Class Name.
 */
function get_column_class( $columns ) {
	$column_class = '';

	// Max of six columns.
	$columns = ( $columns > 6 ) ? 6 : (int) $columns;

	// column class.
	switch ( $columns ) {
		case 0:
		case 1:
			$column_class = '';
			break;
		case 2:
			$column_class = 'one-half';
			break;
		case 3:
			$column_class = 'one-third';
			break;
		case 4:
			$column_class = 'one-fourth';
			break;
		case 5:
			$column_class = 'one-fifth';
			break;
		case 6:
			$column_class = 'one-sixth';
			break;
	}

	return $column_class;
}






/**
 * Returns an array of posts of connected $type.
 *
 * @param string $type the connected_type.
 * @return array|bool array of posts if any else false.
 */
function wplpro_get_connected_posts_of_type( $type ) {

	$connected = get_posts(
		array(
			'connected_type'  => $type,
			'connected_items' => get_queried_object(),
			'nopaging'        => true,
		)
	);

	if ( empty( $connected ) ) {
		return false;
	}

	return $connected;
}

/**
 * Returns an array of posts of connected $type using the $post object.
 * instead of get_queried_object().
 *
 * @param string $type the connected_type.
 * @param  int    $post the post id.
 * @return array|bool array of posts if any else false.
 */
function wplpro_get_connected_posts_of_type_archive( $type, $post ) {

	$connected = get_posts(
		array(
			'connected_type'  => $type,
			'connected_items' => $post,
			'nopaging'        => true,
		)
	);

	if ( empty( $connected ) ) {
		return false;
	}

	return $connected;
}

/**
 * Outputs markup for the connected listings on single agents.
 */
function wplpro_connected_listings_markup() {

	$count = 0;

	$listings = wplpro_get_connected_posts_of_type( 'agents_to_listings' );

	if ( empty( $listings ) ) {
		return;
	}

	echo apply_filters( 'wplpro_connected_listing_heading', $heading = '<h3><a name="agent-listings">My Listings</a></h3>' );

	// That's interesting, grab global $post.
	global $post;

	foreach ( $listings as $listing ) {

		setup_postdata( $listing );

		// $post = $listing;
		$thumb_id  = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src( $thumb_id, 'medium', true );

		$count++;

		if ( 4 === $count ) {
			$count = 1;
		}

		$class = ( 1 === $count ) ? ' first' : '';

		echo '
		<div class="one-third ', esc_attr( $class ), ' connected-listings" itemscope itemtype="https://schema.org/Offer">
			<a href="', esc_url( get_permalink( $listing->ID ) ), '"><img src="', esc_url( $thumb_url[0] ), '" alt="', esc_attr( get_the_title() ), ' photo" class="attachment-agent-profile-photo wp-post-image" itemprop="image" /></a>
			<h4 itemprop="itemOffered"><a class="listing-title" href="', esc_url( get_permalink( $listing->ID ) ), '" itemprop="url">', esc_html( get_the_title( $listing->ID ) ), '</a></h4>
			<p class="listing-price"><span class="label-price">Price: </span><span itemprop="price">', esc_html( get_post_meta( $listing->ID, '_listing_price', true ) ), '</span></p>
			<p class="listing-beds"><span class="label-beds">Beds: </span>', esc_html( get_post_meta( $listing->ID, '_listing_bedrooms', true ) ), '</p><p class="listing-baths"><span class="label-baths">Baths: </span>', esc_html( get_post_meta( $listing->ID, '_listing_bathrooms', true ) ),'</p>
		</div><!-- .connected-listings -->';
	}

	echo '<div class="clearfix"></div>';

	wp_reset_postdata();

}

/**
 * Check if the agent post has connected listings
 *
 * @param WP_Post $post Agent Post to check if there are listings.
 * @return bool                 Whether there are any connected listings.
 */
function wplpro_has_listings( $post ) {

	$listings = wplpro_get_connected_posts_of_type_archive( 'agents_to_listings', $post );

	if ( empty( $listings ) ) {
		return false;
	}
	return true;
}

/**
 * Outputs markup for the connected agents on single listings
 */
function wplpro_connected_agents_markup() {

	$profiles = wplpro_get_connected_posts_of_type( 'agents_to_listings' );

	if ( empty( $profiles ) ) {
		return;
	}

	echo apply_filters( 'wplpro_connected_agent_heading', $heading = '<h4>Listing Presented by:</h4>' );

	global $post;

	foreach ( $profiles as $profile ) {

		setup_postdata( $profile );

		// $post = $profile; // So ya know what, we just won't do it.
		$thumb_id  = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src( $thumb_id, 'agent-profile-photo', true );

		echo '
		<div ', post_class( 'connected-agents vcard' ), ' itemscope itemtype="https://schema.org/Person">
			<div class="agent-thumb"><a href="', esc_url( get_permalink( $profile->ID ) ), '"><img src="', esc_url( $thumb_url[0] ), '" alt="', esc_attr( get_the_title() ), ' photo" class="attachment-agent-profile-photo wp-post-image alignleft" itemprop="image" /></a></div><!-- .agent-thumb -->
			<div class="agent-details"><h5><a class="fn agent-name" itemprop="name" href="', esc_url( get_permalink( $profile->ID ) ), '">', esc_html( get_the_title( $profile->ID ) ), '</a></h5>';
			echo wplpro_employee_details();
			echo wplpro_employee_social();
		echo '</div><!-- .agent-details --></div><!-- .connected-agents .vcard -->';
	}

	echo '<div class="clearfix"></div>';

	wp_reset_postdata();
}

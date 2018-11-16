<?php
/**
 * The template for displaying Listing Archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP-Listings-Pro
 * @since 0.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Archive Listing Loop.
 *
 * @access public
 * @return void
 */
function wplpro_archive_listing_loop() {

	global $post;

	$count = 0; // Start counter at 0.

	while ( have_posts() ) :
		the_post();

		$count++; // add 1 to counter on each loop
		$first = ( 1 === $count ) ? 'first' : ''; // If counter is 1 add class of first.

		$loop = sprintf( '<div class="listing-widget-thumb"><a href="%s" class="listing-image-link">%s</a>', get_permalink(), get_the_post_thumbnail( $post->ID, 'listings' ) );

		if ( '' !== wplpro_get_status() ) {
			$loop .= sprintf( '<span class="listing-status %s">%s</span>', strtolower( str_replace( ' ', '-', wplpro_get_status() ) ), wplpro_get_status() );
		}

		$loop .= sprintf( '<div class="listing-thumb-meta">' );

		if ( '' !== get_post_meta( $post->ID, '_listing_text', true ) ) {
			$loop .= sprintf( '<span class="listing-text">%s</span>', get_post_meta( $post->ID, '_listing_text', true ) );
		} elseif ( '' !== wplpro_get_property_types() ) {
			$loop .= sprintf( '<span class="listing-property-type">%s</span>', wplpro_get_property_types() );
		}

		if ( '' !== get_post_meta( $post->ID, '_listing_price', true ) ) {
			$loop .= sprintf( '<span class="listing-price">%s</span>', get_post_meta( $post->ID, '_listing_price', true ) );
		}

		$loop .= sprintf( '</div><!-- .listing-thumb-meta --></div><!-- .listing-widget-thumb -->' );

		if ( '' !== get_post_meta( $post->ID, '_listing_open_house', true ) ) {
			$loop .= sprintf( '<span class="listing-open-house">Open House: %s</span>', get_post_meta( $post->ID, '_listing_open_house', true ) );
		}

		$loop .= sprintf( '<div class="listing-widget-details"><h3 class="listing-title"><a href="%s">%s</a></h3>', get_permalink(), get_the_title() );
		$loop .= sprintf( '<p class="listing-address"><span class="listing-address">%s</span><br />', wplpro_get_address() );
		$loop .= sprintf( '<span class="listing-city-state-zip">%s, %s %s</span></p>', wplpro_get_city(), wplpro_get_state(), get_post_meta( $post->ID, '_listing_zip', true ) );

		if ( '' !== get_post_meta( $post->ID, '_listing_bedrooms', true ) || '' !== get_post_meta( $post->ID, '_listing_bathrooms', true ) || '' !== get_post_meta( $post->ID, '_listing_sqft', true ) ) {
			$loop .= sprintf( '<ul class="listing-beds-baths-sqft"><li class="beds">%s<span>Beds</span></li> <li class="baths">%s<span>Baths</span></li> <li class="sqft">%s<span>Sq ft</span></li></ul>', get_post_meta( $post->ID, '_listing_bedrooms', true ), get_post_meta( $post->ID, '_listing_bathrooms', true ), get_post_meta( $post->ID, '_listing_sqft', true ) );
		}

		$loop .= sprintf( '</div><!-- .listing-widget-details -->' );

		$loop .= sprintf( '<a href="%s" class="button btn-primary more-link">%s</a>', get_permalink(), __( 'View Listing', 'wp-listings-pro' ) );

		/** Wrap in div with column class, and output. */
		printf( '<article id="post-%s" class="listing entry one-third %s"><div class="listing-wrap">%s</div><!-- .listing-wrap --></article><!-- article#post-## -->', esc_attr( get_the_id() ), esc_attr( $first ), apply_filters( 'wp_listings_featured_listings_widget_loop', $loop ) );

		if ( 3 === $count ) { // If counter is 3, reset to 0.
			$count = 0;
		}

		endwhile;
	if ( function_exists( 'equity' ) ) {
		equity_posts_nav();
	} elseif ( function_exists( 'genesis_init' ) ) {
		genesis_posts_nav();
	} else {
		wplpro_paging_nav_listing();
	}

}

if ( function_exists( 'equity' ) ) {

	add_filter( 'equity_pre_get_option_site_layout', '__equity_return_full_width_content' );
	remove_action( 'equity_entry_header', 'equity_post_info', 12 );
	remove_action( 'equity_entry_footer', 'equity_post_meta' );

	remove_action( 'equity_loop', 'equity_do_loop' );
	add_action( 'equity_loop', 'wplpro_archive_listing_loop' );

	equity();

} elseif ( function_exists( 'genesis_init' ) ) {

	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	remove_action( 'genesis_after_entry', 'genesis_do_author_box_single' );

	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'wplpro_archive_listing_loop' );

	genesis();

} else {

	get_header(); ?>

	<section id="primary" class="content-area container inner">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<?php
					$object = get_queried_object();

					if ( ! isset( $object->label ) ) {
						echo '<h1 class="archive-title">' . esc_html( $object->name ) . '</h1>';
					} else {
						echo '<h1 class="archive-title">' . esc_html( get_bloginfo( 'name' ) ) . ' Listings</h1>';
					}

					?>

					<small>
					<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' ); }
					?>
					</small>
				</header><!-- .archive-header -->

				<?php

				wplpro_archive_listing_loop();

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;

			?>

		</div><!-- #content -->
	</section><!-- #primary -->

	<?php
	get_sidebar( 'content' );
	get_sidebar();
	get_footer();

} // End if().

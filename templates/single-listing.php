<?php
/**
 * The Template for displaying all single listing posts
 *
 * @package WP-Listings-Pro
 * @since 0.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'wplpro_enqueue_single_listing_scripts' );


/**
 * Enqueue_single_listing_scripts function.
 *
 * @access public
 * @return void
 */
function wplpro_enqueue_single_listing_scripts() {
	wp_enqueue_style( 'wp-listings-single' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'bxslider' );

	wp_enqueue_script( 'fitvids', array( 'jquery' ), true, true );
	wp_enqueue_script( 'wp-listings-single', array( 'jquery, jquery-ui-tabs' ), true, true );
	wp_enqueue_script( 'bxslider', array( 'jquery' ), true, true );
}

/**
 * Single Listing Post Content.
 *
 * @access public
 * @return void
 */
function wplpro_single_listing_post_content() {

	global $post;
	$options = get_option( 'wplpro_plugin_settings' );

	?>
<div itemscope itemtype="https://schema.org/SingleFamilyResidence" class="entry-content wplistings-single-listing">

	<?php
	echo '<ul class="listing-meta">';
	if ( ! isset( $options['wplpro_currency_symbol'] ) ) {
		$options['wplpro_currency_symbol'] = '';
	}

	if ( 1 === get_post_meta( $post->ID, '_listing_hide_price', true ) ) {
		echo ( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ? sprintf( '<li class="listing-price">%s</li>', esc_html( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ) : '';
	} else {
		echo sprintf( '<li class="listing-price">%s %s %s</li>', '<span class="currency-symbol">' . esc_html( $options['wplpro_currency_symbol'] ) . '</span>', esc_html( get_post_meta( $post->ID, '_listing_price', true ) ), ( isset( $options['wplpro_display_currency_code'] ) && 1 === $options['wplpro_display_currency_code'] ) ? '<span class="currency-code">' . esc_html( $options['wplpro_currency_code'] ) . '</span>' : '' );
	}

	if ( '' !== wplpro_get_property_types() ) {
		echo sprintf( '<li class="listing-property-type"><span class="label">Property Type: </span>%s</li>', get_the_term_list( get_the_ID(), 'property-types', '', ', ', '' ) );
	}

	if ( '' !== wplpro_get_locations() ) {
		echo sprintf( '<li class="listing-location"><span class="label">Location: </span>%s</li>', get_the_term_list( get_the_ID(), 'locations', '', ', ', '' ) );
	}

	if ( '' !== get_post_meta( $post->ID, '_listing_bedrooms', true ) ) {
		echo sprintf( '<li class="listing-bedrooms"><span class="label">Beds: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_bedrooms', true ) ) );
	}

	if ( '' !== get_post_meta( $post->ID, '_listing_bathrooms', true ) ) {
		echo sprintf( '<li class="listing-bathrooms"><span class="label">Baths: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_bathrooms', true ) ) );
	}

	if ( '' !== get_post_meta( $post->ID, '_listing_sqft', true ) ) {
		echo sprintf( '<li class="listing-sqft"><span class="label">Sq Ft: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_sqft', true ) ) );
	}

	if ( '' !== get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) {
		echo sprintf( '<li class="listing-lot-sqft"><span class="label">Lot Sq Ft: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) );
	}

	echo sprintf( '</ul>' );

	echo ( get_post_meta( $post->ID, '_listing_courtesy', true ) ) ? '<p class="wp-listings-courtesy">' . esc_html( get_post_meta( $post->ID, '_listing_courtesy', true ) ) . '</p>' : '';

	?>
	<style type="text/css">
	ul.tabs {
		display: table;
		list-style-type: none;
		margin: 0;
		padding: 0;
	}

	ul.tabs>li {
		float: left;
		padding: 10px;
		background-color: lightgray;
	}

	ul.tabs>li:hover {
		background-color: lightgray;
	}

	ul.tabs>li.selected {
		background-color: lightgray;
	}

	div.content {
		border: 1px solid black;
	}

	ul { overflow: auto; }

	div.content { clear: both; }
	</style>

	<?php

	$listing_gallery = get_post_meta( $post->ID, '_listing_image_gallery', true );
	if ( ! empty( $listing_gallery ) ) {
		$attachments = array_filter( explode( ',', $listing_gallery ) );
		if ( ! empty( $attachments ) ) {
			echo '<ul class="bxslider">';
			foreach ( $attachments as $attachment_id ) {
				echo '<li><img src="';
				$url = wp_get_attachment_url( $attachment_id );

				echo esc_url( $url );

				echo '" /></li>';
			}
			echo '</ul>';
		}
	}
	?>

	<div id="listing-tabs" class="listing-data">

	<ul class="tabs">
	  <li><a href="#listing-description"><?php esc_html_e( 'Description', 'wp-listings-pro' ); ?></a></li>

	  <li><a href="#listing-details"><?php esc_html_e( 'Details', 'wp-listings-pro' ); ?></a></li>

		<?php
		if ( empty( $listing_gallery ) && get_post_meta( $post->ID, '_listing_gallery', true ) !== '' ) {
			?>
		<li><a href="#listing-gallery"><?php esc_html_e( 'Photos', 'wp-listings-pro' ); ?></a></li>
		<?php } ?>


		<?php if ( get_post_meta( $post->ID, '_listing_video', true ) !== '' ) { ?>
		<li><a href="#listing-video"><?php esc_html_e( 'Video / Virtual Tour', 'wp-listings-pro' ); ?></a></li>
		<?php } ?>

		<?php if ( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) !== '' ) { ?>
	  <li><a href="#listing-school-neighborhood"><?php esc_attr_e( 'Schools &amp; Neighborhood', 'wp-listings-pro' ); ?></a></li>
		<?php } ?>
	</ul>

	<div id="listing-description" itemprop="description">
		<?php
		the_content( __( 'View more <span class="meta-nav">&rarr;</span>', 'wp-listings-pro' ) );

		echo ( get_post_meta( $post->ID, '_listing_featured_on', true ) ) ? '<p class="wp_listings_featured_on">' . esc_html( get_post_meta( $post->ID, '_listing_featured_on', true ) ) . '</p>' : '';

		if ( get_post_meta( $post->ID, '_listing_disclaimer', true ) ) {
			echo '<p class="wp-listings-disclaimer">' . esc_html( get_post_meta( $post->ID, '_listing_disclaimer', true ) ) . '</p>';
		} elseif ( isset( $options['wplpro_global_disclaimer'] ) && '' !== $options['wplpro_global_disclaimer'] && null !== $options['wplpro_global_disclaimer'] ) {
			echo '<p class="wp-listings-disclaimer">' . esc_html( $options['wplpro_global_disclaimer'] ) . '</p>';
		}
		if ( ! isset( $options['wplpro_display_idx_link'] ) ) {
			$options['wplpro_display_idx_link'] = false;
		}
		if ( class_exists( 'Idx_Broker_Plugin' ) && true === $options['wplpro_display_idx_link'] && get_post_meta( $post->ID, '_listing_details_url', true ) ) {
			echo '<a href="' . esc_url( get_post_meta( $post->ID, '_listing_details_url', true ) ) . '" title="' . esc_attr( get_post_meta( $post->ID, '_listing_mls', true ) ) . '">View full listing details</a>';
		}
		?>
	</div><!-- #listing-description. -->

	<div id="listing-details">
		<?php
		$details_instance = new WP_Listings();

		echo '<table class="listing-details">';

		echo '<tbody class="left">';
		if ( get_post_meta( $post->ID, '_listing_hide_price', true ) === 1 ) {
			echo ( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ? '<tr class="wp_listings_listing_price"><td class="label">' . esc_html__( 'Price:', 'wp-listings-pro' ) . '</td><td>' . esc_html( get_post_meta( $post->ID, '_listing_price_alt', true ) ) . '</td></tr>' : '';
		} elseif ( get_post_meta( $post->ID, '_listing_price', true ) ) {
			echo '<tr class="wp_listings_listing_price"><td class="label">' . esc_html__( 'Price:', 'wp-listings-pro' ) . '</td><td><span class="currency-symbol">' . esc_html( $options['wplpro_currency_symbol'] ) . '</span>';
			echo esc_html( get_post_meta( $post->ID, '_listing_price', true ) ) . ' ';
			echo ( isset( $options['wplpro_display_currency_code'] ) && 1 === $options['wplpro_display_currency_code'] ? '<span class="currency-code">' . esc_html( $options['wplpro_currency_code'] ) . '</span>' : '' );
			echo '</td></tr>';
		}
		echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
		echo ( get_post_meta( $post->ID, '_listing_address', true ) ) ? '<tr class="wp_listings_listing_address"><td class="label">' . esc_html__( 'Address:', 'wp-listings-pro' ) . '</td><td itemprop="streetAddress">' . esc_html( get_post_meta( $post->ID, '_listing_address', true ) ) . '</td></tr>' : '';
		echo ( get_post_meta( $post->ID, '_listing_city', true ) ) ? '<tr class="wp_listings_listing_city"><td class="label">' . esc_html__( 'City:', 'wp-listings-pro' ) . '</td><td itemprop="addressLocality">' . esc_html( get_post_meta( $post->ID, '_listing_city', true ) ) . '</td></tr>' : '';
		echo ( get_post_meta( $post->ID, '_listing_county', true ) ) ? '<tr class="wp_listings_listing_county"><td class="label">' . esc_html__( 'County:', 'wp-listings-pro' ) . '</td><td>' . esc_html( get_post_meta( $post->ID, '_listing_county', true ) ) . '</td></tr>' : '';
		echo ( get_post_meta( $post->ID, '_listing_state', true ) ) ? '<tr class="wp_listings_listing_state"><td class="label">' . esc_html__( 'State:', 'wp-listings-pro' ) . '</td><td itemprop="addressRegion">' . esc_html( get_post_meta( $post->ID, '_listing_state', true ) ) . '</td></tr>' : '';
		echo ( get_post_meta( $post->ID, '_listing_zip', true ) ) ? '<tr class="wp_listings_listing_zip"><td class="label">' . esc_html__( 'Zip Code:', 'wp-listings-pro' ) . '</td><td itemprop="postalCode">' . esc_html( get_post_meta( $post->ID, '_listing_zip', true ) ) . '</td></tr>' : '';
		echo '</div>';
		echo ( get_post_meta( $post->ID, '_listing_mls', true ) ) ? '<tr class="wp_listings_listing_mls"><td class="label">MLS:</td><td>' . esc_html( get_post_meta( $post->ID, '_listing_mls', true ) ) . '</td></tr>' : '';
		echo '</tbody>';

		echo '<tbody class="right">';
		foreach ( (array) $details_instance->property_details['col2'] as $label => $key ) {
			$detail_value = get_post_meta( $post->ID, $key, true );
			if ( ! empty( $detail_value ) ) :
				printf( '<tr class="wp_listings%s"><td class="label">%s</td><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
			  endif;
		}
		echo '</tbody>';

		echo '</table>';

		echo '<table class="listing-details extended">';
		echo '<tbody class="left">';
		foreach ( (array) $details_instance->extended_property_details['col1'] as $label => $key ) {
			$detail_value = get_post_meta( $post->ID, $key, true );
			if ( ! empty( $detail_value ) ) :
				printf( '<tr class="wp_listings%s"><td class="label">%s</td><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
			  endif;
		}
		echo '</tbody>';
		echo '<tbody class="right">';
		foreach ( (array) $details_instance->extended_property_details['col2'] as $label => $key ) {
			$detail_value = get_post_meta( $post->ID, $key, true );
			if ( ! empty( $detail_value ) ) :
				printf( '<tr class="wp_listings%s"><td class="label">%s</td><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
			  endif;
		}
		echo '</tbody>';
		echo '</table>';

		if ( get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' ) !== null ) {
			echo '<h5>' . esc_html__( 'Tagged Features:', 'wp-listings-pro' ) . '</h5><ul class="tagged-features">';
			echo get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' );
			echo '</ul><!-- .tagged-features -->';
		}

		if ( get_post_meta( $post->ID, '_listing_home_sum', true ) !== '' || get_post_meta( $post->ID, '_listing_kitchen_sum', true ) !== '' || get_post_meta( $post->ID, '_listing_living_room', true ) !== '' || get_post_meta( $post->ID, '_listing_master_suite', true ) !== '' ) {
			?>
			<div class="additional-features">
			  <h4>Additional Features</h4>
			  <h6 class="label"><?php esc_attr_e( 'Home Summary', 'wp-listings-pro' ); ?></h6>
			  <p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_home_sum', true ) ); ?></p>
			  <h6 class="label"><?php esc_attr_e( 'Kitchen Summary', 'wp-listings-pro' ); ?></h6>
			  <p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_kitchen_sum', true ) ); ?></p>
			  <h6 class="label"><?php esc_attr_e( 'Living Room', 'wp-listings-pro' ); ?></h6>
			  <p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_living_room', true ) ); ?></p>
			  <h6 class="label"><?php esc_attr_e( 'Master Suite', 'wp-listings-pro' ); ?></h6>
			  <p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_master_suite', true ) ); ?></p>
			</div><!-- .additional-features -->
			<?php
		}
		?>

	</div><!-- #listing-details -->

	<?php if ( empty( $listing_gallery ) && get_post_meta( $post->ID, '_listing_gallery', true ) ) { ?>
	<div id="listing-gallery">
			<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_gallery', true ) ); ?>
	</div><!-- #listing-gallery -->

	<?php } ?>

	<?php	if ( get_post_meta( $post->ID, '_employee_responsibility', true ) !== '' ) { ?>
	<div id="listing-agent-assignments">
			<p><?php esc_html_e( 'This listing is managed by', 'wp-listings-pro' ); ?></p>
		<?php
		$ids = explode( ',', get_post_meta( $post->ID, '_employee_responsibility', true ) );
		foreach ( $ids as $agent_id ) {
			echo '<p><img style="min-height: 150px;min-width: 120px;max-width: 120px;max-height: 150px;margin-bottom: 10px;" src="' . esc_url( get_the_post_thumbnail_url( $agent_id ) ) . '" alt="Employee Thumbnail"/><br>';
			echo esc_html( get_post_meta( $agent_id, '_employee_first_name', true ) . ' ' . get_post_meta( $agent_id, '_employee_last_name', true ) ) . '.</p>';
		}
		?>
	</div>
	<?php } ?>

	<?php if ( get_post_meta( $post->ID, '_listing_video', true ) !== '' ) { ?>
	<div id="listing-video">
	  <div class="iframe-wrap">
		<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_video', true ) ); ?>
	  </div>
	</div><!-- #listing-video -->
	<?php } ?>

	<?php if ( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) !== '' ) { ?>
	<div id="listing-school-neighborhood">
	  <p>
		<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) ); ?>
	  </p>
	</div><!-- #listing-school-neighborhood -->
	<?php } ?>

	</div><!-- #listing-tabs.listing-data -->

	<?php
	if ( get_post_meta( $post->ID, '_listing_map', true ) !== '' ) {
		echo '<div id="listing-map"><h3>Location Map</h3>';
		echo do_shortcode( get_post_meta( $post->ID, '_listing_map', true ) );
		echo '</div><!-- .listing-map -->';
	} elseif ( get_post_meta( $post->ID, '_listing_latitude', true ) && get_post_meta( $post->ID, '_listing_longitude', true ) && get_post_meta( $post->ID, '_listing_automap', true ) === 'y' ) {

		$map_info_content = sprintf( '<p style="font-size: 14px; margin-bottom: 0;">%s<br />%s %s, %s</p>', get_post_meta( $post->ID, '_listing_address', true ), get_post_meta( $post->ID, '_listing_city', true ), get_post_meta( $post->ID, '_listing_state', true ), get_post_meta( $post->ID, '_listing_zip', true ) );
	}
	?>

	<div id="listing-contact">

	<?php

	if ( get_post_meta( $post->ID, '_listing_contact_form', true ) !== '' ) {

		echo do_shortcode( get_post_meta( $post->ID, '_listing_contact_form', true ) );

	} elseif ( isset( $options['wplpro_default_form'] ) && '' !== $options['wplpro_default_form'] ) {

		echo do_shortcode( $options['wplpro_default_form'] );

	}
}

?>
	  </div><!-- .listing-contact -->

	</div><!-- .entry-content -->


<?php

if ( function_exists( 'equity' ) ) {

	remove_action( 'equity_entry_header', 'equity_post_info', 12 );
	remove_action( 'equity_entry_footer', 'equity_post_meta' );

	remove_action( 'equity_entry_content', 'equity_do_post_content' );
	add_action( 'equity_entry_content', 'wplpro_single_listing_post_content' );

	equity();

} elseif ( function_exists( 'genesis_init' ) ) {

	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 ); // HTML5.
	remove_action( 'genesis_before_post_content', 'genesis_post_info' ); // XHTML.
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' ); // HTML5.
	remove_action( 'genesis_after_post_content', 'genesis_post_meta' ); // XHTML.
	remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 ); // HTML5.
	remove_action( 'genesis_after_post', 'genesis_do_author_box_single' ); // XHTML.

	remove_action( 'genesis_entry_content', 'genesis_do_post_content' ); // HTML5.
	remove_action( 'genesis_post_content', 'genesis_do_post_content' ); // XHTML.
	add_action( 'genesis_entry_content', 'wplpro_single_listing_post_content' ); // HTML5.
	add_action( 'genesis_post_content', 'wplpro_single_listing_post_content' ); // XHTML.

	genesis();

} else {

	$options = get_option( 'wplpro_plugin_settings' );

	get_header();
	if ( isset( $options['wplpro_custom_wrapper'] ) && isset( $options['wplpro_start_wrapper'] ) && '' !== $options['wplpro_start_wrapper'] ) {
		echo $options['wplpro_start_wrapper'];
	} else {
		echo '<div id="primary" class="content-area container inner">
			<div id="content" class="site-content" role="main">';
	}

		// Start the Loop.
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
				<small>
				<?php
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' ); }
				?>
				</small>
				<div class="entry-meta">
					<?php
					if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
						?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wp-listings-pro' ), __( '1 Comment', 'wp-listings-pro' ), __( '% Comments', 'wp-listings-pro' ) ); ?></span>
						<?php
					endif;

					edit_post_link( __( 'Edit', 'wp-listings-pro' ), '<span class="edit-link">', '</span>' );
					?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->


		<?php wplpro_single_listing_post_content(); ?>

		</article><!-- #post-ID -->

		<?php
		// Previous/next post navigation.
		wplpro_post_nav_listing();

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		endwhile;

	if ( isset( $options['wplpro_custom_wrapper'] ) && isset( $options['wplpro_end_wrapper'] ) && '' !== $options['wplpro_end_wrapper'] ) {
		echo $options['wplpro_end_wrapper'];
	} else {
		echo '</div><!-- #content -->
		</div><!-- #primary -->';
	}

	get_sidebar();
	get_footer();

} // End if().

<?php
/**
 * Welcome Page View
 *
 * @since 1.0.0
 * @package WPW
 */

if ( ! defined( 'WPINC' ) ) {

	die;

}
wplpro_import_image_gallery();
?>
<style>
	/* Logo */
.svg .wp-badge.welcome__logo {
	background: url('') center 24px no-repeat #0092f9;
	background-size: contain;
	color: #fff;
}

/* Responsive Youtube Video*/
.embed-container {
	height: 0;
	max-width: 100%;
	overflow: hidden;
	padding-bottom: 56.25%;
	position: relative;
}

.embed-container iframe,
.embed-container object,
.embed-container embed {
	top: 0;
	height: 100%;
	left: 0;
	position: absolute;
	width: 100%;
}

</style>

<div class="wrap about-wrap">

	<h1><?php printf( __( 'WP Listings Pro &nbsp; %s', 'wp-listings-pro' ), WPLPRO_VERSION ); ?></h1>

	<div class="about-text">
		<?php printf( __( 'Manage your listings right from WordPress.', 'wp-listings-pro' ), WPLPRO_VERSION ); ?>
	</div>

	<div class="wp-badge welcome__logo"></div>

	<div class="feature-section one-col">
		<h3><?php _e( 'Get Started', 'wp-listings-pro' ); ?></h3>
		<ul>
			<li><strong><?php _e( 'Step #1:', 'wp-listings-pro' ); ?></strong> <?php _e( 'Review your Settings.', 'wp-listings-pro' ); ?></li>
			<li><strong><?php _e( 'Step #2:', 'wp-listings-pro' ); ?></strong> <?php _e( 'Deactivate and remove the IMPress Plugins.', 'wp-listings-pro' ); ?></li>
			<li><strong><?php _e( 'Step #3:', 'wp-listings-pro' ); ?></strong> <?php _e( 'Check out Real Estate Pro.', 'wp-listings-pro' ); ?></li>
		</ul>
	 </div>

	<div class="feature-section one-col">
		<h3><?php _e( 'What is Inside?', 'wp-listings-pro' ); ?></h3>
		<div class="headline-feature feature-video">
			<div class='embed-container'>
				<iframe src='https://www.youtube.com/embed/3RLE_vWJ73c' frameborder='0' allowfullscreen></iframe>
			</div>
		</div>
	</div>

	<div class="feature-section two-col">
		<div class="col">
			<img src="http://placehold.it/600x180/0092F9/fff?text=WELCOME" />
			<h3><?php _e( 'Why use 3 plugins, when you can use one?', 'wp-listings-pro' ); ?></h3>
			<p><?php _e( 'Before you needed multiple plugins to manage your agents, listings and link them together. Switching to WP Listings Pro, its the only plugin you need.', 'wp-listings-pro' ); ?></p>
		</div>
		<div class="col">
			<img src="http://placehold.it/600x180/0092F9/fff?text=WELCOME" />
			<h3><?php _e( 'Import your Listings and Agents from IDX Broker', 'wp-listings-pro' ); ?></h3>
			<p><?php _e( 'The IMPress Plugins limited to importing a single image, on top of that you could only import your featured properties, unless you are using the Equity Theme from Agent Evolution (A IDX Broker Company). WP-Listings-Pro aims to fix that, we import all of your images, and all properties available via the IDX Broker API.', 'wp-listings-pro' ); ?></p>
		</div>
	</div>

	<div class="feature-section two-col">
		<div class="col">
			<img src="http://placehold.it/600x180/0092F9/fff?text=WELCOME" />
			<h3><?php _e( 'Always Open Source & Free', 'wp-listings-pro' ); ?></h3>
			<p><?php _e( 'Our goal is to keep this plugin open source and free.', 'wp-listings-pro' ); ?></p>
		</div>

		<div class="col">
			<img src="http://placehold.it/600x180/0092F9/fff?text=WELCOME" />
			<h3><?php _e( 'Better Listing Gallery', 'wp-listings-pro' ); ?></h3>
			<p><?php _e( 'We have updated the Listings Gallery feature to use the WordPress Media Gallery. You can now easily upload, and re-order your listings images.', 'wp-listings-pro' ); ?></p>
		</div>
	</div>

</div>

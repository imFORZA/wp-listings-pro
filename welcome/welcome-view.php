<?php
/**
 * Welcome Page View
 *
 * @since 1.0.0
 * @package WPW
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	<h1><?php esc_attr_e( 'WP Listings Pro', 'wp-listings-pro' ); ?></h1>

	<div class="about-text">
		<?php esc_attr_e( 'Manage your listings right from WordPress.', 'wp-listings-pro' ); ?>
	</div>

	<!-- <div class="wp-badge welcome__logo"></div> -->

	<div class="feature-section one-col">
		<h3><?php esc_attr_e( 'Welcome to WordPress Listings Professional.', 'wp-listings-pro' ); ?></h3>
		<ul>
			<?php /* Thought about having this open in a new tab, but https://www.thesitewizard.com/html-tutorial/open-links-in-new-window-or-tab.shtml made a good case against that */ ?>
			<li><strong><?php esc_attr_e( 'Step #1:', 'wp-listings-pro' ); ?></strong> <a href="/wp-admin/options-general.php?page=wp-listings-settings"><?php esc_attr_e( 'Review your Settings.', 'wp-listings-pro' ); ?></a></li>
			<li><strong><?php esc_attr_e( 'Step #2:', 'wp-listings-pro' ); ?></strong> <?php esc_attr_e( 'Add your IDX Broker API Key to your settings.', 'wp-listings-pro' ); ?> </li>
			<li><strong><?php esc_attr_e( 'Step #3:', 'wp-listings-pro' ); ?></strong> <?php esc_attr_e( 'Import any listings and agents with the IDX Import Tool.', 'wp-listings-pro' ); ?></li>
			<li><strong><?php esc_attr_e( 'Step #4:', 'wp-listings-pro' ); ?></strong> <?php esc_attr_e( 'Run a manual IDX update from the settings page (recommended).', 'wp-listings-pro' ); ?> </li>
		</ul>
	</div>

<!--
	<div class="feature-section one-col">
		<h3><?php esc_attr_e( 'Get Started', 'wp-listings-pro' ); ?></h3>
		<div class="headline-feature feature-video">
			<div class='embed-container'>
				<iframe src='https://www.youtube.com/embed/RY7jxSeMIsI' frameborder='0' allowfullscreen></iframe>
			</div>
		</div>
	</div>
	-->

	<div class="feature-section two-col">
		<div class="col">
			<img src="https://placehold.it/600x180/0092F9/fff?text=ONE%20PLACE" />
			<h3><?php esc_attr_e( 'Why use 3 plugins, when you can use one?', 'wp-listings-pro' ); ?></h3>
			<p><?php esc_attr_e( 'Before you needed multiple plugins to manage your agents, listings and link them together. Switching to WP Listings Pro, its the only plugin you need.', 'wp-listings-pro' ); ?></p>
		</div>
		<div class="col">
			<img src="https://placehold.it/600x180/0092F9/fff?text=IDX%20SUPPORT" />
			<h3><?php esc_attr_e( 'Import your Listings and Agents from IDX Broker', 'wp-listings-pro' ); ?></h3>
			<p><?php esc_attr_e( 'The previous IMPress Plugins limited you to importing a single image, and on top of that you could only import your featured properties. WP-Listings-Pro aims to fix that, we import all of your images, and all properties available via the IDX Broker API.', 'wp-listings-pro' ); ?></p>
		</div>
	</div>

	<div class="feature-section two-col">
		<div class="col">
			<img src="https://placehold.it/600x180/0092F9/fff?text=MORE%20DATA" />
			<h3><?php esc_attr_e( 'More Fields, More Options', 'wp-listings-pro' ); ?></h3>
			<p><?php esc_attr_e( 'We have already begun to add more fields that are commonly requested by Real Estate Agents.', 'wp-listings-pro' ); ?></p>
		</div>

		<div class="col">
			<img src="https://placehold.it/600x180/0092F9/fff?text=BETTER%20IMAGES" />
			<h3><?php esc_attr_e( 'Better Listing Gallery', 'wp-listings-pro' ); ?></h3>
			<p><?php esc_attr_e( 'We have updated the Listings Gallery feature to use the WordPress Media Gallery, instead of a plaintext paragraph that\'s worse than using Microsoft Word for image formatting. You can now easily upload, and re-order your listings images.', 'wp-listings-pro' ); ?></p>
		</div>
	</div>

</div>

<?php

add_action( 'admin_menu', 'wplpro_menu' );

		/**
		 * wplpro_menu function.
		 *
		 * @access public
		 * @return void
		 */
function wplpro_menu() {
	add_menu_page( 'WP Listings Pro', 'WP Listings Pro', 'manage_options', 'wp-listings-pro', 'wplpro_settings_page' );
}

		/**
		 * wplpro_output_submenu function.
		 *
		 * @access public
		 * @param mixed $tab
		 * @param array $submenu_links (default: array())
		 * @return void
		 */
function wplpro_output_submenu( $tab, $submenu_links = array() ) {

	echo '<ul>';
	foreach ( $submenu_links as $submenu_link ) {

		if ( $submenu_link == wplpro_menu_active_subtab() ) {
			$active = 'active';
		} else {
			$active = '';
		}

		echo '<li class="submenu-tab ' . $active . '"><a href="/wp-admin/admin.php?page=wp-listings-pro&tab=' . $tab . '&subtab=' . $submenu_link . '">' . $submenu_link . '</a></li>';
	}
	echo '</ul>';

}

/**
 * Function to get the current active tab.
 *
 * @access private
 * @return String
 */
function wplpro_menu_active_tab() {
	$active_tab = filter_input( INPUT_GET, 'tab' );
	return isset( $active_tab ) ? $active_tab : 'account';
}

/**
 * wplpro_menu_active_subtab function.
 *
 * @access public
 * @return void
 */
function wplpro_menu_active_subtab() {
	$active_subtab = filter_input( INPUT_GET, 'subtab' );
	return isset( $active_subtab ) ? $active_subtab : '';
}



		/**
		 * settings_page function.
		 *
		 * @access public
		 * @return void
		 */
function wplpro_settings_page() {

		$active_tab = idxbrokerpro_menu_active_tab() ?? '';

	$tabs = array( 'Intro', 'listings', 'employees', 'integrations', 'settings', 'support' );

	?>
	<div class="wrap settings">
		<form method="post" action="options.php">
			<h1>WP Listings Pro - <?php echo ucwords( $active_tab ); ?></h1>
			<style>
				.nav-tab-mls {
					text-transform: uppercase;
				}
				.submenu-tab {
					display: inline-block;
					margin: 0 10px 0 0;
					border: 1px solid #CCC;
					padding: 10px;
					background: #e5e5e5;
				}
				.submenu-tab a {
					text-transform: capitalize;
					text-decoration: none;
					font-weight: 600;
					color: #555;
				}
				.submenu-tab a:focus {
					box-shadow: none;
				}
				li.submenu-tab.active {
					background: none;
				}
				li.submenu-tab.active a {
					color: #000;
				}
			</style>

			<h2 class="nav-tab-wrapper">
		<?php

		foreach ( $tabs as $tab ) {
			if ( $tab === $active_tab ) {
				$active_tab_class = 'nav-tab-active';
			} else {
				$active_tab_class = '';
			}
				echo '<a href="?page=wp-listings-pro&#38;tab=' . $tab . '" class="nav-tab ' . $active_tab_class . ' nav-tab-' . $tab . '">' . ucwords( $tab ) . '</a>';
		}
		?>

			</h2>	<div class="wrap">

	<?php

	if ( $active_tab && file_exists( 'settings/' . $active_tab . '.php' ) ) {

		include_once 'settings/' . $active_tab . '.php';

	} else {
		echo 'Coming Soon.';
	}

	echo '</div>';

}

<?php
if ( ! defined( 'ABSPATH' ) ) { exit;
}
if ( isset( $_GET['settings-updated'] ) ) { ?>
	<div id="message" class="updated">
		<p><strong><?php _e( 'Settings saved.','wp-listings-pro' ); ?></strong></p>
	</div>
<?php
}

?>
<div id="icon-options-general" class="icon32"></div>
<div class="wrap">
	<h1><?php _e( 'Agents Settings', 'wp-listings-pro' ); ?></h1>
	<hr>
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div id="side-info-column" class="inner-sidebar">
		<?php // do_meta_boxes('wplpro-agents-options', 'side', null); ?>
		</div>

		<div id="post-body">
			<div id="post-body-content" class="has-sidebar-content">

				<?php $options = get_option( 'plugin_wplpro_agents_settings' );

				$defaults = array(
					'wplpro_stylesheet_load'         => 0,
					'wplpro_archive_posts_num'       => 9,
					'wplpro_slug'                    => 'employees',
					'wplpro_custom_wrapper'          => 0,
					'wplpro_start_wrapper'           => '',
					'wplpro_end_wrapper'             => '',
					);

				foreach ( $defaults as $name => $value ) {
					if ( ! isset( $options[ $name ] ) ) {
						$options[ $name ] = $value;
					}
				}

				if ( $options['wplpro_stylesheet_load'] == 1 ) {
					echo '<p style="color:red; font-weight: bold;">The plugin\'s main stylesheet (wplpro-agents.min.css) has been deregistered<p>';
				}
				?>
				<form action="options.php" method="post" id="wplpro-agents-settings-options-form">
					<?php
					settings_fields( 'wplpro_options' );


					_e( '<h3>Include CSS?</h3>', 'wp-listings-pro' );
					_e( '<p>Here you can deregister the Agents CSS files and move to your theme\'s css file for ease of customization</p>', 'wp-listings-pro' );
					_e( '<p><input name="plugin_wplpro_agents_settings[wplpro_stylesheet_load]" id="wplpro_stylesheet_load" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_stylesheet_load'], false ) . ' /> Deregister IMPress Agents main CSS (wplpro-agents.css)?</p>', 'wplpro-agents' );

					_e( "<h3>Default Number of Posts</h3><p>The default number of posts displayed on a employee archive page is 9. Here you can set a custom number. Enter <span style='color: #f00;font-weight: 700;'>-1</span> to display all employee posts.<br /><em>If you have more than 20-30 posts, it's not recommended to show all or your page will load slow.</em></p>", 'wp-listings-pro' );
				    _e( '<p>Number of posts on employee archive page: <input name="plugin_wplpro_agents_settings[wplpro_archive_posts_num]" id="wplpro_archive_posts_num" type="text" value="' . $options['wplpro_archive_posts_num'] . '" size="1" /></p><hr>', 'wplpro-agents' );


					_e( "<h3>Custom Wrapper</h3><p>If your theme's content HTML ID's and Classes are different than the included template, you can enter the HTML of your content wrapper beginning and end:</p>", 'wp-listings-pro' );
					_e( '<p><label><input name="plugin_wplpro_agents_settings[wplpro_custom_wrapper]" id="wplpro_custom_wrapper" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_custom_wrapper'], false ) . ' /> Use Custom Wrapper?</p>', 'wplpro-agents' );
				    _e( '<p><label>Wrapper Start HTML: </p><input name="plugin_wplpro_agents_settings[wplpro_start_wrapper]" id="wplpro_start_wrapper" type="text" value="' . esc_html( $options['wplpro_start_wrapper'] ) . '" size="80" /></label>', 'wplpro-agents' );
				    _e( '<p><label>Wrapper End HTML: </p><input name="plugin_wplpro_agents_settings[wplpro_end_wrapper]" id="wplpro_end_wrapper" type="text" value="' . esc_html( $options['wplpro_end_wrapper'] ) . '" size="80" /></label><hr>', 'wplpro-agents' );


					_e( '<h3>Directory slug</h3><p>Optionally change the slug of the employee post type<br /><input type="text" name="plugin_wplpro_agents_settings[wplpro_slug]" value="' . $options['wplpro_slug'] . '" /></p>', 'wplpro-agents' );
					_e( "<em>Don't forget to <a href='../wp-admin/options-permalink.php'>reset your permalinks</a> if you change the slug!</em></p>", 'wplpro-agents' );

					?>
					<input name="submit" class="button-primary" type="submit" value="<?php esc_attr_e( 'Save Settings' ); ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
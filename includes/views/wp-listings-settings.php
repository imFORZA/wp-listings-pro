<?php
/**
 * Page for WP-Listings Settings
 *
 * @package wp-listings-pro
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( isset( $_GET['settings-updated'] ) ) {

	?>
	<div id="message" class="updated">
		<p><strong><?php esc_html_e( 'Settings saved.', 'wp-listings-pro' ); ?></strong></p>
	</div>
	<?php
}

?>
<div id="icon-options-general" class="icon32"></div>
<div class="wrap">
	<h1><?php esc_html_e( 'WPL Pro', 'wp-listings-pro' ); ?></h1>
	<hr>
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div id="side-info-column" class="inner-sidebar">
		<?php do_meta_boxes( 'wp-listings-options', 'side', null ); ?>
		</div>

		<div id="post-body">
			<div id="post-body-content" class="has-sidebar-content">

				<?php
				$options = get_option( 'wplpro_plugin_settings' );

				$defaults = array(
					'disable_css'                  => 0,
					'disable_fontawesome'          => 0,
					'disable_properticons'         => 0,
					'wplpro_currency_symbol'       => '',
					'wplpro_currency_code'         => '',
					'wplpro_display_currency_code' => 0,
					'wplpro_archive_posts_num'     => 9,
					'wplpro_global_disclaimer'     => '',
					'wplpro_listings_slug'         => 'listing',
					'wplpro_employees_slug'        => 'employee',
					'wplpro_default_form'          => '',
					'wplpro_custom_wrapper'        => 0,
					'wplpro_start_wrapper'         => '',
					'wplpro_end_wrapper'           => '',
					'wplpro_idx_update'            => 'update-all',
					'wplpro_idx_update_agents'     => 'update-all',
					'wplpro_custom_sync_featured'  => 0,
					'wplpro_custom_sync_gallery'   => 0,
					'wplpro_custom_sync_details'   => 0,
					'wplpro_idx_sold'              => 'sold-keep',
					'wplpro_display_idx_link'      => 0,
					'wplpro_import_author'         => 0,
					'wplpro_uninstall_delete'      => 0,
				);

				foreach ( $defaults as $name => $value ) {
					if ( ! isset( $options[ $name ] ) ) {
						$options[ $name ] = $value;
					}
				}

				if ( ! isset( $options['wplpro_stylesheet_load'] ) ) {
					$options['wplpro_stylesheet_load'] = 0;
				}
				if ( 1 === $options['wplpro_stylesheet_load'] ) {
					echo '<p style="color:red; font-weight: bold;">The plugin\'s main stylesheet (wp-listings.min.css) has been deregistered<p>';
				}

				if ( ! isset( $options['wplpro_widgets_stylesheet_load'] ) ) {
					$options['wplpro_widgets_stylesheet_load'] = 0;
				}
				if ( 1 === $options['wplpro_widgets_stylesheet_load'] ) {
					echo '<p style="color:red; font-weight: bold;">The plugin\'s widget stylesheet (wp-listings-widgets.min.css) has been deregistered<p>';
				}
				?>
				<form action="options.php" method="post" id="wp-listings-settings-options-form">
					<?php
					settings_fields( 'wp_listings_options' );

					if ( isset( $options['wplpro_api_key'] ) || get_option( 'idx_broker_apikey' ) !== false ) {
						?>
						<h3>Update Listings and Employees</h3>
						<input name="submit" type="submit" value="Sync now" class="button-primary" id="sync-idx-settings-now"></input>
						<?php
					}

					if ( ! isset( $options['wplpro_api_key'] ) && get_option( 'idx_broker_apikey' ) !== false ) {
						$options['wplpro_api_key'] = get_option( 'idx_broker_apikey' );
						update_option( 'wplpro_plugin_settings', $options );
					}

					_e( '<h4>IDX Broker API Key</h4><p>For this plugin to be able to import listings/agents, an API key is required.</p>', 'wp-listings-pro' );
					_e( '<p>API Key: <input name="wplpro_plugin_settings[wplpro_api_key]" id="wplpro_default_form" type="text" value="' . esc_html( ( isset( $options['wplpro_api_key'] ) ? $options['wplpro_api_key'] : '' ) ) . '" size="40" /></p><hr>', 'wp-listings-pro' );


					echo '<h3>';
					esc_html_e( 'Disable CSS and/or Javascript:', 'wp-listings-pro' );
					echo '</h3>';

					_e( 'There may be times you may want to disable the CSS automatically provided by WP Listings Pro.', 'wp-listings-pro' );
					_e( '<p><input name="wplpro_plugin_settings[disable_css]" id="wplpro-disable-css" type="checkbox" value="1" class="code" ' . checked( 1, $options['disable_css'], false ) . ' /> Disable WP Listings Pro CSS</p>', 'wp-listings-pro' );

					_e( '<p><input name="wplpro_plugin_settings[disable_fontawesome]" id="wplpro-disable-fontawesome" type="checkbox" value="1" class="code" ' . checked( 1, $options['disable_fontawesome'], false ) . ' /> Disable FontAwesome CSS</p>', 'wp-listings-pro' );

					_e( '<p><input name="wplpro_plugin_settings[disable_properticons]" id="wplpro-disable-properticons" type="checkbox" value="1" class="code" ' . checked( 1, $options['disable_properticons'], false ) . ' /> Disable Properticons CSS</p>', 'wp-listings-pro' );

					echo '<hr>';



					_e( '<h3>Default Currency</h3><p>Select a default currency symbol and optional currency code to display on listings.</p>', 'wp-listings-pro' );
					_e( '<p>Currency Symbol: ', 'wp-listings-pro' );
					echo '<select name="wplpro_plugin_settings[wplpro_currency_symbol]" id="wplpro_currency_symbol">
							 <option value=" " ' . selected( $options['wplpro_currency_symbol'], ' ', false ) . '>None</option>
							 <option value="&#36;" ' . selected( $options['wplpro_currency_symbol'], '$', false ) . '>&#36;</option>
							 <option value="&#163;" ' . selected( $options['wplpro_currency_symbol'], '£', false ) . '>&#163;</option>
							 <option value="&#8364;" ' . selected( $options['wplpro_currency_symbol'], '€', false ) . '>&#8364;</option>
							 <option value="&#165;" ' . selected( $options['wplpro_currency_symbol'], '¥', false ) . '>&#165;</option>
							 <option value="&#8369;" ' . selected( $options['wplpro_currency_symbol'], '₱', false ) . '>&#8369;</option>
							 <option value="&#8361;" ' . selected( $options['wplpro_currency_symbol'], '₩', false ) . '>&#8361;</option>
							 <option value="&#402;" ' . selected( $options['wplpro_currency_symbol'], 'ƒ', false ) . '>&#402;</option>
							 <option value="&#8358;" ' . selected( $options['wplpro_currency_symbol'], '₦', false ) . '>&#8358;</option>
							</select>
						  </p>';
					$codes = array(
						''    => 'None',
						'USD' => 'United States dollar',
						'GBP' => 'British pound',
						'CAD' => 'Canadian dollar',
						'EUR' => 'Euro',
						'MXN' => 'Mexican peso',
						'---' => '---',
						'AED' => 'United Arab Emirates dirham',
						'AFN' => 'Afghan afghani',
						'ALL' => 'Albanian lek',
						'AMD' => 'Armenian dram',
						'AOA' => 'Angolan kwanza',
						'ARS' => 'Argentine peso',
						'AUD' => 'Australian dollar',
						'AWG' => 'Aruban florin',
						'AZN' => 'Azerbaijani manat',
						'BAM' => 'Bosnia and Herzegovina convertible mark',
						'BBD' => 'Barbadian dollar',
						'BDT' => 'Bangladeshi taka',
						'BGN' => 'Bulgarian lev',
						'BHD' => 'Bahraini dinar',
						'BIF' => 'Burundian franc',
						'BMD' => 'Bermudian dollar',
						'BND' => 'Brunei dollar',
						'BOB' => 'Bolivian boliviano',
						'BRL' => 'Brazilian real',
						'BSD' => 'Bahamian dollar',
						'BTN' => 'Bhutanese ngultrum',
						'BWP' => 'Botswana pula',
						'BYR' => 'Belarusian ruble',
						'BZD' => 'Belize dollar',
						'CDF' => 'Congolese franc',
						'CHF' => 'Swiss franc',
						'CLP' => 'Chilean peso',
						'CNY' => 'Chinese yuan',
						'COP' => 'Colombian peso',
						'CRC' => 'Costa Rican colón',
						'CUP' => 'Cuban convertible peso',
						'CVE' => 'Cape Verdean escudo',
						'CZK' => 'Czech koruna',
						'DJF' => 'Djiboutian franc',
						'DKK' => 'Danish krone',
						'DOP' => 'Dominican peso',
						'DZD' => 'Algerian dinar',
						'EGP' => 'Egyptian pound',
						'ERN' => 'Eritrean nakfa',
						'ETB' => 'Ethiopian birr',
						'FJD' => 'Fijian dollar',
						'FKP' => 'Falkland Islands pound',
						'GEL' => 'Georgian lari',
						'GHS' => 'Ghana cedi',
						'GMD' => 'Gambian dalasi',
						'GNF' => 'Guinean franc',
						'GTQ' => 'Guatemalan quetzal',
						'GYD' => 'Guyanese dollar',
						'HKD' => 'Hong Kong dollar',
						'HNL' => 'Honduran lempira',
						'HRK' => 'Croatian kuna',
						'HTG' => 'Haitian gourde',
						'HUF' => 'Hungarian forint',
						'IDR' => 'Indonesian rupiah',
						'ILS' => 'Israeli new shekel',
						'IMP' => 'Manx pound',
						'INR' => 'Indian rupee',
						'IQD' => 'Iraqi dinar',
						'IRR' => 'Iranian rial',
						'ISK' => 'Icelandic króna',
						'JEP' => 'Jersey pound',
						'JMD' => 'Jamaican dollar',
						'JOD' => 'Jordanian dinar',
						'JPY' => 'Japanese yen',
						'KES' => 'Kenyan shilling',
						'KGS' => 'Kyrgyzstani som',
						'KHR' => 'Cambodian riel',
						'KMF' => 'Comorian franc',
						'KPW' => 'North Korean won',
						'KRW' => 'South Korean won',
						'KWD' => 'Kuwaiti dinar',
						'KYD' => 'Cayman Islands dollar',
						'KZT' => 'Kazakhstani tenge',
						'LAK' => 'Lao kip',
						'LBP' => 'Lebanese pound',
						'LKR' => 'Sri Lankan rupee',
						'LRD' => 'Liberian dollar',
						'LSL' => 'Lesotho loti',
						'LTL' => 'Lithuanian litas',
						'LVL' => 'Latvian lats',
						'LYD' => 'Libyan dinar',
						'MAD' => 'Moroccan dirham',
						'MDL' => 'Moldovan leu',
						'MGA' => 'Malagasy ariary',
						'MKD' => 'Macedonian denar',
						'MMK' => 'Burmese kyat',
						'MNT' => 'Mongolian tögrög',
						'MOP' => 'Macanese pataca',
						'MRO' => 'Mauritanian ouguiya',
						'MUR' => 'Mauritian rupee',
						'MVR' => 'Maldivian rufiyaa',
						'MWK' => 'Malawian kwacha',
						'MYR' => 'Malaysian ringgit',
						'MZN' => 'Mozambican metical',
						'NAD' => 'Namibian dollar',
						'NGN' => 'Nigerian naira',
						'NIO' => 'Nicaraguan córdoba',
						'NOK' => 'Norwegian krone',
						'NPR' => 'Nepalese rupee',
						'NZD' => 'New Zealand dollar',
						'OMR' => 'Omani rial',
						'PAB' => 'Panamanian balboa',
						'PEN' => 'Peruvian nuevo sol',
						'PGK' => 'Papua New Guinean kina',
						'PHP' => 'Philippine peso',
						'PKR' => 'Pakistani rupee',
						'PLN' => 'Polish złoty',
						'PRB' => 'Transnistrian ruble',
						'PYG' => 'Paraguayan guaraní',
						'QAR' => 'Qatari riyal',
						'RON' => 'Romanian leu',
						'RSD' => 'Serbian dinar',
						'RUB' => 'Russian ruble',
						'RWF' => 'Rwandan franc',
						'SAR' => 'Saudi riyal',
						'SBD' => 'Solomon Islands dollar',
						'SCR' => 'Seychellois rupee',
						'SDG' => 'Singapore dollar',
						'SEK' => 'Swedish krona',
						'SGD' => 'Singapore dollar',
						'SHP' => 'Saint Helena pound',
						'SLL' => 'Sierra Leonean leone',
						'SOS' => 'Somali shilling',
						'SRD' => 'Surinamese dollar',
						'SSP' => 'South Sudanese pound',
						'STD' => 'São Tomé and Príncipe dobra',
						'SVC' => 'Salvadoran colón',
						'SYP' => 'Syrian pound',
						'SZL' => 'Swazi lilangeni',
						'THB' => 'Thai baht',
						'TJS' => 'Tajikistani somoni',
						'TMT' => 'Turkmenistan manat',
						'TND' => 'Tunisian dinar',
						'TOP' => 'Tongan paʻanga',
						'TRY' => 'Turkish lira',
						'TTD' => 'Trinidad and Tobago dollar',
						'TWD' => 'New Taiwan dollar',
						'TZS' => 'Tanzanian shilling',
						'UAH' => 'Ukrainian hryvnia',
						'UGX' => 'Ugandan shilling',
						'UYU' => 'Uruguayan peso',
						'UZS' => 'Uzbekistani som',
						'VEF' => 'Venezuelan bolívar',
						'VND' => 'Vietnamese đồng',
						'VUV' => 'Vanuatu vatu',
						'WST' => 'Samoan tālā',
						'XAF' => 'Central African CFA franc',
						'XCD' => 'East Caribbean dollar',
						'XOF' => 'West African CFA franc',
						'XPF' => 'CFP franc',
						'YER' => 'Yemeni rial',
						'ZAR' => 'South African rand',
						'ZMW' => 'Zambian kwacha',
						'ZWL' => 'Zimbabwean dollar',
					);
					_e( '<p>Currency Code: ', 'wp-listings-pro' );
					echo '<select name="wplpro_plugin_settings[wplpro_currency_code]" id="wplpro_plugin_settings[wplpro_currency_code]" data-currency="USD">';
					foreach ( $codes as $code => $currency_name ) {
						echo '<option value=' . $code . ' ' . selected( $options['wplpro_currency_code'], $code, false ) . '>' . $currency_name . '</option>';
					}
					echo '</select>
					  </p>';

					_e( '<p><input name="wplpro_plugin_settings[wplpro_display_currency_code]" id="wplpro_display_currency_code" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_display_currency_code'], 0 ) . ' /> Display currency code</p><hr>', 'wp-listings-pro' );

					echo '<h3>' . __( 'Archive Settings:', 'wp-listings-pro' ) . '</h3>';
					echo '<p>Choose how many listings and employees to display on archive pages. There is a max of 50 to prevent performance issues.</p>';

					_e( '<p>Total Number of Listings to display on Listing Archives: <input name="wplpro_plugin_settings[wplpro_archive_posts_num]" id="wplpro_archive_posts_num" type="number" value="' . $options['wplpro_archive_posts_num'] . '" size="1" min="0" max="50" /></p>', 'wp-listings-pro' );

					_e( '<p>Total Number of Employees to display on Employee Archives: <input name="wplpro_plugin_settings[wplpro_archive_agent_num]" id="wplpro_archive_posts_num" type="number" value="' . $options['wplpro_archive_agent_num'] . '" size="1" min="0" max="50" /></p>', 'wplpro-agents' );

					echo '<hr>';


					_e( '<h3>Default Disclaimer</h3><p>Optionally enter a disclaimer to show on single listings. This can be overridden on individual listings.</p>', 'wp-listings-pro' );
					_e( '<p><textarea name="wplpro_plugin_settings[wplpro_global_disclaimer]" id="wplpro_global_disclaimer" type="text" value="' . esc_html( $options['wplpro_global_disclaimer'] ) . '" rows="4" style="width: 80%">' . esc_html( $options['wplpro_global_disclaimer'] ) . '</textarea></p><hr>', 'wp-listings-pro' );

					_e( '<h4>Default Form shortcode</h4><p>If you use a Contact Form plugin, you may enter the form shortcode here to display on all listings. Additionally, each listing can use a custom form. If no shortcode is entered, the template will use a default contact form:</p>', 'wp-listings-pro' );
					_e( '<p>Form shortcode: <input name="wplpro_plugin_settings[wplpro_default_form]" id="wplpro_default_form" type="text" value="' . esc_html( $options['wplpro_default_form'] ) . '" size="40" /></p><hr>', 'wp-listings-pro' );

					_e( "<h3>Custom Wrapper</h3><p>If your theme's content HTML ID's and Classes are different than the included template, you can enter the HTML of your content wrapper beginning and end:</p>", 'wp-listings-pro' );
					_e( '<p><label><input name="wplpro_plugin_settings[wplpro_custom_wrapper]" id="wplpro_custom_wrapper" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_custom_wrapper'], false ) . ' /> Use Custom Wrapper</p>', 'wp-listings-pro' );
					_e( '<p><label>Wrapper Start HTML: </p><input name="wplpro_plugin_settings[wplpro_start_wrapper]" id="wplpro_start_wrapper" type="text" value="' . esc_html( $options['wplpro_start_wrapper'] ) . '" size="80" /></label>', 'wp-listings-pro' );
					_e( '<p><label>Wrapper End HTML: </p><input name="wplpro_plugin_settings[wplpro_end_wrapper]" id="wplpro_end_wrapper" type="text" value="' . esc_html( $options['wplpro_end_wrapper'] ) . '" size="80" /></label><hr>', 'wp-listings-pro' );


					echo '<h3>' . __( 'Default Slugs:', 'wp-listings-pro' ) . '</h3>';

					_e( '<p>Optionally change the slug of the listing post type<br /><input type="text" name="wplpro_plugin_settings[wplpro_listings_slug]" value="' . $options['wplpro_listings_slug'] . '" /></p>', 'wp-listings-pro' );

					_e( '<p>Optionally change the slug of the employee post type<br /><input type="text" name="wplpro_plugin_settings[wplpro_employee_slug]" value="' . $options['wplpro_employee_slug'] . '" /></p>', 'wplpro-agents' );

					_e( "<em>Don't forget to <a href='../wp-admin/options-permalink.php'>reset your permalinks</a> if you change the slug!</em></p>", 'wplpro-agents' );

					echo '<hr>';

					echo '<h3>' . __( 'IDX Import Settings:', 'wp-listings-pro' ) . '</h3>';

						// Listing sync settings.
						_e( '<div style="width:99%;overflow: auto"><p>These settings apply to any imported IDX listings and agents. Imported listings and agents are updated via the latest API response twice daily. These settings can be overridden for individual listings/agents in the listing/agent detail page.</p>', 'wp-listings-pro' );
						_e( '<h2>Update Listings</h2>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="wplpro_plugin_settings[wplpro_idx_update]" id="wplpro_idx_update_all" type="radio" value="update-all" class="code" ' . checked( 'update-all', $options['wplpro_idx_update'], false ) . ' /> <p>Update all imported fields including gallery and featured image. <br /><em>* Excludes Post Title and Post Content</em></p></label></div>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="wplpro_plugin_settings[wplpro_idx_update]" id="wplpro_idx_update_none" type="radio" value="update-none" class="code" ' . checked( 'update-none', $options['wplpro_idx_update'], false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Does not update any fields.<br /><em>* Listing will be changed to sold status if it exists in the sold data feed.</em></p></label></div>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option update-custom"><label><h4>Custom Sync Settings</h4> <span class="dashicons dashicons-update"></span><input name="wplpro_plugin_settings[wplpro_idx_update]" id="wplpro_idx_update_custom" type="radio" value="update-custom" class="code" ' . checked( 'update-custom', $options['wplpro_idx_update'], false ) . ' /> <p>Choose specific fields to update.<br /></p></label></div></div>', 'wp-listings-pro' );

						// Custom boxes for when sync setting is set to custom.
						echo '<div class"custom-inputs"><fieldset id="wplpro_custom_inputs" disabled>';
						_e( '<p><label><input name="wplpro_plugin_settings[wplpro_custom_sync_featured]" id="wplpro_custom_sync_featured" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_custom_sync_featured'], false ) . ' /> Keep the featured image in sync</p>', 'wp-listings-pro' );
						_e( '<p><label><input name="wplpro_plugin_settings[wplpro_custom_sync_gallery]" id="wplpro_custom_sync_gallery" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_custom_sync_gallery'], false ) . ' /> Keep image gallery in sync</p>', 'wp-listings-pro' );
						_e( '<p><label><input name="wplpro_plugin_settings[wplpro_custom_sync_details]" id="wplpro_custom_sync_details" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_custom_sync_details'], false ) . ' /> Keep listing details in sync</p>', 'wp-listings-pro' );
						_e( '</fieldset></div>' );

						// What to do with listings set to sold.
						_e( '<br style="clear: both;"><h2>Sold Listings</h2>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option sold-keep"><label><h4>Keep All</h4> <span class="dashicons dashicons-admin-post"></span><input name="wplpro_plugin_settings[wplpro_idx_sold]" id="wplpro_idx_sold" type="radio" value="sold-keep" class="code" ' . checked( 'sold-keep', $options['wplpro_idx_sold'], false ) . ' /> <p>This will keep all imported listings published with the status changed to reflect as sold.</p></label></div>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option sold-draft"><label><h4>Keep as Draft</h4> <span class="dashicons dashicons-hidden"></span><input name="wplpro_plugin_settings[wplpro_idx_sold]" id="wplpro_idx_sold" type="radio" value="sold-draft" class="code" ' . checked( 'sold-draft', $options['wplpro_idx_sold'], false ) . ' /> <p>This will keep all imported listings that have been sold, but they will be changed to draft status in WordPress (AKA, not visible to front-end users, but not deleted).</p></label></div>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option sold-delete"><label><h4>Delete Sold</h4> <span class="dashicons dashicons-trash"></span><input name="wplpro_plugin_settings[wplpro_idx_sold]" id="wplpro_idx_sold" type="radio" value="sold-delete" class="code" ' . checked( 'sold-delete', $options['wplpro_idx_sold'], false ) . ' /> <p><strong>Not recommended</strong> <br />This will delete all sold listings and attached featured images from your WordPress database and media library.</p></label></div>', 'wp-listings-pro' );

						// Agent sync settings.
						echo '<div style="width:99%;overflow: auto">';
						_e( '<h2>Update Agents</h2>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option update-all"><label><h4>Update All</h4> <span class="dashicons dashicons-update"></span><input name="wplpro_plugin_settings[wplpro_idx_update_agents]" id="wplpro_idx_update_agents_all" type="radio" value="update-all" class="code" ' . checked( 'update-all', $options['wplpro_idx_update_agents'], false ) . ' /> <p>Update all imported fields including photo and contact information. <br /><em>* Excludes Post Title and Post Content</em></p></label></div>', 'wp-listings-pro' );
						_e( '<div class="idx-import-option update-none"><label><h4>Do Not Update</h4> <span class="dashicons dashicons-dismiss"></span><input name="wplpro_plugin_settings[wplpro_idx_update_agents]" id="wplpro_idx_update_agents_none" type="radio" value="update-none" class="code" ' . checked( 'update-none', $options['wplpro_idx_update_agents'], false ) . ' /> <p><strong>Not recommended as displaying inaccurate MLS data may violate your IDX agreement.</strong><br /> Does not update any fields.<br /></p></label></div>', 'wp-listings-pro' );

						_e( '<br style="clear: both;"><h2>Additional Options</h2>', 'wp-listings-pro' );
						_e(
							'<p>Select an author to use when importing listings <br />' . wp_dropdown_users(
								array(
									'selected' => $options['wplpro_import_author'],
									'name'     => 'wplpro_plugin_settings[wplpro_import_author]',
									'id'       => 'wplpro_import_author',
									'echo'     => false,
									'who'      => 'authors',
								)
							) . '</p>',
							'wp-listings-pro'
						);
						_e( '<p><input name="wplpro_plugin_settings[wplpro_display_idx_link]" id="wplpro_display_idx_link" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_display_idx_link'], false ) . ' /> Display a link to IDX Broker details page</p><hr style="clear: both;">', 'wp-listings-pro' );


						_e( '<h3>Sort Listings (High to Low Price)</h3>', 'wp-listings-pro' );

						?>
						<label> <input type="radio" name="wplpro_plugin_settings[enable_sort]" value="1" 
						<?php
						if ( ! empty( $options['enable_sort'] ) == '1' ) {
							echo 'checked="checked"'; }
						?>
						> Yes</label><br>
						<label> <input type="radio" name="wplpro_plugin_settings[enable_sort]" value="0" 
						<?php
						if ( ! empty( $options['enable_sort'] ) == '0' ) {
							echo 'checked="checked"'; }
						?>
						> No</label><br><br>

						<?php
						_e( '<h3>Pin Listings</h3>', 'wp-listings-pro' );

						$selected = ( isset( $options['pinned'] ) ) ? $options['pinned'] : array();
						wplpro_post_select( 'wplpro_plugin_settings[pinned][]', 'listing', $selected );

						$symbol = 'ctrl';
						if ( strpos( getenv( 'HTTP_USER_AGENT' ), 'Mac' ) !== false ) {
							$symbol = '⌘';
						}
						echo '<p class="description">' . esc_attr( 'You can select one or more listings to pin to the top of the search results by holding down the ' . $symbol . ' key and clicking on additional listings.', 'impresspro' ) . '</p>';

						echo '<hr>';
						echo '<h3>' . __( 'Uninstall:', 'wp-listings-pro' ) . '</h3>';
						_e( '<p>Checking this option will delete <strong>all</strong> plugin data when uninstalling the plugin.</p>', 'wp-listings-pro' );
						_e( '<p><input name="wplpro_plugin_settings[wplpro_uninstall_delete]" id="wplpro_uninstall_delete" type="checkbox" value="1" class="code" ' . checked( 1, $options['wplpro_uninstall_delete'], false ) . ' /> <strong style="color: red;">Delete plugin data on uninstall</strong></p><hr>', 'wp-listings-pro' );


						?>

					<input name="submit" class="button-primary" type="submit" value="<?php esc_attr_e( 'Save Settings' ); ?>" />
				</form>
			</div>
		</div>
	</div>
</div>

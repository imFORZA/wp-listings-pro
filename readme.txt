=== WP Listings Pro ===
Contributors: imforza, bradleymoore111, bhubbard, sgarza
Tags: listings, wp-listings, wp-listings-pro, listings, properties, property, real-estate, real estate, real estate agents, real estate brokers, idxbroker, imforza
Donate link: https://www.imforza.com
Requires at least: 4.7
Tested up to: 5.1.1
Requires PHP: 7.0.3
Stable tag: 3.0.8
License: GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

WP Listings Pro makes it simple to manage real estate listings, and real estate agent profiles on a WordPress website.

== Description ==
WP Listings Pro makes it simple to manage real estate listings, and real estate agent profiles on a WordPress website. Based on the original WP Listings (now known as IMPress Listings), we have updated it with new features and improved integration with IDX Broker.

== Screenshots ==
1. Listings in WP Admin
2. Edit Listings Agents, Images, and Documents

== Installation ==
1. Deactivate any other Listings, Agent, or Employee plugins.
2. Install from the WP Admin dashboard, or download the archive and install the archive under the Plugins menu, Add New, Upload Plugin. Or you can unzip the contents of the archive into your WordPress directory under wp-content/plugins/.
3. Activate the plugin from the Plugins page on the WP Admin page.

== Frequently Asked Questions ==
= Will my previous listings/employees be migrated when installing this plugin? =
Probably, while we do our best not all plugins are the same, migrating from IMPress Listings (or AgentPress Listings) and IMPress Agents should be a smooth experience. If you find any issues please submit an issue on Github.

= Whats the big difference between WP Listings Pro and IMPress Listings (formally WP Listings)/IMPress Agents? =
Currently WP Listings Pro has a few extra fields for listings, such as a much better field for gallery images. The IDX Broker sync/import tool has been rewritten to sync all photos and all property types provided by the IDX Broker API. As Agents (aka employees) are built into the plugin, there is no need to use the legacy [Post 2 Post plugin](https://wordpress.org/plugins/posts-to-posts/) which was required to connect agents to listings in the [IMPress Listings](https://wordpress.org/plugins/wp-listings/).

= Who maintains WP Listings Pro? =
WP Listings Pro is open source, and managed on Github, but the primary development is managed by imFORZA. The code is based on the original WP Listings, now called [IMPress Listings](https://wordpress.org/plugins/wp-listings/) built by Agent Evolution.  Be sure to check out our other plugin Real Estate Pro!

= Can I contribute to the project, submit bugs or feature requests? =
You can contribute, or submit bugs and feature requests on [Github](https://github.com/imFORZA/wp-listings-pro).

= Where else can I ask questions? =
Please use the support forums for this plugin on the wordpress.org website or submit an issue on [Github](https://github.com/imFORZA/wp-listings-pro). We'd love to hear from you!

== Changelog ==

- 3.0.8
-- Cleaned up metabox fields.
-- Fixed image import bug for images using HTTPS.

- 3.0.7
-- Fixed design issue with editing listings.

- 3.0.6
-- Fixed bug where featured images couldnt be set manually.

- 3.0.4
-- Fixed bug with API keys being overwritten
-- Updating clearing of cache to clear all transients for API
-- Updated background processing to go through REST rather than AJAX

- 3.0.3
-- More data sanitation bug fives
-- Code quality improvements
-- Updated localization files
-- Added feature to deleting a listing/agent on import page, to not require total refresh of the page

- 3.0.2
-- Bug fixes with data sanitation
-- Code quality improvements

- 3.0.1
-- First release of WP Listings Pro

== Upgrade Notice ==
We encourage all site owners to migrate from IMPress Listings to WP Listings Pro.

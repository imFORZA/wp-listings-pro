<?php
/**
 * WPLPRO IDX API Class, for interacting with IDX Broker.
 *
 * @package WP-Listings-Pro
 */

/**
 * WPLPRO IDX API Class, for interacting with IDX Broker.
 */
class WPLPRO_Idx_Api {

	/**
	 * Construct.
	 */
	public function __construct() {
		if ( isset( get_option( 'wplpro_plugin_settings' )['wplpro_api_key'] ) ) {
			$this->api_key = get_option( 'wplpro_plugin_settings' )['wplpro_api_key']; // Heh.
		}
	}

	/**
	 * Default version for accessing API.
	 *
	 * @var string version.
	 */
	private $idx_api_default_version = '1.4.0';

	/**
	 * URL to access API through.
	 *
	 * @var string url.
	 */
	private $idx_api_url = 'https://api.idxbroker.com';

	/**
	 * Access key.
	 *
	 * @var string access key.
	 */
	public $api_key;

	/**
	 * Function api_response handles the various replies we get from the IDX Broker API and returns appropriate error messages.
	 *
	 * @param  [array] $response [response header from API call].
	 * @return [array]           [keys: 'code' => response code, 'error' => false (default), or error message if one is found].
	 */
	public function api_response( $response ) {
		if ( ! $response || ! is_array( $response ) || ! isset( $response['response'] ) ) {
			return array(
				'code'  => 'Generic',
				'error' => 'Unable to complete API call.',
			);
		}
		if ( ! function_exists( 'curl_init' ) ) {
			return array(
				'code'  => 'PHP',
				'error' => 'The cURL extension for PHP is not enabled on your server.<br />Please contact your developer and/or hosting provider.',
			);
		}
		$response_code = $response['response']['code'];
		$err_message   = false;
		if ( is_numeric( $response_code ) ) {
			switch ( $response_code ) {
				case 401:
					$err_message = 'Access key is invalid or has been revoked, please ensure there are no spaces in your key.<br />If the problem persists, please reset your API key in the IDX Broker Platinum Dashboard or call 800-421-9668.';
					break;
				case 403:
					$err_message = 'IP address blocked due to violation of TOS. Contact 800-421-9668 to determine the reason for the block.';
					break;
				case 403.4:
					$err_message = 'API call generated from WordPress is not using SSL (HTTPS) to communicate.<br />Please contact your developer and/or hosting provider.';
					break;
				case 405:
				case 409:
					$err_message = 'Invalid request sent to IDX Broker API, please re-install the IDX Broker Platinum plugin';
					break;
				case 406:
					$err_message = 'Access key is missing. To obtain an access key, please visit your IDX Broker Platinum Dashboard';
					break;
				case 412:
					$err_message = 'Your account has exceeded the hourly access limit for your API key.<br />You may either wait and try again later, reset your API key in the IDX Broker Platinum Dashboard, or call 800-421-9668.';
					break;
				case 500:
					$err_message = 'General system error when attempting to communicate with the IDX Broker API, please try again in a few moments or contact 800-421-9668 if the problem persists.';
					break;
				case 503:
					$err_message = 'IDX Broker API is currently undergoing maintenance. Please try again in a few moments or call 800-421-9668 if the problem persists.';
					break;
			}
		}
		return array(
			'code'  => $response_code,
			'error' => $err_message,
		);
	}

	/**
	 * Main function for using the IDX API
	 *
	 * @param  string $method               GET POST etc. Nope not actually but I'm not gonna rewrite the doc comments.
	 * @param  string $apiversion           Version of API expected (default this->idx_api_default_version).
	 * @param  string $level                Access level (default 'clients').
	 * @param  array  $params               Arguments (default array()).
	 * @param  number $expiration           Timeout for expiration on transient (default 7200).
	 * @param  string $request_type         Actual method sike, GET POST etc.
	 * @param  bool   $json_decode_type (default false).
	 * @return object Data                  Response from server in object form?
	 */
	public function idx_api(
		  $method,
		  $apiversion = '',
			$level = 'clients',
		  $params = array(),
		  $expiration = 7200,
		  $request_type = 'GET',
		  $json_decode_type = false
	) {
		if ( '' === $apiversion ) {
			$apiversion = $this->idx_api_default_version;
		}
		$cache_key = 'idx_' . $method . '_cache';
		if ( $this->get_transient( $cache_key ) !== false ) {
			$data = $this->get_transient( $cache_key );
			return $data;
		}

		$headers = array(
			'Content-Type'  => 'application/x-www-form-urlencoded',
			'accesskey'     => $this->api_key,
			'outputtype'    => 'json',
			'apiversion'    => $apiversion,
			'pluginversion' => '2.3.3', // \Idx_Broker_Plugin::IDX_WP_PLUGIN_VERSION, // '2.3.3'
		);

		$params = array_merge(
			array(
				'timeout'   => 120,
				'sslverify' => false,
				'headers'   => $headers,
			),
			$params
		);
		$url    = $this->idx_api_url . '/' . $level . '/' . $method; // 'https://api.idxbroker.com'

		if ( 'POST' === $request_type ) {
			$response = wp_safe_remote_post( $url, $params );
		} else {
			$response = wp_remote_get( $url, $params );
		}
		$response = (array) $response;

		extract( $this->api_response( $response ) ); // get code and error message if any, assigned to vars $code and $error.
		if ( isset( $error ) && false !== $error ) {
			if ( 401 === (int) $code ) {
				$this->delete_transient( $cache_key );
			}
			if ( 'equity' === $level && 401 === (int) $code ) {
				$equity_401_message = 'Also confirm you are using the same domain as on your IDX Broker account.';
				return new \WP_Error( 'idx_api_error', 'Error ' . $code . ': ' . $error . $equity_401_message );
			}
			return new \WP_Error( 'idx_api_error', 'Error ' . $code . ': ' . $error );
		} else {
			$data = (array) json_decode( (string) $response['body'], $json_decode_type );
			if ( 'POST' !== $request_type ) {
				$this->set_transient( $cache_key, $data, $expiration );
			}
			return $data;
		}
	}

	/**
	 * If option does not exist or timestamp is old, return false.
	 * Otherwise return data
	 * We create our own transient functions to avoid bugs with the object cache
	 * for caching plugins.
	 *
	 * @param string $name Name of transient to get.
	 * @return string The transient.
	 */
	public function get_transient( $name ) {
		$data = get_option( $name );
		if ( empty( $data ) ) {
			return false;
		}
		$data       = unserialize( $data );
		$expiration = $data['expiration'];
		if ( $expiration < time() ) {
			return false;
		}
		return $data['data'];
	}

	/**
	 * Sets transient.
	 *
	 * @param string $name       Name to give to option.
	 * @param string $data       Data to be stored.
	 * @param string $expiration Date to expire.
	 */
	public function set_transient( $name, $data, $expiration ) {
		$expiration = time() + $expiration;
		$data       = array(
			'data'       => $data,
			'expiration' => $expiration,
		);
		$data       = serialize( $data );
		update_option( $name, $data );
	}

	/**
	 * Delete transient.
	 *
	 * @param  string $name Transient to delete.
	 */
	public function delete_transient( $name ) {
		delete_option( $name );
	}

	/**
	 * Clean IDX cached data
	 *
	 * @return void
	 */
	public function idx_clean_transients() {
		global $wpdb;
		$wpdb->query(
			$wpdb->prepare(
				"
                DELETE FROM $wpdb->options
         WHERE option_name LIKE %s
        ",
				'%idx_%_cache'
			)
		);

		$this->clear_wrapper_cache();

		// Update IDX Pages Immediately.
		wp_schedule_single_event( time(), 'idx_create_idx_pages' );
		wp_schedule_single_event( time(), 'idx_delete_idx_pages' );
	}

	/**
	 *
	 * Using our web services function, lets get the system links built in the middleware,
	 * clean and prepare them, and return them in a new array for use.
	 */
	public function idx_api_get_systemlinks() {
		if ( empty( $this->api_key ) ) {
			return array();
		}
		return $this->idx_api( 'systemlinks' );
	}

	/**
	 *
	 * Using our web services function, lets get saved links built in the middleware,
	 * clean and prepare them, and return them in a new array for use.
	 */
	public function idx_api_get_savedlinks() {
		if ( empty( $this->api_key ) ) {
			return array();
		}
		return $this->idx_api( 'savedlinks' );
	}

	/**
	 *
	 * Using our web services function, lets get the widget details built in the middleware,
	 * clean and prepare them, and return them in a new array for use.
	 */
	public function idx_api_get_widgetsrc() {
		if ( empty( $this->api_key ) ) {
			return array();
		}
		return $this->idx_api( 'widgetsrc' );
	}

	/**
	 * Get api version
	 */
	public function idx_api_get_apiversion() {
		if ( empty( $this->api_key ) ) {
			return $this->idx_api_default_version; // '1.4.0'
		}

		$data = $this->idx_api( 'apiversion', $this->idx_api_default_version, 'clients', array(), 86400 ); // '1.4.0';
		if ( is_array( $data ) && ! empty( $data ) ) {
			return $data['version'];
		} else {
			return $this->idx_api_default_version; // '1.4.0'
		}
	}

	/**
	 * Get URL of results.
	 *
	 * @return mixed    If successful, the url to send to. False if failure.
	 */
	public function system_results_url() {

		$links = $this->idx_api_get_systemlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return false;
		}

		foreach ( $links as $link ) {
			if ( $link->systemresults ) {
				$results_url = $link->url;
			}
		}

		// What if or can they have more than one system results page?
		if ( isset( $results_url ) ) {
			return $results_url;
		}

		return false;
	}

	/**
	 * Returns the url of the link.
	 *
	 * @param string $name name of the link to return the url of.
	 * @return bool|string
	 */
	public function system_link_url( $name ) {

		$links = $this->idx_api_get_systemlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return false;
		}

		foreach ( $links as $link ) {
			if ( $name === $link->name ) {
				return $link->url;
			}
		}

		return false;
	}

	/**
	 * Returns the url of the first system link found with
	 * a category of "details"
	 *
	 * @return bool|string link url if found else false
	 */
	public function details_url() {

		$links = $this->idx_api_get_systemlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return false;
		}

		foreach ( $links as $link ) {
			if ( 'details' === $link->category ) {
				return $link->url;
			}
		}

		return false;
	}

	/**
	 * Returns an array of system link urls
	 *
	 * @return array
	 */
	public function all_system_link_urls() {

		$links = $this->idx_api_get_systemlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return array();
		}

		$system_link_urls = array();

		foreach ( $links as $link ) {
			$system_link_urls[] = $link->url;
		}

		return $system_link_urls;
	}

	/**
	 * Returns an array of system link names
	 *
	 * @return array
	 */
	public function all_system_link_names() {

		$links = $this->idx_api_get_systemlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return array();
		}

		$system_link_names = array();

		foreach ( $links as $link ) {
			$system_link_names[] = $link->name;
		}

		return $system_link_names;
	}

	/**
	 * Get ALL THE URLS.
	 * http://i.imgur.com/FiNj8.jpg
	 *
	 * @return array Array of urls? Idk I didn't write this class.
	 */
	public function all_saved_link_urls() {

		$links = $this->idx_api_get_savedlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return array();
		}

		$system_link_urls = array();

		foreach ( $links as $link ) {
			$system_link_urls[] = $link->url;
		}

		return $system_link_urls;
	}

	/**
	 * Get ALL THE names.
	 * http://i.imgur.com/FiNj8.jpg
	 *
	 * @return array Array of names?
	 */
	public function all_saved_link_names() {

		$links = $this->idx_api_get_savedlinks();

		if ( empty( $links ) || ! empty( $links->errors ) ) {
			return array();
		}

		$system_link_names = array();

		foreach ( $links as $link ) {
			$system_link_names[] = $link->linkTitle;
		}

		return $system_link_names;
	}

	/**
	 * Get a specific page type
	 *
	 * @param  string $idx_page IDX Page.
	 * @return string           thingymabob.
	 */
	public function find_idx_page_type( $idx_page ) {
		// if it is a saved linke, return saved_link otherwise it is a system page.
		$saved_links = $this->idx_api_get_savedlinks();
		foreach ( $saved_links as $saved_link ) {
			$id = $saved_link->id;
			if ( $id === $idx_page ) {
				return 'saved_link';
			}
		}
	}

	/**
	 * Set the wrapper for a type of page... I think.
	 *
	 * @param [type] $idx_page    [description].
	 * @param [type] $wrapper_url [description].
	 */
	public function set_wrapper( $idx_page, $wrapper_url ) {
		// if none, quit process.
		if ( 'none' === $idx_page ) {
			return;
		} elseif ( 'global' === $idx_page ) {
			// set Global Wrapper.
			$this->idx_api( 'dynamicwrapperurl', $this->idx_api_default_version, 'clients', array( 'body' => array( 'dynamicURL' => $wrapper_url ) ), 10, 'POST' );
		} else {
			// find what IDX page type then set the page wrapper.
			$page_type = $this->find_idx_page_type( $idx_page );
			if ( 'saved_link' === $page_type ) {
				$params = array(
					'dynamicURL'  => $wrapper_url,
					'savedLinkID' => $idx_page,
				);
			} else {
				$params = array(
					'dynamicURL' => $wrapper_url,
					'pageID'     => $idx_page,
				);
			}
			$this->idx_api( 'dynamicwrapperurl', $this->idx_api_default_version, 'clients', array( 'body' => $params ), 10, 'POST' );
		}
	}

	/**
	 * Clear cache of wrapper.
	 *
	 * @return Object response from server.
	 */
	public function clear_wrapper_cache() {
		$idx_broker_key = $this->api_key;

		// access URL and request method.
		$url    = $this->idx_api_url . '/clients/wrappercache';
		$method = 'DELETE';

		// headers (required and optional).
		$headers = array(
			'Content-Type: application/x-www-form-urlencoded',
			'accesskey: ' . $idx_broker_key,
			'outputtype: json',
		);

		// set up cURL.
		$handle = curl_init();
		curl_setopt( $handle, CURLOPT_URL, $url );
		curl_setopt( $handle, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $handle, CURLOPT_CUSTOMREQUEST, $method );

		// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference.
		$response = curl_exec( $handle );
		$code     = curl_getinfo( $handle, CURLINFO_HTTP_CODE );

		if ( 204 === (int) $code ) {
			$response = true;
		} else {
			$response = false;
		}

		return $response;
	}

	/**
	 * Get saved link properties.
	 *
	 * @param  string $saved_link_id ID to access.
	 * @return [type]                Saved link properties.
	 */
	public function saved_link_properties( $saved_link_id ) {

		$saved_link_properties = $this->idx_api( 'properties/' . $saved_link_id . '?disclaimers=true', $this->idx_api_default_version, 'equity', array(), 7200, 'GET', true );

		return $saved_link_properties;
	}

	/**
	 * Get client properties.
	 *
	 * @param  string $type Type to access.
	 * @return [type]       Client properties.
	 */
	public function client_properties( $type ) {
		$properties = $this->idx_api( $type . '?disclaimers=true', $this->idx_api_default_version, 'clients', array(), 7200, 'GET', true );

		return $properties;
	}

	/**
	 * Returns an array of city objects for the agents mls area
	 *
	 * @return array $default_cities
	 */
	public function default_cities() {

		$default_cities = $this->idx_api( 'cities/combinedActiveMLS', $this->idx_api_default_version, 'clients' );

		return $default_cities;
	}

	/**
	 * Returns an array of city list ids
	 *
	 * @return array $list_ids
	 */
	public function city_list_ids() {

		$list_ids = $this->idx_api( 'cities', $this->idx_api_default_version, 'clients' );
		return $list_ids;
	}

	/**
	 * Returns a list of cities
	 *
	 * @param string $list_id   ID of list to access.
	 * @return array $city_list List to access.
	 */
	public function city_list( $list_id ) {

		$city_list = $this->idx_api( 'cities/' . $list_id, $this->idx_api_default_version, 'clients' );

		return $city_list;
	}

	/**
	 * Returns the IDs and names for each of a client's city lists including MLS city lists
	 *
	 * @return array
	 */
	public function city_list_names() {

		$city_list_names = $this->idx_api( 'citieslistname', $this->idx_api_default_version, 'clients' );

		return $city_list_names;
	}

	/**
	 * Returns the IDs and names for each of a client's county lists including MLS county lists
	 *
	 * @return array
	 */
	public function county_list_names() {

		$county_list_names = $this->idx_api( 'countieslistname', $this->idx_api_default_version, 'clients' );

		return $county_list_names;
	}

	/**
	 * Returns the IDs and names for each of a client's postalcodes lists including MLS postalcodes lists
	 *
	 * @return array
	 */
	public function postalcode_list_names() {

		$postalcodes_list_names = $this->idx_api( 'postalcodeslistname', $this->idx_api_default_version, 'clients' );

		return $postalcodes_list_names;
	}

	/**
	 * Returns the subdomain url WITH trailing slash
	 *
	 * @return string $url
	 */
	public function subdomain_url() {

		$url = $this->system_link_url( 'Sitemap' );
		$url = explode( 'sitemap', $url );

		return $url[0];
	}

	/**
	 * Returns the IDX IDs and names for all of the paper work approved MLSs
	 * on the client's account
	 */
	public function approved_mls() {

		$approved_mls = $this->idx_api( 'approvedmls', $this->idx_api_default_version, 'mls', array(), 60 * 60 * 24 );

		return $approved_mls;
	}

	/**
	 * Returns search field names for an MLS
	 *
	 * @param string $idx_id IDX to check for.
	 * @return [type]            Search fields name.
	 */
	public function searchfields( $idx_id ) {
		$approved_mls = $this->idx_api( "searchfields/$idx_id", $this->idx_api_default_version, 'mls', array() );

		return $approved_mls;
	}

	/**
	 * Search field values function.
	 *
	 * @param  string $idx_id      SPECIFICITY.
	 * @param  string $field_name  SPECIFICITY.
	 * @param  string $mls_pt_id   SPECIFICITY.
	 * @return [type]            [description]
	 */
	public function searchfieldvalues( $idx_id, $field_name, $mls_pt_id ) {
		$approved_mls = $this->idx_api( "searchfieldvalues/$idx_id?mlsPtID=$mls_pt_id&name=$field_name", $this->idx_api_default_version, 'mls', array() );

		return $approved_mls;
	}

	/**
	 * Compares the price fields of two arrays
	 *
	 * @param array $a  Um.
	 * @param array $b  God I love when I'm given documentation.
	 * @return int          Don't you just love documentation.
	 */
	public function price_cmp( $first, $second ) {

		$first  = $this->clean_price( $first['listingPrice'] );
		$second = $this->clean_price( $second['listingPrice'] );

		if ( $first === $second ) {
			return 0;
		}

		return ( $first < $second ) ? -1 : 1;
	}

	/**
	 * Removes the "$" and "," from the price field
	 *
	 * @param string $price not cleaned price.
	 * @return mixed $price the cleaned price
	 */
	public function clean_price( $price ) {

		$patterns = array(
			'/\$/',
			'/,/',
		);

		$price = preg_replace( $patterns, '', $price );

		return $price;
	}

	/**
	 * Checks whether the account (based on access key) has had a record of theirs go platinum.
	 *
	 * @return bool True if they've gone platinum, false if they're a worthless loser of a musician like me.
	 */
	public function platinum_account_type() {
		$account_type = $this->idx_api( 'accounttype', $this->idx_api_default_version, 'clients', array(), 60 * 60 * 24 );
		if ( gettype( $account_type ) !== 'object' && 'IDX Broker Platinum' === $account_type[0] ) {
			return true;
		}
		return false;
	}

	/**
	 * Get leads from timeframe.
	 *
	 * @param  time   $timeframe  Timeframe to check within (default null).
	 * @param  string $start_date Starting date (default null).
	 * @return array                A big ol stack of leads.
	 */
	public function get_leads( $timeframe = null, $start_date = '' ) {
		if ( ! empty( $start_date ) ) {
			$start_date = "&startDatetime=$start_date";
		}
		if ( ! empty( $timeframe ) ) {
			$leads = $this->idx_api( "lead?interval=$timeframe$start_date", $this->idx_api_default_version, 'leads' );
		} else {
			$leads = $this->idx_api( 'lead', $this->idx_api_default_version, 'leads' );
		}
		return $leads;
	}

	/**
	 * Get featured listings.
	 *
	 * @param  string $listing_type Seriously why is this function all the way at the bottom (default 'featured').
	 * @param  time?  $timeframe    It's like the most useful one (default null).
	 * @return array_of_listings               And yet they have it at the bottom ._.
	 */
	public function get_featured_listings( $listing_type = 'featured', $timeframe = null ) {
		// Force type to array.
		if ( ! empty( $timeframe ) ) {
			$listings = $this->idx_api( "$listing_type?interval=$timeframe", $this->idx_api_default_version, 'clients', array(), 60 * 2, 'GET', true );
		} else {
			$listings = $this->idx_api( $listing_type, $this->idx_api_default_version, 'clients', array(), 60 * 2, 'GET', true );
		}

		return $listings;
	}
}

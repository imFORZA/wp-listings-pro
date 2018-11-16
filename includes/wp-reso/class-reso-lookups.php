<?php
/**
 * RESO Lookup Values (http://ddwiki.reso.org/display/DDW/Lookup+Fields+and+Values)
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Reso Lookup Field Values.
 */
class ResoLookupFieldValues {

	public function __construct() {

	}


	/**
	 * Get Lookup Field Values.
	 *
	 * @access public
	 * @return Array
	 */
	public function get_lookup_field_values() {
		return array(
			'area_source',
			'area_units',
			'association_fee_includes',
			'attended',
			'body_type',
			'business_type',
			'buyer_financing',
			'change_type',
			'class_name',
			'common_walls',
			'compensationtype',
			'concessions',
			'construction_materials',
			'contact_type',
			'country',
			'current_financing',
			'direction_faces',
			'electric',
			'existing_lease_type',
			'feef_requency',
			'financial_data_source',
			'foundation_details',
			'furnished',
			'green_building_verification_type',
			'green_energy_efficient',
			'green_energy_generation',
			'green_indoor_air_quality',
			'green_sustainability',
			'green_verification_source',
			'green_water_conservation',
			'hours_days_of_operation',
			'image_of',
			'income_includes',
			'languages',
			'lease_renewal_compensation',
			'lease_term',
			'levels',
			'linear_units',
			'listing_agreement',
			'listing_service',
			'listing_terms',
			'lockbox_type',
			'lot_size_source',
			'lot_size_units',
			'media_category',
			'media_type',
			'member_status',
			'member_type',
			'occupant_type',
			'office_status',
			'office_type',
			'openhouse_status',
			'openhouse_type',
			'operating_expense_includes',
			'owner_pays',
			'ownership_type',
			'pets_allowed',
			'possession',
			'power_production_annual_status',
			'power_production_type',
			'property_condition',
			'property_subtype',
			'property_type',
			'rent_includes',
			'resource_name',
			'roof',
			'room_type',
			'sewer',
			'showing_contact_type',
			'skirt',
			'special_licenses',
			'special_listing_conditions',
			'standard_status',
			'state_or_province',
			'street_direction',
			'team_status',
			'tenant_pays',
			'utilities',
			'water_source',
			'year_built_source',
		);
	}

	// TODO: Functions to return lookup values as json, dropdown options, checkbox options, radio button options, etc.

	/**
	 * AreaSourceLookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function area_source() {
		return array(
			__( 'Appraiser', 'wp-reso' ),
			__( 'Assessor', 'wp-reso' ),
			__( 'Builder', 'wp-reso' ),
			__( 'Estimated', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Plans', 'wp-reso' ),
			__( 'Public Records', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
		);
	}

	/**
	 * AreaUnitsLookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function area_units() {
		return array(
			__( 'Square Feet', 'wp-reso' ),
			__( 'Square Meters', 'wp-reso' ),
		);
	}

	/**
	 * AssociationFeeIncludesLookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function association_fee_includes() {
		return array(
			__( 'Cable TV', 'wp-reso' ),
			__( 'Earthquake Insurance', 'wp-reso' ),
			__( 'Electricity', 'wp-reso' ),
			__( 'Gas', 'wp-reso' ),
			__( 'Insurance', 'wp-reso' ),
			__( 'Maintenance Exterior', 'wp-reso' ),
			__( 'Maintenance Grounds', 'wp-reso' ),
			__( 'Pest Control', 'wp-reso' ),
			__( 'Security', 'wp-reso' ),
			__( 'Sewer', 'wp-reso' ),
			__( 'Snow Removal', 'wp-reso' ),
			__( 'Trash', 'wp-reso' ),
			__( 'Utilities', 'wp-reso' ),
			__( 'Water', 'wp-reso' ),
		);
	}

	/**
	 * AttendedLookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function attended() {
		return array(
			__( 'Agent', 'wp-reso' ),
			__( 'Seller', 'wp-reso' ),
			__( 'Unattended', 'wp-reso' ),
		);
	}

	/**
	 * BodyType_Lookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function body_type() {
		return array(
			__( 'Double Wide', 'wp-reso' ),
			__( 'Expando', 'wp-reso' ),
			__( 'Quad Wide', 'wp-reso' ),
			__( 'See Remarks (BodyType)', 'wp-reso' ),
			__( 'Single Wide', 'wp-reso' ),
			__( 'Triple Wide', 'wp-reso' ),
		);
	}

	/**
	 * BusinessType_Lookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function business_type() {
		return array(
			__( 'Accounting', 'wp-reso' ),
			__( 'Administrative and Support', 'wp-reso' ),
			__( 'Advertising', 'wp-reso' ),
			__( 'Agriculture', 'wp-reso' ),
			__( 'Animal Grooming', 'wp-reso' ),
			__( 'Appliances', 'wp-reso' ),
			__( 'Aquarium Supplies', 'wp-reso' ),
			__( 'Arts and Entertainment', 'wp-reso' ),
			__( 'Athletic', 'wp-reso' ),
			__( 'Auto Body', 'wp-reso' ),
			__( 'Auto Dealer', 'wp-reso' ),
			__( 'Auto Glass', 'wp-reso' ),
			__( 'Auto Parts', 'wp-reso' ),
			__( 'Auto Rent/Lease', 'wp-reso' ),
			__( 'Auto Repair-Specialty', 'wp-reso' ),
			__( 'Auto Service', 'wp-reso' ),
			__( 'Auto Stereo/Alarm', 'wp-reso' ),
			__( 'Auto Tires', 'wp-reso' ),
			__( 'Auto Wrecking', 'wp-reso' ),
			__( 'Bakery', 'wp-reso' ),
			__( 'Bar/Tavern/Lounge', 'wp-reso' ),
			__( 'Barber/Beauty', 'wp-reso' ),
			__( 'Bed & Breakfast', 'wp-reso' ),
			__( 'Books/Cards/Stationary', 'wp-reso' ),
			__( 'Butcher', 'wp-reso' ),
			__( 'Cabinets', 'wp-reso' ),
			__( 'Candy/Cookie', 'wp-reso' ),
			__( 'Carpet/Tile', 'wp-reso' ),
			__( 'Car Wash', 'wp-reso' ),
			__( 'Child Care', 'wp-reso' ),
			__( 'Church', 'wp-reso' ),
			__( 'Clothing', 'wp-reso' ),
			__( 'Commercial', 'wp-reso' ),
			__( 'Computer', 'wp-reso' ),
			__( 'Construction/Contractor', 'wp-reso' ),
			__( 'Convalescent', 'wp-reso' ),
			__( 'Convenience Store', 'wp-reso' ),
			__( 'Dance Studio', 'wp-reso' ),
			__( 'Decorator', 'wp-reso' ),
			__( 'Deli/Catering', 'wp-reso' ),
			__( 'Dental', 'wp-reso' ),
			__( 'Distribution', 'wp-reso' ),
			__( 'Doughnut', 'wp-reso' ),
			__( 'Drugstore', 'wp-reso' ),
			__( 'Dry Cleaner', 'wp-reso' ),
			__( 'Education/School', 'wp-reso' ),
			__( 'Electronics', 'wp-reso' ),
			__( 'Employment', 'wp-reso' ),
			__( 'Farm', 'wp-reso' ),
			__( 'Fast Food', 'wp-reso' ),
			__( 'Financial', 'wp-reso' ),
			__( 'Fitness', 'wp-reso' ),
			__( 'Florist/Nursery', 'wp-reso' ),
			__( 'Food & Beverage', 'wp-reso' ),
			__( 'Forest Reserve', 'wp-reso' ),
			__( 'Franchise', 'wp-reso' ),
			__( 'Furniture', 'wp-reso' ),
			__( 'Gas Station', 'wp-reso' ),
			__( 'Gift Shop', 'wp-reso' ),
			__( 'Grocery', 'wp-reso' ),
			__( 'Hardware', 'wp-reso' ),
			__( 'Health Food', 'wp-reso' ),
			__( 'Health Services', 'wp-reso' ),
			__( 'Hobby', 'wp-reso' ),
			__( 'Home Cleaner', 'wp-reso' ),
			__( 'Hospitality', 'wp-reso' ),
			__( 'Hotel/Motel', 'wp-reso' ),
			__( 'Ice Cream/Frozen Yogurt', 'wp-reso' ),
			__( 'Industrial', 'wp-reso' ),
			__( 'Jewelry', 'wp-reso' ),
			__( 'Landscaping', 'wp-reso' ),
			__( 'Laundromat', 'wp-reso' ),
			__( 'Liquor Store', 'wp-reso' ),
			__( 'Locksmith', 'wp-reso' ),
			__( 'Manufacturing', 'wp-reso' ),
			__( 'Medical', 'wp-reso' ),
			__( 'Mixed', 'wp-reso' ),
			__( 'Mobile/Trailer Park', 'wp-reso' ),
			__( 'Music', 'wp-reso' ),
			__( 'Nursing Home', 'wp-reso' ),
			__( 'Office Supply', 'wp-reso' ),
			__( 'Other (BusinessType)', 'wp-reso' ),
			__( 'Paints', 'wp-reso' ),
			__( 'Parking', 'wp-reso' ),
			__( 'Pet Store', 'wp-reso' ),
			__( 'Photographer', 'wp-reso' ),
			__( 'Pizza', 'wp-reso' ),
			__( 'Printing', 'wp-reso' ),
			__( 'Professional/Office', 'wp-reso' ),
			__( 'Professional Service', 'wp-reso' ),
			__( 'Real Estate', 'wp-reso' ),
			__( 'Recreation', 'wp-reso' ),
			__( 'Rental', 'wp-reso' ),
			__( 'Residential', 'wp-reso' ),
			__( 'Restaurant', 'wp-reso' ),
			__( 'Retail', 'wp-reso' ),
			__( 'Saddlery/Harness', 'wp-reso' ),
			__( 'Sporting Goods', 'wp-reso' ),
			__( 'Storage', 'wp-reso' ),
			__( 'Toys', 'wp-reso' ),
			__( 'Transportation', 'wp-reso' ),
			__( 'Travel', 'wp-reso' ),
			__( 'Upholstery', 'wp-reso' ),
			__( 'Utility', 'wp-reso' ),
			__( 'Variety', 'wp-reso' ),
			__( 'Video', 'wp-reso' ),
			__( 'Wallpaper', 'wp-reso' ),
			__( 'Warehouse', 'wp-reso' ),
			__( 'Wholesale', 'wp-reso' ),
		);
	}

	/**
	 * BuyerFinancing_Lookups function.
	 *
	 * @access public
	 * @return Array
	 */
	public function buyer_financing() {
		return array(
			__( 'Assumed', 'wp-reso' ),
			__( 'Cash', 'wp-reso' ),
			__( 'Contract', 'wp-reso' ),
			__( 'Conventional', 'wp-reso' ),
			__( 'FHA', 'wp-reso' ),
			__( 'FHA 203(b)', 'wp-reso' ),
			__( 'FHA 203(k)', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Private', 'wp-reso' ),
			__( 'Seller Financing', 'wp-reso' ),
			__( 'Trust Deed', 'wp-reso' ),
			__( 'USDA', 'wp-reso' ),
			__( 'VA', 'wp-reso' ),
		);
	}

	/**
	 * ChangeType function.
	 *
	 * @access public
	 * @return Array
	 */
	public function change_type() {
		return array(
			__( 'Active', 'wp-reso' ),
			__( 'Active Under Contract', 'wp-reso' ),
			__( 'Back On Market', 'wp-reso' ),
			__( 'Canceled', 'wp-reso' ),
			__( 'Closed', 'wp-reso' ),
			__( 'Deleted', 'wp-reso' ),
			__( 'Expired', 'wp-reso' ),
			__( 'Hold', 'wp-reso' ),
			__( 'New Listing', 'wp-reso' ),
			__( 'Pending', 'wp-reso' ),
			__( 'Price Change', 'wp-reso' ),
			__( 'Withdrawn', 'wp-reso' ),
		);
	}

	/**
	 * ClassName function.
	 *
	 * @access public
	 * @return Array
	 */
	public function class_name() {
		return array(
			__( 'Business Opportunity', 'wp-reso' ),
			__( 'Commercial Lease', 'wp-reso' ),
			__( 'Commercial Sale', 'wp-reso' ),
			__( 'Contacts', 'wp-reso' ),
			__( 'Cross Property', 'wp-reso' ),
			__( 'Farm', 'wp-reso' ),
			__( 'History Transactional', 'wp-reso' ),
			__( 'Land', 'wp-reso' ),
			__( 'Manufactured In Park', 'wp-reso' ),
			__( 'Media', 'wp-reso' ),
			__( 'Member', 'wp-reso' ),
			__( 'Office', 'wp-reso' ),
			__( 'Open House', 'wp-reso' ),
			__( 'Residential', 'wp-reso' ),
			__( 'Residential Income', 'wp-reso' ),
			__( 'Residential Lease', 'wp-reso' ),
			__( 'Saved Search', 'wp-reso' ),
		);
	}

	/**
	 * common_walls function.
	 *
	 * @access public
	 * @return Array
	 */
	public function common_walls() {
		return array(
			__( '1 Common Wall', 'wp-reso' ),
			__( '2+ Common Walls', 'wp-reso' ),
			__( 'End Unit', 'wp-reso' ),
			__( 'No Common Walls', 'wp-reso' ),
			__( 'No One Above', 'wp-reso' ),
			__( 'No One Below', 'wp-reso' ),
		);
	}

	/**
	 * compensation_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function compensation_type() {
		return array(
			__( '$', 'wp-reso' ),
			__( '%', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
		);
	}

	/**
	 * concessions function.
	 *
	 * @access public
	 * @return Array
	 */
	public function concessions() {
		return array(
			__( 'Call Listing Agent', 'wp-reso' ),
			__( 'No', 'wp-reso' ),
			__( 'Yes', 'wp-reso' ),
		);
	}

	/**
	 * construction_materials function.
	 *
	 * @access public
	 * @return Array
	 */
	public function construction_materials() {
		return array(
			__( 'Adobe', 'wp-reso' ),
			__( 'Aluminum Siding', 'wp-reso' ),
			__( 'Asbestos', 'wp-reso' ),
			__( 'Asphalt', 'wp-reso' ),
			__( 'Attic/Crawl Hatchway(s) Insulated', 'wp-reso' ),
			__( 'Batts Insulation', 'wp-reso' ),
			__( 'Block', 'wp-reso' ),
			__( 'Blown-In Insulation', 'wp-reso' ),
			__( 'Board & Batten Siding', 'wp-reso' ),
			__( 'Brick', 'wp-reso' ),
			__( 'Brick Veneer', 'wp-reso' ),
			__( 'Cedar', 'wp-reso' ),
			__( 'Cement Siding', 'wp-reso' ),
			__( 'Clapboard', 'wp-reso' ),
			__( 'Concrete', 'wp-reso' ),
			__( 'Ducts Professionally Air-Sealed', 'wp-reso' ),
			__( 'Exterior Duct-Work is Insulated', 'wp-reso' ),
			__( 'Fiber Cement', 'wp-reso' ),
			__( 'Fiberglass Siding', 'wp-reso' ),
			__( 'Foam Insulation', 'wp-reso' ),
			__( 'Frame', 'wp-reso' ),
			__( 'Glass', 'wp-reso' ),
			__( 'HardiPlank Type', 'wp-reso' ),
			__( 'ICAT Recessed Lighting', 'wp-reso' ),
			__( 'ICFs (Insulated Concrete Forms)', 'wp-reso' ),
			__( 'Lap Siding', 'wp-reso' ),
			__( 'Log', 'wp-reso' ),
			__( 'Log Siding', 'wp-reso' ),
			__( 'Low VOC Insulation', 'wp-reso' ),
			__( 'Masonite', 'wp-reso' ),
			__( 'Metal Siding', 'wp-reso' ),
			__( 'Natural Building', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Plaster', 'wp-reso' ),
			__( 'Radiant Barrier', 'wp-reso' ),
			__( 'Rammed Earth', 'wp-reso' ),
			__( 'Recycled/Bio-Based Insulation', 'wp-reso' ),
			__( 'Redwood Siding', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Shake Siding', 'wp-reso' ),
			__( 'Shingle Siding', 'wp-reso' ),
			__( 'Slump Block', 'wp-reso' ),
			__( 'Spray Foam Insulation', 'wp-reso' ),
			__( 'Steel Siding', 'wp-reso' ),
			__( 'Stone', 'wp-reso' ),
			__( 'Stone Veneer', 'wp-reso' ),
			__( 'Straw', 'wp-reso' ),
			__( 'Stucco', 'wp-reso' ),
			__( 'Synthetic Stucco', 'wp-reso' ),
			__( 'Unknown', 'wp-reso' ),
			__( 'Vertical Siding', 'wp-reso' ),
			__( 'Vinyl Siding', 'wp-reso' ),
			__( 'Wood Siding', 'wp-reso' ),
		);
	}

	/**
	 * contact_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function contact_type() {
		return array(
			__( 'Lead', 'wp-reso' ),
		);
	}

	/**
	 * country function.
	 *
	 * @access public
	 * @return Array
	 */
	public function country() {
		return array(
			__( 'AD', 'wp-reso' ),
			__( 'AE', 'wp-reso' ),
			__( 'AF', 'wp-reso' ),
			__( 'AG', 'wp-reso' ),
			__( 'AI', 'wp-reso' ),
			__( 'AL', 'wp-reso' ),
			__( 'AM', 'wp-reso' ),
			__( 'AN', 'wp-reso' ),
			__( 'AO', 'wp-reso' ),
			__( 'AQ', 'wp-reso' ),
			__( 'AR', 'wp-reso' ),
			__( 'AS', 'wp-reso' ),
			__( 'AT', 'wp-reso' ),
			__( 'AU', 'wp-reso' ),
			__( 'AW', 'wp-reso' ),
			__( 'AX', 'wp-reso' ),
			__( 'AZ', 'wp-reso' ),
			__( 'BA', 'wp-reso' ),
			__( 'BB', 'wp-reso' ),
			__( 'BD', 'wp-reso' ),
			__( 'BE', 'wp-reso' ),
			__( 'BF', 'wp-reso' ),
			__( 'BG', 'wp-reso' ),
			__( 'BH', 'wp-reso' ),
			__( 'BI', 'wp-reso' ),
			__( 'BJ', 'wp-reso' ),
			__( 'BL', 'wp-reso' ),
			__( 'BM', 'wp-reso' ),
			__( 'BN', 'wp-reso' ),
			__( 'BO', 'wp-reso' ),
			__( 'BR', 'wp-reso' ),
			__( 'BS', 'wp-reso' ),
			__( 'BT', 'wp-reso' ),
			__( 'BV', 'wp-reso' ),
			__( 'BW', 'wp-reso' ),
			__( 'BY', 'wp-reso' ),
			__( 'BZ', 'wp-reso' ),
			__( 'CA', 'wp-reso' ),
			__( 'CC', 'wp-reso' ),
			__( 'CD', 'wp-reso' ),
			__( 'CF', 'wp-reso' ),
			__( 'CG', 'wp-reso' ),
			__( 'CH', 'wp-reso' ),
			__( 'CI', 'wp-reso' ),
			__( 'CK', 'wp-reso' ),
			__( 'CL', 'wp-reso' ),
			__( 'CM', 'wp-reso' ),
			__( 'CN', 'wp-reso' ),
			__( 'CO', 'wp-reso' ),
			__( 'CR', 'wp-reso' ),
			__( 'CU', 'wp-reso' ),
			__( 'CV', 'wp-reso' ),
			__( 'CX', 'wp-reso' ),
			__( 'CY', 'wp-reso' ),
			__( 'CZ', 'wp-reso' ),
			__( 'DE', 'wp-reso' ),
			__( 'DJ', 'wp-reso' ),
			__( 'DK', 'wp-reso' ),
			__( 'DM', 'wp-reso' ),
			__( 'DO', 'wp-reso' ),
			__( 'DZ', 'wp-reso' ),
			__( 'EC', 'wp-reso' ),
			__( 'EE', 'wp-reso' ),
			__( 'EG', 'wp-reso' ),
			__( 'EH', 'wp-reso' ),
			__( 'ER', 'wp-reso' ),
			__( 'ES', 'wp-reso' ),
			__( 'ET', 'wp-reso' ),
			__( 'FI', 'wp-reso' ),
			__( 'FJ', 'wp-reso' ),
			__( 'FK', 'wp-reso' ),
			__( 'FM', 'wp-reso' ),
			__( 'FO', 'wp-reso' ),
			__( 'FR', 'wp-reso' ),
			__( 'GA', 'wp-reso' ),
			__( 'GB', 'wp-reso' ),
			__( 'GD', 'wp-reso' ),
			__( 'GE', 'wp-reso' ),
			__( 'GF', 'wp-reso' ),
			__( 'GG', 'wp-reso' ),
			__( 'GH', 'wp-reso' ),
			__( 'GI', 'wp-reso' ),
			__( 'GL', 'wp-reso' ),
			__( 'GM', 'wp-reso' ),
			__( 'GN', 'wp-reso' ),
			__( 'GP', 'wp-reso' ),
			__( 'GQ', 'wp-reso' ),
			__( 'GR', 'wp-reso' ),
			__( 'GS', 'wp-reso' ),
			__( 'GT', 'wp-reso' ),
			__( 'GU', 'wp-reso' ),
			__( 'GW', 'wp-reso' ),
			__( 'GY', 'wp-reso' ),
			__( 'HK', 'wp-reso' ),
			__( 'HM', 'wp-reso' ),
			__( 'HN', 'wp-reso' ),
			__( 'HR', 'wp-reso' ),
			__( 'HT', 'wp-reso' ),
			__( 'HU', 'wp-reso' ),
			__( 'ID', 'wp-reso' ),
			__( 'IE', 'wp-reso' ),
			__( 'IL', 'wp-reso' ),
			__( 'IM', 'wp-reso' ),
			__( 'IN', 'wp-reso' ),
			__( 'IO', 'wp-reso' ),
			__( 'IQ', 'wp-reso' ),
			__( 'IR', 'wp-reso' ),
			__( 'IS', 'wp-reso' ),
			__( 'IT', 'wp-reso' ),
			__( 'JE', 'wp-reso' ),
			__( 'JM', 'wp-reso' ),
			__( 'JO', 'wp-reso' ),
			__( 'JP', 'wp-reso' ),
			__( 'KE', 'wp-reso' ),
			__( 'KG', 'wp-reso' ),
			__( 'KH', 'wp-reso' ),
			__( 'KI', 'wp-reso' ),
			__( 'KM', 'wp-reso' ),
			__( 'KN', 'wp-reso' ),
			__( 'KP', 'wp-reso' ),
			__( 'KR', 'wp-reso' ),
			__( 'KW', 'wp-reso' ),
			__( 'KY', 'wp-reso' ),
			__( 'KZ', 'wp-reso' ),
			__( 'LA', 'wp-reso' ),
			__( 'LB', 'wp-reso' ),
			__( 'LC', 'wp-reso' ),
			__( 'LI', 'wp-reso' ),
			__( 'LK', 'wp-reso' ),
			__( 'LR', 'wp-reso' ),
			__( 'LS', 'wp-reso' ),
			__( 'LT', 'wp-reso' ),
			__( 'LU', 'wp-reso' ),
			__( 'LV', 'wp-reso' ),
			__( 'LY', 'wp-reso' ),
			__( 'MA', 'wp-reso' ),
			__( 'MC', 'wp-reso' ),
			__( 'MD', 'wp-reso' ),
			__( 'ME', 'wp-reso' ),
			__( 'MF', 'wp-reso' ),
			__( 'MG', 'wp-reso' ),
			__( 'MH', 'wp-reso' ),
			__( 'MK', 'wp-reso' ),
			__( 'ML', 'wp-reso' ),
			__( 'MM', 'wp-reso' ),
			__( 'MN', 'wp-reso' ),
			__( 'MO', 'wp-reso' ),
			__( 'MP', 'wp-reso' ),
			__( 'MQ', 'wp-reso' ),
			__( 'MR', 'wp-reso' ),
			__( 'MS', 'wp-reso' ),
			__( 'MT', 'wp-reso' ),
			__( 'MU', 'wp-reso' ),
			__( 'MV', 'wp-reso' ),
			__( 'MW', 'wp-reso' ),
			__( 'MX', 'wp-reso' ),
			__( 'MY', 'wp-reso' ),
			__( 'MZ', 'wp-reso' ),
			__( 'NA', 'wp-reso' ),
			__( 'NC', 'wp-reso' ),
			__( 'NE', 'wp-reso' ),
			__( 'NF', 'wp-reso' ),
			__( 'NG', 'wp-reso' ),
			__( 'NI', 'wp-reso' ),
			__( 'NL', 'wp-reso' ),
			__( 'NP', 'wp-reso' ),
			__( 'NR', 'wp-reso' ),
			__( 'NU', 'wp-reso' ),
			__( 'NZ', 'wp-reso' ),
			__( 'OM', 'wp-reso' ),
			__( 'OT', 'wp-reso' ),
			__( 'PA', 'wp-reso' ),
			__( 'PE', 'wp-reso' ),
			__( 'PF', 'wp-reso' ),
			__( 'PG', 'wp-reso' ),
			__( 'PH', 'wp-reso' ),
			__( 'PK', 'wp-reso' ),
			__( 'PL', 'wp-reso' ),
			__( 'PM', 'wp-reso' ),
			__( 'PN', 'wp-reso' ),
			__( 'PR', 'wp-reso' ),
			__( 'PS', 'wp-reso' ),
			__( 'PT', 'wp-reso' ),
			__( 'PW', 'wp-reso' ),
			__( 'PY', 'wp-reso' ),
			__( 'QA', 'wp-reso' ),
			__( 'RE', 'wp-reso' ),
			__( 'RO', 'wp-reso' ),
			__( 'RS', 'wp-reso' ),
			__( 'RU', 'wp-reso' ),
			__( 'RW', 'wp-reso' ),
			__( 'SA', 'wp-reso' ),
			__( 'SB', 'wp-reso' ),
			__( 'SC', 'wp-reso' ),
			__( 'SD', 'wp-reso' ),
			__( 'SE', 'wp-reso' ),
			__( 'SG', 'wp-reso' ),
			__( 'SH', 'wp-reso' ),
			__( 'SI', 'wp-reso' ),
			__( 'SJ', 'wp-reso' ),
			__( 'SK', 'wp-reso' ),
			__( 'SL', 'wp-reso' ),
			__( 'SM', 'wp-reso' ),
			__( 'SN', 'wp-reso' ),
			__( 'SO', 'wp-reso' ),
			__( 'SR', 'wp-reso' ),
			__( 'ST', 'wp-reso' ),
			__( 'SV', 'wp-reso' ),
			__( 'SY', 'wp-reso' ),
			__( 'SZ', 'wp-reso' ),
			__( 'TC', 'wp-reso' ),
			__( 'TD', 'wp-reso' ),
			__( 'TF', 'wp-reso' ),
			__( 'TG', 'wp-reso' ),
			__( 'TH', 'wp-reso' ),
			__( 'TJ', 'wp-reso' ),
			__( 'TK', 'wp-reso' ),
			__( 'TL', 'wp-reso' ),
			__( 'TM', 'wp-reso' ),
			__( 'TN', 'wp-reso' ),
			__( 'TO', 'wp-reso' ),
			__( 'TR', 'wp-reso' ),
			__( 'TT', 'wp-reso' ),
			__( 'TV', 'wp-reso' ),
			__( 'TW', 'wp-reso' ),
			__( 'TZ', 'wp-reso' ),
			__( 'UA', 'wp-reso' ),
			__( 'UG', 'wp-reso' ),
			__( 'UM', 'wp-reso' ),
			__( 'US', 'wp-reso' ),
			__( 'UY', 'wp-reso' ),
			__( 'UZ', 'wp-reso' ),
			__( 'VA', 'wp-reso' ),
			__( 'VC', 'wp-reso' ),
			__( 'VE', 'wp-reso' ),
			__( 'VG', 'wp-reso' ),
			__( 'VI', 'wp-reso' ),
			__( 'VN', 'wp-reso' ),
			__( 'VU', 'wp-reso' ),
			__( 'WF', 'wp-reso' ),
			__( 'WS', 'wp-reso' ),
			__( 'YE', 'wp-reso' ),
			__( 'YT', 'wp-reso' ),
			__( 'ZA', 'wp-reso' ),
			__( 'ZM', 'wp-reso' ),
			__( 'ZW', 'wp-reso' ),
		);
	}

	/**
	 * current_financing function.
	 *
	 * @access public
	 * @return Array
	 */
	public function current_financing() {
		return array(
			__( 'Assumable', 'wp-reso' ),
			__( 'Contract', 'wp-reso' ),
			__( 'Conventional', 'wp-reso' ),
			__( 'FHA 203(b)', 'wp-reso' ),
			__( 'FHA 203(k)', 'wp-reso' ),
			__( 'FHA', 'wp-reso' ),
			__( 'Leased Renewable', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Power Purchase Agreement', 'wp-reso' ),
			__( 'Private', 'wp-reso' ),
			__( 'Property-Assessed Clean Energy', 'wp-reso' ),
			__( 'Trust Deed', 'wp-reso' ),
			__( 'USDA', 'wp-reso' ),
			__( 'VA', 'wp-reso' ),
		);
	}

	/**
	 * direction_faces function.
	 *
	 * @access public
	 * @return Array
	 */
	public function direction_faces() {
		return array(
			__( 'East', 'wp-reso' ),
			__( 'North', 'wp-reso' ),
			__( 'Northeast', 'wp-reso' ),
			__( 'Northwest', 'wp-reso' ),
			__( 'South', 'wp-reso' ),
			__( 'Southeast', 'wp-reso' ),
			__( 'Southwest', 'wp-reso' ),
			__( 'West', 'wp-reso' ),

		);
	}

	/**
	 * electric function.
	 *
	 * @access public
	 * @return Array
	 */
	public function electric() {
		return array(
			__( '100 Amp Service', 'wp-reso' ),
			__( '150 Amp Service', 'wp-reso' ),
			__( '200+ Amp Service', 'wp-reso' ),
			__( '220 Volts', 'wp-reso' ),
			__( '220 Volts For Spa', 'wp-reso' ),
			__( '220 Volts in Garage', 'wp-reso' ),
			__( '220 Volts in Kitchen', 'wp-reso' ),
			__( '220 Volts in Laundry', 'wp-reso' ),
			__( '220 Volts in Workshop', 'wp-reso' ),
			__( '440 Volts', 'wp-reso' ),
			__( 'Circuit Breakers', 'wp-reso' ),
			__( 'Energy Storage Device', 'wp-reso' ),
			__( 'Fuses', 'wp-reso' ),
			__( 'Generator', 'wp-reso' ),
			__( 'Net Meter', 'wp-reso' ),
			__( 'Photovoltaics Seller Owned', 'wp-reso' ),
			__( 'Photovoltaics Third-Party Owned', 'wp-reso' ),
			__( 'Pre-Wired for Renewables', 'wp-reso' ),
			__( 'Ready for Renewables ', 'wp-reso' ),
			__( 'Underground', 'wp-reso' ),
			__( 'Wind Turbine Seller Owned', 'wp-reso' ),
			__( 'Wind Turbine Third-Party Owned', 'wp-reso' ),
		);
	}

	/**
	 * existing_lease_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function existing_lease_type() {
		return array(
			__( 'Absolute Net', 'wp-reso' ),
			__( 'CPI Adjustment', 'wp-reso' ),
			__( 'Escalation Clause', 'wp-reso' ),
			__( 'Gross', 'wp-reso' ),
			__( 'Ground Lease', 'wp-reso' ),
			__( 'Net', 'wp-reso' ),
			__( 'NN', 'wp-reso' ),
			__( 'NNN', 'wp-reso' ),
			__( 'Oral', 'wp-reso' ),

		);
	}

	/**
	 * fee_frequency function.
	 *
	 * @access public
	 * @return Array
	 */
	public function fee_frequency() {
		return array(
			__( 'Annually', 'wp-reso' ),
			__( 'Bi-Monthly', 'wp-reso' ),
			__( 'Bi-Weekly', 'wp-reso' ),
			__( 'Daily', 'wp-reso' ),
			__( 'Monthly', 'wp-reso' ),
			__( 'One Time', 'wp-reso' ),
			__( 'Quarterly', 'wp-reso' ),
			__( 'Seasonal', 'wp-reso' ),
			__( 'Semi-Annually', 'wp-reso' ),
			__( 'Semi-Monthly', 'wp-reso' ),
			__( 'Weekly', 'wp-reso' ),
		);
	}

	/**
	 * financial_data_source function.
	 *
	 * @access public
	 * @return Array
	 */
	public function financial_data_source() {
		return array(
			__( 'Accountant', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Property Manager', 'wp-reso' ),
		);
	}

	/**
	 * foundation_details function.
	 *
	 * @access public
	 * @return Array
	 */
	public function foundation_details() {
		return array(
			__( 'Block', 'wp-reso' ),
			__( 'Brick/Mortar', 'wp-reso' ),
			__( 'Combination', 'wp-reso' ),
			__( 'Concrete Perimeter', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Permanent', 'wp-reso' ),
			__( 'Pillar/Post/Pier', 'wp-reso' ),
			__( 'Raised', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Slab', 'wp-reso' ),
			__( 'Stone', 'wp-reso' ),
		);
	}

	/**
	 * furnished function.
	 *
	 * @access public
	 * @return Array
	 */
	public function furnished() {
		return array(
			__( 'Furnished', 'wp-reso' ),
			__( 'Partially', 'wp-reso' ),
			__( 'Unfurnished', 'wp-reso' ),
		);
	}

	/**
	 * green_building_verification function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_building_verification() {
		return array(
			__( 'Certified Passive House', 'wp-reso' ),
			__( 'ENERGY STAR Certified Homes', 'wp-reso' ),
			__( 'EnerPHit', 'wp-reso' ),
			__( 'HERS Index Score', 'wp-reso' ),
			__( 'Home Energy Score', 'wp-reso' ),
			__( 'Home Energy Upgrade Certificate of Energy Efficiency Improvements', 'wp-reso' ),
			__( 'Home Energy Upgrade Certificate of Energy Efficiency Performance', 'wp-reso' ),
			__( 'Home Performance with ENERGY STAR', 'wp-reso' ),
			__( 'Indoor airPLUS', 'wp-reso' ),
			__( 'LEED For Homes', 'wp-reso' ),
			__( 'Living Building Challenge', 'wp-reso' ),
			__( 'NGBS New Construction', 'wp-reso' ),
			__( 'NGBS Small Projects Remodel', 'wp-reso' ),
			__( 'NGBS Whole-Home Remodel', 'wp-reso' ),
			__( 'PHIUS+', 'wp-reso' ),
			__( 'WaterSense', 'wp-reso' ),
			__( 'Zero Energy Ready Home', 'wp-reso' ),
		);
	}

	/**
	 * green_energy_efficient function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_energy_efficient() {
		return array(
			__( 'Appliances', 'wp-reso' ),
			__( 'Construction', 'wp-reso' ),
			__( 'Doors', 'wp-reso' ),
			__( 'Exposure/Shade', 'wp-reso' ),
			__( 'HVAC', 'wp-reso' ),
			__( 'Incentives', 'wp-reso' ),
			__( 'Insulation', 'wp-reso' ),
			__( 'Lighting', 'wp-reso' ),
			__( 'Roof', 'wp-reso' ),
			__( 'Thermostat', 'wp-reso' ),
			__( 'Water Heater', 'wp-reso' ),
			__( 'Windows', 'wp-reso' ),
		);
	}

	/**
	 * green_energy_generation function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_energy_generation() {
		return array(
			__( 'Solar', 'wp-reso' ),
			__( 'Wind', 'wp-reso' ),
		);
	}

	/**
	 * green_indoor_air_quality function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_indoor_air_quality() {
		return array(
			__( 'Contaminant Control', 'wp-reso' ),
			__( 'Integrated Pest Management', 'wp-reso' ),
			__( 'Moisture Control', 'wp-reso' ),
			__( 'Ventilation', 'wp-reso' ),
		);
	}

	/**
	 * green_sustainability function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_sustainability() {
		return array(
			__( 'Conserving Methods', 'wp-reso' ),
			__( 'Onsite Recycling Center', 'wp-reso' ),
			__( 'Recyclable Materials', 'wp-reso' ),
			__( 'Recycled Materials', 'wp-reso' ),
			__( 'Regionally-Sourced Materials', 'wp-reso' ),
			__( 'Renewable Materials', 'wp-reso' ),
			__( 'Salvaged Materials', 'wp-reso' ),
		);
	}

	/**
	 * green_verification_source function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_verification_source() {
		return array(
			__( 'Administrator', 'wp-reso' ),
			__( 'Assessor', 'wp-reso' ),
			__( 'Builder', 'wp-reso' ),
			__( 'Contractor or Installer', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Program Sponsor', 'wp-reso' ),
			__( 'Program Verifier', 'wp-reso' ),
			__( 'Public Records', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
		);
	}

	/**
	 * green_water_conservation function.
	 *
	 * @access public
	 * @return Array
	 */
	public function green_water_conservation() {
		return array(
			__( 'Efficient Hot Water Distribution', 'wp-reso' ),
			__( 'Gray Water System', 'wp-reso' ),
			__( 'Green Infrastructure', 'wp-reso' ),
			__( 'Low-Flow Fixtures', 'wp-reso' ),
			__( 'Water Recycling', 'wp-reso' ),
			__( 'Water-Smart Landscaping', 'wp-reso' ),
		);
	}

	/**
	 * hours_days_of_operation function.
	 *
	 * @access public
	 * @return Array
	 */
	public function hours_days_of_operation() {
		return array(
			__( 'Evenings Only', 'wp-reso' ),
			__( 'Open 7 Days', 'wp-reso' ),
			__( 'Open 8+ Hours/Day', 'wp-reso' ),
			__( 'Open 8 Hours/Day', 'wp-reso' ),
			__( 'Open 24 Hours', 'wp-reso' ),
			__( 'Open -8 Hours/Day', 'wp-reso' ),
			__( 'Open Monday-Friday', 'wp-reso' ),
			__( 'Open Saturday', 'wp-reso' ),
			__( 'Open Sunday', 'wp-reso' ),
		);
	}

	/**
	 * image_of function.
	 *
	 * @access public
	 * @return Array
	 */
	public function image_of() {
		return array(
			__( 'Aerial View', 'wp-reso' ),
			__( 'Atrium', 'wp-reso' ),
			__( 'Attic', 'wp-reso' ),
			__( 'Back of Structure', 'wp-reso' ),
			__( 'Balcony', 'wp-reso' ),
			__( 'Bar', 'wp-reso' ),
			__( 'Barn', 'wp-reso' ),
			__( 'Basement', 'wp-reso' ),
			__( 'Bathroom', 'wp-reso' ),
			__( 'Bedroom', 'wp-reso' ),
			__( 'Bonus Room', 'wp-reso' ),
			__( 'Breakfast Area', 'wp-reso' ),
			__( 'Closet', 'wp-reso' ),
			__( 'Community', 'wp-reso' ),
			__( 'Courtyard', 'wp-reso' ),
			__( 'Deck', 'wp-reso' ),
			__( 'Den', 'wp-reso' ),
			__( 'Dining Area', 'wp-reso' ),
			__( 'Dining Room', 'wp-reso' ),
			__( 'Dock', 'wp-reso' ),
			__( 'Entry', 'wp-reso' ),
			__( 'Exercise Room', 'wp-reso' ),
			__( 'Family Room', 'wp-reso' ),
			__( 'Fence', 'wp-reso' ),
			__( 'Fireplace', 'wp-reso' ),
			__( 'Floor Plan', 'wp-reso' ),
			__( 'Front of Structure', 'wp-reso' ),
			__( 'Game Room', 'wp-reso' ),
			__( 'Garage', 'wp-reso' ),
			__( 'Garden', 'wp-reso' ),
			__( 'Golf Course', 'wp-reso' ),
			__( 'Great Room', 'wp-reso' ),
			__( 'Guest Quarters', 'wp-reso' ),
			__( 'Gym', 'wp-reso' ),
			__( 'Hobby Room', 'wp-reso' ),
			__( 'Inlaw', 'wp-reso' ),
			__( 'Kitchen', 'wp-reso' ),
			__( 'Lake', 'wp-reso' ),
			__( 'Laundry', 'wp-reso' ),
			__( 'Library', 'wp-reso' ),
			__( 'Living Room', 'wp-reso' ),
			__( 'Loading Dock', 'wp-reso' ),
			__( 'Lobby', 'wp-reso' ),
			__( 'Loft', 'wp-reso' ),
			__( 'Lot', 'wp-reso' ),
			__( 'Master Bathroom', 'wp-reso' ),
			__( 'Master Bedroom', 'wp-reso' ),
			__( 'Media Room', 'wp-reso' ),
			__( 'Mud Room', 'wp-reso' ),
			__( 'Nursery', 'wp-reso' ),
			__( 'Office', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Out Buildings', 'wp-reso' ),
			__( 'Pantry', 'wp-reso' ),
			__( 'Parking', 'wp-reso' ),
			__( 'Patio', 'wp-reso' ),
			__( 'Pier', 'wp-reso' ),
			__( 'Plat Map', 'wp-reso' ),
			__( 'Pond', 'wp-reso' ),
			__( 'Pool', 'wp-reso' ),
			__( 'Reception', 'wp-reso' ),
			__( 'Recreation Room', 'wp-reso' ),
			__( 'Sauna', 'wp-reso' ),
			__( 'Showroom', 'wp-reso' ),
			__( 'Side of Structure', 'wp-reso' ),
			__( 'Sitting Room', 'wp-reso' ),
			__( 'Spa', 'wp-reso' ),
			__( 'Stable', 'wp-reso' ),
			__( 'Storage', 'wp-reso' ),
			__( 'Studio', 'wp-reso' ),
			__( 'Study', 'wp-reso' ),
			__( 'Sun Room', 'wp-reso' ),
			__( 'View', 'wp-reso' ),
			__( 'Waterfront', 'wp-reso' ),
			__( 'Wine Cellar', 'wp-reso' ),
			__( 'Workshop', 'wp-reso' ),
			__( 'Yard', 'wp-reso' ),
		);
	}

	/**
	 * income_includes function.
	 *
	 * @access public
	 * @return Array
	 */
	public function income_includes() {
		return array(
			__( 'Laundry', 'wp-reso' ),
			__( 'Parking', 'wp-reso' ),
			__( 'Recreation', 'wp-reso' ),
			__( 'Rent Only', 'wp-reso' ),
			__( 'RV Storage', 'wp-reso' ),
			__( 'Storage', 'wp-reso' ),
		);
	}

	/**
	 * languages function.
	 *
	 * @access public
	 * @return Array
	 */
	public function languages() {
		return array(
			__( 'Abkhazian', 'wp-reso' ),
			__( 'Afar', 'wp-reso' ),
			__( 'Afrikaans', 'wp-reso' ),
			__( 'Albanian', 'wp-reso' ),
			__( 'American Sign Language', 'wp-reso' ),
			__( 'Amharic', 'wp-reso' ),
			__( 'Arabic', 'wp-reso' ),
			__( 'Aramaic', 'wp-reso' ),
			__( 'Armenian', 'wp-reso' ),
			__( 'Assamese', 'wp-reso' ),
			__( 'Assyrian Neo-Aramaic', 'wp-reso' ),
			__( 'Avestan', 'wp-reso' ),
			__( 'Aymara', 'wp-reso' ),
			__( 'Azerbaijani', 'wp-reso' ),
			__( 'Bambara', 'wp-reso' ),
			__( 'Bashkir', 'wp-reso' ),
			__( 'Basque', 'wp-reso' ),
			__( 'Bengali', 'wp-reso' ),
			__( 'Bihari', 'wp-reso' ),
			__( 'Bikol', 'wp-reso' ),
			__( 'Bislama', 'wp-reso' ),
			__( 'Bosnian', 'wp-reso' ),
			__( 'Brazilian Portuguese', 'wp-reso' ),
			__( 'Bulgarian', 'wp-reso' ),
			__( 'Burmese', 'wp-reso' ),
			__( 'Byelorussian', 'wp-reso' ),
			__( 'Cambodian', 'wp-reso' ),
			__( 'Cantonese', 'wp-reso' ),
			__( 'Cape Verdean Creole', 'wp-reso' ),
			__( 'Catalan', 'wp-reso' ),
			__( 'Cebuano', 'wp-reso' ),
			__( 'Chamorro', 'wp-reso' ),
			__( 'Chechen', 'wp-reso' ),
			__( 'Chinese', 'wp-reso' ),
			__( 'Chuukese', 'wp-reso' ),
			__( 'Chuvash', 'wp-reso' ),
			__( 'Cornish', 'wp-reso' ),
			__( 'Corsican', 'wp-reso' ),
			__( 'Croatian', 'wp-reso' ),
			__( 'Czech', 'wp-reso' ),
			__( 'Danish', 'wp-reso' ),
			__( 'Dari (Afghan Persian)', 'wp-reso' ),
			__( 'Dioula', 'wp-reso' ),
			__( 'Dutch', 'wp-reso' ),
			__( 'Dzongkha', 'wp-reso' ),
			__( 'English', 'wp-reso' ),
			__( 'Esperanto', 'wp-reso' ),
			__( 'Estonian', 'wp-reso' ),
			__( 'Faroese', 'wp-reso' ),
			__( 'Farsi', 'wp-reso' ),
			__( 'Fiji', 'wp-reso' ),
			__( 'Finnish', 'wp-reso' ),
			__( 'Flemish', 'wp-reso' ),
			__( 'French', 'wp-reso' ),
			__( 'Frisian', 'wp-reso' ),
			__( 'Galician', 'wp-reso' ),
			__( 'Georgian', 'wp-reso' ),
			__( 'German', 'wp-reso' ),
			__( 'Greek', 'wp-reso' ),
			__( 'Greenlandic', 'wp-reso' ),
			__( 'Guarani', 'wp-reso' ),
			__( 'Gujarati', 'wp-reso' ),
			__( 'Haitian Creole', 'wp-reso' ),
			__( 'Hausa', 'wp-reso' ),
			__( 'Hebrew', 'wp-reso' ),
			__( 'Herero', 'wp-reso' ),
			__( 'Hiligaynon', 'wp-reso' ),
			__( 'Hindi', 'wp-reso' ),
			__( 'Hiri Motu', 'wp-reso' ),
			__( 'Hmong', 'wp-reso' ),
			__( 'Hungarian', 'wp-reso' ),
			__( 'Iban', 'wp-reso' ),
			__( 'Icelandic', 'wp-reso' ),
			__( 'Igbo', 'wp-reso' ),
			__( 'Ilocano', 'wp-reso' ),
			__( 'Indonesian', 'wp-reso' ),
			__( 'Interlingua', 'wp-reso' ),
			__( 'Inuktitut', 'wp-reso' ),
			__( 'Inupiak', 'wp-reso' ),
			__( 'Irish (Gaelic)', 'wp-reso' ),
			__( 'Italian', 'wp-reso' ),
			__( 'Japanese', 'wp-reso' ),
			__( 'Javanese', 'wp-reso' ),
			__( 'K\'iche\'', 'wp-reso' ),
			__( 'Kannada', 'wp-reso' ),
			__( 'Kashmiri', 'wp-reso' ),
			__( 'Kazakh', 'wp-reso' ),
			__( 'Kichwa', 'wp-reso' ),
			__( 'Kikuyu', 'wp-reso' ),
			__( 'Kinyarwanda', 'wp-reso' ),
			__( 'Kirghiz', 'wp-reso' ),
			__( 'Kirundi', 'wp-reso' ),
			__( 'Komi', 'wp-reso' ),
			__( 'Korean', 'wp-reso' ),
			__( 'Kpelle', 'wp-reso' ),
			__( 'Kru', 'wp-reso' ),
			__( 'Kurdish', 'wp-reso' ),
			__( 'Lao', 'wp-reso' ),
			__( 'Latin', 'wp-reso' ),
			__( 'Latvian', 'wp-reso' ),
			__( 'Lingala', 'wp-reso' ),
			__( 'Lithuanian', 'wp-reso' ),
			__( 'Luxemburgish', 'wp-reso' ),
			__( 'Macedonian', 'wp-reso' ),
			__( 'Malagasy', 'wp-reso' ),
			__( 'Malay', 'wp-reso' ),
			__( 'Malayalam', 'wp-reso' ),
			__( 'Maltese', 'wp-reso' ),
			__( 'Mandarin', 'wp-reso' ),
			__( 'Maninka', 'wp-reso' ),
			__( 'Manx Gaelic', 'wp-reso' ),
			__( 'Maori', 'wp-reso' ),
			__( 'Marathi', 'wp-reso' ),
			__( 'Marshallese', 'wp-reso' ),
			__( 'Moldovan', 'wp-reso' ),
			__( 'Mongolian', 'wp-reso' ),
			__( 'Nauru', 'wp-reso' ),
			__( 'Navajo', 'wp-reso' ),
			__( 'Ndebele', 'wp-reso' ),
			__( 'Ndonga', 'wp-reso' ),
			__( 'Nepali', 'wp-reso' ),
			__( 'Norwegian', 'wp-reso' ),
			__( 'Norwegian (Nynorsk)', 'wp-reso' ),
			__( 'Nyanja', 'wp-reso' ),
			__( 'Occitan', 'wp-reso' ),
			__( 'Oriya', 'wp-reso' ),
			__( 'Oromo', 'wp-reso' ),
			__( 'Ossetian', 'wp-reso' ),
			__( 'Pali', 'wp-reso' ),
			__( 'Pangasinan', 'wp-reso' ),
			__( 'Papiamento', 'wp-reso' ),
			__( 'Pashto', 'wp-reso' ),
			__( 'Polish', 'wp-reso' ),
			__( 'Portuguese', 'wp-reso' ),
			__( 'Punjabi', 'wp-reso' ),
			__( 'Quechua', 'wp-reso' ),
			__( 'Romanian', 'wp-reso' ),
			__( 'Romany', 'wp-reso' ),
			__( 'Russian', 'wp-reso' ),
			__( 'Sami', 'wp-reso' ),
			__( 'Samoan', 'wp-reso' ),
			__( 'Sangho', 'wp-reso' ),
			__( 'Sanskrit', 'wp-reso' ),
			__( 'Sardinian', 'wp-reso' ),
			__( 'Scots Gaelic', 'wp-reso' ),
			__( 'Serbian', 'wp-reso' ),
			__( 'Serbo-Croatian', 'wp-reso' ),
			__( 'Sesotho', 'wp-reso' ),
			__( 'Setswana', 'wp-reso' ),
			__( 'Shan', 'wp-reso' ),
			__( 'Shona', 'wp-reso' ),
			__( 'Sindhi', 'wp-reso' ),
			__( 'Sinhalese', 'wp-reso' ),
			__( 'Siswati', 'wp-reso' ),
			__( 'Slovak', 'wp-reso' ),
			__( 'Slovenian', 'wp-reso' ),
			__( 'Somali', 'wp-reso' ),
			__( 'Southern Ndebele', 'wp-reso' ),
			__( 'Spanish', 'wp-reso' ),
			__( 'Sundanese', 'wp-reso' ),
			__( 'Swahili', 'wp-reso' ),
			__( 'Swedish', 'wp-reso' ),
			__( 'Syriac', 'wp-reso' ),
			__( 'Tagalog', 'wp-reso' ),
			__( 'Tahitian', 'wp-reso' ),
			__( 'Tajik', 'wp-reso' ),
			__( 'Tamil', 'wp-reso' ),
			__( 'Tatar', 'wp-reso' ),
			__( 'Telugu', 'wp-reso' ),
			__( 'Thai', 'wp-reso' ),
			__( 'Tibetan', 'wp-reso' ),
			__( 'Tigrinya', 'wp-reso' ),
			__( 'Tongan', 'wp-reso' ),
			__( 'Tsonga', 'wp-reso' ),
			__( 'Turkish', 'wp-reso' ),
			__( 'Turkmen', 'wp-reso' ),
			__( 'Twi', 'wp-reso' ),
			__( 'Uigur', 'wp-reso' ),
			__( 'Ukrainian', 'wp-reso' ),
			__( 'Urdu', 'wp-reso' ),
			__( 'Uzbek', 'wp-reso' ),
			__( 'Vietnamese', 'wp-reso' ),
			__( 'Volapuk', 'wp-reso' ),
			__( 'Welsh', 'wp-reso' ),
			__( 'Wolof', 'wp-reso' ),
			__( 'Xhosa', 'wp-reso' ),
			__( 'Yiddish', 'wp-reso' ),
			__( 'Yoruba', 'wp-reso' ),
			__( 'Zhuang', 'wp-reso' ),
			__( 'Zulu', 'wp-reso' ),
		);
	}

	/**
	 * lease_renewal_compensation function.
	 *
	 * @access public
	 * @return Array
	 */
	public function lease_renewal_compensation() {
		return array(
			__( 'Call Listing Agent', 'wp-reso' ),
			__( 'Call Listing Office', 'wp-reso' ),
			__( 'Commission Paid On Tenant Purchase', 'wp-reso' ),
			__( 'No Renewal Commission', 'wp-reso' ),
			__( 'Renewal Commission Paid', 'wp-reso' ),
		);
	}

	/**
	 * lease_term function.
	 *
	 * @access public
	 * @return Array
	 */
	public function lease_term() {
		return array(
			__( '6 Months', 'wp-reso' ),
			__( '12 Months', 'wp-reso' ),
			__( '24 Months', 'wp-reso' ),
			__( 'Month To Month', 'wp-reso' ),
			__( 'Negotiable', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Renewal Option', 'wp-reso' ),
			__( 'Short Term Lease', 'wp-reso' ),
			__( 'Weekly', 'wp-reso' ),
		);
	}

	/**
	 * levels function.
	 *
	 * @access public
	 * @return Array
	 */
	public function levels() {
		return array(
			__( 'Multi/Split', 'wp-reso' ),
			__( 'One', 'wp-reso' ),
			__( 'Three Or More', 'wp-reso' ),
			__( 'Two', 'wp-reso' ),
		);
	}

	/**
	 * linear_units function.
	 *
	 * @access public
	 * @return Array
	 */
	public function linear_units() {
		return array(
			__( 'Feet', 'wp-reso' ),
			__( 'Meters', 'wp-reso' ),
		);
	}

	/**
	 * listing_agreement function.
	 *
	 * @access public
	 * @return Array
	 */
	public function listing_agreement() {
		return array(
			__( 'Exclusive Agency', 'wp-reso' ),
			__( 'Exclusive Right To Lease', 'wp-reso' ),
			__( 'Exclusive Right To Sell', 'wp-reso' ),
			__( 'Exclusive Right With Exception', 'wp-reso' ),
			__( 'Net', 'wp-reso' ),
			__( 'Open', 'wp-reso' ),
			__( 'Probate', 'wp-reso' ),
		);
	}

	/**
	 * listing_service function.
	 *
	 * @access public
	 * @return Array
	 */
	public function listing_service() {
		return array(
			__( 'Entry Only', 'wp-reso' ),
			__( 'Full Service', 'wp-reso' ),
			__( 'Limited Service', 'wp-reso' ),
		);
	}

	/**
	 * listing_terms function.
	 *
	 * @access public
	 * @return Array
	 */
	public function listing_terms() {
		return array(
			__( '1031 Exchange', 'wp-reso' ),
			__( 'All Inclusive Trust Deed', 'wp-reso' ),
			__( 'Assumable', 'wp-reso' ),
			__( 'Cash', 'wp-reso' ),
			__( 'Contract', 'wp-reso' ),
			__( 'Conventional', 'wp-reso' ),
			__( 'Existing Bonds', 'wp-reso' ),
			__( 'FHA', 'wp-reso' ),
			__( 'Land Use Fee', 'wp-reso' ),
			__( 'Lease Back', 'wp-reso' ),
			__( 'Lease Option', 'wp-reso' ),
			__( 'Lease Purchase', 'wp-reso' ),
			__( 'Lien Release', 'wp-reso' ),
			__( 'Owner May Carry', 'wp-reso' ),
			__( 'Owner Pay Points', 'wp-reso' ),
			__( 'Owner Will Carry', 'wp-reso' ),
			__( 'Private Financing Available', 'wp-reso' ),
			__( 'Relocation Property', 'wp-reso' ),
			__( 'Seller Equity Share', 'wp-reso' ),
			__( 'Special Funding', 'wp-reso' ),
			__( 'Submit', 'wp-reso' ),
			__( 'Trade', 'wp-reso' ),
			__( 'Trust Conveyance', 'wp-reso' ),
			__( 'Trust Deed', 'wp-reso' ),
			__( 'USDA Loan', 'wp-reso' ),
			__( 'VA Loan', 'wp-reso' ),
		);
	}

	/**
	 * lockbox_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function lockbox_type() {
		return array(
			__( 'Call Listing Office', 'wp-reso' ),
			__( 'Call Seller Direct', 'wp-reso' ),
			__( 'Combo', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'SentriLock', 'wp-reso' ),
			__( 'Supra', 'wp-reso' ),
		);
	}

	/**
	 * lot_size_source function.
	 *
	 * @access public
	 * @return Array
	 */
	public function lot_size_source() {
		return array(
			__( 'Appraiser', 'wp-reso' ),
			__( 'Assessor', 'wp-reso' ),
			__( 'Builder', 'wp-reso' ),
			__( 'Estimated', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Plans', 'wp-reso' ),
			__( 'Public Records', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
		);
	}

	/**
	 * lot_size_units function.
	 *
	 * @access public
	 * @return Array
	 */
	public function lot_size_units() {
		return array(
			__( 'Acres', 'wp-reso' ),
			__( 'Square Feet', 'wp-reso' ),
			__( 'Square Meters', 'wp-reso' ),
		);
	}

	/**
	-
	 * media_category function.
	 *
	 * @access public
	 * @return Array
	 */
	public function media_category() {
		return array(
			__( 'Agent Photo', 'wp-reso' ),
			__( 'Branded Virtual Tour', 'wp-reso' ),
			__( 'Document', 'wp-reso' ),
			__( 'Floor Plan', 'wp-reso' ),
			__( 'Office Logo', 'wp-reso' ),
			__( 'Office Photo', 'wp-reso' ),
			__( 'Photo', 'wp-reso' ),
			__( 'Unbranded Virtual Tour', 'wp-reso' ),
			__( 'Video', 'wp-reso' ),
		);
	}

	/**
	 * media_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function media_type() {
		return array(
			__( 'doc', 'wp-reso' ),
			__( 'docx', 'wp-reso' ),
			__( 'gif', 'wp-reso' ),
			__( 'jpeg', 'wp-reso' ),
			__( 'mp4', 'wp-reso' ),
			__( 'mpeg', 'wp-reso' ),
			__( 'pdf', 'wp-reso' ),
			__( 'png', 'wp-reso' ),
			__( 'quicktime', 'wp-reso' ),
			__( 'rtf', 'wp-reso' ),
			__( 'tiff', 'wp-reso' ),
			__( 'txt', 'wp-reso' ),
			__( 'wmv', 'wp-reso' ),
			__( 'xls', 'wp-reso' ),
			__( 'xlsx', 'wp-reso' ),
		);
	}

	/**
	 * member_status function.
	 *
	 * @access public
	 * @return Array
	 */
	public function member_status() {
		return array(
			__( 'Active', 'wp-reso' ),
			__( 'Inactive', 'wp-reso' ),
		);
	}

	/**
	 * member_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function member_type() {
		return array(
			__( 'Association Staff', 'wp-reso' ),
			__( 'Designated REALTOR Appraiser', 'wp-reso' ),
			__( 'Designated REALTOR Participant', 'wp-reso' ),
			__( 'MLS Only Appraiser', 'wp-reso' ),
			__( 'MLS Only Broker', 'wp-reso' ),
			__( 'MLS Only Salesperson', 'wp-reso' ),
			__( 'MLS Staff', 'wp-reso' ),
			__( 'Non Member/Vendor', 'wp-reso' ),
			__( 'Office Manager', 'wp-reso' ),
			__( 'REALTOR Appraiser', 'wp-reso' ),
			__( 'REALTOR Salesperson', 'wp-reso' ),
			__( 'Unlicensed Assistant', 'wp-reso' ),
		);
	}

	/**
	 * occupant_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function occupant_type() {
		return array(
			__( 'Owner', 'wp-reso' ),
			__( 'Tenant', 'wp-reso' ),
			__( 'Vacant', 'wp-reso' ),
		);
	}

	/**
	 * office_status function.
	 *
	 * @access public
	 * @return Array
	 */
	public function office_status() {
		return array(
			__( 'Active', 'wp-reso' ),
			__( 'Inactive', 'wp-reso' ),
		);
	}

	/**
	 * office_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function office_type() {
		return array(
			__( 'Affiliate', 'wp-reso' ),
			__( 'Appraiser', 'wp-reso' ),
			__( 'Association', 'wp-reso' ),
			__( 'MLS', 'wp-reso' ),
			__( 'MLS Only Branch', 'wp-reso' ),
			__( 'MLS Only Firm', 'wp-reso' ),
			__( 'MLS Only Office', 'wp-reso' ),
			__( 'Non Member/Vendor', 'wp-reso' ),
			__( 'Realtor Branch Office', 'wp-reso' ),
			__( 'Realtor Firm', 'wp-reso' ),
			__( 'Realtor Office', 'wp-reso' ),
		);
	}

	/**
	 * open_house_status function.
	 *
	 * @access public
	 * @return Array
	 */
	public function open_house_status() {
		return array(
			__( 'Active', 'wp-reso' ),
			__( 'Canceled', 'wp-reso' ),
			__( 'Ended', 'wp-reso' ),
		);
	}

	/**
	 * open_house_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function open_house_type() {
		return array(
			__( 'Broker', 'wp-reso' ),
			__( 'Office', 'wp-reso' ),
			__( 'Public', 'wp-reso' ),
		);
	}

	/**
	 * operating_expense_includes function.
	 *
	 * @access public
	 * @return Array
	 */
	public function operating_expense_includes() {
		return array(
			__( 'Accounting', 'wp-reso' ),
			__( 'Advertising', 'wp-reso' ),
			__( 'Association', 'wp-reso' ),
			__( 'Cable TV', 'wp-reso' ),
			__( 'Capital Improvements', 'wp-reso' ),
			__( 'Depreciation', 'wp-reso' ),
			__( 'Equipment Rental', 'wp-reso' ),
			__( 'Fuel', 'wp-reso' ),
			__( 'Furniture Replacement', 'wp-reso' ),
			__( 'Gardener', 'wp-reso' ),
			__( 'Insurance', 'wp-reso' ),
			__( 'Legal', 'wp-reso' ),
			__( 'Licenses', 'wp-reso' ),
			__( 'Maintenance', 'wp-reso' ),
			__( 'Maintenance Grounds', 'wp-reso' ),
			__( 'Maintenance Structure', 'wp-reso' ),
			__( 'Manager', 'wp-reso' ),
			__( 'Mortgage/Loans', 'wp-reso' ),
			__( 'New Tax', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Parking', 'wp-reso' ),
			__( 'Pest Control', 'wp-reso' ),
			__( 'Pool/Spa', 'wp-reso' ),
			__( 'Professional Management', 'wp-reso' ),
			__( 'Security', 'wp-reso' ),
			__( 'Snow Removal', 'wp-reso' ),
			__( 'Staff', 'wp-reso' ),
			__( 'Supplies', 'wp-reso' ),
			__( 'Trash', 'wp-reso' ),
			__( 'Utilities', 'wp-reso' ),
			__( 'Vacancy Allowance', 'wp-reso' ),
			__( 'Water/Sewer', 'wp-reso' ),
			__( 'Workmans Compensation', 'wp-reso' ),
		);
	}

	/**
	 * owner_pays function.
	 *
	 * @access public
	 * @return Array
	 */
	public function owner_pays() {
		return array(
			__( 'All Utilities', 'wp-reso' ),
			__( 'Association Fees', 'wp-reso' ),
			__( 'Cable TV', 'wp-reso' ),
			__( 'Common Area Maintenance', 'wp-reso' ),
			__( 'Electricity', 'wp-reso' ),
			__( 'Exterior Maintenance', 'wp-reso' ),
			__( 'Gas', 'wp-reso' ),
			__( 'Grounds Care', 'wp-reso' ),
			__( 'Hot Water', 'wp-reso' ),
			__( 'HVAC Maintenance', 'wp-reso' ),
			__( 'Insurance', 'wp-reso' ),
			__( 'Janitorial Service', 'wp-reso' ),
			__( 'Management', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Other Tax', 'wp-reso' ),
			__( 'Parking Fee', 'wp-reso' ),
			__( 'Pest Control', 'wp-reso' ),
			__( 'Pool Maintenance', 'wp-reso' ),
			__( 'Repairs', 'wp-reso' ),
			__( 'Roof Maintenance', 'wp-reso' ),
			__( 'Security', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Sewer', 'wp-reso' ),
			__( 'Snow Removal', 'wp-reso' ),
			__( 'Taxes', 'wp-reso' ),
			__( 'Telephone', 'wp-reso' ),
			__( 'Trash Collection', 'wp-reso' ),
			__( 'Water', 'wp-reso' ),
		);
	}

	/**
	 * ownership_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function ownership_type() {
		return array(
			__( 'Corporation', 'wp-reso' ),
			__( 'LLC', 'wp-reso' ),
			__( 'Partnership', 'wp-reso' ),
			__( 'Sole Proprietor', 'wp-reso' ),
		);
	}

	/**
	 * pets_allowed function.
	 *
	 * @access public
	 * @return Array
	 */
	public function pets_allowed() {
		return array(
			__( 'Breed Restrictions', 'wp-reso' ),
			__( 'Call', 'wp-reso' ),
			__( 'Cats OK', 'wp-reso' ),
			__( 'Dogs OK', 'wp-reso' ),
			__( 'No', 'wp-reso' ),
			__( 'Number Limit', 'wp-reso' ),
			__( 'Size Limit', 'wp-reso' ),
			__( 'Yes', 'wp-reso' ),
		);
	}

	/**
	 * possession function.
	 *
	 * @access public
	 * @return Array
	 */
	public function possession() {
		return array(
			__( 'Close Of Escrow', 'wp-reso' ),
			__( 'Close Plus 1 Day', 'wp-reso' ),
			__( 'Close Plus 2 Days', 'wp-reso' ),
			__( 'Close Plus 3 Days', 'wp-reso' ),
			__( 'Close Plus 3 to 5 Days', 'wp-reso' ),
			__( 'Close Plus 30 Days', 'wp-reso' ),
			__( 'Negotiable', 'wp-reso' ),
			__( 'Rental Agreement', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Seller Rent Back', 'wp-reso' ),
			__( 'Subject To Tenant Rights', 'wp-reso' ),
		);
	}

	/**
	 * power_production_annual_status function.
	 *
	 * @access public
	 * @return Array
	 */
	public function power_production_annual_status() {
		return array(
			__( 'Actual', 'wp-reso' ),
			__( 'Estimated', 'wp-reso' ),
			__( 'Partially Estimated', 'wp-reso' ),
		);
	}

	/**
	 * power_production_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function power_production_type() {
		return array(
			__( 'Photovoltaics', 'wp-reso' ),
			__( 'Wind', 'wp-reso' ),
		);
	}

	/**
	 * property_condition function.
	 *
	 * @access public
	 * @return Array
	 */
	public function property_condition() {
		return array(
			__( 'Fixer', 'wp-reso' ),
			__( 'New Construction', 'wp-reso' ),
			__( 'Under Construction', 'wp-reso' ),
			__( 'Updated/Remodeled', 'wp-reso' ),
		);
	}

	/**
	 * property_subtype function.
	 *
	 * @access public
	 * @return Array
	 */
	public function property_subtype() {
		return array(
			__( 'Apartment', 'wp-reso' ),
			__( 'Boat Slip', 'wp-reso' ),
			__( 'Cabin', 'wp-reso' ),
			__( 'Condominium', 'wp-reso' ),
			__( 'Deeded Parking', 'wp-reso' ),
			__( 'Duplex', 'wp-reso' ),
			__( 'Farm', 'wp-reso' ),
			__( 'Manufactured Home', 'wp-reso' ),
			__( 'Manufactured On Land', 'wp-reso' ),
			__( 'Mobile Home', 'wp-reso' ),
			__( 'Own Your Own', 'wp-reso' ),
			__( 'Quadruplex', 'wp-reso' ),
			__( 'Ranch', 'wp-reso' ),
			__( 'Single Family Residence', 'wp-reso' ),
			__( 'Stock Cooperative', 'wp-reso' ),
			__( 'Timeshare', 'wp-reso' ),
			__( 'Townhouse', 'wp-reso' ),
			__( 'Triplex', 'wp-reso' ),
		);
	}

	/**
	 * property_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function property_type() {
		return array(
			__( 'Business Opportunity', 'wp-reso' ),
			__( 'Commercial Lease', 'wp-reso' ),
			__( 'Commercial Sale', 'wp-reso' ),
			__( 'Farm', 'wp-reso' ),
			__( 'Land', 'wp-reso' ),
			__( 'Manufactured In Park', 'wp-reso' ),
			__( 'Residential', 'wp-reso' ),
			__( 'Residential Income', 'wp-reso' ),
			__( 'Residential Lease', 'wp-reso' ),
		);
	}

	/**
	 * rent_includes function.
	 *
	 * @access public
	 * @return Array
	 */
	public function rent_includes() {
		return array(
			__( 'All Utilities', 'wp-reso' ),
			__( 'Cable TV', 'wp-reso' ),
			__( 'Electricity', 'wp-reso' ),
			__( 'Gardener', 'wp-reso' ),
			__( 'Gas', 'wp-reso' ),
			__( 'Internet', 'wp-reso' ),
			__( 'Management', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Sewer', 'wp-reso' ),
			__( 'Trash Collection', 'wp-reso' ),
			__( 'Water', 'wp-reso' ),
		);
	}

	/**
	 * resource_name function.
	 *
	 * @access public
	 * @return Array
	 */
	public function resource_name() {
		return array(
			__( 'Contacts', 'wp-reso' ),
			__( 'Member', 'wp-reso' ),
			__( 'Office', 'wp-reso' ),
			__( 'Property', 'wp-reso' ),
		);
	}

	/**
	 * roof function.
	 *
	 * @access public
	 * @return Array
	 */
	public function roof() {
		return array(
			__( 'Aluminum', 'wp-reso' ),
			__( 'Asbestos Shingle', 'wp-reso' ),
			__( 'Asphalt', 'wp-reso' ),
			__( 'Bahama', 'wp-reso' ),
			__( 'Barrel', 'wp-reso' ),
			__( 'Bituthene', 'wp-reso' ),
			__( 'Built-Up', 'wp-reso' ),
			__( 'Composition', 'wp-reso' ),
			__( 'Concrete', 'wp-reso' ),
			__( 'Copper', 'wp-reso' ),
			__( 'Elastomeric', 'wp-reso' ),
			__( 'Fiberglass', 'wp-reso' ),
			__( 'Flat', 'wp-reso' ),
			__( 'Flat Tile', 'wp-reso' ),
			__( 'Foam', 'wp-reso' ),
			__( 'Green Roof', 'wp-reso' ),
			__( 'Mansard', 'wp-reso' ),
			__( 'Membrane', 'wp-reso' ),
			__( 'Metal', 'wp-reso' ),
			__( 'Mixed', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Rolled/Hot Mop', 'wp-reso' ),
			__( 'Rubber', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Shake', 'wp-reso' ),
			__( 'Shingle', 'wp-reso' ),
			__( 'Slate', 'wp-reso' ),
			__( 'Spanish Tile', 'wp-reso' ),
			__( 'Stone', 'wp-reso' ),
			__( 'Synthetic', 'wp-reso' ),
			__( 'Tar/Gravel', 'wp-reso' ),
			__( 'Tile', 'wp-reso' ),
			__( 'Wood', 'wp-reso' ),
		);
	}

	/**
	 * room_type function.
	 *
	 * @access public
	 * @return Array
	 */
	public function room_type() {
		return array(
			__( 'Basement', 'wp-reso' ),
			__( 'Bathroom 1', 'wp-reso' ),
			__( 'Bathroom 2', 'wp-reso' ),
			__( 'Bathroom 3', 'wp-reso' ),
			__( 'Bathroom 4', 'wp-reso' ),
			__( 'Bathroom 5', 'wp-reso' ),
			__( 'Bedroom 1', 'wp-reso' ),
			__( 'Bedroom 2', 'wp-reso' ),
			__( 'Bedroom 3', 'wp-reso' ),
			__( 'Bedroom 4', 'wp-reso' ),
			__( 'Bedroom 5', 'wp-reso' ),
			__( 'Bonus Room', 'wp-reso' ),
			__( 'Den', 'wp-reso' ),
			__( 'Dining Room', 'wp-reso' ),
			__( 'Exercise Room', 'wp-reso' ),
			__( 'Family Room', 'wp-reso' ),
			__( 'Game Room', 'wp-reso' ),
			__( 'Great Room', 'wp-reso' ),
			__( 'Gym', 'wp-reso' ),
			__( 'Kitchen', 'wp-reso' ),
			__( 'Laundry', 'wp-reso' ),
			__( 'Library', 'wp-reso' ),
			__( 'Living Room', 'wp-reso' ),
			__( 'Loft', 'wp-reso' ),
			__( 'Master Bathroom', 'wp-reso' ),
			__( 'Master Bedroom', 'wp-reso' ),
			__( 'Media Room', 'wp-reso' ),
			__( 'Office', 'wp-reso' ),
			__( 'Sauna', 'wp-reso' ),
			__( 'Utility Room', 'wp-reso' ),
			__( 'Workshop', 'wp-reso' ),
		);
	}

	/**
	 * sewer function.
	 *
	 * @access public
	 * @return Array
	 */
	public function sewer() {
		return array(
			__( 'Aerobic Septic', 'wp-reso' ),
			__( 'Cesspool', 'wp-reso' ),
			__( 'Engineered Septic', 'wp-reso' ),
			__( 'Holding Tank', 'wp-reso' ),
			__( 'Mound Septic', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Perc Test On File', 'wp-reso' ),
			__( 'Perc Test Required', 'wp-reso' ),
			__( 'Private Sewer', 'wp-reso' ),
			__( 'Public Sewer', 'wp-reso' ),
			__( 'Septic Needed', 'wp-reso' ),
			__( 'Septic Tank', 'wp-reso' ),
			__( 'Shared Septic', 'wp-reso' ),
			__( 'Unknown', 'wp-reso' ),
		);
	}

	public function showing_contact_type() {
		return array(
			__( 'Agent', 'wp-reso' ),
			__( 'Occupant', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Property Manager', 'wp-reso' ),
		);
	}

	/**
	 * skirt function.
	 *
	 * @access public
	 * @return Array
	 */
	public function skirt() {
		return array(
			__( 'Aluminum', 'wp-reso' ),
			__( 'Block', 'wp-reso' ),
			__( 'Brick', 'wp-reso' ),
			__( 'Combination', 'wp-reso' ),
			__( 'Concrete', 'wp-reso' ),
			__( 'Fiberglass', 'wp-reso' ),
			__( 'Frame', 'wp-reso' ),
			__( 'Glass', 'wp-reso' ),
			__( 'Masonite', 'wp-reso' ),
			__( 'Metal', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Steel', 'wp-reso' ),
			__( 'Stone', 'wp-reso' ),
			__( 'Stucco', 'wp-reso' ),
			__( 'Synthetic', 'wp-reso' ),
			__( 'Unknown', 'wp-reso' ),
			__( 'Vinyl', 'wp-reso' ),
			__( 'Wood', 'wp-reso' ),
		);
	}

	/**
	 * special_licenses function.
	 *
	 * @access public
	 * @return Array
	 */
	public function special_licenses() {
		return array(
			__( 'Beer/Wine', 'wp-reso' ),
			__( 'Class H', 'wp-reso' ),
			__( 'Entertainment', 'wp-reso' ),
			__( 'Franchise', 'wp-reso' ),
			__( 'Gambling', 'wp-reso' ),
			__( 'Liquor', 'wp-reso' ),
			__( 'Liquor 5 Years Or Less', 'wp-reso' ),
			__( 'Liquor 5 Years Or More', 'wp-reso' ),
			__( 'Liquor-Off Sale', 'wp-reso' ),
			__( 'Liquor-On Sale', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Professional', 'wp-reso' ),
		);
	}

	/**
	 * special_listing_conditions function.
	 *
	 * @access public
	 * @return Array
	 */
	public function special_listing_conditions() {
		return array(
			__( 'Auction', 'wp-reso' ),
			__( 'Bankruptcy Property', 'wp-reso' ),
			__( 'HUD Owned', 'wp-reso' ),
			__( 'In Foreclosure', 'wp-reso' ),
			__( 'Notice Of Default', 'wp-reso' ),
			__( 'Probate Listing', 'wp-reso' ),
			__( 'Real Estate Owned', 'wp-reso' ),
			__( 'Short Sale', 'wp-reso' ),
			__( 'Standard', 'wp-reso' ),
			__( 'Third Party Approval', 'wp-reso' ),
		);
	}

	/**
	 * standard_status function.
	 *
	 * @access public
	 * @return Array
	 */
	public function standard_status() {
		return array(
			__( 'Active', 'wp-reso' ),
			__( 'Active Under Contract', 'wp-reso' ),
			__( 'Canceled', 'wp-reso' ),
			__( 'Closed', 'wp-reso' ),
			__( 'Coming Soon', 'wp-reso' ),
			__( 'Delete', 'wp-reso' ),
			__( 'Expired', 'wp-reso' ),
			__( 'Hold', 'wp-reso' ),
			__( 'Incomplete', 'wp-reso' ),
			__( 'Pending', 'wp-reso' ),
			__( 'Withdrawn', 'wp-reso' ),
		);
	}

	/**
	 * state_or_province function.
	 *
	 * @access public
	 * @return Array
	 */
	public function state_or_province() {
		return array(
			__( 'AB', 'wp-reso' ),
			__( 'AK', 'wp-reso' ),
			__( 'AL', 'wp-reso' ),
			__( 'AR', 'wp-reso' ),
			__( 'AZ', 'wp-reso' ),
			__( 'BC', 'wp-reso' ),
			__( 'CA', 'wp-reso' ),
			__( 'CO', 'wp-reso' ),
			__( 'CT', 'wp-reso' ),
			__( 'DC', 'wp-reso' ),
			__( 'DE', 'wp-reso' ),
			__( 'FL', 'wp-reso' ),
			__( 'GA', 'wp-reso' ),
			__( 'HI', 'wp-reso' ),
			__( 'IA', 'wp-reso' ),
			__( 'ID', 'wp-reso' ),
			__( 'IL', 'wp-reso' ),
			__( 'IN', 'wp-reso' ),
			__( 'KS', 'wp-reso' ),
			__( 'KY', 'wp-reso' ),
			__( 'LA', 'wp-reso' ),
			__( 'MA', 'wp-reso' ),
			__( 'MB', 'wp-reso' ),
			__( 'MD', 'wp-reso' ),
			__( 'ME', 'wp-reso' ),
			__( 'MI', 'wp-reso' ),
			__( 'MN', 'wp-reso' ),
			__( 'MO', 'wp-reso' ),
			__( 'MS', 'wp-reso' ),
			__( 'MT', 'wp-reso' ),
			__( 'NB', 'wp-reso' ),
			__( 'NC', 'wp-reso' ),
			__( 'ND', 'wp-reso' ),
			__( 'NE', 'wp-reso' ),
			__( 'NF', 'wp-reso' ),
			__( 'NH', 'wp-reso' ),
			__( 'NJ', 'wp-reso' ),
			__( 'NM', 'wp-reso' ),
			__( 'NS', 'wp-reso' ),
			__( 'NT', 'wp-reso' ),
			__( 'NU', 'wp-reso' ),
			__( 'NV', 'wp-reso' ),
			__( 'NY', 'wp-reso' ),
			__( 'OH', 'wp-reso' ),
			__( 'OK', 'wp-reso' ),
			__( 'ON', 'wp-reso' ),
			__( 'OR', 'wp-reso' ),
			__( 'PA', 'wp-reso' ),
			__( 'PE', 'wp-reso' ),
			__( 'QC', 'wp-reso' ),
			__( 'RI', 'wp-reso' ),
			__( 'SC', 'wp-reso' ),
			__( 'SD', 'wp-reso' ),
			__( 'SK', 'wp-reso' ),
			__( 'TN', 'wp-reso' ),
			__( 'TX', 'wp-reso' ),
			__( 'UT', 'wp-reso' ),
			__( 'VA', 'wp-reso' ),
			__( 'VI', 'wp-reso' ),
			__( 'VT', 'wp-reso' ),
			__( 'WA', 'wp-reso' ),
			__( 'WI', 'wp-reso' ),
			__( 'WV', 'wp-reso' ),
			__( 'WY', 'wp-reso' ),
			__( 'YT', 'wp-reso' ),
		);
	}

	/**
	 * street_direction function.
	 *
	 * @access public
	 * @return Array
	 */
	public function street_direction() {
		return array(
			__( 'E', 'wp-reso' ),
			__( 'N', 'wp-reso' ),
			__( 'NE', 'wp-reso' ),
			__( 'NW', 'wp-reso' ),
			__( 'S', 'wp-reso' ),
			__( 'SE', 'wp-reso' ),
			__( 'SW', 'wp-reso' ),
			__( 'W', 'wp-reso' ),
		);
	}

	/**
	 * Team Status.
	 *
	 * @access public
	 * @return Array
	 */
	public function team_status() {
		return array(
			'Active',
			'Inactive',
		);
	}

	/**
	 * TenantPays function.
	 *
	 * @access public
	 * @return Array
	 */
	public function tenant_pays() {
		return array(
			__( 'All Utilities Water', 'wp-reso' ),
			__( 'Association Fees', 'wp-reso' ),
			__( 'Cable TV', 'wp-reso' ),
			__( 'Common Area Maintenance', 'wp-reso' ),
			__( 'Electricity', 'wp-reso' ),
			__( 'Exterior Maintenance', 'wp-reso' ),
			__( 'Gas', 'wp-reso' ),
			__( 'Grounds Care', 'wp-reso' ),
			__( 'Hot Water', 'wp-reso' ),
			__( 'HVAC Maintenance', 'wp-reso' ),
			__( 'Insurance', 'wp-reso' ),
			__( 'Janitorial Service', 'wp-reso' ),
			__( 'Management', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Other Tax', 'wp-reso' ),
			__( 'Parking Fee', 'wp-reso' ),
			__( 'Pest Control', 'wp-reso' ),
			__( 'Pool Maintenance', 'wp-reso' ),
			__( 'Repairs', 'wp-reso' ),
			__( 'Roof', 'wp-reso' ),
			__( 'Security', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Sewer', 'wp-reso' ),
			__( 'Snow Removal', 'wp-reso' ),
			__( 'Taxes', 'wp-reso' ),
			__( 'Telephone', 'wp-reso' ),
			__( 'Trash Collection', 'wp-reso' ),
			__( 'Water', 'wp-reso' ),
		);
	}

	/**
	 * Utilities function.
	 *
	 * @access public
	 * @return Array
	 */
	public function utilities() {
		return array(
			__( 'Cable Available', 'wp-reso' ),
			__( 'Cable Connected', 'wp-reso' ),
			__( 'Cable Not Available', 'wp-reso' ),
			__( 'Electricity Available', 'wp-reso' ),
			__( 'Electricity Connected', 'wp-reso' ),
			__( 'Electricity Not Available', 'wp-reso' ),
			__( 'Natural Gas Available', 'wp-reso' ),
			__( 'Natural Gas Connected', 'wp-reso' ),
			__( 'Natural Gas Not Available', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Phone Available', 'wp-reso' ),
			__( 'Phone Connected', 'wp-reso' ),
			__( 'Phone Not Available', 'wp-reso' ),
			__( 'Propane', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Sewer Available', 'wp-reso' ),
			__( 'Sewer Connected', 'wp-reso' ),
			__( 'Sewer Not Available', 'wp-reso' ),
			__( 'Underground Utilities', 'wp-reso' ),
			__( 'Water Available', 'wp-reso' ),
			__( 'Water Connected', 'wp-reso' ),
			__( 'Water Not Available', 'wp-reso' ),
		);
	}

	/**
	 * WaterSource function.
	 *
	 * @access public
	 * @return Array
	 */
	public function water_source() {
		return array(
			__( 'Cistern', 'wp-reso' ),
			__( 'None', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Private', 'wp-reso' ),
			__( 'Public', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
			__( 'Shared Well', 'wp-reso' ),
			__( 'Spring', 'wp-reso' ),
			__( 'Well', 'wp-reso' ),
		);
	}

	/**
	 * YearBuiltSource function.
	 *
	 * @access public
	 * @return Array
	 */
	public function year_built_source() {
		return array(
			__( 'Appraiser', 'wp-reso' ),
			__( 'Assessor', 'wp-reso' ),
			__( 'Builder', 'wp-reso' ),
			__( 'Estimated', 'wp-reso' ),
			__( 'Other', 'wp-reso' ),
			__( 'Owner', 'wp-reso' ),
			__( 'Public Records', 'wp-reso' ),
			__( 'See Remarks', 'wp-reso' ),
		);
	}
}

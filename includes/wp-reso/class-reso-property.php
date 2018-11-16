<?php
/**
 * RESO Property
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Property Class.
 *
 * @package wp-reso-property
 */
class ResoProperty {

	/**
	 * A unique identifier for this record from the immediate source. this is a
	 * string that can include uri or other forms.  alternatively use the
	 * listingkeynumeric for a numeric only key field.  this is the local key of
	 * the system.  when records are received from other systems, a local key is
	 * commonly applied.  if conveying the original keys from the source or
	 * originating systems, see sourcesystemkey and originatingsystemkey.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListingKey+Field
	 * @group property resource, listing group
	 * @maxlength 255
	 * @synonym systemuniqueid, immediatesourceid
	 * @certlevel core
	 * @propertytpes resi,rlse,rinc,land,mobi,farm,coms,coml,buso
	 */
	private $listing_key;

	/**
	 * A unique identifier for this record from the immediate source. this is the
	 * numeric only key and used as an alternative to the listingkey fields.
	 * this is the local key of the system.  when records are received from other
	 * systems, a local key is commonly applied.  if conveying the original keys
	 * from the source or originating systems, see sourcesystemkey and
	 * originatingsystemkey.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListingKeyNumeric+Field
	 * @group property resource, listing group
	 * @maxlength 255
	 * @synonym systemuniqueid, immediatesourceid
	 * @certlevel platinum
	 * @propertytypes resi,rlse,rinc,land,mobi,farm,coms,coml,buso
	 */
	private $listing_key_numeric;

	/**
	 * The well known identifier for the listing. the value may be identical to
	 * that of the listing key, but the listing id is intended to be the value
	 * used by a human to retrieve the information about a specific listing. in a
	 * multiple originating system or a merged system, this value may not be
	 * unique and may require the use of the provider system to create a synthetic
	 * unique value.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListingId+Field
	 * @group property resource, listing group
	 * @maxlength 255
	 * @synonym mlnumber, mlsnumber, listingnumber
	 * @certlevel core
	 * @propertytypes resi, rlse, rinc, land, mobi, farm, coml, buso
	 */
	private $listing_id;


	/**
	 * Finished area within the structure that is at or above the surface of the
	 * ground.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AboveGradeFinishedArea+Field
	 * @group property resource, structure group
	 * @maxlength 14
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $above_grade_finished_area;


	/**
	 * The source of the measurements. This is a pick list of options showing the
	 * source of the measurement. i.e. Agent, Assessor, Estimate, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AboveGradeFinishedAreaSource+Field
	 * @group property resouce, structure group
	 * @maxlength 50
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $above_grade_finished_area_source;


	/**
	 * A pick list of the unit of measurement for the area. i.e. Square Feet,
	 * Square Meters, Acres, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AboveGradeFinishedAreaUnits+Field
	 * @group property resouce, structure group
	 * @maxlength 25
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $above_grade_finished_area_units;


	/**
	 * If the property is located behind an unmanned security gate such as in a
	 * Gated Community, what is the code to gain access through the secured gate.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AccessCode+Field
	 * @group property resource, listing group
	 * @maxlength 25
	 * @synonym gatecode
	 * @certlevel Bronze
	 * @propertytypes resi, rlse, rinc, land, mobi, farm
	 */
	private $access_code;


	/**
	 * A list or description of the accessibility features included in the
	 * sale/lease.
	 *
	 * @var [string list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AccessibilityFeatures+Field
	 * @group property resource, structure group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, coml
	 */
	private $accessibility_features;

	/**
	 * If additional parcels are included in the sale, a list of those parcel's
	 * IDs separated by commas. Do not include the first or primary parcel number,
	 * that should be located in the Parcel Number field.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AdditionalParcelsDescription+Field
	 * @group property resoure, tax group
	 * @maxlength 255
	 * @synonym
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi, farm, coms, commonly
	 */
	private $additional_parcels_description;

	/**
	 * Are there more than one parcel or lot included in the sale?
	 *
	 * @var [boolean]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AdditionalParcelsYN+Field
	 * @group property resource, tax group
	 * @maxlength
	 * @synonym
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi, farm, coms, commonly
	 */
	private $additional_parcels_yn;

	/**
	 * The main or most notable tenants as well as other tenants of the shopping
	 * center or mall in which the commercial property is located.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AnchorsCoTenants+Field
	 * @group property resource, characteristics group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel platinum
	 * @propertytypes coms, coml
	 */
	private $anchors_cotenants;

	/**
	 * A list of the appliances that will be included in the sale/lease of the
	 * property.
	 *
	 * @var [sting list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/Appliances+Field
	 * @group property resource, equipment group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel platinum
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, commonly
	 */
	private $appliances;

	/**
	 * When an MLS has the ability to set a listing to Draft and/or has facility
	 * to allow an agent to input, but their manager to approve the listings
	 * before publishing, this field is used for such control.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ApprovalStatus+Field
	 * @group property resource, listing group
	 * @maxlength 25
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, land, mobi, farm, coms, coml, buso,
	 */
	private $approval_status;

	/**
	 * A list describing the style of the structure. For example, Victorian,
	 * Ranch, Craftsman, etc.
	 *
	 * @var [string list], [structure group]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ArchitecturalStyle+Field
	 * @group property resource, structure group
	 * @maxlength 1024
	 * @synonym style
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $architectural_style;

	/**
	 * Amenities provided by the Home Owners Association, Mobile Park or Complex.
	 * For example Pool, Clubhouse, etc.
	 *
	 * @var [string list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationAmenities+Field
	 * @group property resource, hoa group
	 * @maxlength 1024
	 * @synonym associationrules, associationinfo, hoaamenities
	 * @certlevel platinum
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_amenities;

	/**
	 * A fee paid by the homeowner to the Home Owners Association which is used
	 * for the upkeep of the common area, neighborhood or other association
	 * related benefits.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationFee+Field
	 * @group property resource, hoa group
	 * @maxlength 14
	 * @synonym hoafee, cam charge, condo charge
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_fee;

	/**
	 * A fee paid by the homeowner to the second of two Home Owners Associations,
	 * which is used for the upkeep of the common area, neighborhood or other
	 * association related benefits.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationFee2+Field
	 * @group property resource, hoa group
	 * @maxlength 14
	 * @synonym hoafee2
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_fee_2;

	/**
	 * The frequency the association fee is paid. For example, Weekly, Monthly,
	 * Annually, Bi-Monthly, One Time, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationFee2Frequency+Field
	 * @group property resource, hoa group
	 * @maxlength 25
	 * @synonym hoafee frequency
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_fee_2_frequency;

	/**
	 * The frequency the association fee is paid. For example, Weekly, Monthly,
	 * Annually, Bi-Monthly, One Time, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationFeeFrequency+Field
	 * @group property, hoa group
	 * @maxlength 25
	 * @synonym hoafeefrequency
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_fee_frequency;

	/**
	 * Services included with the association fee. For example Landscaping, Trash,
	 * Water, etc.
	 *
	 * @var [string list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationFeeIncludes+Field
	 * @group property resource, hoa group
	 * @maxlength 1024
	 * @synonym hoafeeincludes
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_fee_includes;

	/**
	 * The name of the Home Owners Association.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationName+Field
	 * @group property resource, hoa group
	 * @maxlength 50
	 * @synonym hoaname
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_name;

	/**
	 * The name of the second of two Home Owners Association
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationName2+Field
	 * @group property resource, hoa group
	 * @maxlength 50
	 * @synonym hoaname2
	 * @certlevel bronze
	 * @propertytypes resi. rlse, rinc, land, mobi
	 */
	private $association_name_2;

	/**
	 * The phone number of the Home Owners Association. North American 10 digit
	 * phone numbers should be in the format of ###-###-#### (separated by
	 * hyphens). Other conventions should use the common local standard.
	 * International numbers should be preceded by a plus symbol.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationPhone+Field
	 * @group property resource, hoa group
	 * @maxlength 16
	 * @synonym hoaphone
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_phone;

	/**
	 * The phone number of the second of two Home Owners Association. North
	 * American 10 digit phone numbers should be in the format of ###-###-####
	 * (separated by hyphens). Other conventions should use the common local
	 * standard. International numbers should be preceded by a plus symbol.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationPhone2+Field
	 * @group property resource, hoa group
	 * @maxlength 16
	 * @synonym hoaphone2
	 * @certlevel bronze
	 * @propertytypes resi, rlse, rinc, land, mobi
	 */
	private $association_phone_2;

	/**
	 * Is there a Home Owners Association. A separate Y/N field is needed because
	 * not all associations have dues.
	 *
	 * @var [boolean]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AssociationYN+Field
	 * @group property resource, hoa group
	 * @maxlength
	 * @synonym hoayn
	 * @certlevel bronze
	 * @propertytypes resi,rlse, rinc, land, mobi
	 */
	private $association_yn;

	/**
	 * A flag indicating that the garage attached to the dwelling.
	 *
	 * @var boolean
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AttachedGarageYN+Field
	 * @group property resource, structure group
	 * @maxlength
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $attached_garage_yn;

	/**
	 * The date the property will be available for possession/occupation.
	 *
	 * @var [date]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/AvailabilityDate+Field
	 * @group property resource, listing group, closing group
	 * @maxlength 10
	 * @synonym
	 * @certlevel silver
	 * @propertytypes rlse, coms, coml
	 */
	private $availability_date;

	/**
	 * A list of information and features about the basement. i.e. None/Slab,
	 * Finished, Partially Finished, Crawl Space, Dirt, Outside Entrance,
	 * Radon Mitigation
	 *
	 * @var [string list],  [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/Basement+Field
	 * @group property resource, structure group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel platinum
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $basement;

	/**
	 * A room containing all 4 of the 4 elements constituting a bath, which are; Toilet,
	 * Sink, Bathtub or Shower Head. A Full Bath will typically contain four elements; Sink,
	 * Toilet, Tub and Shower Head (in tub or stall). However, some may considered a Sink,
	 * Toilet and Tub (without a shower) a Full Bath, others consider this to be a Three
	 * Quarter Bath. In the event that BathroomsThreeQuarter is not in use, this field may
	 * represent the sum of all Full and Three Quarter bathrooms.
	 *
	 * @var [number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsFull+Field
	 * @group Property Resource, Structure Group
	 * @maxlength 3
	 * @synonym BathroomsFull, FullBaths
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, MOBI, FARM
	 * @idxbroker fullBaths
	 */
	private $bathrooms_full;

	/**
	 * A room containing 2 of the 4 elements constituting a bath, which are;
	 * Toilet, Sink, Bathtub or Shower Head. A Half Bath will typically contain a
	 * Sink and Toilet.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsHalf+Field
	 * @group property resource, structure group
	 * @maxlength 3
	 * @synonym bathroomshalf, halfbaths
	 * @certlevel core
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $bathrooms_half;

	/**
	 * A room containing 1 of the 4 elements constituting a bath which are;
	 * Toilet, Sink, Bathtub or Shower Head. Examples are a vanity with a sink or
	 * a WC (Water Closet, which is a room with only a toilet).
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsOneQuarter+Field
	 * @group property resource, structure group
	 * @maxlength 3
	 * @synonym bathroomsonequarter, quarterbaths
	 * @certlevel core
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $bathrooms_one_quarter;

	/**
	 * The number of partial bathrooms in the property being sold/leased. When used in
	 * combination with the BathroomsFull field, this replaces (or is the sum of) all Half
	 * and One Quarter bathrooms; and in the event BathroomsThreeQuarter is not used,
	 * BathroomsFull replaces (or is the sum of) all Full and Three Quarter baths. This
	 * field should not be used in combination with the BathroomsOneQuarter or the BathroomsHalf.
	 *
	 * @var [number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsPartial+Field
	 * @group Property Resource, Structure Group
	 * @maxlength 3
	 * @synonym
	 * @certlevel silver
	 * @propertytpes RESI, RLSE, RINC, MOBI, FARM
	 * @idxbroker partialBaths
	 */
	private $bathrooms_partial;

	/**
	 * A room containing 3 of the 4 elements constituting a bath, which are;
	 * Toilet, Sink, Bathtub or Shower Head. A typical Three Quarter Bath will
	 * contain Sink, Toilet and Shower. Some may considered a Sink, Toilet and Tub
	 * (without a shower) a Three Quarter Bath, others consider this to be a Full
	 * Bath.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsThreeQuarter+Field
	 * @group property resource, structure group
	 * @maxlength 3
	 * @synonym bathroomsthreequarter, threequarterbaths
	 * @certlevel core
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $bathrooms_threequarter;

	/**
	 * The simple sum of the number of bathrooms. For example for a property with two Full
	 * Bathrooms and one Half Bathroom, the Bathrooms Total Integer will be 3. To express
	 * this example as 2.5, use the BathroomsTotalDecimal field. To express this example as
	 * 2.1, use the BathroomsTotalNotational.
	 *
	 * @var [number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BathroomsTotalInteger+Field
	 * @group Property Resource, Structure Group
	 * @maxlength 3
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, MOBI, FARM
	 * @idxbroker totalBaths
	 */
	private $bathrooms_total_integer;

	/**
	 * The sum of BedroomsTotal plus other rooms that may be used as a bedroom but
	 * are not defined as bedroom per local policy.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BedroomsPossible+Field
	 * @group property resource, structure group
	 * @maxlength 3
	 * @synonym bedroomstotal
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $bedrooms_possible;

	/**
	 * The total number of bedrooms in the dwelling
	 *
	 * @var [number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BedroomsTotal+Field
	 * @group Property Resource, Structure Group
	 * @maxlength 3
	 * @synonym BedroomsTotal
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, MOBI, FARM
	 * @idxbroker bedrooms
	 */
	private $bedrooms_total;

	/**
	 * Finished area within the structure that is below ground.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BelowGradeFinishedArea+Field
	 * @group property resource, structure group
	 * @maxlength 14
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $below_grade_finished_area;

	/**
	 * The source of the measurements. This is a pick list of options showing the
	 * source of the measurement. i.e. Agent, Assessor, Estimate, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BelowGradeFinishedAreaSource+Field
	 * @group property resource, structure group
	 * @maxlength 50
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $below_grade_finished_area_source;

	/**
	 * A pick list of the unit of measurement for the area. i.e. Square Feet,
	 * Square Meters, Acres, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BelowGradeFinishedAreaUnits+Field
	 * @group property resource, structure group
	 * @maxlength 25
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm
	 */
	private $below_grade_finished_area_units;

	/**
	 * Type of mobile home.
	 *
	 * @var [string list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BodyType+Field
	 * @group property resource, structure group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel silver
	 * @propertytypes mobi
	 */
	private $body_type;

	/**
	 * The builders model name or number for the property.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuilderModel+Field
	 * @group property resource, structure group
	 * @maxlength 50
	 * @synonym
	 * @certlevel gold
	 * @propertytypes resi, rlse, rinc, farm
	 */
	private $builder_model;

	/**
	 * Name of the builder of the property or builder's tract.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuilderName+Field
	 * @group property resource, struvture group
	 * @maxlength 50
	 * @synonym
	 * @certlevel gold
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, coml
	 */
	private $builder_name;

	/**
	 * The source of the measurements. This is a pick list of options showing the
	 * source of the measurement. i.e. Agent, Assessor, Estimate, etc.
	 *
	 * @var [string list], [structure group]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuildingAreaSource+Field
	 * @group property resource, structure group
	 * @maxlength
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, coml
	 */
	private $building_area_source;

	/**
	 * Total area of the structure. Includes both finished and unfinished areas.
	 *
	 * @var [int]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuildingAreaTotal+Field
	 * @group property resource, structure group
	 * @maxlength 14
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, coml
	 */
	private $building_area_total;

	/**
	 * A pick list of the unit of measurement for the area. i.e. Square Feet,
	 * Square Meters, Acres, etc.
	 *
	 * @var [string list], [single]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuildingAreaUnits+Field
	 * @group property resource, structure group
	 * @maxlength 25
	 * @synonym
	 * @certlevel silver
	 * @propertytypes resi, rlse, rinc, mobi, farm, coms, coml
	 */
	private $building_area_units;

	/**
	 * Features or amenities of the building or business park.
	 *
	 * @var [string list], [multi]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuildingFeatures+Field
	 * @group property resource, structure group
	 * @maxlength 1024
	 * @synonym
	 * @certlevel platinum
	 * @propertytypes coms, coml
	 * */
	private $building_features;

	/**
	 * Name of the building or business park.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuildingName+Field
	 * @group property resource, structure group
	 * @maxlength 50
	 * @synonym
	 * @certlevel gold
	 * @propertytypes coms, coml
	 * */
	private $building_name;

	/**
	 * Name of the business being sold.
	 *
	 * @var [255]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BusinessName+Field
	 * @group property resource, business group
	 * @maxlength 255
	 * @synonym
	 * @certlevel bronze
	 * @propertytypes buso
	 * */
	private $business_name;

	/**
	 * The type of business being sold. Retail, Wholesale, Grocery, Food & Bev, etc.
	 *
	 * @var [string list], [business group]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BusinessType+Field
	 * @group property resource, business group
	 * @maxlength 1024
	 * @synonym propertysubtype
	 * @certlevel core
	 * @propertytypes coms, coml, buso
	 * */
	private $business_type;

	/**
	 * The total commission to be paid for this sale, expressed as either a
	 * percentage or a constant currency amount.
	 *
	 * @var [string]
	 * @access private
	 * @ddwiki http://ddwiki.reso.org/display/DDW/BuyerAgencyCompensation+Field
	 * @group property resource, listing group,  compensation group
	 * @maxlength 25
	 * @synonym socomp, sellingofficecompensation, buyerbrokecompensation, soc, commision
	 * @certlevel core
	 * @propertytypes resi, rlse, rinc, land, mobi, farm, coms, coml, buso
	 * */
	private $buyer_agency_compensation;

	private $buyer_agency_compensation_type;

	private $buyer_agent_aor;

	private $buyer_agent_cell_phone;

	private $buyer_agent_designation;

	private $buyer_agent_directphone;

	private $buyer_agent_email;

	private $buyer_agent_fax;

	private $buyer_agent_first_name;

	private $buyer_agent_full_name;

	private $buyer_agent_home_phone;

	private $buyer_agent_key;

	private $buyer_agent_key_numeric;

	private $buyer_agent_last_name;

	private $buyer_agent_middle_name;

	private $buyer_agent_mls_id;

	private $buyer_agent_name_prefix;

	private $buyer_agent_name_suffix;

	private $buyer_agent_office_phone;

	private $buyer_agent_office_phone_ext;

	private $buyer_agent_pager;

	private $buyer_agent_preferred_phone;

	private $buyer_agent_preferred_phone_ext;

	private $buyer_agent_state_license;

	private $buyer_agent_tollfree_phone;

	private $buyer_agent_url;

	private $buyer_agent_voicemail;

	private $buyer_agent_voicemail_ext;

	private $buyer_financing;

	private $buyer_office_aor;

	private $buyer_office_email;

	private $buyer_office_fax;

	private $buyer_office_key;

	private $buyer_office_key_numeric;

	private $buyer_office_mls_id;

	private $buyer_office_name;

	private $buyer_office_phone;

	private $buyer_office_phone_ext;

	private $buyer_office_url;

	private $buyer_team_key;

	private $buyer_team_key_numeric;

	private $buyer_team_name;

	private $cable_tv_expense;

	private $cancelationdate;

	private $caprate;

	private $carportspaces;

	private $carportyn;

	private $carrierroute;

	/**
	 * The city in listing address.
	 *
	 * @var [String List, Single ]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/City+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 50
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker cityName
	 */
	private $city;

	private $cityregion;

	private $closedate;

	private $closeprice;

	private $cobuyer_agentaor;

	private $cobuyer_agentcellphone;

	private $cobuyer_agentdesignation;

	private $cobuyer_agentdirectphone;

	private $cobuyer_agentemail;

	private $cobuyer_agentfax;

	private $cobuyer_agentfirstname;

	private $cobuyer_agentfullname;

	private $cobuyer_agenthomephone;

	private $cobuyer_agentkey;

	private $cobuyer_agentkeynumeric;

	private $cobuyer_agentlastname;

	private $cobuyer_agentmiddlename;

	private $cobuyer_agentmlsid;

	private $cobuyer_agentnameprefix;

	private $cobuyer_agentnamesuffix;

	private $cobuyer_agentofficephone;

	private $cobuyer_agentofficephoneext;

	private $cobuyer_agentpager;

	private $cobuyer_agentpreferredphone;

	private $cobuyer_agentpreferredphoneext;

	private $cobuyer_agentstatelicense;

	private $cobuyer_agenttollfreephone;

	private $cobuyer_agenturl;

	private $cobuyer_agentvoicemail;

	private $cobuyer_agentvoicemailext;

	private $cobuyer_officeaor;

	private $cobuyer_officeemail;

	private $cobuyer_officefax;

	private $cobuyer_officekey;

	private $cobuyer_officekeynumeric;

	private $cobuyer_officemlsid;

	private $cobuyer_officename;

	private $cobuyer_officephone;

	private $cobuyer_officephoneext;

	private $cobuyer_officeurl;

	private $colist_agentaor;

	private $colist_agentcellphone;

	private $colist_agentdesignation;

	private $colist_agentdirectphone;

	private $colist_agentemail;

	private $colist_agentfax;

	private $colist_agentfirstname;

	private $colist_agentfullname;

	private $colist_agenthomephone;

	private $colist_agentkey;

	private $colist_agentkeynumeric;

	private $colist_agentlastname;

	private $colist_agentmiddlename;

	private $colist_agentmlsid;

	private $colist_agentnameprefix;

	private $colist_agentnamesuffix;

	private $colist_agentofficephone;

	private $colist_agentofficephoneext;

	private $colist_agentpager;

	private $colist_agentpreferredphone;

	private $colist_agentpreferredphoneext;

	private $colist_agentstatelicense;

	private $colist_agenttollfreephone;

	private $colist_agenturl;

	private $colist_agentvoicemail;

	private $colist_agentvoicemailext;

	private $colist_officeaor;

	private $colist_officeemail;

	private $colist_officefax;

	private $colist_officekey;

	private $colist_officekeynumeric;

	private $colist_officemlsid;

	private $colist_officename;

	private $colist_officephone;

	private $colist_officephoneext;

	private $colist_officeurl;

	private $commonwalls;

	private $communityfeatures;

	private $concessions;

	private $concessionsamount;

	private $concessionscomments;

	private $constructionmaterials;

	private $continentregion;

	private $contingency;

	private $contingentdate;

	private $contractstatuschangedate;

	private $cooling;

	private $coolingyn;

	private $copyrightnotice;

	private $country;

	private $countryregion;

	/**
	 * The County, Parish or other regional authority
	 *
	 * @var [String List, Single ]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/CountyOrParish+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 50
	 * @synonym County
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker countyName
	 */
	private $county_or_parish;

	private $coveredspaces;

	private $cropsincludedyn;

	private $crossstreet;

	private $cultivatedarea;

	private $cumulativedaysonmarket;

	private $currentfinancing;

	private $currentuse;

	private $doh1;

	private $doh2;

	private $doh3;

	private $daysonmarket;

	private $developmentstatus;

	private $directionfaces;

	private $directions;

	private $disclaimer;

	private $disclosures;

	private $distance_tobuscomments;

	private $distance_tobusnumeric;

	private $distance_tobusunits;

	private $distance_toelectriccomments;

	private $distance_toelectricnumeric;

	private $distance_toelectricunits;

	private $distance_tofreewaycomments;

	private $distance_tofreewaynumeric;

	private $distance_tofreewayunits;

	private $distance_togascomments;

	private $distance_togasnumeric;

	private $distance_togasunits;

	private $distance_tophoneservicecomments;

	private $distance_tophoneservicenumeric;

	private $distance_tophoneserviceunits;

	private $distance_toplaceofworshipcomments;

	private $distance_toplaceofworshipnumeric;

	private $distance_toplaceofworshipunits;

	private $distance_toschoolbuscomments;

	private $distance_toschoolbusnumeric;

	private $distance_toschoolbusunits;

	private $distance_toschoolscomments;

	private $distance_toschoolsnumeric;

	private $distance_toschoolsunits;

	private $distance_tosewercomments;

	private $distance_tosewernumeric;

	private $distance_tosewerunits;

	private $distance_toshoppingcomments;

	private $distance_toshoppingnumeric;

	private $distance_toshoppingunits;

	private $distance_tostreetcomments;

	private $distance_tostreetnumeric;

	private $distance_tostreetunits;

	private $distance_towatercomments;

	private $distance_towaternumeric;

	private $distance_towaterunits;

	private $documentsavailable;

	private $documentschangetimestamp;

	private $documentscount;

	private $doorfeatures;

	private $dualvariablecompensationyn;

	private $electric;

	private $electricexpense;

	private $electriconpropertyyn;

	private $elementaryschool;

	private $elementaryschooldistrict;

	private $elevation;

	private $elevationunits;

	private $entrylevel;

	private $entrylocation;

	private $exclusions;

	private $existingleasetype;

	private $expirationdate;

	private $exteriorfeatures;

	private $farmcreditserviceinclyn;

	private $farmlandareasource;

	private $farmlandareaunits;

	private $fencing;

	private $financialdatasource;

	private $fireplacefeatures;

	private $fireplaceyn;

	private $fireplacestotal;

	private $flooring;

	private $foundationarea;

	private $foundationdetails;

	private $frontagelength;

	private $frontagetype;

	private $fuelexpense;

	private $furnished;

	private $furniturereplacementexpense;

	private $garagespaces;

	private $garageyn;

	private $gardnerexpense;

	private $gas;

	private $grazingpermitsblmyn;

	private $grazingpermitsforestserviceyn;

	private $grazingpermitsprivateyn;

	private $green_buildingverificationtype;

	private $green_energyefficient;

	private $green_energygeneration;

	private $green_indoorairquality;

	private $green_location;

	private $green_sustainability;

	private $green_verification;

	private $green_waterconservation;

	private $grossincome;

	private $grossscheduledincome;

	private $habitableresidenceyn;

	private $heating;

	private $heatingyn;

	private $highschool;

	private $highschooldistrict;

	private $homewarrantyyn;

	private $horseamenities;

	private $horseyn;

	private $hoursdaysofoperation;

	private $hoursdaysofoperationdescription;

	private $inclusions;

	private $incomeincludes;

	private $insuranceexpense;

	private $interiorfeatures;

	/**
	 * A yes/no field that states the seller has allowed the listing address to be displayed
	 * on Internet sites.
	 *
	 * @var [Boolean]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/InternetAddressDisplayYN+Field
	 * @group Property Resource, Listing Group, Marketing Group
	 * @maxlength 1
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker displayAddress
	 */
	private $internet_address_display_yn;

	private $internetautomatedvaluationdisplayyn;

	private $internetconsumercommentyn;

	private $internetentirelistingdisplayyn;

	private $irrigationsource;

	private $irrigationwaterrightsacres;

	private $irrigationwaterrightsyn;

	private $laborinformation;

	private $landleaseamount;

	private $landleaseamountfrequency;

	private $landleaseexpirationdate;

	private $landleaseyn;

	/**
	 * The geographic latitude of some reference point on the property, specified in degrees
	 * and decimal parts. Positive numbers must not include the plus symbol.
	 *
	 * @var [Number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/Latitude+Field
	 * @group Property Resource, Location Group, GIS Group
	 * @maxlength 12
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker latitude
	 */
	private $latitude;

	private $laundryfeatures;

	private $leasablearea;

	private $leasableareaunits;

	private $lease_amount;

	private $lease_amountfrequency;

	private $lease_assignableyn;

	private $lease_consideredyn;

	private $lease_expiration;

	private $lease_renewalcompensation;

	private $lease_renewaloptionyn;

	private $lease_term;

	private $levels;

	private $license1;

	private $license2;

	private $license3;

	private $licensesexpense;

	private $list_aor;

	private $list_agent_aor;

	private $list_agent_cellphone;

	private $list_agent_designation;

	private $list_agent_directphone;

	private $list_agent_email;

	private $list_agent_fax;

	private $list_agent_firstname;

	private $list_agent_fullname;

	private $list_agent_homephone;

	/**
	 * A system unique identifier. Specifically, in aggregation systems, the ListAgentKey
	 * is the system unique identifier from the system that the record was retrieved. This
	 * may be identical to the related xxxId. This is a foreign key relating to the Member
	 * resource's MemberKey.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListAgentKey+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 255
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker listingAgentID || userAgentID
	 */
	private $list_agent_key;

	private $list_agent_keynumeric;

	private $list_agent_lastname;

	private $list_agent_middlename;

	private $list_agent_mlsid;

	private $list_agent_nameprefix;

	private $list_agent_namesuffix;

	private $list_agent_officephone;

	private $list_agent_officephoneext;

	private $list_agent_pager;

	private $list_agent_preferredphone;

	private $list_agent_preferredphoneext;

	private $list_agent_statelicense;

	private $list_agent_tollfreephone;

	private $list_agent_url;

	private $list_agent_voicemail;

	private $list_agent_voicemailext;

	private $list_office_aor;

	private $list_office_email;

	private $list_office_fax;

	/**
	 * A system unique identifier. Specifically, in aggregation systems, the Key is the
	 * system unique identifier from the system that the record was just retrieved. This
	 * may be identical to the related xxxId identifier, but the key is guaranteed unique
	 * for this record set. This is a foreign key relating to the Office resource's OfficeKey.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListOfficeKey+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 255
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker listingOfficeID
	 */
	private $list_office_key;

	private $list_office_keynumeric;

	private $list_office_mlsid;

	private $list_office_name;

	private $list_office_phone;

	private $list_office_phoneext;

	private $list_office_url;

	/**
	 * The current price of the property as determined by the seller and the seller's
	 * broker. For auctions this is the minimum or reserve price.
	 *
	 * @var [Number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/ListPrice+Field
	 * @group Property Resource, Listing Group, Price Group
	 * @maxlength 14
	 * @synonym AskingPrice, PriceListing, PriceListed, CurrentPrice
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker listingPrice
	 */
	private $list_price;

	private $list_pricelow;

	private $list_teamkey;

	private $list_teamkeynumeric;

	private $list_teamname;

	private $list_ingagreement;

	private $list_ingcontractdate;

	private $list_ingservice;

	private $list_ingterms;

	private $livingarea;

	private $livingareasource;

	private $livingareaunits;

	private $lockboxlocation;

	private $lockboxserialnumber;

	private $lockboxtype;

	/**
	 * The geographic longitude of some reference point on the property, specified in
	 * degrees and decimal parts. Positive numbers must not include the plus symbol.
	 *
	 * @var [Number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/Longitude+Field
	 * @group Property Resource, Location Group, GIS Group
	 * @maxlength 12
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker longitude
	 */
	private $longitude;

	private $lot_dimensionssource;

	private $lot_features;

	/**
	 * The total Acres of the lot. This field is related to the Lot Size Area and Lot Size
	 * Units and must be in sync with the values represented in those fields. Lot Size
	 * Source also applies to this field when used.
	 *
	 * @var [Number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/LotSizeAcres+Field
	 * @group Property Resource, Characteristics Group
	 * @maxlength 16
	 * @synonym
	 * @certlevel gold
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker acres
	 */
	private $lot_size_acres;

	/**
	 * The total area of the lot. See Lot Size Units for the units of measurement
	 * (Square Feet, Square Meters, Acres, etc.).
	 *
	 * @var [Number]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/LotSizeAcres+Field
	 * @group Property Resource, Characteristics Group
	 * @maxlength 16
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker sqFt
	 */
	private $lot_sizearea;

	private $lot_sizedimensions;

	private $lot_sizesource;

	private $lot_sizesquarefeet;

	private $lot_sizeunits;

	private $mlsareamajor;

	private $mlsareaminor;

	private $mainlevelbathrooms;

	private $mainlevelbedrooms;

	private $maintenanceexpense;

	private $majorchangetimestamp;

	private $majorchangetype;

	private $make;

	private $managerexpense;

	private $mapcoordinate;

	private $mapcoordinatesource;

	private $mapurl;

	private $middleorjuniorschool;

	private $middleorjuniorschooldistrict;

	private $mlsstatus;

	private $mobiledimunits;

	private $mobilehomeremainsyn;

	private $mobilelength;

	private $mobilewidth;

	private $model;

	private $modificationtimestamp;

	private $netoperatingincome;

	private $newconstructionyn;

	private $newtaxesexpense;

	private $number_ofbuildings;

	private $number_offulltimeemployees;

	private $number_oflots;

	private $number_ofpads;

	private $number_ofparttimeemployees;

	private $number_ofseparateelectricmeters;

	private $number_ofseparategasmeters;

	private $number_ofseparatewatermeters;

	private $number_ofunitsincommunity;

	private $number_ofunitsleased;

	private $number_ofunitsmomo;

	private $number_ofunitstotal;

	private $number_ofunitsvacant;

	private $occupantname;

	private $occupantphone;

	private $occupanttype;

	private $offmarketdate;

	private $offmarkettimestamp;

	private $onmarketdate;

	private $onmarkettimestamp;

	private $openparkingspaces;

	private $openparkingyn;

	private $operatingexpense;

	private $operatingexpenseincludes;

	private $originalentrytimestamp;

	private $originallistprice;

	private $originatingsystemid;

	private $originatingsystemkey;

	private $originatingsystemname;

	private $otherequipment;

	private $otherexpense;

	private $otherparking;

	private $otherstructures;

	private $ownername;

	private $ownerpays;

	private $ownerphone;

	private $ownership;

	private $ownershiptype;

	private $parcelnumber;

	private $parkmanagername;

	private $parkmanagerphone;

	private $parkname;

	private $parkingfeatures;

	private $parkingtotal;

	private $pasturearea;

	private $patioandporchfeatures;

	private $pendingtimestamp;

	private $pestcontrolexpense;

	private $petsallowed;

	private $photoschangetimestamp;

	private $photoscount;

	private $poolexpense;

	private $poolfeatures;

	private $poolprivateyn;

	private $possession;

	private $possible_use;

	private $postalcity;

	/**
	 * The postal code portion of a street or mailing address.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/PostalCode+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 10
	 * @synonym ZipCode, Zip
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker zipcode
	 */
	private $postal_code;

	/**
	 * The postal code +4 portion of a street or mailing address.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/PostalCodePlus4+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 4
	 * @synonym Zip+4, ZipPlus4
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker zip4
	 */
	private $postal_code_plus_4;

	private $power_production;

	private $power_production_type;

	private $previous_list_price;

	private $price_change_timestamp;

	private $private_office_remarks;

	private $private_remarks;

	private $professional_management_expense;

	private $property_attached_yn;

	private $property_condition;

	private $property_subtype;

	/**
	 * A list of types of residential and residential lease properties, i.e. SFR, Condo, etc.
	 * Or a list of Sub Types for Mobile, such as Expando, Manufactured, Modular, etc.
	 *
	 * @var [String List, Single]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/PropertySubType+Field
	 * @group Property Resource
	 * @maxlength 50
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, MOBI, COMS, COML, BUSO
	 * @idxbroker idxPropType
	 */
	private $property_type;

	/**
	 * Text remarks that may be displayed to the public. In an MLS, it is the field where
	 * information is entered for the public. This information is intended to be visible
	 * on-line. This is typically information that describes the selling points of the
	 * building and/or land for sale. Local conditions and rules will determine what such
	 * content can contain. Generally, the following information is excluded: any
	 * information pertaining to entry to the property, the seller and/or tenant, listing
	 * member contact information. In other systems, these remarks will be determined by
	 * local business rules.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/PublicRemarks+Field
	 * @group Property Resource, Listing Group, Remarks Group
	 * @maxlength 4000
	 * @synonym PropertyDescription, InternetRemarks, Remarks
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker remarksConcat
	 */
	private $public_remarks;

	private $public_survey_range;

	private $public_survey_section;

	private $publics_urvey_township;

	private $purchase_contract_date;

	private $rv_parking_dimensions;

	private $range_area;

	private $rent_control_yn;

	private $rent_includes;

	private $road_frontagetype;

	private $road_responsibility;

	private $road_surface_type;

	private $roof;

	private $room;

	private $room_type;

	private $rooms_total;

	private $seating_capacity;

	private $security_features;

	private $senior_community_yn;

	private $serial_u;

	private $serial_x;

	private $serial_xx;

	private $sewer;

	private $showing_contact_name;

	private $showing_contact_phone;

	private $showing_contact_phone_ext;

	private $showing_contact_type;

	private $showing_instructions;

	private $sign_on_property_yn;

	private $skirt;

	/**
	 * The RESO OUID's OrganizationUniqueId of the Source record provider. The source system
	 * is the system from which the record was directly received. In cases where the source
	 * system was not where the record originated (the authoritative system), see the
	 * Originating System fields.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/SourceSystemID+Field
	 * @group Property Resource, Listing Group
	 * @maxlength 25
	 * @synonym
	 * @certlevel platinum
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 */
	private $source_system_id;

	/**
	 * The system key, a unique record identifier, from the Source System. The Source
	 * System is the system from which the record was directly received. In cases where
	 * the Source System was not where the record originated (the authoritative system),
	 * see the Originating System fields.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/SourceSystemKey+Field
	 * @group Property Resource, Listing Group
	 * @maxlength 255
	 * @synonym ProviderKey
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker listingID
	 */
	private $source_system_key;

	private $source_system_name;

	private $spa_features;

	private $spa_yn;

	private $special_licenses;

	private $special_listing_conditions;

	/**
	 * The status of the listing as it reflects the state of the contract between the
	 * listing agent and seller or an agreement with a buyer (Active, Active Under Contract,
	 * Canceled, Closed, Expired, Pending, Withdrawn). This is a Single Select field.
	 *
	 * @var [String List, Single]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StandardStatus+Field
	 * @group Property Resource, Listing Group
	 * @maxlength 25
	 * @synonym NormalizedListingStatus, RetsStatus
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker status || idxStatus
	 * @lookup standard_status()
	 */
	private $standard_status;

	/**
	 * Text field containing the accepted postal abbreviation for the state or province.
	 *
	 * @var [String List, Single ]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StateOrProvince+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 2
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker state
	 * @lookup state_or_province()
	 */
	private $state_or_province;

	private $state_region;

	private $status_change_timestamp;

	private $stories;

	private $stories_total;

	private $street_additional_info;

	/**
	 * The direction indicator that precedes the listed property's street name.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StreetDirPrefix+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 15
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker streetDirection
	 * @lookup street_direction()
	 */
	private $street_dir_prefix;

	/**
	 * The direction indicator that follows a listed property's street address.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StreetDirSuffix+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 15
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @lookup street_direction()
	 */
	private $street_dir_suffix;

	/**
	 * The street name portion of a listed property's street address.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StreetName+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 50
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker streetName
	 */
	private $street_name;

	/**
	 * The street number portion of a listed property's street address. In some areas the
	 * street number may contain non-numeric characters. This field can also contain
	 * extensions and modifiers to the street number, such as "1/2" or "-B". This street
	 * number field should not include Prefixes, Direction or Suffixes.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/StreetNumber+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 25
	 * @synonym
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker streetNumber
	 */
	private $street_number;

	private $street_number_numeric;

	private $street_suffix;

	private $street_suffix_modifier;

	private $structure_type;

	private $subagency_compensation;

	private $subagency_compensation_type;

	private $subdivision_name;

	private $supplies_expense;

	private $syndicate_to;

	private $syndication_remarks;

	private $tax_annual_amount;

	private $tax_assessed_value;

	private $tax_block;

	private $tax_book_number;

	private $tax_exemptions;

	private $tax_legaldescription;

	private $tax_lot;

	private $tax_map_number;

	private $tax_other_annual_assessment_amount;

	private $tax_parcel_letter;

	private $tax_status_current;

	private $tax_tract;

	private $tax_year;

	private $telephone;

	private $tenant_pays;

	private $topography;

	private $total_actual_rent;

	private $township;

	private $transaction_broker_compensation;

	private $transaction_broker_compensation_type;

	private $trash_expense;

	/**
	 * Text field containing the number or portion of a larger building or complex. Unit
	 * Number should appear following the street suffix or, if it exists, the street suffix
	 * direction, in the street address. Examples are: "APT G", "55", etc.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/UnitNumber+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 25
	 * @synonym ApartmentNumber, SpaceNumber, Suite
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker unitNumber
	 */
	private $unit_number;

	private $unit_type;

	private $unit_type_type;

	private $units_furnished;

	/**
	 * The UnparsedAddress is a text representation of the address with the full civic
	 * location as a single entity. It may optionally include any of City, StateOrProvince,
	 * PostalCode and Country.
	 *
	 * @var [string]
	 * @ddwiki http://ddwiki.reso.org/display/DDW/UnparsedAddress+Field
	 * @group Property Resource, Location Group, Address Group
	 * @maxlength 255
	 * @synonym FullAddress
	 * @certlevel core
	 * @propertytpes RESI, RLSE, RINC, LAND, MOBI, FARM, COMS, COML, BUSO
	 * @idxbroker address
	 */
	private $unparsed_address;

	private $utilities;

	private $vacancy_allowance;

	private $vacancy_allowance_rate;

	private $vegetation;

	private $videos_change_timestamp;

	private $videos_count;

	private $view;

	private $view_yn;

	private $virtualtour_url_branded;

	private $virtualtour_url_unbranded;

	private $walkscore;

	private $water_body_name;

	private $water_sewer_expense;

	private $water_source;

	private $waterfront_features;

	private $waterfront_yn;

	private $window_features;

	private $withdrawn_date;

	private $wooded_area;

	private $workmans_compensation_expense;

	private $year_built;

	private $year_built_details;

	private $year_built_effective;

	private $year_built_source;

	private $year_established;

	private $years_current_owner;

	private $zoning;

	private $zoning_description;


	/**
	 * Property constructor
	 */
	public function __construct() {

	}

	/**
	 * get_property_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_property_fields() {
		return array(
			// TOD: Add all Fields.
			'year_established',
			'years_current_owner',
			'zoning',
			'zoning_description',
		);
	}
}

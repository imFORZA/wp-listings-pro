<?php
/**
 * RESO Member
 *
 * @package wp-reso
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * RESO Member Class.
 *
 * @package wp-reso-member
 */
class ResoMember {

	/**
	 * JobTitle
	 *
	 * @var mixed
	 * @access private
	 */
	private $JobTitle;

	/**
	 * LastLoginTimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $LastLoginTimestamp;

	/**
	 * MemberAOR
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_AOR;

	/**
	 * MemberAORMlsId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_AORMlsId;

	/**
	 * MemberAORkey
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_AORkey;

	/**
	 * MemberAORkeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_AORkeyNumeric;

	/**
	 * MemberAddress1
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Address1;

	/**
	 * MemberAddress2
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Address2;

	/**
	 * MemberAssociationComments
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_AssociationComments;

	/**
	 * MemberCarrierRoute
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_CarrierRoute;

	/**
	 * MemberCity
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_City;

	/**
	 * MemberCountry
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Country;

	/**
	 * MemberCountyOrParish
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_CountyOrParish;

	/**
	 * MemberDesignation
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Designation;

	/**
	 * MemberDirectPhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_DirectPhone;

	/**
	 * MemberEmail
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Email;

	/**
	 * MemberFax
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Fax;

	/**
	 * MemberFirstName
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_FirstName;

	/**
	 * MemberFullName
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_FullName;

	/**
	 * MemberHomePhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_HomePhone;

	/**
	 * MemberIsAssistantTo
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_IsAssistantTo;

	/**
	 * MemberKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Key;

	/**
	 * MemberKeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_KeyNumeric;

	/**
	 * MemberLanguages
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Languages;

	/**
	 * MemberLastName
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_LastName;

	/**
	 * MemberLoginId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_LoginId;

	/**
	 * MemberMiddleName
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_MiddleName;

	/**
	 * MemberMlsAccessYN
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_MlsAccessYN;

	/**
	 * MemberMlsId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_MlsId;

	/**
	 * MemberMlsSecurityClass
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_MlsSecurityClass;

	/**
	 * MemberMobilePhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_MobilePhone;

	/**
	 * MemberNamePrefix
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_NamePrefix;

	/**
	 * MemberNameSuffix
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_NameSuffix;

	/**
	 * MemberNationalAssociationId
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_NationalAssociationId;

	/**
	 * MemberNickname
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Nickname;

	/**
	 * MemberOfficePhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_OfficePhone;

	/**
	 * MemberOfficePhoneExt
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_OfficePhoneExt;

	/**
	 * MemberOtherPhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_OtherPhone;

	/**
	 * MemberOtherPhoneType
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_OtherPhoneType;

	/**
	 * MemberPager
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Pager;

	/**
	 * MemberPassword
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Password;

	/**
	 * MemberPhoneTTYTDD
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_PhoneTTYTDD;

	/**
	 * MemberPostalCode
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_PostalCode;

	/**
	 * MemberPostalCodePlus4
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_PostalCodePlus4;

	/**
	 * MemberPreferredPhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_PreferredPhone;

	/**
	 * MemberPreferredPhoneExt
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_PreferredPhoneExt;

	/**
	 * MemberStateLicense
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_StateLicense;

	/**
	 * MemberStateLicenseState
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_StateLicenseState;

	/**
	 * MemberStateOrProvince
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_StateOrProvince;

	/**
	 * MemberStatus
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Status;

	/**
	 * MemberTollFreePhone
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_TollFreePhone;

	/**
	 * MemberType
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_Type;

	/**
	 * MemberVoiceMail
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_VoiceMail;

	/**
	 * MemberVoiceMailExt
	 *
	 * @var mixed
	 * @access private
	 */
	private $member_VoiceMailExt;

	/**
	 * ModificationTimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $ModificationTimestamp;

	/**
	 * OfficeKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_Key;

	/**
	 * OfficeKeyNumeric
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_KeyNumeric;

	/**
	 * OfficeMlsId
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_MlsId;

	/**
	 * OfficeName
	 *
	 * @var mixed
	 * @access private
	 */
	private $office_Name;

	/**
	 * OriginalEntryTimestamp
	 *
	 * @var mixed
	 * @access private
	 */
	private $OriginalEntryTimestamp;

	/**
	 * OriginatingSystemID
	 *
	 * @var mixed
	 * @access private
	 */
	private $OriginatingSystemID;

	/**
	 * OriginatingSystemMemberKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $OriginatingSystemMemberKey;

	/**
	 * OriginatingSystemName
	 *
	 * @var mixed
	 * @access private
	 */
	private $OriginatingSystemName;

	/**
	 * SocialMedia
	 *
	 * @var mixed
	 * @access private
	 */
	private $SocialMedia;

	/**
	 * SocialMediaType
	 *
	 * @var mixed
	 * @access private
	 */
	private $SocialMediaType;

	/**
	 * SourceSystemID
	 *
	 * @var mixed
	 * @access private
	 */
	private $SourceSystemID;

	/**
	 * SourceSystemMemberKey
	 *
	 * @var mixed
	 * @access private
	 */
	private $SourceSystemMemberKey;

	/**
	 * SourceSystemName
	 *
	 * @var mixed
	 * @access private
	 */
	private $SourceSystemName;

	/**
	 * SyndicateTo
	 *
	 * @var mixed
	 * @access private
	 */
	private $SyndicateTo;

	/**
	 * Member constructor
	 */
	public function __construct() {
	}

	/**
	 * get_member_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_member_fields() {
		return array(
			'job_title',
			'lastlogin_timestamp',
			'member__address1',
			'member__address2',
			'member__aor',
			'member__aorkey',
			'member_aorkeynumeric',
			'member_aormlsid',
			'member_associationcomments',
			'member_carrierroute',
			'member_city',
			'member_country',
			'member_countyorparish',
			'member_designation',
			'member_directphone',
			'member_email',
			'member_fax',
			'member_firstname',
			'member_fullname',
			'member_homephone',
			'member_isassistantto',
			'member_key',
			'member_keynumeric',
			'member_languages',
			'member_lastname',
			'member_loginid',
			'member_middlename',
			'member_mlsaccessyn',
			'member_mlsid',
			'member_mlssecurityclass',
			'member_mobilephone',
			'member_nameprefix',
			'member_namesuffix',
			'member_nationalassociationid',
			'member_nickname',
			'member_officephoneext',
			'member_officephone',
			'member_otherphone[type]ext',
			'member_otherphone[type]number',
			'member_otherphonetype',
			'member_pager',
			'member_password',
			'member_phonettytdd',
			'member_postalcode',
			'member_postalcodeplus4',
			'member_preferredphoneext',
			'member_preferredphone',
			'member_statelicense',
			'member_statelicensestate',
			'member_stateorprovince',
			'member_status',
			'member_tollfreephone',
			'member_type',
			'member_voicemailext',
			'member_voicemail',
			'modificationtimestamp',
			'office_key',
			'office_keynumeric',
			'office_mlsid',
			'office_name',
			'originalentrytimestamp',
			'originating_systemid',
			'originating_system_member_key',
			'originating_system_name',
			'social_media[type]urlorid',
			'social_mediatype',
			'source_system_id',
			'source_system_member_key',
			'source_system_name',
			'syndicate_to',
		);
	}
}

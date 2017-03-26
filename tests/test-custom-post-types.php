<?php

/**
 * Test_WPLPRO_CustomPostTypes class.
 *
 * @extends WP_UnitTestCase
 */
class Test_WPLPRO_CustomPostTypes extends WP_UnitTestCase {


	/**
	 * Test for Employee Post Type.
	 *
	 * @access public
	 * @return void
	 */
	function test_employee_post_type_creation() {
    	$this->assertTrue( post_type_exists( 'employee' ) );
  	}

  	/**
  	 * Test for Listing Post Type.
  	 *
  	 * @access public
  	 * @return void
  	 */
  	function test_listing_post_type_creation() {
    	$this->assertTrue( post_type_exists( 'listing' ) );
  	}
}

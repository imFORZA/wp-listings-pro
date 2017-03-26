<?php
/**
 * [setUp description]
 */
class Test_WPLPRO_Taxonomies extends WP_UnitTestCase {
    /**
     * [setUp description]
     */
    function setUp(){
        parent::setUp();
    }
    /**
     * [tearDown description]
     * @return {[type] [description]
     */
    function tearDown(){
        parent::tearDown();
    }


    /**
     * [test_all_taxonomies description]
     * @return {[type] [description]
     */
    function test_listing_taxonomies() {
        $all_tax = get_object_taxonomies( 'listing' );
        sort( $all_tax );
        $this->assertEquals( array( 'features', 'locations', 'property-types', 'status' ), $all_tax );
    }
    /**
     * [test_employee_taxonomies description]
     * @return {[type] [description]
     */
    function test_employee_taxonomies() {
        $all_tax = get_object_taxonomies( 'employee' );
        sort( $all_tax );
        $this->assertEquals( array( 'job-types', 'offices' ), $all_tax );
    }
}

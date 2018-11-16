<?php
/**
 * Listing metabox for agent assignments
 *
 * @package WP-Listings-Pro
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// * Agent Assignments.
global $post;


echo '<h4>' . __( 'Agent Assignments', 'wp-listings-pro' ) . '</h4>';

$stuff = get_posts(
	array(
		'post_type'      => 'employee',
		'posts_per_page' => 500,
	)
);

if ( count( $stuff ) === 0 ) {
	echo __( 'No agents found.', 'wp-listings-pro' );
} else {
	$agent_assignments = explode( ',', get_post_meta( $post->ID, '_employee_responsibility', true ) );

	foreach ( $stuff as $agent ) {
		printf( '<input type="checkbox" name="wp_listings[_employee_responsibility_' . $agent->ID . ']" %s />', checked( in_array( $agent->ID, $agent_assignments ), 1, 0 ) );

		echo get_post_meta( $agent->ID, '_employee_first_name', true ) . ' ' . get_post_meta( $agent->ID, '_employee_last_name', true );
		echo '<br>';
	}
}

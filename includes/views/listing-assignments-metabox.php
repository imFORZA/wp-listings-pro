<?php

// * Agent Assignments

global $post;
echo '<div>';
_e( '<h4>Agent Assignments</h4>', 'wp-listings-pro' );
echo '<p>Agents will go here</p><p>';
// Example for how to access Will's first name. Neat.
// * echo get_post_meta(8, '_employee_first_name', true);
// * update_post_meta($post->ID, '_assigned_employees[\'8\']', 1);.
$stuff = get_posts(array(
	'post_type'       => 'employee',
	'posts_per_page'  => -1,
));
// * echo print_r($stuff, true);
// echo $stuff[0]->ID; // yields 10. NEAT.
foreach ( $stuff as $agent ) {
	error_log($agent->ID);
  printf( '<input type="checkbox" name="wp_listings[_employee_responsibility_' . $agent->ID . ']" %s />',checked( get_post_meta( $post->ID, '_employee_responsibility_' . $agent->ID , true ), 1, 0 ) );

	echo get_post_meta( $agent->ID, '_employee_last_name', true ) . ', ' . get_post_meta( $agent->ID, '_employee_first_name', true );
	echo '<br>';
}
echo '</p></div>';

?>

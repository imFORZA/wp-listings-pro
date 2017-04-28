<?php

// * Agent Assignments

global $post;
echo '<div>';
_e( '<h4>Agent Assignments</h4><p>', 'wp-listings-pro' );
$stuff = get_posts(array(
	'post_type'       => 'employee',
	'posts_per_page'  => -1,
));
if(count($stuff) === 0){
	echo __("No agents found.", 'wp-listings-pro');
}else{
	$agent_assignments = explode(",", get_post_meta( $post->ID, '_employee_responsibility' , true ));
	// $agent_assignments = [5, 15]; // Now just need to ba able to get this from post meta
	foreach ( $stuff as $agent ) {
	  printf( '<input type="checkbox" name="wp_listings[_employee_responsibility_' . $agent->ID . ']" %s />',checked( in_array( $agent->ID, $agent_assignments ), 1, 0 ) );

		echo get_post_meta( $agent->ID, '_employee_first_name', true ) . ' ' . get_post_meta( $agent->ID, '_employee_last_name', true );
		echo '<br>';
	}
}

echo '</p></div>';

?>

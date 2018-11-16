<?php
/**
 * Metabox for employee details
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_nonce_field( 'WPLPROAgents_metabox_save', 'WPLPROAgents_metabox_nonce' );

global $post;

$pattern = '<p><label>%s<br /><input type="text" name="WPLPROAgents[%s]" value="%s" style="width:80&#37;;"/></label></p>';

echo '<div style="width: 45%; display: inline-block;">';

foreach ( (array) $this->employee_details['col1'] as $label => $key ) { // here is where it's actually outputted, OK.
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div>';

echo '<div style="width: 45%; display: inline-block;">';

foreach ( (array) $this->employee_details['col2'] as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div>';

$pattern = '<p><label>%s<br /><input type="url" name="WPLPROAgents[%s]" value="%s" style="width:80&#37;;"/></label></p>';

echo '<div style="width: 100%;"><h4>' . __( 'Social info:', 'wp-listings-pro' ) . '</h4><hr>';

foreach ( (array) $this->employee_social as $label => $key ) {
	printf( $pattern, esc_html( $label ), $key, esc_attr( get_post_meta( $post->ID, $key, true ) ) );
}

echo '</div>';

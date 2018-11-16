<?php
/**
 * Page for editing agent taxonomy.
 *
 * @package wp-listings-pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = get_option( $this->settings_field );

if ( array_key_exists( $_REQUEST['id'], (array) $options ) ) {
	$taxonomy = stripslashes_deep( $options[ $_REQUEST['id'] ] );
} else {
	wp_die( __( "Nice try, partner. But that taxonomy doesn't exist or can't be edited. Click back and try again.", 'wp-listings-pro' ) );
}
?>

<?php screen_icon( 'plugins' ); ?>
<h2><?php esc_html_e( 'Edit Taxonomy', 'wp-listings-pro' ); ?></h2>

<form method="post" action="<?php echo admin_url( 'admin.php?page=' . $this->menu_page . '&amp;action=edit' ); ?>">
<?php wp_nonce_field( 'WPLPROAgents-action_edit-taxonomy', 'WPLPROAgents-action_edit-taxonomy' ); ?>
<table class="form-table">

	<tr class="form-field">
		<th scope="row" valign="top"><label for="WPLPROAgents_taxonomy[id]"><?php esc_html_e( 'ID', 'wp-listings-pro' ); ?></label></th>
		<td>
		<input type="text" value="<?php echo esc_html( $_REQUEST['id'] ); ?>" size="40" disabled="disabled" />
		<input name="WPLPROAgents_taxonomy[id]" id="WPLPROAgents_taxonomy[id]" type="hidden" value="<?php echo esc_html( $_REQUEST['id'] ); ?>" size="40" />
		<p class="description"><?php esc_html_e( 'The unique ID is used to register the taxonomy. (cannot be changed)', 'wp-listings-pro' ); ?></p></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="WPLPROAgents_taxonomy[name]"><?php esc_html_e( 'Plural Name', 'wp-listings-pro' ); ?></label></th>
		<td><input name="WPLPROAgents_taxonomy[name]" id="WPLPROAgents_taxonomy[name]" type="text" value="<?php echo esc_html( $taxonomy['labels']['name'] ); ?>" size="40" />
		<p class="description"><?php esc_html_e( 'Example: "Job Types" or "Offices"', 'wp-listings-pro' ); ?></p></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="WPLPROAgents_taxonomy[singular_name]"><?php esc_html_e( 'Singular Name', 'wp-listings-pro' ); ?></label></th>
		<td><input name="WPLPROAgents_taxonomy[singular_name]" id="WPLPROAgents_taxonomy[singular_name]" type="text" value="<?php echo esc_html( $taxonomy['labels']['singular_name'] ); ?>" size="40" />
		<p class="description"><?php esc_html_e( 'Example: "Job Type" or "Office"', 'wp-listings-pro' ); ?></p></td>
	</tr>

</table>

<?php submit_button( __( 'Update', 'wp-listings-pro' ) ); ?>

</form>

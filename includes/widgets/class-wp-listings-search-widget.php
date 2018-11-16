<?php
/**
 * Listing Search Widget.
 *
 * @package WP-Listings-Pro
 */

/**
 * This widget creates a search form which uses listings' taxonomy for search fields.
 *
 * @package WP-Listings-Pro
 * @since 0.1.0
 */
class WP_Listings_Search_Widget extends WP_Widget {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'listings-search wp-listings-search',
			'description'                 => __( 'Display listings search dropdown', 'wp-listings-pro' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'listings-search',
		);
		parent::__construct( 'wplpro_listings_search', __( 'WP Listings Pro - Search', 'wp-listings-pro' ), $widget_ops, $control_ops );
	}

	/**
	 * Output Widget.
	 *
	 * @access public
	 * @param mixed $args Arguments.
	 * @param mixed $instance Instance.
	 * @return void
	 */
	function widget( $args, $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'       => '',
				'button_text' => __( 'Search Listings', 'wp-listings-pro' ),
			)
		);

		global $_wplpro_taxonomies;

		$listings_taxonomies = $_wplpro_taxonomies->get_taxonomies();

		esc_html( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', esc_attr( $instance['title'], $instance, $this->id_base ) ) . $args['after_title'];
		}

		echo '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '" ><input type="hidden" value="" name="s" /><input type="hidden" value="listing" name="post_type" />';

		foreach ( $listings_taxonomies as $tax => $data ) {
			if ( ! isset( $instance[ $tax ] ) || ! $instance[ $tax ] ) {
				continue;
			}

			$terms = get_terms(
				$tax,
				array(
					'orderby'      => 'title',
					'number'       => 100,
					'hierarchical' => false,
				)
			);
			if ( empty( $terms ) ) {
				continue;
			}

			$current = ! empty( $wp_query->query_vars[ $tax ] ) ? $wp_query->query_vars[ $tax ] : '';
			echo "<select name='" . esc_attr( $tax ) . "' id='" . esc_attr( $tax ) . "' class='wp-listings-taxonomy'>\n\t";
			echo '<option value="" ' . esc_attr( selected( '' === $current, true, false ) ) . ">{$data['labels']['name']}</option>\n";
			foreach ( (array) $terms as $term ) {
				echo "\t<option value='" . esc_attr( $term->slug ) . "' " . esc_attr( selected( $current, $term->slug, false ) ) . '>' . $term->name . "</option>\n";
			}

			echo '</select>';
		}

		echo '<div class="btn-search"><button type="submit" class="searchsubmit"><i class="fa fa-search"></i><span class="button-text">' . esc_attr( $instance['button_text'] ) . '</span></button></div>';
		echo '<div class="clear"></div>
		</form>';

		esc_html( $args['after_widget'] );

	}

	/**
	 * Update Widget.
	 *
	 * @access public
	 * @param mixed $new_instance New Instance.
	 * @param mixed $old_instance Old Instance.
	 * @return New Instance.
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Widget Form.
	 *
	 * @access public
	 * @param mixed $instance Instance.
	 * @return void
	 */
	function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'       => '',
				'button_text' => __( 'Search Listings', 'wp-listings-pro' ),
			)
		);

		global $_wplpro_taxonomies;

		$listings_taxonomies = $_wplpro_taxonomies->get_taxonomies();
		$new_widget          = empty( $instance );

		printf( '<p><label for="%s">%s</label><input type="text" id="%s" name="%s" value="%s" style="%s" /></p>', esc_attr( $this->get_field_id( 'title' ) ), esc_html_e( 'Title:', 'wp-listings-pro' ), esc_attr( $this->get_field_id( 'title' ) ), esc_attr( $this->get_field_name( 'title' ) ), esc_attr( $instance['title'] ), 'width: 95%;' );
		?>
		<h5><?php esc_html_e( 'Include these taxonomies in the search widget', 'wp-listings-pro' ); ?></h5>
		<?php
		foreach ( (array) $listings_taxonomies as $tax => $data ) {
			$terms = get_terms( $tax );
			if ( empty( $terms ) ) {
				continue;
			}

			$checked = isset( $instance[ $tax ] ) && $instance[ $tax ];

			printf( '<p><label><input id="%s" type="checkbox" name="%s" value="1" %s />%s</label></p>', esc_attr( $this->get_field_id( 'tax' ) ), esc_attr( $this->get_field_name( $tax ) ), checked( 1, $checked, 0 ), esc_html( $data['labels']['name'] ) );

		}

		printf( '<p><label for="%s">%s</label><input type="text" id="%s" name="%s" value="%s" style="%s" /></p>', esc_attr( $this->get_field_id( 'button_text' ) ), esc_html_e( 'Button Text:', 'wp-listings-pro' ), esc_attr( $this->get_field_id( 'button_text' ) ), esc_attr( $this->get_field_name( 'button_text' ) ), esc_attr( $instance['button_text'] ), 'width: 95%;' );
	}
}

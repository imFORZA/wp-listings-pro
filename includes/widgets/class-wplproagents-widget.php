<?php
/**
 * Widget for employees
 *
 * @package wp-listings-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * This widget displays a featured employee.
 *
 * @since 0.9.0
 * @author Agent Evolution
 */
class WPLPROAgents_Widget extends WP_Widget {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'featured-employee',
			'description'                 => __( 'Display a featured employee or employees contact info.', 'wp-listings-pro' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array(
			'width'  => 300,
			'height' => 350,
		);
		parent::__construct( 'wplpro_employee', __( 'WP Listings Pro - Employee', 'wp-listings-pro' ), $widget_ops, $control_ops );
	}

	/**
	 * Widget.
	 *
	 * @access public
	 * @param mixed $args Arguments.
	 * @param mixed $instance Instance.
	 * @return void
	 */
	function widget( $args, $instance ) {

		global $post;

		/** Defaults. */
		$instance = wp_parse_args(
			$instance,
			array(
				'post_id'     => '',
				'title'       => '',
				'show_agent'  => 0,
				'show_number' => 1,
				'orderby'     => '',
				'order'       => '',
			)
		);

		extract( $args );

		$post_id     = $instance['post_id'];
		$title       = $instance['title'];
		$orderby     = $instance['orderby'];
		$order       = $instance['order'];
		$show_agent  = $instance['show_agent'];
		$show_number = ( ! empty( $instance['show_number'] ) ) ? absint( $instance['show_number'] ) : 1;

		echo $before_widget;

		if ( 'show_all' === $show_agent ) {
			echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
			$query_args = array(
				'post_type'      => 'employee',
				'posts_per_page' => - 1,
				'orderby'        => $orderby,
				'order'          => $order,
			);
		} elseif ( 'show_random' === $show_agent ) {
			echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
			$query_args = array(
				'post_type'      => 'employee',
				'posts_per_page' => $show_number,
				'orderby'        => 'rand',
				'order'          => $order,
			);
		} else {
			$post_id = explode( ',', $instance['post_id'] );
			echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
			$query_args = array(
				'post_type'      => 'employee',
				'p'              => $post_id[0],
				'posts_per_page' => 1,
				'orderby'        => $orderby,
				'order'          => $order,
			);
		}

		query_posts( $query_args );

		if ( have_posts() ) {
			while ( have_posts() ) :
				the_post();

				echo '<div ', post_class( 'widget-agent-wrap' ), '>';
				echo '<a href="', esc_url( get_permalink() ), '">', get_the_post_thumbnail( $post->ID, 'employee-thumbnail' ), '</a>';
				printf( '<div class="widget-agent-details"><a class="fn" href="%s">%s</a>', esc_url( get_permalink() ), esc_html( get_the_title() ) );
				echo wplpro_employee_archive_details();

				if ( function_exists( '_p2p_init' ) && function_exists( 'agentpress_listings_init' ) || function_exists( '_p2p_init' ) && function_exists( 'wplpro_init' ) ) {
					$has_listings = wplpro_has_listings( $post->ID );
					if ( ! empty( $has_listings ) ) {
						echo '<p><a class="agent-listings-link" href="' . esc_url( get_permalink() ) . '#agent-listings">View My Listings</a></p>';
					}
				}

				echo '</div>';
				echo '</div><!-- .widget-agent-wrap -->';
			endwhile;
		}
		wp_reset_query();

		echo $after_widget;

	}

	/**
	 * Update.
	 *
	 * @access public
	 * @param mixed $new_instance New Instance.
	 * @param mixed $old_instance Old Instance.
	 * @return object $new_instance
	 */
	function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['show_number'] = (int) $new_instance['show_number'];

		return $new_instance;
	}

	/**
	 * Form.
	 *
	 * @access public
	 * @param mixed $instance Instance.
	 * @return void
	 */
	function form( $instance ) {

		$instance = wp_parse_args(
			$instance,
			array(
				'post_id'     => '',
				'title'       => 'Featured Employees',
				'show_agent'  => 'show_selected',
				'show_number' => 1,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
			)
		);
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php
		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'post_id' ) ) . '">Select an Employee:</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'post_id' ) ) . '" name="' . esc_attr( $this->get_field_name( 'post_id' ) ) . '" class="widefat" style="width:100%;">';
			global $post;
			$args   = array(
				'post_type'      => 'employee',
				// TODO: Don't use -1, https://10up.github.io/Engineering-Best-Practices/php/ .
				'posts_per_page' => -1,
			);
			$agents = get_posts( $args );
		foreach ( $agents as $post ) :
			setup_postdata( $post );
			echo '<option style="margin-left: 8px; padding-right:10px;" value="' . esc_attr( $post->ID ) . ',' . esc_attr( $post->post_title ) . '" ' . selected( $post->ID . ',' . $post->post_title, $instance['post_id'], false ) . '>' . esc_html( $post->post_title ) . '</option>';
			endforeach;
		echo '</select>';
		echo '</p>';

		?>

		<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_agent' ) ); ?>"><?php esc_html_e( 'Show Agent', 'wp-listings-pro' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'show_agent' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_agent' ) ); ?>">
					<option value="show_selected" <?php selected( 'show_selected', $instance['show_agent'] ); ?>><?php esc_html_e( 'Show Agent selected above', 'wp-listings-pro' ); ?></option>
					<option value="show_random" <?php selected( 'show_random', $instance['show_agent'] ); ?>><?php esc_html_e( 'Show Random', 'wp-listings-pro' ); ?></option>
					<option value="show_all" <?php selected( 'show_all', $instance['show_agent'] ); ?>><?php esc_html_e( 'Show All', 'wp-listings-pro' ); ?></option>
				</select>
		</p>

		<hr>
		<p><?php esc_html_e( 'If Show Random selected: ', 'wp-listings-pro' ); ?></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_number' ) ); ?>"><?php esc_html_e( 'Max number of agents to show:' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_number' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['show_number'] ); ?>" size="3" maxlength="2" />
			</p>

		<hr>
		<p><?php esc_html_e( 'If Show All selected: ', 'wp-listings-pro' ); ?></p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'wp-listings-pro' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php esc_html_e( 'Date', 'wp-listings-pro' ); ?></option>
					<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php esc_html_e( 'Title', 'wp-listings-pro' ); ?></option>
					<option value="menu_order" <?php selected( 'menu_order', $instance['orderby'] ); ?>><?php esc_html_e( 'Menu Order', 'wp-listings-pro' ); ?></option>
					<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php esc_html_e( 'ID', 'wp-listings-pro' ); ?></option>
					<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php esc_html_e( 'Random', 'wp-listings-pro' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Sort Order', 'wp-listings-pro' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
					<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php esc_html_e( 'Descending (3, 2, 1)', 'wp-listings-pro' ); ?></option>
					<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php esc_html_e( 'Ascending (1, 2, 3)', 'wp-listings-pro' ); ?></option>
				</select>
			</p>
		<?php
	}

}

<?php
/**
 * Register widgets.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Adds Contact_Info_Widget.
 */
class Contact_Info_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'contact_info_widget', // ID
			'Contact Info',        // Name
			array(
				'classname' => 'widget_contact',
				'description' => __( 'Display your company contact info.', 'base' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		if ( $instance['title'] ) {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>

		<div class="contact-info">
	   	<?php
			if ( $instance['show_phone'] ) {
		      base_phone( '<p class="phone">', '</p>', 'option' );
			}

			if ( $instance['show_email'] ) {
				base_email( '<p class="email">', '</p>', 'option' );
			}

			if ( $instance['show_address'] ) {
				base_address();
			}
			?>
		</div>

		<?php
		if ( $instance['show_map'] ) {
			get_template_part( 'template-parts/map' );
		}

		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$show_phone = isset( $instance['show_phone'] ) ? ( bool ) $instance['show_phone'] : false;
		$show_email = isset( $instance['show_email'] ) ? ( bool ) $instance['show_email'] : false;
		$show_address = isset( $instance['show_address'] ) ? ( bool ) $instance['show_address'] : false;
		$show_map = isset( $instance['show_map'] ) ? ( bool ) $instance['show_map'] : false;
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'base' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_phone ); ?> id="<?php echo $this->get_field_id( 'show_phone' ); ?>" name="<?php echo $this->get_field_name( 'show_phone' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_phone' ); ?>"><?php _e( 'Display phone?', 'base' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_email ); ?> id="<?php echo $this->get_field_id( 'show_email' ); ?>" name="<?php echo $this->get_field_name( 'show_email' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_email' ); ?>"><?php _e( 'Display email?' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_address ); ?> id="<?php echo $this->get_field_id( 'show_address' ); ?>" name="<?php echo $this->get_field_name( 'show_address' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_address' ); ?>"><?php _e( 'Display address?', 'base' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_map ); ?> id="<?php echo $this->get_field_id( 'show_map' ); ?>" name="<?php echo $this->get_field_name( 'show_map' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_map' ); ?>"><?php _e( 'Display map?', 'base' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['show_phone'] = isset( $new_instance['show_phone'] ) ? ( bool ) $new_instance['show_phone'] : false;
		$instance['show_email'] = isset( $new_instance['show_email'] ) ? ( bool ) $new_instance['show_email'] : false;
		$instance['show_address'] = isset( $new_instance['show_address'] ) ? ( bool ) $new_instance['show_address'] : false;
		$instance['show_map'] = isset( $new_instance['show_map'] ) ? ( bool ) $new_instance['show_map'] : false;

		return $instance;
	}

}

/**
 * Register widgets for this theme.
 */
function base_register_widgets()
{
	register_widget( 'Contact_Info_Widget' );
}
add_action( 'widgets_init', 'base_register_widgets' );

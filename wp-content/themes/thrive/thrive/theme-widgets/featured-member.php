<?php

/**
 * Adds Thrive_Featured_Member_Widget widget.
 */
class Thrive_Featured_Member_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'thrive_featured_member_widget', // Base ID
			__( 'Thrive: Featured Member', 'thrive' ), // Name
			array( 'description' => __( 'Use this widget to feature a member.', 'thrive' ), ) // Args
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
		
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {

			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];

		}

		$user = $this->get_user( $instance['username'] );

		if ( empty ( $user ) ) {
			?>
			<p>
				<?php _e('I can\'t seem to find a user with that username. Please check your username input.', 'thrive'); ?>
			</p>
			<?php
			echo $args['after_widget'];
			return false;
		} 

		$user_link = bp_core_get_userlink( $user->ID );
		$user_domain = bp_core_get_user_domain( $user->ID );
		
		$user_domain_profile  = sprintf( "%sprofile",  $user_domain );
		$user_domain_activity = sprintf( "%sactivity", $user_domain );
		$user_domain_friends  = sprintf( "%sfriends",  $user_domain );
		?>
		<div class="fmember-member-details">

			<div class="fmember-avatar">
				<h3 class="h6">
					<?php echo esc_html( $instance['title'] ); ?>
				</h3>
				<a href="<?php echo esc_url( $user_domain ); ?>" alt="<?php _e('Visit Member Profile', 'thrive'); ?>">
					<?php echo get_avatar( $user->ID, 325 ); ?>
				</a>
			</div>

			<div class="fmember-title">
				<h5>
					<?php echo $user_link; ?>
				</h5>
				<!-- Display member title-->
				<?php if ( function_exists( 'xprofile_get_field_data' ) ) { ?>
					<span>
						<?php echo xprofile_get_field_data( 'Role', $user->ID ); ?>
					</span>
				<?php } ?>
			</div>
			
			<div class="fmember-links">
			
				<a href="<?php echo esc_url( $user_domain_profile ); ?>">
					<i class="material-icons md-24 md-dark">account_circle</i>
					<?php _e('Profile', 'thrive'); ?>
				</a>
			
				<a href="<?php echo esc_url( $user_domain_activity ); ?>">
					<i class="material-icons md-24 md-dark">notifications_none</i>
					<?php _e('Activity', 'thrive'); ?>
				</a>
		
				<a class="last" href="<?php echo esc_url( $user_domain_friends ); ?>">
					<i class="material-icons md-24 md-dark">people_outline</i>
					<?php _e('Friends', 'thrive'); ?>
				</a>
				
				<div class="clearfix"></div>
			</div>	
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Member', 'thrive' );
		$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
		?>
		<p>
			
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'thrive' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			
			<span class="help-text">
				<em><?php _e('You can use this field to enter the widget title.', 'thrive'); ?></em>
			</span>
		</p>

		<p>
			
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:', 'thrive' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username  ); ?>">
			
			<span class="help-text">
				<em><?php _e('Enter the username of the member that you want to be featured.', 'thrive'); ?></em>
			</span>

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

		$instance = array();

		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';

		return $instance;
	}


	public function get_user( $user_login = "" ) {
		
		global $wpdb;
		
		$user = '';

		$id = bp_core_get_userid( $user_login );
		
		if ( $id ) {

			$user = bp_core_get_core_userdata( $id );

			if ( $user ) {
				return $user;
			} else {
				return false;
			}
		}

		
		return false;
	}

} // class Thrive_Featured_Member_Widget

add_action( 'widgets_init', 'thrive_register_fmember_widget' );

function thrive_register_fmember_widget() {

	register_widget( 'Thrive_Featured_Member_Widget' );

	return;
}
<?php
/**
 * Adds Thrive_Featured_Group_Widget widget.
 */
class Thrive_Featured_Group_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'thrive_featured_group_widget', // Base ID
			__( 'Thrive: Featured Group', 'thrive' ), // Name
			array( 'description' => __( 'Use this widget to feature a group.', 'thrive' ), ) // Args
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

		$group = $this->get_group( $instance['groupname'] );

		if ( ! function_exists( 'buddypress' ) ) {
			echo __('Unable to fetch groups. Is BuddyPress installed or activated?', 'thrive');
			return;
		}

		if ( empty ( $group ) ) {
			?>
			<p>
				<?php _e('I can\'t seem to find a group with that group name. Please check your group name input.', 'thrive'); ?>
			</p>
			<?php
			echo $args['after_widget'];
			return false;
		}

		// Gets the id of a group from a slug.
		$group_id = groups_get_id( $group );
		$group = groups_get_group( array( 'group_id' => $group_id ) );

		$group_link = bp_get_group_name( $group);
		$user_domain = rtrim(bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . groups_get_slug( $group_id ). '/');

		$user_domain_activity = sprintf( "%sactivity", $user_domain );
		$user_domain_friends  = sprintf( "%smembers",  $user_domain );

		// Getting the URL with bp_core_fetch_avatar
		$avatar_options = array( 'item_id' => 0, 'object' => 'group', 'type' => 'full' );

		// Sets the $avatar_options["item_id"] equal to groups id.
		$avatar_options["item_id"] = $group_id;

		// Use the bp_core_fetch_avatar function to get the group avatar.
		$group_avatar = bp_core_fetch_avatar($avatar_options);

		?>
		<div class="fmember-member-details">

			<div class="fmember-avatar">
				<h3 class="h6">
					<?php echo esc_html( $instance['title'] ); ?>
				</h3>
				<a href="<?php echo esc_url( $user_domain ); ?>" alt="<?php _e('Visit Group Profile', 'thrive'); ?>">
					<?php echo $group_avatar ?>
				</a>
			</div>

			<div class="fmember-title">
				<h5>
					<?php echo $group_link; ?>
				</h5>
			</div>

			<div class="fmember-links">

				<a href="<?php echo esc_url( $user_domain_activity ); ?>">
					<i class="material-icons md-24 md-dark">notifications_none</i>
					<?php _e('Activities', 'thrive'); ?>
				</a>

				<a class="last" href="<?php echo esc_url( $user_domain_friends ); ?>">
					<i class="material-icons md-24 md-dark">people_outline</i>
					<?php _e('Members', 'thrive'); ?>
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

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Group', 'thrive' );
		$groupname = ! empty( $instance['groupname'] ) ? $instance['groupname'] : '';
		?>
		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'thrive' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

			<span class="help-text">
				<em><?php _e('You can use this field to enter the widget title.', 'thrive'); ?></em>
			</span>
		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'groupname' ); ?>"><?php _e( 'Groups Name:', 'thrive' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'groupname' ); ?>" name="<?php echo $this->get_field_name( 'groupname' ); ?>" type="text" value="<?php echo esc_attr( $groupname ); ?>">

			<span class="help-text">
				<em><?php _e('Enter the name of the group that you want to be featured.', 'thrive'); ?></em>
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
		$instance['groupname'] = ( ! empty( $new_instance['groupname'] ) ) ? strip_tags( sanitize_file_name ($new_instance['groupname'] ) ) : '';

		return $instance;
	}


	public function get_group( $group_login = "" ) {

		global $wpdb;

		if( ! function_exists( 'groups_get_id' ) ) {
			return;
		}

		$group = '';

		$id = groups_get_id( $group_login );

		if ( $id ) {

			$group = groups_get_slug( $id );

			if ( $group ) {
				return $group;
			} else {
				return false;
			}
			return $id;
		}


		return false;
	}

} // class Thrive_Featured_Member_Widget

add_action( 'widgets_init', 'thrive_register_featured_group_widget' );

function thrive_register_featured_group_widget() {

	register_widget( 'Thrive_Featured_Group_Widget' );

	return;
}

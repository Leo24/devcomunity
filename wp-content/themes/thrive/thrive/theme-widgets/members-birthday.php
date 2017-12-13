<?php
/**
 * Adds thrive_members_birthday_widget widget.
 */
class Thrive_Members_Birthday_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	function __construct() {
		parent::__construct(
			'thrive_members_birthday_widget', // Base ID
			__( 'Thrive: Birthday Widget', 'thrive' ), // Name
			array( 'description' => __( 'Celebrate your members\' birthday with Thrive Birthday Widget.', 'thrive' ), ) // Args
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

		global $wpdb;

		ob_start();

		?>

		<?php $db_field_id = 0; ?>

		<?php if ( function_exists('xprofile_get_field_id_from_name') ) { ?>

			<?php $db_field_id = xprofile_get_field_id_from_name( 'Date of Birth' ); ?>

		<?php } ?>

		<?php if ( empty( $db_field_id ) ) { ?>

			<?php esc_html_e('I can\'t find "Date of Birth" profile data. Have you added "Date of Birth" user field already?', 'thrive'); ?>

			<?php echo thrive_sanity_check( $args['after_widget'] ); ?>

		<?php } ?>

		<?php
			$scope = intval( $instance['filter'] ); //1 Yearly, 2 Monthly, 3 Weekly

			// 1. Yearly
			// Date of birth query
		 	$stmt = $wpdb->prepare( "
				SELECT user_id, value, DayOfYear( STR_TO_DATE( value, '%%Y-%%c-%%d') ) as `day_of_year`,
				STR_TO_DATE( value, '%%Y-%%c-%%d') as `birth_day`
				FROM {$wpdb->prefix}bp_xprofile_data
				WHERE field_id = %d
				AND DayOfYear( STR_TO_DATE( value, '%%Y-%%c-%%d') ) >= DayOfYear( STR_TO_DATE( '%s', '%%Y-%%c-%%d') )
				ORDER BY `day_of_year` ASC LIMIT 15",
                $db_field_id, // Field ID
				date('Y-m-d') // Date today
			);

			// 2. Monthly
			if ( 2 === $scope ) {
				$stmt = $wpdb->prepare( "
					SELECT user_id, value, DayOfYear( STR_TO_DATE( value, '%%Y-%%c-%%d') ) as `day_of_year`,
					STR_TO_DATE( value, '%%Y-%%c-%%d') as `birth_day`
					FROM {$wpdb->prefix}bp_xprofile_data
					WHERE field_id = %d
					AND MONTH( STR_TO_DATE( value, '%%Y-%%c-%%d') ) = MONTH( STR_TO_DATE( '%s', '%%Y-%%c-%%d') )
					AND DayOfYear( STR_TO_DATE( value, '%%Y-%%c-%%d') ) >= DayOfYear( STR_TO_DATE( '%s', '%%Y-%%c-%%d') )
					ORDER BY `day_of_year` ASC LIMIT 15",
                    $db_field_id, // Field ID
					date('Y-m-d'), // Date today
					date('Y-m-d') // Date today
				);
			}

			// 3. Weekly
			if ( 3 === $scope ) {
				$stmt = $wpdb->prepare( "
					SELECT
					user_id, value,
					DayOfYear( STR_TO_DATE( value, '%%Y-%%c-%%d') ) as `day_of_year`,
					STR_TO_DATE( value, '%%Y-%%c-%%d') as `birth_day`
					FROM {$wpdb->prefix}bp_xprofile_data
					WHERE field_id = %d
					AND WEEKOFYEAR( STR_TO_DATE( REPLACE( value, LEFT( value, 4 ), '%s'), '%%Y-%%c-%%d') ) = WEEKOFYEAR( STR_TO_DATE( '%s', '%%Y-%%c-%%d') )
					ORDER BY `day_of_year` ASC LIMIT 15",
                    $db_field_id, // Field ID
					date('Y'), // Year now
					date('Y-m-d') // Date today
				);
			}
		?>
		<?php $members = $wpdb->get_results( $stmt, OBJECT ); ?>

		<?php if ( ! empty( $members ) ) { ?>
			<ul class="thrive-bday-widget-list">
				<?php
					$now = date('F d');
					foreach( $members as $member ) {
						$user_id = $member->user_id;
						$user_link = bp_core_get_userlink( $user_id );
						$user_domain = bp_core_get_user_domain( $user_id );
						$user_domain_activity = sprintf( "%sactivity", $user_domain );
						$user_dob = $member->value;
						?>
						<li>
							<div class="row">
								<div class="col-xs-3 pd-right-5">
									<a href="<?php echo esc_url( $user_domain_activity ); ?>" title="<?php _e('Visit Profile', 'thrive'); ?>">
										<?php echo get_avatar( $user_id, 64 ); ?>
									</a>
								</div>

								<div class="col-xs-9">
									<h5 class="light mg-bottom-5"><?php echo thrive_sanity_check( $user_link ); ?></h5>
									<p>
										<?php $user_dob_formatted = date_i18n('F d', strtotime( $user_dob ) ); ?>
										<?php if ( $now === $user_dob_formatted ) { ?>
											<?php $bp_page_option = get_option('bp-pages'); ?>
											<?php $user_name = bp_members_get_user_nicename( $user_id ); ?>
											<?php $greetings_link = $user_domain; ?>
											<?php if ( !empty( $bp_page_option['activity'] ) ) { ?>
												<?php $greetings_link = get_permalink( $bp_page_option['activity'] ); ?>
												<?php $message = apply_filters('thrive_activity_birthday_message', __(' Happy%20Birthday!', 'thrive')); ?>
												<?php $greetings_link .= "?r=".$user_name.'%20'.$message; ?>
											<?php } ?>
											<span class="celebrating">
												<i class="material-icons md-18 secondary">cake</i>
												<a href="<?php echo esc_url( $greetings_link ); ?>" title="<?php _e('Happy Birthday!', 'thrive'); ?>">
													<?php _e('Greet', 'thrive'); ?>
												</a>
											</span>
										<?php } else { ?>
											<span class="upcoming">
												<i class="material-icons md-18">cake</i>
												<?php echo esc_html( $user_dob_formatted ); ?>
											</span>
										<?php } ?>
									</p>
								</div>
							</div>
						</li>
					<?php } //end foreach
				?>

			</ul>
		<?php } else { ?>
				<div class="text-info" class="widget-thrive-bday-no-result">
					<?php echo __('There are no upcoming birthday celebrations', 'thrive'); ?>
				</div>
		<?php } ?>
		<?php

		$template = ob_get_clean();

		if ( "on" === $instance['is_hide'] ) {
			if ( $birthday_count <= 0 ) {
				// Do nothing...
			} else {

				echo thrive_sanity_check( $args['before_widget'] );

					if ( ! empty( $instance['title'] ) ) {
						echo thrive_sanity_check( $args['before_title'] ) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
					}

					echo thrive_sanity_check( $template );

				echo thrive_sanity_check( $args['after_widget'] );
			}
		} else {

			echo thrive_sanity_check( $args['before_widget'] );

				if ( ! empty( $instance['title'] ) ) {
					echo thrive_sanity_check( $args['before_title'] ) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
				}

				echo thrive_sanity_check( $template );

			echo thrive_sanity_check( $args['after_widget'] );
		}

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Birthdays', 'thrive' );
		$filter = ! empty( $instance['filter'] ) ? $instance['filter'] : 1;
		$is_hide = ! empty( $instance['is_hide'] ) ? $instance['is_hide'] : 'no';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Show Birthdays:', 'thrive' ); ?></label>
			<br/>
			<select name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">
				<option <?php echo absint( $filter ) === 1 ? "selected":"";?> value="1"><?php esc_html_e('This Year','thrive'); ?> </option>
				<option <?php echo absint( $filter ) === 2 ? "selected":"";?> value="2"><?php esc_html_e('This Month', 'thrive'); ?></option>
				<option <?php echo absint( $filter ) === 3 ? "selected":"";?> value="3"><?php esc_html_e('This Week', 'thrive'); ?> </option>
			</select>
		</p>

		<p>
			<?php
			$checked = '';
			if ( "on" === $is_hide ) {
					$checked = 'checked';
				};
			?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_hide' ) ); ?>">
				<?php esc_html_e( 'Hide if no birthdays:', 'thrive' ); ?>
			</label>
			<input type="checkbox" <?php echo esc_attr( $checked ); ?> name="<?php echo esc_attr( $this->get_field_name( 'is_hide' ) ); ?>" id="<?php echo esc_html( $this->get_field_id( 'is_hide' ) ); ?>" />
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

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['filter'] = ( ! empty( $new_instance['filter'] ) ) ? strip_tags( $new_instance['filter'] ) : '';
		$instance['is_hide'] = ( ! empty( $new_instance['is_hide'] ) ) ? strip_tags( $new_instance['is_hide'] ) : '';

		return $instance;
	}

} // class thrive_members_birthday_widget

// register thrive_members_birthday_widget widget
function register_thrive_members_birthday_widget() {
    register_widget( 'thrive_members_birthday_widget' );
}

add_action( 'widgets_init', 'register_thrive_members_birthday_widget' );

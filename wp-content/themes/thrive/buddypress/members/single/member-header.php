<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

/**
 * Fires before the display of a member's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_member_header' ); ?>

<div id="item-header-context">
	<div id="item-header-avatar">
		<div id="item-user-detail-scope">
		<a href="<?php bp_displayed_user_link(); ?>">
			<?php bp_displayed_user_avatar( 'type=full' ); ?>
		</a>
		<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
			<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
		<?php endif; ?>
			<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
		</div>
	</div><!-- #item-header-avatar -->

	<div id="item-header-content">

		<h2 class="profile-item-title">

			<?php the_title(); ?>

			<?php // Added temporary error control operator to silence notices thrown in bp 2.7. ?>

			<?php $role = @bp_get_member_profile_data( 'field=Role' ); ?>

			<?php if ( ! empty( $role ) ) { ?>

				<span class="thrive-member-role">
					<?php echo esc_html( $role ); ?>
				</span>

			<?php } ?>

		</h2>

		<?php

		/**
		 * Fires before the display of the member's header meta.
		 *
		 * @since BuddyPress (1.2.0)
		 */
		do_action( 'bp_before_member_header_meta' ); ?>

		<div id="item-meta">
			<?php if ( bp_is_active( 'activity' ) ) : ?>
				<div id="latest-update">
					<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>
				</div>
			<?php endif; ?>
			<div id="item-buttons">
				<?php
				/**
				 * Fires in the member header actions section.
				 *
				 * @since BuddyPress (1.2.6)
				 */
				do_action( 'bp_member_header_actions' ); ?>
			</div><!-- #item-buttons -->
			<?php

			 /**
			  * Fires after the group header actions section.
			  *
			  * If you'd like to show specific profile fields here use:
			  * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
			  *
			  * @since BuddyPress (1.2.0)
			  */
			 do_action( 'bp_profile_header_meta' );

			 ?>

		</div><!-- #item-meta -->
	</div><!-- #item-header-content -->
	<div class="clearfix"></div>
</div><!-- #item-header-context -->

<div class="clearfix"></div>

<?php

/**
 * Fires after the display of a member's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_after_member_header' ); ?>

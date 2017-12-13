<?php

/**
 * Fires before the display of a group's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_group_header' );

?>

<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>

	<div id="item-header-avatar">
		<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">
			<?php bp_group_avatar(''); ?>
		</a>

		<div id="item-buttons" class="text-aligncenter mg-top-10 mg-bottom-20">
			<?php
			/**
			 * Fires in the group header actions section.
			 *
			 * @since BuddyPress (1.2.6)
			 */
			do_action( 'bp_group_header_actions' ); ?>
		</div><!-- #item-buttons -->

	</div><!-- #item-header-avatar -->

<?php endif; ?>

<div id="item-header-content">

	<h2 class="profile-item-title">
		<?php bp_group_name(); ?>
	</h2>

	<span class="highlight"><?php bp_group_type(); ?></span>
	<span class="activity"><?php printf( __( 'active %s', 'thrive' ), bp_get_group_last_active() ); ?></span>

	<?php

	/**
	 * Fires before the display of the group's header meta.
	 *
	 * @since BuddyPress (1.2.0)
	 */
	do_action( 'bp_before_group_header_meta' ); ?>

	<div id="item-meta">

		<?php bp_group_description(); ?>

		<?php if ( function_exists( 'bp_group_type_list' ) ) { ?>
			<?php bp_group_type_list(); ?>
		<?php } ?>

		<?php

		/**
		 * Fires after the group header actions section.
		 *
		 * @since BuddyPress (1.2.0)
		 */
		do_action( 'bp_group_header_meta' ); ?>

	</div>

</div><!-- #item-header-content -->
<div class="clearfix"></div>
<div id="item-actions">

	<?php if ( bp_group_is_visible() ) : ?>

		<div id="item-officials">
			<?php bp_group_list_admins();
			/**
			 * Fires after the display of the group's administrators.
			 *
			 * @since BuddyPress (1.1.0)
			 */
			do_action( 'bp_after_group_menu_admins' );
			if ( bp_group_has_moderators() ) :
				/**
				 * Fires before the display of the group's moderators, if there are any.
				 *
				 * @since BuddyPress (1.1.0)
				 */
				do_action( 'bp_before_group_menu_mods' ); ?>

				<?php bp_group_list_mods();

				/**
				 * Fires after the display of the group's moderators, if there are any.
				 *
				 * @since BuddyPress (1.1.0)
				 */
				do_action( 'bp_after_group_menu_mods' );

			endif; ?>
	</div><!--.#item-officials-->

	<?php endif; ?>

</div><!-- #item-actions -->
<div class="clearfix"></div>
<?php

/**
 * Fires after the display of a group's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_after_group_header' );
?>

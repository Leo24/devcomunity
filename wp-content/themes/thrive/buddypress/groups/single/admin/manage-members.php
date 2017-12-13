<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<h2 class="bp-screen-reader-text"><?php _e( 'Manage Members', 'thrive' ); ?></h2>

<?php

/**
 * Fires before the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_manage_members_admin' ); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">

	<div class="bp-widget group-members-list group-admins-list">
		<h4 class="section-header"><?php _e( 'Administrators', 'thrive' ); ?></h4>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'group_role' => array( 'admin' ), 'page_arg' => 'mlpage-admin' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="admins-list" class="item-list single-line">

				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

					<li>
                        <div class="row">
    						<div class="item-avatar col-sm-2">
    							<?php bp_group_member_avatar_thumb( array( 'type' => 'full', 'width' => 150, 'height' => 150, 'alt' => sprintf( __( 'Profile picture of %s', 'thrive' ), bp_get_member_name() ) ) ); ?>
    						</div>

    						<div class="item col-sm-10">
    							<div class="item-title">
    								<?php bp_group_member_link(); ?>
    							</div>
    							<p class="joined item-meta">
    								<?php bp_group_member_joined_since(); ?>
    							</p>
    							<?php

    							/**
    							 * Fires inside the item section of a member admin item in group management area.
    							 *
    							 * @since 1.1.0
    							 * @since 2.7.0 Added $section parameter.
    							 *
    							 * @param $section Which list contains this item.
    							 */
    							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>

        						<div class="action manage-members small">
        							<?php if ( count( bp_group_admin_ids( false, 'array' ) ) > 1 ) : ?>

                                        <?php
                                        /**
                                         * Removed the .button class
                                         * @since 2.1.1 of Thrive
                                         */
                                        ?>
                                        <a class="confirm admin-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php _e( 'Demote to Member', 'thrive' ); ?></a>
        							<?php endif; ?>

        							<?php

        							/**
        							 * Fires inside the action section of a member admin item in group management area.
        							 *
        							 * @since 2.7.0
        							 *
        							 * @param $section Which list contains this item.
        							 */
        							do_action( 'bp_group_manage_members_admin_actions', 'admins-list' ); ?>
        						</div>
    						</div>
    					</div>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

		<div id="message" class="info">
			<p><?php _e( 'No group administrators were found.', 'thrive' ); ?></p>
		</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list group-mods-list">
		<h4 class="section-header"><?php _e( 'Moderators', 'thrive' ); ?></h4>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'group_role' => array( 'mod' ), 'page_arg' => 'mlpage-mod' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="mods-list" class="item-list single-line">

				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li>
                        <div class="row">
    						<div class="item-avatar col-sm-2">
    							<?php bp_group_member_avatar_thumb( array( 'type' => 'full', 'width' => 150, 'height' => 150, 'alt' => sprintf( __( 'Profile picture of %s', 'thrive' ), bp_get_member_name() ) ) ); ?>
    						</div>

    						<div class="item col-sm-10">
    							<div class="item-title">
    								<?php bp_group_member_link(); ?>
    							</div>
    							<p class="joined item-meta">
    								<?php bp_group_member_joined_since(); ?>
    							</p>
    							<?php

    							/**
    							 * Fires inside the item section of a member admin item in group management area.
    							 *
    							 * @since 1.1.0
    							 * @since 2.7.0 Added $section parameter.
    							 *
    							 * @param $section Which list contains this item.
    							 */
    							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>

        						<div class="action manage-members small">

                                    <?php
                                    /**
                                     * Removed the .button class
                                     * @since 2.1.1 of Thrive
                                     */
                                    ?>
        							<a href="<?php bp_group_member_promote_admin_link(); ?>" class="confirm mod-promote-to-admin"><?php _e( 'Promote to Admin', 'thrive' ); ?></a>

                                    <?php
                                    /**
                                     * Removed the .button class
                                     * @since 2.1.1 of Thrive
                                     */
                                    ?>
                                    <a class="confirm mod-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php _e( 'Demote to Member', 'thrive' ); ?></a>

        							<?php

        							/**
        							 * Fires inside the action section of a member admin item in group management area.
        							 *
        							 * @since 2.7.0
        							 *
        							 * @param $section Which list contains this item.
        							 */
        							do_action( 'bp_group_manage_members_admin_actions', 'mods-list' ); ?>

        						</div>
    						</div>
						</div>
					</li>
				<?php endwhile; ?>

			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'No group moderators were found.', 'thrive' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list">
		<h4 class="section-header"><?php _e( "Members", 'thrive' ); ?></h4>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'exclude_banned' => 0 ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="members-list" class="item-list single-line" aria-live="assertive" aria-relevant="all">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

					<li class="<?php bp_group_member_css_class(); ?>">
                        <div class="row">
    						<div class="item-avatar col-sm-2">
    							<?php bp_group_member_avatar_thumb( array( 'type' => 'full', 'width' => 150, 'height' => 150, 'alt' => sprintf( __( 'Profile picture of %s', 'thrive' ), bp_get_member_name() ) ) ); ?>
    						</div>

    						<div class="item col-sm-10">
    							<div class="item-title">
    								<?php bp_group_member_link(); ?>
    								<?php
    								if ( bp_get_group_member_is_banned() ) {
    									echo ' <span class="banned">';
    									_e( '(banned)', 'thrive' );
    									echo '</span>';
    								} ?>
    							</div>
    							<p class="joined item-meta">
    								<?php bp_group_member_joined_since(); ?>
    							</p>
    							<?php

    							/**
    							 * Fires inside the item section of a member admin item in group management area.
    							 *
    							 * @since 1.1.0
    							 * @since 2.7.0 Added $section parameter.
    							 *
    							 * @param $section Which list contains this item.
    							 */
    							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>


        						<div class="manage-members small">
        							<?php if ( bp_get_group_member_is_banned() ) : ?>

                                        <?php
                                        /**
                                         * Removed the .button class
                                         * @since 2.1.1 of Thrive
                                         */
                                        ?>
        								<a href="<?php bp_group_member_unban_link(); ?>" class="confirm member-unban" title="<?php esc_attr_e( 'Unban this member', 'thrive' ); ?>"><?php _e( 'Remove Ban', 'thrive' ); ?></a>

        							<?php else : ?>

                                        <?php
                                        /**
                                         * Removed the .button class
                                         * @since 2.1.1 of Thrive
                                         */
                                        ?>
        								<a href="<?php bp_group_member_ban_link(); ?>" class="confirm member-ban"><?php _e( 'Kick &amp; Ban', 'thrive' ); ?></a>

                                        <?php
                                        /**
                                         * Removed the .button class
                                         * @since 2.1.1 of Thrive
                                         */
                                        ?>
                                        <a href="<?php bp_group_member_promote_mod_link(); ?>" class="confirm member-promote-to-mod"><?php _e( 'Promote to Mod', 'thrive' ); ?></a>

                                        <?php
                                        /**
                                         * Removed the .button class
                                         * @since 2.1.1 of Thrive
                                         */
                                        ?>
                                        <a href="<?php bp_group_member_promote_admin_link(); ?>" class="confirm member-promote-to-admin"><?php _e( 'Promote to Admin', 'thrive' ); ?></a>

        							<?php endif; ?>

                                    <?php
                                    /**
                                     * Removed the .button class
                                     * @since 2.1.1 of Thrive
                                     */
                                    ?>
        							<a href="<?php bp_group_member_remove_link(); ?>" class="confirm"><?php _e( 'Remove from group', 'thrive' ); ?></a>

        							<?php

        							/**
        							 * Fires inside the action section of a member admin item in group management area.
        							 *
        							 * @since 2.7.0
        							 *
        							 * @param $section Which list contains this item.
        							 */
        							do_action( 'bp_group_manage_members_admin_actions', 'members-list' ); ?>
        						</div>
                            </div>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'No group members were found.', 'thrive' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

</div>

<?php

/**
 * Fires after the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_manage_members_admin' ); ?>

<?php
/**
 * BuddyPress - Groups Admin - Edit Details
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

/**
 * Fires before the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_details_admin' ); ?>

<h2 class="bp-screen-reader-text"><?php _e( 'Manage Group Details', 'thrive' ); ?></h2>

<label for="group-name"><?php _e( 'Group Name (required)', 'thrive' ); ?></label>
<input type="text" name="group-name" id="group-name" value="<?php bp_group_name(); ?>" aria-required="true" />

<label for="group-desc"><?php _e( 'Group Description (required)', 'thrive' ); ?></label>
<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_group_description_editable(); ?></textarea>

<?php

/**
 * Fires after the group description admin details.
 *
 * @since 1.0.0
 */
do_action( 'groups_custom_group_fields_editable' ); ?>

<p>
	<label for="group-notify-members">
		<input type="checkbox" name="group-notify-members" id="group-notify-members" value="1" /> <?php _e( 'Notify group members of these changes via email', 'thrive' ); ?>
	</label>
</p>

<?php

/**
 * Fires after the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_details_admin' ); ?>

<p><input type="submit" value="<?php esc_attr_e( 'Save Changes', 'thrive' ); ?>" id="save" name="save" /></p>
<?php wp_nonce_field( 'groups_edit_group_details' ); ?>

<?php
/**
 * Index Register
 *
 * This file loads the minimal or default register page
 * depending on user selected option
 *
 * @since 1.8.5
 */

$user_layout = 'minimal';
get_template_part(sprintf('buddypress/members/%s-register', $user_layout));
?>

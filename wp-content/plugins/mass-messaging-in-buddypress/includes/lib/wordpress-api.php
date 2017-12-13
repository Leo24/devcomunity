<?php if (!defined('ABSPATH')) {
	exit;
}

class Mass_Messaging_in_BuddyPress_WordPress_API
{
	public function add_subnav_item(&$wp_admin_bar, $options) {
		$wp_admin_bar->add_node(['id'     => $options[ 'slug' ],
								 'parent' => 'my-account-' . $options[ 'parent_id' ],
								 'title'  => $options[ 'name' ],
								 'href'   => trailingslashit($options[ 'link' ] . $options[ 'slug' ])]);
	}
}
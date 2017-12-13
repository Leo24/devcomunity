<?php if(!defined('ABSPATH')) exit;

class Mass_Messaging_in_BuddyPress_BuddyPress_API {
	
	public function add_subnav_item($options){
		
		bp_core_new_subnav_item(array(
			'name' 			  => $options['name'],
			'slug' 			  => $options['slug'],
			'parent_url' 	  => $options['link'],
			'parent_slug' 	  => $options['parent_slug'],
			'screen_function' => $options['screen'],
			'position'		  => $options['position']
		));
	}
}
<?php
/**
 * 
 */

if ( !defined('ABSPATH') ) die();

$sidebars = array();

// Register Additional Sidebars.
if ( defined('THRIVE_SIDEBAR_UNIQUE_ID') ) {

	$sidebars = unserialize( get_option( THRIVE_SIDEBAR_UNIQUE_ID ) ); 

}

if ( !empty( $sidebars ) ) { 
	
	foreach( $sidebars as $sidebar ) { 

		if( !empty( $sidebar['thrive-sidebar-name'] ) ) {

			$sidebar_args = array(
				'name'          => $sidebar['thrive-sidebar-name'],
				'id' 			=> $sidebar['thrive-sidebar-id'],
				'before_widget' => '<aside id="%1$s" class="sidebar-widgets widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3><div class="widget-clear"></div>',
			);

			register_sidebar( $sidebar_args );
		}
	}
}
?>
<?php
/**
 * Sidebars Action
 *
 * @package Thrive
 * @since 1.0
 */
?>
<?php

DEFINE( 'THRIVE_SIDEBAR_UNIQUE_ID', 'thrive_register_sidebar_settings_menu' );

add_action( 'init', 'thrive_sidebar_meta' );
add_action( 'wp_ajax_thrive_sidebar_add', 'thrive_sidebar_add' );
add_action( 'wp_ajax_thrive_sidebar_delete', 'thrive_sidebar_delete' );
add_action( 'wp_ajax_thrive_sidebar_update', 'thrive_sidebar_update' );
add_action( 'widgets_init', 'thrive_sidebar_register' );
add_action( 'admin_menu', 'thrive_register_sidebar_settings' );

function thrive_sidebar_meta() {
	
	require_once get_template_directory() . '/thrive/sidebars/sidebars-meta.php';

	return;
}


function thrive_sidebar_register() {

	require_once get_template_directory() . '/thrive/sidebars/sidebars-register.php';

	return;
}
/**
 * Register Unlimited Sidebar Option
 */
function thrive_register_sidebar_settings() {
	// add option page under appearance
	
	add_theme_page( 
			__( 'Sidebars','thrive'),
			__('Sidebars','thrive'), 
				'read', 
				THRIVE_SIDEBAR_UNIQUE_ID, 
				'thrive_register_sidebar_settings_page'
		);
}

function thrive_register_sidebar_settings_page() {

	locate_template(
		array(
			'thrive/sidebars/sidebars-screen.php'
		),
		true,
		true
	);

	return;

}


/**
 * Updates the sidebar.
 */
function thrive_sidebar_update(){
	
	// check if user has the right to manage options
	if( current_user_can( 'manage_options' ) ){
		
		$sidebar_id = esc_attr( $_POST['sidebar_id'] );
		
		if( empty( $sidebar_id ) ) die();
		
		$option_key = THRIVE_SIDEBAR_UNIQUE_ID;
		$existing_sidebar = unserialize( get_option( $option_key ) );
		
		// remove the sidebar from the serialized array
		$existing_sidebar[ $sidebar_id ]['thrive-sidebar-name'] = esc_attr( $_POST['thrive-sidebar-name'] );
		$existing_sidebar[ $sidebar_id ]['thrive-sidebar-description'] = esc_attr( $_POST['thrive-sidebar-description'] );
	
		update_option( THRIVE_SIDEBAR_UNIQUE_ID, serialize( $existing_sidebar ) );
		wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&action=edit&sidebar=' . $sidebar_id ) );
	}
	
	die();
} 
/**
 * Removes a sidebar
 */
function thrive_sidebar_delete(){
	
	// check if user has the right to manage options
	if( current_user_can( 'manage_options' ) ){
		
		$sidebar_id = esc_attr( $_GET['sidebar'] );
		
		if( empty( $sidebar_id ) ) die();
		
		$option_key = THRIVE_SIDEBAR_UNIQUE_ID;
		$existing_sidebar = unserialize( get_option( $option_key ) );
		// remove the sidebar from the serialized array
		unset( $existing_sidebar[ $sidebar_id ] );
		update_option( THRIVE_SIDEBAR_UNIQUE_ID, serialize( $existing_sidebar ) );
		wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'' ) );
	}
	
	die();
	
}
/**
 * adds new custom sidebar
 */
function thrive_sidebar_add(){

	// check if current user has the ability
	// to manage the option, most probably the 
	// website administrator
	// @thrive version 1
	
	$option_key = THRIVE_SIDEBAR_UNIQUE_ID; // to make sure the option is unique to avoid 
	
	
	if( current_user_can('manage_options') ){
		
		$current_sidebars = unserialize( get_option( $option_key ) );	
		
		// just insert the serialized data if no sidebars
		// are added yet
		if( empty( $_POST['thrive-sidebar-name'] ) ){
			wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&sidebar-error=true' ) );
			die();
		}
		
		// allow only alpha numeric
		if( preg_match('/[^a-z_\-0-9\s]/i', $_POST['thrive-sidebar-name'] ))
		{
			wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&sidebar-error=true&type=c' ) );
			die();
		}
		
		$sidebar_name = esc_attr( stripslashes( $_POST['thrive-sidebar-name'] ) );
		$sidebar_id = sanitize_title( $_POST['thrive-sidebar-name'] );
		$value = array(
				$sidebar_id => array(
						'thrive-sidebar-name' => $sidebar_name,
						'thrive-sidebar-id' => $sidebar_id,
						'thrive-sidebar-description' => esc_attr( $_POST['thrive-sidebar-description'] )
					)
				);
			
		// check if there are no sidebars	
		if( empty( $current_sidebars ) ){
			// update the option
			update_option(  $option_key, serialize( $value ) );
			wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&sidebar-success=true' ) );
		}else{
			// if option is already set, it means there are existing sidebars
			// then, get all the sidebars first
			$existing_sidebars = unserialize( get_option( $option_key ) );
			
			// check if the same sidebar already exists
			if( array_key_exists( $sidebar_id , $existing_sidebars ) ){
				wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&sidebar-error=true&type=u' ) );
			}else{
				// add new sidebar :)
				$existing_sidebars[$sidebar_id] = array(
						'thrive-sidebar-name' => $sidebar_name,
						'thrive-sidebar-id' => $sidebar_id,
						'thrive-sidebar-description' => esc_attr( $_POST['thrive-sidebar-description'] )
					);				
				// update the option after appending our new 
				// sidebar to existing one				
				update_option(  $option_key, serialize( $existing_sidebars ) );
				wp_safe_redirect( admin_url( 'themes.php?page='.THRIVE_SIDEBAR_UNIQUE_ID.'&sidebar-success=true' ) );
			}
			
		}
	}
	die();
}
?>
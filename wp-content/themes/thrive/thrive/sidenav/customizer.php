<?php
/**
 * This file handles the option for changing things
 * under Side Navigation options
 *
 * @since 1.5.0
 */
$wp_customize->add_section( 'thrive_sidenav',
	array(
		'title' => __( 'Side Navigation', 'thrive' ),
		'description' => __( 'Side Navigation are useful for retaining user 	permalink links. Side Navigation (SideNav) is only available for 2 columns layout.', 'thrive' ),
		'priority' => 22,
		'capability' => 'edit_theme_options',
	)
);

// Side Navigation Enable or Disable Widgets.
$wp_customize->add_setting(
	$setting_id = 'thrive_sidenav_is_widget_enabled_on_logged_out',
	array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'manage_options',
		'default' => 1,
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( 'thrive_sidenav_is_widget_enabled_on_logged_out',
	array(
		'type' => 'checkbox',
		'label' => __("Public 'Sidenav Widgets'", 'thrive'),
		'section' => 'thrive_sidenav',
		'description' => __('Check to make the left sidebar widgets accesible to public.', 'thrive')
	)
);

// Side Navigation Logout Text.
$wp_customize->add_setting( $setting_id = 'thrive_sidenav_logout_text',
	array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'manage_options',
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( 'thrive_sidenav_logout_text',
	array(
		'label' => __( 'Log Out Message', 'thrive' ),
		'type' => 'textarea',
		'section' => 'thrive_sidenav',
		'description' => __('Use the Textarea below to write your side navigation message when the user is logged out.', 'thrive')
	)
);

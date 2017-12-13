<?php
/**
 * This file handles the option for changing things
 * under Side Navigation options
 *
 * @since 1.5.0
 */
// Register 'Register Page' Section.
$wp_customize->add_section( 'thrive_register', array(
	'title' => __( 'Register Page', 'thrive' ),
	'description' => __( 'Use this section to customize your register page. After saving, log-out and visit your register page to see the changes. Make sure to disable the registration option inside the site settings.', 'thrive' ),
	'priority' => 37,
	'capability' => 'edit_theme_options',
));

// Disable Site Header.
$wp_customize->add_setting( $setting_id = 'thrive_register_disable_header', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => 0,
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( 'thrive_register_disable_header', array(
	'type' => 'checkbox',
	'label' => __("Disable Page Header", 'thrive'),
	'section' => 'thrive_register',
	'description' => __('Check to disable site header in the register page.', 'thrive')
));

// Disable Site Footer.
$wp_customize->add_setting( $setting_id = 'thrive_register_disable_footer', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => 0,
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( 'thrive_register_disable_footer', array(
	'type' => 'checkbox',
	'label' => __("Disable Page Footer", 'thrive'),
	'section' => 'thrive_register',
	'description' => __('Check to disable site footer in the register page.', 'thrive')
));

// Enable Site Logo.
$wp_customize->add_setting( $setting_id = 'thrive_register_enable_logo', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => 0,
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( 'thrive_register_enable_logo', array(
	'type' => 'checkbox',
	'label' => __("Enable Site Logo", 'thrive'),
	'section' => 'thrive_register',
	'description' => __('Check to enable site logo in the register form. Useful if you want to hide the site header.', 'thrive')
));

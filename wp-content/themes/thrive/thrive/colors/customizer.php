<?php
/**
 * This file handles the code for registering our
 * general color options inside WordPress Customizer
 *
 * @since 1.0.8
 */

$wp_customize->add_section( 'thrive_general_colors_customize', array(
	'title' => __( 'General Colors', 'thrive' ),
	'description' => __( 'Select the desired general color combination for your website.', 'thrive' ),
	'priority' => 40,
	'capability' => 'edit_theme_options',
));

// Enable dark navigation
$wp_customize->add_setting( $setting_id = 'thrive_dark_menu', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( 'thrive_dark_menu', array(
	'type' => 'checkbox',
	'label' => __('Dark Side Menu', 'thrive'),
	'section' => 'thrive_general_colors_customize',
	'description' => __('This option applies for 2 columns layout side menu background color', 'thrive')
));

// Overall primary colors.
$wp_customize->add_setting( $setting_id = 'thrive_primary_color', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '#03A9F4',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_primary_color', array(
	'label' => __( 'Primary Colors', 'thrive' ),
	'section' => 'thrive_general_colors_customize',
	'settings' => 'thrive_primary_color',
	'description' => __('Select a primary color for your website. This settings will be automatically overwritten if you change the colors inside individual components, for example, "Branding", "Menu", etc. ', 'thrive')
)));

// Overall primary colors (shade).
$wp_customize->add_setting( $setting_id = 'thrive_primary_color_shade', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '#0288D1',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_primary_color_shade', array(
	'label' => __( 'Primary Colors Shade', 'thrive' ),
	'section' => 'thrive_general_colors_customize',
	'settings' => 'thrive_primary_color_shade',
	'description' => __('Select a shade for your primary color. This settings will be automatically overwritten if you change the colors inside individual components, for example, "Branding", "Menu", etc. ', 'thrive')
)));


// Overall secondary colors.
$wp_customize->add_setting( $setting_id = 'thrive_secondary_color', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '#FF4081',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_secondary_color', array(
	'label' => __( 'Secondary Colors', 'thrive' ),
	'section' => 'thrive_general_colors_customize',
	'settings' => 'thrive_secondary_color',
	'description' => __('Select a secondary color. This settings will be automatically overwritten if you change the colors inside individual components, for example, "Branding", "Menu", etc. ', 'thrive')
)));
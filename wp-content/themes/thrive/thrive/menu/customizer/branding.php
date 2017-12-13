<?php
/**
 * Thrive/Menu/Customizer/Branding
 *
 * @package Thrive
 * @since 1.0
 */

$panel = 'thrive_branding_menu';

$wp_customize->add_section($section_id = 'thrive_branding', array(
	'title' => __( 'Branding', 'thrive' ),
	'panel' => $panel,
	'description' => '<em>' . __( 'This section handles the all default settings for your Branding. Change it to your preference.', 'thrive' ) . '</em>', // Include html tags such as <p>.
	'priority' => 30, // Mixed with top-level-section hierarchy.
));

/**
 * Branding Height
 */
$wp_customize->add_setting($setting_id = 'thrive_branding_height', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => 100,
	'transport' => 'postMessage',
	'sanitize_callback' => 'thrive_handle_empty_var',
));

$wp_customize->add_control('thrive_branding_height', array(
	'type' => 'range',
	'section' => 'thrive_branding',
	'label' => __( 'Branding Height', 'thrive' ),
	'description' => __( 'Use the slider below to adjust the height of the the Header Section.', 'thrive' ),
	'default' => 100,
	'input_attrs' => array(
		'min' => 100,
		'max' => 175,
		'step' => 1,
	),
));

/**
 * Logo Background.
 */
$wp_customize->add_setting($setting_id = 'thrive_logo_background', array(
	'type' => 'theme_mod',
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_logo_background_control', array(
	'label' => __( 'Logo Background', 'thrive' ),
	'section' => 'thrive_branding',
	'settings' => 'thrive_logo_background',
)));

/**
 * Branding Accent Settings.
 */
$wp_customize->add_setting($setting_id = 'thrive_header_menu_background', array(
	'type' => 'theme_mod',
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_branding_accent_control', array(
	'label' => __( 'Menu Background', 'thrive' ),
	'section' => 'thrive_branding',
	'settings' => 'thrive_header_menu_background',
)));

/**
 * Logo Settings & Controls.
 */
$default_logo = get_template_directory_uri() . '/logo.png';

$wp_customize->add_setting($setting_id = 'thrive_logo', array(
	'type' => 'theme_mod',
	'capability' => 'manage_options',
	'default' => esc_url( $default_logo ),
	'transport' => 'refresh',
	'sanitize_callback' => 'esc_url',
));

$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'thrive_logo_control',
	array(
			'label'      => __( 'Upload a logo', 'thrive' ),
			'section'    => 'thrive_branding',
			'settings'   => 'thrive_logo',
	 )
));

/**
 * Logo Mobile
 */
$default_logo_mobile = get_template_directory_uri() . '/logo-mobile.png';

$wp_customize->add_setting($setting_id = 'thrive_logo_mobile', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => esc_url( $default_logo_mobile ),
	'transport' => 'refresh',
	'sanitize_callback' => 'esc_url',
));

$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'thrive_logo_mobile_control',
	array(
		'label'      => __( 'Mobile Logo', 'thrive' ),
		'section'    => 'thrive_branding',
		'settings'   => 'thrive_logo_mobile',
	 )
));

/*
 * Favicon Settings & Controls. Favicon functionality is deprecated in favor of new WordPress native favicon.
if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

	$default_favicon = get_template_directory_uri() . '/favicon.ico';

	$wp_customize->add_setting($setting_id = 'thrive_favicon', array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'manage_options',
		'default' => esc_url( $default_favicon ),
		'transport' => 'refresh',
		'sanitize_callback' => 'esc_url',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'thrive_favicon_control',
		array(
	   		'label'      => __( 'Upload a Favicon', 'thrive' ),
	  		'section'    => 'thrive_branding',
			'settings'   => 'thrive_favicon',
		 )
	));

}
 */
?>

<?php
$wp_customize->add_section( 'thrive_layouts_customize_section', array(
	'title' => __( 'General Layout', 'thrive' ),
	'description' => __( 'Select the desired layout for your website.', 'thrive' ),
	'priority' => 20,
	'capability' => 'edit_theme_options',
));

// Overall layouts settings.
$wp_customize->add_setting( $setting_id = 'thrive_layouts_customize', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control( 'thrive_layouts_customize', array(
	'type' => 'radio',
	'label' => __('Select Layout:', 'thrive'),
	'section' => 'thrive_layouts_customize_section',
	'choices' => array(
			'2_columns' => '2 Columns Left (Default)',
			'1_column' => 'Full Page Layout',
		),
));

// RTL Settings
$wp_customize->add_setting( $setting_id = 'thrive_layouts_rtl', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control( 'thrive_layouts_rtl', array(
	'type' => 'radio',
	'label' => __('Direction:', 'thrive'),
	'section' => 'thrive_layouts_customize_section',
	'choices' => array(
			'no' => 'Left to Right (Default)',
			'yes' => 'Right to Left (RTL Mode)',
		),
));
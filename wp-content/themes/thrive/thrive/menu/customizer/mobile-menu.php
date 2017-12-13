<?php
$panel = 'thrive_branding_menu';

$wp_customize->add_section($section_id = 'thrive_mobile_menu', array(
    'title' => __('Mobile Menu', 'thrive'),
    'panel' => $panel,
    'description' => '<em>' . __('This section handles the all default settings for your website mobile menu. Choose the best colors that suites your company and personality.', 'thrive') . '</em>', 
    'priority' => 30, // Mixed with top-level-section hierarchy.
));

/**
 * Mobile Button
 */
$wp_customize->add_setting($setting_id = 'thrive_mobile_menu_button_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_mobile_menu_button_color', array(
    'label' => __('Button Color', 'thrive'),
    'section' => 'thrive_mobile_menu',
    'settings' => 'thrive_mobile_menu_button_color',
)));

/**
 * Mobile Default State Color
 */
$wp_customize->add_setting($setting_id = 'thrive_mobile_menu_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_mobile_menu_color', array(
    'label' => __('Default State', 'thrive'),
    'section' => 'thrive_mobile_menu',
    'settings' => 'thrive_mobile_menu_color',
)));
/**
 * Mobile Hover & Active Color
 */
$wp_customize->add_setting($setting_id = 'thrive_mobile_menu_hover_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_mobile_menu_hover_color', array(
    'label' => __('Hover & Active State', 'thrive'),
    'section' => 'thrive_mobile_menu',
    'settings' => 'thrive_mobile_menu_hover_color',
)));
/**
 * Mobile Hover & Active Background
 */
$wp_customize->add_setting($setting_id = 'thrive_mobile_menu_hover_background', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_mobile_menu_hover_background', array(
    'label' => __('Hover & Active Background', 'thrive'),
    'section' => 'thrive_mobile_menu',
    'settings' => 'thrive_mobile_menu_hover_background',
)));
/**
 * Mobile Background
 */
$wp_customize->add_setting($setting_id = 'thrive_mobile_background', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_mobile_background', array(
    'label' => __('Mobile Background', 'thrive'),
    'section' => 'thrive_mobile_menu',
    'settings' => 'thrive_mobile_background',
)));
?>
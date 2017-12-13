<?php
$panel = 'thrive_branding_menu';

$wp_customize->add_section($section_id = 'thrive_submenu', array(
    'title' => __('Sub Menu', 'thrive'),
    'panel' => $panel,
    'description' => '<em>' . __('This section handles the all default settings for your website submenu menu. Choose the best colors that suites your company and personality.', 'thrive') . '</em>', 
    'priority' => 30, // Mixed with top-level-section hierarchy.
));

/**
 * Sub Menu Default State Color
 */
$wp_customize->add_setting($setting_id = 'thrive_submenu_color_default', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_submenu_color_default', array(
    'label' => __('Default State', 'thrive'),
    'section' => 'thrive_submenu',
    'settings' => 'thrive_submenu_color_default',
)));
/**
 * Sub Menu Active & Hover State
 */
$wp_customize->add_setting($setting_id = 'thrive_submenu_color_active', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_submenu_color_active', array(
    'label' => __('Hover & Active State', 'thrive'),
    'section' => 'thrive_submenu',
    'settings' => 'thrive_submenu_color_active',
)));

/**
 * Sub Menu Active & Hover State
 */
$wp_customize->add_setting($setting_id = 'thrive_submenu_background_active', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_submenu_background_active', array(
    'label' => __('Hover & Active State Background', 'thrive'),
    'section' => 'thrive_submenu',
    'settings' => 'thrive_submenu_background_active',
)));
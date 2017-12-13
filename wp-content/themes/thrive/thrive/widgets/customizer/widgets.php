<?php
/**
 * @Widgets Specification
 * Background: $light
 * Foreground: $dark
 * Links: $primary
 * Links Hover: $primary_700
 */

$wp_customize->add_section($section_id = 'thrive_sidebar_widgets', array(
    'title' => __('Sidebar Widgets', 'thrive'),
    'description' => '<em>' . __('You can change the appearance of your sidebar widgets here', 'thrive') . '</em>', // Include html tags such as <p>.
    'priority' => 37, // Mixed with top-level-section hierarchy.
));

/**
 * Widgets Outline Option
 */
$wp_customize->add_setting($setting_id = 'thrive_widgets_outline', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => 'shadowed',
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control('thrive_widgets_outline', array(
    'label' => __('Widgets Outline', 'thrive'),
    'type' => 'radio',
    'section' => 'thrive_sidebar_widgets',
    'choices' => array(
            'shadowed' => __('Shadowed', 'thrive'),
            'solid-border' => __('Solid Border', 'thrive'),
            'no-outline' => __('No Outline', 'thrive'),
        )
));

/**
 * Widgets Background Color
 */
$background = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_sidebar_widgets_background', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $background,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'thrive_sidebar_widgets_background_control', array(
    'label' => __('Background', 'thrive'),
    'section' => 'thrive_sidebar_widgets',
    'settings' => 'thrive_sidebar_widgets_background',
)));

/**
 * Widgets Color
 */
$colors = '#000000';
$wp_customize->add_setting($setting_id = 'thrive_sidebar_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $colors,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'thrive_sidebar_color_control', array(
    'label' => __('Color', 'thrive'),
    'section' => 'thrive_sidebar_widgets',
    'settings' => 'thrive_sidebar_color',
)));

/**
 * Links Color
 */
$links_color = '#03A9F4';
$wp_customize->add_setting($setting_id = 'thrive_sidebar_links_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $links_color,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'thrive_sidebar_links_color_control', array(
    'label' => __('Links', 'thrive'),
    'section' => 'thrive_sidebar_widgets',
    'settings' => 'thrive_sidebar_links_color',
)));

/**
 * Links:hover Color
 */
$links_color = '#0288D1';
$wp_customize->add_setting($setting_id = 'thrive_sidebar_links_color__hover', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $links_color,
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'thrive_sidebar_links_color__hover_control', array(
    'label' => __('Links Hover', 'thrive'),
    'section' => 'thrive_sidebar_widgets',
    'settings' => 'thrive_sidebar_links_color__hover',
)));
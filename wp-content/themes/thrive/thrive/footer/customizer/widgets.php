<?php
/**
 * @Footer Widgets Specification
 * Background: $primary
 * Foreground: $light
 * Links: $light_secondary
 * Links Hover: $light:underline
 */
$wp_customize->add_section($section_id = 'thrive_footer_widgets', array(
    'title' => __('Widgets', 'thrive'),
    'panel' => 'thrive_footer_menu',
    'description' => '<em>' . __('Configure the widgets that are shown in the footer section of your website', 'thrive') . '</em>', // Include html tags such as <p>.
    'priority' => 35, // Mixed with top-level-section hierarchy.
));

/**
 * @FooterWidget Columns
 */
$wp_customize->add_setting($setting_id = 'thrive_footer_widget_columns', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '4-columns',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control('thrive_footer_widget_columns', array(
    'label' => __('Columns', 'thrive'),
    'type' => 'radio',
    'section' => 'thrive_footer_widgets',
    'choices' => array(
            '1-columns' => __('1 Column', 'thrive'),
            '2-columns' => __('2 Columns', 'thrive'),
            '3-columns' => __('3 Columns', 'thrive'),
            '4-columns' => __('4 Columns', 'thrive'),
        )
));

/**
 * @FooterWidget Spec
 * Foreground
 */
$widget_color = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_footer_widget_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $widget_color,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_widget_footer_color_control', array(
    'label' => __('Color', 'thrive'),
    'section' => 'thrive_footer_widgets',
    'settings' => 'thrive_footer_widget_color',
)));

/**
 * @FooterWidget Spec
 * Background
 */
$widget_background = '#03A9F4';
$wp_customize->add_setting($setting_id = 'thrive_footer_widget_background', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $widget_background,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_widget_background_control', array(
    'label' => __('Background', 'thrive'),
    'section' => 'thrive_footer_widgets',
    'settings' => 'thrive_footer_widget_background',
)));

/**
 * @FooterWidget Spec
 * Footer Links
 */
$widget_color_link = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_footer_widget_color_link', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $widget_color_link,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_widget_footer_color_link_control', array(
    'label' => __('Links', 'thrive'),
    'section' => 'thrive_footer_widgets',
    'settings' => 'thrive_footer_widget_color_link',
)));

/**
 * @FooterWidget Spec
 * Footer Links Hover
 */
$widget_color_on_hover = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_footer_widget_color_hover', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $widget_color_on_hover,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_color_hover_control', array(
    'label' => __('Links Hover State', 'thrive'),
    'section' => 'thrive_footer_widgets',
    'settings' => 'thrive_footer_widget_color_hover',
)));

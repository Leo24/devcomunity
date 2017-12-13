<?php
$panel = 'thrive_branding_menu';

$wp_customize->add_section($section_id = 'thrive_menu', array(
    'title' => __('Menu', 'thrive'),
    'panel' => $panel,
    'description' => '<em>' . __('This section handles the all default settings for your website menu. Choose the best colors that suites your company and personality.', 'thrive') . '</em>', // Include html tags such as <p>.
    'priority' => 30, // Mixed with top-level-section hierarchy.
));

/**
 * Menu Default State Color
 */
$wp_customize->add_setting($setting_id = 'thrive_menu_color_default', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_menu_color_default_control', array(
    'label' => __('Default State', 'thrive'),
    'section' => 'thrive_menu',
    'settings' => 'thrive_menu_color_default',
)));

/**
 * Active & Hover State
 */
$wp_customize->add_setting($setting_id = 'thrive_menu_color_active', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_menu_color_active_control', array(
    'label' => __('Active & Hover State', 'thrive'),
    'section' => 'thrive_menu',
    'settings' => 'thrive_menu_color_active',
)));

/**
 * Top Right Bar
 */
$wp_customize->add_setting($setting_id = 'thrive_top_right_bar', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));

$wp_customize->add_control( 'thrive_top_right_bar', array(
  'type' => 'radio',
  'priority' => 10, // Within the section.
  'section' => 'thrive_menu', // Required, core or custom.
  'label' => __( 'Top Right Menu', 'thrive' ),
  'default' => 'bp-menu',
  'description' => __( 'Choose which kind of menu you would like to display in the top right bar.', 'thrive' ),
  'choices' => array(
      'bp-menu' => __('Automatically fetch BuddyPress generated profile menu for me. (BuddyPress plugin required)', 'thrive'),
      'wp-menu' => __('I would like to use the theme "Top Right Bar" menu.', 'thrive')
  )
));
?>

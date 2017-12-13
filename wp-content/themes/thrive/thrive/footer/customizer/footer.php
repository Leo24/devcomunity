<?php
/**
  * @Footer Specification
  * Background: $dark
  * Foreground: $light_secondary
  * Links: $light_secondary:underline
  * Links Hover: $light
  */

$wp_customize->add_section($section_id = 'thrive_footer', array(
    'title' => __('Copyright', 'thrive'),
    'panel' => 'thrive_footer_menu',
    'description' => '<em>' . __('This section handles the all default settings for your footer. Choose the best colors that suites your company and personality.', 'thrive') . '</em>', // Include html tags such as <p>.
    'priority' => 35, // Mixed with top-level-section hierarchy.
));

/**
 * @Footer Spec
 * Foreground
 */
$default_footer_color = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_footer_color', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $default_footer_color,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_color_control', array(
    'label' => __('Default State', 'thrive'),
    'section' => 'thrive_footer',
    'settings' => 'thrive_footer_color',
)));

/**
 * @Footer Spec
 * Background
 */
$default_footer_background = '#000000';
$wp_customize->add_setting($setting_id = 'thrive_footer_background', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $default_footer_background,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_background_control', array(
    'label' => __('Background', 'thrive'),
    'section' => 'thrive_footer',
    'settings' => 'thrive_footer_background',
)));

/**
 * @Footer Spec
 * Links
 */
$default_footer_links = '#fff';
$wp_customize->add_setting($setting_id = 'thrive_footer_links', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $default_footer_links,
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_links_control', array(
    'label' => __('Links', 'thrive'),
    'section' => 'thrive_footer',
    'settings' => 'thrive_footer_links',
)));

/**
 * @Footer Spec
 * Links:Hover
 */
$default_links_hover = '#ffffff';
$wp_customize->add_setting($setting_id = 'thrive_footer_links_hover', array(
    'type' => 'theme_mod', // or 'option'
    'capability' => 'manage_options',
    'default' => $default_links_hover,
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_attr'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'thrive_footer_links_hover_control', array(
    'label' => __('Links Hover State', 'thrive'),
    'section' => 'thrive_footer',
    'settings' => 'thrive_footer_links_hover',
)));


/**
 * Footer Copyright
 */
$default_copy_text = __( '&copy; [Your Website Name Here] 2015. All Rights Reserved.', 'thrive');

$wp_customize->add_setting(
    $setting_id = 'thrive_footer_copyright', array(
        'type' => 'option', // or 'option'
        'capability' => 'manage_options',
        'default' => $default_copy_text,
        'transport' => 'postMessage',
        'sanitize_callback' => 'thrive_handle_empty_var'
    )
);

$wp_customize->add_control( 'thrive_footer_copyright',
    array(
        'label' => __('Copyright Text', 'thrive'),
        'section' => 'thrive_footer',
        'type' => 'textarea',
        'description' => __('Enter the copyright text that can be found in your site\'s footer. You can also add html tags.', 'thrive')
    )
);
?>

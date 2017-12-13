<?php
/**
 * Font Options
 *
 * @since 1.0.7
 */


/**
 * -------------
 * Heading Fonts.
 * -------------
 */

// Load the file that implements 'thrive_get_google_fonts' function.
require_once get_template_directory() . '/thrive/typography/customizer/font-library.php';

$font_collection = thrive_get_google_fonts();

$section = 'thrive_typography_section';

$wp_customize->add_section(

    $section_id = $section,

    array(
        'title' => __('Fonts', 'thrive'),
        'panel' => 'thrive_typography',
        'description' => '<em>' . __('Select desired font combination for your website.
                        Hundreds of fonts are available to choose from.', 'thrive') . '</em>',
        'priority' => 35,
    )

);


$wp_customize->add_setting(

    $setting_id = 'thrive_typography_header',

    array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'manage_options',
        'default' => $this->defaultHeaderFont,
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_attr'
    )
);

$wp_customize->add_control(

    'thrive_typography_header',

    array(
        'label' => __('Headings Font', 'thrive'),
        'type' => 'select',
        'description' => __('Select the desired font to be applied in the headings of the theme.', 'thrive'),
        'section' => $section,
        'choices' => $font_collection
    )

);

/**
 * -------------
 * Body Fonts.
 * -------------
 */

$wp_customize->add_setting(

    $setting_id = 'thrive_typography_body',

    array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'manage_options',
        'default' => $this->defaultBodyFont,
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_attr'
    )
);

$wp_customize->add_control(

    'thrive_typography_body',

    array(
        'label' => __('Body Font', 'thrive'),
        'type' => 'select',
        'description' => __('Use this option to select a general font for the content of the theme.', 'thrive'),
        'section' => $section,
        'choices' => $font_collection
    )

);

/**
 * -------------
 * Font Size.
 * -------------
 */

$wp_customize->add_setting(

    $setting_id = 'thrive_typography_font_size',

    array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'manage_options',
        'default' => 14,
        'sanitize_callback' => 'esc_attr'
    )
);

$wp_customize->add_control(

    'thrive_typography_font_size',

    array(
        'label' => __('Font Point', 'thrive'),
        'description' => __('Controls the overall size of the text. Minimum recommended input is "12" and the maximum recommended input is "22". Set the value to "14" in order to reset the size.', 'thrive'),
        'type' => 'number',
        'section' => $section,
        'input_attrs' => array(
                'min' => 14,
                'max' => 22
            ),
    )

);
?>

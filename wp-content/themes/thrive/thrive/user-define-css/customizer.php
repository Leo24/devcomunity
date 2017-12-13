<?php
/**
 * This file handles the code for registering our
 * general user define css inside WordPress Customizer
 *
 * @since 1.0.8
 */

$wp_customize->add_section( 'thrive_user_define_css_customize', array(
	'title' => __( 'Custom CSS', 'thrive' ),
	'priority' => 40,
	'capability' => 'edit_theme_options',
));

$wp_customize->add_setting( $setting_id = 'thrive_user_define_css', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'manage_options',
	'default' => '',
	'transport' => 'postMessage',
	'sanitize_callback' => 'esc_attr',
));

$wp_customize->add_control('thrive_user_define_css', array(
  'label' => __( 'Custom Theme CSS', 'thrive' ),
  'type' => 'textarea',
  'section' => 'thrive_user_define_css_customize',
) );
<?php
/**
 * The header for our register page.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package thrive
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php  if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>

    <link rel="icon" href="<?php echo esc_url( thrive_favicon_url() ); ?>" type="image/x-icon" />

	<link rel="shortcut icon" href="<?php echo esc_url( thrive_favicon_url() ); ?>" type="image/x-icon" />

<?php } ?>
 
<?php wp_head(); ?>

</head>

<body <?php body_class( array('thrive-inline') ); ?>>

<div id="thrive-global-wrapper-register">

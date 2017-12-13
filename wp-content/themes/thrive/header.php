<?php
/**
 * The header for our theme.
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

<div id="thrive-global-wrapper" class="active">

<?php $layout = thrive_customizer_radio_mod('thrive_layouts_customize', '2_columns'); ?>

<?php if ( "2_columns" === $layout ) { ?>

	<?php $is_dark_layout = get_theme_mod( 'thrive_dark_menu', '' ); ?>

	<?php $class = ""; ?>

	<?php if ( !empty( $is_dark_layout ) ) { ?>

		<?php $class = "dark"; ?>

	<?php } ?>

	<div id="sidebar-wrapper" class="<?php echo esc_attr( $class ); ?>">

		<div id="page-sidenav" class="<?php echo thrive_layout_class('sidenav'); ?>">

				<div id="page-sidenav-section">

					<?php get_template_part( 'template-parts/sidebar', 'heading' ); ?>

					<?php get_template_part( 'template-parts/sidebar', 'content' ); ?>

				</div>

		</div>

		<div id="page-sidebar-toggle">

			<div id="toggle-container">

				<a id="toggle-remove" title="<?php _e('Toggle Sidebar', 'thrive'); ?>" href="#">
					<span class="span-toggle">
						<i class="material-icons md-24">remove_circle_outline</i>
					</span>
					<span class="clearfix"></span>
				</a>

			</div>

		</div>

	</div>

<?php } ?>

<div id="thrive-site-container" class="hfeed site">

	<?php if ( "2_columns" === $layout ) { ?>
		<a id="toggle-add" title="<?php _e('Toggle Sidebar', 'thrive'); ?>" href="#">
			<span class="span-toggle">
				<i class="material-icons md-24">add_circle_outline</i>
			</span>
			<span class="clearfix"></span>
		</a>
	<?php } ?>

		<div class="container-fluid" id="page-container">

			<div class="row" id="page-row">

				<div id="page" class="<?php echo thrive_layout_class('content'); ?>">

					<a class="skip-link screen-reader-text" href="#content">

						<?php esc_html_e( 'Skip to content', 'thrive' ); ?>

					</a>

					<header id="masthead" class="site-header" role="banner">

						<?php thrive_nav(); ?>

					</header><!-- #masthead -->

					<div id="thrive-secondary-menu" class="hide">

						<div class="container-fluid">

							<div class="row">

									<div id="thrive-secondary-menu-search" class="col-xs-10">

										<?php get_search_form(); ?>

									</div>

									<div class="mobile-secondary-menu-search col-xs-2 visible-sm visible-xs">

										<div id="mobile-search-menu">
                                            <a id="thrive-mobile-search-btn" href="#" alt="<?php _e("Search", "thrive"); ?>">
                                                <i class="material-icons">search</i>
                                            </a>
                                        </div>

										<div id="mobile-menu">
											<a href="#" title="<?php _e('Show Menu', 'thrive'); ?>">
												<i id="main-menu-mobile-search" class="material-icons">menu</i>
											</a>
										</div>
									</div>

							</div>

						</div>

					</div>

				<div id="content" class="site-content thrive-container">
				<?php // remove fluid on canvas template ?>
				<?php if ( ! is_page_template('page-templates/canvas.php') ) { ?>
					<div class="container-fluid">
				<?php } ?>
						<div class="row limiter">
							<?php do_action( 'thrive_before_content' ); ?>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package thrive
 */

$layout = thrive_get_layout();

$disable_header = get_theme_mod('thrive_register_disable_header', false);
$disable_footer = get_theme_mod('thrive_register_disable_footer', false);
$enable_logo    = get_theme_mod('thrive_register_enable_logo', false);

if ( ! $disable_header ) {
	get_header();
} else {
	get_header('buddypress-register');
}
?>

<?php do_action( 'thrive_before_page_content' ); ?>

<div id="minimal-register" class="buddypress ">

	<div id="minimal-registration-container">

		<div id="primary" class="content-area thrive-page-document">

			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( $enable_logo ) { ?>

						<div class="bg-primary" id="thrive-registration-logo">

							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

								<?php $default_logo = get_template_directory_uri() . '/logo.png'; ?>

								<?php $logo_url = get_theme_mod('thrive_logo', esc_url($default_logo)); ?>

								<img class="site-logo" id="site-md-logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo( 'title' ); ?>" />

							</a>

						</div>

						<div id="thrive-social-connect">
							<?php do_action( 'gears_login_form' ); ?>
						</div>

					<?php } else { ?>

						<div class="non-logo" id="thrive-social-connect">
							<?php do_action( 'gears_login_form' ); ?>
						</div>

					<?php } ?>

					<?php the_content(); ?>

				<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content-container -->
</div>
<?php
if ( ! $disable_footer ) {
	get_footer();
} else {
	get_footer('buddypress-register');
}
?>

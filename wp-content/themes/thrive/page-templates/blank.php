<?php
/**
 * Template Name: Blank
 */
?>
<!DOCTYPE html>
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
<?php
if( have_posts() ){
	while( have_posts() ){
		the_post();
		// using the WordPress loop, we'll display the post content here
		// inorder for page builder to work, you need the page builder's shortcode
		// right into the textarea wherein you compose your blog
		?>
		
		<?php do_action( 'thrive_before_page_content' ); ?>

		<div class="row">
			<div id="blank-template-content" class="col-md-12">

				<div id="primary" class="content-area thrive-page-document">
					<main id="main" class="site-main" role="main">
						<?php the_content(); ?>
					</main>
				</div>

				<div id="dashboard-widgets"></div>

			</div>
		</div>

		<?php
	}
}

wp_footer(); ?>
</body>
</html>
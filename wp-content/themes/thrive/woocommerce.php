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

get_header(); ?>

<?php do_action( 'thrive_before_page_content' ); ?>

<?php $layout = thrive_get_layout(); ?>

<div class="row <?php echo esc_attr( $layout['layout'] ); ?>">
	<div id="content-left-col" class="col-md-8 <?php echo esc_attr( $layout['content'] ); ?>">
		<div id="primary" class="dunhakdis-card content-area thrive-page-document">
			<main id="main" class="site-main" role="main">
				<article class="hentry">
					<?php woocommerce_content(); ?>
				</article>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--.col-md-8-->

	<div id="content-right-col" class="col-md-4 <?php echo esc_attr( $layout['sidebar'] ); ?>">

		<?php get_sidebar(); ?>

	</div><!--.col-md-4-->
</div>	 
<?php get_footer(); ?>

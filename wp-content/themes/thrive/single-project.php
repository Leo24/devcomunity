<?php
/**
 * The template for displaying all single projects.
 *
 * @package thrive
 */

get_header(); ?>
<?php do_action( 'thrive_before_page_content' ); ?>
	<div id="content-left-col" class="col-md-8">
		<div id="primary" class="content-area thrive-page-document">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>


				<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--.col-md-8-->
	<div id="content-right-col" class="col-md-4">
		<?php get_sidebar(); ?>
	</div><!--.col-md-4-->
<?php get_footer(); ?>

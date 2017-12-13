<?php
/**
 * The template for displaying all single posts.
 *
 * @package thrive
 */

get_header(); ?>

<?php $layout = thrive_get_layout(); ?>

<div class="<?php echo esc_attr( $layout['layout'] ); ?>">

	<div id="content-left-col" class="<?php echo esc_attr( $layout['content'] ); ?>">

		<div id="primary" class="content-area">
		
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php the_post_navigation(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-8-->
	<div id="content-right-col" class="<?php echo esc_attr( $layout['sidebar'] ); ?>">	
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>

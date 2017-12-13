<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package thrive
 */

get_header(); ?>
<div id="archive-section">
	<div class="col-md-8" id="content-left-col">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>
				<?php 
					$archive_allowed_tags = array(
					    'a' => array(
					        'href' => array(),
					        'title' => array()
					    ),
					    'span' => array(
					    	'class' => array()
					    )
					);
				?>

				<header class="page-header thrive-card no-mg-top">
					<?php
						$archive_title = get_the_archive_title( '<h1 class="page-title">', '</h1>' );
					?>
					<?php if ( empty ( $archive_title ) ) { ?>

						<h1 class="page-title">

							<i class="material-icons md-24 md-dark">archive</i><?php _e( 'Archives', 'thrive' ); ?>

						</h1>

					<?php } else { ?>

						<?php echo wp_kses( $archive_title, $archive_allowed_tags ); ?>

					<?php } ?>

					<?php echo get_the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-8-->

<div class="col-md-4" id="content-right-col">	
	<?php get_sidebar(); ?>
</div>
</div><!--#archive-section-->
<?php get_footer(); ?>

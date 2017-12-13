<?php
/**
 * The template for displaying search results pages.
 *
 * @package thrive
 */

get_header(); ?>
<div class="row limiter">
	<div id="content-left-col" class="col-md-8">
		<section id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="search-page-header thrive-card mg-bottom-35">

					
					<div class="clearfix">
						<div class="pull-left">
							<span class="material-icons md-24 md-dark">youtube_searched_for</span>
						</div>
						<div class="pull-left">
							<h5 class="dark_secondary_icon">
								<?php _e('Search Results', 'thrive'); ?>
							</h5>
						</div>
					</div>
					
					<h1 class="page-title">
						<?php echo get_search_query(); ?>
					</h1>
				
					<div id="search-page-search-form">
						<?php echo get_search_form(); ?>
					</div>

				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );
					?>

				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!--.col-md-8-->
	<div class="col-md-4">
		<?php get_sidebar(); ?>
	</div>
</div>	
<?php get_footer(); ?>

<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package thrive
 */

get_header(); ?>
	<div id="content-left-col" class="col-md-8">
		<div id="primary" class="content-area thrive-page-document">
			<main id="main" class="site-main" role="main">

				<article class="error-404 not-found content-area hentry">
					<header class="404-page-header">
						<h1 class="page-title"><?php esc_html_e( '404 - Oops! That page can&rsquo;t be found.', 'thrive' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'thrive' ); ?></p>
						<?php echo get_search_form(); ?>
					</div><!-- .page-content -->
				</article><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div>

	<div id="content-right-col" class="col-md-4">
		<?php get_sidebar(); ?>
	</div><!--col-md-4-->

<?php get_footer(); ?>

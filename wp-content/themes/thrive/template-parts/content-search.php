<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package thrive
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('thrive-list', 'mg-bottom-15', 'thrive-archives')); ?>>

	<header class="entry-header">
		<div class="entry-meta mg-bottom-10">
			<?php thrive_posted_on(); ?>
		</div><!-- .entry-meta -->
		
		<div class="row mg-bottom-10">
			<div class="col-xs-1 no-pd-right">
				<span class="material-icons md-24 md-dark">link</span>
			</div>
			<div class="col-xs-11 no-pd-left">
				<?php the_title( sprintf( '<h1 class="h3 search-entry-title"><a class="dark_secondary_icon" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			</div>
		</div>
		
	</header><!-- .entry-header -->

	<?php if ( 'post' == get_post_type() ) : ?>
		<footer class="entry-footer">
			<?php thrive_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->


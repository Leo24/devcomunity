<?php
/**
 * Template part for displaying single posts.
 *
 * @package thrive
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if (has_post_thumbnail()) { ?>
	
	<header class="entry-header has-post-thumbnail mg-bottom-25">

		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>

		<div class="entry-meta hidden-xs">
			<?php thrive_posted_on(); ?>
			<div class="hidden-xs">
				<?php the_title( '<h1 class="entry-title type-light">', '</h1>' ); ?>
			</div>
		</div><!-- .entry-meta -->

		<div class="entry-actions">
			<a href="<?php comments_link(); ?>" title="<?php _e('Comments', 'thrive'); ?>">
				<span class="material-icons md-24 md-light">
					comment
				</span>
				<span class="entry-actions-comment-count">
					<?php comments_number('Add Comment', '1 Comment', '% Comments' ); ?>
				</span>
			</a>
		</div><!--.entry-actions-->

	</header><!-- .entry-header -->

	<?php } else { ?>

	<header class="entry-header">
		<div class="entry-meta">
			<?php thrive_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php } ?>

	<div class="entry-content">
	
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="visible-xs">
				<?php thrive_posted_on(); ?>
				<?php the_title( '<h2 class="visible-xs h1 entry-title type-light">', '</h1>' ); ?>
			</div>
		<?php } ?>

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'thrive' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php thrive_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->


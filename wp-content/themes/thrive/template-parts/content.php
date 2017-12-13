<?php
/**
 * Template part for displaying posts.
 *
 * @package thrive
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('thrive-card', 'mg-bottom-15', 'thrive-archives')); ?>>

	<?php if (has_post_thumbnail()) { ?>
		<header class="entry-header has-post-thumbnail mg-bottom-25">
			<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>

			<div class="entry-meta hidden-xs">
				<?php thrive_posted_on(); ?>
				<a href="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(the_title()); ?>">
					<?php the_title( '<h1 class="entry-title type-light">', '</h1>' ); ?>
				</a>
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

			<a href="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(the_title()); ?>">
				<?php the_title('<h1 class="entry-title">', '</h1>' ); ?>
			</a>

		</header><!-- .entry-header -->

	<?php } ?>

	<!--"End Header"-->

	<div class="entry-content">
		
		<?php if ( has_post_thumbnail() ) { ?>

			<header class="entry-header mg-top-10 visible-xs">
			
				<div class="entry-meta">
					<?php thrive_posted_on(); ?>
				</div><!-- .entry-meta -->

				<a href="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(the_title()); ?>">
					<?php the_title('<h1 class="entry-title">', '</h1>' ); ?>
				</a>
				
			</header><!-- .entry-header -->

		<?php } ?>

		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'thrive' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

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

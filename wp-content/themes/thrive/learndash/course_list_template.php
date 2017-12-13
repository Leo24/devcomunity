<?php
/**
 * This file contains the code that displays the course list.
 *
 * @since 1.6.0
 *
 * @package thrive\LearnDash\Course
 */
?>

<?php global $more; $more = 0; ?>

<div class="col-md-4 thrive-ld-course">

	<?php if ( has_post_thumbnail() ) { ?>
		<div class="thrive-ld-featured-image">

			<div class="thrive-ld-featured-image-wrap">
				<?php the_post_thumbnail(); ?>
			</div>


			<div class="thrive-ld-course-overlay">
				<div class="thrive-ld-overlay-wrapper">
					<div class="thrive-ld-overlay-wrap">
						<div class="thrive-ld-link-icon ">
							<i class="material-icons">
									school
							</i>
						</div>


						<div class="thrive-ld-see-course">
							<?php echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', _e('See Course', 'thrive'), '</a>'; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	<?php } else { ?>
		<div class="thrive-ld-featured-image">

			<div class="thrive-ld-featured-image-wrap">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/learndash/images/learndash-default-img.jpg" alt="<?php the_title(); ?>" />
			</div>


			<div class="thrive-ld-course-overlay">
				<div class="thrive-ld-overlay-wrapper">
					<div class="thrive-ld-overlay-wrap">
						<div class="thrive-ld-link-icon ">
							<i class="material-icons">
									school
							</i>
						</div>


						<div class="thrive-ld-see-course">
							<?php echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', 'See Course </a>'; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	<?php } ?>

	<div class="thrive-ld-info-container">
		<div class="thrive-ld-categories">
			<?php the_category(); ?>
		</div>

		<div class="thrive-ld-title">
			<?php the_title( '<h2 class="ld-entry-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); ?>
		</div>

		<div class="thrive-ld-author">
			<div class="thrive-ld-avatar">
				<?php echo get_avatar( $user_id = intval( get_the_author_meta( 'ID' ) ), 32 ); ?>
			</div>
			<div class="thrive-ld-name">

				<?php
					$temp_post = get_post($post_id);
					$user_id = $temp_post->post_author;
					$author_bp_profile = bp_core_get_user_domain( $user_id );
				?>

					<?php _e('By', 'thrive'); ?>
				<a href="<?php echo $author_bp_profile;?>">
					<?php echo the_author_meta( 'display_name' ); ?>
				</a>
			</div>
		</div>

	</div>
</div>

<?php get_header();?>
<?php if ( have_posts() ) { ?>
<?php while (have_posts()) { ?>
<?php the_post(); ?>
<div id="thrive-sfwd-certificate-single">
	
	<div id="thrive-sfwd-certificate-image">
		<?php the_post_thumbnail(); ?>
	</div>
	<div id="thrive-sfwd-certificate-content">
		<?php the_content(); ?>
	</div>
	
</div>
<?php } ?>
<?php } ?>

<?php get_footer(); ?>
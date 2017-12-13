<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package thrive
 */

?>
</div><!--.row-->
<?php if ( ! is_page_template('page-templates/canvas.php') ) { ?>
</div><!-- #content -->
<?php } ?> 
</div><!--.row-->
</div><!--#page-container">-->
</div><!--#page-row-->

<div class="row">

	<?php if ( is_active_sidebar( 'sidebar-footer-area' ) ) { ?>
	
		<div id="thrive_footer_widget">
			<div class="container-fluid">
				<div class="row limiter">
					<div class="clearfix">
						<?php dynamic_sidebar('sidebar-footer-area'); ?>
					</div>
				</div>
			</div>
		</div>		

	<?php } ?>

	<footer id="thrive_footer" class="site-footer" role="contentinfo">
		
		<div class="site-info">
			
			<div class="container-fluid">
				<div class="row">
					<div id="thrive_footer_copytext" class="col-xs-12">

						<?php 
							
							$thrive_allowed_html_tags = array(
						    	'a' => array(
						        	'href' => array(),
						        	'title' => array()
						    	),
						    	'br' => array(),
						    	'em' => array(),
						    	'strong' => array(),
							);

						?>

						<?php $thrive_default_copytext = __( '&copy; [Your Website Name Here] 2015. All Rights Reserved.', 'thrive'); ?>

						<?php $thrive_copytext = get_option( 'thrive_footer_copyright', $thrive_default_copytext ); ?>

						<?php if ( !empty( $thrive_copytext ) ) { ?>

							<?php echo wp_kses( $thrive_copytext, $thrive_allowed_html_tags ); ?>

						<?php } else { ?>

							<?php echo wp_kses( $thrive_default_copytext, $thrive_allowed_html_tags ); ?>

						<?php } ?>

					</div> <!--.col-xs-12-->
				</div> <!--.row-->
			</div><!--.container-fluid-->

		</div><!-- .site-info -->
	
	</footer><!-- #thrive_footer-->

</div><!--.row-->

</div><!--.site-content -(header.php)-->
</div><!-- #page-container-->
<?php do_action( 'thrive_after_body' ); ?>
</div><!-- #page -->
</div><!--#thrive-global-wrapper-->
<?php wp_footer(); ?>
</body>
</html>
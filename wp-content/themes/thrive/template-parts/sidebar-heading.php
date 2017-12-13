<div id="site-branding" <?php do_action('thrive_branding_height'); ?>>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

		<?php $default_logo = get_template_directory_uri() . '/logo.png'; ?>

		<?php $mobile_logo  = get_template_directory_uri() . '/logo-mobile.png'; ?>
		
		<?php $logo_url = get_theme_mod('thrive_logo', esc_url($default_logo)); ?>
		
		<?php $logo_mobile_url = get_theme_mod('thrive_logo_mobile', esc_url($mobile_logo)); ?>

		<img class="site-logo" id="site-md-logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo( 'title' ); ?>" />

	</a>
	
	<h1 class="sr-only site-title">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			
			<?php bloginfo( 'name' ); ?>

		</a>

	</h1>
	
	<h2 class="sr-only site-description">

		<?php bloginfo( 'description' ); ?>

	</h2>
</div><!-- .site-branding -->
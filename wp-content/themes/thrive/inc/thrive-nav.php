<div id="thrive_nav" <?php do_action('thrive_branding_height'); ?>>

	<div id="thrive_nav_wrap">

		<div class="container-fluid">
			<div class="row limiter">

				<div id="site-title-description">
					<?php if ( is_home() || is_front_page() ) { ?>
					<div class="sr-only">
						<h1>
							<a href="<?php echo esc_url( home_url() ); ?>" alt="<?php bloginfo( 'title' ); ?>">
								<?php bloginfo( 'title' ); ?>
							</a>
						</h1>
						<h2>
							<?php bloginfo( 'description' ); ?>
						</h2>
					</div>
					<?php } else { ?>
						<div class="sr-only">
							<p>
								<a href="<?php echo esc_url( home_url() ); ?>" alt="<?php bloginfo( 'title' ); ?>">
									<?php bloginfo( 'title' ); ?>
								</a>
							</p>
							<p>
								<?php bloginfo( 'description' ); ?>
							</p>
						</div>
					<?php } ?>
				</div>

				<!--site-logo-->
				<?php $layout = thrive_customizer_radio_mod('thrive_layouts_customize', '2_columns'); ?>
				<?php $default_logo = get_template_directory_uri() . '/logo.png'; ?>
				<?php $logo_url = get_theme_mod('thrive_logo', esc_url( $default_logo ) ); ?>

				<?php $mobile_default_logo = get_template_directory_uri() . '/logo-mobile.png'; ?>
				<?php $mobile_logo_url = get_theme_mod('thrive_logo_mobile', esc_url( $mobile_default_logo ) ); ?>

				<?php if ( "1_column" === $layout  ) { ?>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div id="site-logo" class="">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img class="img-site-logo visible-sm visible-md visible-lg" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php _e('Site Logo', 'thrive'); ?>" />
								<img class="img-site-logo visible-xs" src="<?php echo esc_url( $mobile_logo_url ); ?>" alt="<?php _e('Site Mobile Logo', 'thrive'); ?>" />
							</a>
						</div>
					</div>
				<?php } else { ?>

					<div class="col-md-3 col-sm-6 col-xs-12 visible-xs">
						<div id="site-logo" class="">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img class="img-site-logo visible-sm visible-md visible-lg" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php _e('Site Logo', 'thrive'); ?>" />
								<img class="img-site-logo visible-xs" src="<?php echo esc_url( $mobile_logo_url ); ?>" alt="<?php _e('Site Mobile Logo', 'thrive'); ?>" />
							</a>
						</div>
					</div>

					<div class="col-md-4 col-sm-6 col-xs-12 hidden-xs hidden-sm">
						<div id="menu-site-search" class="">
							<?php get_search_form(); ?>
						</div>
					</div>
				<?php } ?>
				<!--end site logo -->

				<!--site navigation-->

				<div id="site-navigation-container" class="col-md-5 col-sm-12">
					<nav id="site-navigation" role="navigation">

						<div id="site-navigation-menu-wrap" class="site-navigation-menu">

							<div id="desktop-menu">

								<?php
									$nav = wp_nav_menu(
										array(
												'theme_location' => 'primary',
												'menu_id' => 'primary-menu',
												'echo' => false,
												'fallback_cb' => ''
											)
										);
								?>
								<?php if ( !empty( $nav ) ) { ?>

									<?php echo thrive_handle_empty_var( $nav ); ?>

								<?php } else { ?>

									<ul id="primary-menu" class="menu">

										<li id="no-menu" class="menu-item">

											<a href="<?php echo esc_url( admin_url('nav-menus.php?action=locations') ); ?>">

												<i class="material-icons md-18">create</i>

												<?php _e("Create or Assign a 'Primary' Menu", 'thrive'); ?>

											</a>

										</li>

									</ul>

								<?php } ?>

							</div>

							<div class="clearfix"></div>

						</div>

						<div class="clearfix"></div>

					</nav><!-- #site-navigation -->
				</div>
				<!--end site navigation-->

				<!--site user navigation-->
				<?php if ( "2_columns" === $layout  ) { ?>
					<nav id="site-user-updates" class="col-md-3 col-sm-12 col-xs-12">
				<?php } else { ?>
					<nav id="site-user-updates" class="col-md-4 col-sm-6 col-xs-12">
				<?php } ?>
					<?php thrive_user_nav(); ?>
				</nav>
				<!--site user navigation end-->
			</div>
		</div>
	</div>
</div>

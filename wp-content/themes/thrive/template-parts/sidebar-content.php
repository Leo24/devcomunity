<?php if ( is_user_logged_in() ) { ?>

<?php
	$args = array(
		'size' => 'thumb',
		'object_id' => get_current_user_id()
	);

	if ( function_exists( 'bcp_get_cover_photo' ) ) {
		$cover_image_src = bcp_get_cover_photo( $args );
		?>
		<?php if ( ! empty( $cover_image_src ) ) { ?>
			<style>
			#page-sidebar-user {
				background-image: url("<?php echo esc_url($cover_image_src); ?>");
				background-size: cover;
				background-position: center center;
			}
			</style>
		<?php } ?>
	<?php } ?>
<?php

?>
	<div id="user-content-widget-sidenav" class="nano">
		<div class="nano-content">
			<div id="page-sidebar-user">
				<div class="row">
					<?php if ( function_exists( 'bp_core_get_user_domain' ) ) { ?>
						<div class="col-xs-4" id="page-sidebar-user-avatar">
							<a href="<?php echo esc_url( bp_core_get_user_domain( get_current_user_id() ) ); ?>" title="<?php _e('View Profile', 'thrive'); ?>">
								<?php echo get_avatar( get_current_user_id(), 64 ); ?>
							</a>
						</div>
					<?php } ?>
					<div class="col-xs-8" id="page-sidebar-user-details">
						<?php $user_nickname = get_user_meta( get_current_user_id(), 'nickname', true ); ?>
						<h5>
							<?php if ( function_exists('bp_core_get_user_domain') ) { ?>
								<a href="<?php echo esc_url( bp_core_get_user_domain( get_current_user_id() ) ); ?>" title="<?php _e('View Profile', 'thrive'); ?>">
									<?php echo esc_html( $user_nickname ); ?>
								</a>
							<?php } else { ?>
								<?php echo esc_html( $user_nickname ); ?>
							<?php } ?>
						</h5>
						<a class="log-out-text" href="<?php echo esc_url( wp_logout_url() ); ?>" title="<?php echo esc_attr_e( 'Logout', 'thrive' );?>">
							<?php _e('Sign Out', 'thrive'); ?>
						</a>
					</div>
				</div><!--.row-->

				<div class="row">
					<div class="col-xs-12">
						<div class="mg-top-30 light_secondary">
							<?php $user_email = get_the_author_meta( 'email', get_current_user_id() ); ?>
							<?php echo ( $user_email ); ?>
						</div>
					</div>
				</div>

			</div><!--#page-sidebar-user-->

			<div id="page-sidebar-menu">
				<?php
				$nav = wp_nav_menu(
					array(
							'theme_location' => 'secondary',
							'menu_id' => 'secondary-menu-links',
							'fallback_cb' => '',
							'echo' => false
						)
					);
				?>
				<?php if ( !empty( $nav ) ) { ?>
					<?php echo thrive_handle_empty_var( $nav ); ?>
				<?php } else { ?>
					<ul id="secondary-menu-links" class="menu">
						<li id="no-menu" class="menu-item">
							<a href="<?php echo esc_url( admin_url('nav-menus.php?action=locations') ); ?>">
								<i class="material-icons md-18">create</i>
								<?php _e("New 'Secondary' Menu", 'thrive'); ?>
							</a>
						</li>
					</ul>
				<?php } ?>
			</div>

		<?php if ( is_active_sidebar( 'sidenav-sidebar' ) ) { ?>
			<div id="page-sidebar-widgets">
				<?php dynamic_sidebar( 'sidenav-sidebar' ); ?>
			</div>
		<?php } ?>
		</div><!--.nano-content-->
	</div>
<?php } ?>

<?php if ( !is_user_logged_in() ) { ?>
<div id="user-content-widget-sidenav" class="nano">
	<div class="nano-content">
		<div id="page-sidebar-user-logged-out">
			<div class="row text-aligncenter mg-top-35">
				<div class="col-sm-12">
					<div id="thrive-logout-message">
						<?php $thrive_default_logout_message = '<p>' . esc_html__('Welcome! Please sign-in to your account. Thank you!', 'thrive') . '</p>'; ?>
						<?php $thrive_thememod_default_logout_message = get_theme_mod('thrive_sidenav_logout_text', $thrive_default_logout_message); ?>
						<?php if ( empty( $thrive_thememod_default_logout_message ) ) { ?>
							<?php echo thrive_handle_empty_var( $thrive_default_logout_message ); ?>
						<?php } else { ?>
							<p><?php echo thrive_handle_empty_var( $thrive_thememod_default_logout_message ); ?></p>
						<?php } ?>
					</div>
				</div>
				<div class="col-sm-12 mg-bottom-25" id="lock-outline">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/lock.svg' ); ?>" alt="<?php _e('Login', 'thrive'); ?>" />
				</div>
			</div>
			<?php if ( is_active_sidebar( 'sidenav-sidebar' ) ) { ?>
				<?php $thrive_sidenav_is_widget_enabled_on_logged_out = get_theme_mod('thrive_sidenav_is_widget_enabled_on_logged_out', 1); ?>
				<?php if ( $thrive_sidenav_is_widget_enabled_on_logged_out ) { ?>
					<div id="page-sidebar-widgets">
						<?php dynamic_sidebar( 'sidenav-sidebar' ); ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div><!--#page-sidebar-user-->
	</div><!--.nano-content-->
</div><!--#logged-out-sidenav-->
<?php }

/**
 * Reset Members Template to fix the issue with BuddyPress Members Widget
 * when Profile is viewed along with a pre members layout
 */
if ( isset( $GLOBALS['members_template'] ) ) {
	$GLOBALS['members_template']  = null;
}
?>

<?php
/**
 * Thrive Custom Components
 * Theme Mods Customiser, Widgets, etc.
 *
 * @since 1.0
 */
$components = array(
		'theme-widgets/featured-group',
		'theme-widgets/featured-member',
		'theme-widgets/members-birthday',
		'layouts/layouts',
		'sidenav/sidenav',
		'menu/menu',
		'typography/typography',
		'widgets/widgets',
		'colors/colors',
		'user-define-css/user-define-css',
		'user-navigation/user-navigation',
		'sidebars/sidebars',
		'footer/footer',
		'register/register',
	);

foreach ( $components as $component ) {
	require_once get_template_directory() . '/thrive/' . $component . '.php';
}
?>

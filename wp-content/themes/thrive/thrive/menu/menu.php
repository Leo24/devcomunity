<?php
/**
 * Theme menu systems
 *
 * @package thrive
 */
class DunhakdisMenu {

	public function __construct() {

		$this->registerNavigationMenus();
		$this->registerActionHooks();

		return $this;
	}

	/**
	 * [registerActionHooks description]
	 * @return [type] [description]
	 */
	public function registerActionHooks() {

		add_action('wp_head', array($this, 'customizerCompiledStyleSheet'), 100);
		add_action('customize_register', array($this, 'customizer'));
		add_action('after_setup_theme', array($this, 'registerNavigationMenus'));
		add_action('customize_preview_init', array($this, 'preview'));

		return $this;
	}
	/**
	 * Register navigation menu
	 * @return [type] [description]
	 */
	public function registerNavigationMenus() {

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__('Primary Menu', 'thrive'),
			'secondary' => esc_html__('Secondary Menu', 'thrive'),
			'topbarmenu' => esc_html__('Top Right Bar', 'thrive'),
		));

		return $this;
	}

	/**
	 * Live Preview
	 */
	public function preview() {

		// The file 'customizer.php' is actually a js file.
  		wp_enqueue_script(
  			'menu_css_preview',
  			get_template_directory_uri() . '/thrive/menu/customizer/customizer.js',
  			array( 'customize-preview', 'jquery' )
  		);

		return $this;
	}

	/**
	 * [customiser description]
	 * @return [type] [description]
	 */
	public function customizer($wp_customize) {

		$wp_customize->add_panel('thrive_branding_menu', array(
		    'title' => __( 'Branding & Menu', 'thrive'),
		    'priority' => 30, // Mixed with top-level-section hierarchy.
		));

		$this->registerCustomizerSettings('branding', $wp_customize);
		$this->registerCustomizerSettings('menu', $wp_customize);
		$this->registerCustomizerSettings('sub-menu', $wp_customize);
		$this->registerCustomizerSettings('mobile-menu', $wp_customize);

		return;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/menu/customizer/' . sanitize_title($file_handle) . '.php';

		return $this;
	}

	public function applyCSS( $identifier, $attrib, $value ) {

		$css = '';

		if ( empty( $value ) || empty( $attrib ) || empty( $identifier ) ) {
			return '';
		}

		$css = trim( sprintf( "%1s { %2s: %3s; }", $identifier, $attrib, $value ) );

		return $css;

	}

	public function customizerCompiledStyleSheet() {

		$style = '<style>';

			// ::::::::::::::::::::::::::::::::: //
			// Header Logo Background (for 2 columns layout)
			// ::::::::::::::::::::::::::::::::: //
			$style .= $this->applyCSS( '#site-branding', 'background-color', get_theme_mod( 'thrive_logo_background', '' ) );

			// ::::::::::::::::::::::::::::::::: //
			// Header Menu background color.
			$style .= $this->applyCSS( '#thrive_nav', 'background-color', get_theme_mod( 'thrive_header_menu_background', '' ) );
			// Header Menu color.
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation ul li a', 'color', get_theme_mod( 'thrive_menu_color_default', '' ) );
			// Header Menu  Hover State.
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation ul li a:hover', 'color', get_theme_mod( 'thrive_menu_color_active', '' ) );
			// Header Menu Active State.
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation ul li.current-menu-ancestor a, #thrive_nav #thrive_nav_wrap #site-navigation ul li.current-menu-item a', 'color', get_theme_mod( 'thrive_menu_color_active', '' ) );
			// Header Menu Ancestor Active State.
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li.current-menu-item > a', 'background-color', get_theme_mod( 'thrive_header_menu_background', '') );
			// ::::::::::::::::::::::::::::::::: //

			// ::::::::::::::::::::::::::::::::: //
			// Header Sub Menu Color
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a', 'color', get_theme_mod( 'thrive_submenu_color_default', '' ) );
			// Header Sub Menu Hover & Active State Color
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a:hover', 'color', get_theme_mod( 'thrive_submenu_color_active', '' ) );
			// Header Sub Menu Hover & Active State Background Color
			$style .= $this->applyCSS( '#thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li.current-menu-item > a, #thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a:hover', 'background-color', get_theme_mod( 'thrive_submenu_background_active', '' ) );
			// ::::::::::::::::::::::::::::::::: //


			// ::::::::::::::::::::::::::::::::: //
			// Header Sub Menu Color
			$style .= "@media (max-width: 992px ) {";

				$style .= $this->applyCSS( '.thrive-inline #thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a', 'color', get_theme_mod( 'thrive_mobile_menu_color', '' ) );
				$style .= $this->applyCSS( '.thrive-inline #thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a:hover', 'color', get_theme_mod( 'thrive_mobile_menu_hover_color', '' ) );
				$style .= $this->applyCSS( '.thrive-inline #thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a:hover', 'background-color', get_theme_mod( 'thrive_mobile_menu_hover_background', '' ) );

				$style .= $this->applyCSS( '.thrive-inline #thrive_nav #thrive_nav_wrap #site-navigation .sub-menu li a, #thrive_nav #thrive_nav_wrap #site-navigation ul li', 'background-color', get_theme_mod( 'thrive_mobile_background', '' ) );

			$style .= "}";
			// ::::::::::::::::::::::::::::::::: //
		$style .= '</style>';

		echo trim( $style );

        return $this;

	}

}

// Start
$thriveMenu = new DunhakdisMenu();
?>

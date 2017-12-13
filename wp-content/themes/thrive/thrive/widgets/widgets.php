<?php
/**
 * Theme Widgets Module
 *
 * @package thrive
 */
class DunhakdisWidgets {

	public function __construct() {
		
		$this->registerActionHooks();

		return $this;
	}

	public function registerActionHooks() {

		add_action('widgets_init', array($this, 'registerWidgets'));
		add_action('customize_register', array($this, 'registerCustomizer'));
		add_action('wp_head', array($this, 'stylesheet'));
		add_action('customize_preview_init', array($this, 'preview'));

		return $this;
	}

	public function preview() {

		wp_enqueue_script( 
  			'widgets_css_preview', 
  			get_template_directory_uri() . '/thrive/widgets/customizer/customizer.js', 
  			array( 'customize-preview', 'jquery' )
  		);
		
		return;
	}

	public function registerWidgets() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'thrive' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="sidebar-widgets widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));

		register_sidebar( array(
			'name'          => esc_html__( 'BP Sidebar', 'thrive' ),
			'id'            => 'bp-sidebar',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="sidebar-widgets buddypress widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Sidenav Sidebar', 'thrive' ),
			'id'            => 'sidenav-sidebar',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="sidebar-widgets buddypress widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar( array(
			'name'          => esc_html__( 'Archives', 'thrive' ),
			'id'            => 'archives-sidebar',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="sidebar-widgets archives widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Dashboard', 'thrive' ),
			'id'            => 'homepage-widgets',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="home-widgets widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));

		return $this;
	}

	public function registerCustomizer($wp_customize) {
		
		$this->registerCustomizerSettings('widgets', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/widgets/customizer/' . sanitize_title($file_handle) . '.php';

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

	public function stylesheet() {

		$style = "<style>";
		
		$theme_mod_outline = get_theme_mod( 'thrive_widgets_outline', 'shadowed' );

		$outline = "";
		
		if ( $theme_mod_outline === 'solid-border' ) {
			$outline = "none; border: 1px solid rgba(0, 0, 0, 0.12);"; //$dark_text
		}
		
		if ( $theme_mod_outline === 'no-outline' ) {
			$outline = "none; border: none;";
		}

		// Background.
		$style .= $this->applyCSS( '.sidebar-widgets', 'background', get_theme_mod( 'thrive_sidebar_widgets_background', false ) );
		// Color
		$style .= $this->applyCSS( '.sidebar-widgets', 'color', get_theme_mod( 'thrive_sidebar_color', false ) );
		// Links
		$style .= $this->applyCSS( '.site-content .sidebar-widgets a', 'color', get_theme_mod( 'thrive_sidebar_links_color', false ) );
		// Links::hover
		$style .= $this->applyCSS( '.site-content .sidebar-widgets a:hover', 'color', get_theme_mod( 'thrive_sidebar_links_color__hover', false ) );
		// Outline.
		$style .= $this->applyCSS( '.sidebar-widgets', 'box-shadow', $outline );


		// Truncate Style.
		$style .= '</style>';

		echo thrive_sanity_check( $style );
	}
}

$thriveWidgets = new DunhakdisWidgets();
?>
<?php
/**
 * Theme footer module
 *
 * @package thrive
 */
class DunhakdisFooter {

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

		// The file 'customizer.php' is actually a js file.
  		wp_enqueue_script(
  			'footer_css_preview',
  			get_template_directory_uri() . '/thrive/footer/customizer/customizer.js',
  			array( 'customize-preview', 'jquery' )
  		);

		return $this;
	}

	public function registerWidgets() {

		$columns = get_theme_mod('thrive_footer_widget_columns', '4-columns');

		$transport_columns = array(
				'0'			=> 4,
				'1-columns' => 12,
				'2-columns' => 6,
				'3-columns' => 4,
				'4-columns' => 3
			);

		$col_number = $transport_columns[$columns];

		$column_class = sprintf('footer-widget footer-widgets-%s', $columns);

		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'thrive' ),
			'id'            => 'sidebar-footer-area',
			'description'   => '',
			'before_widget' => '<div class="col-sm-6 '.$column_class.' col-md-'.esc_attr($col_number).'"><aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside></div>',
			'before_title'  => '<h3 class="widget-title h6">',
			'after_title'   => '</h3>',
		));

		return $this;
	}

	public function registerCustomizer($wp_customize) {

		$wp_customize->add_panel('thrive_footer_menu', array(
		    'title' => __( 'Footer', 'thrive'),
		    'priority' => 45, // Mixed with top-level-section hierarchy.
		));

		$this->registerCustomizerSettings('widgets', $wp_customize);
		$this->registerCustomizerSettings('footer', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/footer/customizer/' . sanitize_title($file_handle) . '.php';

		return $this;
	}


	public function stylesheet() {

		// get all theme mods
		$thrive_footer_rgba = '';
		$thrive_footer_link_rgba = '';

		$thrive_footer_color = get_theme_mod('thrive_footer_color', '');

			if ( !empty( $thrive_footer_color ) ) {
				$thrive_footer_rgba = thrive_hex2rgba($thrive_footer_color, 0.70);
			}

			$thrive_footer_link = get_theme_mod('thrive_footer_links', '');

			if ( !empty( $thrive_footer_link ) ) {
				$thrive_footer_link_rgba = thrive_hex2rgba($thrive_footer_link, 0.70);
			}

			$thrive_footer_links_hover = get_theme_mod('thrive_footer_links_hover', '');

			$thrive_footer_background = get_theme_mod('thrive_footer_background', '');


		// footer widget background
			$thrive_footer_widget_background = get_theme_mod('thrive_footer_widget_background', '');
		// footer widget color
			$thrive_footer_widget_color = get_theme_mod('thrive_footer_widget_color', '');
		// footer widget link
			$thrive_footer_widget_color_link = get_theme_mod('thrive_footer_widget_color_link', '');

				if ( !empty( $thrive_footer_widget_color_link ) ) {
					$thrive_footer_widget_color_link_rgba = thrive_hex2rgba($thrive_footer_widget_color_link, 0.70);
				}
		// footer widget link hover
			$thrive_footer_widget_color_hover = get_theme_mod('thrive_footer_widget_color_hover', '');

		// compose the style
		$stylesheet = '<style>';
			//copyright
			$stylesheet .= "#thrive_footer{";
				$stylesheet .= "color:$thrive_footer_color;";
				$stylesheet .= "background:$thrive_footer_background;";
			$stylesheet .= "}";

			if ( !empty( $thrive_footer_link_rgba ) ) {
				$stylesheet .= "#thrive_footer a{";
					$stylesheet .= "color:$thrive_footer_link_rgba;";
				$stylesheet .= "}";
			}

			if ( !empty( $thrive_footer_links_hover ) ) {
				$stylesheet .= "#thrive_footer a:hover{";
					$stylesheet .= "color:$thrive_footer_links_hover;";
				$stylesheet .= "}";
			}

			//widgets
			if ( !empty( $thrive_footer_widget_background ) ) {
				$stylesheet .= "#thrive_footer_widget {background:$thrive_footer_widget_background;}";
			}

			if ( !empty( $thrive_footer_widget_color ) ) {
				$stylesheet .= "#thrive_footer_widget, #thrive_footer_widget .widget-title {color:$thrive_footer_widget_color;}";
			}

			if ( !empty( $thrive_footer_widget_color_link_rgba ) ) {
				$stylesheet .= "#thrive_footer_widget a {color:$thrive_footer_widget_color_link_rgba;}";
			}

			if ( !empty( $thrive_footer_widget_color_hover ) ) {
				$stylesheet .= "#thrive_footer_widget a:hover {color:$thrive_footer_widget_color_hover;}";
			}

		$stylesheet .= '</style>';

		echo trim($stylesheet);

	}
}

$thriveFooter = new DunhakdisFooter();
?>

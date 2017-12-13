<?php
/**
 * Theme Colors Module
 *
 * @package thrive
 */
class DunhakdisColors {

	public function __construct() {

		$this->registerActionHooks();

		return $this;
	}

	public function registerActionHooks() {

		add_action('customize_register', array($this, 'registerCustomizer'));

		add_action('wp_head', array($this, 'stylesheet'));

		add_action('login_enqueue_scripts', array($this, 'stylesheet'));

		add_action('customize_preview_init', array($this, 'preview'));

		return $this;
	}


	public function registerCustomizer($wp_customize) {

		$this->registerCustomizerSettings('customizer', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/colors/' . sanitize_title($file_handle) . '.php';

		return $this;
	}

	public function preview() {

		// The file 'customizer.php' is actually a js file.
  		wp_enqueue_script(
  			'colors_css_preview',
  			get_template_directory_uri() . '/thrive/colors/customizer.js.php',
  			array( 'customize-preview', 'jquery' )
  		);

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

		require_once get_template_directory() . '/thrive/colors/collections.php';

		// Regulars.
		$primaryColorTags  = thrive_colors_tags( 'primary' );

		// Primary Colors Shade.
		$primaryColorShadedTags = thrive_colors_tags( 'primary_shade' );
		// Primary Background Colors.
		$primaryBackgroundTags = thrive_colors_tags( 'primary_background' );
		// Secondary Colors.
		$secondaryColors = thrive_colors_tags( 'secondary' );
		// Secondary Background Colors.
		$secondaryBackgroundColors = thrive_colors_tags( 'secondary_background' );
		// Secondary BorderColors
		$secondaryBorderColors = thrive_colors_tags( 'borders_secondary' );

		// Begin Styling.

		$style  = '<style>';

			// Primary Colors.
			$style .= $this->applyCSS( $primaryColorTags, 'color', get_theme_mod( 'thrive_primary_color', false ) );
			// Primary Background.
			$style .= $this->applyCSS( $primaryBackgroundTags, 'background-color', get_theme_mod( 'thrive_primary_color', false ) );
			// Primary Shades.
			$style .= $this->applyCSS( $primaryColorShadedTags, 'background-color', get_theme_mod( 'thrive_primary_color_shade', false ) );
			// Secondary Colors
			$style .= $this->applyCSS( $secondaryColors, 'color', get_theme_mod( 'thrive_secondary_color', false ) );
			// Secondary Background Colors
			$style .= $this->applyCSS( $secondaryBackgroundColors, 'background-color', get_theme_mod( 'thrive_secondary_color', false )	 );
			// Border Colors
			$style .= $this->applyCSS( $secondaryBorderColors, 'border-color', get_theme_mod( 'thrive_secondary_color', false ) );

		$style .= '</style>';

		echo trim( $style );

		// End style.
	}
}

$thriveWidgets = new DunhakdisColors();
?>

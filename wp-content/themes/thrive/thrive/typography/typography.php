<?php
/**
 * The Typography module of Thrive.
 *
 * @package Thrive
 * @since 1.0
 */

class DunhakdisTypography {

	var $defaultHeaderFont = 'RobotoDraft';
	var $defaultBodyFont   = 'RobotoDraft';

	public function __construct() {

		$this->registerActionHooks();

		return $this;

	}

	public function registerActionHooks() {

		add_action('customize_register', array($this, 'registerCustomizer'));

		add_filter('thrive_google_font', array($this, 'getUserSelectedGoogleFont'));

		add_action('wp_head', array($this, 'stylesheet'));

		return $this;

	}

	public function registerCustomizer($wp_customize) {

		$wp_customize->add_panel('thrive_typography', array(
		    'title' => __( 'Typography', 'thrive'),
		    'priority' => 40,
		));

		$this->registerCustomizerSettings('options', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/typography/customizer/' . sanitize_title($file_handle) . '.php';

		return $this;
	}

	public function getUserSelectedHeaderFont() {

		$header_font = get_theme_mod( 'thrive_typography_header', $this->defaultHeaderFont );

		return $header_font;

	}

	public function getUserSelectedBodyFont() {

		$body_font = get_theme_mod( 'thrive_typography_body', $this->defaultBodyFont );

		return $body_font;

	}

	public function getUserSelectedGoogleFont() {

		$header_font = $this->getUserSelectedHeaderFont();

		$body_font = $this->getUserSelectedBodyFont();

		$token = sprintf(
					"%s:700,400,700italic,400italic|%s:700,400,700italic,400italic",
					$header_font,
					$body_font
				);

		if ( $header_font === $body_font ) {

			$token = sprintf("%s:700,400,700italic,400italic", $body_font );

		}

		return $token;

	}


	public function stylesheet() {

		require_once get_template_directory() . '/thrive/typography/customizer/font-library.php';

		// Get the list of all available google fonts.
		$font_library = thrive_get_google_fonts();

		// The size of the font selected inside the customizer.
		$font_size = get_theme_mod( 'thrive_typography_font_size', 14 );

		// The font selected by the user inside the customizer.
		$body_font = $this->getUserSelectedBodyFont();

		// The font selected by the user inside the customizer.
		$header_font = $this->getUserSelectedHeaderFont();

		$style  =  '<style>';

			if ( !empty( $body_font ) ) {

				if ( $body_font !== $this->defaultBodyFont ) {

					$style .= 'body.thrive-inline {';
						$style .= sprintf( 'font-family: "%s", georgia;', $font_library[ $body_font ] );
					$style .= '}';

				}

			}

			if ( !empty( $header_font ) ) {

				if ( $header_font !== $this->defaultHeaderFont ) {

					$style .= 'body.thrive-inline h1, body.thrive-inline h2, body.thrive-inline h3, body.thrive-inline h4, body.thrive-inline h5, body.thrive-inline h6 {';
						$style .= sprintf( 'font-family: "%s", georgia;', $font_library[ $header_font ] );
					$style .= '}';

				}
			}

			if ( !empty ( $font_size ) ) {

				$style .= 'html {';
					$style .= sprintf('font-size:%spx;', $font_size);
				$style .= '}';

			}

		$style .= '</style>';

		echo thrive_sanity_check( $style );

	}
}

new DunhakdisTypography();
?>

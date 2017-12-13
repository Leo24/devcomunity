<?php
/**
 * Theme User Define CSS Module
 *
 * @package thrive
 */
class DunhakdisUserDefineCSS {

	public function __construct() {

		$this->registerActionHooks();

		return $this;
	}

	public function registerActionHooks() {

		add_action('customize_register', array($this, 'registerCustomizer'));

		add_action('wp_head', array($this, 'stylesheet'));

		add_action('customize_preview_init', array($this, 'preview'));

		return $this;
	}


	public function registerCustomizer($wp_customize) {

		$this->registerCustomizerSettings('customizer', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		require_once get_template_directory() . '/thrive/user-define-css/' . sanitize_title($file_handle) . '.php';

		return $this;
	}

	public function preview() {

  		wp_enqueue_script(
  			'user-define-css-preview',
  			get_template_directory_uri() . '/thrive/user-define-css/user-define-css.js',
  			array( 'customize-preview', 'jquery' )
  		);

		return $this;
	}

	public function stylesheet() {

		$style = sprintf( "<style>%s</style>", get_theme_mod('thrive_user_define_css', '') );

		$htmnl_entities = array( "&quot;", "&#039;", "&gt;" );

		$special_characters = array( "\"", "'", ">");

		$allowed_css = str_replace( $htmnl_entities, $special_characters, $style );

		echo trim( $allowed_css );

		// End style.
	}
}

$thriveWidgets = new DunhakdisUserDefineCSS();
?>

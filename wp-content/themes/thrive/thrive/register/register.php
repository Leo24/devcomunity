<?php
/**
 * Theme Register Option
 *
 * @package thrive
 * @since 1.8.5
 */
class DunhakdisRegister {

	public function __construct() {

		$this->registerActionHooks();

		return $this;
	}

	public function registerActionHooks() {

		add_action('customize_register', array($this, 'registerCustomizer'));

		return $this;
	}


	public function registerCustomizer($wp_customize) {

		$this->registerCustomizerSettings('customizer', $wp_customize);

		return $this;
	}

	public function registerCustomizerSettings($file_handle = '', $wp_customize) {

		include_once get_template_directory() . '/thrive/register/' . sanitize_title($file_handle) . '.php';

		return $this;
	}



	public function stylesheet() {


	}
}

$thriveRegister = new DunhakdisRegister();
?>

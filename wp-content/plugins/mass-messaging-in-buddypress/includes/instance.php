<?php if (!defined('ABSPATH')) {
	exit;
}

class Mass_Messaging_in_BuddyPress
{
	private static $_instance = null;
	public $settings = null;
	public $implementation = null;
	public $_version;
	public $_token;
	public $file;
	public $dir;
	public $assets_dir;
	public $assets_url;
	public $script_suffix;

	public function __construct($file = '', $version = '1.0.0') {
		$this->_version = $version;
		$this->_token   = 'mass_messaging_in_buddypress';

		// Load plugin environment variables
		$this->file       = $file;
		$this->dir        = dirname($this->file);
		$this->assets_dir = trailingslashit($this->dir) . 'assets';
		$this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));

		$this->script_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook($this->file, [$this, 'install']);

		// Load frontend JS & CSS
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles'], 10);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 10);

		$this->wordpress  = new Mass_Messaging_in_BuddyPress_WordPress_API();
		$this->buddypress = new Mass_Messaging_in_BuddyPress_BuddyPress_API();

		// Load API for generic admin functions
		if (is_admin()) {
			$this->admin = new Mass_Messaging_in_BuddyPress_Admin_API();
		}

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action('init', [$this, 'load_localisation'], 0);
	}

	public function load_plugin_textdomain() {
		$domain = 'mass-messaging-in-buddypress';

		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
		load_plugin_textdomain($domain, false, dirname(plugin_basename($this->file)) . '/lang/');
	}

	public function enqueue_styles() {
		wp_register_style($this->_token . '-frontend', esc_url($this->assets_url) . 'css/frontend.css', [], $this->_version);
		wp_enqueue_style($this->_token . '-frontend');
	}

	public function enqueue_scripts() {
		wp_register_script($this->_token . '-frontend', esc_url($this->assets_url) . 'js/frontend' . $this->script_suffix . '.js', ['jquery'], $this->_version);
		wp_enqueue_script($this->_token . '-frontend');
	}

	public function admin_enqueue_styles($hook = '') {
		wp_register_style($this->_token . '-admin', esc_url($this->assets_url) . 'css/admin.css', [], $this->_version);
		wp_enqueue_style($this->_token . '-admin');
	}

	public function admin_enqueue_scripts($hook = '') {
		wp_register_script($this->_token . '-admin', esc_url($this->assets_url) . 'js/admin' . $this->script_suffix . '.js', ['jquery'], $this->_version);
		wp_enqueue_script($this->_token . '-admin');
	}

	public function load_localisation() {
		load_plugin_textdomain('mass-messaging-in-buddypress', false, dirname(plugin_basename($this->file)) . '/lang/');
	}

	public static function instance($file = '', $version = '1.0.0') {
		if (is_null(self::$_instance)) {
			self::$_instance = new self($file, $version);
		}

		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
	}

	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
	}

	public function install() {
		$this->_log_version_number();
	}

	private function _log_version_number() {
		update_option($this->_token . '_version', $this->_version);
	}
}
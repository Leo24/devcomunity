<?php
/**
 * Dunhakdis functions and definitions
 *
 * @package thrive
 */

define( 'DUNHAKDIS_THEME_VERSION', '2.1.9' );

if ( ! function_exists( 'thrive_init' ) ):
	function thrive_init() {
		// Add styling to the default editor
		add_editor_style( get_template_directory_uri() . '/css/editor-style.css');
	}
	add_action('init', 'thrive_init');
endif;
if ( ! function_exists( 'thrive_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function thrive_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on thrive, use a find and replace
		 * to change 'thrive' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'thrive', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Support WooCommerce.
		 */
		add_theme_support( 'woocommerce' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// add_theme_support( 'custom-header', $args = array() );
		// add_theme_support( 'custom-background', $args = array() );

	}
endif; // End function thrive_setup.

add_action( 'after_setup_theme', 'thrive_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thrive_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'thrive_content_width', 750 );

}

add_action( 'after_setup_theme', 'thrive_content_width', 0 );

if ( ! isset( $content_width ) ) {
	$content_width = 850;
}

/**
 * Register Google Fonts
 *
 * @return  string The url of the google font.
 */
function thrive_google_fonts_url() {

    $font_url = '';

    $font_code = apply_filters( 'thrive_google_font', 'RobotoDraft:300,400,500,700,400italic,500italic,700italic,300italic' );
    /*
     Translators: If there are characters in your language that are not supported
     by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'thrive' ) ) {

        $font_url = add_query_arg( 'family', $font_code, "//fonts.googleapis.com/css" );

    }

    return $font_url;
}

/**
 * Check if user enable RTL option inside WordPress Customizer
 * @return boolean True if user enabled RTL. Otherwise, false.
 */
function thrive_is_rtl() {

	// @todo: Create rtl option inside customizer
	// $rtl_option = get_theme_mod('rtl_option');
	$rtl_option = get_theme_mod('thrive_layouts_rtl', 'no');

	if ( "yes" === $rtl_option ) {

		return true;

	}

	return false;

}

/**
 * Enqueue scripts and styles.
 */
function thrive_scripts() {

	// Load RobotoDraft font from Google Fonts
	wp_enqueue_style( 'thrive-google-font', thrive_google_fonts_url(), array(), DUNHAKDIS_THEME_VERSION );

	wp_enqueue_style( 'thrive-scaffolding', get_template_directory_uri() . '/css/bootstrap.css', array(), DUNHAKDIS_THEME_VERSION );
	wp_enqueue_style( 'thrive-group-popup', get_template_directory_uri() . '/css/group_popup.css', array(), DUNHAKDIS_THEME_VERSION );

	if ( thrive_is_rtl() ) {
		wp_enqueue_style( 'thrive-rtl', get_template_directory_uri() . '/rtl.css', array(), DUNHAKDIS_THEME_VERSION );
		wp_enqueue_style( 'bootstrap-rtl', '//cdn.rawgit.com/morteza/bootstrap-rtl/master/dist/css/bootstrap-rtl.min.css', array(), DUNHAKDIS_THEME_VERSION );
	}

	// Add theme support for LearnDash LMS.
	if ( in_array( 'sfwd-lms/sfwd_lms.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		wp_enqueue_style( 'thrive-learndash-style', get_template_directory_uri() . '/css/learndash.css', array(), DUNHAKDIS_THEME_VERSION );
		wp_dequeue_style('wpProQuiz_front_style');

	}
	// Add theme support for BuddyDrive.
	if ( in_array( 'buddydrive/buddydrive.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		wp_enqueue_style( 'thrive-buddydrive-style', get_template_directory_uri() . '/css/buddydrive.css', array(), DUNHAKDIS_THEME_VERSION );
	}

	wp_enqueue_style( 'thrive-scaffolding-theme', get_template_directory_uri() . '/css/bootstrap-theme.css', array(), DUNHAKDIS_THEME_VERSION );

	wp_enqueue_style( 'thrive-style', get_stylesheet_uri(), array(), DUNHAKDIS_THEME_VERSION );

	wp_enqueue_script( 'thrive-navigation', get_template_directory_uri() . '/js/navigation.js', array(), DUNHAKDIS_THEME_VERSION, true );
	wp_enqueue_script( 'thrive-jquery-plugins', get_template_directory_uri() . '/js/jquery-plugins.js', array( 'jquery' ), DUNHAKDIS_THEME_VERSION, true );
	wp_enqueue_script( 'thrive-script', get_template_directory_uri() . '/js/thrive.js', array(), DUNHAKDIS_THEME_VERSION, true );
	wp_enqueue_script( 'thrive-group-popup', get_template_directory_uri() . '/js/group_popup.js', array(), DUNHAKDIS_THEME_VERSION, true );

	wp_enqueue_script( 'thrive-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), DUNHAKDIS_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	return;

}

add_action( 'wp_enqueue_scripts', 'thrive_scripts' );

function showGroupPagePopup(){
    $showPopup = false;
    $userId = get_current_user_id();
    $userMeta = get_user_meta($userId, 'user_group_list', true);
    $groupId = bp_get_group_id();
    if($groupId && $groupId !==  0) {
        if (strpos($userMeta, (string)$groupId) === false) {
            $showPopup = true;
        }
    }
//    delete_user_meta( $userId, 'user_group_list');
    return $showPopup;
}

add_action('wp_ajax_acceptGroupConditions', 'acceptGroupConditions');
add_action('wp_ajax_nopriv_acceptGroupConditions', 'acceptGroupConditions');

function acceptGroupConditions(){
    if(isset($_POST['action']) && $_POST['action'] === 'acceptGroupConditions'){
        $data = $_POST;
        $userId = $data['userId'];
        $groupId = $data['groupId'];
        $userMeta = get_user_meta($userId, 'user_group_list', true);
        if (strpos($userMeta, (string)$groupId) === false) {
            $userMeta = $userMeta . ' ' . $groupId;
            update_user_meta($userId, 'user_group_list', $userMeta);
            wp_send_json(array(
                'message'  => 'Data saved.',
            ));
        }
    }
    return false;
}

function renderUserConfurmation($userId, $groupId, $member_type){
    if($member_type == 'member' || $member_type == 'banned'){
        $userMeta = get_user_meta($userId, 'user_group_list', true);
        if($groupId && $groupId !==  0) {
            if (strpos($userMeta, (string)$groupId) !== false) {
                echo '<td class="urole-column">';
                _e('User Confirmed Terms', 'thrive');
                echo '</td>';
         }
            else{
                echo '<td class="urole-column">';
                _e('User Not Confirmed Terms', 'thrive');
                echo '</td>';
            }
        }
    }
}

/**
 * Disable BuddyPress Cover Photo
 */
add_filter( 'bp_is_profile_cover_image_active', '__return_false' );
add_filter( 'bp_is_groups_cover_image_active', '__return_false' );

/**
 * Require the menu
 */
require get_template_directory() . '/thrive/thrive.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load WooCommerce compatability file.
 */
require get_template_directory(). '/inc/woocommerce.php';

/**
 * Option Tree Settings.
 */
if ( class_exists( 'Gears' ) ) {

	add_filter( 'ot_theme_options_page_title', 'thrive_options_page_title');
	function thrive_options_page_title() { return __('Social Connect ', 'thrive'); }

	add_filter( 'ot_theme_options_menu_title', 'thrive_options_menu_title');
	function thrive_options_menu_title() { return __('Social Connect ', 'thrive'); }

	add_filter( 'ot_header_version_text', 'thrive_ot_header_version_text');
	function thrive_ot_header_version_text(){ return __('Thrive Social Connect ', 'thrive') . DUNHAKDIS_THEME_VERSION; };

	add_filter( 'gears_widget_recent_posts_is_enabled', '__return_true' );
    add_filter( 'gears_widget_social_media_link_is_enabled', '__return_true' );
    add_filter( 'gears_counters_enabled', '__return_true' );

	add_filter( 'ot_show_pages', '__return_false' );
	add_filter( 'ot_show_options_ui', '__return_false' );
	add_filter( 'ot_show_new_layout', '__return_false' );
	add_filter( 'ot_theme_mode', '__return_true' );

	/**
	 * include OptionTree.
	 */
	require get_template_directory() . '/inc/option-tree/ot-loader.php';
	require get_template_directory() . '/inc/theme-options.php';

}

/**
 * WP Login CSS.
 */
require get_template_directory() . '/inc/wp-login-css.php';

/**
 * Require TGM
 */
require get_template_directory() . '/thrive/tgm/tgm-plugin-loader.php';

/**
 * Include One Click Demo Installation Demo
 */
require_once get_template_directory() . '/one-click-demo-import/one-click-demo-import.php';

<?php
/**
 * Handles the styling for default WP Login
 *
 * @package thrive
 */

/**
 * Filter callback to login_enqueue_scripts
 *
 * @return void
 */
function thrive_wp_login_logo() {

	$site_logo_src = get_theme_mod( 'thrive_logo' );

	if ( empty( $site_logo_src ) ) {

		$site_logo_src = get_template_directory_uri() . '/logo.png';

	}

	?>

    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('<?php echo esc_url( $site_logo_src ); ?>');
            padding-bottom: 30px;
        }
        /*Apply Customer Branding Background to Logo*/
        <?php $thrive_logo_background = get_theme_mod('thrive_logo_background', '#0288d1'); ?>
        <?php if ( ! empty( $thrive_logo_background )) { ?>
            .login h1 { background-color: <?php echo esc_html( $thrive_logo_background ); ?>!important; }
        <?php } ?>
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'thrive_wp_login_logo' );

/**
 * Thrive WP Log-in Style
 *
 * @return void
 */
add_action( 'login_enqueue_scripts', 'thrive_login_stylesheet' );

function thrive_login_stylesheet() {

    wp_enqueue_script('jquery');
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/wp-login.css' );
    wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/js/wp-login.js' );

    return;
}
/**
 * Thrive WP Log-in Logo URL
 *
 * @return string
 */
add_filter( 'login_headerurl', 'thrive_login_logo_url' );

function thrive_login_logo_url() {
    return esc_url( home_url('/') );
}
/**
 * Thrive WP Log-in Logo URL title.
 *
 * @return string
 */
add_filter( 'login_headertitle', 'thrive_login_logo_url_title' );

function thrive_login_logo_url_title() {

    return esc_attr__( 'Go back to main page', 'thrive' );

}
/**
 * Thrive WP Log-in forget password link
 *
 * @return void
 */
add_action('login_footer', 'thrive_wp_login_forget_pass');

function thrive_wp_login_forget_pass() {

    echo '<div id="thrive-wp-login-lost-pass"><p><a href="'.esc_url(wp_lostpassword_url()).'" title="'.esc_attr('Click to Recover Password','thrive').'">'.esc_html__('Lost Password?', 'thrive').'</a></p></div>';
}

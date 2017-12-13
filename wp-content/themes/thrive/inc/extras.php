<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package thrive
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function thrive_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( thrive_is_rtl() ) {
		$classes[] = 'rtl';
	}

	if ( ! is_user_logged_in() ) {
		$classes[] = 'logged-out';
	}

	return $classes;
}

add_filter( 'body_class', 'thrive_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function thrive_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'thrive' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'thrive_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function thrive_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'thrive_render_title' );
endif;


/**
 * Converts Hex to RGBA
 */
function thrive_hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

function thrive_comments($comment, $args, $depth){
$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo thrive_handle_empty_var( $tag ) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body row">
	<?php endif; ?>


	<div class="comment-author vcard col-xs-2 col-sm-1 no-pd-right">
		<div class="clearfix">
			<?php echo get_avatar( $comment, 64 ); ?>
		</div>
	</div>

	<div class="comment-content col-xs-10 col-sm-11">

		<div class="comment-content-context">

		<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'thrive'); ?></em>
		<br />
		<?php endif; ?>

		<div class="row">
			<div class="comment-author-name mg-bottom-10 col-xs-12 col-sm-5 ">
				<?php printf( __( '<span class="type-strong fn">%s</span>', 'thrive' ), get_comment_author_link() ); ?>
			</div>

			<div class="comment-meta commentmetadata col-sm-7 col-xs-12">
				<span class="pull-right mg-left-10">
					<?php edit_comment_link( __( '(Edit)', 'thrive' ), '  ', '' );?>
				</span>
				<a class="type-strong dark_disabled pull-right" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __('%1$s at %2$s', 'thrive'), get_comment_date(),  get_comment_time() ); ?>
				</a>

				<div class="clearfix"></div>
			</div>
		</div>

		<div class="comment-text">
			<?php comment_text(); ?>
		</div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		</div>
	</div>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}
add_filter( 'get_the_archive_title', 'thrive_archive_title');

function thrive_archive_title() {

	$title = "";

    if ( is_category() ) {

    	$title  = '<span class="archive-type">' . __('Category', 'thrive') . '</span>';
        $title .= '<span class="archive-title">' . single_cat_title( '', false ) . '</span>';

    } elseif ( is_tag() ) {

    	$title  = '<span class="archive-type">' . __('Tag', 'thrive') . '</span>';
        $title .= '<span class="archive-title">' . single_tag_title( '', false ) . '</span>';


    } elseif ( is_author() ) {

    	$title  = '<span class="archive-type">' . __('Author', 'thrive') . '</span>';
        $title .= '<span class="archive-title vcard">' . get_the_author( '', false ) . '</span>';

    } elseif ( is_tax() ) {

    	global $wp_query;

    	$tax_name = '';
    	$term = $wp_query->get_queried_object();

    	if (!empty($term)) {
    		$tax_name = $term->name;
    	}

   		$title  = '<span class="archive-type">' . __('Archive', 'thrive') . '</span>';
        $title .= '<span class="archive-title vcard">' . esc_attr($tax_name) . '</span>';

    }

    return $title;

}

/**
 * Changes default BuddyDrive Label
 */
add_filter('buddydrive_get_name', 'thrive_buddydrive_set_name');

/**
 * Callback function to 'buddydrive_get_name' filter
 */
function thrive_buddydrive_set_name() {
	return  __('Files', 'thrive');
}

/**
 * Add Message to install BuddyPress if BuddyPress is not found
 */

add_action( 'thrive_before_content', 'thrive_bp_require' );

function thrive_bp_require() {
	if ( current_user_can('manage_options') ) { ?>
		<?php if ( !function_exists('buddypress') ) { ?>
			<div id="global-message" class="alert alert-danger">
				<?php $bp_link = '<a href="https://wordpress.org/plugins/buddypress/">'.__('BuddyPress', 'thrive').'</a>'; ?>
				<?php echo sprintf( __( "%s is not currently installed or activated. Thrive recommends that you install and activate %s plugin. Thank you :)", 'thrive' ), $bp_link, $bp_link); ?>
			</div>
		<?php } ?>
	<?php }
}


add_filter('body_class', 'thrive_layout_body_class');

function thrive_layout_body_class( $classes_collection ) {

	$classes_collection[] = 'thrive-layout-' . thrive_customizer_radio_mod('thrive_layouts_customize', '2_columns');

	return $classes_collection;

}

function thrive_layout_class( $section = '' ) {

	if ( empty( $section ) ) {
		return '';
	}

	$classes['sidenav'] = '';
	$classes['content'] = 'col-xs-12 full-content-layout';

	if ( ! array_key_exists( $section, $classes ) ) {
		return '';
	}

	return $classes[ $section ];
}

add_action( 'thrive_after_body', 'thrive_wisechat_support' );

function thrive_wisechat_support() {

    $wise_chat_pro_options = get_option( 'wise_chat_options_name' );
    $fb_mode = '';

	if ( function_exists('wise_chat') ) {

		if ( is_user_logged_in() ) {

            if (1 === intval($wise_chat_pro_options['mode'])) {
                $fb_mode = 'fb-mode-enabled ';
            }

			do_action('before_wisechat_support');

			echo '<div id="thrive-wisechat-support" class="inactive has-wise-chat ' . $fb_mode . '">';
				echo '<div id="thrive-wisechat-support-close-btn">
						<span id="thrive-chat-icon">
							<i class="material-icons">chat</i>
							<em id="thrive-chat-icon-label">'.__('Chat', 'thrive').'</em>
						</span>
						<span id="thrive-chat-label">
							<i class="material-icons">add</i>
						</span>
						<i id="thrive-wisechat-support-close-btn-icon" class="material-icons">close</i></div>';
						wise_chat();
			echo '</div>';

			do_action('after_wisechat_support');

		}

	}

	return;
}

/**
 * RTMedia Updates
 */

add_filter('bp_get_activity_show_filters_options', 'thrive_add_media_show_filter', 10, 2);

if ( ! function_exists('thrive_add_media_show_filter') ) {

	function thrive_add_media_show_filter( $filters, $context ) {

	    $filters['rtmedia_update'] = __('Media Updates', 'thrive');

	    return $filters;

	}

}

/**
 * Branding Height
 */
add_action('thrive_branding_height', 'thrive_branding_height');

function thrive_branding_height() {

	$branding_height = 100;
	$thememod_branding_height = get_theme_mod( 'thrive_branding_height', false );

	if ( !empty( $thememod_branding_height ) ) {
		$branding_height = $thememod_branding_height;
	}

	echo sprintf( 'style="height: %dpx;"', intval( $branding_height ) );

	return;
}

/**
 * Customizer Radio Selector Wrapper
 */
function thrive_customizer_radio_mod( $mod_name = '', $default = '') {

	$theme_mod_value = get_theme_mod( $mod_name );

	if ( empty ( $theme_mod_value ) ) {

		return $default;

	}

	return $theme_mod_value;

}

add_filter('bp_members_widget_separator', 'thrive_groups_widget_separator');
add_filter('bp_groups_widget_separator', 'thrive_groups_widget_separator');

function thrive_groups_widget_separator() {
	return '&raquo;';
}

add_filter('ld_course_list', 'thrive_fix_ld_container_issue');

function thrive_fix_ld_container_issue( $output ){
	return '<div class="thrive-ld-courses-wrapper">' . $output . '</div>';
}

/**
 * Add new button for user to view his/her profile as different user
 */
add_action('thrive_bp_view_profile_as', 'thrive_bp_view_profile_as_cb');

function thrive_bp_view_profile_as_cb() {

	if ( ! function_exists('buddypress')) {
		return;
	}


	if ( ! function_exists('bp_is_user') ) {
		return;
	}

	if ( bp_is_user() ) {

		// Get the current viewed user's id.
		$current_viewed_user_id = absint(buddypress()->displayed_user->id);

		// Get the current logged-in user's id.
		$current_user_id = get_current_user_id();

		if ( $current_viewed_user_id === $current_user_id ) {
			?>
				<div id="item-nav-user-settings-btn">
					<a href="<?php echo esc_url( bp_loggedin_user_domain() ); ?>settings" class="button" title="<?php echo esc_attr__('Settings', 'thrive'); ?>">
						<?php esc_attr_e('Settings', 'thrive'); ?>
					</a>
				</div>
			<?php
		}
	}
	return;
}

function thrive_sanity_check( $mixed_data ) {
	if ( ! empty ( $mixed_data ) ) {
		return $mixed_data;
	}
	return "";
}

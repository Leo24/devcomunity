<?php
function ocdi_import_files() {
    return array(
        array(
            'import_file_name'           => 'Thrive Intranet & Extranet Demo',
            // DEMO CATEGORY
            'categories'                 => array( 'Thrive Intranet & Extranet Demo' ),
            // XML FILE URL
            'import_file_url'            => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+Intranet+%26+Extranet+Demo+Files/thrive-intranet-and-extranet.xml',
            // WIDGET FILE URL (.WIE)
            'import_widget_file_url'     => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+Intranet+%26+Extranet+Demo+Files/thrive-intranet-and-extranet-widgets.wie',
            // PREVIEW IMAGE
            'import_preview_image_url'   => 'http://image-turbo.s3.amazonaws.com/thrive-docs/Thrive+Intranet+%26+Extranet+Demo+Files/thrive-intrane-and-extranet-preview.jpg',

            'import_notice'              => __( 'After you import this demo, you will have to create your own members and groups because their data should be unique.', 'thrive' ),
        ),

        array(
            'import_file_name'           => 'Thrive Community Demo',

            'categories'                 => array( 'Thrive Community Demo' ),

            'import_file_url'            => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+Community+Demo+FIles/thrive-community-demo.xml',

            'import_widget_file_url'     => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+Community+Demo+FIles/thrive-community-demo-widgets.wie',

            'import_customizer_file_url' => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+Community+Demo+FIles/thrive-community-demo.dat',

            'import_preview_image_url'   => 'http://image-turbo.s3.amazonaws.com/thrive-docs/Thrive+Community+Demo+FIles/thrive-community-preview.jpg',

            'import_notice'              => __( 'For this import, please make sure that you have installed and activated all the recommended plugins. Also, you will have to setup the slider separately.', 'thrive' ),
        ),

        array(
            'import_file_name'           => 'Thrive E-learning Demo',

            'categories'                 => array( 'Thrive E-learning Demo' ),

            'import_file_url'            => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+E-learning+Demo+Files/thrive-e-learning-demo.xml',

            'import_widget_file_url'     => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+E-learning+Demo+Files/thrive-e-learning-demo-widgets.wie',

            'import_customizer_file_url' => 'https://s3.amazonaws.com/image-turbo/thrive-docs/Thrive+E-learning+Demo+Files/thrive-e-learning-demo.dat',

            'import_preview_image_url'   => 'http://image-turbo.s3.amazonaws.com/thrive-docs/Thrive+E-learning+Demo+Files/thrive-E-learning-preview.jpg',

            'import_notice'              => __( 'For this import, please make sure that you have installed and activated all the recommended plugins. Also, you will have to setup the slider separately.', 'thrive' ),
        )

    );

}

add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


// Empty the theme sidebars before importing the demo contents.
function ocdi_before_widgets_import( $selected_import ) {

    // Get theme sidebars
    $thrive_sidebars = get_option( 'sidebars_widgets' );

    // Check if the theme sidebars are not empty
    if ( ! empty( $thrive_sidebars ) ) {

        // Empty the theme sidebars
        update_option( 'sidebars_widgets', $null );

    }

}

add_action( 'pt-ocdi/before_widgets_import', 'ocdi_before_widgets_import' );


// Configure the theme demo settings properly after the importation of the demo contents.
function ocdi_after_import( $selected_import ) {

    global $wp_rewrite;

    // Thrive Intranet & Extranet Demo Settings
    if ( "Thrive Intranet & Extranet Demo" === $selected_import['import_file_name'] ) {

        thrive_intranet_demo_import_setting();

    }

    // Thrive Community Demo Settings
    if ( "Thrive Community Demo" === $selected_import['import_file_name'] ) {

        thrive_community_demo_import_setting();

    }

    // Thrive E-learning Demo Settings
    if ( "Thrive E-learning Demo" === $selected_import['import_file_name'] ) {

        thrive_e_learning_demo_import_setting();

    }

    // Update BuddyPress options
    thrive_set_bp_options();

    // Set permalink
    $wp_rewrite->set_permalink_structure( '/%postname%/' );

    flush_rewrite_rules( $hard = true );

}

add_action( 'pt-ocdi/after_import', 'ocdi_after_import' );


// Function that handles the Thrive Intranet & Extranet Demo Settings
function thrive_intranet_demo_import_setting() {

    // Assign menus to their locations.
    $header_menu = get_term_by( 'name', 'Header', 'nav_menu' );

    $sidenav_menu = get_term_by( 'name', 'Sidenav', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(

            'primary' => $header_menu->term_id,

            'secondary' => $sidenav_menu->term_id,

        )

    );


    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Dashboard' );

    $blog_page_id  = get_page_by_title( 'News Blog' );

    update_option( 'show_on_front', 'page' );

    update_option( 'page_on_front', $front_page_id->ID );

    update_option( 'page_for_posts', $blog_page_id->ID );

}


// Function that handles the Thrive Community Demo Settings
function thrive_community_demo_import_setting() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(

            'primary' => $main_menu->term_id,

        )
    );


    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );

    update_option( 'page_on_front', $front_page_id->ID );


    // Declare the name of the theme demo slider
    $demo_slider = 'home-slider';

    // Import the theme demo slider
    thrive_import_slider( $demo_slider );

}


// Function that handles the Thrive E-learning Demo Settings
function thrive_e_learning_demo_import_setting() {

    // Assign menus to their locations.
    $primary_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

    $secondary_menu = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(

            'primary' => $primary_menu->term_id,

            'secondary' => $secondary_menu->term_id,
        )
    );


    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Landing' );

    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );

    update_option( 'page_on_front', $front_page_id->ID );

    update_option( 'page_for_posts', $blog_page_id->ID );


    // Declare the name of the theme demo slider
    $demo_slider = 'elearning-slider';

    // Import the theme demo slider
    thrive_import_slider( $demo_slider );

}


// Import the theme demo slider
function thrive_import_slider( $slider = '' ) {

    if ( empty ( $slider ) )  return;

    $thrive_demo_slider = get_template_directory() . "/demo/" . $slider . ".zip";

    if ( file_exists( $thrive_demo_slider ) ) {

        require_once( ABSPATH . 'wp-admin/includes/file.php' );

        if ( class_exists( 'RevSlider' ) ) {

            $rev_slider = new RevSlider();

            $rev_slider->importSliderFromPost( true, true, $thrive_demo_slider );

        }

    }

    return;

}



function thrive_set_bp_options() {

    $bp_pages = get_option('bp-pages');

    $members_page = get_page_by_path( 'members-2' );

    $groups_page = get_page_by_path( 'groups' );

    $activity_page = get_page_by_path( 'activity-2' );

    if ( isset ( $members_page->ID ) ):

        $bp_pages['members'] = $members_page->ID;

    endif;

    if ( isset ( $members_page->ID ) ):

        $bp_pages['groups'] = $groups_page->ID;

    endif;

    if ( isset ( $members_page->ID ) ):

        $bp_pages['activity'] = $activity_page->ID;

    endif;

    update_option( 'bp-pages', $bp_pages );

    return;

}

?>

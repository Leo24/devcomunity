<?php
/**
 * Theme Options File
 */

add_action( 'admin_init', 'klein_theme_options_setup' );

function klein_theme_options_setup() {

    $saved_settings = get_option( 'option_tree_settings', array() );
    $fb_link = "https://www.youtube.com/watch?v=orx7bhEBUP4";

    $thrive_options_settings = array(

     'contextual_help' => array(
        'content' => array(
            array(
                'id' => 'general_help',
                'title' => 'General',
                'content' => '<p>Thank you for choosing Thrive WordPress Theme. Please visit http://dunhakdis.ticksy.com for support and inquiry.</p>'
                )
            ),
        'sidebar'  => '<p>:)</p>',
        )
     );


    if ( class_exists( 'Gears' ) ) {

        // facebook connect section
        $thrive_options_settings['sections'][] = array(
            'id'          => 'facebook_connect',
            'title'       => 'FB Sign-in'
            );


        $thrive_options_settings['settings'][] = array(
            'id'          => 'is_fb_enabled',
            'label'       => 'Enable Facebook Connect',
            'desc'        => 'Check to enable Facebok Connect/Register. Make sure to enable the registration in general settings.',
            'type'        => 'checkbox',
            'section'     => 'facebook_connect',
            'choices'     => array(
                array(
                    'value' => 'yes',
                    'label' => 'Yes' 
                    )
                )
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'gears_fb_btn_label',
            'label'       => 'Button Label',
            'desc'        => 'Enter a custom label for your facebook connect button to replace the default text (Connect w/ Facebook)',
            'type'        => 'text',
            'section'     => 'facebook_connect'
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'application_secret',
            'label'       => 'Application Secret',
            'desc'        => '',
            'type'        => 'text',
            'section'     => 'facebook_connect'
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'application_id',
            'label'       => 'Application ID',
            'desc'        => 'Enter your Facebook <b>App ID</b> and <b>App Secret</b> in the following text field. <a href="'.esc_url( $fb_link ).'" target="_blank">Click here to locate your App ID and Key.</a>',
            'type'        => 'text',
            'section'     => 'facebook_connect'
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'application_secret',
            'label'       => 'Application Secret',
            'desc'        => '',
            'type'        => 'text',
            'section'     => 'facebook_connect'
            );

        // google connect section
        
        $thrive_options_settings['sections'][] = array(
            'id'          => 'gp_connect',
            'title'       => 'Google Sign-in'
            );

         $thrive_options_settings['settings'][] = array(
            'id'          => 'google_api_enabled',
            'label'       => 'Enable Google Connect',
            'desc'        => 'Check to enable Google Connect. Make sure to enable the registration in general settings.',
            'type'        => 'checkbox',
            'section'     => 'gp_connect',
            'choices'     => array(
                array(
                    'value' => 'yes',
                    'label' => 'Yes' 
                    )
                )
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'google_api_button_label',
            'label'       => 'Button Label',
            'std' => 'Google+',
            'desc'        => 'Enter a custom label for your Google Connect button to replace the default text (Google+)',
            'type'        => 'text',
            'section'     => 'gp_connect'
         );
        
        $thrive_options_settings['settings'][] = array(
            'id'          => 'google_api_client_id',
            'label'       => 'Client ID',
            'desc'        => 'Please provide your Google App Client ID. Kindly head over to <a target="_blank" href="http://console.developers.google.com/project" title="Google Developers Console"> Google Developers Console</a> to find your \'Client ID\'',
            'type'        => 'text',
            'section'     => 'gp_connect'
            );

        $thrive_options_settings['settings'][] = array(
            'id'          => 'google_api_client_secret',
            'label'       => 'Client Secret',
            'desc'        => 'Please provide your Google App Client Secret. Kindly head over to <a target="_blank" href="http://console.developers.google.com/project" title="Google Developers Console"> Google Developers Console</a> to find your \'Client Secret\'',
            'type'        => 'text',
            'section'     => 'gp_connect'
            );

        $google_api_callback_uri = admin_url('admin-ajax.php?action=clientConnectionInit');

        $thrive_options_settings['settings'][] = array(
            'id'          => 'google_api_callback_instruction',
            'label'       => 'REDIRECT URIS',
            'desc'       => '<p><strong><span style="color:#E74C3C;">IMPORTANT</span>: In your Google Developer Console. Please set the "REDIRECT URIS" to the following:</strong></p><strong>REDIRECT URIS: </strong>
                             <code>'.$google_api_callback_uri.'</code>',
            'type'        => 'textblock',
            'section'     => 'gp_connect'
           );
    }

    if ( $saved_settings !== $thrive_options_settings ) {
        update_option( 'option_tree_settings', $thrive_options_settings ); 
    }
}
?>
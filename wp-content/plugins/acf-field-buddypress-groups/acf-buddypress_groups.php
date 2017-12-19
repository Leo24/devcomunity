<?php

/*
Plugin Name: Advanced Custom Fields: Buddypress Groups
Plugin URI: https://github.com/locomo/acf-field-buddypress-groups
Description: Buddypress Groups field for Advanced Custom Fields
Version: 1.0.4
Author: Satellite Jones
Author URI: http://satellitejones.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-buddypress_groups', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );


// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_buddypress_groups( $version ) {

	include_once('acf-buddypress_groups-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_buddypress_groups');




// 3. Include field type for ACF4
function register_fields_buddypress_groups() {

	include_once('acf-buddypress_groups-v4.php');

}

add_action('acf/register_fields', 'register_fields_buddypress_groups');



?>

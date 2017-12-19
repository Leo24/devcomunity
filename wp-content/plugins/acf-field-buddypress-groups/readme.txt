=== Advanced Custom Fields: Buddypress Groups Field ===
Contributors: Satellite Jones
Tags: Buddypress, Groups, Buddypress Groups, ACF, Advanced Custom Fields
Requires at least: 3.5
Tested up to: 4.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SHORT_DESCRIPTION

== Description ==

This plugin provides a Buddypress Groups field for Advanced Custom Fields. The field can be configured to display all groups or only groups of which the active user is a member. You can choose to return the Group ID(s) or Group object(s).

= Compatibility =

This ACF field type is compatible with:
* ACF 5
* ACF 4

== Installation ==

1. Copy the `acf-buddypress_groups` folder into your `wp-content/plugins` folder
2. Activate the Buddypress Groups plugin via the plugins admin page
3. Create a new field via ACF and select the Buddypress Groups type
4. Please refer to the description for more info regarding the field type settings

== Changelog ==

= 1.0.5 =
* Added 'allow_null' setting for the select list field

= 1.0.4 =
* Added documentation for template usage

= 1.0.3 =
* Added return_format option for ACF 4

= 1.0.2 =
* Added return_format option - can choose to return the group ID or group object  (ACF 5 only)

= 1.0.1 =
* Added support for ACF 5

= 1.0.0 =
* Initial Release.

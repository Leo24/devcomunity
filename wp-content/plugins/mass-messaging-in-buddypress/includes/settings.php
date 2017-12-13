<?php if (!defined('ABSPATH')) {
    exit;
}

/*
 * New tabs for features activated: Members, Groups, Blogs etc...
 */

class Mass_Messaging_in_BuddyPress_Settings
{
    private static $_instance = null;
    public $parent = null;
    public $base = '';
    public $settings = [];
    public $site = [];

    public function __construct($parent)
    {
        $this->parent = $parent;

        $this->base = $this->parent->_token . '_';

        $this->site[ 'members' ] = true;
        $this->site[ 'groups' ]  = bp_is_active('groups');
        $this->site[ 'blogs' ]   = is_multisite();

        // Initialise settings
        add_action('init', [$this, 'init_settings']);

        // Register plugin settings
        add_action('admin_init', [$this, 'register_settings']);

        // Add settings page to menu
        add_action('admin_menu', [$this, 'add_menu_item']);

        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename($this->parent->file), [$this, 'add_settings_link']);

        do_action($this->base . 'init');
    }

    public function get_option($id, $type, $default = false)
    {
        $data = get_option($this->base . $id, $default);
        switch ($type) {
            case 'checkbox':
                return $data == 'on';
            default:
                return $data;
        }
    }

    public static function instance($parent)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
        }

        return self::$_instance;
    }

    public function init_settings()
    {
        $features   = [];
        $features[] = $this->get_option('ordering_first', 'text');
        $features[] = $this->get_option('ordering_second', 'text');
        $features[] = $this->get_option('ordering_third', 'text');
        $features   = array_unique($features);

        $position = (array_search('members', $features) + 1) * 10;
        add_filter($this->parent->_token . '_settings_fields', [$this, 'members_settings_fields'], $position);

        if ($this->site[ 'groups' ]) {
            $position = (array_search('groups', $features) + 1) * 10;
            add_filter($this->parent->_token . '_settings_fields', [$this, 'groups_settings_fields'], $position);
        }

        if ($this->site[ 'blogs' ]) {
            $position = (array_search('blogs', $features) + 1) * 10;
            add_filter($this->parent->_token . '_settings_fields', [$this, 'multisite_settings_fields'], $position);
        }

        add_filter($this->parent->_token . '_settings_fields', [$this, 'ordering_settings_fields'], 50);
        add_filter($this->parent->_token . '_settings_fields', [$this, 'user_access_settings_fields'], 40);
        add_filter($this->parent->_token . '_settings_fields', [$this, 'messaging_settings_fields'], 40);

        $this->settings = $this->settings_fields();
    }

    private function settings_fields()
    {
        $settings[ 'features' ] = ['title'       => __('Features', 'mass-messaging-in-buddypress'),
                                   'description' => __('Configure which features are enabled or disabled. (Drag to reorder)', 'mass-messaging-in-buddypress'),
                                   'fields'      => []];

        $settings[ 'access' ] = ['title'       => __('Access', 'mass-messaging-in-buddypress'),
                                 'description' => __('Configure who can access the mass messaging.', 'mass-messaging-in-buddypress'),
                                 'fields'      => []];

        $settings[ 'messaging' ] = ['title'       => __('Messaging', 'mass-messaging-in-buddypress'),
                                  'description' => __('Manage mass messaging reading and replies.', 'mass-messaging-in-buddypress'),
                                  'fields'      => []];

        $settings[ 'support' ] = ['title'       => __('Support', 'mass-messaging-in-buddypress'),
                                  'description' => __('For help and support please visit the WordPress plugin support forums<br /><br /><a href="https://wordpress.org/support/plugin/mass-messaging-in-buddypress">https://wordpress.org/support/plugin/mass-messaging-in-buddypress</a><br /><br />Mass Messaging will be free, always. Please consider donating :)<br /><br /><a href="https://www.paypal.me/eliottrobson/10">Donate via PayPal</a>', 'mass-messaging-in-buddypress'),
                                  'fields'      => []];

        $settings = apply_filters($this->parent->_token . '_settings_fields', $settings);

        return $settings;
    }

    public function add_menu_item()
    {
        $page = add_options_page(__('Mass Messaging', 'mass-messaging-in-buddypress'), __('Mass Messaging', 'mass-messaging-in-buddypress'), 'manage_options', $this->parent->_token . '_settings', [$this,
                                                                                                                                                                                                     'settings_page']);
        add_action('admin_print_styles-' . $page, [$this, 'settings_assets']);
    }

    public function settings_assets()
    {
        wp_register_script($this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', ['jquery'], $this->parent->_version);

        wp_register_style($this->parent->_token . '-settings-css', $this->parent->assets_url . 'css/admin' . $this->parent->script_suffix . '.css', [], $this->parent->_version);

        wp_enqueue_script($this->parent->_token . '-settings-js');
        wp_enqueue_style($this->parent->_token . '-settings-css');

        wp_enqueue_script('jquery-ui-sortable');
    }

    public function add_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __('Settings', 'mass-messaging-in-buddypress') . '</a>';
        array_push($links, $settings_link);

        return $links;
    }

    public function members_settings_fields($settings)
    {
        $members = [/* Members */
                    ['id'          => 'enable_members',
                     'label'       => __('Members', 'mass-messaging-in-buddypress'),
                     'description' => __('Allow mass messaging to members.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox',
                     'default'     => ''],

                    ['id'          => 'enable_all_members',
                     'description' => __('Allow the ability to select all members.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox',
                     'default'     => ''],

                    ['id'          => 'enable_show_all_members',
                     'description' => __('Show all members, not just friends.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox',
                     'default'     => ''],];

        $settings[ 'features' ][ 'fields' ] = array_merge($settings[ 'features' ][ 'fields' ], $members);

        return $settings;
    }

    public function groups_settings_fields($settings)
    {
        $groups = [/* Groups */
                   ['id'          => 'enable_groups',
                    'label'       => __('Groups', 'mass-messaging-in-buddypress'),
                    'description' => __('Allow mass messaging to groups.', 'mass-messaging-in-buddypress'),
                    'type'        => 'checkbox',
                    'default'     => ''],

                   ['id'          => 'enable_all_groups',
                    'description' => __('Allow the ability to select all groups.', 'mass-messaging-in-buddypress'),
                    'type'        => 'checkbox',
                    'default'     => ''],

                   ['id'          => 'enable_show_all_groups',
                    'description' => __('Show all groups, not just those with membership.', 'mass-messaging-in-buddypress'),
                    'type'        => 'checkbox',
                    'default'     => ''],];

        $settings[ 'features' ][ 'fields' ] = array_merge($settings[ 'features' ][ 'fields' ], $groups);

        return $settings;
    }

    public function multisite_settings_fields($settings)
    {
        $blogs = [/* Blogs */
                  ['id'          => 'enable_blogs',
                   'label'       => __('Blogs', 'mass-messaging-in-buddypress'),
                   'description' => __('Allow mass messaging to blogs.', 'mass-messaging-in-buddypress'),
                   'type'        => 'checkbox',
                   'default'     => ''],

                  ['id'          => 'enable_all_blogs',
                   'description' => __('Allow mass messaging to select all blogs.', 'mass-messaging-in-buddypress'),
                   'type'        => 'checkbox',
                   'default'     => ''],

                  ['id'          => 'enable_show_all_blogs',
                   'description' => __('Show all blogs, not just those with membership.', 'mass-messaging-in-buddypress'),
                   'type'        => 'checkbox',
                   'default'     => ''],];

        $settings[ 'features' ][ 'fields' ] = array_merge($settings[ 'features' ][ 'fields' ], $blogs);

        return $settings;
    }

    public function user_access_settings_fields($settings)
    {
        $capabilities = ['activate_plugins'  => 'Administrator (activate_plugins)',
                         'manage_categories' => 'Editor (manage_categories)',
                         'publish_posts'     => 'Author (publish_posts)',
                         'edit_posts'        => 'Contributor (edit_posts)',
                         'read'              => 'Subscriber (read)',];

        if ($this->site[ 'blogs' ]) {
            $capabilities = ['manage_network' => 'Super Admin (manage_network)'] + $capabilities;
        }

        $capabilities = ['' => 'No-One'] + $capabilities;

        $access = [/* User Access */
                   ['id'          => 'minimum_access',
                    'label'       => __('Minimum Access', 'mass-messaging-in-buddypress'),
                    'description' => __('Who can use mass messaging.', 'mass-messaging-in-buddypress'),
                    'type'        => 'select',
                    'options'     => $capabilities],

        ];

        if ($this->site[ 'groups' ]) {
            $groups = ['creator' => 'Group Creator',
                       'admins'  => 'Group Admins',
                       'mods'    => 'Group Mods',
                       'members' => 'Group Members',
                       'any'     => 'Anyone',];

            $access[] = ['id'          => 'groups_access',
                         'label'       => __('Minimum Groups Access', 'mass-messaging-in-buddypress'),
                         'description' => __('Who can use the groups messaging.', 'mass-messaging-in-buddypress'),
                         'type'        => 'select',
                         'options'     => $groups];
        }

        $settings[ 'access' ][ 'fields' ] = array_merge($settings[ 'access' ][ 'fields' ], $access);

        return $settings;
    }

    public function ordering_settings_fields($settings)
    {
        $access = [/* Ordering */
                   ['id'          => 'ordering_first',
                    'label'       => __('Ordering', 'mass-messaging-in-buddypress'),
                    'description' => '',
                    'type'        => 'hidden']];

        if ($this->site[ 'groups' ]) {
            $access[] = ['id'          => 'ordering_second',
                         'label'       => '',
                         'description' => '',
                         'type'        => 'hidden'];
        }

        if ($this->site[ 'blogs' ]) {
            $access[] = ['id'          => 'ordering_third',
                         'label'       => '',
                         'description' => '',
                         'type'        => 'hidden'];
        }

        $settings[ 'features' ][ 'fields' ] = array_merge($settings[ 'features' ][ 'fields' ], $access);

        return $settings;
    }

    public function messaging_settings_fields($settings)
    {
        $messaging = [/* Messaging */
                    ['id'          => 'read_count',
                     'label'       => __('Read Count', 'mass-messaging-in-buddypress'),
                     'description' => __('Show how many recipients have read the messages.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox'],

                      ['id'          => 'single_thread',
                     'label'       => __('Single Thread', 'mass-messaging-in-buddypress'),
                     'description' => __('Allow users to send messages as single thread.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox'],

                      ['id'          => 'disable_email',
                     'label'       => __('Disable Email', 'mass-messaging-in-buddypress'),
                     'description' => __('Allow users to disable sending emails for certain messages.', 'mass-messaging-in-buddypress'),
                     'type'        => 'checkbox']];

        $settings[ 'messaging' ][ 'fields' ] = array_merge($settings[ 'messaging' ][ 'fields' ], $messaging);

        return $settings;
    }

    public function register_settings()
    {
        if (is_array($this->settings)) {

            // Check posted/selected tab
            $current_section = '';
            if (isset($_POST[ 'tab' ]) && $_POST[ 'tab' ]) {
                $current_section = $_POST[ 'tab' ];
            } else {
                if (isset($_GET[ 'tab' ]) && $_GET[ 'tab' ]) {
                    $current_section = $_GET[ 'tab' ];
                }
            }

            foreach ($this->settings as $section => $data) {
                if ($current_section && $current_section != $section) {
                    continue;
                }

                // Add section to page
                add_settings_section($section, $data[ 'title' ], [$this,
                                                                  'settings_section'], $this->parent->_token . '_settings');

                foreach ($data[ 'fields' ] as $field) {

                    // Validation callback for field
                    $validation = '';
                    if (isset($field[ 'callback' ])) {
                        $validation = $field[ 'callback' ];
                    }

                    // Register field
                    $option_name = $this->base . $field[ 'id' ];
                    register_setting($this->parent->_token . '_settings', $option_name, $validation);

                    // Add field to page
                    $label = isset($field[ 'label' ]) ? $field[ 'label' ] : '';
                    add_settings_field($field[ 'id' ], $label, [$this->parent->admin,
                                                                'display_field'], $this->parent->_token . '_settings', $section, ['field'  => $field,
                                                                                                                                  'prefix' => $this->base]);
                }

                if (!$current_section) {
                    break;
                }
            }
        }
    }

    public function settings_section($section)
    {
        $html = '<p> ' . $this->settings[ $section[ 'id' ] ][ 'description' ] . '</p>' . "\n";
        echo $html;
    }

    public function settings_page()
    {
        // Build page HTML
        $html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
        $html .= '<h2>' . __('Mass Messaging in BuddyPress Options', 'mass-messaging-in-buddypress') . '</h2>' . "\n";

        $tab = '';
        if (isset($_GET[ 'tab' ]) && $_GET[ 'tab' ]) {
            $tab .= $_GET[ 'tab' ];
        }

        // Show page tabs
        if (is_array($this->settings) && 1 < count($this->settings)) {
            $html .= '<h2 class="nav-tab-wrapper">' . "\n";

            $c = 0;
            foreach ($this->settings as $section => $data) {

                // Set tab class
                $class = 'nav-tab';
                if (!isset($_GET[ 'tab' ])) {
                    if (0 == $c) {
                        $class .= ' nav-tab-active';
                    }
                } else {
                    if (isset($_GET[ 'tab' ]) && $section == $_GET[ 'tab' ]) {
                        $class .= ' nav-tab-active';
                    }
                }

                // Set tab link
                $tab_link = add_query_arg(['tab' => $section]);
                if (isset($_GET[ 'settings-updated' ])) {
                    $tab_link = remove_query_arg('settings-updated', $tab_link);
                }

                // Output tab
                $html .= '<a href="' . $tab_link . '" class="' . esc_attr($class) . '">' . esc_html($data[ 'title' ]) . '</a>' . "\n";
                ++$c;
            }
            $html .= '</h2>' . "\n";
        }

        $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

        // Get settings fields
        ob_start();
        settings_fields($this->parent->_token . '_settings');
        do_settings_sections($this->parent->_token . '_settings');
        $html .= ob_get_clean();

        if (empty($tab)) {
            $tab = current(array_keys($this->settings));
        }

        if (count($this->settings[ $tab ][ 'fields' ]) > 0) {
            $html .= '<p class="submit">' . "\n";
            $html .= '<input type="hidden" name="tab" value="' . esc_attr($tab) . '" />' . "\n";
            $html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr(__('Save Settings', 'mass-messaging-in-buddypress')) . '" />' . "\n";
            $html .= '</p>' . "\n";
        }

        $html .= '</form>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
    }

    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->parent->_version);
    }

    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->parent->_version);
    }
}

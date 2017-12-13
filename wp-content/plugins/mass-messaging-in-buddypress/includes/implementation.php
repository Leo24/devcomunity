<?php if (!defined('ABSPATH')) {
    exit;
}

/* TODO:
    - Threads
        Support more than 100 people in a single thread

    - Emailing
        Send emails if messaging not enabled

    - Groups
        Show mass messaging to group members on group (complements above)

    - Access
        Custom Role(s)
        User Meta
        Member Time
        s2member integration?

    - Searching
        Searching filters on frontend

    - Filters
        Filter which members / groups / blogs are displayed

    - Custom sections
        Setup custom message lists (dynamic)

    - History
        Mass reply and such like

    - Events
        Support for eventspress / events manager etc...
*/

class Mass_Messaging_in_BuddyPress_Implementation
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

        // Initialise menus
        add_action('init', [$this, 'setup_menus'], 1);
        add_action('init', [$this, 'init_implementation']);

        $this->content();
    }

    public function content()
    {
        add_action('wp_ajax_get_message_recipients', [$this, 'get_message_recipients']);
        add_action('wp_ajax_chunk_send_messages', [$this, 'chunk_send_messages']);

        $show_read = $this->parent->settings->get_option('read_count', 'checkbox');
        if ($show_read) {
            add_action('bp_before_message_thread_list', [$this, 'read_count']);
        }
    }

    public static function instance($parent)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
        }

        return self::$_instance;
    }

    public function setup_menus()
    {
        if ($this->can_access()) {
            add_action('admin_bar_menu', [$this, 'setup_wordpress_navigation'], 100);
            add_action('bp_setup_nav', [$this, 'setup_buddypress_navigation']);
        }
    }

    public function can_access()
    {
        $minimum = $this->parent->settings->get_option('minimum_access', 'select');
        $access  = !empty($minimum) && current_user_can($minimum);

        return apply_filters($this->parent->_token . '_can_access', $access);
    }

    public function init_implementation()
    {
        $features   = [];
        $features[] = $this->parent->settings->get_option('ordering_first', 'text');
        $features[] = $this->parent->settings->get_option('ordering_second', 'text');
        $features[] = $this->parent->settings->get_option('ordering_third', 'text');
        $features   = array_unique($features);

        $position = (array_search('members', $features) + 1) * 10;
        add_action($this->parent->_token . '_members_action', [$this, 'members_action'], $position, 3);

        if ($this->parent->settings->site[ 'groups' ]) {
            $position = (array_search('groups', $features) + 1) * 10;
            add_action($this->parent->_token . '_groups_action', [$this, 'groups_action'], $position, 3);
        }

        if ($this->parent->settings->site[ 'blogs' ]) {
            $position = (array_search('blogs', $features) + 1) * 10;
            add_action($this->parent->_token . '_blogs_action', [$this, 'blogs_action'], $position, 3);
        }
    }

    public function setup_wordpress_navigation($wp_admin_nav)
    {
        global $bp;

        $parent      = 'messages';
        $user_domain = $bp->loggedin_user->domain;
        $parent_slug = $bp->{$parent}->slug;
        $link        = trailingslashit($user_domain . $parent_slug);

        $menu = ['name'      => 'Mass Messaging',
                 'slug'      => 'mass-messaging',
                 'parent_id' => $parent,
                 'link'      => $link,];
        $this->parent->wordpress->add_subnav_item($wp_admin_nav, $menu);
    }

    public function setup_buddypress_navigation()
    {
        global $bp;

        $parent      = 'messages';
        $user_domain = $bp->loggedin_user->domain;
        $parent_slug = $bp->{$parent}->slug;
        $link        = trailingslashit($user_domain . $parent_slug);

        $menu = ['name'        => 'Mass Messaging',
                 'slug'        => 'mass-messaging',
                 'link'        => $link,
                 'parent_slug' => $parent,
                 'screen'      => [$this, 'mass_messaging_screen'],
                 'position'    => 90];

        $this->parent->buddypress->add_subnav_item($menu);
    }

    public function mass_messaging_screen()
    {
        add_action('bp_template_title', [$this, 'mass_messaging_page_screen_title']);
        add_action('bp_template_content', [$this, 'mass_messaging_page_screen_content']);
        bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
    }

    public function mass_messaging_page_screen_title()
    {
        return 'Mass Messaging';
    }

    public function mass_messaging_page_screen_content()
    {
        global $bp;

        $user     = $bp->loggedin_user->id;
        $allClass = $this->base . 'select_all';
        $divClass = $this->base . 'list_';

        $features   = [];
        $features[] = $this->parent->settings->get_option('ordering_first', 'text');
        $features[] = $this->parent->settings->get_option('ordering_second', 'text');
        $features[] = $this->parent->settings->get_option('ordering_third', 'text');
        $features   = array_unique($features); ?>
		<div id="send_message_notice"></div>
		<div id="send_message_form" class="standard-form <?php echo $this->parent->_token; ?>">
			<label for="subject" class="subject">Subject</label>
			<input type="text" name="subject" id="subject" value=""/>

			<label for="content" class="content">Message</label>
			<textarea name="content" id="message_content" rows="15" cols="50"></textarea>
			<div id="<?php echo $this->base; ?>checkboxes">
				<?php
                foreach ($features as $feature) {
                    do_action($this->parent->_token . '_' . $feature . '_action', $user, $allClass, $divClass);
                } ?>
				<br/>
				<?php if ($this->parent->settings->get_option('single_thread', 'checkbox')) {
                    ?>
				<label><input type="checkbox" id="thread" name="thread" class="thread" value="1"> Send as single thread?<br/>
					<?php

                } ?>
				<?php if ($this->parent->settings->get_option('disable_email', 'checkbox')) {
                    ?>
				<label><input type="checkbox" id="noemail" name="noemail" class="noemail" value="1"> Disable emails for this message?<br/>
					<?php

                } ?>
			</div>
			<input type="button" value="Send Message &rarr;" name="<?php echo $this->base . 'submit'; ?>" id="send"/>
		</div>
		<div id="send_message_progress"></div>
		<?php

    }

    public function members_action($user, $allClass, $divClass)
    {
        $enable_members = $this->parent->settings->get_option('enable_members', 'checkbox');
        if ($enable_members) {
            $select_all_members = $this->parent->settings->get_option('enable_all_members', 'checkbox');
            $show_all_members   = $this->parent->settings->get_option('enable_show_all_members', 'checkbox');

            echo '<h3>Users</h3>';

            $members_filter = ['per_page' => 99999, 'type' => 'alphabetical', 'exclude' => $user];
            if (!$show_all_members) {
                $members_filter[ 'user_id' ] = $user;
            }

            echo '<div id="' . $divClass . 'members" class="' . $divClass . 'scroll">';
            if ($select_all_members) {
                echo '<label class="' . $allClass . '"><input type="checkbox" name="all_members" value="ignore"> Select All Users</label>';
            }

            if (bp_has_members($members_filter)) {
                while (bp_members()) {
                    bp_the_member();
                    echo '<label><input type="checkbox" name="members[]" value="' . bp_get_member_user_id() . '"> ' . bp_get_member_name() . '</label>';
                }
            }
            echo '</div>';
        }
    }

    public function groups_action($user, $allClass, $divClass)
    {
        $enable_groups = $this->parent->settings->site[ 'groups' ] && $this->parent->settings->get_option('enable_groups', 'checkbox');
        if ($enable_groups) {
            $select_all_groups = $this->parent->settings->get_option('enable_all_groups', 'checkbox');
            $show_all_groups   = $this->parent->settings->get_option('enable_show_all_groups', 'checkbox');
            $filter_groups     = $this->parent->settings->get_option('groups_access', 'select');

            echo '<h3>Groups</h3>';

            $groupsFilter = ['per_page' => 99999, 'type' => 'alphabetical', 'show_hidden' => true];
            if ($show_all_groups && $filter_groups === 'any') {
                $groupsFilter[ 'user_id' ] = null;
            } else {
                $groupsFilter[ 'user_id' ] = $user;
            }

            echo '<div id="' . $divClass . 'groups" class="' . $divClass . 'scroll">';
            if ($select_all_groups) {
                echo '<label class="' . $allClass . '"><input type="checkbox" name="all_groups" value="ignore"> Select All Groups</label>';
            }

            if (bp_has_groups($groupsFilter)) {
                while (bp_groups()) {
                    bp_the_group();

                    switch ($filter_groups) {
                        case 'mods':
                            if (!bp_group_is_mod()) {
                                continue;
                            }
                        case 'admins':
                            if (!bp_group_is_admin()) {
                                continue;
                            }
                        case 'creator':
                            if (!bp_is_group_creator()) {
                                continue;
                            }
                    }

                    echo '<label><input type="checkbox" name="groups[]" value="' . bp_get_group_id() . '"> ' . bp_get_group_name() . '</label>';
                }
            }
            echo '</div>';
        }
    }

    public function blogs_action($user, $allClass, $divClass)
    {
        $enable_blogs = $this->parent->settings->site[ 'blogs' ] && $this->parent->settings->get_option('enable_blogs', 'checkbox');
        if ($enable_blogs) {
            $select_all_blogs = $this->parent->settings->get_option('enable_all_blogs', 'checkbox');
            $show_all_blogs   = $this->parent->settings->get_option('enable_show_all_blogs', 'checkbox');

            echo '<h3>Blogs</h3>';

            $blogs_filter = ['per_page' => 99999, 'type' => 'alphabetical'];

            if ($show_all_blogs) {
                $blogs_filter[ 'user_id' ] = false;
            } else {
                $blogs_filter[ 'user_id' ] = $user;
            }

            echo '<div id="' . $divClass . 'blogs" class="' . $divClass . 'scroll">';
            if ($select_all_blogs) {
                echo '<label class="' . $allClass . '"><input type="checkbox" name="all_blogs" value="ignore"> Select All Blogs</label>';
            }

            if (bp_has_blogs($blogs_filter)) {
                while (bp_blogs()) {
                    bp_the_blog();
                    echo '<label><input type="checkbox" name="blogs[]" value="' . bp_get_blog_id() . '"> ' . bp_get_blog_name() . '</label>';
                }
            }
            echo '</div>';
        }
    }

    public function read_count()
    {
        global $thread_template;

        $thread = $thread_template->thread;

        $userId = bp_loggedin_user_id();

        // Show to sender only
        if ((int) $thread->messages[ 0 ]->sender_id == $userId) {
            $total = 0;
            $read  = 0;
            foreach ($thread->recipients as $recipient) {
                $id     = (int) $recipient->user_id;
                $unread = (int) $recipient->unread_count;

                if ($id != $userId) {
                    if ($unread == 0) {
                        $read++;
                    }
                    $total++;
                }
            }

            echo '<p id="' . $this->parent->_token . '_read_count' . '"><span class="highlight">Read By: ' . $read . '/' . $total . '</span></p>';
        }
    }

    public function get_message_recipients()
    {
        global $bp, $wpdb;

        $result = ['success' => true];

        $members = [];

        if (isset($_POST[ 'groups' ])) {
            $groups = [];
            foreach ($_POST[ 'groups' ] as $group) {
                $groups[] = (int) $group;
            }
            $query   = $wpdb->get_col("SELECT `user_id` FROM `{$bp->groups->table_name_members}` WHERE `group_id` IN (" . implode(',', $groups) . ") AND is_confirmed = 1 AND is_banned = 0");
            $members = array_merge($members, $query);
        }

        if (isset($_POST[ 'blogs' ])) {
            $blogs = [];
            foreach ($_POST[ 'blogs' ] as $blog) {
                $blogs[] = (int) $blog;
            }
            $query   = $wpdb->get_col("SELECT `user_id` FROM `{$bp->blogs->table_name}` WHERE `blog_id` IN (" . implode(',', $blogs) . ")");
            $members = array_merge($members, $query);
        }

        $members = array_map('intval', $members);
        $members = array_values($members);

        $result[ 'members' ] = $members;

        echo json_encode($result);
        wp_die();
    }

    public function chunk_send_messages()
    {
        global $bp;

        $result = [];

        $subject = $_POST[ 'subject' ];
        $content = $_POST[ 'content' ];
        $thread  = $this->parent->settings->get_option('single_thread', 'checkbox') && $_POST[ 'thread' ] === "true";
        $noemail = $this->parent->settings->get_option('disable_email', 'checkbox') && $_POST[ 'noemail' ] === "true";
        $members = $_POST[ 'members' ];

        $result[ 'success' ] = true;

        if ($noemail) {
            remove_action('messages_message_sent', 'messages_notification_new_message', 10);
        }

        $sender = $bp->loggedin_user->id;
        if ($members != null) {
            if ($thread) {
                messages_new_message(['sender_id'  => $sender,
                                      'subject'    => $subject,
                                      'content'    => $content,
                                      'recipients' => $members]);
            } else {
                foreach ($members as $member) {
                    messages_new_message(['sender_id'  => $sender,
                                          'subject'    => $subject,
                                          'content'    => $content,
                                          'recipients' => $member]);
                }
            }
        } else {
            $result[ 'success' ] = false;
        }

        echo json_encode($result);
        wp_die();
    }

    public function users_to_id($user)
    {
        return $user->data->ID;
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

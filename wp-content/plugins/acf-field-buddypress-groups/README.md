# ACF Buddypress Groups Field

Welcome to the Advanced Custom Fields Buddypress Groups field.

-----------------------

### Description

This plugin provides a Buddypress Groups field for Advanced Custom Fields. The field can be configured to display all groups or only groups of which the active user is a member. You can choose to return the Group ID(s) or Group object(s).

### Compatibility

This ACF field type is compatible with:
* ACF 5
* ACF 4

### Installation

1. Copy the `acf-buddypress_groups` folder into your `wp-content/plugins` folder
2. Activate the Buddypress Groups plugin via the plugins admin page
3. Create a new field via ACF and select the Buddypress Groups type
4. Please refer to the description for more info regarding the field type settings

### Template Usage

**NOTE** Only use 'the_field' if **Return Format** == 'Group ID'. In general I wouldn't suggest using 'the_field' for this ACF field

---


+ **Select multiple values?** == 'no' AND **Return Format** == 'Group ID'

    *Returns a single Buddypress Group ID*

        $group_id = get_field( 'your_field_name' );
        $group = groups_get_group( array( 'group_id' => $group_id ) );
        echo $group->name;

---

+ **Select multiple values?** == 'no' AND **Return Format** == 'Group Object'

    *Returns a single instance of a Buddypress Group Object*

        $group = get_field( 'your_field_name' );
        echo $group->name;

---

+ **Select multiple values?** == 'yes' AND **Return Format** == 'Group ID'

    *Returns an array of Buddypress Group IDs*

        $group_ids = get_field( 'your_field_name' );
        $groups = groups_get_groups( array( 'include' => $group_ids ) );
        $groups = $groups['groups'];
        if ( $groups ): ?>
            <ul>
            <?php foreach( $groups as $group ): ?>
                <li>
                    <?php echo $group->name; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

---

+ **Select multiple values?** == 'yes' AND **Return Format** == 'Group Object'

    *Returns an array of Buddypress Group Objects*

        $groups = get_field( 'your_field_name' );
        if ( $groups ): ?>
            <ul>
            <?php foreach( $groups as $group ): ?>
                <li>
                    <?php echo $group->name; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>


### Debug

To see what is being returned by the field:

    <?php
    $groups = get_field( 'your_field_name' );
    <pre>
    print_r( $groups );
    </pre>
    ?>

### Changelog
Please see `readme.txt` for changelog

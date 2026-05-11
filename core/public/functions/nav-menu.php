<?php
/**
 * Navigation Menu Functionality
 */

/**
 * Add custom fields to menu items
 */
add_action('wp_nav_menu_item_custom_fields', 'sublimeplus_menu_item_custom_fields', 10, 4);
function sublimeplus_menu_item_custom_fields($item_id, $item, $depth, $args) {
    $icon = get_post_meta($item_id, '_menu_item_icon', true);
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e('Icon', 'sublimeplus'); ?><br />
            <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr($icon); ?>" placeholder="Font Awesome class, SVG code, or image URL" />
            <button type="button" class="button upload-icon-button" data-item-id="<?php echo $item_id; ?>"><?php _e('Select from Media Library', 'sublimeplus'); ?></button>
        </label>
    </p>
    <?php
}

/**
 * Save custom fields
 */
add_action('wp_update_nav_menu_item', 'sublimeplus_update_menu_item', 10, 3);
function sublimeplus_update_menu_item($menu_id, $menu_item_db_id, $args) {
    if (isset($_REQUEST['menu-item-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon', sanitize_text_field($_REQUEST['menu-item-icon'][$menu_item_db_id]));
    }
}

/**
 * @return object|string
 */
function Sublimeplus_get_walker_nav_menu()
{
    $theme_settings = get_option(Sublimeplus_SETTINGS_KEY, true);

    if (!empty($theme_settings['enable_builtin_mega_menu'])) {
        return new Sublimeplus_Mega_Menu_Walker();
    }

    return '';
}

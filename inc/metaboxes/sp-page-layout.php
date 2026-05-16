<?php
/**
 * Page Layout meta box — sidebar position per page.
 * Native WP meta box, no plugin dependency.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'sp_page_layout',
        __('Page Layout', 'sublimeplus'),
        'sp_page_layout_cb',
        'page',
        'side',
        'default'
    );
});

function sp_page_layout_cb($post) {
    wp_nonce_field('sp_page_layout_save', 'sp_page_layout_nonce');
    $sidebar = get_post_meta($post->ID, '_sp_page_sidebar', true);
    if ($sidebar === false || $sidebar === null) {
        $sidebar = 'inherit';
    }
    ?>
    <p style="margin:0 0 5px;font-weight:600;font-size:12px;color:#1d2327;">
        <?= esc_html__('Sidebar Position', 'sublimeplus') ?>
    </p>
    <select name="sp_page_sidebar" style="width:100%;">
        <option value="inherit" <?php selected($sidebar, 'inherit'); ?>>
            <?= esc_html__('Default (from Customizer)', 'sublimeplus') ?>
        </option>
        <option value="" <?php selected($sidebar, ''); ?>>
            <?= esc_html__('None — Full Width', 'sublimeplus') ?>
        </option>
        <option value="right" <?php selected($sidebar, 'right'); ?>>
            <?= esc_html__('Right Sidebar', 'sublimeplus') ?>
        </option>
        <option value="left" <?php selected($sidebar, 'left'); ?>>
            <?= esc_html__('Left Sidebar', 'sublimeplus') ?>
        </option>
    </select>
    <p style="margin:5px 0 0;color:#6b7280;font-size:11px;line-height:1.5;">
        <?= esc_html__('Overrides the global Customizer setting for this page only.', 'sublimeplus') ?>
    </p>
    <?php
}

add_action('save_post_page', function ($post_id) {
    if (
        !isset($_POST['sp_page_layout_nonce']) ||
        !wp_verify_nonce($_POST['sp_page_layout_nonce'], 'sp_page_layout_save') ||
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        !current_user_can('edit_page', $post_id)
    ) {
        return;
    }

    $allowed = ['inherit', '', 'left', 'right'];
    $val     = isset($_POST['sp_page_sidebar']) ? sanitize_text_field($_POST['sp_page_sidebar']) : 'inherit';

    if (!in_array($val, $allowed, true)) {
        $val = 'inherit';
    }

    update_post_meta($post_id, '_sp_page_sidebar', $val);
});

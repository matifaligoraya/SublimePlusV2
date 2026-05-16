<?php
/**
 * Supply Item metabox — icon key + custom link URL
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'sp_supply_details',
        __('Supply Card Details', 'sublimeplus'),
        '_sp_supply_metabox_render',
        'sp_supply',
        'normal',
        'high'
    );
});

function _sp_supply_metabox_render(WP_Post $post): void {
    wp_nonce_field('sp_supply_save', 'sp_supply_nonce');

    $icon = get_post_meta($post->ID, '_sp_supply_icon', true) ?: 'stock';
    $link = get_post_meta($post->ID, '_sp_supply_link', true);

    $icons = [
        'stock'   => 'Stock / Inventory',
        'truck'   => 'Truck / Delivery',
        'docs'    => 'Documents / Compliance',
        'mould'   => 'Moulds / Layers',
        'support' => 'Site Support / People',
        'lab'     => 'Lab / Flask',
    ];
    ?>
    <table class="form-table" style="margin-top:0">
      <tr>
        <th><label for="sp_supply_icon"><?php _e('Icon', 'sublimeplus'); ?></label></th>
        <td>
          <select name="sp_supply_icon" id="sp_supply_icon" style="min-width:260px">
            <?php foreach ($icons as $key => $label) : ?>
            <option value="<?php echo esc_attr($key); ?>"<?php selected($icon, $key); ?>><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
          </select>
          <p class="description"><?php _e('SVG icon shown on the card.', 'sublimeplus'); ?></p>
        </td>
      </tr>
      <tr>
        <th><label for="sp_supply_link"><?php _e('Card Link URL', 'sublimeplus'); ?></label></th>
        <td>
          <input type="url" name="sp_supply_link" id="sp_supply_link"
                 value="<?php echo esc_attr($link); ?>"
                 class="regular-text"
                 placeholder="https://example.com/products/">
          <p class="description"><?php _e('Where clicking the card goes. Leave blank to link to the Products archive.', 'sublimeplus'); ?></p>
        </td>
      </tr>
      <tr>
        <th><?php _e('Display Order', 'sublimeplus'); ?></th>
        <td>
          <p class="description"><?php _e('Use the "Order" field in the Page Attributes box (right sidebar) to set sort order.', 'sublimeplus'); ?></p>
        </td>
      </tr>
    </table>
    <?php
}

add_action('save_post_sp_supply', function (int $post_id): void {
    if (!isset($_POST['sp_supply_nonce']) || !wp_verify_nonce($_POST['sp_supply_nonce'], 'sp_supply_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $allowed_icons = ['stock', 'truck', 'docs', 'mould', 'support', 'lab'];
    $icon = in_array($_POST['sp_supply_icon'] ?? '', $allowed_icons, true)
        ? $_POST['sp_supply_icon']
        : 'stock';
    update_post_meta($post_id, '_sp_supply_icon', $icon);

    $link = isset($_POST['sp_supply_link']) ? esc_url_raw($_POST['sp_supply_link']) : '';
    update_post_meta($post_id, '_sp_supply_link', $link);
});

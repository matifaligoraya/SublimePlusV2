<?php
/**
 * Meta box for sp_project CPT.
 * Fields: client, emirate, status, completion date, scale/volume,
 *         project value, related products, gallery images.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('add_meta_boxes',         'sp_project_add_meta_boxes');
add_action('save_post_sp_project',   'sp_project_save_meta', 10, 2);
add_action('admin_enqueue_scripts',  'sp_project_admin_scripts');

function sp_project_admin_scripts($hook) {
    global $post;
    if (!in_array($hook, ['post-new.php', 'post.php'], true)) return;
    if (!isset($post->post_type) || $post->post_type !== 'sp_project') return;
    wp_enqueue_media();
}

function sp_project_add_meta_boxes() {
    add_meta_box(
        'sp_project_details',
        __('Project Details', 'sublimeplus'),
        'sp_project_details_cb',
        'sp_project',
        'normal',
        'high'
    );
    add_meta_box(
        'sp_project_gallery',
        __('Project Gallery', 'sublimeplus'),
        'sp_project_gallery_cb',
        'sp_project',
        'normal',
        'default'
    );
}

// ── Details meta box ──────────────────────────────────────────────────────────

function sp_project_details_cb($post) {
    wp_nonce_field('sp_project_meta_save', 'sp_project_nonce');

    $client        = get_post_meta($post->ID, '_sp_project_client',      true);
    $emirate       = get_post_meta($post->ID, '_sp_project_emirate',     true);
    $status        = get_post_meta($post->ID, '_sp_project_status',      true) ?: 'completed';
    $date          = get_post_meta($post->ID, '_sp_project_date',        true);
    $scale         = get_post_meta($post->ID, '_sp_project_scale',       true);
    $value         = get_post_meta($post->ID, '_sp_project_value',       true);
    $products_raw  = get_post_meta($post->ID, '_sp_project_products',    true);
    $related_ids   = $products_raw ? json_decode($products_raw, true) : [];
    if (!is_array($related_ids)) $related_ids = [];

    $all_products = get_posts([
        'post_type'      => 'sp_product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $emirates = [
        'dubai'          => 'Dubai',
        'abu-dhabi'      => 'Abu Dhabi',
        'sharjah'        => 'Sharjah',
        'ajman'          => 'Ajman',
        'ras-al-khaimah' => 'Ras Al Khaimah',
        'fujairah'       => 'Fujairah',
        'western-region' => 'Western Region (Abu Dhabi)',
        'uae'            => 'UAE Nationwide',
    ];
    ?>
    <style>
        .sp-prj-wrap { display: grid; grid-template-columns: 170px 1fr; gap: 0; }
        .sp-prj-wrap .sp-label { font-weight: 600; color: #1e293b; padding: 10px 12px 10px 0; font-size: 13px; align-self: center; }
        .sp-prj-wrap .sp-field { padding: 7px 0; border-bottom: 1px solid #f1f5f9; }
        .sp-prj-wrap .sp-field:last-child { border-bottom: none; }
        .sp-prj-wrap input[type="text"], .sp-prj-wrap input[type="date"], .sp-prj-wrap select { width: 100%; }
        .sp-prj-wrap input[type="text"], .sp-prj-wrap input[type="date"] { padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; }
        .sp-hint { font-size: 12px; color: #64748b; margin: .2rem 0 0; }
        .sp-products-list { display: flex; flex-wrap: wrap; gap: .4rem; max-height: 160px; overflow-y: auto; padding: 6px 0; }
        .sp-products-list label { display: flex; align-items: center; gap: .35rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: .28rem .7rem; font-size: 13px; cursor: pointer; transition: border-color .15s; }
        .sp-products-list label:hover { border-color: #264653; }
        .sp-products-list input[type="checkbox"]:checked + span { font-weight: 600; color: #264653; }
    </style>

    <div class="sp-prj-wrap">

        <!-- Client -->
        <div class="sp-label"><?php _e('Client / Developer', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_project_client" value="<?php echo esc_attr($client); ?>"
                   placeholder="<?php esc_attr_e('e.g. RTA Dubai', 'sublimeplus'); ?>">
        </div>

        <!-- Emirate -->
        <div class="sp-label"><?php _e('Emirate / Location', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <select name="sp_project_emirate">
                <option value=""><?php _e('— Select Emirate —', 'sublimeplus'); ?></option>
                <?php foreach ($emirates as $key => $label) : ?>
                <option value="<?php echo esc_attr($key); ?>"<?php selected($emirate, $key); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Status -->
        <div class="sp-label"><?php _e('Project Status', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <select name="sp_project_status">
                <option value="completed"<?php selected($status, 'completed'); ?>><?php _e('Completed', 'sublimeplus'); ?></option>
                <option value="ongoing"<?php selected($status, 'ongoing'); ?>><?php _e('Ongoing', 'sublimeplus'); ?></option>
                <option value="upcoming"<?php selected($status, 'upcoming'); ?>><?php _e('Upcoming', 'sublimeplus'); ?></option>
            </select>
        </div>

        <!-- Completion Date -->
        <div class="sp-label"><?php _e('Completion Date', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="date" name="sp_project_date" value="<?php echo esc_attr($date); ?>">
        </div>

        <!-- Scale / Volume -->
        <div class="sp-label"><?php _e('Scale / Volume', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_project_scale" value="<?php echo esc_attr($scale); ?>"
                   placeholder="<?php esc_attr_e('e.g. 2,500 Barriers', 'sublimeplus'); ?>">
            <p class="sp-hint"><?php _e('Shown as a stat on the project card.', 'sublimeplus'); ?></p>
        </div>

        <!-- Project Value -->
        <div class="sp-label"><?php _e('Project Value', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_project_value" value="<?php echo esc_attr($value); ?>"
                   placeholder="<?php esc_attr_e('e.g. AED 1.2M', 'sublimeplus'); ?>">
        </div>

        <!-- Related Products -->
        <div class="sp-label"><?php _e('Products Used', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <?php if ($all_products) : ?>
            <div class="sp-products-list">
                <?php foreach ($all_products as $prod) : ?>
                <label>
                    <input type="checkbox" name="sp_project_products[]" value="<?php echo esc_attr($prod->ID); ?>"<?php checked(in_array($prod->ID, $related_ids, true)); ?>>
                    <span><?php echo esc_html($prod->post_title); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <p class="sp-hint"><?php _e('Tick all products supplied for this project.', 'sublimeplus'); ?></p>
            <?php else : ?>
            <p class="sp-hint"><?php _e('No products found. Add products under Products → Add Product first.', 'sublimeplus'); ?></p>
            <?php endif; ?>
        </div>

    </div>
    <?php
}

// ── Gallery meta box ──────────────────────────────────────────────────────────

function sp_project_gallery_cb($post) {
    $gallery_ids = get_post_meta($post->ID, '_sp_project_gallery', true);
    if (!is_array($gallery_ids)) $gallery_ids = [];
    ?>
    <style>
        .sp-gallery-wrap { padding: 6px 0; }
        .sp-gallery-thumbs { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: .75rem; }
        .sp-gallery-thumbs .sp-gal-item {
            position: relative; width: 80px; height: 80px; border-radius: 6px; overflow: hidden;
            border: 1px solid #e2e8f0; cursor: move;
        }
        .sp-gallery-thumbs .sp-gal-item img { width: 100%; height: 100%; object-fit: cover; }
        .sp-gallery-thumbs .sp-gal-remove {
            position: absolute; top: 2px; right: 2px; width: 18px; height: 18px; background: rgba(0,0,0,.7);
            color: #fff; border: none; border-radius: 50%; cursor: pointer; font-size: 11px; line-height: 18px; text-align: center; padding: 0;
        }
        #sp-gallery-preview { min-height: 20px; }
    </style>

    <div class="sp-gallery-wrap">
        <input type="hidden" id="sp_project_gallery" name="sp_project_gallery" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">

        <div class="sp-gallery-thumbs" id="sp-gallery-preview">
            <?php foreach ($gallery_ids as $img_id) :
                $url = wp_get_attachment_image_url((int) $img_id, 'thumbnail');
                if (!$url) continue;
            ?>
            <div class="sp-gal-item" data-id="<?php echo esc_attr($img_id); ?>">
                <img src="<?php echo esc_url($url); ?>" alt="">
                <button type="button" class="sp-gal-remove" title="<?php esc_attr_e('Remove', 'sublimeplus'); ?>">×</button>
            </div>
            <?php endforeach; ?>
        </div>

        <button type="button" class="button" id="sp-gallery-add"><?php _e('Add / Edit Gallery Images', 'sublimeplus'); ?></button>
        <p style="font-size:12px;color:#64748b;margin:.4rem 0 0;"><?php _e('These images appear in the project detail page. Featured Image is shown on archive/home cards.', 'sublimeplus'); ?></p>
    </div>

    <script>
    (function($) {
        var frame;

        function refreshField() {
            var ids = [];
            $('#sp-gallery-preview .sp-gal-item').each(function() {
                ids.push($(this).data('id'));
            });
            $('#sp_project_gallery').val(ids.join(','));
        }

        $('#sp-gallery-add').on('click', function(e) {
            e.preventDefault();
            if (!frame) {
                frame = wp.media({
                    title: '<?php echo esc_js(__('Select Gallery Images', 'sublimeplus')); ?>',
                    button: { text: '<?php echo esc_js(__('Add to Gallery', 'sublimeplus')); ?>' },
                    multiple: true
                });
                frame.on('select', function() {
                    frame.state().get('selection').each(function(att) {
                        var id  = att.get('id');
                        var url = att.get('sizes') && att.get('sizes').thumbnail ? att.get('sizes').thumbnail.url : att.get('url');
                        $('#sp-gallery-preview').append(
                            '<div class="sp-gal-item" data-id="' + id + '">' +
                            '<img src="' + url + '" alt="">' +
                            '<button type="button" class="sp-gal-remove">×</button>' +
                            '</div>'
                        );
                    });
                    refreshField();
                });
            }
            frame.open();
        });

        $(document).on('click', '.sp-gal-remove', function() {
            $(this).closest('.sp-gal-item').remove();
            refreshField();
        });
    })(jQuery);
    </script>
    <?php
}

// ── Save ──────────────────────────────────────────────────────────────────────

function sp_project_save_meta($post_id) {
    if (!isset($_POST['sp_project_nonce']) || !wp_verify_nonce($_POST['sp_project_nonce'], 'sp_project_meta_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Text / select fields
    $text_fields = [
        '_sp_project_client'  => 'sp_project_client',
        '_sp_project_emirate' => 'sp_project_emirate',
        '_sp_project_status'  => 'sp_project_status',
        '_sp_project_date'    => 'sp_project_date',
        '_sp_project_scale'   => 'sp_project_scale',
        '_sp_project_value'   => 'sp_project_value',
    ];
    foreach ($text_fields as $meta_key => $post_key) {
        $val = sanitize_text_field($_POST[$post_key] ?? '');
        $val ? update_post_meta($post_id, $meta_key, $val)
             : delete_post_meta($post_id, $meta_key);
    }

    // Related products (array of IDs)
    $product_ids = array_map('absint', (array) ($_POST['sp_project_products'] ?? []));
    $product_ids = array_filter($product_ids);
    update_post_meta($post_id, '_sp_project_products', wp_json_encode(array_values($product_ids)));

    // Gallery (comma-separated IDs)
    $gallery_raw = sanitize_text_field($_POST['sp_project_gallery'] ?? '');
    $gallery_ids = array_filter(array_map('absint', explode(',', $gallery_raw)));
    update_post_meta($post_id, '_sp_project_gallery', array_values($gallery_ids));
}

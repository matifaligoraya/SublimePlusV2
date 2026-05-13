<?php
/**
 * Product meta box — icon, specs table, certifications, material,
 * finish, datasheet PDF, and gallery for the sp_product CPT.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('add_meta_boxes', 'sp_product_add_meta_boxes');
add_action('save_post_sp_product', 'sp_product_save_meta', 10, 2);
add_action('admin_enqueue_scripts', 'sp_product_admin_scripts');

function sp_product_admin_scripts($hook) {
    global $post;
    if (($hook === 'post-new.php' || $hook === 'post.php') && isset($post->post_type) && $post->post_type === 'sp_product') {
        wp_enqueue_media();
    }
}

function sp_product_add_meta_boxes() {
    add_meta_box(
        'sp_product_details',
        __('Product Details', 'sublimeplus'),
        'sp_product_details_cb',
        'sp_product',
        'normal',
        'high'
    );
}

function sp_product_details_cb($post) {
    wp_nonce_field('sp_product_meta_save', 'sp_product_nonce');

    $icon_id        = (int) get_post_meta($post->ID, '_sp_product_icon',           true);
    $certifications = get_post_meta($post->ID, '_sp_product_certifications', true);
    $material       = get_post_meta($post->ID, '_sp_product_material',       true);
    $finish         = get_post_meta($post->ID, '_sp_product_finish',         true);
    $datasheet_id   = (int) get_post_meta($post->ID, '_sp_product_datasheet',      true);
    $gallery_raw    = get_post_meta($post->ID, '_sp_product_gallery',        true);
    $specs_raw      = get_post_meta($post->ID, '_sp_product_specs',          true);
    $specs          = $specs_raw ? json_decode($specs_raw, true) : [];

    $icon_url      = $icon_id      ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
    $datasheet_url = $datasheet_id ? wp_get_attachment_url($datasheet_id)               : '';
    $gallery_ids   = $gallery_raw  ? array_filter(array_map('absint', explode(',', $gallery_raw))) : [];
    ?>
    <style>
        .sp-meta-wrap { display: grid; grid-template-columns: 160px 1fr; gap: 0; }
        .sp-meta-wrap .sp-label { font-weight: 600; color: #1e293b; padding: 10px 12px 10px 0; font-size: 13px; }
        .sp-meta-wrap .sp-field { padding: 6px 0; border-bottom: 1px solid #f1f5f9; }
        .sp-meta-wrap .sp-field:last-of-type { border-bottom: none; }
        .sp-meta-wrap input[type="text"] { width: 100%; }
        .sp-thumb-preview { max-height: 64px; margin-top: 6px; border-radius: 6px; display: block; }
        .sp-gallery-preview { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .sp-gallery-preview img { width: 64px; height: 64px; object-fit: cover; border-radius: 6px; }
        .sp-specs-section { margin-top: 20px; padding-top: 16px; border-top: 2px solid #e2e8f0; }
        .sp-spec-row { display: flex; gap: 8px; margin-bottom: 6px; align-items: center; }
        .sp-spec-row input { flex: 1; }
        .sp-spec-row .sp-del { width: 28px; height: 28px; background: #ef4444; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 18px; line-height: 1; flex-shrink: 0; }
    </style>

    <div class="sp-meta-wrap">

        <!-- Icon -->
        <div class="sp-label"><?php _e('Icon Image', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="hidden" name="sp_product_icon" id="sp_product_icon" value="<?php echo esc_attr($icon_id ?: ''); ?>">
            <button type="button" class="button" id="sp-icon-btn"><?php _e('Select Icon', 'sublimeplus'); ?></button>
            <button type="button" class="button" id="sp-icon-clear"<?php echo $icon_id ? '' : ' style="display:none"'; ?>><?php _e('Remove', 'sublimeplus'); ?></button>
            <div id="sp-icon-preview"><?php if ($icon_url) : ?><img src="<?php echo esc_url($icon_url); ?>" class="sp-thumb-preview"><?php endif; ?></div>
        </div>

        <!-- Certifications -->
        <div class="sp-label"><?php _e('Certifications', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_product_certifications" value="<?php echo esc_attr($certifications); ?>" placeholder="<?php esc_attr_e('e.g. RTA Approved, ISO 9001:2015, ICV', 'sublimeplus'); ?>">
        </div>

        <!-- Material -->
        <div class="sp-label"><?php _e('Material Grade', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_product_material" value="<?php echo esc_attr($material); ?>" placeholder="<?php esc_attr_e('e.g. C30 Grade Concrete', 'sublimeplus'); ?>">
        </div>

        <!-- Finish -->
        <div class="sp-label"><?php _e('Finish', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_product_finish" value="<?php echo esc_attr($finish); ?>" placeholder="<?php esc_attr_e('e.g. As-cast concrete finish', 'sublimeplus'); ?>">
        </div>

        <!-- Datasheet PDF -->
        <div class="sp-label"><?php _e('Datasheet (PDF)', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="hidden" name="sp_product_datasheet" id="sp_product_datasheet" value="<?php echo esc_attr($datasheet_id ?: ''); ?>">
            <button type="button" class="button" id="sp-ds-btn"><?php _e('Select PDF', 'sublimeplus'); ?></button>
            <button type="button" class="button" id="sp-ds-clear"<?php echo $datasheet_id ? '' : ' style="display:none"'; ?>><?php _e('Remove', 'sublimeplus'); ?></button>
            <span id="sp-ds-name" style="margin-left:8px;color:#64748b;"><?php echo $datasheet_url ? esc_html(basename($datasheet_url)) : ''; ?></span>
        </div>

        <!-- Gallery -->
        <div class="sp-label"><?php _e('Gallery Images', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="hidden" name="sp_product_gallery" id="sp_product_gallery" value="<?php echo esc_attr($gallery_raw ?: ''); ?>">
            <button type="button" class="button" id="sp-gallery-btn"><?php _e('Select Images', 'sublimeplus'); ?></button>
            <button type="button" class="button" id="sp-gallery-clear"<?php echo $gallery_raw ? '' : ' style="display:none"'; ?>><?php _e('Clear', 'sublimeplus'); ?></button>
            <div class="sp-gallery-preview" id="sp-gallery-preview">
                <?php foreach ($gallery_ids as $gid) :
                    $gurl = wp_get_attachment_image_url($gid, 'thumbnail');
                    if ($gurl) echo '<img src="' . esc_url($gurl) . '">';
                endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Spec rows repeater -->
    <div class="sp-specs-section">
        <h4 style="margin:0 0 4px;"><?php _e('Specification Table', 'sublimeplus'); ?></h4>
        <p style="color:#64748b;margin:0 0 10px;font-size:13px;"><?php _e('Label / Value pairs shown in the product spec table and on homepage cards.', 'sublimeplus'); ?></p>
        <div id="sp-specs-rows">
            <?php foreach ($specs as $row) : ?>
            <div class="sp-spec-row">
                <input type="text" name="sp_spec_label[]" value="<?php echo esc_attr($row[0] ?? ''); ?>" placeholder="<?php esc_attr_e('Label e.g. Weight', 'sublimeplus'); ?>">
                <input type="text" name="sp_spec_value[]" value="<?php echo esc_attr($row[1] ?? ''); ?>" placeholder="<?php esc_attr_e('Value e.g. 1,400 kg', 'sublimeplus'); ?>">
                <input type="text" name="sp_spec_icon[]" value="<?php echo esc_attr($row[2] ?? ''); ?>" placeholder="<?php esc_attr_e('Icon URL (Tabler SVG)', 'sublimeplus'); ?>" style="flex:1.2">
                <button type="button" class="sp-del">&times;</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button" id="sp-add-spec" style="margin-top:6px;"><?php _e('+ Add Row', 'sublimeplus'); ?></button>
    </div>

    <script>
    (function($) {
        // Spec rows
        $('#sp-add-spec').on('click', function() {
            $('#sp-specs-rows').append(
                '<div class="sp-spec-row">' +
                '<input type="text" name="sp_spec_label[]" placeholder="<?php echo esc_js(__('Label e.g. Weight', 'sublimeplus')); ?>">' +
                '<input type="text" name="sp_spec_value[]" placeholder="<?php echo esc_js(__('Value e.g. 1,400 kg', 'sublimeplus')); ?>">' +
                '<input type="text" name="sp_spec_icon[]" placeholder="<?php echo esc_js(__('Icon URL (Tabler SVG)', 'sublimeplus')); ?>" style="flex:1.2">' +
                '<button type="button" class="sp-del">&times;</button>' +
                '</div>'
            );
        });
        $(document).on('click', '.sp-del', function() { $(this).closest('.sp-spec-row').remove(); });

        // ── Media frames ─────────────────────────────────────────────────────
        function makeFrame(opts) {
            return wp.media($.extend({ multiple: false }, opts));
        }

        // Icon
        var iconFrame;
        $('#sp-icon-btn').on('click', function(e) {
            e.preventDefault();
            if (!iconFrame) {
                iconFrame = makeFrame({ title: '<?php echo esc_js(__('Select Icon', 'sublimeplus')); ?>', button: { text: '<?php echo esc_js(__('Use this image', 'sublimeplus')); ?>' } });
                iconFrame.on('select', function() {
                    var a = iconFrame.state().get('selection').first().toJSON();
                    $('#sp_product_icon').val(a.id);
                    $('#sp-icon-preview').html('<img src="' + (a.sizes && a.sizes.thumbnail ? a.sizes.thumbnail.url : a.url) + '" class="sp-thumb-preview">');
                    $('#sp-icon-clear').show();
                });
            }
            iconFrame.open();
        });
        $('#sp-icon-clear').on('click', function() { $('#sp_product_icon').val(''); $('#sp-icon-preview').html(''); $(this).hide(); });

        // Datasheet
        var dsFrame;
        $('#sp-ds-btn').on('click', function(e) {
            e.preventDefault();
            if (!dsFrame) {
                dsFrame = makeFrame({ title: '<?php echo esc_js(__('Select Datasheet PDF', 'sublimeplus')); ?>', button: { text: '<?php echo esc_js(__('Use this file', 'sublimeplus')); ?>' } });
                dsFrame.on('select', function() {
                    var a = dsFrame.state().get('selection').first().toJSON();
                    $('#sp_product_datasheet').val(a.id);
                    $('#sp-ds-name').text(a.filename || a.url.split('/').pop());
                    $('#sp-ds-clear').show();
                });
            }
            dsFrame.open();
        });
        $('#sp-ds-clear').on('click', function() { $('#sp_product_datasheet').val(''); $('#sp-ds-name').text(''); $(this).hide(); });

        // Gallery
        var galFrame;
        $('#sp-gallery-btn').on('click', function(e) {
            e.preventDefault();
            if (!galFrame) {
                galFrame = wp.media({ title: '<?php echo esc_js(__('Select Gallery Images', 'sublimeplus')); ?>', button: { text: '<?php echo esc_js(__('Add to gallery', 'sublimeplus')); ?>' }, multiple: 'add' });
                galFrame.on('select', function() {
                    var ids = [], html = '';
                    galFrame.state().get('selection').each(function(att) {
                        att = att.toJSON();
                        ids.push(att.id);
                        html += '<img src="' + (att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url) + '">';
                    });
                    $('#sp_product_gallery').val(ids.join(','));
                    $('#sp-gallery-preview').html(html);
                    $('#sp-gallery-clear').show();
                });
            }
            galFrame.open();
        });
        $('#sp-gallery-clear').on('click', function() { $('#sp_product_gallery').val(''); $('#sp-gallery-preview').html(''); $(this).hide(); });

    })(jQuery);
    </script>
    <?php
}

function sp_product_save_meta($post_id) {
    if (!isset($_POST['sp_product_nonce']) || !wp_verify_nonce($_POST['sp_product_nonce'], 'sp_product_meta_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Text fields
    foreach (['sp_product_certifications', 'sp_product_material', 'sp_product_finish'] as $key) {
        update_post_meta($post_id, '_' . $key, sanitize_text_field($_POST[$key] ?? ''));
    }

    // Attachment IDs (icon, datasheet)
    foreach (['sp_product_icon', 'sp_product_datasheet'] as $key) {
        $val = absint($_POST[$key] ?? 0);
        $val ? update_post_meta($post_id, '_' . $key, $val) : delete_post_meta($post_id, '_' . $key);
    }

    // Gallery — comma-separated IDs
    $gal = implode(',', array_filter(array_map('absint', explode(',', $_POST['sp_product_gallery'] ?? ''))));
    $gal ? update_post_meta($post_id, '_sp_product_gallery', $gal) : delete_post_meta($post_id, '_sp_product_gallery');

    // Specs table
    $labels = array_map('sanitize_text_field', (array) ($_POST['sp_spec_label'] ?? []));
    $values = array_map('sanitize_text_field', (array) ($_POST['sp_spec_value'] ?? []));
    $icons  = array_map('esc_url_raw',         (array) ($_POST['sp_spec_icon']  ?? []));
    $specs  = [];
    foreach ($labels as $i => $label) {
        $val  = $values[$i] ?? '';
        $icon = $icons[$i]  ?? '';
        if ($label !== '' || $val !== '') {
            $specs[] = [$label, $val, $icon];
        }
    }
    $specs ? update_post_meta($post_id, '_sp_product_specs', wp_json_encode($specs)) : delete_post_meta($post_id, '_sp_product_specs');
}

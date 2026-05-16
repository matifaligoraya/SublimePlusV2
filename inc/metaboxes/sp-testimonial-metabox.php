<?php
/**
 * Meta box for sp_testimonial CPT.
 * Fields: photo, position/title, company, star rating.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('add_meta_boxes',          'sp_testimonial_add_meta_boxes');
add_action('save_post_sp_testimonial','sp_testimonial_save_meta', 10, 2);
add_action('admin_enqueue_scripts',   'sp_testimonial_admin_scripts');

function sp_testimonial_admin_scripts($hook) {
    global $post;
    if (in_array($hook, ['post-new.php', 'post.php'], true)
        && isset($post->post_type)
        && $post->post_type === 'sp_testimonial') {
        wp_enqueue_media();
    }
}

function sp_testimonial_add_meta_boxes() {
    add_meta_box(
        'sp_testimonial_details',
        __('Testimonial Details', 'sublimeplus'),
        'sp_testimonial_details_cb',
        'sp_testimonial',
        'normal',
        'high'
    );
}

function sp_testimonial_details_cb($post) {
    wp_nonce_field('sp_testimonial_meta_save', 'sp_testimonial_nonce');

    $photo_id = (int) get_post_meta($post->ID, '_sp_testimonial_photo_id', true);
    $position = get_post_meta($post->ID, '_sp_testimonial_position',       true);
    $company  = get_post_meta($post->ID, '_sp_testimonial_company',        true);
    $stars    = (int) get_post_meta($post->ID, '_sp_testimonial_stars',    true) ?: 5;

    $photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'thumbnail') : '';
    ?>
    <style>
        .sp-tm-wrap { display: grid; grid-template-columns: 160px 1fr; gap: 0; }
        .sp-tm-wrap .sp-label { font-weight: 600; color: #1e293b; padding: 10px 12px 10px 0; font-size: 13px; align-self: center; }
        .sp-tm-wrap .sp-field { padding: 6px 0; border-bottom: 1px solid #f1f5f9; }
        .sp-tm-wrap .sp-field:last-child { border-bottom: none; }
        .sp-tm-wrap input[type="text"], .sp-tm-wrap select { width: 100%; }
        .sp-photo-preview img { width: 64px; height: 64px; object-fit: cover; border-radius: 50%; margin-top: 6px; display: block; }
        .sp-hint { font-size: 12px; color: #64748b; margin: .25rem 0 0; }
    </style>

    <p class="sp-hint" style="margin:0 0 12px;font-size:13px;color:#475569;">
        <?php _e('Post Title = reviewer name. Post content (below) = the quote text.', 'sublimeplus'); ?>
    </p>

    <div class="sp-tm-wrap">

        <!-- Photo -->
        <div class="sp-label"><?php _e('Photo', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="hidden" name="sp_testimonial_photo_id" id="sp_testimonial_photo_id" value="<?php echo esc_attr($photo_id ?: ''); ?>">
            <button type="button" class="button" id="sp-tm-photo-btn"><?php _e('Upload / Select Photo', 'sublimeplus'); ?></button>
            <button type="button" class="button" id="sp-tm-photo-clear"<?php echo $photo_id ? '' : ' style="display:none"'; ?>><?php _e('Remove', 'sublimeplus'); ?></button>
            <div class="sp-photo-preview" id="sp-tm-photo-preview">
                <?php if ($photo_url) : ?><img src="<?php echo esc_url($photo_url); ?>" alt=""><?php endif; ?>
            </div>
        </div>

        <!-- Position / Title -->
        <div class="sp-label"><?php _e('Position / Title', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_testimonial_position" value="<?php echo esc_attr($position); ?>" placeholder="<?php esc_attr_e('e.g. Senior Project Manager', 'sublimeplus'); ?>">
        </div>

        <!-- Company -->
        <div class="sp-label"><?php _e('Company', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <input type="text" name="sp_testimonial_company" value="<?php echo esc_attr($company); ?>" placeholder="<?php esc_attr_e('e.g. NMDC Construction', 'sublimeplus'); ?>">
        </div>

        <!-- Stars -->
        <div class="sp-label"><?php _e('Star Rating', 'sublimeplus'); ?></div>
        <div class="sp-field">
            <select name="sp_testimonial_stars">
                <?php foreach ([5, 4, 3] as $s) : ?>
                <option value="<?php echo $s; ?>"<?php selected($stars, $s); ?>><?php echo $s; ?> <?php _e('stars', 'sublimeplus'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

    <script>
    (function($) {
        var photoFrame;
        $('#sp-tm-photo-btn').on('click', function(e) {
            e.preventDefault();
            if (!photoFrame) {
                photoFrame = wp.media({
                    title: '<?php echo esc_js(__('Select Photo', 'sublimeplus')); ?>',
                    button: { text: '<?php echo esc_js(__('Use this photo', 'sublimeplus')); ?>' },
                    multiple: false
                });
                photoFrame.on('select', function() {
                    var a = photoFrame.state().get('selection').first().toJSON();
                    $('#sp_testimonial_photo_id').val(a.id);
                    var url = (a.sizes && a.sizes.thumbnail) ? a.sizes.thumbnail.url : a.url;
                    $('#sp-tm-photo-preview').html('<img src="' + url + '" alt="">');
                    $('#sp-tm-photo-clear').show();
                });
            }
            photoFrame.open();
        });
        $('#sp-tm-photo-clear').on('click', function() {
            $('#sp_testimonial_photo_id').val('');
            $('#sp-tm-photo-preview').html('');
            $(this).hide();
        });
    })(jQuery);
    </script>
    <?php
}

function sp_testimonial_save_meta($post_id) {
    if (!isset($_POST['sp_testimonial_nonce']) || !wp_verify_nonce($_POST['sp_testimonial_nonce'], 'sp_testimonial_meta_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Photo
    $photo_id = absint($_POST['sp_testimonial_photo_id'] ?? 0);
    $photo_id ? update_post_meta($post_id, '_sp_testimonial_photo_id', $photo_id)
              : delete_post_meta($post_id, '_sp_testimonial_photo_id');

    // Text fields
    update_post_meta($post_id, '_sp_testimonial_position', sanitize_text_field($_POST['sp_testimonial_position'] ?? ''));
    update_post_meta($post_id, '_sp_testimonial_company',  sanitize_text_field($_POST['sp_testimonial_company']  ?? ''));

    // Stars
    $stars = max(1, min(5, (int) ($_POST['sp_testimonial_stars'] ?? 5)));
    update_post_meta($post_id, '_sp_testimonial_stars', $stars);
}

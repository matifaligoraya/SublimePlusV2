<?php
/**
 * Tools → Import Supply Items
 * One-click seeder for the 9 default Supply Capability cards.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_management_page(
        __('Import Supply Items', 'sublimeplus'),
        __('Import Supply Items', 'sublimeplus'),
        'manage_options',
        'sp-import-supply',
        '_sp_import_supply_page'
    );
});

function _sp_import_supply_page(): void {
    $log = [];

    if (isset($_POST['sp_do_import_supply']) && check_admin_referer('sp_import_supply')) {
        $log = _sp_run_supply_import();
    }
    ?>
    <div class="wrap">
      <h1><?php _e('Import Supply Items', 'sublimeplus'); ?></h1>
      <p><?php _e('Creates the 9 default Supply Capability cards as <code>sp_supply</code> posts (skips any that already exist by title).', 'sublimeplus'); ?></p>

      <?php if ($log) : ?>
      <div class="notice notice-success"><ul style="margin:.5rem 0">
        <?php foreach ($log as $l) echo '<li>' . esc_html($l) . '</li>'; ?>
      </ul></div>
      <?php endif; ?>

      <form method="post">
        <?php wp_nonce_field('sp_import_supply'); ?>
        <input type="hidden" name="sp_do_import_supply" value="1">
        <?php submit_button(__('Run Import', 'sublimeplus'), 'primary'); ?>
      </form>
    </div>
    <?php
}

function _sp_run_supply_import(): array {
    $pu  = get_post_type_archive_link('sp_product') ?: home_url('/products/');
    $base = get_template_directory() . '/assets/img/supply/';
    $base_uri = get_template_directory_uri() . '/assets/img/supply/';

    $items = [
        [
            'title' => 'Immediate Stock',
            'desc'  => 'Standing inventory of 1,000+ barriers and 10,000 blocks — most standard orders dispatched within 24 hours.',
            'icon'  => 'stock',
            'link'  => $pu,
            'img'   => 'stock.webp',
            'order' => 1,
        ],
        [
            'title' => 'Crane Delivery',
            'desc'  => '40ft trailers and crane-mounted trucks for direct site offloading across all emirates including Western Region.',
            'icon'  => 'truck',
            'link'  => $pu,
            'img'   => 'crane-delivery.webp',
            'order' => 2,
        ],
        [
            'title' => 'Compliance Docs',
            'desc'  => 'Every delivery includes mill certificates, compressive strength reports, and delivery notes for RTA inspection.',
            'icon'  => 'docs',
            'link'  => $pu,
            'img'   => 'compliance-docs.webp',
            'order' => 3,
        ],
        [
            'title' => 'Custom Moulds',
            'desc'  => 'In-house mould fabrication for bespoke shapes. Non-standard dimensions produced within 2–3 weeks.',
            'icon'  => 'mould',
            'link'  => $pu,
            'img'   => 'custom-molds.webp',
            'order' => 4,
        ],
        [
            'title' => 'Site Support',
            'desc'  => 'Technical team provides on-site guidance for barrier placement, anchoring, and inspection compliance.',
            'icon'  => 'support',
            'link'  => $pu,
            'img'   => 'site-support.webp',
            'order' => 5,
        ],
        [
            'title' => 'In-House Lab',
            'desc'  => 'Every batch tested on-site — slump, cube strength, and density — before dispatch. Full QA traceability.',
            'icon'  => 'lab',
            'link'  => $pu,
            'img'   => 'lab.webp',
            'order' => 6,
        ],
        [
            'title' => 'Consolidated Delivery',
            'desc'  => 'Barriers, blocks, and stoppers dispatched on a single load — reducing your site coordination overhead.',
            'icon'  => 'truck',
            'link'  => $pu,
            'img'   => 'consolidated.webp',
            'order' => 7,
        ],
        [
            'title' => 'Site-to-Site Relocation',
            'desc'  => 'We collect, transport, and reinstall used barriers between your project sites across the UAE.',
            'icon'  => 'truck',
            'link'  => $pu,
            'img'   => 'relocation.webp',
            'order' => 8,
        ],
        [
            'title' => 'Bulk Logistics',
            'desc'  => 'Volume orders of 500+ units handled end-to-end: production scheduling, staged deliveries, stacking plans.',
            'icon'  => 'stock',
            'link'  => $pu,
            'img'   => 'bulk.webp',
            'order' => 9,
        ],
    ];

    $log = [];

    foreach ($items as $item) {
        // Skip if already exists
        $existing = get_page_by_title($item['title'], OBJECT, 'sp_supply');
        if ($existing) {
            $log[] = 'Skipped (exists): ' . $item['title'];
            continue;
        }

        $pid = wp_insert_post([
            'post_type'    => 'sp_supply',
            'post_title'   => $item['title'],
            'post_excerpt' => $item['desc'],
            'post_status'  => 'publish',
            'menu_order'   => $item['order'],
        ]);

        if (is_wp_error($pid)) {
            $log[] = 'Error: ' . $item['title'] . ' — ' . $pid->get_error_message();
            continue;
        }

        update_post_meta($pid, '_sp_supply_icon', $item['icon']);
        update_post_meta($pid, '_sp_supply_link', $item['link']);

        // Attach local image as featured image
        $img_path = $base . $item['img'];
        if (file_exists($img_path)) {
            $attach_id = _sp_attach_local_image($img_path, $base_uri . $item['img'], $pid);
            if ($attach_id && !is_wp_error($attach_id)) {
                set_post_thumbnail($pid, $attach_id);
                $log[] = 'Created: ' . $item['title'];
            } else {
                $log[] = 'Created (no image): ' . $item['title'];
            }
        } else {
            $log[] = 'Created (image file missing): ' . $item['title'];
        }
    }

    return $log;
}

function _sp_attach_local_image(string $file_path, string $file_url, int $parent_id): int|WP_Error {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $filetype = wp_check_filetype(basename($file_path), null);

    $attachment = [
        'guid'           => $file_url,
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_path)),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    // Copy to uploads so WP can manage it
    $upload_dir = wp_upload_dir();
    $dest       = $upload_dir['path'] . '/' . basename($file_path);

    if (!file_exists($dest)) {
        copy($file_path, $dest);
    }

    $attach_id = wp_insert_attachment($attachment, $dest, $parent_id);
    if (!is_wp_error($attach_id)) {
        wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $dest));
    }

    return $attach_id;
}

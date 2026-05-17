<?php
/**
 * Tools → Import Authority Images to Media Library
 *
 * Reads the 7 authority / certification webp icons already present in
 * assets/img/authority/ and registers them as WordPress media-library
 * attachments. Saves the resulting IDs in the option `sp_authority_img_ids`
 * so the Certificates ticker can reference them by ID instead of raw paths.
 *
 * Idempotent: skips any key whose stored ID still points to a valid attachment.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
if (!is_admin()) return;

function sp_authority_img_list(): array {
    // key => [remote filename on precastuae.ae, local save name, title]
    return [
        'rta'          => ['icon_rta_hu_f8dbde2709607f59.webp',       'rta.webp',          'RTA Approved'],
        'municipality' => ['icon_gov_hu_68d5611c45fe9202.webp',        'municipality.webp', 'Municipality Compliant'],
        'iso9001'      => ['icon_iso_hu_65b3b7fa78d402ad.webp',        'iso9001.webp',      'ISO 9001:2015'],
        'iso14001'     => ['icon_iso14001_hu_b0839e86659938ce.webp',   'iso14001.webp',     'ISO 14001:2015'],
        'icv'          => ['icon_icv_hu_ad13437139275aa0.webp',        'icv.webp',          'ICV Certified'],
        'made-in-uae'  => ['icon_made_uae_hu_5fecb080d114eff1.webp',   'made-in-uae.webp',  'Made in UAE'],
        'iso45001'     => ['icon_iso45001_hu_1c1d54ffcbcf3eca.webp',   'iso45001.webp',      'ISO 45001:2018'],
    ];
}

add_action('admin_menu', function () {
    add_management_page(
        'Import Authority Images',
        'Import Authority Images',
        'manage_options',
        'sp-import-authority',
        'sp_import_authority_page'
    );
});

function sp_import_authority_page(): void {
    $list   = sp_authority_img_list();
    $stored = (array) get_option('sp_authority_img_ids', []);
    $results = [];

    // ── Import ────────────────────────────────────────────────────────────────
    if (isset($_POST['sp_run_authority_import']) && check_admin_referer('sp_import_authority')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $base_url = 'https://precastuae.ae/icons/authority/';

        foreach ($list as $key => [$remote_file, $local_file, $title]) {
            $existing_id = (int) ($stored[$key] ?? 0);

            if ($existing_id && get_post_type($existing_id) === 'attachment') {
                $results[] = ['skip', "$key — already imported (ID $existing_id)"];
                continue;
            }

            $tmp = download_url($base_url . $remote_file);

            if (is_wp_error($tmp)) {
                $results[] = ['error', "$key — download failed: " . $tmp->get_error_message()];
                continue;
            }

            $id = media_handle_sideload(['name' => $local_file, 'tmp_name' => $tmp], 0, $title);

            if (is_wp_error($id)) {
                @unlink($tmp);
                $results[] = ['error', "$key — " . $id->get_error_message()];
            } else {
                $stored[$key] = $id;
                $results[]    = ['ok', "$key imported → attachment ID $id"];
            }
        }

        update_option('sp_authority_img_ids', $stored);
    }

    // ── Reset stored IDs (keeps media library attachments) ───────────────────
    if (isset($_POST['sp_reset_authority_ids']) && check_admin_referer('sp_reset_authority')) {
        delete_option('sp_authority_img_ids');
        $stored  = [];
        $results = [['ok', 'Stored IDs cleared. Media-library attachments were not deleted.']];
    }

    // ── Status counts ─────────────────────────────────────────────────────────
    $total = count($list);
    $done  = 0;
    foreach (array_keys($list) as $key) {
        $id = (int) ($stored[$key] ?? 0);
        if ($id && get_post_type((int) $id) === 'attachment') $done++;
    }
    ?>
    <div class="wrap">
      <h1>Import Authority / Certificate Images</h1>
      <p>
        Registers the authority logos from <code>assets/img/authority/</code> as proper
        WordPress media-library attachments. Once imported, the
        <strong>Certificates Ticker</strong> section will use the media IDs automatically,
        and you can also pick them from any WPBakery <em>Image</em> field.
      </p>

      <table class="widefat striped" style="max-width:640px;margin-bottom:1.5rem">
        <thead>
          <tr>
            <th>Key</th>
            <th>File</th>
            <th>Status</th>
            <th>Attachment ID</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $key => [$remote_file, $local_file, $title]) :
            $id    = (int) ($stored[$key] ?? 0);
            $valid = $id && get_post_type($id) === 'attachment';
          ?>
          <tr>
            <td><strong><?php echo esc_html($key); ?></strong></td>
            <td><code><?php echo esc_html($local_file); ?></code></td>
            <td>
              <?php if ($valid) : ?>
                <span style="color:#166534">&#10004; In media library</span>
              <?php else : ?>
                <span style="color:#92400e">Not imported</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($valid) : ?>
                <a href="<?php echo esc_url(get_edit_post_link($id)); ?>" target="_blank"><?php echo $id; ?></a>
              <?php else : ?>
                &mdash;
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (!empty($results)) : ?>
        <h3>Import log</h3>
        <ul style="max-height:260px;overflow:auto;background:#f6f7f7;padding:1rem;border:1px solid #ddd;border-radius:4px;font-family:monospace;font-size:13px;list-style:none;margin:0 0 1.5rem">
          <?php foreach ($results as [$st, $msg]) :
            $c = ['ok' => '#166534', 'skip' => '#92400e', 'error' => '#991b1b'][$st] ?? '#000';
          ?>
            <li style="color:<?php echo $c; ?>;margin:.2rem 0">[<?php echo esc_html($st); ?>] <?php echo esc_html($msg); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form method="post" style="display:inline-block;margin-right:1rem">
        <?php wp_nonce_field('sp_import_authority'); ?>
        <button type="submit" name="sp_run_authority_import" value="1" class="button button-primary button-large">
          <?php echo ($done === $total) ? 'Re-import All (Force)' : "Import to Media Library ($done / $total done)"; ?>
        </button>
      </form>

      <?php if ($done > 0) : ?>
      <form method="post" style="display:inline-block">
        <?php wp_nonce_field('sp_reset_authority'); ?>
        <button type="submit" name="sp_reset_authority_ids" value="1" class="button button-secondary"
          onclick="return confirm('This only clears the stored ID references — the attachments in the media library will not be deleted. Continue?')">
          Clear Stored IDs
        </button>
      </form>
      <?php endif; ?>

    </div>
    <?php
}

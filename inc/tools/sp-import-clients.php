<?php
/**
 * Tools → Import Site Assets
 *
 * Downloads all client logos and supply card images from precastuae.ae
 * into assets/img/clients/ and assets/img/supply/ on this server.
 * Idempotent — skips files that already exist.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
if (!is_admin()) return;

function sp_assets_client_list() {
    return [
        'nmdc.webp'           => '/images/clients/nmdc_hu_394147463c4acb5.webp',
        'trojan.webp'         => '/images/clients/trojan_hu_337241c456b66fec.webp',
        'amana.webp'          => '/images/clients/amana_hu_73e1b41c141e33c5.webp',
        'asgc.webp'           => '/images/clients/asgc_hu_be34d9e44f927547.webp',
        'alec.webp'           => '/images/clients/alec_hu_e06cad9db4de4fa1.webp',
        'acc.webp'            => '/images/clients/acc_hu_2745ac2f509df25c.webp',
        'naresco.webp'        => '/images/clients/naresco_hu_d4bbf03bdf9a5095.webp',
        'dubaipetroleum.webp' => '/images/clients/dubaipetroleum_hu_abbe00f89bd88416.webp',
        'ginco.webp'          => '/images/clients/ginco_hu_a1471977d9309ac0.webp',
        'civilco.webp'        => '/images/clients/civilco_hu_a35dff2ef58e2cc4.webp',
        'unec.webp'           => '/images/clients/unec_hu_872cf56f60c6f1a3.webp',
        'alnaboodah.webp'     => '/images/clients/alnaboodah_hu_20e4ce9bdc5511a4.webp',
        'wadeadams.webp'      => '/images/clients/wadeadams_hu_ef64d10738c08d23.webp',
        'khansaheb.webp'      => '/images/clients/khansaheb_hu_b86c3b865bbc6183.webp',
        'dutco.webp'          => '/images/clients/dutco_hu_b362d9952c52c01c.webp',
        'albaddad.webp'       => '/images/clients/albaddad_hu_3589571e26fbb53a.webp',
        'besix.webp'          => '/images/clients/besix_hu_32c3c3edb5dcdc15.webp',
        'bic.webp'            => '/images/clients/bic_hu_89eb82e99ef0236f.webp',
        'shapoorji.webp'      => '/images/clients/shapoorji_hu_fa2ae47268b25beb.webp',
        'lnt.webp'            => '/images/clients/lnt_hu_b9b7f462a5a336e7.webp',
        'sobha.webp'          => '/images/clients/sobha_hu_21d612ecc92d030b.webp',
        'ecc.webp'            => '/images/clients/ecc_hu_b8a4fc19e49778b3.webp',
        'mclaren.webp'        => '/images/clients/mclaren_hu_d6674dc0667756b3.webp',
        'multiplex.webp'      => '/images/clients/multiplex_hu_69952a73ba176bbd.webp',
        'cscec.webp'          => '/images/clients/cscec_hu_5c06569d468d1254.webp',
        'archirodon.webp'     => '/images/clients/archirodon_hu_92b73b14a2a24309.webp',
        'ghantoot.webp'       => '/images/clients/ghantoot_hu_b829401acd99ed85.webp',
        'aljaber.webp'        => '/images/clients/aljaber_hu_edb17584cdfe3f3c.webp',
        'alsahel.webp'        => '/images/clients/alsahel_hu_556a9c232fcf3a7e.webp',
        'parkway.webp'        => '/images/clients/parkway_hu_f0500bffcfd80012.webp',
        'target.webp'         => '/images/clients/target_hu_cab040a4eda88f6b.webp',
        'kier.webp'           => '/images/clients/kier_hu_63e3d3805847f373.webp',
    ];
}

function sp_assets_supply_list() {
    return [
        'stock.webp'          => '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
        'crane-delivery.webp' => '/images/feature_delivery_new_hu_434855aada6d92f4.webp',
        'compliance-docs.webp'=> '/images/feature_docs_hu_27e801fac11363c.webp',
        'custom-molds.webp'   => '/images/feature_moulds_hu_e7cb04c5aeb7c48f.webp',
        'site-support.webp'   => '/images/feature_site_support_hu_6f60d4b30e09f89c.webp',
        'lab.webp'            => '/images/feature_lab_hu_9f78b2a1c3d4e5f6.webp',
        'consolidated.webp'   => '/images/feature_consolidated_hu_a1b2c3d4e5f67890.webp',
        'relocation.webp'     => '/images/feature_relocation_hu_b2c3d4e5f6789012.webp',
        'bulk.webp'           => '/images/feature_bulk_hu_c3d4e5f678901234.webp',
    ];
}

function sp_import_assets_menu() {
    add_management_page(
        'Import Site Assets',
        'Import Assets',
        'manage_options',
        'sp-import-assets',
        'sp_import_assets_page'
    );
}
add_action('admin_menu', 'sp_import_assets_menu');

function sp_import_assets_page() {
    $base       = 'https://precastuae.ae';
    $theme_dir  = get_template_directory();
    $client_dir = $theme_dir . '/assets/img/clients/';
    $supply_dir = $theme_dir . '/assets/img/supply/';
    $clients    = sp_assets_client_list();
    $supply     = sp_assets_supply_list();

    $ran     = isset($_POST['sp_run_import']) && check_admin_referer('sp_import_assets');
    $results = [];

    if ($ran) {
        wp_mkdir_p($client_dir);
        wp_mkdir_p($supply_dir);

        foreach ($clients as $filename => $path) {
            $dest = $client_dir . $filename;
            if (file_exists($dest)) {
                $results[] = ['skip', "clients/$filename (already exists)"];
                continue;
            }
            $tmp = download_url($base . $path);
            if (is_wp_error($tmp)) {
                $results[] = ['error', "clients/$filename — " . $tmp->get_error_message()];
            } else {
                copy($tmp, $dest);
                @unlink($tmp);
                $results[] = ['ok', "clients/$filename"];
            }
        }

        foreach ($supply as $filename => $path) {
            $dest = $supply_dir . $filename;
            if (file_exists($dest)) {
                $results[] = ['skip', "supply/$filename (already exists)"];
                continue;
            }
            $tmp = download_url($base . $path);
            if (is_wp_error($tmp)) {
                $results[] = ['error', "supply/$filename — " . $tmp->get_error_message()];
            } else {
                copy($tmp, $dest);
                @unlink($tmp);
                $results[] = ['ok', "supply/$filename"];
            }
        }
    }

    $clients_total = count($clients);
    $supply_total  = count($supply);
    $clients_done  = 0;
    $supply_done   = 0;
    foreach (array_keys($clients) as $f) {
        if (file_exists($client_dir . $f)) $clients_done++;
    }
    foreach (array_keys($supply) as $f) {
        if (file_exists($supply_dir . $f)) $supply_done++;
    }
    $all_done = ($clients_done + $supply_done === $clients_total + $supply_total);
    ?>
    <div class="wrap">
      <h1>Import Site Assets</h1>
      <p>Downloads client logos and supply card images from <strong>precastuae.ae</strong> into the theme's <code>assets/img/</code> folder. Skips files that already exist.</p>

      <table class="widefat" style="max-width:480px;margin-bottom:1.5rem">
        <tr><th>Client logos</th><td><?php echo $clients_done; ?> / <?php echo $clients_total; ?> present</td></tr>
        <tr><th>Supply images</th><td><?php echo $supply_done; ?> / <?php echo $supply_total; ?> present</td></tr>
      </table>

      <?php if ($ran && !empty($results)) : ?>
        <h3>Import log</h3>
        <ul style="max-height:320px;overflow:auto;background:#f6f7f7;padding:1rem;border:1px solid #ddd;border-radius:4px;font-family:monospace;font-size:13px">
          <?php foreach ($results as [$status, $msg]) :
            $color = ['ok' => '#166534', 'skip' => '#92400e', 'error' => '#991b1b'][$status] ?? '#000';
          ?>
            <li style="color:<?php echo $color; ?>;margin:.2rem 0">[<?php echo esc_html($status); ?>] <?php echo esc_html($msg); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form method="post">
        <?php wp_nonce_field('sp_import_assets'); ?>
        <p>
          <button type="submit" name="sp_run_import" value="1" class="button button-primary button-large">
            <?php echo $all_done ? 'Re-download All Assets' : 'Download Missing Assets'; ?>
          </button>
        </p>
      </form>
    </div>
    <?php
}

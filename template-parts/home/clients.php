<?php
/**
 * Homepage — Trusted by / Client logos
 *
 * Add your logos to /assets/img/clients/ and update the list via the
 * 'sp_client_logos' filter, or replace this template entirely.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$heading = $args['heading'] ?? get_theme_mod('sp_clients_heading', "The Choice of UAE's Top Contractors");
$subtext = $args['subtext'] ?? get_theme_mod('sp_clients_subtext', "Supplying certified precast solutions for the region's most critical infrastructure projects.");

// $args['clients'] from WPBakery: [['name'=>'...','url'=>'...'], ...]
// Falls back to the filter which uses filenames relative to /assets/img/clients/
if (!empty($args['clients']) && is_array($args['clients'])) {
  $clients_data = $args['clients'];
} else {
  $base         = get_template_directory_uri() . '/assets/img/clients/';
  $filter_logos = apply_filters('sp_client_logos', [
    'NMDC Construction'          => 'nmdc.webp',
    'Trojan Construction Group'  => 'trojan.webp',
    'Group AMANA'                => 'amana.webp',
    'ASGC (Al Shafar)'           => 'asgc.webp',
    'Alec Engineering'           => 'alec.webp',
    'Arabian Construction Co'    => 'acc.webp',
    'Naresco Contracting'        => 'naresco.webp',
    'Dubai Petroleum'            => 'dubaipetroleum.webp',
    'Ginco General Contracting'  => 'ginco.webp',
    'Civilco'                    => 'civilco.webp',
    'United Engineering (UNEC)'  => 'unec.webp',
    'Al Naboodah Construction'   => 'alnaboodah.webp',
    'Wade Adams'                 => 'wadeadams.webp',
    'Khansaheb'                  => 'khansaheb.webp',
    'Dutco Balfour Beatty'       => 'dutco.webp',
    'Albaddad Holding'           => 'albaddad.webp',
    'Besix / Six Construct'      => 'besix.webp',
    'BIC Contracting'            => 'bic.webp',
    'Shapoorji Pallonji'         => 'shapoorji.webp',
    'Larsen & Toubro'            => 'lnt.webp',
    'Sobha Construction'         => 'sobha.webp',
    'ECC Group'                  => 'ecc.webp',
    'McLaren Construction'       => 'mclaren.webp',
    'Multiplex'                  => 'multiplex.webp',
    'China State Construction'   => 'cscec.webp',
    'Archirodon'                 => 'archirodon.webp',
    'Ghantoot Group'             => 'ghantoot.webp',
    'Al Jaber Group'             => 'aljaber.webp',
    'Al Sahel Contracting'       => 'alsahel.webp',
    'Parkway International'      => 'parkway.webp',
    'Target Engineering'         => 'target.webp',
    'Kier Group'                 => 'kier.webp',
  ]);
  $clients_data = [];
  foreach ($filter_logos as $name => $file) {
    $clients_data[] = ['name' => $name, 'url' => $base . $file];
  }
}
?>
<section class="trusted-by-section" id="trusted-by">
  <div class="container">

    <div class="trusted-header-bold">
      <div class="arch-rating" aria-hidden="true">
        <span class="star star-small"><svg viewBox="0 0 24 24" width="16" height="16"><path fill="#EAB308" stroke="#CA8A04" stroke-width=".5" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg></span>
        <span class="star star-medium"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="#EAB308" stroke="#CA8A04" stroke-width=".5" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg></span>
        <span class="star star-large"><svg viewBox="0 0 24 24" width="32" height="32"><path fill="#EAB308" stroke="#CA8A04" stroke-width=".5" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg></span>
        <span class="star star-medium"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="#EAB308" stroke="#CA8A04" stroke-width=".5" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg></span>
        <span class="star star-small"><svg viewBox="0 0 24 24" width="16" height="16"><path fill="#EAB308" stroke="#CA8A04" stroke-width=".5" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg></span>
      </div>
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="client-grid">
      <?php foreach ($clients_data as $c) :
        if (empty($c['url'])) continue;
      ?>
        <div class="client-logo-item" title="<?php echo esc_attr($c['name'] ?? ''); ?>">
          <img src="<?php echo esc_url($c['url']); ?>" alt="<?php echo esc_attr($c['name'] ?? ''); ?>" loading="lazy" decoding="async">
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

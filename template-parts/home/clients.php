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

$clients = apply_filters('sp_client_logos', [
  'NMDC Construction'        => 'nmdc.png',
  'Trojan Construction Group'=> 'trojan.png',
  'AMANA Group'              => 'amana.png',
  'ASGC'                     => 'asgc.png',
  'ALEC Engineering'         => 'alec.png',
  'Arabian Construction Co'  => 'acc.png',
  'Naresco Contracting'      => 'naresco.png',
  'Ginco Contracting'        => 'ginco.png',
  'Al Naboodah'              => 'alnaboodah.png',
  'BESIX / Six Construct'    => 'besix.png',
  'L&T'                      => 'lnt.png',
  'China State Construction' => 'cscec.png',
]);

$base = get_template_directory_uri() . '/assets/img/clients/';

$heading = get_theme_mod('sp_clients_heading', "The Choice of UAE's Top Contractors");
$subtext = get_theme_mod('sp_clients_subtext', "Supplying certified precast solutions for the region's most critical infrastructure projects.");
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
      <?php foreach ($clients as $name => $file) :
        $src = $base . $file;
      ?>
        <div class="client-logo-item" title="<?php echo esc_attr($name); ?>">
          <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" decoding="async">
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

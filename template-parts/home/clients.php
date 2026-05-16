<?php
/**
 * Homepage — Trusted By / Client logos
 * Split layout: left = content + stats, right = two-row infinite logo ticker.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$heading = $args['heading'] ?? get_theme_mod('sp_clients_heading', "The Choice of UAE's Top Contractors");
$subtext = $args['subtext'] ?? get_theme_mod('sp_clients_subtext', "Supplying certified precast solutions for the region's most critical infrastructure projects.");

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

if (empty($clients_data)) return;

$half = (int) ceil(count($clients_data) / 2);
$row1 = array_slice($clients_data, 0, $half);
$row2 = array_slice($clients_data, $half);

$contact_url = get_permalink(get_page_by_path('contact')) ?: '#inquiry';
?>

<section class="sp-clients" id="trusted-by">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- ── Left: content + stats ───────────────────────────────────────── -->
      <div class="col-lg-5">

        <span class="sp-clients__eyebrow">Trusted By</span>

        <h2 class="sp-clients__heading"><?php echo esc_html($heading); ?></h2>
        <p class="sp-clients__sub"><?php echo esc_html($subtext); ?></p>

        <div class="sp-clients__stats">
          <div class="sp-clients__stat">
            <strong class="sp-clients__stat-num">32<sup>+</sup></strong>
            <span class="sp-clients__stat-label">Active Clients</span>
          </div>
          <div class="sp-clients__stat">
            <strong class="sp-clients__stat-num">150<sup>+</sup></strong>
            <span class="sp-clients__stat-label">Projects Completed</span>
          </div>
          <div class="sp-clients__stat">
            <strong class="sp-clients__stat-num">5</strong>
            <span class="sp-clients__stat-label">UAE Emirates</span>
          </div>
        </div>

        <a href="<?php echo esc_url($contact_url); ?>" class="sp-clients__cta">
          Start a Project
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>

      </div>

      <!-- ── Right: infinite two-row logo ticker ─────────────────────────── -->
      <div class="col-lg-7">
        <div class="sp-clients__ticker-outer">

          <!-- Row 1: scrolls left -->
          <div class="sp-clients__row">
            <div class="sp-clients__track sp-clients__track--left">
              <?php foreach ($row1 as $c) : if (empty($c['url'])) continue; ?>
              <div class="sp-clients__tile">
                <img src="<?php echo esc_url($c['url']); ?>" alt="<?php echo esc_attr($c['name'] ?? ''); ?>" loading="lazy" decoding="async">
              </div>
              <?php endforeach; ?>
              <?php foreach ($row1 as $c) : if (empty($c['url'])) continue; ?>
              <div class="sp-clients__tile" aria-hidden="true">
                <img src="<?php echo esc_url($c['url']); ?>" alt="" loading="lazy" decoding="async">
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Row 2: scrolls right -->
          <div class="sp-clients__row">
            <div class="sp-clients__track sp-clients__track--right">
              <?php foreach ($row2 as $c) : if (empty($c['url'])) continue; ?>
              <div class="sp-clients__tile">
                <img src="<?php echo esc_url($c['url']); ?>" alt="<?php echo esc_attr($c['name'] ?? ''); ?>" loading="lazy" decoding="async">
              </div>
              <?php endforeach; ?>
              <?php foreach ($row2 as $c) : if (empty($c['url'])) continue; ?>
              <div class="sp-clients__tile" aria-hidden="true">
                <img src="<?php echo esc_url($c['url']); ?>" alt="" loading="lazy" decoding="async">
              </div>
              <?php endforeach; ?>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<style>
/* ── Section ──────────────────────────────────────────────────────────────── */
.sp-clients {
  padding: 5rem 0;
  background: #fff;
}

/* ── Left content ─────────────────────────────────────────────────────────── */
.sp-clients__eyebrow {
  display: inline-block;
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .14em;
  color: var(--c-primary, #264653);
  background: rgba(38,70,83,.08);
  padding: .3rem .9rem;
  border-radius: 50px;
  margin-bottom: 1.25rem;
}
.sp-clients__heading {
  font-size: clamp(1.7rem, 2.6vw, 2.4rem);
  font-weight: 800;
  line-height: 1.2;
  color: #1a3340;
  margin: 0 0 1rem;
}
.sp-clients__sub {
  font-size: .95rem;
  color: #64748b;
  line-height: 1.75;
  margin: 0 0 2rem;
}

/* Stats */
.sp-clients__stats {
  display: flex;
  gap: 2rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.sp-clients__stat {
  display: flex;
  flex-direction: column;
  gap: .15rem;
}
.sp-clients__stat-num {
  font-size: 2.2rem;
  font-weight: 800;
  line-height: 1;
  color: var(--c-primary, #264653);
}
.sp-clients__stat-num sup {
  font-size: 1rem;
  vertical-align: super;
}
.sp-clients__stat-label {
  font-size: .75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: #94a3b8;
}

/* CTA link */
.sp-clients__cta {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  font-size: .85rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .09em;
  color: var(--c-primary, #264653);
  text-decoration: none;
  transition: gap .2s;
}
.sp-clients__cta:hover { gap: .72rem; }

/* ── Ticker outer ─────────────────────────────────────────────────────────── */
.sp-clients__ticker-outer {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  /* Fade-out edges so the scroll looks seamless */
  -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 10%, #000 90%, transparent 100%);
          mask-image: linear-gradient(to right, transparent 0%, #000 10%, #000 90%, transparent 100%);
}

.sp-clients__row { overflow: hidden; }

.sp-clients__track {
  display: flex;
  gap: 1rem;
  width: max-content;
}
.sp-clients__track--left {
  animation: sp-cl-left 28s linear infinite;
}
.sp-clients__track--right {
  animation: sp-cl-right 28s linear infinite;
}
/* Pause on hover so users can read logos */
.sp-clients__ticker-outer:hover .sp-clients__track {
  animation-play-state: paused;
}

@keyframes sp-cl-left {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes sp-cl-right {
  from { transform: translateX(-50%); }
  to   { transform: translateX(0); }
}

/* Logo tile */
.sp-clients__tile {
  flex: 0 0 auto;
  width: 128px;
  height: 68px;
  background: #f8fafc;
  border: 1px solid #e8ecf0;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: .7rem .9rem;
  transition: border-color .2s, box-shadow .2s;
}
.sp-clients__tile:hover {
  border-color: #c0cdd8;
  box-shadow: 0 4px 16px rgba(38,70,83,.1);
}
.sp-clients__tile img {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
  object-fit: contain;
  filter: grayscale(1) opacity(.65);
  transition: filter .25s;
}
.sp-clients__tile:hover img {
  filter: grayscale(0) opacity(1);
}

/* ── Responsive ───────────────────────────────────────────────────────────── */
@media (max-width: 991px) {
  .sp-clients          { padding: 3.5rem 0; }
  .sp-clients__stats   { gap: 1.5rem; }
  .sp-clients__stat-num { font-size: 1.8rem; }
}
@media (max-width: 576px) {
  .sp-clients__ticker-outer { gap: .75rem; }
  .sp-clients__tile { width: 110px; height: 60px; }
}
</style>

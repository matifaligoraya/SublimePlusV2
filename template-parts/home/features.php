<?php
/**
 * Features / Why-choose-us section — icon + title + description grid
 *
 * @package SublimePlusV2
 * @var array $args  eyebrow, heading, subtext, cta_text, cta_url, features (param_group rows)
 */
defined('ABSPATH') || exit;

$eyebrow  = $args['eyebrow']  ?? '';
$heading  = $args['heading']  ?? 'Why Choose Al Turab';
$subtext  = $args['subtext']  ?? '';
$cta_text = $args['cta_text'] ?? '';
$cta_url  = $args['cta_url']  ?? '';
$cols     = max(2, min(4, (int) ($args['cols'] ?? 3)));

$default_features = [
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>',
        'title' => 'RTA & ISO Certified',
        'desc'  => 'All products meet UAE road authority standards and international quality benchmarks.',
    ],
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'title' => 'Same-Day Dispatch',
        'desc'  => 'Large ready stock across all 6 Emirates ensures urgent orders ship the same business day.',
    ],
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        'title' => 'On-Site Support',
        'desc'  => 'Our technical team provides installation guidance and on-site assistance for every project.',
    ],
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'title' => '10-Year Track Record',
        'desc'  => 'Trusted by contractors, developers and government entities across the UAE since 2014.',
    ],
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
        'title' => 'Custom Moulds & Designs',
        'desc'  => 'We manufacture bespoke precast elements to your drawings — barriers, walls, kerbs, and more.',
    ],
    [
        'icon'  => '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
        'title' => 'Fast Lead Times',
        'desc'  => 'Streamlined production planning keeps lead times short even on large-volume orders.',
    ],
];

$features = !empty($args['features']) ? $args['features'] : $default_features;

$col_class = [2 => 'col-sm-6', 3 => 'col-sm-6 col-lg-4', 4 => 'col-sm-6 col-xl-3'][$cols];
?>
<section class="sp-features">
  <div class="container">

    <div class="sp-features__header">
      <?php if ($eyebrow) : ?>
        <p class="sp-features__eyebrow"><?= esc_html($eyebrow) ?></p>
      <?php endif; ?>
      <h2 class="sp-features__heading"><?= esc_html($heading) ?></h2>
      <?php if ($subtext) : ?>
        <p class="sp-features__sub"><?= esc_html($subtext) ?></p>
      <?php endif; ?>
    </div>

    <div class="row g-4">
      <?php foreach ($features as $f) :
        $icon  = $f['icon']  ?? '';
        $title = $f['title'] ?? '';
        $desc  = $f['desc']  ?? '';
        $img   = $f['img']   ?? '';
      ?>
        <div class="<?= esc_attr($col_class) ?>">
          <div class="sp-feat-card">
            <div class="sp-feat-card__icon">
              <?php if ($img) : ?>
                <img src="<?= esc_url($img) ?>" alt="<?= esc_attr($title) ?>" width="28" height="28">
              <?php elseif ($icon) : ?>
                <?= $icon ?>
              <?php endif; ?>
            </div>
            <h3 class="sp-feat-card__title"><?= esc_html($title) ?></h3>
            <?php if ($desc) : ?>
              <p class="sp-feat-card__desc"><?= esc_html($desc) ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($cta_text && $cta_url) : ?>
      <div class="sp-features__cta">
        <a href="<?= esc_url($cta_url) ?>" class="btn btn-primary px-4">
          <?= esc_html($cta_text) ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>

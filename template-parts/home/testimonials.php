<?php
/**
 * Homepage — Testimonials / Trusted by Industry Leaders
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$heading = $args['heading'] ?? get_theme_mod('sp_testimonials_heading', 'Trusted by Industry Leaders');
$subtext = $args['subtext'] ?? get_theme_mod('sp_testimonials_subtext', 'Preferred by top-tier UAE contractors for consistent quality, documentation, and on-time delivery.');

$_default = [
    [
        'stars'   => 5,
        'text'    => 'Delivered 1,200 barriers on time for the E311 widening. The QA documentation was ready before we even asked.',
        'name'    => 'Saleh Johnson',
        'title'   => 'Senior Project Manager',
        'company' => 'NMDC Construction',
    ],
    [
        'stars'   => 5,
        'text'    => "We spec'd PRECAST UAE on three DEWA substations. Stopper quality, delivery timing, and compliance paperwork — exactly as promised.",
        'name'    => 'Eng. Tariq Mahmood',
        'title'   => 'Project Engineer',
        'company' => 'ALEC Engineering',
    ],
    [
        'stars'   => 5,
        'text'    => 'In-house lab reports made our RTA barrier submissions straightforward. No NCRs, no re-testing — passed first time.',
        'name'    => 'Mohammed Al Hashimi',
        'title'   => 'Site Manager',
        'company' => 'Trojan Construction Group',
    ],
    [
        'stars'   => 5,
        'text'    => 'We needed 600 hoarding blocks in 48 hours for an emergency site perimeter change. They had stock and delivered. No other supplier came close.',
        'name'    => 'Hassan Al Mulla',
        'title'   => 'Site Engineer',
        'company' => 'ASGC',
    ],
    [
        'stars'   => 5,
        'text'    => 'Custom bunker shell dimensions matched our structural drawings exactly. Saved three weeks of rework and eliminated one formal RFI.',
        'name'    => 'Stephan Richter',
        'title'   => 'Project Director',
        'company' => 'Six Construct / BESIX',
    ],
    [
        'stars'   => 5,
        'text'    => 'PRECAST UAE became our default barrier supplier across all emirates. Consistent quality, fast dispatch, and zero surprises on every project.',
        'name'    => 'Sylvio Pellegrini',
        'title'   => 'Operations Manager',
        'company' => 'Dutco Balfour Beatty',
    ],
];

$reviews = (!empty($args['reviews']) && is_array($args['reviews']))
    ? $args['reviews']
    : apply_filters('sp_testimonials', $_default);

if (empty($reviews)) return;
?>
<section class="testimonials-section" id="testimonials">
  <div class="container">

    <div class="section-header">
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="reviews-grid">
      <?php foreach ($reviews as $r) :
        $stars = max(1, min(5, (int) ($r['stars'] ?? 5)));
      ?>
      <div class="review-card">
        <div class="review-card__stars">
          <?php for ($i = 0; $i < $stars; $i++) : ?>
          <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">
            <path fill="#EAB308" stroke="#CA8A04" stroke-width=".5"
                  d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/>
          </svg>
          <?php endfor; ?>
        </div>
        <p class="review-card__text"><?php echo esc_html($r['text'] ?? ''); ?></p>
        <div class="review-card__author">
          <span class="review-card__name"><?php echo esc_html($r['name'] ?? ''); ?></span>
          <?php
          $meta_parts = array_filter([$r['title'] ?? '', $r['company'] ?? '']);
          if ($meta_parts) : ?>
          <span class="review-card__meta"><?php echo esc_html(implode(', ', $meta_parts)); ?></span>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

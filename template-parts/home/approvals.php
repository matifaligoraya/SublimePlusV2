<?php
/**
 * Homepage — Approvals / Certifications scrolling ticker
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args = $args ?? [];

$_uri     = get_template_directory_uri() . '/assets/img/authority/';
$_default = [
  ['img' => $_uri . 'rta.webp',          'main' => 'RTA Approved',          'sub' => 'Roads &amp; Transport Authority',  'alt' => 'RTA'],
  ['img' => $_uri . 'municipality.webp', 'main' => 'Municipality Compliant', 'sub' => 'Dubai &amp; Abu Dhabi Specs',      'alt' => 'Municipality'],
  ['img' => $_uri . 'iso9001.webp',      'main' => 'ISO 9001:2015',          'sub' => 'Quality Management System',        'alt' => 'ISO 9001'],
  ['img' => $_uri . 'iso14001.webp',     'main' => 'ISO 14001:2015',         'sub' => 'Environmental Management',         'alt' => 'ISO 14001'],
  ['img' => $_uri . 'icv.webp',          'main' => 'ICV Certified',          'sub' => 'In-Country Value Program',         'alt' => 'ICV'],
  ['img' => $_uri . 'made-in-uae.webp',  'main' => 'Made in UAE',            'sub' => 'Industrial Development',           'alt' => 'Made in UAE'],
  ['img' => $_uri . 'iso45001.webp',     'main' => 'ISO 45001:2018',         'sub' => 'Health &amp; Safety Management',   'alt' => 'ISO 45001'],
];

// $args['items'] from WPBakery overrides the filter
$items = (!empty($args['items']) && is_array($args['items']))
  ? $args['items']
  : apply_filters('sp_approvals_items', $_default);

if (empty($items)) return;
?>
<section class="approvals-section" aria-label="<?php esc_attr_e('Certifications and approvals', 'sublimeplus'); ?>">
  <div class="approvals-track" aria-hidden="true">

    <?php foreach ([1, 2] as $pass) : /* duplicate for seamless loop */ ?>
    <div class="approvals-group">
      <?php foreach ($items as $item) : ?>
        <div class="approval-item">
          <?php if (!empty($item['img'])) : ?>
            <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt'] ?? ''); ?>" loading="lazy">
          <?php endif; ?>
          <div>
            <div class="approval-text-main"><?php echo esc_html($item['main']); ?></div>
            <div class="approval-text-sub"><?php echo wp_kses_post($item['sub']); ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

  </div>
</section>

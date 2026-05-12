<?php
/**
 * Homepage — Approvals / Certifications scrolling ticker
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$items = apply_filters('sp_approvals_items', [
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/rta.png',
    'main'  => 'RTA Approved',
    'sub'   => 'Roads &amp; Transport Authority',
    'alt'   => 'RTA',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/municipality.png',
    'main'  => 'Municipality Compliant',
    'sub'   => 'Dubai &amp; Abu Dhabi Specs',
    'alt'   => 'Municipality',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/iso9001.png',
    'main'  => 'ISO 9001:2015',
    'sub'   => 'Quality Management System',
    'alt'   => 'ISO 9001',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/iso14001.png',
    'main'  => 'ISO 14001:2015',
    'sub'   => 'Environmental Management',
    'alt'   => 'ISO 14001',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/icv.png',
    'main'  => 'ICV Certified',
    'sub'   => 'In-Country Value Program',
    'alt'   => 'ICV',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/made-in-uae.png',
    'main'  => 'Made in UAE',
    'sub'   => 'Industrial Development',
    'alt'   => 'Made in UAE',
  ],
  [
    'img'   => get_template_directory_uri() . '/assets/img/authority/iso45001.png',
    'main'  => 'ISO 45001:2018',
    'sub'   => 'Health &amp; Safety Management',
    'alt'   => 'ISO 45001',
  ],
]);

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

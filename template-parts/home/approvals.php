<?php
/**
 * Homepage — Approvals / Certifications scrolling ticker
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args = $args ?? [];

$_uri        = get_template_directory_uri() . '/assets/img/authority/';
$_stored_ids = (array) get_option('sp_authority_img_ids', []);

// Helper: prefer media-library URL when an imported attachment ID exists, otherwise fall back to direct file path.
$_img = function (string $key, string $fallback) use ($_stored_ids, $_uri): string {
    $id = (int) ($_stored_ids[$key] ?? 0);
    if ($id && ($url = wp_get_attachment_image_url($id, 'thumbnail'))) {
        return $url;
    }
    return $_uri . $fallback;
};

$_default = [
  ['img' => $_img('rta',          'rta.webp'),          'main' => 'RTA Approved',          'sub' => 'Roads &amp; Transport Authority',  'alt' => 'RTA'],
  ['img' => $_img('municipality', 'municipality.webp'), 'main' => 'Municipality Compliant', 'sub' => 'Dubai &amp; Abu Dhabi Specs',      'alt' => 'Municipality'],
  ['img' => $_img('iso9001',      'iso9001.webp'),      'main' => 'ISO 9001:2015',          'sub' => 'Quality Management System',        'alt' => 'ISO 9001'],
  ['img' => $_img('iso14001',     'iso14001.webp'),     'main' => 'ISO 14001:2015',         'sub' => 'Environmental Management',         'alt' => 'ISO 14001'],
  ['img' => $_img('icv',          'icv.webp'),          'main' => 'ICV Certified',          'sub' => 'In-Country Value Program',         'alt' => 'ICV'],
  ['img' => $_img('made-in-uae',  'made-in-uae.webp'),  'main' => 'Made in UAE',            'sub' => 'Industrial Development',           'alt' => 'Made in UAE'],
  ['img' => $_img('iso45001',     'iso45001.webp'),     'main' => 'ISO 45001:2018',         'sub' => 'Health &amp; Safety Management',   'alt' => 'ISO 45001'],
];

// $args['items'] from WPBakery overrides the filter
$items = (!empty($args['items']) && is_array($args['items']))
  ? $args['items']
  : apply_filters('sp_approvals_items', $_default);

if (empty($items)) return;
?>
<section class="approvals-section" aria-label="<?php esc_attr_e('Certifications and approvals', 'sublimeplus'); ?>">

  <!-- Fixed left label -->
  <div class="approvals-label" aria-hidden="true">
    <span class="approvals-label__icon">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    </span>
    <span class="approvals-label__text">Certified<br>&amp; Approved</span>
  </div>

  <!-- Scrolling ticker -->
  <div class="approvals-ticker">
    <div class="approvals-track" aria-hidden="true">
      <?php foreach ([1, 2] as $pass) : ?>
      <div class="approvals-group">
        <?php foreach ($items as $item) : ?>
          <div class="approval-item">
            <?php if (!empty($item['img'])) : ?>
              <div class="approval-item__icon-wrap">
                <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt'] ?? ''); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="approval-item__text">
              <div class="approval-text-main"><?php echo esc_html($item['main']); ?></div>
              <div class="approval-text-sub"><?php echo wp_kses_post($item['sub']); ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</section>

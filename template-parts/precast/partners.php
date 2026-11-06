<?php
/**
 * Precast — Clients & Project Partners (Brief: Priority 14)
 *
 * Only logos listed here (or in the existing theme logo list) are shown.
 * The heading is deliberately "Clients & Project Partners" so supply through
 * contractors is not misrepresented as a direct client relationship.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Clients & Project Partners';
$subtext = $args['subtext'] ?: 'Contractors, developers and authorities whose UAE projects we have supplied, directly or through main contractors.';
$rows = sp_pc_rows($args['logos'] ?? '');
$logos = [];
foreach ($rows as $r) if (!empty($r['image_id'])) $logos[] = ['name' => $r['name'] ?? '', 'url' => sp_img_url($r['image_id'], 'medium')];
if (!$logos) {
    $base = get_template_directory_uri() . '/assets/img/clients/';
    $list = apply_filters('sp_client_logos', []);
    if (!$list) {
        $files = glob(get_template_directory() . '/assets/img/clients/*.webp') ?: [];
        foreach ($files as $f) $list[ucwords(str_replace(['-', '_'], ' ', pathinfo($f, PATHINFO_FILENAME)))] = basename($f);
    }
    foreach ($list as $name => $file) $logos[] = ['name' => $name, 'url' => $base . $file];
}
if (!$logos) return;
?>
<section class="pc-section pc-partners" id="partners">
  <div class="container">
    <?php echo sp_section_head('Trusted By', $heading, $subtext, 'center'); ?>
    <ul class="pc-partners__grid">
      <?php foreach ($logos as $l) : ?>
      <li title="<?php echo esc_attr($l['name']); ?>"><img src="<?php echo esc_url($l['url']); ?>" alt="<?php echo esc_attr($l['name']); ?>" loading="lazy" decoding="async" width="160" height="64"></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

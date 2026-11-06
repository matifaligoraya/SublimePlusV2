<?php
/**
 * Precast — Capability bar directly below the hero (Brief: Priority 3)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$rows = sp_pc_rows($args['items'] ?? '');
$items = [];
foreach ($rows as $r) if (!empty($r['title'])) $items[] = ['title' => $r['title'], 'icon' => $r['icon'] ?? 'factory'];
if (!$items) {
    $items = [
        ['title' => 'UAE Manufacturing',        'icon' => 'factory'],
        ['title' => 'Custom Mould Fabrication', 'icon' => 'mould'],
        ['title' => 'Heavy Precast Capability', 'icon' => 'heavy'],
        ['title' => 'QA/QC Documentation',      'icon' => 'qa'],
        ['title' => 'UAE Project Delivery',     'icon' => 'truck'],
    ];
}
?>
<section class="pc-capbar" aria-label="Company capabilities">
  <div class="container">
    <ul class="pc-capbar__list">
      <?php foreach ($items as $it) : ?>
      <li><span class="pc-capbar__icon"><?php echo sp_icon($it['icon'], 24); ?></span><span><?php echo esc_html($it['title']); ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

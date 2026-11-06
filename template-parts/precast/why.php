<?php
/**
 * Precast — Why choose Precast Al Turab (Brief: Priority 39 #8)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Why Choose Precast Al Turab';
$subtext = $args['subtext'] ?: 'A manufacturer built for project-specific precast, not only standard stock.';
$rows = sp_pc_rows($args['items'] ?? '');
$items = [];
foreach ($rows as $r) if (!empty($r['title'])) $items[] = ['title' => $r['title'], 'desc' => $r['desc'] ?? '', 'icon' => $r['icon'] ?? 'check'];
if (!$items) {
    $items = [
        ['title' => 'Heavy & Custom Precast',     'icon' => 'heavy',   'desc' => 'Large reinforced units manufactured from your drawings, including bunkers, T-Walls, culverts and structural panels.'],
        ['title' => 'In-House Mould Fabrication', 'icon' => 'mould',   'desc' => 'Project-specific steel moulds engineered and built in-house, so non-standard sections do not depend on third parties.'],
        ['title' => 'Drawing-to-Delivery Control','icon' => 'drawing', 'desc' => 'One team handles technical review, production planning, QA/QC, lifting and transport coordination.'],
        ['title' => 'Documented QA/QC',           'icon' => 'qa',      'desc' => 'Inspection records at mould, reinforcement, casting and finished-product stages, available with deliveries on request.'],
        ['title' => 'Heavy Lifting & Logistics',  'icon' => 'crane',   'desc' => 'Planned crane lifting, trailer loading and UAE-wide transport for units weighing several tonnes.'],
        ['title' => 'UAE Manufacturing',          'icon' => 'factory', 'desc' => 'Manufactured in the UAE for government, main contractor, consultant and industrial project requirements.'],
    ];
}
?>
<section class="pc-section pc-why" id="why">
  <div class="container">
    <?php echo sp_section_head('Why Us', $heading, $subtext, 'center'); ?>
    <div class="pc-why__grid">
      <?php foreach ($items as $it) : ?>
      <div class="pc-why__item">
        <span class="pc-why__icon"><?php echo sp_icon($it['icon'], 26); ?></span>
        <h3><?php echo esc_html($it['title']); ?></h3>
        <p><?php echo esc_html($it['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

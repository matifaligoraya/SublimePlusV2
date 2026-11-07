<?php
/**
 * Precast — Why choose Precast Al Turab (Brief: Priority 39 #8)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Why Precast Al Turab?';
$subtext = $args['subtext'] ?: 'When standard products are not enough, our customized manufacturing expertise makes the difference.';
$rows = sp_pc_rows($args['items'] ?? '');
$items = [];
foreach ($rows as $r) if (!empty($r['title'])) $items[] = ['title' => $r['title'], 'desc' => $r['desc'] ?? '', 'icon' => $r['icon'] ?? 'check'];
if (!$items) {
    $items = [
        ['title' => 'Expertise in Customized Manufacturing',   'icon' => 'custom',  'desc' => 'Our key advantage is our ability to manufacture specialized and non-standard precast components where conventional off-the-shelf solutions may not meet project requirements.'],
        ['title' => 'Government & Defence Vendor Registration','icon' => 'shield',  'desc' => 'Our registered vendor status with government and defence institutions demonstrates our involvement in professional procurement environments serving demanding sectors.'],
        ['title' => 'Technical Knowledge & Manufacturing Experience', 'icon' => 'drawing', 'desc' => 'We combine practical engineering knowledge, skilled manufacturing personnel, and production experience to address complex precast concrete requirements.'],
        ['title' => 'High-Quality Materials & Production Standards', 'icon' => 'qa', 'desc' => 'We focus on concrete quality, appropriate reinforcement, manufacturing accuracy, and quality control in accordance with agreed project specifications.'],
        ['title' => 'Flexible Manufacturing Capabilities',     'icon' => 'mould',   'desc' => 'Whether the requirement involves a single prototype, a specialized structure, or bulk production, we tailor our manufacturing approach to the scale and complexity of the project.'],
        ['title' => 'Direct Manufacturer Advantage',           'icon' => 'factory', 'desc' => 'Working directly with a manufacturer provides better technical coordination, flexible customization, competitive pricing, and effective production planning.'],
    ];
}
?>
<section class="pc-section pc-why<?php echo ($args['bg'] ?? '') === 'white' ? ' pc-why--white' : ''; ?>"<?php echo empty($args['eyebrow']) ? ' id="why"' : ''; ?>>
  <div class="container">
    <?php echo sp_section_head($args['eyebrow'] ?: 'Why Us', $heading, $subtext, 'center'); ?>
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

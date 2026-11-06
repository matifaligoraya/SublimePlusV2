<?php
/**
 * Precast — About Us core capabilities list (Brief: Priority 12)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Core Capabilities';
$items   = sp_pc_lines($args['items'] ?? '') ?: ['Heavy Precast Manufacturing', 'Custom Mould Fabrication', 'Reinforcement Fabrication', 'Concrete Casting', 'QA/QC', 'Heavy Lifting', 'Loading', 'Transportation', 'Technical Coordination'];
$icons   = ['heavy', 'mould', 'rebar', 'cast', 'qa', 'crane', 'load', 'truck', 'drawing'];
?>
<section class="pc-section pc-aboutcap">
  <div class="container">
    <?php echo sp_section_head('About Us', $heading, '', 'center'); ?>
    <ul class="pc-aboutcap__grid">
      <?php foreach ($items as $i => $it) : ?>
      <li><span><?php echo sp_icon($icons[$i % count($icons)], 24); ?></span><?php echo esc_html($it); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

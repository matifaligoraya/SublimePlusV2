<?php
/**
 * Precast — Quality built into production (Brief: Priority 27)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Quality Built Into Production';
$subtext = $args['subtext'] ?: 'Every unit passes through documented checkpoints before it is released for delivery.';
$steps   = sp_pc_lines($args['steps'] ?? '') ?: ['Approved Drawings', 'Mould Inspection', 'Reinforcement Inspection', 'Concrete Check', 'Casting', 'Curing', 'Dimensional Inspection', 'Finished Product Inspection', 'Lifting Preparation', 'Delivery Release'];
?>
<section class="pc-section pc-qaqc" id="qaqc">
  <div class="container">
    <div class="pc-qaqc__grid">
      <div class="pc-qaqc__intro">
        <?php echo sp_section_head('QA / QC', $heading, $subtext); ?>
        <ul class="pc-qaqc__points">
          <li><?php echo sp_icon('qa', 20); ?> Dimensional checks against approved structural drawings</li>
          <li><?php echo sp_icon('qa', 20); ?> Reinforcement and cover verified before every pour</li>
          <li><?php echo sp_icon('qa', 20); ?> Production records available with each delivery on request</li>
        </ul>
        <a class="pc-btn pc-btn--outline-dark" href="<?php echo esc_url(sp_page_url('capabilities', '/capabilities/')); ?>">Our Manufacturing Capability <?php echo sp_icon('arrow', 16); ?></a>
      </div>
      <ol class="pc-qaqc__steps">
        <?php foreach ($steps as $i => $s) : ?>
        <li><span><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span><?php echo esc_html($s); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

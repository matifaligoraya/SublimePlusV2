<?php
/**
 * Precast — Technical resources teaser for the homepage (Brief: Priority 16, 39)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Technical Resources';
$subtext = $args['subtext'] ?: 'Documents for engineers, consultants and procurement teams. Current documents are supplied on request while the download library is being completed.';
$url     = sp_page_url('technical-resources', '/technical-resources/');
$docs = [
    ['Company Profile',            'Introduction, products, factory, QA/QC and logistics.',   'file'],
    ['Product Catalogue',          'Standard product range and custom capability overview.',  'layers'],
    ['Product Data Sheets',        'Bunkers, T-Walls, Jersey barriers, box culverts, manholes.', 'drawing'],
    ['Method Statements & Lifting', 'Lifting guidelines, installation and material submittals.', 'crane'],
    ['Certificates',               'Trade licence, ICV and ISO certificates.',                'cert'],
];
?>
<section class="pc-section pc-resources" id="resources">
  <div class="container">
    <div class="pc-resources__head">
      <?php echo sp_section_head('Downloads', $heading, $subtext); ?>
      <a class="pc-btn pc-btn--dark" href="<?php echo esc_url($url); ?>">All Technical Resources <?php echo sp_icon('arrow', 16); ?></a>
    </div>
    <div class="pc-resources__grid">
      <?php foreach ($docs as [$t, $d, $i]) : ?>
      <a class="pc-res-card" href="<?php echo esc_url($url); ?>">
        <span class="pc-res-card__icon"><?php echo sp_icon($i, 24); ?></span>
        <strong><?php echo esc_html($t); ?></strong>
        <span><?php echo esc_html($d); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

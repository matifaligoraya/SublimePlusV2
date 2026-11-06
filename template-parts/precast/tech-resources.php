<?php
/**
 * Precast — Technical Resources page: document library (Brief: Priority 16, 28, 29)
 *
 * Documents come from the WPBakery param_group; any document without a file
 * is shown as "Request" and links to the RFQ form with the document name.
 * Certificates with an expiry date in the past are hidden automatically.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$rows = sp_pc_rows($args['docs'] ?? '');
$docs = [];
foreach ($rows as $r) {
    if (empty($r['title'])) continue;
    if (!empty($r['expiry']) && strtotime($r['expiry']) && strtotime($r['expiry']) < time()) continue; // expired certificate → hide
    $docs[] = ['title' => $r['title'], 'desc' => $r['desc'] ?? '', 'cat' => $r['category'] ?: 'Technical Documents', 'url' => !empty($r['file_id']) ? wp_get_attachment_url((int) $r['file_id']) : '', 'file_id' => (int) ($r['file_id'] ?? 0)];
}
if (!$docs) {
    $defaults = [
        ['Company', 'Company Profile', 'Company introduction, products, heavy precast capability, factory, projects, QA/QC, equipment, logistics and contact information.'],
        ['Company', 'Product Catalogue', 'Overview of standard products and custom manufacturing capability.'],
        ['Product Data Sheets', 'Bunker Technical Data Sheet', 'Typical configurations, reinforcement approach, lifting and customisation notes.'],
        ['Product Data Sheets', 'T-Wall Data Sheet', 'Heights, base widths, concrete grade options and lifting points.'],
        ['Product Data Sheets', 'Jersey Barrier Data Sheet', 'Standard lengths, profile, interlock details and unit weights.'],
        ['Product Data Sheets', 'Box Culvert Data Sheet', 'Internal spans, wall thickness and jointing details.'],
        ['Product Data Sheets', 'Manhole Data Sheet', 'Chamber sizes, cover slabs and step iron options.'],
        ['Technical Documents', 'Concrete Information', 'Concrete grades, admixtures and durability options available.'],
        ['Technical Documents', 'Method Statements', 'Manufacturing, handling and installation method statements.'],
        ['Technical Documents', 'Material Submittals', 'Material submittal package for consultant approval.'],
        ['Technical Documents', 'Lifting Guidelines', 'Crane lifting, anchor types and handling instructions for heavy units.'],
        ['Technical Documents', 'Installation Guidelines', 'Site placement, bedding and jointing guidance.'],
        ['Certificates', 'Trade Licence', 'Current trade licence.'],
        ['Certificates', 'ICV Certificate', 'In-Country Value certificate.'],
        ['Certificates', 'ISO Certificates', 'Quality, environmental and safety management system certificates.'],
    ];
    foreach ($defaults as [$cat, $t, $d]) $docs[] = ['title' => $t, 'desc' => $d, 'cat' => $cat, 'url' => '', 'file_id' => 0];
    // Company profile from Customizer if set
    $c = sp_company();
    if ($c['profile_id'] && ($u = wp_get_attachment_url($c['profile_id']))) $docs[0]['url'] = $u;
}
$groups = [];
foreach ($docs as $d) $groups[$d['cat']][] = $d;
$order = ['Company', 'Product Data Sheets', 'Technical Documents', 'Certificates'];
uksort($groups, function ($a, $b) use ($order) { $ia = array_search($a, $order, true); $ib = array_search($b, $order, true); return ($ia === false ? 99 : $ia) <=> ($ib === false ? 99 : $ib); });
?>
<section class="pc-section pc-techres">
  <div class="container">
    <div class="pc-techres__intro">
      <p>This page allows customers, engineers and procurement staff to obtain company and product documents. Where a document is not yet available for direct download, use <strong>Request</strong> and our team will send the current version by email.</p>
      <div class="pc-cta-group">
        <a class="pc-btn pc-btn--accent" href="<?php echo esc_url(sp_profile_url()); ?>" data-track="profile_download"><?php echo sp_icon('download', 18); ?> Download Company Profile</a>
        <a class="pc-btn pc-btn--outline-dark" href="<?php echo esc_url(sp_rfq_url('', '', 'Technical Data Request')); ?>" data-track="techdata_click"><?php echo sp_icon('file', 18); ?> Request Technical Data</a>
      </div>
    </div>
    <?php foreach ($groups as $cat => $items) : ?>
    <div class="pc-techres__group">
      <h2 class="pc-h3"><?php echo esc_html($cat); ?></h2>
      <ul class="pc-techres__list">
        <?php foreach ($items as $d) : ?>
        <li class="pc-doc">
          <span class="pc-doc__icon"><?php echo sp_icon($cat === 'Certificates' ? 'cert' : 'file', 22); ?></span>
          <div class="pc-doc__text"><strong><?php echo esc_html($d['title']); ?></strong><?php if ($d['desc']) : ?><span><?php echo esc_html($d['desc']); ?></span><?php endif; ?></div>
          <?php if ($d['url']) : ?>
          <a class="pc-btn pc-btn--sm pc-btn--dark" href="<?php echo esc_url($d['url']); ?>" target="_blank" rel="noopener" data-track="techdata_download"><?php echo sp_icon('download', 16); ?> Download</a>
          <?php else : ?>
          <a class="pc-btn pc-btn--sm pc-btn--outline-dark" href="<?php echo esc_url(sp_rfq_url('', '', 'Document Request: ' . $d['title'])); ?>" data-track="techdata_click">Request</a>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>

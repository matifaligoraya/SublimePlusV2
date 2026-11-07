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
    // Same logo list as the original theme "Trusted By" section (template-parts/home/clients.php).
    $list = apply_filters('sp_client_logos', [
        'NMDC Construction' => 'nmdc.webp', 'Trojan Construction Group' => 'trojan.webp', 'Group AMANA' => 'amana.webp',
        'ASGC (Al Shafar)' => 'asgc.webp', 'Alec Engineering' => 'alec.webp', 'Arabian Construction Co' => 'acc.webp',
        'Naresco Contracting' => 'naresco.webp', 'Dubai Petroleum' => 'dubaipetroleum.webp', 'Ginco General Contracting' => 'ginco.webp',
        'Civilco' => 'civilco.webp', 'United Engineering (UNEC)' => 'unec.webp', 'Al Naboodah Construction' => 'alnaboodah.webp',
        'Wade Adams' => 'wadeadams.webp', 'Khansaheb' => 'khansaheb.webp', 'Dutco Balfour Beatty' => 'dutco.webp',
        'Albaddad Holding' => 'albaddad.webp', 'Besix / Six Construct' => 'besix.webp', 'BIC Contracting' => 'bic.webp',
        'Shapoorji Pallonji' => 'shapoorji.webp', 'Larsen & Toubro' => 'lnt.webp', 'Sobha Construction' => 'sobha.webp',
        'ECC Group' => 'ecc.webp', 'McLaren Construction' => 'mclaren.webp', 'Multiplex' => 'multiplex.webp',
        'China State Construction' => 'cscec.webp', 'Archirodon' => 'archirodon.webp', 'Ghantoot Group' => 'ghantoot.webp',
        'Al Jaber Group' => 'aljaber.webp', 'Al Sahel Contracting' => 'alsahel.webp', 'Parkway International' => 'parkway.webp',
        'Target Engineering' => 'target.webp', 'Kier Group' => 'kier.webp',
    ]);
    $dir = get_template_directory() . '/assets/img/clients/';
    foreach ($list as $name => $file) {
        if (file_exists($dir . $file)) $logos[] = ['name' => $name, 'url' => $base . $file];
    }
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

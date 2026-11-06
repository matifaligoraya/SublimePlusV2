<?php
/**
 * Precast — Capabilities page content (Brief: Priority 15)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$rows = sp_pc_rows($args['blocks'] ?? '');
$blocks = [];
foreach ($rows as $r) if (!empty($r['title'])) $blocks[] = ['title' => $r['title'], 'desc' => $r['desc'] ?? '', 'icon' => $r['icon'] ?? 'factory', 'img' => !empty($r['image_id']) ? sp_img_url($r['image_id'], 'medium_large') : ''];
if (!$blocks) {
    $blocks = [
        ['title' => 'Technical Review',          'icon' => 'drawing', 'desc' => 'Client drawing and specification review. We check dimensions, reinforcement details, embedded items, lifting requirements and tolerances before production is planned.'],
        ['title' => 'Mould Fabrication',         'icon' => 'mould',   'desc' => 'Custom steel mould development for project-specific sections, including bunker shells, T-Wall profiles, culvert boxes and non-standard units.'],
        ['title' => 'Reinforcement Fabrication', 'icon' => 'rebar',   'desc' => 'Cutting, bending and reinforcement cage preparation according to approved structural drawings and bar bending schedules.'],
        ['title' => 'Concrete Casting',          'icon' => 'cast',    'desc' => 'Controlled casting according to project requirements, with concrete grade, cover and compaction checked for every pour.'],
        ['title' => 'Quality Control',           'icon' => 'inspect', 'desc' => 'Inspection and production documentation at each stage: mould, reinforcement, concrete, dimensions and finished product.'],
        ['title' => 'Custom Manufacturing',      'icon' => 'custom',  'desc' => 'Non-standard sizes and specialised products manufactured from client drawings, BOQ and technical specifications.'],
        ['title' => 'Heavy Lifting',             'icon' => 'crane',   'desc' => 'Handling large reinforced units using appropriate lifting equipment, cast-in anchors and planned lifting procedures.'],
        ['title' => 'Logistics',                 'icon' => 'truck',   'desc' => 'Loading and transportation coordination throughout the UAE, including crane loading, trailer transport and site delivery planning.'],
    ];
}
?>
<section class="pc-section pc-capab">
  <div class="container">
    <div class="pc-capab__grid">
      <?php foreach ($blocks as $i => $b) : ?>
      <article class="pc-capab__item">
        <span class="pc-capab__num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
        <?php if ($b['img'] ?? '') : ?><img class="pc-capab__img" src="<?php echo esc_url($b['img']); ?>" alt="<?php echo esc_attr($b['title']); ?>" loading="lazy"><?php endif; ?>
        <span class="pc-capab__icon"><?php echo sp_icon($b['icon'], 28); ?></span>
        <h2 class="pc-capab__title"><?php echo esc_html($b['title']); ?></h2>
        <p><?php echo esc_html($b['desc']); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

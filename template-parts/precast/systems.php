<?php
/**
 * Precast — Specialised Precast Systems: six large product cards (Brief: Priority 4)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Specialised Precast Systems';
$subtext = $args['subtext'] ?: 'Standard and custom reinforced concrete products manufactured for UAE projects.';

$rows  = sp_pc_rows($args['cards'] ?? '');
$cards = [];
foreach ($rows as $r) {
    if (empty($r['title'])) continue;
    $cards[] = [
        'title' => $r['title'], 'desc' => $r['desc'] ?? '', 'btn' => $r['btn_text'] ?? 'View', 'link' => $r['link'] ?? '#',
        'img'   => !empty($r['image_id']) ? sp_img_url($r['image_id'], 'large') : '', 'icon' => $r['icon'] ?? 'box',
    ];
}
if (!$cards) {
    // 'img' = card photo (existing media library images, one per card, no repeats on the homepage).
    $defaults = [
        ['img' => 13,  'slug' => 'precast-bunker',   'cat' => '',                          'title' => 'Precast Bunkers & Shelters',     'desc' => 'Heavy reinforced precast structures manufactured according to project-specific drawings and requirements.', 'btn' => 'View Bunkers',   'icon' => 'bunker'],
        ['img' => 208, 'slug' => 't-wall',           'cat' => '',                          'title' => 'T-Walls & Protective Barriers',  'desc' => 'Heavy reinforced wall systems for perimeter protection, separation and infrastructure applications.',          'btn' => 'View T-Walls',   'icon' => 'wall'],
        ['img' => 211, 'slug' => 'box-culvert',      'cat' => '',                          'title' => 'Box Culverts & Channels',        'desc' => 'Box culverts, C-Type structures and U-Channels manufactured in standard and custom dimensions.',                'btn' => 'View Culverts',  'icon' => 'culvert'],
        ['img' => 9,   'slug' => 'jersey-barrier',   'cat' => 'concrete-barriers',         'title' => 'Concrete Road Barriers',         'desc' => 'Jersey barriers, security barriers and precast traffic-control products.',                                      'btn' => 'View Barriers',  'icon' => 'barrier'],
        ['img' => 212, 'slug' => 'manhole',          'cat' => 'manholes-utility-structures','title' => 'Manholes & Utility Structures',  'desc' => 'Manholes, chambers, cable troughs, utility bases and related infrastructure products.',                         'btn' => 'View Utilities', 'icon' => 'manhole'],
        ['img' => 15,  'slug' => 'custom-precast',   'cat' => '',                          'title' => 'Custom Precast',                 'desc' => 'Custom reinforced precast products manufactured according to client drawings, BOQ and technical specifications.', 'btn' => 'Send Drawing',   'icon' => 'custom', 'rfq' => true],
    ];
    foreach ($defaults as $d) {
        $p    = sp_pc_product_by_slug($d['slug']);
        $img  = !empty($d['img']) ? sp_img_url($d['img'], 'large') : ($p ? get_the_post_thumbnail_url($p->ID, 'large') : '');
        $link = '#';
        if (!empty($d['rfq']))           $link = sp_rfq_url('Custom Precast', '', 'Send Drawing') . '#rfq-files';
        elseif ($d['cat'] && ($term = get_term_by('slug', $d['cat'], 'sp_product_cat'))) $link = get_term_link($term);
        elseif ($p)                      $link = get_permalink($p);
        else                             $link = get_post_type_archive_link('sp_product');
        $cards[] = ['title' => $d['title'], 'desc' => $d['desc'], 'btn' => $d['btn'], 'link' => $link, 'img' => $img ?: '', 'icon' => $d['icon'], 'pid' => $p ? (int) $p->ID : 0, 'quote' => $d['title']];
    }
}
?>
<section class="pc-section pc-systems" id="products">
  <div class="container">
    <?php echo sp_section_head('Product Range', $heading, $subtext, 'center'); ?>
    <div class="pc-systems__grid">
      <?php foreach ($cards as $i => $c) : ?>
      <article class="pc-sys-card">
        <a class="pc-sys-card__media" href="<?php echo esc_url($c['link']); ?>" tabindex="-1" aria-hidden="true">
          <?php if ($c['img']) : ?>
            <img src="<?php echo esc_url($c['img']); ?>" alt="<?php echo esc_attr($c['title']); ?>" loading="<?php echo $i < 2 ? 'eager' : 'lazy'; ?>" decoding="async" width="640" height="440">
          <?php else : echo sp_pc_placeholder($c['icon'], $c['title']); endif; ?>
          <span class="pc-sys-card__num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
        </a>
        <div class="pc-sys-card__body">
          <span class="pc-sys-card__icon"><?php echo sp_icon($c['icon'], 26); ?></span>
          <h3 class="pc-sys-card__title"><a href="<?php echo esc_url($c['link']); ?>"><?php echo esc_html($c['title']); ?></a></h3>
          <p><?php echo esc_html($c['desc']); ?></p>
          <?php echo sp_pc_card_specs_html((int) ($c['pid'] ?? 0)); ?>
          <div class="pc-sys-card__actions">
            <a class="pc-btn pc-btn--accent pc-btn--sm" href="<?php echo esc_url(sp_rfq_url($c['quote'] ?? $c['title'])); ?>" data-track="rfq_click"><?php echo sp_icon('quote', 15); ?> Get Quote</a>
            <a class="pc-btn pc-btn--dark pc-btn--sm" href="<?php echo esc_url($c['link']); ?>"><?php echo esc_html($c['btn']); ?> <?php echo sp_icon('arrow', 16); ?></a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

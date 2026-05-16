<?php
/**
 * Homepage — Supply Capability (dark image cards, clickable)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$eyebrow = $args['eyebrow'] ?? get_theme_mod('sp_supply_eyebrow', 'What We Offer');
$heading = $args['heading'] ?? get_theme_mod('sp_supply_heading', 'Supply Capability');
$subtext = $args['subtext'] ?? get_theme_mod('sp_supply_subtext', 'We understand that construction delays cost money. Our logistics setup is built for speed and volume.');

$pu   = get_post_type_archive_link('sp_product') ?: home_url('/products/');
$base = get_template_directory_uri() . '/assets/img/supply/';

// ── Pull from CPT, fall back to hardcoded defaults ────────────────────────────
if (!empty($args['cards']) && is_array($args['cards'])) {
    $cards = $args['cards'];
} else {
    $cards = [];

    $sq = new WP_Query([
        'post_type'      => 'sp_supply',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if ($sq->have_posts()) {
        while ($sq->have_posts()) {
            $sq->the_post();
            $spid  = get_the_ID();
            $s_link = get_post_meta($spid, '_sp_supply_link', true) ?: $pu;
            $s_img  = get_the_post_thumbnail_url($spid, 'large') ?: '';
            $cards[] = [
                'title' => get_the_title(),
                'desc'  => get_the_excerpt(),
                'link'  => $s_link,
                'img'   => $s_img,
                'icon'  => get_post_meta($spid, '_sp_supply_icon', true) ?: 'stock',
            ];
        }
        wp_reset_postdata();
    } else {
        // Static fallback — shown before CPT is seeded
        $cards = apply_filters('sp_supply_cards', [
            ['img' => $base . 'stock.webp',           'title' => 'Immediate Stock',         'desc' => 'Standing inventory of 1,000+ barriers and 10,000 blocks — most standard orders dispatched within 24 hours.',         'link' => $pu, 'icon' => 'stock'],
            ['img' => $base . 'crane-delivery.webp',  'title' => 'Crane Delivery',          'desc' => '40ft trailers and crane-mounted trucks for direct site offloading across all emirates including Western Region.',      'link' => $pu, 'icon' => 'truck'],
            ['img' => $base . 'compliance-docs.webp', 'title' => 'Compliance Docs',         'desc' => 'Every delivery includes mill certificates, compressive strength reports, and delivery notes for RTA inspection.',       'link' => $pu, 'icon' => 'docs'],
            ['img' => $base . 'custom-molds.webp',    'title' => 'Custom Moulds',           'desc' => 'In-house mould fabrication for bespoke shapes. Non-standard dimensions produced within 2–3 weeks.',                   'link' => $pu, 'icon' => 'mould'],
            ['img' => $base . 'site-support.webp',    'title' => 'Site Support',            'desc' => 'Technical team provides on-site guidance for barrier placement, anchoring, and inspection compliance.',                'link' => $pu, 'icon' => 'support'],
            ['img' => $base . 'lab.webp',             'title' => 'In-House Lab',            'desc' => 'Every batch tested on-site — slump, cube strength, and density — before dispatch. Full QA traceability.',             'link' => $pu, 'icon' => 'lab'],
            ['img' => $base . 'consolidated.webp',    'title' => 'Consolidated Delivery',   'desc' => 'Barriers, blocks, and stoppers dispatched on a single load — reducing your site coordination overhead.',               'link' => $pu, 'icon' => 'truck'],
            ['img' => $base . 'relocation.webp',      'title' => 'Site-to-Site Relocation', 'desc' => 'We collect, transport, and reinstall used barriers between your project sites across the UAE.',                       'link' => $pu, 'icon' => 'truck'],
            ['img' => $base . 'bulk.webp',            'title' => 'Bulk Logistics',          'desc' => 'Volume orders of 500+ units handled end-to-end: production scheduling, staged deliveries, stacking plans.',           'link' => $pu, 'icon' => 'stock'],
        ]);
    }
}

if (empty($cards)) return;

// Per-card SVG icons
$svg = [
    'stock'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="11" height="5" rx="1"/></svg>',
    'truck'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
    'docs'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
    'mould'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>',
    'support' => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    'lab'     => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v11l-4 7a1 1 0 0 0 .9 1.5h12.2a1 1 0 0 0 .9-1.5L15 14V3"/><line x1="3" y1="9" x2="21" y2="9"/></svg>',
];
$arrow_svg = '<svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="9 3 14 8 9 13"/></svg>';
?>
<section class="supply-section" id="logistics">
  <div class="container">

    <div class="section-header section-header--dark">
      <?php if ($eyebrow) : ?>
      <span class="section-eyebrow"><?php echo esc_html($eyebrow); ?></span>
      <?php endif; ?>
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="supply-grid">
      <?php foreach ($cards as $i => $card) :
        $bg       = !empty($card['img'])  ? esc_url($card['img'])  : '';
        $link     = !empty($card['link']) ? esc_url($card['link']) : '';
        $icon_key = $card['icon'] ?? 'stock';
        $icon_svg = $svg[$icon_key] ?? $svg['stock'];
        $tag      = $link ? 'a' : 'div';
        $href_attr = $link ? ' href="' . $link . '"' : '';
        $num      = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
      ?>
        <<?php echo $tag; ?> class="supply-card"<?php echo $href_attr; ?>>
          <span class="supply-card__num" aria-hidden="true"><?php echo $num; ?></span>

          <?php if ($bg) : ?>
          <div class="supply-card__img" style="background-image:url(<?php echo $bg; ?>)" role="img" aria-label="<?php echo esc_attr($card['title']); ?>"></div>
          <?php endif; ?>

          <div class="supply-card__body">
            <div class="supply-card__icon" aria-hidden="true">
              <?php echo $icon_svg; ?>
            </div>
            <h3><?php echo esc_html($card['title']); ?></h3>
            <p><?php echo esc_html($card['desc']); ?></p>
            <?php if ($link) : ?>
            <span class="supply-card__cta">
              <?php _e('Explore', 'sublimeplus'); ?>
              <?php echo $arrow_svg; ?>
            </span>
            <?php endif; ?>
          </div>
        </<?php echo $tag; ?>>
      <?php endforeach; ?>
    </div>

  </div>
</section>

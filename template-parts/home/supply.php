<?php
/**
 * Homepage — Supply Capability section
 * Cards are defined via the 'sp_supply_cards' filter so a plugin or
 * child theme can swap them out without editing this file.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$heading = $args['heading'] ?? get_theme_mod('sp_supply_heading', 'Supply Capability');
$subtext = $args['subtext'] ?? get_theme_mod('sp_supply_subtext', 'We understand that construction delays cost money. Our logistics setup is built for speed and volume.');

// $args['cards'] from WPBakery: [['img'=>url,'title'=>'...','desc'=>'...'], ...]
// Falls back to the filter when no WPBakery override is supplied
if (!empty($args['cards']) && is_array($args['cards'])) {
  $cards = $args['cards'];
} else {
  $base  = get_template_directory_uri() . '/assets/img/supply/';
  $cards = apply_filters('sp_supply_cards', [
    ['img' => $base . 'stock.jpg',          'title' => 'Immediate Stock',  'desc' => 'We maintain a standing inventory of 1,000+ barriers and 10,000 blocks at any given time. Most standard orders can be dispatched within 24 hours.'],
    ['img' => $base . 'crane-delivery.jpg', 'title' => 'Crane Delivery',   'desc' => 'Our fleet includes 40ft trailers and crane-mounted trucks for direct site offloading across all emirates including the Western Region.'],
    ['img' => $base . 'compliance-docs.jpg','title' => 'Compliance Docs',  'desc' => 'Every delivery includes a full QA package: mill certificates, compressive strength reports, and delivery notes for inspection.'],
    ['img' => $base . 'custom-molds.jpg',   'title' => 'Custom Moulds',    'desc' => 'Our in-house mould fabrication team can produce bespoke steel moulds for non-standard shapes within 2–3 weeks.'],
    ['img' => $base . 'site-support.jpg',   'title' => 'Site Support',     'desc' => 'Our technical team provides on-site guidance for barrier placement, anchoring, and inspection compliance.'],
    ['img' => $base . 'lab.jpg',            'title' => 'In-House Lab',     'desc' => 'Every batch is tested in our on-site concrete lab — slump, cube strength, and density — before dispatch.'],
  ]);
}

if (empty($cards)) return;
?>
<section class="supply-section" id="logistics">
  <div class="container">

    <div class="section-header">
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="home-grid home-grid--3">
      <?php foreach ($cards as $card) : ?>
        <div class="supply-card">
          <div class="supply-card__image">
            <img src="<?php echo esc_url($card['img']); ?>" alt="<?php echo esc_attr($card['title']); ?>" loading="lazy" decoding="async">
          </div>
          <h3><?php echo esc_html($card['title']); ?></h3>
          <p><?php echo esc_html($card['desc']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

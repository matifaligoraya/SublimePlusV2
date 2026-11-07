<?php
/**
 * Precast — Homepage hero (Brief: Priority 2)
 * Heavy-precast photo, strong heading, three CTAs, formats line.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$a = wp_parse_args($args ?? [], []);
$bg_id   = (int) ($a['bg_image_id'] ?? 0);
if (!$bg_id && !get_theme_mod('sp_hero_bg')) $bg_id = 13; // default: bunker production photo
// Responsive source set so phones download a small file instead of the full-size original.
$bg      = $bg_id ? (sp_img_url($bg_id, 'large') ?: sp_img_url($bg_id, 'full')) : get_theme_mod('sp_hero_bg');
$bg_set  = $bg_id ? (string) wp_get_attachment_image_srcset($bg_id, 'full') : '';
$heading = $a['heading']     ?: 'Engineered Precast Concrete Solutions for the UAE';
$sub     = $a['subheading']  ?: 'Heavy-Duty Precast Manufacturing for Infrastructure, Industrial, Construction and Specialised Projects';
$desc    = $a['description'] ?: 'Precast Al Turab manufactures reinforced precast concrete products engineered for demanding UAE projects. From protective bunkers and T-Walls to barriers, box culverts, chambers and custom structural elements, we support projects from drawing review and mould fabrication through production, lifting and delivery.';
$formats = $a['formats']     ?: 'PDF • DWG • BOQ • Technical Specification';

// Client's branded 3D product images (Nov 2026), shown as a slider beside the heading.
$models = [];
foreach ([
    ['precast-bunker',  'Bunkers & Shelters'],
    ['t-wall',          'T-Walls'],
    ['jersey-barrier',  'Road Barriers'],
    ['manhole',         'Manholes'],
    ['telecom-chamber', 'Telecom Chambers'],
] as [$slug, $label]) {
    $p = sp_pc_product_by_slug($slug);
    if (!$p || !has_post_thumbnail($p->ID)) continue;
    $tid = (int) get_post_thumbnail_id($p->ID);
    $models[] = ['src' => sp_img_url($tid, 'large') ?: sp_img_url($tid, 'full'), 'alt' => get_post_meta($tid, '_wp_attachment_image_alt', true) ?: $label, 'label' => $label, 'link' => get_permalink($p)];
}
?>
<section class="pc-hero" id="hero">
  <?php if ($bg) : ?>
  <img class="pc-hero__bg" src="<?php echo esc_url($bg); ?>"<?php if ($bg_set) : ?> srcset="<?php echo esc_attr($bg_set); ?>" sizes="100vw"<?php endif; ?> alt="" fetchpriority="high" decoding="async">
  <?php endif; ?>
  <div class="pc-hero__shade" aria-hidden="true"></div>
  <div class="container">
    <div class="pc-hero__grid<?php echo $models ? ' pc-hero__grid--3d' : ''; ?>">
    <div class="pc-hero__inner">
      <span class="pc-eyebrow pc-eyebrow--light">UAE Precast Concrete Manufacturer</span>
      <h1 class="pc-hero__title"><?php echo esc_html($heading); ?></h1>
      <p class="pc-hero__sub"><?php echo esc_html($sub); ?></p>
      <p class="pc-hero__desc"><?php echo esc_html($desc); ?></p>
      <?php echo sp_cta_buttons(['class' => 'pc-hero__cta']); ?>
      <p class="pc-hero__formats"><?php echo sp_icon('file', 16); ?> <?php echo esc_html($formats); ?></p>
    </div>
    <?php if ($models) : ?>
    <div class="pc-hero__3d" data-hero-3d>
      <div class="pc-hero__slides">
        <?php foreach ($models as $i => $m) : ?>
        <a class="pc-hero__slide<?php echo $i === 0 ? ' is-active' : ''; ?>" href="<?php echo esc_url($m['link']); ?>" aria-hidden="<?php echo $i === 0 ? 'false' : 'true'; ?>" tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>">
          <img src="<?php echo esc_url($m['src']); ?>" alt="<?php echo esc_attr($m['alt']); ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>" decoding="async">
        </a>
        <?php endforeach; ?>
      </div>
      <div class="pc-hero__3d-bar">
        <div class="pc-hero__3d-tabs" role="tablist">
          <?php foreach ($models as $i => $m) : ?>
          <button type="button" role="tab" class="<?php echo $i === 0 ? 'is-active' : ''; ?>" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" data-link="<?php echo esc_url($m['link']); ?>"><?php echo esc_html($m['label']); ?></button>
          <?php endforeach; ?>
        </div>
        <a class="pc-hero__3d-link" href="<?php echo esc_url($models[0]['link']); ?>">View product <?php echo sp_icon('arrow', 14); ?></a>
      </div>
    </div>
    <?php endif; ?>
    </div>
  </div>
</section>
<?php if (count($models) > 1) : ?>
<script>
(function(){
  var box=document.querySelector('[data-hero-3d]'); if(!box) return;
  var slides=[].slice.call(box.querySelectorAll('.pc-hero__slide')), tabs=[].slice.call(box.querySelectorAll('.pc-hero__3d-tabs button')), link=box.querySelector('.pc-hero__3d-link'), i=0, timer, touched=false;
  function show(n){ i=n; slides.forEach(function(s,k){ var on=k===n; s.classList.toggle('is-active',on); s.setAttribute('aria-hidden',on?'false':'true'); s.tabIndex=on?0:-1; });
    tabs.forEach(function(b,k){ b.classList.toggle('is-active',k===n); b.setAttribute('aria-selected',k===n?'true':'false'); }); link.href=tabs[n].getAttribute('data-link'); }
  tabs.forEach(function(b,k){ b.addEventListener('click',function(){ touched=true; clearInterval(timer); show(k); }); });
  box.addEventListener('mouseenter',function(){ clearInterval(timer); });
  box.addEventListener('mouseleave',function(){ if(!touched) timer=setInterval(function(){ show((i+1)%slides.length); }, 5000); });
  timer=setInterval(function(){ if(!touched) show((i+1)%slides.length); }, 5000);
})();
</script>
<?php endif; ?>

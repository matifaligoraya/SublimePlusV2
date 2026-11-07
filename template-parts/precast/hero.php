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

// 3D product models (same .glb files the original banner used), shown beside the heading.
$models_dir = get_template_directory_uri() . '/assets/models/';
$models = [];
foreach ([
    ['jersey-barrier',  'concrete_road_barrier.glb', 'Concrete Jersey Barrier'],
    ['wheel-stopper',   'wheel_stopper.glb',         'Wheel Stopper'],
    ['plastic-barrier', 'plastic_barrier.glb',       'Water-Filled Barrier'],
] as [$slug, $file, $label]) {
    if (!file_exists(get_template_directory() . '/assets/models/' . $file)) continue;
    $p = sp_pc_product_by_slug($slug);
    $models[] = ['src' => $models_dir . $file, 'label' => $label, 'link' => $p ? get_permalink($p) : get_post_type_archive_link('sp_product')];
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
      <model-viewer class="pc-hero__model" src="<?php echo esc_url($models[0]['src']); ?>" alt="<?php echo esc_attr($models[0]['label']); ?> 3D model"
        auto-rotate rotation-per-second="25deg" camera-controls disable-zoom interaction-prompt="none"
        camera-orbit="-30deg 80deg 110%" shadow-intensity="1" shadow-softness="0.6" exposure="1.1">
        <div slot="progress-bar"></div>
      </model-viewer>
      <div class="pc-hero__3d-bar">
        <span class="pc-hero__3d-hint"><?php echo sp_icon('layers', 14); ?> 3D view · drag to rotate</span>
        <div class="pc-hero__3d-tabs" role="tablist">
          <?php foreach ($models as $i => $m) : ?>
          <button type="button" role="tab" class="<?php echo $i === 0 ? 'is-active' : ''; ?>" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" data-src="<?php echo esc_url($m['src']); ?>" data-label="<?php echo esc_attr($m['label']); ?>" data-link="<?php echo esc_url($m['link']); ?>"><?php echo esc_html($m['label']); ?></button>
          <?php endforeach; ?>
        </div>
        <a class="pc-hero__3d-link" href="<?php echo esc_url($models[0]['link']); ?>">View product <?php echo sp_icon('arrow', 14); ?></a>
      </div>
    </div>
    <?php endif; ?>
    </div>
  </div>
</section>
<?php if ($models) : ?>
<script>
(function(){
  var box=document.querySelector('[data-hero-3d]'); if(!box) return;
  // Load the 3D viewer only after the page has loaded, so it never delays the hero text or photo.
  function load(){ if(window.customElements && customElements.get('model-viewer')) return; var s=document.createElement('script'); s.type='module'; s.src='https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js'; document.head.appendChild(s); }
  if(document.readyState==='complete') load(); else window.addEventListener('load', load);
  var mv=box.querySelector('model-viewer'), tabs=[].slice.call(box.querySelectorAll('[data-src]')), link=box.querySelector('.pc-hero__3d-link'), i=0, timer, touched=false;
  function show(n){ i=n; var t=tabs[n]; mv.setAttribute('src', t.getAttribute('data-src')); mv.setAttribute('alt', t.getAttribute('data-label')+' 3D model'); link.href=t.getAttribute('data-link');
    tabs.forEach(function(b,k){ b.classList.toggle('is-active',k===n); b.setAttribute('aria-selected',k===n?'true':'false'); }); }
  tabs.forEach(function(b,k){ b.addEventListener('click',function(){ touched=true; clearInterval(timer); show(k); }); });
  mv.addEventListener('pointerdown',function(){ touched=true; clearInterval(timer); });
  timer=setInterval(function(){ if(!touched) show((i+1)%tabs.length); }, 7000);
})();
</script>
<?php endif; ?>

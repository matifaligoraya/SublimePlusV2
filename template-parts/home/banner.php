<?php
/**
 * Homepage Hero — Product Showcase Slider
 *
 * Left half : product info card (title, specs, buttons)
 * Right half : model-viewer 3D (auto-rotate + drag) from sp_model_url post meta
 *              Falls back to product featured image if no model assigned.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$base        = get_template_directory_uri();
// Try common contact page slugs, then fall back to #inquiry
$_contact_pg = get_page_by_path('contact-us') ?: get_page_by_path('contact');
$contact_url = $_contact_pg ? get_permalink($_contact_pg) : '#inquiry';
// Products archive URL for fallback slides
$_products_pg = get_page_by_path('products') ?: get_page_by_path('product');
$products_url = $_products_pg ? get_permalink($_products_pg) : (get_post_type_archive_link('sp_product') ?: home_url('/products/'));
$hero_bg     = get_theme_mod('sp_hero_bg', $base . '/assets/img/banner/hero-bg.jpg');

// ── Query sp_product posts ────────────────────────────────────────────────────
// $args['product_ids'] is a comma-separated string of IDs from the WPBakery element.
$_selected_ids = array_filter(array_map('absint', explode(',', $args['product_ids'] ?? '')));

if (!empty($_selected_ids)) {
    $_q = new WP_Query([
        'post_type'      => 'sp_product',
        'post__in'       => $_selected_ids,
        'posts_per_page' => count($_selected_ids),
        'post_status'    => 'publish',
        'orderby'        => 'post__in',  // preserve the editor's selection order
    ]);
} else {
    $_q = new WP_Query([
        'post_type'      => 'sp_product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);
}

$slides = [];
if ($_q->have_posts()) {
    while ($_q->have_posts()) {
        $_q->the_post();
        $pid  = get_the_ID();
        $cats = get_the_terms($pid, 'sp_product_cat');
        $slides[] = [
            'title'     => get_the_title(),
            'excerpt'   => get_the_excerpt() ?: wp_trim_words(get_the_content(), 20),
            'permalink' => get_permalink(),
            'img'       => get_the_post_thumbnail_url($pid, 'large') ?: '',
            'model_url' => get_post_meta($pid, 'sp_model_url', true) ?: '',
            'category'  => (!is_wp_error($cats) && !empty($cats)) ? $cats[0]->name : '',
            'dims'      => get_post_meta($pid, 'sp_dimensions', true) ?: get_post_meta($pid, 'dimensions', true) ?: '',
            'weight'    => get_post_meta($pid, 'sp_weight',     true) ?: get_post_meta($pid, 'weight',     true) ?: '',
            'finish'    => get_post_meta($pid, 'sp_finish',     true) ?: get_post_meta($pid, 'finish',     true) ?: '',
            'standard'  => get_post_meta($pid, 'sp_standard',   true) ?: get_post_meta($pid, 'standard',   true) ?: '',
        ];
    }
    wp_reset_postdata();
}

// ── Fallback: show demo slides until products are published ───────────────────
if (empty($slides)) {
    $slides = [
        [
            'title'     => 'Jersey Barrier — Type F',
            'excerpt'   => 'RTA-approved concrete Jersey barriers for highway lane division, crash zones, and construction site separation across all UAE Emirates.',
            'permalink' => $products_url,
            'img'       => '',
            'model_url' => $base . '/assets/models/concrete_road_barrier.glb',
            'category'  => 'Traffic Barriers',
            'dims'      => '6100 × 810 × 810 mm',
            'weight'    => '3,500 kg',
            'finish'    => 'Smooth / As-cast',
            'standard'  => 'RTA Dubai · BS EN 1317',
        ],
        [
            'title'     => 'Concrete Wheel Stopper',
            'excerpt'   => 'Heavy-duty concrete wheel stoppers for car parks, loading bays, and logistics zones. Reflective markings and anchor bolt holes standard.',
            'permalink' => $products_url,
            'img'       => '',
            'model_url' => $base . '/assets/models/wheel_stopper.glb',
            'category'  => 'Parking Solutions',
            'dims'      => '1800 × 200 × 150 mm',
            'weight'    => '150 kg',
            'finish'    => 'Natural / Painted',
            'standard'  => 'Municipality Approved',
        ],
        [
            'title'     => 'Water-Filled Plastic Barrier',
            'excerpt'   => 'RTA-approved UV-stabilized HDPE barriers for agile traffic diversion and crowd control. Interlocking, easy to deploy and relocate.',
            'permalink' => $products_url,
            'img'       => '',
            'model_url' => $base . '/assets/models/plastic_barrier.glb',
            'category'  => 'Traffic Management',
            'dims'      => '2000 × 800 × 400 mm',
            'weight'    => '500 kg (full)',
            'finish'    => 'HDPE Red / White',
            'standard'  => 'RTA Approved',
        ],
    ];
}

$count = count($slides);
?>

<!-- model-viewer web component (Google) -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

<section class="sph" id="sp-hero" aria-label="Product showcase">

  <!-- Fixed background (stays still while slides change) -->
  <div class="sph__bg" style="background-image:url('<?php echo esc_url($hero_bg); ?>')"></div>
  <div class="sph__overlay"></div>

  <!-- Slides -->
  <div class="sph__track">
    <?php foreach ($slides as $i => $s) : ?>
    <div class="sph__slide<?php echo $i === 0 ? ' sph__slide--active' : ''; ?>" data-index="<?php echo $i; ?>">

      <!-- LEFT: info card -->
      <div class="sph__info">
        <div class="sph__card">
          <?php if ($s['category']) : ?>
            <span class="sph__cat"><?php echo esc_html($s['category']); ?></span>
          <?php endif; ?>

          <h2 class="sph__title"><?php echo esc_html($s['title']); ?></h2>
          <div class="sph__line"></div>

          <?php
          $specs = array_filter([
              'Dimensions' => $s['dims'],
              'Weight'     => $s['weight'],
              'Finish'     => $s['finish'],
              'Standard'   => $s['standard'],
          ]);
          if ($specs) : ?>
          <dl class="sph__specs">
            <?php foreach ($specs as $k => $v) : ?>
            <div class="sph__spec">
              <dt><?php echo esc_html($k); ?></dt>
              <dd><?php echo esc_html($v); ?></dd>
            </div>
            <?php endforeach; ?>
          </dl>
          <?php endif; ?>

          <?php if ($s['excerpt']) : ?>
          <p class="sph__desc"><?php echo esc_html($s['excerpt']); ?></p>
          <?php endif; ?>

          <div class="sph__actions">
            <a href="<?php echo esc_url($s['permalink']); ?>" class="sph__btn sph__btn--solid">View Product</a>
            <a href="<?php echo esc_url($contact_url); ?>"    class="sph__btn sph__btn--outline">Get a Quote</a>
          </div>
        </div>
      </div>

      <!-- RIGHT: 3D model or product image -->
      <div class="sph__visual">
        <?php if (!empty($s['model_url'])) : ?>
          <model-viewer
            src="<?php echo esc_url($s['model_url']); ?>"
            alt="<?php echo esc_attr($s['title']); ?>"
            auto-rotate
            rotation-per-second="25deg"
            interaction-prompt="none"
            camera-controls
            camera-orbit="-30deg 80deg 110%"
            min-camera-orbit="auto auto 90%"
            max-camera-orbit="auto auto 140%"
            shadow-intensity="1"
            shadow-softness="0.6"
            exposure="1.1"
            <?php echo $i === 0 ? '' : 'loading="lazy"'; ?>>
            <div slot="progress-bar"></div>
          </model-viewer>
        <?php elseif (!empty($s['img'])) : ?>
          <img src="<?php echo esc_url($s['img']); ?>"
               alt="<?php echo esc_attr($s['title']); ?>"
               class="sph__img"
               loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
        <?php endif; ?>
      </div>

    </div><!-- .sph__slide -->
    <?php endforeach; ?>
  </div><!-- .sph__track -->

  <?php if ($count > 1) : ?>
  <!-- Prev / Next -->
  <button class="sph__arrow sph__arrow--prev" aria-label="Previous">
    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <button class="sph__arrow sph__arrow--next" aria-label="Next">
    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </button>

  <!-- Dot indicators -->
  <div class="sph__dots">
    <?php foreach ($slides as $i => $s) : ?>
    <button class="sph__dot<?php echo $i === 0 ? ' sph__dot--on' : ''; ?>"
            data-index="<?php echo $i; ?>"
            aria-label="Slide <?php echo $i + 1; ?>"></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

</section>

<style>
/* ── Hero section ───────────────────────────────────────────────────────────── */
.sph {
  position: relative;
  width: 100%;
  height: 100vh;
  min-height: 580px;
  max-height: 980px;
  overflow: hidden;
  /* Lighter navy — menu color stepped up in lightness */
  background: #2a5080;
}

/* Background image — stays fixed */
.sph__bg {
  position: absolute; inset: 0;
  background-size: cover;
  background-position: center;
  pointer-events: none;
}
.sph__overlay {
  position: absolute; inset: 0;
  background: linear-gradient(110deg, rgba(20,50,85,.88) 0%, rgba(20,50,85,.65) 50%, rgba(20,50,85,.25) 100%);
  pointer-events: none;
}

/* Slides sit on top of the fixed background */
.sph__track {
  position: relative;
  width: 100%; height: 100%;
  z-index: 2;
}
.sph__slide {
  position: absolute; inset: 0;
  display: grid;
  grid-template-columns: 48% 52%;
  align-items: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity .65s ease;
}
.sph__slide--active {
  opacity: 1;
  pointer-events: auto;
}

/* ── LEFT: info card ─────────────────────────────────────────────────────────── */
.sph__info {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 3rem 2.5rem 3rem 2rem;
  height: 100%;
}
.sph__card {
  background: #fff;
  border-radius: 14px;
  padding: 2.25rem 2rem;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 20px 60px rgba(0,0,0,.4);
  /* Slide-in from left when active */
  transform: translateX(-28px);
  opacity: 0;
  transition: transform .6s .08s ease, opacity .6s .08s ease;
}
.sph__slide--active .sph__card {
  transform: translateX(0);
  opacity: 1;
}

.sph__cat {
  display: inline-block;
  background: var(--c-accent, #F97316);
  color: #fff;
  font-size: .7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .14em;
  padding: .28rem .9rem;
  border-radius: 4px;
  margin-bottom: 1rem;
}
.sph__title {
  font-size: clamp(1.35rem, 2vw, 1.85rem);
  font-weight: 800;
  line-height: 1.2;
  color: #1a2d45;
  margin: 0 0 .9rem;
}
.sph__line {
  width: 44px; height: 3px;
  background: var(--c-accent, #F97316);
  border-radius: 2px;
  margin-bottom: 1.1rem;
}

/* Spec grid */
.sph__specs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: .5rem .65rem;
  margin: 0 0 1.1rem;
}
.sph__spec {
  background: #f1f5f9;
  border-radius: 8px;
  padding: .55rem .7rem;
}
.sph__spec dt {
  font-size: .66rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .07em;
  color: #64748b;
  margin-bottom: .18rem;
}
.sph__spec dd {
  font-size: .82rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0;
  line-height: 1.3;
}

.sph__desc {
  font-size: .84rem;
  color: #475569;
  line-height: 1.6;
  margin: 0 0 1.35rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.sph__actions { display: flex; gap: .65rem; flex-wrap: wrap; }
.sph__btn {
  display: inline-flex;
  align-items: center;
  padding: .6rem 1.4rem;
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: .09em;
  text-transform: uppercase;
  text-decoration: none !important;
  border-radius: 6px;
  border: 2px solid transparent;
  transition: all .2s ease;
  white-space: nowrap;
}
.sph__btn--solid {
  background: var(--c-accent, #F97316);
  color: #fff !important;
  border-color: var(--c-accent, #F97316);
}
.sph__btn--solid:hover {
  background: var(--c-accent-dark, #ea6c0a);
  border-color: var(--c-accent-dark, #ea6c0a);
  box-shadow: 0 4px 16px rgba(249,115,22,.4);
}
.sph__btn--outline {
  background: transparent;
  color: #1a2d45 !important;
  border-color: rgba(26,45,69,.35);
}
.sph__btn--outline:hover { background: #1a2d45; color: #fff !important; border-color: #1a2d45; }

/* ── RIGHT: 3D model viewer ──────────────────────────────────────────────────── */
.sph__visual {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  /* Slide-in from right */
  transform: translateX(30px) scale(.97);
  opacity: 0;
  transition: transform .7s .2s ease, opacity .7s .2s ease;
}
.sph__slide--active .sph__visual {
  transform: translateX(0) scale(1);
  opacity: 1;
}

model-viewer {
  width: 100%;
  height: 100%;
  background: transparent;
  --poster-color: transparent;
}
model-viewer:focus { outline: none; }

.sph__img {
  max-height: 70%;
  max-width: 90%;
  object-fit: contain;
  filter: drop-shadow(0 16px 40px rgba(0,0,0,.5));
}

/* ── Navigation arrows ────────────────────────────────────────────────────────── */
.sph__arrow {
  position: absolute;
  top: 50%; transform: translateY(-50%);
  z-index: 10;
  width: 52px; height: 52px;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,.55);
  background: rgba(255,255,255,.14);
  color: #fff !important;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  backdrop-filter: blur(8px);
  transition: border-color .2s, background .2s, transform .2s;
}
.sph__arrow:hover {
  border-color: #fff;
  background: rgba(255,255,255,.25);
  transform: translateY(-50%) scale(1.08);
}
.sph__arrow svg { stroke: #fff; }
.sph__arrow--prev { left: 1.25rem; }
.sph__arrow--next { right: 1.25rem; }

/* ── Dot indicators ───────────────────────────────────────────────────────────── */
.sph__dots {
  position: absolute;
  bottom: 1.75rem; left: 50%;
  transform: translateX(-50%);
  display: flex; gap: .45rem;
  z-index: 10;
}
.sph__dot {
  width: 32px; height: 3px;
  border-radius: 2px; border: none; padding: 0;
  background: rgba(255,255,255,.28);
  cursor: pointer;
  transition: width .25s, background .25s;
}
.sph__dot--on,
.sph__dot:hover { width: 48px; background: var(--c-accent, #F97316); }

/* ── Responsive ───────────────────────────────────────────────────────────────── */
@media (max-width: 991px) {
  /* Mobile: stack vertically, show card only */
  .sph__slide {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr auto;
    align-items: end;
  }
  .sph__info {
    justify-content: center;
    padding: 5rem 1.25rem 1.5rem;
    grid-row: 2;
  }
  .sph__card { max-width: 100%; }
  .sph__visual {
    grid-row: 1;
    padding: 2rem 1rem .5rem;
    height: 40vh;
    transform: none; opacity: 0;
  }
  .sph__slide--active .sph__visual { opacity: 1; }
}
@media (max-width: 576px) {
  .sph { height: 95vh; }
  .sph__card { padding: 1.5rem 1.1rem; }
  .sph__specs { grid-template-columns: 1fr; }
  .sph__visual { height: 32vh; }
}
</style>

<script>
(function () {
  'use strict';
  var hero    = document.getElementById('sp-hero');
  if (!hero) return;

  var slides  = Array.from(hero.querySelectorAll('.sph__slide'));
  var dots    = Array.from(hero.querySelectorAll('.sph__dot'));
  var total   = slides.length;
  var cur     = 0;
  var timer   = null;
  var DELAY   = 7000;

  if (total < 2) return;

  function activate(idx) {
    // Pause model-viewer on outgoing slide
    var mvOut = slides[cur].querySelector('model-viewer');
    if (mvOut) mvOut.removeAttribute('auto-rotate');

    slides[cur].classList.remove('sph__slide--active');
    dots[cur].classList.remove('sph__dot--on');

    cur = ((idx % total) + total) % total;

    slides[cur].classList.add('sph__slide--active');
    dots[cur].classList.add('sph__dot--on');

    // Resume model-viewer on incoming slide
    var mvIn = slides[cur].querySelector('model-viewer');
    if (mvIn) mvIn.setAttribute('auto-rotate', '');
  }

  function next() { activate(cur + 1); }
  function prev() { activate(cur - 1); }
  function startTimer() { clearInterval(timer); timer = setInterval(next, DELAY); }
  function stopTimer()  { clearInterval(timer); }

  // Pause non-active model-viewers at init
  slides.forEach(function (s, i) {
    if (i === 0) return;
    var mv = s.querySelector('model-viewer');
    if (mv) mv.removeAttribute('auto-rotate');
  });

  var btnPrev = hero.querySelector('.sph__arrow--prev');
  var btnNext = hero.querySelector('.sph__arrow--next');
  if (btnPrev) btnPrev.addEventListener('click', function () { stopTimer(); prev(); startTimer(); });
  if (btnNext) btnNext.addEventListener('click', function () { stopTimer(); next(); startTimer(); });

  dots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      stopTimer();
      activate(parseInt(this.getAttribute('data-index'), 10));
      startTimer();
    });
  });

  // Pause on hover (so user can interact with model-viewer freely)
  hero.addEventListener('mouseenter', stopTimer);
  hero.addEventListener('mouseleave', startTimer);

  // Keyboard
  hero.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft')  { stopTimer(); prev(); startTimer(); }
    if (e.key === 'ArrowRight') { stopTimer(); next(); startTimer(); }
  });

  // Touch swipe
  var tx = 0;
  hero.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; }, { passive: true });
  hero.addEventListener('touchend',   function (e) {
    var d = tx - e.changedTouches[0].clientX;
    if (Math.abs(d) > 50) { stopTimer(); (d > 0 ? next : prev)(); startTimer(); }
  }, { passive: true });

  startTimer();
})();
</script>

<?php
/**
 * Homepage — Testimonials Carousel (Canvas style)
 * Left: heading + description | Right: 2-up card carousel
 * Pulls from sp_testimonial CPT; falls back to hardcoded defaults.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args    = $args ?? [];
$heading = $args['heading'] ?? get_theme_mod('sp_testimonials_heading', 'What Our Clients Say');
$subtext = $args['subtext'] ?? get_theme_mod('sp_testimonials_subtext', 'Preferred by top-tier UAE contractors for consistent quality, documentation, and on-time delivery.');

// ── Build reviews from CPT, or WPBakery override, or hardcoded defaults ───────
if (!empty($args['reviews']) && is_array($args['reviews'])) {
    $reviews = $args['reviews'];
} else {
    // Query sp_testimonial CPT
    $_tq = new WP_Query([
        'post_type'      => 'sp_testimonial',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);
    $reviews = [];
    if ($_tq->have_posts()) {
        while ($_tq->have_posts()) {
            $_tq->the_post();
            $pid      = get_the_ID();
            $photo_id = (int) get_post_meta($pid, '_sp_testimonial_photo_id', true);
            $reviews[] = [
                'stars'   => (int) get_post_meta($pid, '_sp_testimonial_stars',    true) ?: 5,
                'text'    => get_the_content() ?: get_the_excerpt(),
                'name'    => get_the_title(),
                'title'   => get_post_meta($pid, '_sp_testimonial_position', true),
                'company' => get_post_meta($pid, '_sp_testimonial_company',  true),
                'photo'   => $photo_id ? wp_get_attachment_image_url($photo_id, 'thumbnail') : '',
            ];
        }
        wp_reset_postdata();
    }

    // Hardcoded fallback when no CPT posts exist yet
    if (empty($reviews)) {
        $reviews = [
            ['stars' => 5, 'text' => 'Delivered 1,200 barriers on time for the E311 widening. QA documentation was ready before we even asked. No surprises from start to finish.', 'name' => 'Saleh Johnson',        'title' => 'Senior Project Manager', 'company' => 'NMDC Construction',        'photo' => ''],
            ['stars' => 5, 'text' => "We spec'd PRECAST UAE on three DEWA substations. Stopper quality, delivery timing, and compliance paperwork — exactly as promised every single time.", 'name' => 'Eng. Tariq Mahmood', 'title' => 'Project Engineer',       'company' => 'ALEC Engineering',          'photo' => ''],
            ['stars' => 5, 'text' => 'In-house lab reports made our RTA barrier submissions straightforward. No NCRs, no re-testing — passed first time. Saved us two weeks on the programme.', 'name' => 'Mohammed Al Hashimi', 'title' => 'Site Manager', 'company' => 'Trojan Construction Group', 'photo' => ''],
            ['stars' => 5, 'text' => 'We needed 600 hoarding blocks in 48 hours for an emergency site perimeter change. They had stock and delivered. No other supplier came close.', 'name' => 'Hassan Al Mulla',    'title' => 'Site Engineer',          'company' => 'ASGC',                      'photo' => ''],
            ['stars' => 5, 'text' => 'Custom bunker shell dimensions matched our structural drawings exactly. Saved three weeks of rework and eliminated one formal RFI.', 'name' => 'Stephan Richter',    'title' => 'Project Director',       'company' => 'Six Construct / BESIX',     'photo' => ''],
            ['stars' => 5, 'text' => 'PRECAST UAE became our default barrier supplier across all emirates. Consistent quality, fast dispatch, and zero surprises on every project.', 'name' => 'Sylvio Pellegrini',  'title' => 'Operations Manager',     'company' => 'Dutco Balfour Beatty',      'photo' => ''],
        ];
    }
}

if (empty($reviews)) return;

// Group reviews into pairs (2 per carousel slide)
$slides     = array_chunk($reviews, 2);
$slide_count = count($slides);
$archive_url = get_post_type_archive_link('sp_testimonial') ?: '#';
$uid         = 'tc-' . substr(md5(uniqid()), 0, 6); // unique ID for multiple instances
?>

<section class="sp-testi" id="testimonials">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- LEFT: heading block -->
      <div class="col-lg-4">
        <span class="sp-testi__eyebrow"><?php _e('Testimonials', 'sublimeplus'); ?></span>
        <h2 class="sp-testi__heading"><?php echo esc_html($heading); ?></h2>
        <p class="sp-testi__sub"><?php echo esc_html($subtext); ?></p>
        <a href="<?php echo esc_url($archive_url); ?>" class="sp-testi__more">
          <?php _e('All Reviews', 'sublimeplus'); ?>
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>

      <!-- RIGHT: carousel -->
      <div class="col-lg-8">
        <div class="sp-testi__carousel" id="<?php echo $uid; ?>">

          <div class="sp-testi__track" role="list">
            <?php foreach ($slides as $si => $pair) : ?>
            <div class="sp-testi__slide<?php echo $si === 0 ? ' sp-testi__slide--active' : ''; ?>" role="listitem" aria-label="<?php printf('Slide %d of %d', $si + 1, $slide_count); ?>">
              <div class="row g-3">
                <?php foreach ($pair as $r) :
                  $stars = max(1, min(5, (int) ($r['stars'] ?? 5)));
                  $name  = $r['name'] ?? '';
                  // Initials fallback when no photo
                  $initials = '';
                  foreach (preg_split('/\s+/', trim($name)) as $part) {
                      if ($part) $initials .= strtoupper($part[0]);
                      if (strlen($initials) >= 2) break;
                  }
                ?>
                <div class="col-sm-6">
                  <div class="sp-review-card">
                    <!-- Avatar -->
                    <div class="sp-review-card__avatar-wrap">
                      <?php if (!empty($r['photo'])) : ?>
                        <img src="<?php echo esc_url($r['photo']); ?>" alt="<?php echo esc_attr($name); ?>" class="sp-review-card__avatar-img" width="64" height="64">
                      <?php else : ?>
                        <div class="sp-review-card__avatar-initials"><?php echo esc_html($initials); ?></div>
                      <?php endif; ?>
                    </div>

                    <!-- Stars -->
                    <div class="sp-review-card__stars" aria-label="<?php echo $stars; ?> out of 5 stars">
                      <?php for ($i = 0; $i < $stars; $i++) : ?>
                      <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path fill="#E9C46A" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg>
                      <?php endfor; ?>
                    </div>

                    <!-- Quote -->
                    <p class="sp-review-card__text"><?php echo esc_html($r['text'] ?? ''); ?></p>

                    <!-- Attribution -->
                    <div class="sp-review-card__author">
                      <strong class="sp-review-card__name"><?php echo esc_html($name); ?></strong>
                      <?php
                      $meta = array_filter([$r['title'] ?? '', $r['company'] ?? '']);
                      if ($meta) : ?>
                      <span class="sp-review-card__company"><?php echo esc_html(implode(', ', $meta)); ?></span>
                      <?php endif; ?>
                    </div>

                    <!-- Decorative bg icon -->
                    <svg class="sp-review-card__bg-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div><!-- .sp-testi__track -->

          <!-- Dots -->
          <?php if ($slide_count > 1) : ?>
          <div class="sp-testi__dots" role="tablist" aria-label="<?php _e('Testimonial slides', 'sublimeplus'); ?>">
            <?php foreach ($slides as $si => $pair) : ?>
            <button class="sp-testi__dot<?php echo $si === 0 ? ' sp-testi__dot--on' : ''; ?>"
                    role="tab"
                    data-index="<?php echo $si; ?>"
                    aria-selected="<?php echo $si === 0 ? 'true' : 'false'; ?>"
                    aria-label="<?php printf(__('Go to slide %d', 'sublimeplus'), $si + 1); ?>">
            </button>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

        </div><!-- .sp-testi__carousel -->
      </div>

    </div>
  </div>
</section>

<style>
/* ── Testimonials section ─────────────────────────────────────────────────── */
.sp-testi {
  padding: 5rem 0;
  background: #f8fafc;
}

/* Left column */
.sp-testi__eyebrow {
  display: inline-block;
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .14em;
  color: var(--c-primary, #264653);
  background: rgba(38,70,83,.08);
  padding: .3rem .9rem;
  border-radius: 50px;
  margin-bottom: 1.1rem;
}
.sp-testi__heading {
  font-size: clamp(1.6rem, 2.5vw, 2.2rem);
  font-weight: 800;
  line-height: 1.2;
  color: #1a3340;
  margin: 0 0 1rem;
}
.sp-testi__sub {
  font-size: .95rem;
  color: #64748b;
  line-height: 1.7;
  margin: 0 0 1.5rem;
}
.sp-testi__more {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  font-size: .85rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .09em;
  color: var(--c-primary, #264653);
  text-decoration: none;
  transition: gap .2s;
}
.sp-testi__more:hover { gap: .7rem; }

/* Carousel */
.sp-testi__carousel { position: relative; }
.sp-testi__track    { position: relative; }

.sp-testi__slide {
  display: none;
  animation: sp-testi-fade .4s ease;
}
.sp-testi__slide--active { display: block; }

@keyframes sp-testi-fade {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Review card */
.sp-review-card {
  background: #fff;
  border: 1px solid #e8ecf0;
  border-radius: 14px;
  padding: 1.75rem 1.5rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,.06);
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: box-shadow .2s, transform .2s;
}
.sp-review-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,.12);
  transform: translateY(-2px);
}

.sp-review-card__avatar-wrap { margin-bottom: 1rem; }

.sp-review-card__avatar-img {
  width: 64px; height: 64px;
  border-radius: 50%;
  object-fit: cover;
  display: block;
  margin: 0 auto;
}
.sp-review-card__avatar-initials {
  width: 64px; height: 64px;
  border-radius: 50%;
  background: var(--c-primary, #264653);
  color: #E9C46A;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem; font-weight: 800;
  margin: 0 auto;
}

.sp-review-card__stars {
  display: flex; gap: 2px; justify-content: center;
  margin-bottom: .85rem;
}

.sp-review-card__text {
  font-size: 1rem;
  line-height: 1.65;
  color: #334155;
  margin: 0 0 1.25rem;
  flex: 1;
}

.sp-review-card__author { text-align: center; }
.sp-review-card__name {
  display: block;
  font-size: .9rem;
  font-weight: 700;
  color: #1a3340;
  margin-bottom: .2rem;
}
.sp-review-card__company {
  display: block;
  font-size: .8rem;
  color: #94a3b8;
}

/* Decorative background star */
.sp-review-card__bg-icon {
  position: absolute;
  bottom: -10px; right: -10px;
  width: 80px; height: 80px;
  fill: #f1f5f9;
  pointer-events: none;
  z-index: 0;
}

/* Dots */
.sp-testi__dots {
  display: flex;
  justify-content: center;
  gap: .45rem;
  margin-top: 1.5rem;
}
.sp-testi__dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  border: none; padding: 0;
  background: #cbd5e1;
  cursor: pointer;
  transition: background .25s, transform .25s;
}
.sp-testi__dot--on,
.sp-testi__dot:hover {
  background: var(--c-primary, #264653);
  transform: scale(1.3);
}

@media (max-width: 576px) {
  .sp-testi { padding: 3.5rem 0; }
  .sp-review-card { padding: 1.25rem 1rem; }
  .sp-review-card__text { font-size: .9rem; }
}
</style>

<script>
(function () {
  'use strict';
  var wrap = document.getElementById('<?php echo $uid; ?>');
  if (!wrap) return;

  var slides = Array.from(wrap.querySelectorAll('.sp-testi__slide'));
  var dots   = Array.from(wrap.querySelectorAll('.sp-testi__dot'));
  var cur    = 0;
  var timer  = null;
  var total  = slides.length;
  if (total < 2) return;

  function go(idx) {
    slides[cur].classList.remove('sp-testi__slide--active');
    dots[cur].classList.remove('sp-testi__dot--on');
    dots[cur].setAttribute('aria-selected', 'false');
    cur = ((idx % total) + total) % total;
    slides[cur].classList.add('sp-testi__slide--active');
    dots[cur].classList.add('sp-testi__dot--on');
    dots[cur].setAttribute('aria-selected', 'true');
  }

  function startTimer() { clearInterval(timer); timer = setInterval(function () { go(cur + 1); }, 5000); }
  function stopTimer()  { clearInterval(timer); }

  dots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      stopTimer();
      go(parseInt(this.getAttribute('data-index'), 10));
      startTimer();
    });
  });

  wrap.addEventListener('mouseenter', stopTimer);
  wrap.addEventListener('mouseleave', startTimer);

  startTimer();
})();
</script>

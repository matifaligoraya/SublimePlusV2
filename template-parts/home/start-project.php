<?php
/**
 * Homepage — Start a Project CTA strip
 *
 * Bold dark band between the content sections and the inquiry form.
 * Links directly to #inquiry on the same page.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args = $args ?? [];

$eyebrow  = !empty($args['eyebrow']) ? $args['eyebrow'] : 'Ready When You Are';
$heading  = !empty($args['heading']) ? $args['heading'] : 'Start Your Next Project with Precast Al Turab';
$subtext  = !empty($args['subtext']) ? $args['subtext'] : 'From custom barrier solutions to large-scale supply contracts — our team is ready to quote, plan, and deliver anywhere in the UAE within 24 hours.';
$btn_text = !empty($args['btn_text']) ? $args['btn_text'] : 'Start a Project';
$phone    = !empty($args['phone'])    ? $args['phone']    : get_theme_mod('sp_footer_phone',    '+971 54 350 7724');
$whatsapp = !empty($args['whatsapp']) ? $args['whatsapp'] : get_theme_mod('sp_footer_whatsapp', 'https://wa.me/971543507724');

$_contact_pg = get_page_by_path('contact-us') ?: get_page_by_path('contact');
$inquiry_url = ($_contact_pg ? get_permalink($_contact_pg) : home_url('/')) . '#inquiry';

$benefits = [
    [
        'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'title' => '24-Hour Response',
        'desc'  => 'Our sales team replies within one business day with a detailed quote.',
    ],
    [
        'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
        'title' => 'Free Project Quote',
        'desc'  => 'No-obligation pricing with full material specs and delivery schedule.',
    ],
    [
        'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
        'title' => 'UAE-Wide Delivery',
        'desc'  => 'All seven emirates covered — Abu Dhabi, Dubai, Sharjah and beyond.',
    ],
];
?>

<section class="sp-cta" id="start-project" aria-labelledby="sp-cta-heading">

  <!-- Geometric pattern overlay -->
  <div class="sp-cta__pattern" aria-hidden="true"></div>

  <div class="container">
    <div class="sp-cta__inner">

      <!-- ── Left: headline + CTA ─────────────────────────────────────────── -->
      <div class="sp-cta__left">

        <span class="sp-cta__eyebrow"><?php echo esc_html($eyebrow); ?></span>

        <h2 class="sp-cta__heading" id="sp-cta-heading">
          <?php echo esc_html($heading); ?>
        </h2>

        <p class="sp-cta__sub"><?php echo esc_html($subtext); ?></p>

        <div class="sp-cta__actions">
          <a href="<?php echo esc_url($inquiry_url); ?>"
             class="sp-cta__btn sp-cta__btn--primary">
            <?php echo esc_html($btn_text); ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <?php if ($whatsapp) : ?>
          <a href="<?php echo esc_url($whatsapp); ?>"
             class="sp-cta__btn sp-cta__btn--ghost"
             target="_blank" rel="noopener noreferrer">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            Chat on WhatsApp
          </a>
          <?php endif; ?>
        </div>

        <?php if ($phone) : ?>
        <p class="sp-cta__phone-line">
          Or call us directly:&nbsp;
          <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
            <?php echo esc_html($phone); ?>
          </a>
        </p>
        <?php endif; ?>

      </div><!-- /.sp-cta__left -->

      <!-- ── Right: 3 benefit tiles ───────────────────────────────────────── -->
      <div class="sp-cta__benefits" aria-label="Why choose us">
        <?php foreach ($benefits as $b) : ?>
        <div class="sp-cta__benefit">
          <span class="sp-cta__benefit-icon" aria-hidden="true">
            <?php echo $b['icon']; ?>
          </span>
          <div>
            <strong class="sp-cta__benefit-title"><?php echo esc_html($b['title']); ?></strong>
            <span class="sp-cta__benefit-desc"><?php echo esc_html($b['desc']); ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div><!-- /.sp-cta__benefits -->

    </div><!-- /.sp-cta__inner -->
  </div>

</section>

<style>
/* ── Start a Project CTA strip ─────────────────────────────────────────────── */
.sp-cta {
  position: relative;
  padding: 5rem 0;
  background: linear-gradient(135deg, #0f1f32 0%, #1a3340 55%, #0f2030 100%);
  overflow: hidden;
}

/* Diagonal engineering-grid pattern */
.sp-cta__pattern {
  position: absolute; inset: 0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px),
    linear-gradient(rgba(255,255,255,.015) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.015) 1px, transparent 1px);
  background-size: 80px 80px, 80px 80px, 20px 20px, 20px 20px;
}

/* Orange top accent line */
.sp-cta::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--c-accent, #F97316) 0%, rgba(249,115,22,.3) 100%);
}

/* Large faint watermark shape — right bg decoration */
.sp-cta::after {
  content: '';
  position: absolute;
  right: -120px;
  top: 50%;
  transform: translateY(-50%);
  width: 520px;
  height: 520px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(249,115,22,.07) 0%, transparent 65%);
  pointer-events: none;
}

/* ── Layout ─────────────────────────────────────────────────────────────────── */
.sp-cta__inner {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: 1fr 420px;
  gap: 4rem;
  align-items: center;
}

/* ── Left: text ─────────────────────────────────────────────────────────────── */
.sp-cta__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  font-size: .7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .18em;
  color: var(--c-accent, #F97316);
  background: rgba(249,115,22,.12);
  border: 1px solid rgba(249,115,22,.28);
  padding: .32rem 1rem;
  border-radius: 50px;
  margin-bottom: 1.2rem;
}

.sp-cta__heading {
  font-size: clamp(1.75rem, 2.8vw, 2.6rem);
  font-weight: 800;
  line-height: 1.18;
  color: #fff;
  margin: 0 0 1.1rem;
  letter-spacing: -.01em;
}

.sp-cta__sub {
  font-size: .95rem;
  line-height: 1.75;
  color: rgba(255,255,255,.62);
  margin: 0 0 2rem;
  max-width: 520px;
}

/* ── Action buttons ─────────────────────────────────────────────────────────── */
.sp-cta__actions {
  display: flex;
  gap: .75rem;
  flex-wrap: wrap;
  align-items: center;
  margin-bottom: 1.25rem;
}

.sp-cta__btn {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  padding: .78rem 1.85rem;
  font-size: .82rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .09em;
  border-radius: 8px;
  text-decoration: none !important;
  border: 2px solid transparent;
  transition: all .22s ease;
  white-space: nowrap;
}

.sp-cta__btn--primary {
  background: var(--c-accent, #F97316);
  border-color: var(--c-accent, #F97316);
  color: #fff !important;
  box-shadow: 0 6px 24px rgba(249,115,22,.4);
}
.sp-cta__btn--primary:hover {
  background: var(--c-accent-dark, #ea6c0a);
  border-color: var(--c-accent-dark, #ea6c0a);
  box-shadow: 0 8px 32px rgba(249,115,22,.55);
  transform: translateY(-2px);
}

.sp-cta__btn--ghost {
  background: rgba(255,255,255,.08);
  border-color: rgba(255,255,255,.22);
  color: rgba(255,255,255,.88) !important;
}
.sp-cta__btn--ghost:hover {
  background: rgba(255,255,255,.14);
  border-color: rgba(255,255,255,.45);
  color: #fff !important;
}

.sp-cta__phone-line {
  font-size: .82rem;
  color: rgba(255,255,255,.42);
  margin: 0;
}
.sp-cta__phone-line a {
  color: rgba(255,255,255,.72);
  text-decoration: none;
  font-weight: 600;
  transition: color .18s;
}
.sp-cta__phone-line a:hover { color: #fff; }

/* ── Benefit tiles ─────────────────────────────────────────────────────────── */
.sp-cta__benefits {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.sp-cta__benefit {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.09);
  border-radius: 12px;
  padding: 1.1rem 1.25rem;
  transition: background .2s, border-color .2s;
}
.sp-cta__benefit:hover {
  background: rgba(255,255,255,.09);
  border-color: rgba(249,115,22,.3);
}

.sp-cta__benefit-icon {
  flex-shrink: 0;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  background: rgba(249,115,22,.12);
  border: 1px solid rgba(249,115,22,.22);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--c-accent, #F97316);
}

.sp-cta__benefit-title {
  display: block;
  font-size: .87rem;
  font-weight: 700;
  color: #f1f5f9;
  margin-bottom: .22rem;
  line-height: 1.3;
}

.sp-cta__benefit-desc {
  display: block;
  font-size: .77rem;
  color: rgba(255,255,255,.48);
  line-height: 1.5;
}

/* ── Responsive ─────────────────────────────────────────────────────────────── */
@media (max-width: 1099px) {
  .sp-cta__inner {
    grid-template-columns: 1fr 360px;
    gap: 3rem;
  }
}

@media (max-width: 899px) {
  .sp-cta { padding: 3.75rem 0; }
  .sp-cta__inner {
    grid-template-columns: 1fr;
    gap: 2.5rem;
  }
  .sp-cta__benefits {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .85rem;
  }
  .sp-cta__benefit {
    flex-direction: column;
    gap: .65rem;
  }
}

@media (max-width: 576px) {
  .sp-cta { padding: 3rem 0; }
  .sp-cta__benefits { grid-template-columns: 1fr; }
  .sp-cta__actions { flex-direction: column; align-items: flex-start; }
  .sp-cta__btn { width: 100%; justify-content: center; }
}
</style>

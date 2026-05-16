<?php
/**
 * Homepage — Product Catalogue
 * Bento-style interactive grid: featured first card + filterable regular cards.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args     = $args ?? [];
$heading  = $args['heading']  ?? get_theme_mod('sp_products_heading', 'Product Catalogue');
$subtext  = $args['subtext']  ?? get_theme_mod('sp_products_subtext', 'Explore our complete range of RTA-approved precast concrete solutions, manufactured for UAE infrastructure projects.');
$cta_text = $args['cta_text'] ?? get_theme_mod('sp_products_cta_text', 'View Full Catalogue');
$cta_url  = $args['cta_url']  ?? get_theme_mod('sp_products_cta_url',  get_post_type_archive_link('sp_product') ?: '#');

$contact_url = get_permalink(get_page_by_path('contact')) ?: '#inquiry';

$query = new WP_Query([
    'post_type'      => 'sp_product',
    'posts_per_page' => 5,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

if (!$query->have_posts()) return;

$total_published = (int) wp_count_posts('sp_product')->publish;

$cat_terms = get_terms([
    'taxonomy'   => 'sp_product_cat',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
]);

// ── Build products array ──────────────────────────────────────────────────────
$products = [];
foreach ($query->posts as $idx => $_p) {
    $pid = $_p->ID;

    $thumb_id    = (int) get_post_thumbnail_id($pid);
    $gallery_raw = get_post_meta($pid, '_sp_product_gallery', true);
    $gallery_ids = $gallery_raw ? array_filter(array_map('absint', explode(',', $gallery_raw))) : [];
    if ($thumb_id) array_unshift($gallery_ids, $thumb_id);
    $gallery_ids = array_unique(array_slice($gallery_ids, 0, 4));

    $img_url = '';
    if (!empty($gallery_ids)) {
        $img_url = wp_get_attachment_image_url(reset($gallery_ids), 'large') ?: '';
    }

    $specs_raw   = get_post_meta($pid, '_sp_product_specs', true);
    $specs_all   = $specs_raw ? (array) json_decode($specs_raw, true) : [];
    $specs_clean = array_values(array_filter($specs_all, function ($s) {
        return !empty($s[0]) && !empty($s[1]);
    }));

    $certs        = get_post_meta($pid, '_sp_product_certifications', true);
    $material     = get_post_meta($pid, '_sp_product_material',       true);
    $datasheet_id = (int) get_post_meta($pid, '_sp_product_datasheet', true);
    $datasheet    = $datasheet_id ? wp_get_attachment_url($datasheet_id) : '';

    $terms     = get_the_terms($pid, 'sp_product_cat');
    $cat_slugs = [];
    $cat_name  = '';
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $t) $cat_slugs[] = $t->slug;
        $cat_name = $terms[0]->name;
    }

    $is_rta = $certs && (bool) preg_match('/\bRTA\b/i', $certs);
    $is_new = (time() - strtotime($_p->post_date)) < 60 * DAY_IN_SECONDS;
    $num_str = str_pad($idx + 1, 2, '0', STR_PAD_LEFT); // "01", "02" …

    $products[] = compact(
        'pid', 'img_url', 'specs_clean', 'certs', 'material',
        'datasheet', 'cat_slugs', 'cat_name', 'is_rta', 'is_new', 'num_str'
    ) + [
        'title'     => get_the_title($pid),
        'excerpt'   => get_the_excerpt($_p),
        'permalink' => get_permalink($pid),
    ];
}
?>

<section class="sp-catalogue" id="products">
  <div class="container">

    <!-- ── Header ─────────────────────────────────────────────────────────── -->
    <div class="sp-catalogue__head">
      <div class="sp-catalogue__title-block">
        <span class="sp-catalogue__eyebrow">Product Range</span>
        <h2 class="sp-catalogue__heading"><?php echo esc_html($heading); ?></h2>
        <p class="sp-catalogue__sub"><?php echo esc_html($subtext); ?></p>
      </div>

      <?php if (!empty($cat_terms) && !is_wp_error($cat_terms)) : ?>
      <div class="sp-catalogue__filters" role="tablist" aria-label="Filter by product category">
        <button class="sp-cf-btn sp-cf-btn--active" data-filter="*" role="tab" aria-selected="true">
          All Products
        </button>
        <?php foreach ($cat_terms as $term) : ?>
        <button class="sp-cf-btn" data-filter="<?php echo esc_attr($term->slug); ?>" role="tab" aria-selected="false">
          <?php echo esc_html($term->name); ?>
        </button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <!-- ── Bento grid ─────────────────────────────────────────────────────── -->
    <div class="sp-catalogue__grid" id="sp-catalogue-grid">

      <?php foreach ($products as $idx => $p) :
        $cat_str    = implode(' ', $p['cat_slugs']);
        $is_first   = ($idx === 0);
        $card_class = 'sp-prod-card';
        if ($is_first) $card_class .= ' sp-featured';
      ?>
      <article class="<?php echo $card_class; ?>"
               data-cat="<?php echo esc_attr($cat_str); ?>"
               style="--sp-delay: <?php echo $idx * 0.07; ?>s">

        <!-- ── Media ──────────────────────────────────────────────────────── -->
        <a href="<?php echo esc_url($p['permalink']); ?>"
           class="sp-prod-card__media"
           tabindex="-1" aria-hidden="true">

          <?php if ($p['img_url']) : ?>
            <img src="<?php echo esc_url($p['img_url']); ?>"
                 alt="<?php echo esc_attr($p['title']); ?>"
                 class="sp-prod-card__img"
                 width="600" height="412"
                 loading="<?php echo $is_first ? 'eager' : 'lazy'; ?>" decoding="async">
          <?php else : ?>
            <div class="sp-prod-card__no-img">
              <svg viewBox="0 0 64 64" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="14" width="56" height="40" rx="4"/><path d="M4 38l14-12 10 10 10-8 10 10"/><circle cx="20" cy="26" r="4"/></svg>
            </div>
          <?php endif; ?>

          <!-- Overlay badges -->
          <div class="sp-prod-card__badges">
            <div class="sp-prod-card__badges-left">
              <?php if ($p['cat_name']) : ?>
              <span class="sp-prod-card__badge sp-prod-card__badge--cat">
                <?php echo esc_html($p['cat_name']); ?>
              </span>
              <?php endif; ?>
              <?php if ($p['is_new']) : ?>
              <span class="sp-prod-card__badge sp-prod-card__badge--new">New</span>
              <?php endif; ?>
            </div>
            <?php if ($p['is_rta']) : ?>
            <span class="sp-prod-card__badge sp-prod-card__badge--rta">
              <svg viewBox="0 0 24 24" width="9" height="9" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              RTA Approved
            </span>
            <?php endif; ?>
          </div>

          <!-- Hover quick-spec overlay -->
          <?php if (!empty($p['specs_clean'])) : ?>
          <div class="sp-prod-card__hover-overlay" aria-hidden="true">
            <span class="sp-prod-card__hover-label">Quick Specs</span>
            <div class="sp-prod-card__hover-specs">
              <?php foreach (array_slice($p['specs_clean'], 0, $is_first ? 4 : 3) as $hs) : ?>
              <span class="sp-prod-card__hover-pill">
                <strong><?php echo esc_html($hs[0]); ?></strong>
                <?php echo esc_html($hs[1]); ?>
              </span>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

        </a>

        <!-- ── Body ───────────────────────────────────────────────────────── -->
        <div class="sp-prod-card__body" data-num="<?php echo esc_attr($p['num_str']); ?>">

          <?php if ($is_first) : ?>
          <span class="sp-prod-card__featured-tag">
            <svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Featured Product
          </span>
          <?php endif; ?>

          <h3 class="sp-prod-card__title">
            <a href="<?php echo esc_url($p['permalink']); ?>"><?php echo esc_html($p['title']); ?></a>
          </h3>

          <?php if ($p['excerpt']) : ?>
          <p class="sp-prod-card__exc"><?php echo esc_html($p['excerpt']); ?></p>
          <?php endif; ?>

          <!-- Spec chips -->
          <?php if (!empty($p['specs_clean'])) : ?>
          <div class="sp-prod-card__chips">
            <?php foreach (array_slice($p['specs_clean'], 0, $is_first ? 5 : 3) as $chip) : ?>
            <span class="sp-prod-card__chip">
              <span class="sp-prod-card__chip-k"><?php echo esc_html($chip[0]); ?></span>
              <span class="sp-prod-card__chip-v"><?php echo esc_html($chip[1]); ?></span>
            </span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <!-- Certifications -->
          <?php if ($p['certs']) : ?>
          <p class="sp-prod-card__certs">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <?php echo esc_html($p['certs']); ?>
          </p>
          <?php endif; ?>

          <!-- Actions -->
          <div class="sp-prod-card__actions">
            <a href="<?php echo esc_url($p['permalink']); ?>"
               class="sp-prod-card__btn sp-prod-card__btn--view">
              View Details
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="<?php echo esc_url($contact_url); ?>?ref=<?php echo urlencode($p['title']); ?>"
               class="sp-prod-card__btn sp-prod-card__btn--quote">
              Get Quote
            </a>
            <?php if ($p['datasheet']) : ?>
            <a href="<?php echo esc_url($p['datasheet']); ?>"
               class="sp-prod-card__pdf"
               target="_blank" rel="noopener noreferrer"
               title="Download datasheet — <?php echo esc_attr($p['title']); ?>">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
            </a>
            <?php endif; ?>
          </div>

        </div><!-- /.sp-prod-card__body -->
      </article>
      <?php endforeach; ?>

    </div><!-- /.sp-catalogue__grid -->

    <!-- ── Footer ─────────────────────────────────────────────────────────── -->
    <div class="sp-catalogue__footer">
      <p class="sp-catalogue__count" id="sp-cat-count">
        Showing <strong><?php echo count($products); ?></strong> of
        <strong><?php echo $total_published; ?></strong> products
      </p>
      <?php if ($cta_url && $cta_text) : ?>
      <a href="<?php echo esc_url($cta_url); ?>" class="sp-catalogue__cta">
        <?php echo esc_html($cta_text); ?>
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <?php endif; ?>
    </div>

  </div>
</section>

<style>
/* ═══════════════════════════════════════════════════════════════════════════
   PRODUCT CATALOGUE — complete styles
   ═══════════════════════════════════════════════════════════════════════════ */

/* ── Section ──────────────────────────────────────────────────────────────── */
.sp-catalogue {
  padding: 5.5rem 0;
  /* Subtle dot-grid pattern over light background */
  background-color: #f1f5f9;
  background-image: radial-gradient(circle, #cbd5e1 1px, transparent 1px);
  background-size: 22px 22px;
}

/* ── Header ───────────────────────────────────────────────────────────────── */
.sp-catalogue__head {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 2rem;
  margin-bottom: 2.75rem;
  flex-wrap: wrap;
}
.sp-catalogue__eyebrow {
  display: inline-block;
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .14em;
  color: var(--c-primary, #264653);
  background: rgba(38,70,83,.08);
  padding: .3rem .9rem;
  border-radius: 50px;
  margin-bottom: 1rem;
}
.sp-catalogue__heading {
  font-size: clamp(1.7rem, 2.5vw, 2.4rem);
  font-weight: 800;
  line-height: 1.2;
  color: #1a3340;
  margin: 0 0 .65rem;
}
.sp-catalogue__sub {
  font-size: .93rem;
  color: #64748b;
  line-height: 1.7;
  margin: 0;
  max-width: 500px;
}

/* ── Category filter tabs ─────────────────────────────────────────────────── */
.sp-catalogue__filters {
  display: flex;
  gap: .45rem;
  flex-wrap: wrap;
  justify-content: flex-end;
  align-self: flex-start;
  padding-top: .25rem;
}
.sp-cf-btn {
  padding: .48rem 1.15rem;
  font-size: .77rem;
  font-weight: 600;
  letter-spacing: .03em;
  border: 1.5px solid #d4dce5;
  border-radius: 50px;
  background: #fff;
  color: #64748b;
  cursor: pointer;
  white-space: nowrap;
  transition: all .22s ease;
  line-height: 1;
}
.sp-cf-btn:hover {
  border-color: var(--c-primary, #264653);
  color: var(--c-primary, #264653);
}
.sp-cf-btn--active {
  background: var(--c-primary, #264653) !important;
  border-color: var(--c-primary, #264653) !important;
  color: #fff !important;
  box-shadow: 0 4px 14px rgba(38,70,83,.3);
}

/* ═══════════════════════════════════════════════════════════════════════════
   BENTO GRID
   Desktop: 3 cols — featured card spans first 2, third column normal card
   Row 2+: regular 3-column
   ═══════════════════════════════════════════════════════════════════════════ */
.sp-catalogue__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-auto-rows: auto;
  gap: 1.5rem;
  margin-bottom: 2.25rem;
}

/* ── Card — base ──────────────────────────────────────────────────────────── */
.sp-prod-card {
  background: #fff;
  border-radius: 18px;
  border: 1px solid #e2eaf0;
  border-top: 3.5px solid var(--c-primary, #264653);   /* teal accent top */
  overflow: hidden;
  display: flex;
  flex-direction: column;
  will-change: transform;
  position: relative;
  /* Staggered entrance animation */
  animation: sp-card-rise .55s cubic-bezier(.22,.61,.36,1) both;
  animation-delay: var(--sp-delay, 0s);
  transition: box-shadow .3s ease, transform .3s ease,
              border-top-color .3s ease, border-color .3s ease;
}
.sp-prod-card:hover {
  box-shadow: 0 20px 60px rgba(26,51,64,.14), 0 0 0 1px rgba(38,70,83,.06);
  transform: translateY(-6px);
  border-top-color: var(--c-accent, #E9C46A);   /* gold on hover */
  border-color: #c5d5e0;
}
.sp-prod-card.sp-hidden { display: none; }

@keyframes sp-card-rise {
  from { opacity: 0; transform: translateY(24px) scale(.98); }
  to   { opacity: 1; transform: translateY(0)    scale(1);   }
}

/* ── FEATURED card (first / .sp-featured) ─────────────────────────────────── */
.sp-prod-card.sp-featured {
  grid-column: 1 / span 2;     /* takes up 2 of the 3 columns */
  flex-direction: row;          /* horizontal: image left, body right */
  min-height: 340px;
}
.sp-prod-card.sp-featured .sp-prod-card__media {
  flex: 0 0 52%;
  aspect-ratio: unset;          /* full card height */
  min-height: 300px;
}
.sp-prod-card.sp-featured .sp-prod-card__body {
  padding: 2rem 2rem 1.75rem;
  justify-content: center;
}
.sp-prod-card.sp-featured .sp-prod-card__title {
  font-size: 1.3rem;
  margin-bottom: .1rem;
}
.sp-prod-card.sp-featured .sp-prod-card__exc {
  -webkit-line-clamp: 3;
}

/* ── Media area ───────────────────────────────────────────────────────────── */
.sp-prod-card__media {
  position: relative;
  display: block;
  overflow: hidden;
  aspect-ratio: 16 / 11;
  background: #e9eff5;
  text-decoration: none;
  flex-shrink: 0;
}
.sp-prod-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .6s cubic-bezier(.22,.61,.36,1);
}
.sp-prod-card:hover .sp-prod-card__img { transform: scale(1.07); }

.sp-prod-card__no-img {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #b8cdd8;
  background: linear-gradient(135deg, #edf2f7 0%, #e2eaf0 100%);
}

/* ── Image badges (top of media) ──────────────────────────────────────────── */
.sp-prod-card__badges {
  position: absolute;
  top: .8rem;
  left: .8rem;
  right: .8rem;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: .4rem;
  pointer-events: none;
  z-index: 2;
}
.sp-prod-card__badges-left {
  display: flex;
  flex-direction: column;
  gap: .3rem;
  align-items: flex-start;
}
.sp-prod-card__badge {
  display: inline-flex;
  align-items: center;
  gap: .25rem;
  padding: .28rem .72rem;
  font-size: .67rem;
  font-weight: 700;
  letter-spacing: .07em;
  text-transform: uppercase;
  border-radius: 50px;
  line-height: 1;
  backdrop-filter: blur(8px);
}
.sp-prod-card__badge--cat {
  background: rgba(26,51,64,.8);
  color: #fff;
}
.sp-prod-card__badge--new {
  background: rgba(245,158,11,.9);
  color: #fff;
}
.sp-prod-card__badge--rta {
  background: rgba(22,163,74,.88);
  color: #fff;
  margin-left: auto;
}

/* ── Hover overlay (quick specs) ──────────────────────────────────────────── */
.sp-prod-card__hover-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(16,36,48,.94) 0%,
    rgba(16,36,48,.6)  50%,
    transparent        100%
  );
  opacity: 0;
  pointer-events: none;
  transition: opacity .35s ease;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1.1rem 1rem 1rem;
  z-index: 1;
}
.sp-prod-card:hover .sp-prod-card__hover-overlay { opacity: 1; }

.sp-prod-card__hover-label {
  font-size: .63rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .13em;
  color: var(--c-accent, #E9C46A);
  margin: 0 0 .45rem;
}
.sp-prod-card__hover-specs {
  display: flex;
  gap: .38rem;
  flex-wrap: wrap;
}
.sp-prod-card__hover-pill {
  font-size: .72rem;
  color: rgba(255,255,255,.92);
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 5px;
  padding: .2rem .58rem;
  line-height: 1.4;
}
.sp-prod-card__hover-pill strong {
  color: #E9C46A;
  font-weight: 600;
  margin-right: .28rem;
}

/* ═══════════════════════════════════════════════════════════════════════════
   CARD BODY
   ═══════════════════════════════════════════════════════════════════════════ */
.sp-prod-card__body {
  padding: 1.35rem 1.3rem 1.2rem;
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: .6rem;
  position: relative;     /* for ghost number pseudo-element */
  overflow: hidden;
}

/* Ghost index number in the background */
.sp-prod-card__body::after {
  content: attr(data-num);
  position: absolute;
  bottom: -.7rem;
  right: .5rem;
  font-size: 7.5rem;
  font-weight: 900;
  line-height: 1;
  color: var(--c-primary, #264653);
  opacity: .04;
  pointer-events: none;
  user-select: none;
  z-index: 0;
  font-family: inherit;
  transition: opacity .3s;
}
.sp-prod-card:hover .sp-prod-card__body::after { opacity: .07; }

/* All content in body sits above ghost number */
.sp-prod-card__body > * { position: relative; z-index: 1; }

/* ── Featured eyebrow tag ─────────────────────────────────────────────────── */
.sp-prod-card__featured-tag {
  display: inline-flex;
  align-items: center;
  gap: .3rem;
  font-size: .67rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--c-accent, #E9C46A);
  background: rgba(233,196,106,.12);
  border: 1px solid rgba(233,196,106,.35);
  padding: .28rem .75rem;
  border-radius: 50px;
  width: fit-content;
}

/* ── Title ────────────────────────────────────────────────────────────────── */
.sp-prod-card__title {
  font-size: 1rem;
  font-weight: 700;
  line-height: 1.3;
  margin: 0;
  color: #1a3340;
}
.sp-prod-card__title a {
  color: inherit;
  text-decoration: none;
  transition: color .2s;
}
.sp-prod-card__title a:hover { color: var(--c-primary, #264653); }

/* ── Excerpt ──────────────────────────────────────────────────────────────── */
.sp-prod-card__exc {
  font-size: .83rem;
  color: #64748b;
  line-height: 1.65;
  margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* ── Spec chips ───────────────────────────────────────────────────────────── */
.sp-prod-card__chips {
  display: flex;
  flex-wrap: wrap;
  gap: .32rem;
}
.sp-prod-card__chip {
  display: inline-flex;
  align-items: center;
  gap: .3rem;
  background: #f1f5f9;
  border: 1px solid #e2eaf0;
  border-radius: 6px;
  padding: .22rem .62rem;
  font-size: .7rem;
  line-height: 1.35;
  transition: background .2s, border-color .2s;
}
.sp-prod-card:hover .sp-prod-card__chip {
  background: #e8f0f6;
  border-color: #c8d8e8;
}
.sp-prod-card__chip-k { color: #94a3b8; font-weight: 500; }
.sp-prod-card__chip-v { color: #1e293b; font-weight: 700; }

/* ── Certifications ───────────────────────────────────────────────────────── */
.sp-prod-card__certs {
  display: flex;
  align-items: center;
  gap: .35rem;
  font-size: .73rem;
  color: #64748b;
  margin: 0;
  line-height: 1.4;
}
.sp-prod-card__certs svg { flex-shrink: 0; color: #16a34a; }

/* ── Action buttons ───────────────────────────────────────────────────────── */
.sp-prod-card__actions {
  display: flex;
  align-items: center;
  gap: .45rem;
  margin-top: auto;
  padding-top: .95rem;
  border-top: 1px solid #eef2f7;
}
.sp-prod-card__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .3rem;
  font-size: .73rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .07em;
  border-radius: 8px;
  padding: .55rem .9rem;
  text-decoration: none !important;
  border: 1.5px solid;
  transition: all .22s ease;
  white-space: nowrap;
  flex: 1;
}
.sp-prod-card__btn--view {
  color: var(--c-primary, #264653) !important;
  border-color: var(--c-primary, #264653);
  background: transparent;
}
.sp-prod-card__btn--view:hover {
  background: var(--c-primary, #264653);
  color: #fff !important;
  box-shadow: 0 4px 12px rgba(38,70,83,.25);
}
.sp-prod-card__btn--quote {
  background: var(--c-accent, #E9C46A);
  border-color: var(--c-accent, #E9C46A);
  color: #1a3340 !important;
}
.sp-prod-card__btn--quote:hover {
  background: var(--c-accent-dark, #d4a843);
  border-color: var(--c-accent-dark, #d4a843);
  box-shadow: 0 4px 12px rgba(233,196,106,.4);
}
.sp-prod-card__pdf {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex: 0 0 37px;
  width: 37px;
  height: 37px;
  border: 1.5px solid #e2eaf0;
  border-radius: 8px;
  color: #94a3b8;
  text-decoration: none !important;
  transition: all .22s ease;
  flex-shrink: 0;
}
.sp-prod-card__pdf:hover {
  border-color: #ef4444;
  color: #ef4444;
  background: #fef2f2;
}

/* ── Footer ───────────────────────────────────────────────────────────────── */
.sp-catalogue__footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
  padding-top: 1.75rem;
  border-top: 1px solid #e2eaf0;
}
.sp-catalogue__count {
  font-size: .84rem;
  color: #94a3b8;
  margin: 0;
}
.sp-catalogue__count strong { color: #1e293b; font-weight: 700; }
.sp-catalogue__cta {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  font-size: .83rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: #fff !important;
  background: var(--c-primary, #264653);
  padding: .72rem 1.85rem;
  border-radius: 9px;
  text-decoration: none !important;
  border: 2px solid var(--c-primary, #264653);
  transition: background .2s, border-color .2s, box-shadow .2s;
}
.sp-catalogue__cta:hover {
  background: var(--c-primary-dark, #1a3340);
  border-color: var(--c-primary-dark, #1a3340);
  box-shadow: 0 6px 20px rgba(38,70,83,.3);
}

/* ── Responsive ───────────────────────────────────────────────────────────── */
@media (max-width: 1199px) {
  .sp-catalogue__head    { flex-direction: column; align-items: flex-start; }
  .sp-catalogue__filters { justify-content: flex-start; }
}

/* Tablet: 2 cols, featured spans full width but stacks vertically */
@media (max-width: 991px) {
  .sp-catalogue__grid         { grid-template-columns: repeat(2, 1fr); }
  .sp-prod-card.sp-featured   { grid-column: 1 / span 2; flex-direction: column; min-height: unset; }
  .sp-prod-card.sp-featured .sp-prod-card__media { flex: unset; aspect-ratio: 16 / 9; min-height: unset; }
  .sp-prod-card.sp-featured .sp-prod-card__body  { padding: 1.5rem; justify-content: flex-start; }
  .sp-prod-card.sp-featured .sp-prod-card__title { font-size: 1.1rem; }
}

/* Mobile: single column, no bento */
@media (max-width: 576px) {
  .sp-catalogue       { padding: 3.5rem 0; }
  .sp-catalogue__grid { grid-template-columns: 1fr; gap: 1rem; }
  .sp-prod-card.sp-featured { grid-column: auto; flex-direction: column; }
  .sp-prod-card.sp-featured .sp-prod-card__media { aspect-ratio: 16 / 11; flex: unset; }
  .sp-catalogue__footer  { flex-direction: column; align-items: flex-start; }
  .sp-catalogue__cta     { width: 100%; justify-content: center; }
  .sp-prod-card__body::after { font-size: 5.5rem; }
}
</style>

<script>
(function () {
  'use strict';
  var grid    = document.getElementById('sp-catalogue-grid');
  var counter = document.getElementById('sp-cat-count');
  if (!grid) return;

  var cards   = Array.from(grid.querySelectorAll('.sp-prod-card'));
  var buttons = Array.from(document.querySelectorAll('.sp-cf-btn'));
  if (!buttons.length) return;

  function applyFilter(filter) {
    var visible = 0;
    var firstVisible = null;

    // Reset featured from all cards first
    cards.forEach(function (card) {
      card.classList.remove('sp-featured');
    });

    cards.forEach(function (card) {
      var cats = (card.getAttribute('data-cat') || '').split(' ');
      var show = filter === '*' || cats.indexOf(filter) !== -1;
      card.classList.toggle('sp-hidden', !show);
      if (show) {
        visible++;
        if (!firstVisible) firstVisible = card;
      }
    });

    // Re-assign featured to first visible card
    if (firstVisible) firstVisible.classList.add('sp-featured');

    if (counter) {
      var strongs = counter.querySelectorAll('strong');
      if (strongs.length) strongs[0].textContent = visible;
    }
  }

  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      buttons.forEach(function (b) {
        b.classList.remove('sp-cf-btn--active');
        b.setAttribute('aria-selected', 'false');
      });
      this.classList.add('sp-cf-btn--active');
      this.setAttribute('aria-selected', 'true');
      applyFilter(this.getAttribute('data-filter'));
    });
  });
})();
</script>

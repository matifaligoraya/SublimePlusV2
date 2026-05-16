<?php
/**
 * Single project detail page — sp_project CPT.
 *
 * @package SublimePlusV2
 */
get_header();

if (!have_posts()) { get_footer(); return; }
the_post();

$pid          = get_the_ID();
$title        = get_the_title();
$content      = get_the_content();
$excerpt      = get_the_excerpt();
$featured_url = get_the_post_thumbnail_url($pid, 'full') ?: '';

// Meta fields
$client       = get_post_meta($pid, '_sp_project_client',  true);
$emirate_key  = get_post_meta($pid, '_sp_project_emirate', true);
$status       = get_post_meta($pid, '_sp_project_status',  true);
$scale        = get_post_meta($pid, '_sp_project_scale',   true);
$value        = get_post_meta($pid, '_sp_project_value',   true);
$date_raw     = get_post_meta($pid, '_sp_project_date',    true);
$products_raw = get_post_meta($pid, '_sp_project_products', true);
$gallery_raw  = get_post_meta($pid, '_sp_project_gallery',  true);

$emirate_map = [
    'dubai'          => 'Dubai',
    'abu-dhabi'      => 'Abu Dhabi',
    'sharjah'        => 'Sharjah',
    'ajman'          => 'Ajman',
    'ras-al-khaimah' => 'Ras Al Khaimah',
    'fujairah'       => 'Fujairah',
    'western-region' => 'Western Region',
    'uae'            => 'UAE Nationwide',
];
$emirate_label = $emirate_map[$emirate_key] ?? $emirate_key;

$status_label = ['completed' => 'Completed', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming'][$status] ?? '';
$date_label   = $date_raw ? date_i18n('F Y', strtotime($date_raw)) : '';

// Gallery IDs
$gallery_ids  = is_array($gallery_raw) ? array_filter(array_map('absint', $gallery_raw)) : [];
if (empty($gallery_ids) && $featured_url) {
    $thumb_id = get_post_thumbnail_id($pid);
    if ($thumb_id) $gallery_ids = [$thumb_id];
}

// Active image: use first gallery item or featured
$main_img_id  = !empty($gallery_ids) ? reset($gallery_ids) : get_post_thumbnail_id($pid);
$main_img_url = $main_img_id ? wp_get_attachment_image_url($main_img_id, 'large') : $featured_url;

// Categories
$cats = get_the_terms($pid, 'sp_project_cat');

// Related products
$related_product_ids = $products_raw ? json_decode($products_raw, true) : [];
if (!is_array($related_product_ids)) $related_product_ids = [];

$related_products = [];
if ($related_product_ids) {
    $rq = new WP_Query([
        'post_type'      => 'sp_product',
        'post__in'       => $related_product_ids,
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'orderby'        => 'post__in',
    ]);
    while ($rq->have_posts()) {
        $rq->the_post();
        $rpid = get_the_ID();
        $related_products[] = [
            'id'      => $rpid,
            'title'   => get_the_title(),
            'link'    => get_the_permalink(),
            'img'     => get_the_post_thumbnail_url($rpid, 'medium') ?: '',
            'excerpt' => get_the_excerpt(),
        ];
    }
    wp_reset_postdata();
}

// Inquiry page URL (best effort)
$inquiry_url = get_the_permalink(get_page_by_path('contact')) ?: home_url('/#inquiry');
?>

<main id="primary" class="content-area sp-single-project">

  <!-- ── Hero ────────────────────────────────────────────────────────────── -->
  <div class="sp-proj-hero"<?php if ($featured_url) : ?> style="background-image:url(<?php echo esc_url($featured_url); ?>)"<?php endif; ?>>
    <div class="sp-proj-hero__overlay"></div>
    <div class="container">
      <nav class="sp-proj-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'sublimeplus'); ?></a>
        <span>›</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>"><?php _e('Projects', 'sublimeplus'); ?></a>
        <span>›</span>
        <span><?php echo esc_html($title); ?></span>
      </nav>

      <?php if ($cats && !is_wp_error($cats)) : ?>
      <div class="sp-proj-hero__cats">
        <?php foreach ($cats as $cat) : ?>
        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="sp-proj-cat-tag">
          <?php echo esc_html($cat->name); ?>
        </a>
        <?php endforeach; ?>
        <?php if ($status_label) : ?>
        <span class="sp-proj-hero__status sp-proj-hero__status--<?php echo esc_attr($status); ?>">
          <?php echo esc_html($status_label); ?>
        </span>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <h1 class="sp-proj-hero__title"><?php echo esc_html($title); ?></h1>

      <?php if ($excerpt) : ?>
      <p class="sp-proj-hero__excerpt"><?php echo esc_html($excerpt); ?></p>
      <?php endif; ?>

      <div class="sp-proj-hero__stats">
        <?php if ($client) : ?>
        <div class="sp-proj-hero__stat">
          <span class="sp-proj-hero__stat-label"><?php _e('Client', 'sublimeplus'); ?></span>
          <span class="sp-proj-hero__stat-value"><?php echo esc_html($client); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($emirate_label) : ?>
        <div class="sp-proj-hero__stat">
          <span class="sp-proj-hero__stat-label"><?php _e('Location', 'sublimeplus'); ?></span>
          <span class="sp-proj-hero__stat-value"><?php echo esc_html($emirate_label); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($scale) : ?>
        <div class="sp-proj-hero__stat">
          <span class="sp-proj-hero__stat-label"><?php _e('Scale', 'sublimeplus'); ?></span>
          <span class="sp-proj-hero__stat-value"><?php echo esc_html($scale); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($value) : ?>
        <div class="sp-proj-hero__stat">
          <span class="sp-proj-hero__stat-label"><?php _e('Contract Value', 'sublimeplus'); ?></span>
          <span class="sp-proj-hero__stat-value"><?php echo esc_html($value); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($date_label) : ?>
        <div class="sp-proj-hero__stat">
          <span class="sp-proj-hero__stat-label"><?php _e('Completed', 'sublimeplus'); ?></span>
          <span class="sp-proj-hero__stat-value"><?php echo esc_html($date_label); ?></span>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ── Content + Gallery ────────────────────────────────────────────────── -->
  <div class="sp-proj-body">
    <div class="container">
      <div class="sp-proj-layout">

        <!-- Gallery column -->
        <?php if (!empty($gallery_ids) || $main_img_url) : ?>
        <div class="sp-proj-gallery">
          <div class="sp-proj-gallery__main" id="sp-proj-main-img">
            <?php if ($main_img_url) : ?>
            <img src="<?php echo esc_url($main_img_url); ?>"
                 alt="<?php echo esc_attr($title); ?>"
                 id="sp-proj-main-src"
                 loading="eager" decoding="async">
            <?php endif; ?>
          </div>
          <?php if (count($gallery_ids) > 1) : ?>
          <div class="sp-proj-gallery__thumbs" role="list">
            <?php foreach ($gallery_ids as $gid) :
              $thumb   = wp_get_attachment_image_url($gid, 'thumbnail');
              $full    = wp_get_attachment_image_url($gid, 'large');
              $alt     = get_post_meta($gid, '_wp_attachment_image_alt', true) ?: $title;
              if (!$thumb) continue;
            ?>
            <button type="button"
                    class="sp-proj-gallery__thumb<?php echo ($gid === $main_img_id) ? ' active' : ''; ?>"
                    data-full="<?php echo esc_url($full); ?>"
                    aria-label="<?php echo esc_attr($alt); ?>"
                    role="listitem">
              <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($alt); ?>">
            </button>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Content column -->
        <div class="sp-proj-content">
          <?php if ($content) : ?>
          <div class="sp-proj-content__body entry-content">
            <?php echo wp_kses_post(apply_filters('the_content', $content)); ?>
          </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- ── Related Products ─────────────────────────────────────────────────── -->
  <?php if (!empty($related_products)) : ?>
  <div class="sp-proj-related">
    <div class="container">
      <h2 class="sp-proj-related__heading"><?php _e('Products Used in This Project', 'sublimeplus'); ?></h2>
      <div class="sp-proj-related__grid">
        <?php foreach ($related_products as $rp) : ?>
        <a href="<?php echo esc_url($rp['link']); ?>" class="sp-proj-related__card">
          <?php if ($rp['img']) : ?>
          <div class="sp-proj-related__card-img">
            <img src="<?php echo esc_url($rp['img']); ?>"
                 alt="<?php echo esc_attr($rp['title']); ?>"
                 loading="lazy" decoding="async">
          </div>
          <?php endif; ?>
          <div class="sp-proj-related__card-body">
            <h3><?php echo esc_html($rp['title']); ?></h3>
            <?php if ($rp['excerpt']) : ?>
            <p><?php echo esc_html($rp['excerpt']); ?></p>
            <?php endif; ?>
            <span class="sp-proj-related__cta">
              <?php _e('View Product', 'sublimeplus'); ?>
              <svg viewBox="0 0 16 16" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="9 3 14 8 9 13"/></svg>
            </span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── CTA ──────────────────────────────────────────────────────────────── -->
  <div class="sp-proj-cta-section">
    <div class="container">
      <div class="sp-proj-cta-inner">
        <div class="sp-proj-cta-text">
          <h2><?php _e('Need a Similar Solution?', 'sublimeplus'); ?></h2>
          <p><?php _e('Our team delivers across all UAE emirates — from single-site orders to large multi-phase programmes. Get a quote within 24 hours.', 'sublimeplus'); ?></p>
        </div>
        <div class="sp-proj-cta-actions">
          <a href="<?php echo esc_url($inquiry_url); ?>" class="cta-primary">
            <?php _e('Get a Quote', 'sublimeplus'); ?>
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="9 3 14 8 9 13"/></svg>
          </a>
          <a href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>" class="cta-outline">
            <?php _e('All Projects', 'sublimeplus'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

</main>

<script>
(function() {
    var mainImg = document.getElementById('sp-proj-main-src');
    if (!mainImg) return;
    document.querySelectorAll('.sp-proj-gallery__thumb').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var full = this.getAttribute('data-full');
            if (full) mainImg.src = full;
            document.querySelectorAll('.sp-proj-gallery__thumb').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
        });
    });
})();
</script>

<?php get_footer(); ?>

<?php
/**
 * Homepage — Product Catalogue section
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args     = $args ?? [];
$heading  = $args['heading']  ?? get_theme_mod('sp_products_heading', 'Product Catalogue');
$subtext  = $args['subtext']  ?? get_theme_mod('sp_products_subtext', 'Explore our range of RTA-approved precast concrete solutions manufactured for UAE infrastructure projects.');
$cta_text = $args['cta_text'] ?? get_theme_mod('sp_products_cta_text', 'View Full Catalogue');
$cta_url  = $args['cta_url']  ?? get_theme_mod('sp_products_cta_url',  get_post_type_archive_link('sp_product'));

$query = new WP_Query([
  'post_type'      => 'sp_product',
  'posts_per_page' => 6,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);

if (!$query->have_posts()) return;
?>
<section class="products-section" id="products">
  <div class="container">

    <div class="section-header">
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="grid" id="sp-products-grid">
      <?php foreach ($query->posts as $sp_post) :
        $sp_id      = $sp_post->ID;
        $permalink  = get_permalink($sp_id);
        $title      = get_the_title($sp_id);
        $excerpt    = get_the_excerpt($sp_post);
        $slug       = sanitize_title($title);

        // Build slideshow image list: featured thumb first, then gallery (max 3 total)
        $gallery_raw  = get_post_meta($sp_id, '_sp_product_gallery', true);
        $gallery_ids  = $gallery_raw ? array_filter(array_map('absint', explode(',', $gallery_raw))) : [];
        $thumb_id     = get_post_thumbnail_id($sp_id);
        if ($thumb_id) array_unshift($gallery_ids, (int) $thumb_id);
        $gallery_ids  = array_unique(array_slice($gallery_ids, 0, 4));

        // Fallback: use placeholder if no images at all
        if (empty($gallery_ids)) {
          $slides = [['url' => get_template_directory_uri() . '/assets/img/placeholder.jpg', 'alt' => $title]];
        } else {
          $slides = [];
          foreach ($gallery_ids as $gid) {
            $url = wp_get_attachment_image_url($gid, 'large');
            if ($url) $slides[] = ['url' => $url, 'alt' => get_post_field('post_excerpt', $gid) ?: $title];
          }
        }

        // Icon
        $icon_id  = (int) get_post_meta($sp_id, '_sp_product_icon', true);
        $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';

        // Specs (each row: [label, value, icon_url])
        $specs_raw = get_post_meta($sp_id, '_sp_product_specs', true);
        $specs     = $specs_raw ? json_decode($specs_raw, true) : [];
      ?>
      <a href="<?php echo esc_url($permalink); ?>" class="product-card-link" id="home-card-<?php echo esc_attr($slug); ?>">
        <article class="product-card">

          <div class="image-container<?php echo count($slides) > 1 ? ' slideshow' : ''; ?>" id="sp-ss-<?php echo esc_attr($slug); ?>">
            <?php foreach ($slides as $i => $slide) : ?>
            <img src="<?php echo esc_url($slide['url']); ?>"
                 alt="<?php echo esc_attr($slide['alt']); ?>"
                 class="slide<?php echo $i === 1 ? ' active' : ($i === 0 && count($slides) === 1 ? ' active' : ''); ?>"
                 width="600" height="450" loading="lazy" decoding="async">
            <?php endforeach; ?>
          </div>

          <h3>
            <?php if ($icon_url) : ?>
            <img src="<?php echo esc_url($icon_url); ?>" class="heading-icon" alt="" width="24" height="24">
            <?php endif; ?>
            <?php echo esc_html($title); ?>
          </h3>

          <?php if ($excerpt) : ?>
          <p><?php echo esc_html($excerpt); ?></p>
          <?php endif; ?>

          <?php if (!empty($specs)) : ?>
          <div class="specs-minimal">
            <?php foreach (array_slice($specs, 0, 4) as $spec) : ?>
            <div class="spec-row">
              <?php if (!empty($spec[2])) : ?>
              <img src="<?php echo esc_url($spec[2]); ?>" class="spec-icon" alt="" width="16" height="16">
              <?php endif; ?>
              <span class="label"><?php echo esc_html($spec[0]); ?></span>
              <span class="value"><?php echo esc_html($spec[1]); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

        </article>
      </a>
      <?php endforeach; ?>
    </div>

    <?php if ($cta_text && $cta_url) : ?>
    <div class="home-products-action">
      <a href="<?php echo esc_url($cta_url); ?>" class="cta-primary home-products-action-btn">
        <?php echo esc_html($cta_text); ?>
      </a>
    </div>
    <?php endif; ?>

  </div>
</section>

<script>
(function() {
  document.querySelectorAll('#sp-products-grid .slideshow').forEach(function(ss) {
    var slides = ss.querySelectorAll('.slide');
    if (slides.length < 2) return;
    var idx = 0;
    slides.forEach(function(s, i) { if (s.classList.contains('active')) idx = i; });
    setInterval(function() {
      slides[idx].classList.remove('active');
      idx = (idx + 1) % slides.length;
      slides[idx].classList.add('active');
    }, 3200);
  });
})();
</script>

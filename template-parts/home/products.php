<?php
/**
 * Homepage — Product Catalogue section
 * Queries WooCommerce products (featured first) if WooCommerce is active.
 * Falls back to a 'product' custom post type, then shows nothing.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading  = get_theme_mod('sp_products_heading', 'Product Catalogue');
$subtext  = get_theme_mod('sp_products_subtext', 'Explore our range of RTA-approved precast concrete solutions manufactured for UAE infrastructure projects.');
$cta_text = get_theme_mod('sp_products_cta_text', 'View Full Catalogue');
$cta_url  = get_theme_mod('sp_products_cta_url',  get_permalink(get_page_by_path('products')));

// Query — WooCommerce preferred, then CPT fallback
if (class_exists('WooCommerce')) {
  $query = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 6,
    'tax_query'      => [[
      'taxonomy' => 'product_visibility',
      'field'    => 'name',
      'terms'    => 'featured',
      'operator' => 'IN',
    ]],
    'orderby' => 'menu_order',
    'order'   => 'ASC',
  ]);
  // If not enough featured, just get latest products
  if ($query->post_count < 3) {
    $query = new WP_Query([
      'post_type'      => 'product',
      'posts_per_page' => 6,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    ]);
  }
} else {
  $query = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 6,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
  ]);
}

if (!$query->have_posts()) return;
?>
<section class="products-section" id="products">
  <div class="container">

    <div class="section-header">
      <h2><?php echo esc_html($heading); ?></h2>
      <p><?php echo esc_html($subtext); ?></p>
    </div>

    <div class="home-grid home-grid--3">
      <?php while ($query->have_posts()) : $query->the_post();
        $permalink  = get_permalink();
        $img_url    = get_the_post_thumbnail_url(null, 'large') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg';
        $excerpt    = get_the_excerpt();
        $icon_url   = get_post_meta(get_the_ID(), '_product_icon', true);
        // Spec rows: stored as JSON in post meta _product_specs: [["Label","Value"],...]
        $specs_raw  = get_post_meta(get_the_ID(), '_product_specs', true);
        $specs      = $specs_raw ? json_decode($specs_raw, true) : [];
      ?>
        <a href="<?php echo esc_url($permalink); ?>" class="product-card-link" id="home-card-<?php echo sanitize_title(get_the_title()); ?>">
          <article class="product-card">

            <div class="product-card__image">
              <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async">
            </div>

            <h3>
              <?php if ($icon_url) : ?>
                <img class="heading-icon" src="<?php echo esc_url($icon_url); ?>" alt="" width="24" height="24" aria-hidden="true">
              <?php endif; ?>
              <?php the_title(); ?>
            </h3>

            <?php if ($excerpt) : ?>
              <p><?php echo esc_html($excerpt); ?></p>
            <?php endif; ?>

            <?php if (!empty($specs)) : ?>
              <div class="specs-minimal">
                <?php foreach (array_slice($specs, 0, 4) as $spec) : ?>
                  <div class="spec-row">
                    <span class="label"><?php echo esc_html($spec[0]); ?></span>
                    <span class="value"><?php echo esc_html($spec[1]); ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </article>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <?php if ($cta_text && $cta_url) : ?>
      <div class="home-section-cta">
        <a href="<?php echo esc_url($cta_url); ?>" class="cta-primary"><?php echo esc_html($cta_text); ?></a>
      </div>
    <?php endif; ?>

  </div>
</section>

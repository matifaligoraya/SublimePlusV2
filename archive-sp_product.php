<?php
/**
 * Products archive — Precast Al Turab (Brief: Priority 4/5)
 * Heavy precast categories first; small products listed last.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
get_header();

$active = get_queried_object();
$active_slug = ($active instanceof WP_Term) ? $active->slug : '';
$cats = get_terms(['taxonomy' => 'sp_product_cat', 'hide_empty' => true, 'orderby' => 'term_order', 'meta_key' => '', 'parent' => 0]);
if (is_wp_error($cats)) $cats = [];
// Sort: heavy/protective first, accessories last
$priority = ['heavy-precast' => 1, 'protective-structures' => 2, 'culverts-channels' => 3, 'concrete-barriers' => 4, 'manholes-utility-structures' => 5, 'custom-precast' => 6];
usort($cats, fn($a, $b) => ($priority[$a->slug] ?? 50) <=> ($priority[$b->slug] ?? 50));

$heading = $active_slug ? $active->name : 'Precast Concrete Products';
$sub     = $active_slug && $active->description ? $active->description : 'Standard and custom reinforced concrete products manufactured for UAE projects.';
?>
<main id="primary" class="site-main">
  <?php echo sp_pc_render('page-hero', ['eyebrow' => 'Products', 'heading' => $heading, 'subtext' => $sub, 'show_cta' => '1']); ?>

  <section class="pc-section pc-archive">
    <div class="container">
      <?php if ($cats) : ?>
      <nav class="pc-filters" aria-label="Product categories">
        <a href="<?php echo esc_url(get_post_type_archive_link('sp_product')); ?>" class="<?php echo $active_slug ? '' : 'active'; ?>">All</a>
        <?php foreach ($cats as $t) : ?>
        <a href="<?php echo esc_url(get_term_link($t)); ?>" class="<?php echo $active_slug === $t->slug ? 'active' : ''; ?>"><?php echo esc_html($t->name); ?></a>
        <?php endforeach; ?>
      </nav>
      <?php endif; ?>

      <?php if (have_posts()) : ?>
      <div class="pc-prod-grid">
        <?php while (have_posts()) : the_post(); echo sp_pc_product_card(get_the_ID()); endwhile; ?>
      </div>
      <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '← Previous', 'next_text' => 'Next →', 'class' => 'pc-pagination']); ?>
      <?php else : ?>
      <p class="pc-empty">No products found.</p>
      <?php endif; ?>
    </div>
  </section>

  <?php echo sp_pc_render('final-cta', ['heading' => 'Need a Product That Is Not Listed?', 'subheading' => 'Custom reinforced precast is manufactured to your drawings, BOQ and technical specification.']); ?>
</main>
<?php get_footer(); ?>

<?php
/**
 * Projects portfolio — Precast Al Turab (Brief: Priority 9)
 * Filters limited to: All · Heavy Precast · Infrastructure · Industrial · Security · Commercial · Utilities
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
get_header();

$active = get_queried_object();
$active_slug = ($active instanceof WP_Term) ? $active->slug : '';
$filters = [];
foreach (sp_project_filter_slugs() as $slug) {
    $t = get_term_by('slug', $slug, 'sp_project_cat');
    if ($t) $filters[] = $t;
}
$heading = $active_slug ? $active->name . ' Projects' : 'Our Projects';
?>
<main id="primary" class="site-main">
  <?php echo sp_pc_render('page-hero', ['eyebrow' => 'Portfolio', 'heading' => $heading, 'subtext' => 'Manufactured in the UAE. Built for real project conditions.', 'show_cta' => '1']); ?>

  <section class="pc-section pc-archive">
    <div class="container">
      <nav class="pc-filters" aria-label="Filter projects">
        <a href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>" class="<?php echo $active_slug ? '' : 'active'; ?>">All</a>
        <?php foreach ($filters as $t) : ?>
        <a href="<?php echo esc_url(get_term_link($t)); ?>" class="<?php echo $active_slug === $t->slug ? 'active' : ''; ?>"><?php echo esc_html($t->name); ?></a>
        <?php endforeach; ?>
      </nav>

      <?php if (have_posts()) : ?>
      <div class="pc-proj-grid">
        <?php while (have_posts()) : the_post(); echo sp_pc_project_card(get_the_ID()); endwhile; ?>
      </div>
      <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '← Previous', 'next_text' => 'Next →', 'class' => 'pc-pagination']); ?>
      <?php else : ?>
      <p class="pc-empty">No projects in this category yet.</p>
      <?php endif; ?>
    </div>
  </section>

  <?php echo sp_pc_render('final-cta', ['heading' => 'Planning a Similar Project?', 'subheading' => 'Send us your drawing, BOQ or technical specification and we will quote the manufacturing scope.']); ?>
</main>
<?php get_footer(); ?>

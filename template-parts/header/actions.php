<?php
/**
 * Template part: header actions (no WooCommerce)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$cta_page = get_page_by_path('contact');
$cta_url  = $cta_page ? get_permalink($cta_page->ID) : '#inquiry';
?>

<!-- Get a Quote CTA button (Canvas Finance style) -->
<a href="<?php echo esc_url($cta_url); ?>" class="btn btn-sp-cta rounded-pill d-none d-lg-inline-flex align-items-center gap-2 ms-3">
  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
  <span>Get a Quote</span>
</a>

<!-- Searchform large -->
<?php if (is_active_sidebar('top-nav-search')) : ?>
  <div class="d-none d-<?= esc_attr(apply_filters('bootscore/class/header/search/breakpoint', 'lg')); ?>-block <?= esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'searchform')); ?> nav-search-lg">
    <?php dynamic_sidebar('top-nav-search'); ?>
  </div>
<?php endif; ?>

<!-- Search toggler mobile -->
<?php if (is_active_sidebar('top-nav-search')) : ?>
  <button class="<?= esc_attr(apply_filters('bootscore/class/header/button', 'btn btn-outline-secondary', 'search-toggler')); ?> d-<?= esc_attr(apply_filters('bootscore/class/header/search/breakpoint', 'lg')); ?>-none <?= esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'search-toggler')); ?> search-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-search" aria-expanded="false" aria-controls="collapse-search" aria-label="<?php esc_attr_e('Search toggler', 'bootscore'); ?>">
    <?= wp_kses_post(apply_filters('bootscore/icon/search', '<i class="fa-solid fa-magnifying-glass"></i>')); ?> <span class="visually-hidden-focusable">Search</span>
  </button>
<?php endif; ?>

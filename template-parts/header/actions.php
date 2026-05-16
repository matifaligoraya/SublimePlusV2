<?php
/**
 * Template part: header actions
 * CTA button lives in the brand row (header.php). This file retains search only.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
?>

<?php if (is_active_sidebar('top-nav-search')) : ?>
  <div class="d-none d-<?= esc_attr(apply_filters('bootscore/class/header/search/breakpoint', 'lg')); ?>-block <?= esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'searchform')); ?> nav-search-lg">
    <?php dynamic_sidebar('top-nav-search'); ?>
  </div>
  <button class="<?= esc_attr(apply_filters('bootscore/class/header/button', 'btn btn-outline-secondary', 'search-toggler')); ?> d-<?= esc_attr(apply_filters('bootscore/class/header/search/breakpoint', 'lg')); ?>-none <?= esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'search-toggler')); ?> search-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#collapse-search"
          aria-expanded="false"
          aria-controls="collapse-search"
          aria-label="<?php esc_attr_e('Search toggler', 'bootscore'); ?>">
    <?= wp_kses_post(apply_filters('bootscore/icon/search', '<i class="fa-solid fa-magnifying-glass"></i>')); ?>
    <span class="visually-hidden-focusable">Search</span>
  </button>
<?php endif; ?>

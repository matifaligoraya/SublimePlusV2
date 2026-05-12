<?php
/**
 * Template part: collapse search (no WooCommerce)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
?>

<!-- Collapse Search Mobile -->
<?php if (is_active_sidebar('top-nav-search')) : ?>
  <div class="collapse <?= esc_attr(apply_filters('bootscore/class/header/collapse', 'bg-body-tertiary position-absolute start-0 end-0')); ?> d-<?= esc_attr(apply_filters('bootscore/class/header/search/breakpoint', 'lg')); ?>-none" id="collapse-search">
    <div class="<?= esc_attr(apply_filters('bootscore/class/container', 'container', 'collapse-search')); ?> pb-2">
      <?php dynamic_sidebar('top-nav-search'); ?>
    </div>
  </div>
<?php endif; ?>

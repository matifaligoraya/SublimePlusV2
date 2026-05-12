<?php
/**
 * Template part: collapse search (WooCommerce)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
?>

<!-- Collapse Search -->
<?php if (is_active_sidebar('top-nav-search')) : ?>
  <div class="collapse <?= esc_attr(apply_filters('bootscore/class/header/collapse', 'bg-body-tertiary position-absolute start-0 end-0')); ?>" id="collapse-search">
    <div class="<?= esc_attr(apply_filters('bootscore/class/container', 'container', 'collapse-search')); ?> pb-2">
      <?php dynamic_sidebar('top-nav-search'); ?>
    </div>
  </div>
<?php endif; ?>

<?php
/**
 * Homepage template (front-page.php)
 * Matches the precastuae.ae reference design.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

get_header();
?>
<main id="primary" class="site-main">
  <?php get_template_part('template-parts/home/hero'); ?>
  <?php get_template_part('template-parts/home/approvals'); ?>
  <?php get_template_part('template-parts/home/clients'); ?>
  <?php get_template_part('template-parts/home/products'); ?>
  <?php get_template_part('template-parts/home/supply'); ?>
  <?php get_template_part('template-parts/home/blog'); ?>
</main>
<?php get_footer(); ?>

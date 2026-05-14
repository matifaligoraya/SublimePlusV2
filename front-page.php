<?php
/**
 * Homepage template (front-page.php)
 *
 * Renders the front page via the_content() so WPBakery Page Builder
 * controls the layout entirely. The Sublime section shortcodes
 * (sublime_hero, sublime_products, etc.) defined in
 * inc/functions/wpbakery-elements.php power each section.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

get_header();
?>
<main id="primary" class="site-main">
  <?php
  while (have_posts()) :
    the_post();
    the_content();
  endwhile;
  ?>
</main>
<?php get_footer(); ?>

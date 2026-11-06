<?php
/**
 * 404 page — Precast Al Turab
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="primary" class="site-main">
  <section class="pc-section pc-404">
    <div class="container">
      <span class="pc-eyebrow">Error 404</span>
      <h1 class="pc-h2">Page Not Found</h1>
      <p>The page you requested does not exist or has moved. Use the links below to continue.</p>
      <div class="pc-cta-group">
        <a class="pc-btn pc-btn--dark" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <a class="pc-btn pc-btn--outline-dark" href="<?php echo esc_url(get_post_type_archive_link('sp_product')); ?>">Products</a>
        <a class="pc-btn pc-btn--outline-dark" href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>">Projects</a>
        <a class="pc-btn pc-btn--accent" href="<?php echo esc_url(sp_rfq_url()); ?>">Request a Quotation</a>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>

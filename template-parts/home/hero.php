<?php
/**
 * Homepage — Hero section
 * Customise text via Appearance → Customize → Homepage Hero,
 * or edit this file directly.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$badge       = get_theme_mod('sp_hero_badge',    'RTA &amp; Municipality Compliant');
$title_top   = get_theme_mod('sp_hero_title_top', 'High-Strength');
$title_bot   = get_theme_mod('sp_hero_title_bot', 'Concrete Precast.');
$description = get_theme_mod('sp_hero_desc',     'Jersey barriers, bunker components, wheel stoppers, and blocks — factory-cast with RTA and municipality approvals for UAE projects.');
$btn1_text   = get_theme_mod('sp_hero_btn1_text', 'Get a Quote');
$btn1_url    = get_theme_mod('sp_hero_btn1_url',  get_permalink(get_page_by_path('contact')));
$btn2_text   = get_theme_mod('sp_hero_btn2_text', 'View Catalogue');
$btn2_url    = get_theme_mod('sp_hero_btn2_url',  get_permalink(get_page_by_path('products')));

// Background: featured image of homepage, then theme_mod, then fallback
$page_id    = get_option('page_on_front');
$bg_url     = '';
if ($page_id && has_post_thumbnail($page_id)) {
  $bg_url = get_the_post_thumbnail_url($page_id, 'full');
}
if (!$bg_url) {
  $bg_url = get_theme_mod('sp_hero_bg_image', get_template_directory_uri() . '/assets/img/hero-bg.jpg');
}
?>
<section class="home-hero" id="home-hero">
  <?php if ($bg_url) : ?>
    <img class="home-hero__bg" src="<?php echo esc_url($bg_url); ?>" alt="" aria-hidden="true" fetchpriority="high" decoding="async">
  <?php endif; ?>
  <div class="home-hero__overlay"></div>

  <div class="container">
    <div class="home-hero__content">

      <?php if ($badge) : ?>
        <div class="home-badge">
          <span class="home-badge__dot"></span>
          <?php echo wp_kses_post($badge); ?>
        </div>
      <?php endif; ?>

      <h1 class="home-hero__title">
        <span class="text-highlight"><?php echo esc_html($title_top); ?></span><br>
        <?php echo esc_html($title_bot); ?>
      </h1>

      <?php if ($description) : ?>
        <p class="home-hero__desc"><?php echo esc_html($description); ?></p>
      <?php endif; ?>

      <div class="home-hero__actions">
        <?php if ($btn1_text && $btn1_url) : ?>
          <a href="<?php echo esc_url($btn1_url); ?>" class="cta-primary"><?php echo esc_html($btn1_text); ?></a>
        <?php endif; ?>
        <?php if ($btn2_text && $btn2_url) : ?>
          <a href="<?php echo esc_url($btn2_url); ?>" class="cta-outline"><?php echo esc_html($btn2_text); ?></a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

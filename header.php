<?php
/**
 * Site header — Precast Al Turab (Brief: Priority 1)
 *
 * Clean sticky header: logo · main navigation · WhatsApp · REQUEST A QUOTATION.
 * Mobile: logo · WhatsApp icon · menu icon, with an offcanvas menu.
 * The fixed mobile bottom bar (CALL | WHATSAPP | GET QUOTE) is printed in wp_footer.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$c       = sp_company();
$logo_id = get_theme_mod('custom_logo');
$logo    = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
$wa      = is_singular('sp_product') ? sp_wa_url_for_product(get_queried_object_id()) : sp_wa_url();
$rfq     = sp_rfq_url(is_singular('sp_product') ? get_the_title() : '');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#1f2426">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
  <a class="skip-link visually-hidden-focusable" href="#primary">Skip to content</a>

  <header id="masthead" class="pc-hdr">
    <div class="container">
      <div class="pc-hdr__inner">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="pc-hdr__logo" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
          <?php if ($logo) : ?>
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="180" height="56" decoding="async">
          <?php else : ?>
            <span class="pc-hdr__wordmark notranslate" translate="no">PRECAST AL TURAB</span>
          <?php endif; ?>
        </a>

        <nav class="pc-hdr__nav" aria-label="Main navigation">
          <?php echo sp_nav_html('pc-nav'); ?>
        </nav>

        <div class="pc-hdr__actions">
          <div class="pc-lang notranslate" translate="no" role="group" aria-label="Language">
            <a href="#" data-lang="en" lang="en" class="is-active">EN</a>
            <a href="#" data-lang="ar" lang="ar">العربية</a>
          </div>
          <a href="<?php echo esc_url($wa); ?>" class="pc-hdr__wa" target="_blank" rel="noopener" aria-label="WhatsApp" data-track="whatsapp_click">
            <?php echo sp_icon('whatsapp', 20); ?><span>WhatsApp</span>
          </a>
          <a href="<?php echo esc_url($rfq); ?>" class="pc-btn pc-btn--accent pc-hdr__rfq" data-track="rfq_click">
            <?php echo sp_icon('quote', 16); ?><span>Request a Quotation</span>
          </a>
          <button class="pc-hdr__toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#pc-offcanvas" aria-controls="pc-offcanvas" aria-label="Open menu">
            <?php echo sp_icon('menu', 26); ?>
          </button>
        </div>

      </div>
    </div>
  </header>

  <div class="offcanvas offcanvas-end pc-offcanvas" tabindex="-1" id="pc-offcanvas" aria-labelledby="pc-offcanvas-label">
    <div class="pc-offcanvas__head">
      <?php if ($logo) : ?><img src="<?php echo esc_url($logo); ?>" alt="" height="40"><?php else : ?><span id="pc-offcanvas-label" class="pc-hdr__wordmark">PRECAST AL TURAB</span><?php endif; ?>
      <button type="button" class="pc-offcanvas__close" data-bs-dismiss="offcanvas" aria-label="Close menu"><?php echo sp_icon('close', 24); ?></button>
    </div>
    <div class="pc-offcanvas__body">
      <div class="pc-lang pc-lang--mobile notranslate" translate="no" role="group" aria-label="Language">
        <a href="#" data-lang="en" lang="en" class="is-active">English</a>
        <a href="#" data-lang="ar" lang="ar">العربية</a>
      </div>
      <?php echo sp_nav_html('pc-nav pc-nav--mobile'); ?>
      <div class="pc-offcanvas__cta">
        <a href="<?php echo esc_url($rfq); ?>" class="pc-btn pc-btn--accent" data-track="rfq_click"><?php echo sp_icon('quote', 16); ?> Request a Quotation</a>
        <a href="<?php echo esc_url($wa); ?>" class="pc-btn pc-btn--wa" target="_blank" rel="noopener" data-track="whatsapp_click"><?php echo sp_icon('whatsapp', 16); ?> WhatsApp</a>
        <a href="tel:<?php echo esc_attr($c['phone_tel']); ?>" class="pc-btn pc-btn--ghost"><?php echo sp_icon('phone', 16); ?> <?php echo esc_html($c['phone']); ?></a>
      </div>
      <p class="pc-offcanvas__meta"><?php echo esc_html($c['email']); ?><br><?php echo esc_html($c['hours']); ?></p>
    </div>
  </div>

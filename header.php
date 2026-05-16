<?php
/**
 * Site header — Canvas menu-8 style
 * Row 1: Logo + contact info tiles + CTA
 * Row 2: Primary navigation with item subtitles (desktop)
 * Offcanvas: mobile slide-in menu
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

// Contact info from Customizer (same keys as footer)
$hdr_phone    = get_theme_mod('sp_footer_phone',    '+971 54 350 7724');
$hdr_email    = get_theme_mod('sp_footer_email',    'info@precastalturab.ae');
$hdr_whatsapp = get_theme_mod('sp_footer_whatsapp', 'https://wa.me/971543507724');

$cta_url = get_permalink(get_page_by_path('contact')) ?: '#inquiry';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

  <a class="skip-link visually-hidden-focusable" href="#primary"><?php esc_html_e('Skip to content', 'bootscore'); ?></a>

  <?php do_action('bootscore_before_masthead'); ?>

  <header id="masthead" class="site-header <?php echo esc_attr(apply_filters('bootscore/class/header', 'sticky-top')); ?>">

    <?php do_action('bootscore_after_masthead_open'); ?>

    <!-- ══════════════════════════════════════════════════════════════
         ROW 1 — Brand: Logo · Contact tiles · CTA · Mobile toggle
    ══════════════════════════════════════════════════════════════ -->
    <div class="sp-hdr-brand">
      <div class="container">
        <div class="sp-hdr-brand__inner">

          <!-- Logo ─────────────────────────────────────────────── -->
          <div class="sp-hdr-logo">
            <?php
            $logo_id  = get_theme_mod('custom_logo');
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
            if ($logo_url) :
            ?>
              <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="sp-hdr-logo__img">
              </a>
            <?php else : ?>
              <a href="<?php echo esc_url(home_url('/')); ?>" class="sp-hdr-logo__text" rel="home">
                <?php echo esc_html(get_bloginfo('name')); ?>
              </a>
            <?php endif; ?>
          </div>

          <!-- Contact tiles (desktop) ──────────────────────────── -->
          <div class="sp-hdr-extras">

            <?php if ($hdr_email) : ?>
            <a href="mailto:<?php echo esc_attr($hdr_email); ?>" class="sp-hdr-extra">
              <div class="sp-hdr-extra__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
              </div>
              <div class="sp-hdr-extra__text">
                <span class="sp-hdr-extra__label"><?php esc_html_e('Drop an Email', 'sublimeplus'); ?></span>
                <span class="sp-hdr-extra__value"><?php echo esc_html($hdr_email); ?></span>
              </div>
            </a>
            <?php endif; ?>

            <?php if ($hdr_phone) : ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $hdr_phone)); ?>" class="sp-hdr-extra">
              <div class="sp-hdr-extra__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.82 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 3.12 4.18 2 2 0 0 1 5.09 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              </div>
              <div class="sp-hdr-extra__text">
                <span class="sp-hdr-extra__label"><?php esc_html_e('Get in Touch', 'sublimeplus'); ?></span>
                <span class="sp-hdr-extra__value"><?php echo esc_html($hdr_phone); ?></span>
              </div>
            </a>
            <?php endif; ?>

            <?php if ($hdr_whatsapp) : ?>
            <a href="<?php echo esc_url($hdr_whatsapp); ?>" target="_blank" rel="noopener" class="sp-hdr-extra sp-hdr-extra--wa">
              <div class="sp-hdr-extra__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
              </div>
              <div class="sp-hdr-extra__text">
                <span class="sp-hdr-extra__label">WhatsApp</span>
                <span class="sp-hdr-extra__value"><?php esc_html_e('Chat Now', 'sublimeplus'); ?></span>
              </div>
            </a>
            <?php endif; ?>

          </div><!-- .sp-hdr-extras -->

          <!-- Right actions: CTA + lang + mobile toggle ────────── -->
          <div class="sp-hdr-actions">

            <!-- Language switcher -->
            <?php do_action('bootscore_after_navbar_brand'); ?>

            <!-- Get a Quote CTA (desktop) -->
            <a href="<?php echo esc_url($cta_url); ?>" class="btn-sp-cta d-none d-lg-inline-flex align-items-center gap-2">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <?php esc_html_e('Get a Quote', 'sublimeplus'); ?>
            </a>

            <!-- Mobile hamburger (opens offcanvas) -->
            <button class="sp-hdr-toggler d-lg-none"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvas-navbar"
                    aria-controls="offcanvas-navbar"
                    aria-label="<?php esc_attr_e('Toggle main menu', 'bootscore'); ?>">
              <span class="sp-hdr-toggler__bar"></span>
              <span class="sp-hdr-toggler__bar"></span>
              <span class="sp-hdr-toggler__bar"></span>
            </button>

          </div><!-- .sp-hdr-actions -->

        </div><!-- .sp-hdr-brand__inner -->
      </div><!-- .container -->
    </div><!-- .sp-hdr-brand -->

    <!-- ══════════════════════════════════════════════════════════════
         ROW 2 — Navigation bar (desktop only)
    ══════════════════════════════════════════════════════════════ -->
    <div class="sp-hdr-nav d-none d-lg-block">
      <div class="container">
        <?php
        $nav_location = has_nav_menu('main-menu') ? 'main-menu' : 'primary-menu';
        wp_nav_menu([
          'theme_location' => $nav_location,
          'container'      => false,
          'fallback_cb'    => '__return_false',
          'items_wrap'     => '<ul id="sp-primary-nav" class="sp-hdr-nav__list">%3$s</ul>',
          'depth'          => 2,
          'walker'         => new bootstrap_5_wp_nav_menu_walker(),
        ]);
        ?>
      </div>
    </div><!-- .sp-hdr-nav -->

    <!-- ══════════════════════════════════════════════════════════════
         OFFCANVAS — Mobile slide-in menu
    ══════════════════════════════════════════════════════════════ -->
    <div class="offcanvas offcanvas-end sp-offcanvas-menu" tabindex="-1" id="offcanvas-navbar">

      <div class="offcanvas-header">
        <?php
        $logo_id  = get_theme_mod('custom_logo');
        $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'thumbnail') : '';
        if ($logo_url) :
        ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" height="32" class="sp-offcanvas-logo">
        <?php else : ?>
          <span class="sp-offcanvas-sitename"><?php echo esc_html(get_bloginfo('name')); ?></span>
        <?php endif; ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Close', 'bootscore'); ?>"></button>
      </div>

      <div class="offcanvas-body">
        <?php get_template_part('template-parts/header/main-menu'); ?>

        <!-- CTA inside offcanvas -->
        <div class="sp-offcanvas-cta">
          <a href="<?php echo esc_url($cta_url); ?>" class="btn-sp-cta w-100 justify-content-center">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <?php esc_html_e('Get a Quote', 'sublimeplus'); ?>
          </a>
        </div>

        <!-- Contact quick links in offcanvas -->
        <div class="sp-offcanvas-contact">
          <?php if ($hdr_phone) : ?>
          <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $hdr_phone)); ?>">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.82 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 3.12 4.18 2 2 0 0 1 5.09 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html($hdr_phone); ?>
          </a>
          <?php endif; ?>
          <?php if ($hdr_email) : ?>
          <a href="mailto:<?php echo esc_attr($hdr_email); ?>">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            <?php echo esc_html($hdr_email); ?>
          </a>
          <?php endif; ?>
        </div>

      </div><!-- .offcanvas-body -->
    </div><!-- #offcanvas-navbar -->

    <?php do_action('bootscore_before_masthead_close'); ?>

  </header><!-- #masthead -->

  <?php do_action('bootscore_after_masthead'); ?>

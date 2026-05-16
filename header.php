<?php
/**
 * The header template
 * Compatible: Bootscore 6.3.1 + SublimePlusV2
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?= esc_attr(get_bloginfo('charset')); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

  <!-- Skip Links -->
  <a class="skip-link visually-hidden-focusable" href="#primary"><?php esc_html_e('Skip to content', 'bootscore'); ?></a>
  <a class="skip-link visually-hidden-focusable" href="#footer"><?php esc_html_e('Skip to footer', 'bootscore'); ?></a>

  <!-- Top Bar Widget -->
  <?php if (is_active_sidebar('top-bar')) : ?>
    <?php dynamic_sidebar('top-bar'); ?>
  <?php endif; ?>

  <!-- ── Canvas Finance-style top utility bar ────────────────────────────── -->
  <div class="sp-topbar">
    <div class="container">
      <div class="sp-topbar__inner">
        <div class="sp-topbar__left">
          <a href="tel:+97144000000" class="sp-topbar__item">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.57a16 16 0 0 0 6 6l.93-.93a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            +971 4 400 0000
          </a>
          <a href="mailto:info@precastuae.ae" class="sp-topbar__item">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            info@precastuae.ae
          </a>
        </div>
        <div class="sp-topbar__right">
          <span class="sp-topbar__item sp-topbar__item--muted">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Sun–Thu &nbsp;8:00 AM – 6:00 PM
          </span>
          <span class="sp-topbar__divider"></span>
          <span class="sp-topbar__item sp-topbar__item--muted">UAE Nationwide Delivery</span>
        </div>
      </div>
    </div>
  </div>

  <?php do_action('bootscore_before_masthead'); ?>

  <header id="masthead" class="<?= esc_attr(apply_filters('bootscore/class/header', 'sticky-top bg-body-tertiary')); ?> site-header">

    <?php do_action('bootscore_after_masthead_open'); ?>

    <nav id="nav-main" class="navbar <?= esc_attr(apply_filters('bootscore/class/header/navbar/breakpoint', 'navbar-expand-lg')); ?>">

      <div class="<?= esc_attr(apply_filters('bootscore/class/container', 'container', 'header')); ?>">

        <?php do_action('bootscore_before_navbar_brand'); ?>

        <!-- Navbar Brand -->
        <?php
        $bs_brand_class = apply_filters('bootscore/class/header/navbar-brand', 'navbar-brand');
        $bs_logo_filter = function ($html) use ($bs_brand_class) {
          return str_replace('class="custom-logo-link"', 'class="custom-logo-link ' . esc_attr($bs_brand_class) . '"', $html);
        };
        add_filter('get_custom_logo', $bs_logo_filter, 20);
        get_template_part('inc/templates/logo');
        remove_filter('get_custom_logo', $bs_logo_filter, 20);
        ?>

        <?php do_action('bootscore_after_navbar_brand'); ?>

        <!-- Offcanvas Navbar -->
        <div class="offcanvas offcanvas-<?= esc_attr(apply_filters('bootscore/class/header/offcanvas/direction', 'end', 'menu')); ?>" tabindex="-1" id="offcanvas-navbar">
          <div class="offcanvas-header <?= esc_attr(apply_filters('bootscore/class/offcanvas/header', '', 'menu')); ?>">
            <span class="h5 offcanvas-title"><?= esc_html(apply_filters('bootscore/offcanvas/navbar/title', __('Menu', 'bootscore'))); ?></span>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body <?= esc_attr(apply_filters('bootscore/class/offcanvas/body', '', 'menu')); ?>">

            <!-- Bootstrap 5 Nav Walker Main Menu -->
            <?php get_template_part('template-parts/header/main-menu'); ?>

            <!-- Top Nav 2 Widget -->
            <?php if (is_active_sidebar('top-nav-2')) : ?>
              <?php dynamic_sidebar('top-nav-2'); ?>
            <?php endif; ?>

          </div>
        </div>

        <div class="header-actions <?= esc_attr(apply_filters('bootscore/class/header-actions', 'd-flex align-items-center')); ?>">

          <!-- Top Nav Widget -->
          <?php if (is_active_sidebar('top-nav')) : ?>
            <?php dynamic_sidebar('top-nav'); ?>
          <?php endif; ?>

          <?php
          if (class_exists('WooCommerce')) :
            get_template_part('template-parts/header/actions', 'woocommerce');
          else :
            get_template_part('template-parts/header/actions');
          endif;
          ?>

          <!-- Navbar Toggler -->
          <button class="<?= esc_attr(apply_filters('bootscore/class/header/button', 'btn btn-outline-secondary', 'nav-toggler')); ?> <?= esc_attr(apply_filters('bootscore/class/header/navbar/toggler/breakpoint', 'd-lg-none')); ?> <?= esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'nav-toggler')); ?> nav-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvas-navbar" aria-label="<?php esc_attr_e('Toggle main menu', 'bootscore'); ?>">
            <?= wp_kses_post(apply_filters('bootscore/icon/menu', '<i class="fa-solid fa-bars"></i>')); ?> <span class="visually-hidden-focusable">Menu</span>
          </button>

          <?php do_action('bootscore_after_nav_toggler'); ?>

        </div><!-- .header-actions -->

      </div><!-- .container -->

    </nav><!-- .navbar -->

    <?php
    if (class_exists('WooCommerce')) :
      get_template_part('template-parts/header/collapse-search', 'woocommerce');
    else :
      get_template_part('template-parts/header/collapse-search');
    endif;
    ?>

    <!-- Offcanvas User and Cart -->
    <?php
    if (class_exists('WooCommerce')) :
      get_template_part('template-parts/header/offcanvas', 'woocommerce');
    endif;
    ?>

    <?php do_action('bootscore_before_masthead_close'); ?>

  </header><!-- #masthead -->

  <?php do_action('bootscore_after_masthead'); ?>

<?php
/**
 * Enqueue Bootstrap 5 (compiled from local SCSS) + Font Awesome + theme JS
 *
 * SCSS source: assets/scss/main.scss  (Bootstrap 5 + Bootscore styles)
 * Compiled to: assets/css/main.css    (auto-compiled on first load / when SCSS changes)
 *
 * To customise Bootstrap variables edit: assets/scss/_bootscore-variables.scss
 * To add custom CSS edit:               assets/scss/_bootscore-custom.scss
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

function bootscore_scripts() {

  // Compile SCSS → assets/css/main.css (skipped if file exists and nothing changed)
  require_once get_template_directory() . '/inc/bootscore/scss-compiler.php';
  bootscore_compile_scss();

  // Deregister any old Bootstrap handle registered elsewhere
  wp_deregister_script('bootstrap');
  wp_deregister_style('bootstrap');

  // Bootstrap 5 + Bootscore CSS (locally compiled)
  $main_css = get_template_directory() . '/assets/css/main.css';
  $main_ver = file_exists($main_css) ? date('YmdHi', filemtime($main_css)) : '1';
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), $main_ver);

  // Theme style.css
  $style_ver = date('YmdHi', filemtime(get_stylesheet_directory() . '/style.css'));
  wp_enqueue_style('bootscore-style', get_stylesheet_uri(), array('main'), $style_ver);

  // Font Awesome (local)
  $fa_css = get_template_directory() . '/assets/fontawesome/css/all.min.css';
  if (file_exists($fa_css)) {
    $fa_ver = date('YmdHi', filemtime($fa_css));
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/fontawesome/css/all.min.css', array(), $fa_ver);
    add_filter('style_loader_tag', function ($tag) {
      return preg_replace("/id='fontawesome-css'/", "id='fontawesome-css' onload=\"if(media!='all')media='all'\"", $tag);
    });
  }

  // Bootstrap 5 JS bundle (local — includes Popper)
  $bs_js = get_template_directory() . '/assets/js/lib/bootstrap.bundle.min.js';
  if (file_exists($bs_js)) {
    $bs_ver = date('YmdHi', filemtime($bs_js));
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/lib/bootstrap.bundle.min.js', array(), $bs_ver, true);
  }

  // Bootscore theme JS
  $theme_js = get_template_directory() . '/assets/js/theme.js';
  if (file_exists($theme_js)) {
    $theme_ver = date('YmdHi', filemtime($theme_js));
    wp_enqueue_script('bootscore-theme', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), $theme_ver, true);
  }

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'bootscore_scripts', 5);

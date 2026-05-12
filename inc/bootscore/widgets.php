<?php
/**
 * Register Bootscore widget areas
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!function_exists('bootscore_widgets_init')) :
  function bootscore_widgets_init() {

    register_sidebar(array(
      'name'          => esc_html__('Top Bar', 'bootscore'),
      'id'            => 'top-bar',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget top-bar-widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('Top Nav', 'bootscore'),
      'id'            => 'top-nav',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget top-nav-widget ' . esc_attr(apply_filters('bootscore/class/header/action/spacer', 'ms-1 ms-md-2', 'top-nav-widget')) . '">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('Top Nav 2', 'bootscore'),
      'id'            => 'top-nav-2',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget top-nav-widget-2 ' . esc_attr(apply_filters('bootscore/class/header/top-nav-widget-2', 'd-lg-flex align-items-lg-center mt-2 mt-lg-0 ms-lg-2')) . '">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('Top Nav Search', 'bootscore'),
      'id'            => 'top-nav-search',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget top-nav-search">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('Sidebar', 'bootscore'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<section id="%1$s" class="widget mb-4">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title h5">',
      'after_title'   => '</h2>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('Footer Top', 'bootscore'),
      'id'            => 'footer-top',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget footer_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ));

    foreach (array('footer-1', 'footer-2', 'footer-3', 'footer-4') as $footer_id) {
      register_sidebar(array(
        'name'          => esc_html__(ucwords(str_replace('-', ' ', $footer_id)), 'bootscore'),
        'id'            => $footer_id,
        'description'   => esc_html__('Add widgets here.', 'bootscore'),
        'before_widget' => '<div class="widget footer_widget ' . esc_attr(apply_filters('bootscore/class/footer/col/spacer', 'mb-3', $footer_id)) . '">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title h5">',
        'after_title'   => '</h2>',
      ));
    }

    register_sidebar(array(
      'name'          => esc_html__('Footer Info', 'bootscore'),
      'id'            => 'footer-info',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget footer_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => esc_html__('404 Page', 'bootscore'),
      'id'            => '404-page',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="widget mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h1 class="widget-title">',
      'after_title'   => '</h1>',
    ));
  }
  add_action('widgets_init', 'bootscore_widgets_init');
endif;

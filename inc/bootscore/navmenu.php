<?php
/**
 * Register Bootscore nav menus
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!function_exists('bootscore_register_navmenu')) :
  function bootscore_register_navmenu() {
    register_nav_menu('main-menu', esc_html__('Main Menu', 'bootscore'));
    register_nav_menu('footer-menu', esc_html__('Footer Menu', 'bootscore'));
  }
endif;
add_action('after_setup_theme', 'bootscore_register_navmenu');

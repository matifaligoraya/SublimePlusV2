<?php
/**
 * Template part: Bootstrap 5 nav walker main menu
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

// Use 'main-menu' if a menu is assigned there, otherwise fall back to 'primary-menu'
$nav_location = has_nav_menu('main-menu') ? 'main-menu' : 'primary-menu';

wp_nav_menu(array(
  'theme_location' => $nav_location,
  'container'      => false,
  'menu_class'     => '',
  'fallback_cb'    => '__return_false',
  'items_wrap'     => '<ul id="bootscore-navbar" class="navbar-nav nav-links ' . esc_attr(apply_filters('bootscore/class/header/navbar-nav', 'ms-auto')) . ' %2$s">%3$s</ul>',
  'depth'          => 2,
  'walker'         => new bootstrap_5_wp_nav_menu_walker()
));

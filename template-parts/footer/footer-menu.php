<?php
/**
 * Template part: Bootstrap 5 nav walker footer menu
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

wp_nav_menu(array(
  'theme_location' => 'footer-menu',
  'container'      => false,
  'menu_class'     => '',
  'fallback_cb'    => '__return_false',
  'items_wrap'     => '<ul id="footer-menu" class="nav %2$s">%3$s</ul>',
  'depth'          => 1,
  'walker'         => new bootstrap_5_wp_nav_menu_walker()
));

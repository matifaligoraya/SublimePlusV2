<?php
/**
 * Bootstrap 5 column helpers
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

function bootscore_main_col_class_sidebar($string) {
  if (is_active_sidebar('sidebar-1')) {
    return 'col-lg-9';
  }
  return $string;
}
add_filter('bootscore/class/main/col', 'bootscore_main_col_class_sidebar');

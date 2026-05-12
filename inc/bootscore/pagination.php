<?php
/**
 * Bootstrap 5 pagination
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!function_exists('bootscore_pagination')) :
  function bootscore_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged)) $paged = 1;
    if ($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;
      if (!$pages) $pages = 1;
    }

    if (1 != $pages) {
      echo '<nav aria-label="Page navigation">';
      echo '<span class="visually-hidden">' . esc_html__('Page navigation', 'bootscore') . '</span>';
      echo '<ul class="pagination justify-content-center mb-4">';

      if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link(1)) . '">&laquo;</a></li>';

      if ($paged > 1 && $showitems < $pages)
        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged - 1)) . '">&lsaquo;</a></li>';

      for ($i = 1; $i <= $pages; $i++) {
        if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
          echo ($paged == $i)
            ? '<li class="page-item active"><span class="page-link">' . esc_html($i) . '</span></li>'
            : '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html($i) . '</a></li>';
        }
      }

      if ($paged < $pages && $showitems < $pages)
        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link(($paged === 0 ? 1 : $paged) + 1)) . '">&rsaquo;</a></li>';

      if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($pages)) . '">&raquo;</a></li>';

      echo '</ul></nav>';
    }
  }
endif;

// Bootstrap 5 classes on prev/next post links
add_filter('next_post_link',     'bootscore_post_link_attributes');
add_filter('previous_post_link', 'bootscore_post_link_attributes');

function bootscore_post_link_attributes($output) {
  return str_replace('<a href=', '<a class="page-link" href=', $output);
}

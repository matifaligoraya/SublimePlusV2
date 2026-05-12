<?php
/**
 * Bootscore template tags
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!function_exists('bootscore_category_badge')) :
  function bootscore_category_badge() {
    if ('post' === get_post_type()) {
      echo '<p class="category-badge">';
      $thelist = '';
      $i = 0;
      foreach (get_the_category() as $category) {
        if (0 < $i) $thelist .= ' ';
        $class    = apply_filters('bootscore/class/badge/category', 'badge bg-primary-subtle text-primary-emphasis text-decoration-none');
        $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="' . esc_attr($class) . '">' . esc_html($category->name) . '</a>';
        $i++;
      }
      echo wp_kses_post($thelist);
      echo '</p>';
    }
  }
endif;

if (!function_exists('bootscore_date')) :
  function bootscore_date() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
      if (apply_filters('bootscore/meta/time/updated', true)) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <span class="time-updated-separator">/</span> <time class="updated" datetime="%3$s">%4$s</time>';
      } else {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
      }
    }
    $time_string = sprintf($time_string,
      esc_attr(get_the_date(DATE_W3C)), esc_html(get_the_date()),
      esc_attr(get_the_modified_date(DATE_W3C)), esc_html(get_the_modified_date())
    );
    echo '<span class="posted-on"><span rel="bookmark">' . $time_string . '</span></span>';
  }
endif;

if (!function_exists('bootscore_author')) :
  function bootscore_author() {
    if (!apply_filters('bootscore/meta/author', true)) return;
    $byline = sprintf(
      esc_html_x('by %s', 'post author', 'bootscore'),
      '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );
    echo '<span class="byline"> ' . $byline . '</span>';
  }
endif;

add_filter('get_the_archive_description', function ($description) {
  if (is_author()) return wpautop($description);
  return $description;
});

if (!function_exists('bootscore_comments')) :
  function bootscore_comments() {
    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
      echo ' <span class="comment-divider">|</span> ' . wp_kses_post(apply_filters('bootscore/icon/comments', '<i class="fa-regular fa-comments"></i>')) . ' <span class="comments-link">';
      comments_popup_link(sprintf(wp_kses(__('Leave a Comment', 'bootscore'), array('span' => array('class' => array()))), get_the_title()));
      echo '</span>';
    }
  }
endif;

if (!function_exists('bootscore_edit')) :
  function bootscore_edit() {
    edit_post_link(
      sprintf(wp_kses(__('Edit', 'bootscore'), array('span' => array('class' => array()))), get_the_title()),
      ' | <span class="edit-link">',
      '</span>'
    );
  }
endif;

if (!function_exists('bootscore_comment_count')) :
  function bootscore_comment_count() {
    if (!post_password_required() && (comments_open() || get_comments_number())) {
      echo ' <span class="comment-divider">|</span> ' . wp_kses_post(apply_filters('bootscore/icon/comments', '<i class="fa-regular fa-comments"></i>')) . ' <span class="comments-link">';
      comments_popup_link(sprintf(__('Leave a comment', 'bootscore'), get_the_title()));
      echo '</span>';
    }
  }
endif;

if (!function_exists('bootscore_tags')) :
  function bootscore_tags() {
    if ('post' === get_post_type()) {
      $tags_list = get_the_tag_list('', ' ');
      if ($tags_list) {
        echo '<div class="tags-links">';
        if (is_singular('post') && get_the_ID() === get_queried_object_id()) {
          echo '<p class="tags-heading h6">' . esc_html__('Tagged', 'bootscore') . '</p>';
        }
        echo get_the_tag_list();
        echo '</div>';
      }
    }
  }

  add_filter('term_links-post_tag', function ($links) {
    $class = apply_filters('bootscore/class/badge/tag', 'badge bg-primary-subtle text-primary-emphasis text-decoration-none');
    return str_replace('</a>', '</a> ', str_replace('<a href="', '<a class="' . esc_attr($class) . '" href="', $links));
  });
endif;

if (!function_exists('bootscore_post_thumbnail')) :
  function bootscore_post_thumbnail() {
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) return;
    if (is_singular()) : ?>
      <div class="post-thumbnail">
        <?php the_post_thumbnail('full', array('class' => 'rounded mb-3')); ?>
      </div>
    <?php else : ?>
      <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
        <?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute(array('echo' => false)))); ?>
      </a>
    <?php
    endif;
  }
endif;

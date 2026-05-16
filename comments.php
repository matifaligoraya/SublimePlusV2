<?php
/**
 * Comments template
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}

if (!comments_open() && !have_comments()) {
    return;
}
?>
<div id="comments" class="comments-area">

  <?php if (have_comments()) : ?>
    <h2 class="comments-title">
      <?php
      $comment_count = get_comments_number();
      printf(
          esc_html(_n('%s Comment', '%s Comments', $comment_count, 'sublimeplus')),
          number_format_i18n($comment_count)
      );
      ?>
    </h2>

    <ol class="comment-list">
      <?php wp_list_comments(['style' => 'ol', 'short_ping' => true]); ?>
    </ol>

    <?php the_comments_navigation(); ?>
  <?php endif; ?>

  <?php if (!comments_open() && have_comments()) : ?>
    <p class="no-comments"><?= esc_html__('Comments are closed.', 'sublimeplus'); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>

</div>

<?php
/**
 * The template for displaying all pages
 * Template Version: 6.3.1
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

global $post;

// Treat WPBakery pages AND pages using any of our custom section shortcodes as full-width.
$_sublime_tags = ['vc_row', 'sublime_hero', 'sublime_certificates', 'sublime_clients',
                  'sublime_products', 'sublime_supply', 'sublime_testimonials',
                  'sublime_inquiry', 'sublime_projects', 'sublime_blog',
                  'sublime_contact', 'sublime_stats', 'sublime_features',
                  'sublime_about_intro'];
$_wpb = $post && array_reduce($_sublime_tags, function ($carry, $tag) use ($post) {
    return $carry || has_shortcode($post->post_content, $tag);
}, false);

get_header();

if ($_wpb) : ?>
  <div id="content" class="site-content">
    <div id="primary" class="content-area">
      <main id="main" class="site-main">
        <?php the_post(); the_content(); ?>
      </main>
    </div>
  </div>
<?php else :
  $sidebar_pos = Sublimeplus_page_sidebar();
  $has_sidebar = in_array($sidebar_pos, ['left', 'right'], true) && is_active_sidebar('sidebar-1');
  $row_class   = ($has_sidebar && $sidebar_pos === 'left') ? ' flex-row-reverse' : '';
  $col_class   = $has_sidebar ? 'col-lg-9' : 'col-12';
?>
  <div id="content" class="site-content <?= esc_attr(apply_filters('bootscore/class/container', 'container', 'page')); ?> <?= esc_attr(apply_filters('bootscore/class/content/spacer', 'pt-4 pb-5', 'page')); ?>">
    <div id="primary" class="content-area">

      <?php do_action('bootscore_after_primary_open', 'page'); ?>

      <div class="row<?= esc_attr($row_class); ?>">
        <div class="<?= esc_attr($col_class); ?>">

          <main id="main" class="site-main">

            <div class="entry-header">
              <?php the_post(); ?>
              <?php do_action('bootscore_before_title', 'page'); ?>
              <?php the_title('<h1 class="entry-title ' . esc_attr(apply_filters('bootscore/class/entry/title', '', 'page')) . '">', '</h1>'); ?>
              <?php do_action('bootscore_after_title', 'page'); ?>
              <?php bootscore_post_thumbnail(); ?>
            </div>

            <?php do_action('bootscore_after_featured_image', 'page'); ?>

            <div class="entry-content">
              <?php the_content(); ?>
            </div>

            <?php do_action('bootscore_before_entry_footer', 'page'); ?>

            <div class="entry-footer">
              <?php comments_template(); ?>
            </div>

          </main>

        </div>
        <?php if ($has_sidebar) get_sidebar(); ?>
      </div>

    </div>
  </div>
<?php endif;

get_footer();

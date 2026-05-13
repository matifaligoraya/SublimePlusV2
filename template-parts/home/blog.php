<?php
/**
 * Homepage — Latest blog posts / Industry Insights
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args     = $args ?? [];
$heading  = $args['heading']  ?? get_theme_mod('sp_blog_heading', 'Latest Industry Insights');
$subtext  = $args['subtext']  ?? get_theme_mod('sp_blog_subtext', 'Stay updated on precast concrete innovations, project highlights, and UAE infrastructure news.');
$cta_text = $args['cta_text'] ?? get_theme_mod('sp_blog_cta_text', 'Read All Articles');
$cta_url  = $args['cta_url']  ?? (get_permalink(get_option('page_for_posts')) ?: get_home_url(null, '/blog/'));

$posts = new WP_Query([
  'post_type'      => 'post',
  'posts_per_page' => 5,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

if (!$posts->have_posts()) return;
?>
<section class="blog-section" id="insights">
  <div class="container">

    <div class="section-header section-header--inline">
      <div>
        <h2><?php echo esc_html($heading); ?></h2>
        <p><?php echo esc_html($subtext); ?></p>
      </div>
      <?php if ($cta_text) : ?>
        <a href="<?php echo esc_url($cta_url); ?>" class="cta-text-link"><?php echo esc_html($cta_text); ?> &rarr;</a>
      <?php endif; ?>
    </div>

    <div class="home-grid home-grid--blog">
      <?php foreach ($posts->posts as $sp_post) :
        $sp_id = $sp_post->ID;
        $img   = get_the_post_thumbnail_url($sp_id, 'medium_large');
        $cats  = get_the_category($sp_id);
        $cat   = $cats ? $cats[0]->name : '';
        $title = get_the_title($sp_id);
        $link  = get_permalink($sp_id);
      ?>
        <a href="<?php echo esc_url($link); ?>" class="blog-card-link">
          <article class="blog-card">

            <?php if ($img) : ?>
              <div class="blog-card__image">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" decoding="async">
              </div>
            <?php endif; ?>

            <div class="blog-card__body">
              <?php if ($cat) : ?>
                <span class="blog-card__cat"><?php echo esc_html($cat); ?></span>
              <?php endif; ?>
              <h3><?php echo esc_html($title); ?></h3>
              <p class="blog-card__meta">
                <time datetime="<?php echo get_the_date('c', $sp_post); ?>"><?php echo get_the_date('', $sp_post); ?></time>
              </p>
            </div>

          </article>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>

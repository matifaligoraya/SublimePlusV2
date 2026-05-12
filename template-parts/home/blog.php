<?php
/**
 * Homepage — Latest blog posts / Industry Insights
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading  = get_theme_mod('sp_blog_heading', 'Latest Industry Insights');
$subtext  = get_theme_mod('sp_blog_subtext', 'Stay updated on precast concrete innovations, project highlights, and UAE infrastructure news.');
$cta_text = get_theme_mod('sp_blog_cta_text', 'Read All Articles');
$cta_url  = get_permalink(get_option('page_for_posts')) ?: get_home_url(null, '/blog/');

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
      <?php while ($posts->have_posts()) : $posts->the_post();
        $img  = get_the_post_thumbnail_url(null, 'medium_large');
        $cats = get_the_category();
        $cat  = $cats ? $cats[0]->name : '';
      ?>
        <a href="<?php the_permalink(); ?>" class="blog-card-link">
          <article class="blog-card">

            <?php if ($img) : ?>
              <div class="blog-card__image">
                <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async">
              </div>
            <?php endif; ?>

            <div class="blog-card__body">
              <?php if ($cat) : ?>
                <span class="blog-card__cat"><?php echo esc_html($cat); ?></span>
              <?php endif; ?>
              <h3><?php the_title(); ?></h3>
              <p class="blog-card__meta">
                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
              </p>
            </div>

          </article>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

  </div>
</section>

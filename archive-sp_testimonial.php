<?php
/**
 * Testimonials archive — /testimonials/
 * Grid of all published sp_testimonial posts.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

  <!-- Page hero -->
  <div class="sp-archive-hero">
    <div class="container">
      <h1 class="sp-archive-hero__title"><?php _e('Client Testimonials', 'sublimeplus'); ?></h1>
      <p class="sp-archive-hero__sub"><?php _e('What UAE contractors say about working with us.', 'sublimeplus'); ?></p>
    </div>
  </div>

  <!-- Cards grid -->
  <div class="sp-testi-archive">
    <div class="container">
      <?php if (have_posts()) : ?>

      <div class="sp-testi-archive__grid">
        <?php while (have_posts()) :
          the_post();
          $pid      = get_the_ID();
          $photo_id = (int) get_post_meta($pid, '_sp_testimonial_photo_id', true);
          $photo    = $photo_id ? wp_get_attachment_image_url($photo_id, 'thumbnail') : '';
          $position = get_post_meta($pid, '_sp_testimonial_position', true);
          $company  = get_post_meta($pid, '_sp_testimonial_company',  true);
          $stars    = max(1, min(5, (int) get_post_meta($pid, '_sp_testimonial_stars', true) ?: 5));
          $name     = get_the_title();
          $initials = '';
          foreach (preg_split('/\s+/', trim($name)) as $part) {
              if ($part) $initials .= strtoupper($part[0]);
              if (strlen($initials) >= 2) break;
          }
        ?>
        <div class="sp-review-card">

          <div class="sp-review-card__avatar-wrap">
            <?php if ($photo) : ?>
              <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($name); ?>" class="sp-review-card__avatar-img" width="64" height="64">
            <?php else : ?>
              <div class="sp-review-card__avatar-initials"><?php echo esc_html($initials); ?></div>
            <?php endif; ?>
          </div>

          <div class="sp-review-card__stars" aria-label="<?php echo $stars; ?> out of 5 stars">
            <?php for ($i = 0; $i < $stars; $i++) : ?>
            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path fill="#E9C46A" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg>
            <?php endfor; ?>
          </div>

          <p class="sp-review-card__text"><?php echo esc_html(get_the_content() ?: get_the_excerpt()); ?></p>

          <div class="sp-review-card__author">
            <strong class="sp-review-card__name"><?php echo esc_html($name); ?></strong>
            <?php $meta = array_filter([$position, $company]); if ($meta) : ?>
            <span class="sp-review-card__company"><?php echo esc_html(implode(', ', $meta)); ?></span>
            <?php endif; ?>
          </div>

          <svg class="sp-review-card__bg-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21Z"/></svg>
        </div>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination(['mid_size' => 2]); ?>

      <?php else : ?>
      <p class="sp-testi-archive__empty"><?php _e('No testimonials published yet.', 'sublimeplus'); ?></p>
      <?php endif; ?>
    </div>
  </div>

</main>

<style>
/* ── Archive hero ─────────────────────────────────────────────────────────── */
.sp-archive-hero {
  background: var(--c-primary, #264653);
  padding: 4rem 0 3rem;
  text-align: center;
}
.sp-archive-hero__title {
  color: #fff;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  margin: 0 0 .75rem;
}
.sp-archive-hero__sub {
  color: rgba(255,255,255,.7);
  font-size: 1.05rem;
  margin: 0;
}

/* ── Grid ─────────────────────────────────────────────────────────────────── */
.sp-testi-archive { padding: 4rem 0; background: #f8fafc; }

.sp-testi-archive__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}
@media (max-width: 991px) { .sp-testi-archive__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) { .sp-testi-archive__grid { grid-template-columns: 1fr; } }

.sp-testi-archive__empty {
  text-align: center;
  color: #64748b;
  font-size: 1.1rem;
  padding: 3rem 0;
}

/* sp-review-card styles live in testimonials.php and are globally available */
</style>

<?php get_footer(); ?>

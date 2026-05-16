<?php
/**
 * About intro section — image + rich text split layout
 *
 * @package SublimePlusV2
 * @var array $args
 */
defined('ABSPATH') || exit;

$eyebrow    = $args['eyebrow']    ?? 'About Us';
$heading    = $args['heading']    ?? 'Precast Concrete Specialists';
$content    = $args['content']    ?? '';
$image_id   = (int) ($args['image_id'] ?? 0);
$img_pos    = $args['img_pos']    ?? 'left';   // left | right
$cta_text   = $args['cta_text']   ?? '';
$cta_url    = $args['cta_url']    ?? '';
$cta2_text  = $args['cta2_text']  ?? '';
$cta2_url   = $args['cta2_url']   ?? '';
$badges     = $args['badges']     ?? [];        // param_group rows

$img_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
$img_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';

$reverse = ($img_pos === 'right') ? ' flex-lg-row-reverse' : '';
?>
<section class="sp-about-intro">
  <div class="container">
    <div class="row align-items-center g-5<?= esc_attr($reverse) ?>">

      <!-- Image column -->
      <div class="col-lg-5">
        <?php if ($img_url) : ?>
          <div class="sp-about-intro__img-wrap">
            <img src="<?= esc_url($img_url) ?>"
                 alt="<?= esc_attr($img_alt) ?>"
                 class="sp-about-intro__img">
            <div class="sp-about-intro__img-badge">
              <span class="sp-about-intro__img-badge-num">15<sup>+</sup></span>
              <span class="sp-about-intro__img-badge-lbl">Years<br>Experience</span>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Text column -->
      <div class="col-lg-7">

        <?php if ($eyebrow) : ?>
          <p class="sp-about-intro__eyebrow"><?= esc_html($eyebrow) ?></p>
        <?php endif; ?>

        <h2 class="sp-about-intro__heading"><?= esc_html($heading) ?></h2>

        <?php if ($content) : ?>
          <div class="sp-about-intro__content">
            <?= wp_kses_post(wpautop($content)) ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($badges)) : ?>
          <ul class="sp-about-intro__badges">
            <?php foreach ($badges as $b) : ?>
              <li>
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                <?= esc_html($b['text'] ?? '') ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if ($cta_text || $cta2_text) : ?>
          <div class="sp-about-intro__actions">
            <?php if ($cta_text && $cta_url) : ?>
              <a href="<?= esc_url($cta_url) ?>" class="btn btn-primary px-4">
                <?= esc_html($cta_text) ?>
              </a>
            <?php endif; ?>
            <?php if ($cta2_text && $cta2_url) : ?>
              <a href="<?= esc_url($cta2_url) ?>" class="btn btn-outline-secondary px-4">
                <?= esc_html($cta2_text) ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

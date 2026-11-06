<?php
/**
 * Precast — Text block with optional image (About intro etc.)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$eyebrow  = $args['eyebrow'] ?? '';
$heading  = $args['heading'] ?? '';
$content  = $args['content'] ?? '';
$img_id   = (int) ($args['image_id'] ?? 0);
$img      = $img_id ? sp_img_url($img_id, 'large') : '';
$img_pos  = ($args['img_pos'] ?? 'right') === 'left' ? 'pc-textblock--left' : '';
$cta_text = $args['cta_text'] ?? '';
$cta_url  = $args['cta_url'] ?? '';
?>
<section class="pc-section pc-textblock <?php echo esc_attr($img_pos); ?>">
  <div class="container">
    <div class="pc-textblock__grid<?php echo $img ? '' : ' pc-textblock__grid--single'; ?>">
      <div class="pc-textblock__text">
        <?php if ($eyebrow) : ?><span class="pc-eyebrow"><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
        <?php if ($heading) : ?><h2 class="pc-h2"><?php echo esc_html($heading); ?></h2><?php endif; ?>
        <div class="pc-prose"><?php echo wp_kses_post(wpautop(do_shortcode($content))); ?></div>
        <?php if ($cta_text && $cta_url) : ?><a class="pc-btn pc-btn--accent" href="<?php echo esc_url($cta_url); ?>"><?php echo esc_html($cta_text); ?> <?php echo sp_icon('arrow', 16); ?></a><?php endif; ?>
      </div>
      <?php if ($img) : ?>
      <div class="pc-textblock__media"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($heading ?: 'Precast Al Turab'); ?>" loading="lazy" decoding="async"></div>
      <?php endif; ?>
    </div>
  </div>
</section>

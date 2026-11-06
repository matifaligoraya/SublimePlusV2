<?php
/**
 * Precast — Inner page hero / heading band
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$eyebrow = $args['eyebrow'] ?? '';
$heading = $args['heading'] ?: get_the_title();
$subtext = $args['subtext'] ?? '';
$bg_id   = (int) ($args['bg_image_id'] ?? 0);
$bg      = $bg_id ? sp_img_url($bg_id, 'full') : '';
$show_cta = ($args['show_cta'] ?? '1') === '1';
?>
<section class="pc-phero<?php echo $bg ? ' pc-phero--img' : ''; ?>">
  <?php if ($bg) : ?><img class="pc-phero__bg" src="<?php echo esc_url($bg); ?>" alt="" decoding="async"><div class="pc-phero__shade"></div><?php endif; ?>
  <div class="container">
    <?php echo sp_breadcrumb_html(); ?>
    <div class="pc-phero__inner">
      <div>
        <?php if ($eyebrow) : ?><span class="pc-eyebrow pc-eyebrow--light"><?php echo esc_html($eyebrow); ?></span><?php endif; ?>
        <h1 class="pc-phero__title"><?php echo esc_html($heading); ?></h1>
        <?php if ($subtext) : ?><p class="pc-phero__sub"><?php echo esc_html($subtext); ?></p><?php endif; ?>
      </div>
      <?php if ($show_cta) echo sp_cta_buttons(['show' => ['quote', 'wa'], 'labels' => ['quote' => 'Request Quotation', 'wa' => 'WhatsApp'], 'class' => 'pc-phero__cta']); ?>
    </div>
  </div>
</section>

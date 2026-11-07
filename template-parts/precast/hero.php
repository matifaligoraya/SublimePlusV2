<?php
/**
 * Precast — Homepage hero (Brief: Priority 2)
 * Heavy-precast photo, strong heading, three CTAs, formats line.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$a = wp_parse_args($args ?? [], []);
$bg_id   = (int) ($a['bg_image_id'] ?? 0);
if (!$bg_id && !get_theme_mod('sp_hero_bg')) $bg_id = 13; // default: bunker production photo
// Responsive source set so phones download a small file instead of the full-size original.
$bg      = $bg_id ? (sp_img_url($bg_id, 'large') ?: sp_img_url($bg_id, 'full')) : get_theme_mod('sp_hero_bg');
$bg_set  = $bg_id ? (string) wp_get_attachment_image_srcset($bg_id, 'full') : '';
$heading = $a['heading']     ?: 'Engineered Precast Concrete Solutions for the UAE';
$sub     = $a['subheading']  ?: 'Heavy-Duty Precast Manufacturing for Infrastructure, Industrial, Construction and Specialised Projects';
$desc    = $a['description'] ?: 'Precast Al Turab manufactures reinforced precast concrete products engineered for demanding UAE projects. From protective bunkers and T-Walls to barriers, box culverts, chambers and custom structural elements, we support projects from drawing review and mould fabrication through production, lifting and delivery.';
$formats = $a['formats']     ?: 'PDF • DWG • BOQ • Technical Specification';
?>
<section class="pc-hero" id="hero">
  <?php if ($bg) : ?>
  <img class="pc-hero__bg" src="<?php echo esc_url($bg); ?>"<?php if ($bg_set) : ?> srcset="<?php echo esc_attr($bg_set); ?>" sizes="100vw"<?php endif; ?> alt="" fetchpriority="high" decoding="async">
  <?php endif; ?>
  <div class="pc-hero__shade" aria-hidden="true"></div>
  <div class="container">
    <div class="pc-hero__inner">
      <span class="pc-eyebrow pc-eyebrow--light">UAE Precast Concrete Manufacturer</span>
      <h1 class="pc-hero__title"><?php echo esc_html($heading); ?></h1>
      <p class="pc-hero__sub"><?php echo esc_html($sub); ?></p>
      <p class="pc-hero__desc"><?php echo esc_html($desc); ?></p>
      <?php echo sp_cta_buttons(['class' => 'pc-hero__cta']); ?>
      <p class="pc-hero__formats"><?php echo sp_icon('file', 16); ?> <?php echo esc_html($formats); ?></p>
    </div>
  </div>
</section>

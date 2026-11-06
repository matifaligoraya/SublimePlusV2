<?php
/**
 * Precast — Heavy Precast & Protective Structures feature (Brief: Priority 7)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading  = $args['heading']  ?: 'Heavy Precast & Protective Structures';
$text     = $args['text']     ?: 'Precast Al Turab specialises in manufacturing large reinforced precast components requiring custom moulds, heavy reinforcement and controlled lifting operations.';
$products = sp_pc_lines($args['products'] ?? '') ?: ['Precast Bunkers', 'T-Walls', 'C-Type Shelters', 'Box Culverts', 'U-Channels', 'Roof Slabs', 'Heavy Structural Panels', 'Custom Concrete Structures'];
$btn_text = $args['btn_text'] ?: 'Explore Heavy Precast';
$btn_url  = $args['btn_url']  ?: (($t = get_term_by('slug', 'heavy-precast', 'sp_product_cat')) ? get_term_link($t) : get_post_type_archive_link('sp_product'));
$img_id   = (int) ($args['image_id'] ?? 0);
$img      = $img_id ? sp_img_url($img_id, 'large') : sp_img_url(14, 'large');

$product_links = [
    'Precast Bunkers' => 'precast-bunker', 'T-Walls' => 't-wall', 'C-Type Shelters' => 'c-type-structure', 'Box Culverts' => 'box-culvert',
    'U-Channels' => 'u-channel', 'Roof Slabs' => 'cover-slab', 'Heavy Structural Panels' => 'custom-precast', 'Custom Concrete Structures' => 'custom-precast',
];
?>
<section class="pc-section pc-heavy" id="heavy-precast">
  <div class="container">
    <div class="pc-heavy__grid">
      <div class="pc-heavy__content">
        <span class="pc-eyebrow pc-eyebrow--light">Core Capability</span>
        <h2 class="pc-h2 pc-h2--light"><?php echo esc_html($heading); ?></h2>
        <p class="pc-heavy__text"><?php echo esc_html($text); ?></p>
        <ul class="pc-heavy__list">
          <?php foreach ($products as $p) :
            $slug = $product_links[$p] ?? '';
            $post = $slug ? sp_pc_product_by_slug($slug) : null;
            $url  = $post ? get_permalink($post) : '';
          ?>
          <li><?php echo sp_icon('check', 16); ?><?php echo $url ? '<a href="' . esc_url($url) . '">' . esc_html($p) . '</a>' : esc_html($p); ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="pc-cta-group">
          <a class="pc-btn pc-btn--accent" href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($btn_text); ?> <?php echo sp_icon('arrow', 16); ?></a>
          <a class="pc-btn pc-btn--ghost" href="<?php echo esc_url(sp_rfq_url('Heavy Precast', '', 'Send Drawing')); ?>#rfq-files" data-track="drawing_click"><?php echo sp_icon('upload', 16); ?> Send Your Drawing</a>
        </div>
      </div>
      <div class="pc-heavy__media">
        <?php if ($img) : ?>
          <img src="<?php echo esc_url($img); ?>" alt="Heavy reinforced precast concrete unit manufactured by Precast Al Turab" loading="lazy" decoding="async">
        <?php else : echo sp_pc_placeholder('bunker', 'Heavy precast'); endif; ?>
        <div class="pc-heavy__badge">
          <strong>From Drawing to Delivery</strong>
          <span>Technical Review • Custom Moulds • Reinforcement • Casting • QA/QC • Heavy Lifting • Logistics</span>
        </div>
      </div>
    </div>
  </div>
</section>

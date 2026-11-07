<?php
/**
 * Single product page — Precast Al Turab (Brief: Priority 6, 18, 32, 36)
 *
 * 1 Hero (image, name, short description, buttons)
 * 2 Product overview   3 Technical information table   4 Applications
 * 5 Manufacturing process   6 Photo gallery   7 FAQs   8 Call to action
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
get_header();

while (have_posts()) : the_post();
    $id       = get_the_ID();
    $title    = get_the_title();
    $content  = get_the_content();
    $excerpt  = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags($content), 30);
    $overview = get_post_meta($id, '_sp_overview', true);
    $apps     = array_filter(array_map('trim', explode(',', (string) get_post_meta($id, '_sp_applications', true))));
    $faqs     = json_decode((string) get_post_meta($id, '_sp_faqs', true), true) ?: [];
    $specs    = json_decode((string) get_post_meta($id, '_sp_product_specs', true), true) ?: [];
    $material = get_post_meta($id, '_sp_product_material', true);
    $finish   = get_post_meta($id, '_sp_product_finish', true);
    $certs    = get_post_meta($id, '_sp_product_certifications', true);
    $ds_id    = (int) get_post_meta($id, '_sp_product_datasheet', true);
    $ds_url   = $ds_id ? wp_get_attachment_url($ds_id) : '';
    $gallery  = array_filter(array_map('absint', explode(',', (string) get_post_meta($id, '_sp_product_gallery', true))));
    $thumb    = get_post_thumbnail_id($id);
    if ($thumb) array_unshift($gallery, (int) $thumb);
    $gallery  = array_values(array_unique($gallery));
    $main_img = $gallery ? sp_img_url($gallery[0], 'large') : '';
    $cats     = get_the_terms($id, 'sp_product_cat');
    $wa       = sp_wa_url_for_product($id);
    $h1       = get_post_meta($id, '_sp_h1', true) ?: $title;

    // Technical table: material/finish + spec rows; "Project Specific" wording when empty.
    $rows = [];
    if ($material) $rows[] = ['Concrete Grade', $material];
    foreach ($specs as $s) if (!empty($s[0]) && !empty($s[1])) $rows[] = [$s[0], $s[1]];
    if ($finish) $rows[] = ['Finish', $finish];
    $have = array_map('strtolower', array_column($rows, 0));
    foreach (['Dimensions', 'Reinforcement', 'Wall Thickness', 'Unit Weight', 'Lifting System', 'Embedded Items', 'Quantity Capability', 'Customisation'] as $k) {
        if (!in_array(strtolower($k), $have, true)) {
            $rows[] = [$k, in_array($k, ['Quantity Capability'], true) ? 'Single units to full project quantities' : (in_array($k, ['Customisation'], true) ? 'Manufactured to client drawings and specification' : 'According to Approved Structural Drawing')];
        }
    }
    $process = [['Drawing Review', 'drawing'], ['Mould Preparation', 'mould'], ['Reinforcement', 'rebar'], ['Concrete Casting', 'cast'], ['Curing', 'curing'], ['Finishing', 'finish'], ['Inspection', 'inspect'], ['Lifting', 'lift'], ['Loading', 'load'], ['Delivery', 'truck']];

    // Related products: same category
    $related = [];
    if ($cats && !is_wp_error($cats)) {
        $related = get_posts(['post_type' => 'sp_product', 'posts_per_page' => 3, 'post__not_in' => [$id], 'tax_query' => [['taxonomy' => 'sp_product_cat', 'field' => 'term_id', 'terms' => $cats[0]->term_id]]]);
    }
?>
<main id="primary" class="site-main pc-product">

  <section class="pc-product__hero">
    <div class="container">
      <?php echo sp_breadcrumb_html(); ?>
      <div class="pc-product__hero-grid">
        <div class="pc-product__gallery">
          <div class="pc-product__main">
            <?php if ($main_img) : ?>
              <img src="<?php echo esc_url($main_img); ?>" alt="<?php echo esc_attr($title); ?>" id="pc-main-img" fetchpriority="high" decoding="async">
            <?php else : echo sp_pc_placeholder('box', 'Product photo coming soon'); endif; ?>
          </div>
          <?php if (count($gallery) > 1) : ?>
          <div class="pc-product__thumbs">
            <?php foreach ($gallery as $i => $gid) : $t = sp_img_url($gid, 'thumbnail'); $l = sp_img_url($gid, 'large'); if (!$t) continue; ?>
            <button type="button" class="<?php echo $i === 0 ? 'active' : ''; ?>" data-full="<?php echo esc_url($l); ?>" aria-label="Image <?php echo $i + 1; ?>"><img src="<?php echo esc_url($t); ?>" alt="" loading="lazy"></button>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="pc-product__info">
          <?php if ($cats && !is_wp_error($cats)) : ?>
          <div class="pc-product__cats"><?php foreach ($cats as $ct) : ?><a class="pc-tag pc-tag--static" href="<?php echo esc_url(get_term_link($ct)); ?>"><?php echo esc_html($ct->name); ?></a><?php endforeach; ?></div>
          <?php endif; ?>
          <h1 class="pc-product__title"><?php echo esc_html($h1); ?></h1>
          <p class="pc-product__excerpt"><?php echo esc_html($excerpt); ?></p>
          <?php echo sp_pc_card_specs_html($id); ?>
          <ul class="pc-product__quick">
            <?php foreach (array_slice($rows, 0, 4) as [$k, $v]) : ?><li><span><?php echo esc_html($k); ?></span><strong><?php echo esc_html($v); ?></strong></li><?php endforeach; ?>
          </ul>
          <?php echo sp_cta_buttons(['product' => $title, 'wa_msg' => '', 'labels' => ['quote' => 'Request Quotation', 'drawing' => 'Send Drawing', 'wa' => 'WhatsApp'], 'class' => 'pc-product__cta']); ?>
          <div class="pc-product__secondary">
            <a href="<?php echo esc_url(sp_rfq_url($title, '', 'Get Price')); ?>" data-track="rfq_click"><?php echo sp_icon('quote', 15); ?> Get Price</a>
            <a href="<?php echo esc_url($ds_url ?: sp_rfq_url($title, '', 'Technical Data Request')); ?>" <?php echo $ds_url ? 'target="_blank" rel="noopener" data-track="techdata_download"' : 'data-track="techdata_click"'; ?>><?php echo sp_icon('file', 15); ?> <?php echo $ds_url ? 'Download Data Sheet' : 'Request Technical Data'; ?></a>
            <a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener" data-track="whatsapp_click"><?php echo sp_icon('whatsapp', 15); ?> WhatsApp</a>
          </div>
          <?php if ($certs) : ?><p class="pc-product__certs"><?php echo sp_icon('shield', 15); ?> <?php echo esc_html($certs); ?></p><?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="pc-section pc-product__overview">
    <div class="container">
      <div class="pc-product__two">
        <div>
          <h2 class="pc-h3">Product Overview</h2>
          <div class="pc-prose">
            <?php if ($overview) echo wpautop(esc_html($overview)); ?>
            <?php if ($content) echo wp_kses_post(apply_filters('the_content', $content)); ?>
            <?php if (!$overview && !$content) echo '<p>' . esc_html($excerpt) . '</p>'; ?>
          </div>
        </div>
        <div>
          <h2 class="pc-h3">Technical Information</h2>
          <table class="pc-table">
            <tbody>
              <?php foreach ($rows as [$k, $v]) : ?><tr><th scope="row"><?php echo esc_html($k); ?></th><td><?php echo esc_html($v); ?></td></tr><?php endforeach; ?>
            </tbody>
          </table>
          <p class="pc-note">Values marked "Project Specific" or "According to Approved Structural Drawing" are confirmed per project during technical review.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="pc-section pc-product__apps">
    <div class="container">
      <div class="pc-product__two">
        <div>
          <h2 class="pc-h3">Applications</h2>
          <ul class="pc-chips">
            <?php foreach ($apps ?: ['Infrastructure', 'Construction', 'Industrial', 'Utilities', 'Security', 'Road Works', 'Government Projects', 'Temporary or Permanent Protection'] as $ap) : ?><li><?php echo esc_html($ap); ?></li><?php endforeach; ?>
          </ul>
        </div>
        <div>
          <h2 class="pc-h3">Manufacturing Process</h2>
          <ol class="pc-mini-process">
            <?php foreach ($process as $i => [$label, $ic]) : ?><li><span class="pc-mini-process__ic"><?php echo sp_icon($ic, 18); ?></span><?php echo esc_html($label); ?></li><?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <?php if (count($gallery) > 1) : ?>
  <section class="pc-section pc-product__photos">
    <div class="container">
      <h2 class="pc-h3">Photo Gallery</h2>
      <div class="pc-gallery">
        <?php foreach ($gallery as $gid) : $m = sp_img_url($gid, 'medium_large'); $l = sp_img_url($gid, 'large'); if (!$m) continue; $alt = get_post_meta($gid, '_wp_attachment_image_alt', true) ?: $title; ?>
        <a href="<?php echo esc_url($l); ?>" class="pc-gallery__item" target="_blank" rel="noopener"><img src="<?php echo esc_url($m); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" decoding="async"></a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($faqs) : ?>
  <section class="pc-section pc-product__faq">
    <div class="container">
      <h2 class="pc-h3">Frequently Asked Questions</h2>
      <div class="pc-faq">
        <?php foreach ($faqs as $i => $f) : if (empty($f[0])) continue; ?>
        <details class="pc-faq__item"<?php echo $i === 0 ? ' open' : ''; ?>>
          <summary><?php echo esc_html($f[0]); ?></summary>
          <div class="pc-faq__a"><?php echo wpautop(esc_html($f[1] ?? '')); ?></div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="pc-section pc-product__cta pc-final">
    <div class="container">
      <div class="pc-final__inner pc-final__inner--simple">
        <div class="pc-final__text">
          <h2 class="pc-h2 pc-h2--light">Need This Product for Your Project?</h2>
          <p class="pc-final__sub">Send us your drawing, BOQ or technical specification.</p>
          <?php echo sp_cta_buttons(['product' => $title, 'labels' => ['quote' => 'Request Quotation', 'drawing' => 'Upload Drawing', 'wa' => 'WhatsApp'], 'show' => ['quote', 'drawing', 'wa']]); ?>
        </div>
      </div>
    </div>
  </section>

  <?php if ($related) : ?>
  <section class="pc-section pc-product__related">
    <div class="container">
      <h2 class="pc-h3">Related Products</h2>
      <div class="pc-prod-grid"><?php foreach ($related as $rp) echo sp_pc_product_card($rp->ID); ?></div>
    </div>
  </section>
  <?php endif; ?>

</main>
<script>
(function(){var m=document.getElementById('pc-main-img');if(!m)return;document.querySelectorAll('.pc-product__thumbs button').forEach(function(b){b.addEventListener('click',function(){m.src=this.getAttribute('data-full');document.querySelectorAll('.pc-product__thumbs button').forEach(function(x){x.classList.remove('active')});this.classList.add('active');});});})();
</script>
<?php endwhile;
get_footer(); ?>

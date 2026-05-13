<?php
/**
 * Single product template for sp_product CPT.
 * URL: /products/{slug}/
 *
 * @package SublimePlusV2
 */
get_header();

while (have_posts()) : the_post();
    $sp_id       = get_the_ID();
    $title       = get_the_title();
    $content     = get_the_content();
    $excerpt     = get_the_excerpt();

    // Meta
    $icon_id        = (int) get_post_meta($sp_id, '_sp_product_icon',           true);
    $certifications = get_post_meta($sp_id,        '_sp_product_certifications', true);
    $material       = get_post_meta($sp_id,        '_sp_product_material',       true);
    $finish         = get_post_meta($sp_id,        '_sp_product_finish',         true);
    $datasheet_id   = (int) get_post_meta($sp_id,  '_sp_product_datasheet',      true);
    $gallery_raw    = get_post_meta($sp_id,        '_sp_product_gallery',        true);
    $specs_raw      = get_post_meta($sp_id,        '_sp_product_specs',          true);

    $icon_url       = $icon_id      ? wp_get_attachment_image_url($icon_id, 'thumbnail')    : '';
    $datasheet_url  = $datasheet_id ? wp_get_attachment_url($datasheet_id)                  : '';
    $specs          = $specs_raw    ? json_decode($specs_raw, true)                         : [];
    $certs          = $certifications ? array_filter(array_map('trim', explode(',', $certifications))) : [];

    // Gallery: featured image first, then gallery IDs
    $gallery_ids = $gallery_raw ? array_filter(array_map('absint', explode(',', $gallery_raw))) : [];
    $thumb_id    = get_post_thumbnail_id($sp_id);
    if ($thumb_id) array_unshift($gallery_ids, (int) $thumb_id);
    $gallery_ids = array_unique($gallery_ids);

    $main_img = $gallery_ids
        ? wp_get_attachment_image_url(reset($gallery_ids), 'large')
        : get_template_directory_uri() . '/assets/img/placeholder.jpg';

    // Taxonomy
    $cats = get_the_terms($sp_id, 'sp_product_cat');

    // Quick specs: material + finish + first 4 from spec table
    $quick_specs = [];
    if ($material) $quick_specs[] = [__('Material',    'sublimeplus'), $material];
    if ($finish)   $quick_specs[] = [__('Finish',      'sublimeplus'), $finish];
    foreach (array_slice($specs, 0, 4) as $s) $quick_specs[] = $s;

    // Related products (same first category, exclude current)
    $related = [];
    if ($cats && !is_wp_error($cats)) {
        $related_q = new WP_Query([
            'post_type'      => 'sp_product',
            'posts_per_page' => 3,
            'post__not_in'   => [$sp_id],
            'tax_query'      => [[
                'taxonomy' => 'sp_product_cat',
                'field'    => 'term_id',
                'terms'    => $cats[0]->term_id,
            ]],
            'orderby' => 'rand',
        ]);
        $related = $related_q->posts;
    }
?>

<main id="primary" class="content-area sp-single-product">

    <!-- Breadcrumb -->
    <nav class="sp-product-breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'sublimeplus'); ?>">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sublimeplus'); ?></a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('sp_product')); ?>"><?php esc_html_e('Products', 'sublimeplus'); ?></a>
            <?php if ($cats && !is_wp_error($cats)) : ?>
            <span class="sep">/</span>
            <a href="<?php echo esc_url(get_term_link($cats[0])); ?>"><?php echo esc_html($cats[0]->name); ?></a>
            <?php endif; ?>
            <span class="sep">/</span>
            <span class="current"><?php echo esc_html($title); ?></span>
        </div>
    </nav>

    <!-- Hero -->
    <section class="sp-product-hero">
        <div class="container">
            <div class="sp-product-hero__grid">

                <!-- Gallery column -->
                <div class="sp-gallery">
                    <div class="sp-gallery__main" id="sp-main-img">
                        <img src="<?php echo esc_url($main_img); ?>"
                             alt="<?php echo esc_attr($title); ?>"
                             id="sp-main-img-el">
                    </div>

                    <?php if (count($gallery_ids) > 1) : ?>
                    <div class="sp-gallery__thumbs">
                        <?php foreach ($gallery_ids as $i => $gid) :
                            $turl = wp_get_attachment_image_url($gid, 'thumbnail');
                            $lurl = wp_get_attachment_image_url($gid, 'large');
                            if (!$turl) continue;
                        ?>
                        <div class="sp-thumb<?php echo $i === 0 ? ' active' : ''; ?>"
                             data-full="<?php echo esc_url($lurl); ?>">
                            <img src="<?php echo esc_url($turl); ?>"
                                 alt="<?php printf(esc_attr__('%s — image %d', 'sublimeplus'), esc_attr($title), $i + 1); ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Info column -->
                <div class="sp-product-info">

                    <!-- Badges -->
                    <div class="sp-product-badges">
                        <?php if ($cats && !is_wp_error($cats)) :
                            foreach ($cats as $cat) : ?>
                        <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                           class="sp-product-cat-badge"><?php echo esc_html($cat->name); ?></a>
                        <?php endforeach; endif; ?>

                        <?php foreach ($certs as $cert) : ?>
                        <span class="sp-cert-badge"><?php echo esc_html($cert); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Title -->
                    <h1 class="sp-product-title">
                        <?php if ($icon_url) : ?>
                        <img src="<?php echo esc_url($icon_url); ?>" alt="" width="32" height="32" aria-hidden="true">
                        <?php endif; ?>
                        <?php echo esc_html($title); ?>
                    </h1>

                    <!-- Excerpt -->
                    <?php if ($excerpt) : ?>
                    <p class="sp-product-excerpt"><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>

                    <!-- Quick specs -->
                    <?php if (!empty($quick_specs)) : ?>
                    <div class="sp-product-quick-specs">
                        <?php foreach ($quick_specs as $qs) : ?>
                        <div class="sp-qspec-row">
                            <?php if (!empty($qs[2])) : ?>
                            <img src="<?php echo esc_url($qs[2]); ?>" class="sp-qspec-icon" alt="" width="16" height="16">
                            <?php endif; ?>
                            <span class="sp-qspec-label"><?php echo esc_html($qs[0]); ?></span>
                            <span class="sp-qspec-value"><?php echo esc_html($qs[1]); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Actions -->
                    <div class="sp-product-actions">
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>#quote-form"
                           class="btn btn-primary">
                            <?php esc_html_e('Request a Quote', 'sublimeplus'); ?>
                        </a>
                        <?php if ($datasheet_url) : ?>
                        <a href="<?php echo esc_url($datasheet_url); ?>"
                           class="btn btn-outline-secondary"
                           target="_blank" rel="noopener">
                            <?php esc_html_e('Download Datasheet', 'sublimeplus'); ?>
                        </a>
                        <?php endif; ?>
                    </div>

                </div><!-- .sp-product-info -->
            </div><!-- .sp-product-hero__grid -->
        </div><!-- .container -->
    </section>

    <div class="container">

        <!-- Full description -->
        <?php if ($content) : ?>
        <div class="sp-product-description">
            <h2><?php esc_html_e('Product Description', 'sublimeplus'); ?></h2>
            <div class="entry-content">
                <?php echo wp_kses_post(apply_filters('the_content', $content)); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Full specifications table -->
        <?php if (!empty($specs)) : ?>
        <div class="sp-specs-section">
            <h2><?php esc_html_e('Technical Specifications', 'sublimeplus'); ?></h2>
            <table class="sp-specs-table">
                <tbody>
                    <?php foreach ($specs as $row) : ?>
                    <tr>
                        <th>
                            <?php if (!empty($row[2])) : ?>
                            <img src="<?php echo esc_url($row[2]); ?>" class="sp-spec-tbl-icon" alt="" width="15" height="15">
                            <?php endif; ?>
                            <?php echo esc_html($row[0] ?? ''); ?>
                        </th>
                        <td><?php echo esc_html($row[1] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Related products -->
        <?php if (!empty($related)) : ?>
        <div class="sp-related-section">
            <h2><?php esc_html_e('Related Products', 'sublimeplus'); ?></h2>
            <div class="sp-related-grid">
                <?php foreach ($related as $rp) :
                    $r_id    = $rp->ID;
                    $r_img   = get_the_post_thumbnail_url($r_id, 'medium_large') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg';
                    $r_title = get_the_title($r_id);
                    $r_link  = get_permalink($r_id);
                    $r_icon_id  = (int) get_post_meta($r_id, '_sp_product_icon', true);
                    $r_icon_url = $r_icon_id ? wp_get_attachment_image_url($r_icon_id, 'thumbnail') : '';
                    $r_exc   = get_the_excerpt($rp);
                ?>
                <a href="<?php echo esc_url($r_link); ?>" class="product-card-link">
                    <article class="product-card">
                        <div class="product-card__image">
                            <img src="<?php echo esc_url($r_img); ?>"
                                 alt="<?php echo esc_attr($r_title); ?>"
                                 loading="lazy" decoding="async">
                        </div>
                        <h3>
                            <?php if ($r_icon_url) : ?>
                            <img class="heading-icon" src="<?php echo esc_url($r_icon_url); ?>" alt="" width="20" height="20" aria-hidden="true">
                            <?php endif; ?>
                            <?php echo esc_html($r_title); ?>
                        </h3>
                        <?php if ($r_exc) : ?>
                        <p><?php echo esc_html($r_exc); ?></p>
                        <?php endif; ?>
                    </article>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- .container -->

</main>

<script>
(function() {
    var thumbs = document.querySelectorAll('.sp-thumb');
    var mainImg = document.getElementById('sp-main-img-el');
    if (!mainImg || !thumbs.length) return;

    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            var full = this.dataset.full;
            if (!full) return;
            mainImg.style.opacity = '0';
            setTimeout(function() {
                mainImg.src = full;
                mainImg.style.opacity = '1';
            }, 150);
            thumbs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
        });
    });
})();
</script>

<?php endwhile; ?>

<?php get_footer(); ?>

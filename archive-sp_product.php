<?php
/**
 * Archive template for sp_product CPT.
 * URL: /products/
 *
 * @package SublimePlusV2
 */
get_header();

// Collect all categories for the filter bar
$all_cats   = get_terms(['taxonomy' => 'sp_product_cat', 'hide_empty' => true]);
$active_cat = get_queried_object(); // WP_Term on taxonomy archive, WP_Post_Type on main archive
$active_slug = ($active_cat instanceof WP_Term) ? $active_cat->slug : '';
?>

<main id="primary" class="content-area">

    <!-- Archive header -->
    <header class="sp-archive-header">
        <div class="container">
            <h1><?php echo $active_slug
                    ? esc_html($active_cat->name)
                    : esc_html__('Product Catalogue', 'sublimeplus');
            ?></h1>
            <p><?php esc_html_e('Explore our range of RTA-approved precast concrete solutions manufactured for UAE infrastructure projects.', 'sublimeplus'); ?></p>
        </div>
    </header>

    <div class="container">

        <!-- Category filter tabs -->
        <?php if ($all_cats && !is_wp_error($all_cats)) : ?>
        <nav class="sp-cat-filter" aria-label="<?php esc_attr_e('Filter by category', 'sublimeplus'); ?>">
            <a href="<?php echo esc_url(get_post_type_archive_link('sp_product')); ?>"
               class="sp-cat-tab<?php echo $active_slug ? '' : ' active'; ?>">
                <?php esc_html_e('All', 'sublimeplus'); ?>
            </a>
            <?php foreach ($all_cats as $cat) : ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>"
               class="sp-cat-tab<?php echo ($active_slug === $cat->slug) ? ' active' : ''; ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

        <!-- Products grid -->
        <?php if (have_posts()) : ?>
        <div class="sp-products-grid">
            <?php while (have_posts()) : the_post();
                $sp_id       = get_the_ID();
                $permalink   = get_the_permalink();
                $title       = get_the_title();
                $img_url     = get_the_post_thumbnail_url($sp_id, 'large') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg';
                $excerpt     = get_the_excerpt();
                $icon_id     = (int) get_post_meta($sp_id, '_sp_product_icon', true);
                $icon_url    = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
                $specs_raw   = get_post_meta($sp_id, '_sp_product_specs', true);
                $specs       = $specs_raw ? json_decode($specs_raw, true) : [];
                $cats        = get_the_terms($sp_id, 'sp_product_cat');
            ?>
            <a href="<?php echo esc_url($permalink); ?>" class="product-card-link">
                <article class="product-card">

                    <div class="product-card__image">
                        <img src="<?php echo esc_url($img_url); ?>"
                             alt="<?php echo esc_attr($title); ?>"
                             loading="lazy" decoding="async">
                    </div>

                    <?php if ($cats && !is_wp_error($cats)) : ?>
                    <div class="sp-product-badges">
                        <?php foreach ($cats as $cat) : ?>
                        <span class="sp-product-cat-badge"><?php echo esc_html($cat->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <h3>
                        <?php if ($icon_url) : ?>
                        <img class="heading-icon" src="<?php echo esc_url($icon_url); ?>" alt="" width="24" height="24" aria-hidden="true">
                        <?php endif; ?>
                        <?php echo esc_html($title); ?>
                    </h3>

                    <?php if ($excerpt) : ?>
                    <p><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($specs)) : ?>
                    <div class="specs-minimal">
                        <?php foreach (array_slice($specs, 0, 3) as $spec) : ?>
                        <div class="spec-row">
                            <span class="label"><?php echo esc_html($spec[0]); ?></span>
                            <span class="value"><?php echo esc_html($spec[1]); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </article>
            </a>
            <?php endwhile; ?>
        </div>

        <?php
        // Pagination
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&larr; ' . __('Previous', 'sublimeplus'),
            'next_text' => __('Next', 'sublimeplus') . ' &rarr;',
        ]);
        ?>

        <?php else : ?>
        <p class="py-5 text-center text-muted"><?php esc_html_e('No products found.', 'sublimeplus'); ?></p>
        <?php endif; ?>

    </div><!-- .container -->

</main>

<?php get_footer(); ?>

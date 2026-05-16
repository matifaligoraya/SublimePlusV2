<?php
/**
 * Archive template for sp_project CPT.
 * URL: /projects/
 *
 * @package SublimePlusV2
 */
get_header();

$all_cats    = get_terms(['taxonomy' => 'sp_project_cat', 'hide_empty' => true]);
$active_cat  = get_queried_object();
$active_slug = ($active_cat instanceof WP_Term) ? $active_cat->slug : '';

$emirate_map = [
    'dubai'          => 'Dubai',
    'abu-dhabi'      => 'Abu Dhabi',
    'sharjah'        => 'Sharjah',
    'ajman'          => 'Ajman',
    'ras-al-khaimah' => 'Ras Al Khaimah',
    'fujairah'       => 'Fujairah',
    'western-region' => 'Western Region',
    'uae'            => 'UAE',
];

$status_styles = [
    'completed' => 'background:#dcfce7;color:#166534;',
    'ongoing'   => 'background:#dbeafe;color:#1e40af;',
    'upcoming'  => 'background:#fef9c3;color:#854d0e;',
];
?>

<main id="primary" class="content-area">

    <header class="sp-archive-header">
        <div class="container">
            <h1><?php echo $active_slug
                    ? esc_html($active_cat->name)
                    : esc_html__('Project Portfolio', 'sublimeplus');
            ?></h1>
            <p><?php esc_html_e('Precast concrete solutions delivered across UAE\'s infrastructure, residential, commercial, and industrial sectors.', 'sublimeplus'); ?></p>
        </div>
    </header>

    <div class="container">

        <?php if ($all_cats && !is_wp_error($all_cats)) : ?>
        <nav class="sp-cat-filter" aria-label="<?php esc_attr_e('Filter by category', 'sublimeplus'); ?>">
            <a href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>"
               class="sp-cat-tab<?php echo $active_slug ? '' : ' active'; ?>">
                <?php esc_html_e('All Projects', 'sublimeplus'); ?>
            </a>
            <?php foreach ($all_cats as $cat) : ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>"
               class="sp-cat-tab<?php echo ($active_slug === $cat->slug) ? ' active' : ''; ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
        <div class="sp-projects-grid">
            <?php while (have_posts()) : the_post();
                $pid         = get_the_ID();
                $permalink   = get_the_permalink();
                $title       = get_the_title();
                $img_url     = get_the_post_thumbnail_url($pid, 'large') ?: '';
                $client      = get_post_meta($pid, '_sp_project_client',  true);
                $emirate_key = get_post_meta($pid, '_sp_project_emirate', true);
                $emirate     = $emirate_map[$emirate_key] ?? $emirate_key;
                $scale       = get_post_meta($pid, '_sp_project_scale',   true);
                $status      = get_post_meta($pid, '_sp_project_status',  true);
                $cats        = get_the_terms($pid, 'sp_project_cat');
                $status_map  = ['completed' => 'Completed', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming'];
                $status_label = $status_map[$status] ?? '';
                $status_style = $status_styles[$status] ?? '';
            ?>
            <a href="<?php echo esc_url($permalink); ?>" class="sp-proj-card">

                <div class="sp-proj-card__media">
                    <?php if ($img_url) : ?>
                    <img src="<?php echo esc_url($img_url); ?>"
                         alt="<?php echo esc_attr($title); ?>"
                         loading="lazy" decoding="async">
                    <?php else : ?>
                    <div class="sp-proj-card__placeholder"></div>
                    <?php endif; ?>
                    <div class="sp-proj-card__overlay"></div>
                    <?php if ($cats && !is_wp_error($cats)) : ?>
                    <div class="sp-proj-card__cats">
                        <?php foreach (array_slice($cats, 0, 3) as $cat) : ?>
                        <span class="sp-proj-cat-tag"><?php echo esc_html($cat->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="sp-proj-card__body">
                    <h3 class="sp-proj-card__title"><?php echo esc_html($title); ?></h3>

                    <?php if ($client || $emirate || $scale) : ?>
                    <div class="sp-proj-card__meta">
                        <?php if ($client) : ?>
                        <div class="sp-proj-card__meta-item">
                            <span class="sp-proj-meta-label"><?php _e('Client', 'sublimeplus'); ?></span>
                            <span class="sp-proj-meta-value"><?php echo esc_html($client); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($emirate) : ?>
                        <div class="sp-proj-card__meta-item">
                            <span class="sp-proj-meta-label"><?php _e('Location', 'sublimeplus'); ?></span>
                            <span class="sp-proj-meta-value"><?php echo esc_html($emirate); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($scale) : ?>
                        <div class="sp-proj-card__meta-item">
                            <span class="sp-proj-meta-label"><?php _e('Scale', 'sublimeplus'); ?></span>
                            <span class="sp-proj-meta-value"><?php echo esc_html($scale); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($status_label) : ?>
                    <span class="sp-proj-status" style="<?php echo esc_attr($status_style); ?>"><?php echo esc_html($status_label); ?></span>
                    <?php endif; ?>
                </div>

            </a>
            <?php endwhile; ?>
        </div>

        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&larr; ' . __('Previous', 'sublimeplus'),
            'next_text' => __('Next', 'sublimeplus') . ' &rarr;',
        ]);
        ?>

        <?php else : ?>
        <p class="py-5 text-center text-muted"><?php esc_html_e('No projects found.', 'sublimeplus'); ?></p>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>

<?php
/**
 * Homepage — Featured Projects showcase (bento card grid)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args     = $args ?? [];
$eyebrow  = $args['eyebrow']  ?? 'Our Projects';
$heading  = $args['heading']  ?? 'Delivered Across All Seven Emirates';
$subtext  = $args['subtext']  ?? 'From highway safety barriers to large-scale residential block work — our precast concrete products are trusted by UAE\'s leading contractors and developers.';
$cta_text = $args['cta_text'] ?? 'View All Projects';
$cta_url  = $args['cta_url']  ?? (get_post_type_archive_link('sp_project') ?: '#');

// ── Query CPT ─────────────────────────────────────────────────────────────────
$query = new WP_Query([
    'post_type'      => 'sp_project',
    'posts_per_page' => 5,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$projects = [];

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $pid  = get_the_ID();
        $cats = get_the_terms($pid, 'sp_project_cat');

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
        $emirate_key = get_post_meta($pid, '_sp_project_emirate', true);

        $projects[] = [
            'title'   => get_the_title(),
            'link'    => get_the_permalink(),
            'img'     => get_the_post_thumbnail_url($pid, 'large') ?: '',
            'client'  => get_post_meta($pid, '_sp_project_client', true),
            'emirate' => $emirate_map[$emirate_key] ?? $emirate_key,
            'scale'   => get_post_meta($pid, '_sp_project_scale', true),
            'status'  => get_post_meta($pid, '_sp_project_status', true),
            'cats'    => ($cats && !is_wp_error($cats)) ? $cats : [],
        ];
    }
    wp_reset_postdata();
}

// ── Fallback static showcase when no CPT posts yet ────────────────────────────
if (empty($projects)) {
    $pu = get_post_type_archive_link('sp_product') ?: '#';
    $projects = apply_filters('sp_projects_fallback', [
        [
            'title'     => 'Al Maktoum Airport Road Expansion',
            'link'      => $pu,
            'img'       => '',
            'client'    => 'RTA Dubai',
            'emirate'   => 'Dubai',
            'scale'     => '3,200 Barriers',
            'status'    => 'completed',
            'cats_text' => ['Infrastructure', 'Road Barriers', 'RTA'],
        ],
        [
            'title'     => 'DAMAC Hills Community Phase 3',
            'link'      => $pu,
            'img'       => '',
            'client'    => 'DAMAC Properties',
            'emirate'   => 'Dubai',
            'scale'     => '8,500 Blocks',
            'status'    => 'completed',
            'cats_text' => ['Residential', 'Masonry Blocks'],
        ],
        [
            'title'     => 'Etihad Rail Safety Corridor',
            'link'      => $pu,
            'img'       => '',
            'client'    => 'Etihad Rail',
            'emirate'   => 'Abu Dhabi',
            'scale'     => '5,000 Barriers',
            'status'    => 'completed',
            'cats_text' => ['Infrastructure', 'Road Barriers'],
        ],
        [
            'title'     => 'Yas Island Development Works',
            'link'      => $pu,
            'img'       => '',
            'client'    => 'Aldar Properties',
            'emirate'   => 'Abu Dhabi',
            'scale'     => '12,000 Blocks',
            'status'    => 'ongoing',
            'cats_text' => ['Commercial', 'Masonry Blocks'],
        ],
        [
            'title'     => 'Sharjah Industrial Zone Perimeter',
            'link'      => $pu,
            'img'       => '',
            'client'    => 'SEDD',
            'emirate'   => 'Sharjah',
            'scale'     => '1,800 Barriers',
            'status'    => 'completed',
            'cats_text' => ['Industrial', 'Road Barriers'],
        ],
    ]);
}

if (empty($projects)) return;

$status_labels = ['completed' => 'Completed', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming'];
?>
<section class="sp-projects-section" id="projects">
  <div class="container">

    <div class="sp-proj-header">
      <div>
        <?php if ($eyebrow) : ?>
        <span class="section-eyebrow section-eyebrow--dark"><?php echo esc_html($eyebrow); ?></span>
        <?php endif; ?>
        <h2 class="sp-proj-heading"><?php echo esc_html($heading); ?></h2>
        <p class="sp-proj-subtext"><?php echo esc_html($subtext); ?></p>
      </div>
      <?php if ($cta_text && $cta_url) : ?>
      <a href="<?php echo esc_url($cta_url); ?>" class="btn-sp-outline sp-proj-cta-top">
        <?php echo esc_html($cta_text); ?>
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="9 3 14 8 9 13"/></svg>
      </a>
      <?php endif; ?>
    </div>

    <div class="sp-proj-bento">
      <?php foreach ($projects as $idx => $p) :
        $is_featured = ($idx === 0);
        $card_class  = 'sp-proj-card' . ($is_featured ? ' sp-proj-featured' : '');
        $link        = !empty($p['link']) ? esc_url($p['link']) : '#';
        $img         = !empty($p['img'])  ? esc_url($p['img'])  : '';
        $status      = $p['status'] ?? '';
        $status_label = $status_labels[$status] ?? '';

        // Category names from CPT terms or static fallback
        if (!empty($p['cats']) && is_array($p['cats']) && !empty($p['cats'][0]) && is_object($p['cats'][0])) {
            $cat_names = array_map(function ($c) { return $c->name; }, $p['cats']);
        } elseif (!empty($p['cats_text'])) {
            $cat_names = $p['cats_text'];
        } else {
            $cat_names = [];
        }
      ?>
      <a href="<?php echo $link; ?>" class="<?php echo esc_attr($card_class); ?>">

        <div class="sp-proj-card__media">
          <?php if ($img) : ?>
          <img src="<?php echo $img; ?>" alt="<?php echo esc_attr($p['title']); ?>" loading="lazy" decoding="async">
          <?php else : ?>
          <div class="sp-proj-card__placeholder"></div>
          <?php endif; ?>
          <div class="sp-proj-card__overlay"></div>
          <?php if (!empty($cat_names)) : ?>
          <div class="sp-proj-card__cats">
            <?php foreach (array_slice($cat_names, 0, 3) as $cat_name) : ?>
            <span class="sp-proj-cat-tag"><?php echo esc_html($cat_name); ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="sp-proj-card__body">
          <h3 class="sp-proj-card__title"><?php echo esc_html($p['title']); ?></h3>

          <?php if (!empty($p['client']) || !empty($p['emirate']) || !empty($p['scale'])) : ?>
          <div class="sp-proj-card__meta">
            <?php if (!empty($p['client'])) : ?>
            <div class="sp-proj-card__meta-item">
              <span class="sp-proj-meta-label"><?php _e('Client', 'sublimeplus'); ?></span>
              <span class="sp-proj-meta-value"><?php echo esc_html($p['client']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($p['emirate'])) : ?>
            <div class="sp-proj-card__meta-item">
              <span class="sp-proj-meta-label"><?php _e('Location', 'sublimeplus'); ?></span>
              <span class="sp-proj-meta-value"><?php echo esc_html($p['emirate']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($p['scale'])) : ?>
            <div class="sp-proj-card__meta-item">
              <span class="sp-proj-meta-label"><?php _e('Scale', 'sublimeplus'); ?></span>
              <span class="sp-proj-meta-value"><?php echo esc_html($p['scale']); ?></span>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <?php if ($status_label) : ?>
          <span class="sp-proj-status sp-proj-status--<?php echo esc_attr($status); ?>"><?php echo esc_html($status_label); ?></span>
          <?php endif; ?>
        </div>

      </a>
      <?php endforeach; ?>
    </div>

    <?php if ($cta_text && $cta_url) : ?>
    <div class="text-center mt-5">
      <a href="<?php echo esc_url($cta_url); ?>" class="cta-primary">
        <?php echo esc_html($cta_text); ?>
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="9 3 14 8 9 13"/></svg>
      </a>
    </div>
    <?php endif; ?>

  </div>
</section>

<?php
/**
 * Project case study page — Precast Al Turab (Brief: Priority 10, 31)
 *
 * Hero photo · summary table · scope of work · technical information ·
 * manufacturing process photos · logistics photos · gallery · CTA
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;
get_header();

while (have_posts()) : the_post();
    $id      = get_the_ID();
    $title   = get_the_title();
    $content = get_the_content();
    $hero    = get_the_post_thumbnail_url($id, 'full');
    $g = fn($k) => get_post_meta($id, $k, true);

    $emirate_map = ['dubai' => 'Dubai', 'abu-dhabi' => 'Abu Dhabi', 'sharjah' => 'Sharjah', 'ajman' => 'Ajman', 'ras-al-khaimah' => 'Ras Al Khaimah', 'fujairah' => 'Fujairah', 'umm-al-quwain' => 'Umm Al Quwain', 'western-region' => 'Western Region', 'al-ain' => 'Al Ain', 'uae' => 'UAE'];
    $status_map  = ['completed' => 'Completed', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming'];
    $loc   = $emirate_map[$g('_sp_project_emirate')] ?? $g('_sp_project_emirate');
    $date  = $g('_sp_project_date');
    $year  = $date ? date('Y', strtotime($date)) : '';
    $prod_ids = json_decode((string) $g('_sp_project_products'), true) ?: [];
    $product  = $g('_sp_project_product') ?: implode(', ', array_filter(array_map('get_the_title', $prod_ids)));
    $qty   = $g('_sp_project_quantity') ?: $g('_sp_project_scale');
    $cats  = get_the_terms($id, 'sp_project_cat');

    $summary = array_filter([
        'Project'         => $title,
        'Location'        => $loc,
        'Year'            => $year,
        'Product'         => $product,
        'Quantity'        => $qty,
        'Client'          => $g('_sp_project_client'),
        'Main Contractor' => $g('_sp_project_contractor'),
        'Consultant'      => $g('_sp_project_consultant'),
        'Status'          => $status_map[$g('_sp_project_status')] ?? '',
    ]);
    $tech = json_decode((string) $g('_sp_project_tech'), true) ?: [];
    if ($g('_sp_project_lifting')) $tech[] = ['Lifting Method', $g('_sp_project_lifting')];
    if ($g('_sp_project_period'))  $tech[] = ['Production Period', $g('_sp_project_period')];
    if ($qty && !in_array('Quantity', array_column($tech, 0), true)) $tech[] = ['Quantity', $qty];

    $ids = fn($k) => array_values(array_filter(array_map('absint', explode(',', (string) $g($k)))));
    $process_ids   = $ids('_sp_project_process_gallery');
    $logistics_ids = $ids('_sp_project_logistics_gallery');
    $gallery_raw   = $g('_sp_project_gallery');
    $gallery_ids   = is_array($gallery_raw) ? array_values(array_filter(array_map('absint', $gallery_raw))) : $ids('_sp_project_gallery');
    $thumb = get_post_thumbnail_id($id);
    if ($thumb && !in_array($thumb, $gallery_ids, true)) array_unshift($gallery_ids, (int) $thumb);

    $scope = $g('_sp_project_scope');
    $gallery_block = function (array $ids, string $heading, string $sub = '') use ($title) {
        if (!$ids) return;
        echo '<section class="pc-section pc-project__photos"><div class="container"><h2 class="pc-h3">' . esc_html($heading) . '</h2>';
        if ($sub) echo '<p class="pc-sub">' . esc_html($sub) . '</p>';
        echo '<div class="pc-gallery">';
        foreach ($ids as $gid) {
            $m = sp_img_url($gid, 'medium_large'); $l = sp_img_url($gid, 'large'); if (!$m) continue;
            $alt = get_post_meta($gid, '_wp_attachment_image_alt', true) ?: $title;
            echo '<a href="' . esc_url($l) . '" class="pc-gallery__item" target="_blank" rel="noopener"><img src="' . esc_url($m) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async"></a>';
        }
        echo '</div></div></section>';
    };
    $related = get_posts(['post_type' => 'sp_project', 'posts_per_page' => 3, 'post__not_in' => [$id], 'meta_key' => '_thumbnail_id']);
?>
<main id="primary" class="site-main pc-project">

  <section class="pc-project__hero<?php echo $hero ? ' pc-project__hero--img' : ''; ?>">
    <?php if ($hero) : ?><img class="pc-project__bg" src="<?php echo esc_url($hero); ?>" alt="" fetchpriority="high" decoding="async"><div class="pc-project__shade"></div><?php endif; ?>
    <div class="container">
      <?php echo sp_breadcrumb_html(); ?>
      <div class="pc-project__hero-inner">
        <?php if ($cats && !is_wp_error($cats)) : ?><div class="pc-project__cats"><?php foreach ($cats as $ct) : ?><a class="pc-tag pc-tag--static" href="<?php echo esc_url(get_term_link($ct)); ?>"><?php echo esc_html($ct->name); ?></a><?php endforeach; ?></div><?php endif; ?>
        <h1 class="pc-phero__title"><?php echo esc_html($title); ?></h1>
        <?php if (has_excerpt()) : ?><p class="pc-phero__sub"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
        <div class="pc-project__hero-cta">
          <a class="pc-btn pc-btn--accent" href="<?php echo esc_url(sp_rfq_url($product ?: 'Similar product', $title)); ?>" data-track="rfq_click"><?php echo sp_icon('quote', 16); ?> Request Similar Product</a>
          <a class="pc-btn pc-btn--wa" href="<?php echo esc_url(sp_wa_url('Hello Precast Al Turab, I need a quotation for a product similar to your project: ' . $title . '.')); ?>" target="_blank" rel="noopener" data-track="whatsapp_click"><?php echo sp_icon('whatsapp', 16); ?> WhatsApp</a>
        </div>
      </div>
    </div>
  </section>

  <section class="pc-section">
    <div class="container">
      <div class="pc-project__grid">
        <div class="pc-project__main">
          <h2 class="pc-h3">Scope of Work</h2>
          <div class="pc-prose">
            <?php if ($scope) echo wpautop(esc_html($scope)); ?>
            <?php if ($content) echo wp_kses_post(apply_filters('the_content', $content)); ?>
            <?php if (!$scope && !$content) : ?><p>Manufacture of reinforced precast components including mould preparation, reinforcement fabrication, concrete casting, curing, finishing and crane loading.</p><?php endif; ?>
          </div>
          <?php if ($tech) : ?>
          <h2 class="pc-h3">Technical Information</h2>
          <table class="pc-table"><tbody>
            <?php foreach ($tech as $row) : if (empty($row[0])) continue; ?><tr><th scope="row"><?php echo esc_html($row[0]); ?></th><td><?php echo esc_html($row[1] ?? ''); ?></td></tr><?php endforeach; ?>
          </tbody></table>
          <?php endif; ?>
        </div>
        <aside class="pc-project__side">
          <div class="pc-summary">
            <h2 class="pc-h3">Project Summary</h2>
            <table class="pc-table pc-table--compact"><tbody>
              <?php foreach ($summary as $k => $v) : ?><tr><th scope="row"><?php echo esc_html($k); ?></th><td><?php echo esc_html($v); ?></td></tr><?php endforeach; ?>
            </tbody></table>
            <?php if ($prod_ids) : ?>
            <p class="pc-summary__label">Products used</p>
            <ul class="pc-summary__links"><?php foreach ($prod_ids as $pid) : if (get_post_status($pid) !== 'publish') continue; ?><li><a href="<?php echo esc_url(get_permalink($pid)); ?>"><?php echo esc_html(get_the_title($pid)); ?> <?php echo sp_icon('arrow', 14); ?></a></li><?php endforeach; ?></ul>
            <?php endif; ?>
            <a class="pc-btn pc-btn--accent pc-btn--block" href="<?php echo esc_url(sp_rfq_url($product ?: 'Similar product', $title)); ?>" data-track="rfq_click">Request Similar Product</a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <?php
  $gallery_block($process_ids,   'Manufacturing Process', 'Mould, reinforcement, casting, curing, demoulding, finishing and inspection.');
  $gallery_block($logistics_ids, 'Logistics',             'Crane lifting, trailer loading, transport and site delivery.');
  $gallery_block($gallery_ids,   'Project Gallery');
  ?>

  <section class="pc-section pc-final">
    <div class="container">
      <div class="pc-final__inner pc-final__inner--simple">
        <div class="pc-final__text">
          <h2 class="pc-h2 pc-h2--light">Need a Similar Product for Your Project?</h2>
          <p class="pc-final__sub">The enquiry form will carry this project as your reference.</p>
          <?php echo sp_cta_buttons(['product' => $product ?: '', 'project' => $title, 'labels' => ['quote' => 'Request Similar Product', 'drawing' => 'Upload Drawing', 'wa' => 'WhatsApp']]); ?>
        </div>
      </div>
    </div>
  </section>

  <?php if ($related) : ?>
  <section class="pc-section">
    <div class="container">
      <h2 class="pc-h3">More Projects</h2>
      <div class="pc-proj-grid"><?php foreach ($related as $rp) echo sp_pc_project_card($rp->ID); ?></div>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php endwhile;
get_footer(); ?>

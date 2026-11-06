<?php
/**
 * Precast — Featured projects on the homepage (Brief: Priority 39 #7)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading'] ?: 'Featured Projects';
$subtext = $args['subtext'] ?: 'Manufactured in the UAE. Built for real project conditions.';
$count   = max(2, min(8, (int) ($args['count'] ?: 4)));

$q = new WP_Query([
    'post_type' => 'sp_project', 'posts_per_page' => $count, 'post_status' => 'publish',
    'orderby' => ['menu_order' => 'ASC', 'date' => 'DESC'],
    'meta_query' => [['key' => '_thumbnail_id', 'compare' => 'EXISTS']],
]);
$ids = wp_list_pluck($q->posts, 'ID');
wp_reset_postdata();
if (!$ids) return;
?>
<section class="pc-section pc-featproj" id="projects">
  <div class="container">
    <div class="pc-resources__head">
      <?php echo sp_section_head('Our Projects', $heading, $subtext); ?>
      <a class="pc-btn pc-btn--dark" href="<?php echo esc_url(get_post_type_archive_link('sp_project')); ?>">All Projects <?php echo sp_icon('arrow', 16); ?></a>
    </div>
    <div class="pc-proj-grid pc-proj-grid--home">
      <?php foreach ($ids as $i => $pid) echo sp_pc_project_card($pid, $i === 0); ?>
    </div>
  </div>
</section>

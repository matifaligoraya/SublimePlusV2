<?php
/**
 * Stats counter section — animated number grid
 *
 * @package SublimePlusV2
 * @var array $args  eyebrow, heading, subtext, stats (param_group rows)
 */
defined('ABSPATH') || exit;

$eyebrow = $args['eyebrow'] ?? '';
$heading = $args['heading'] ?? '';
$subtext = $args['subtext'] ?? '';
$bg      = $args['bg']      ?? 'light';   // light | dark | accent

$default_stats = [
    ['number' => '500',  'suffix' => '+', 'prefix' => '',  'label' => 'Projects Delivered'],
    ['number' => '15',   'suffix' => '+', 'prefix' => '',  'label' => 'Years of Experience'],
    ['number' => '6',    'suffix' => '',  'prefix' => '',  'label' => 'Emirates Served'],
    ['number' => '200',  'suffix' => '+', 'prefix' => '',  'label' => 'Products in Catalogue'],
];

$stats = !empty($args['stats']) ? $args['stats'] : $default_stats;

$bg_class = 'sp-stats--light';
if ($bg === 'dark')   $bg_class = 'sp-stats--dark';
if ($bg === 'accent') $bg_class = 'sp-stats--accent';
?>
<section class="sp-stats <?= esc_attr($bg_class) ?>">
  <div class="container">

    <?php if ($eyebrow || $heading || $subtext) : ?>
      <div class="sp-stats__header">
        <?php if ($eyebrow) : ?>
          <p class="sp-stats__eyebrow"><?= esc_html($eyebrow) ?></p>
        <?php endif; ?>
        <?php if ($heading) : ?>
          <h2 class="sp-stats__heading"><?= esc_html($heading) ?></h2>
        <?php endif; ?>
        <?php if ($subtext) : ?>
          <p class="sp-stats__sub"><?= esc_html($subtext) ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="sp-stats__grid">
      <?php foreach ($stats as $stat) :
        $num    = $stat['number'] ?? '0';
        $suffix = $stat['suffix'] ?? '';
        $prefix = $stat['prefix'] ?? '';
        $label  = $stat['label']  ?? '';
      ?>
        <div class="sp-stats__card">
          <div class="sp-stats__number" data-target="<?= esc_attr($num) ?>">
            <span class="sp-stats__prefix"><?= esc_html($prefix) ?></span>
            <span class="sp-stats__count">0</span>
            <span class="sp-stats__suffix"><?= esc_html($suffix) ?></span>
          </div>
          <?php if ($label) : ?>
            <p class="sp-stats__label"><?= esc_html($label) ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<script>
(function () {
  function animateCount(el) {
    var card   = el.closest('.sp-stats__card');
    var target = parseInt(card.querySelector('[data-target]').dataset.target, 10);
    var count  = card.querySelector('.sp-stats__count');
    var start  = 0;
    var duration = 1600;
    var step = Math.ceil(target / (duration / 16));
    var timer = setInterval(function () {
      start += step;
      if (start >= target) { start = target; clearInterval(timer); }
      count.textContent = start.toLocaleString();
    }, 16);
  }

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        animateCount(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.sp-stats__card').forEach(function (card) {
    observer.observe(card);
  });
})();
</script>

<?php
/**
 * Precast — Manufacturing process: From Drawing to Delivery (Brief: Priority 8)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$eyebrow = $args['eyebrow'] ?: 'Manufacturing Process';
$heading = $args['heading'] ?: 'From Drawing to Delivery';
$subtext = $args['subtext'] ?: 'Eight controlled stages from technical review to site delivery.';
$bg      = ($args['bg'] ?? 'light') === 'dark' ? 'pc-process--dark' : '';

$rows = sp_pc_rows($args['steps'] ?? '');
$steps = [];
foreach ($rows as $r) if (!empty($r['title'])) $steps[] = ['title' => $r['title'], 'desc' => $r['desc'] ?? '', 'icon' => $r['icon'] ?? 'check'];
if (!$steps) {
    $steps = [
        ['title' => 'Technical Review',  'desc' => 'Review client drawings, BOQ and project requirements.',            'icon' => 'drawing'],
        ['title' => 'Mould Engineering', 'desc' => 'Prepare steel or project-specific moulds.',                        'icon' => 'mould'],
        ['title' => 'Reinforcement',     'desc' => 'Fabricate reinforcement cages according to approved design.',      'icon' => 'rebar'],
        ['title' => 'Casting',           'desc' => 'Concrete placement using controlled manufacturing procedures.',    'icon' => 'cast'],
        ['title' => 'Curing',            'desc' => 'Controlled curing before demoulding and handling.',                'icon' => 'curing'],
        ['title' => 'QA/QC',             'desc' => 'Check dimensions, concrete quality and finished product.',         'icon' => 'inspect'],
        ['title' => 'Lifting & Loading', 'desc' => 'Prepare heavy units for crane lifting and trailer loading.',       'icon' => 'crane'],
        ['title' => 'Delivery',          'desc' => 'Coordinate transportation according to project requirements.',    'icon' => 'truck'],
    ];
}
?>
<section class="pc-section pc-process <?php echo esc_attr($bg); ?>" id="process">
  <div class="container">
    <?php echo sp_section_head($eyebrow, $heading, $subtext, 'center'); ?>
    <ol class="pc-process__grid">
      <?php foreach ($steps as $i => $s) : ?>
      <li class="pc-step">
        <span class="pc-step__num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
        <span class="pc-step__icon"><?php echo sp_icon($s['icon'], 26); ?></span>
        <h3 class="pc-step__title"><?php echo esc_html($s['title']); ?></h3>
        <p><?php echo esc_html($s['desc']); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

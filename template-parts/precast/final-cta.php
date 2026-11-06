<?php
/**
 * Precast — Homepage final CTA (Brief: Priority 38)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$heading = $args['heading']    ?: 'Have a Precast Requirement?';
$sub     = $args['subheading'] ?: 'Send us your drawing, BOQ or technical specification';
$items   = sp_pc_lines($args['items'] ?? '') ?: ['Dimensions', 'Concrete Requirements', 'Reinforcement', 'Quantity', 'Mould Requirements', 'Production Requirements', 'Lifting', 'Transportation'];
$c = sp_company();
?>
<section class="pc-section pc-final" id="rfq">
  <div class="container">
    <div class="pc-final__inner">
      <div class="pc-final__text">
        <span class="pc-eyebrow pc-eyebrow--accent">Request a Quotation</span>
        <h2 class="pc-h2 pc-h2--light"><?php echo esc_html($heading); ?></h2>
        <p class="pc-final__sub"><?php echo esc_html($sub); ?></p>
        <p class="pc-final__lead">Our team can review:</p>
        <ul class="pc-final__list">
          <?php foreach ($items as $it) : ?><li><?php echo sp_icon('check', 15); ?><?php echo esc_html($it); ?></li><?php endforeach; ?>
        </ul>
        <?php echo sp_cta_buttons(['labels' => ['quote' => 'Request Quotation', 'drawing' => 'Upload Drawing', 'wa' => 'WhatsApp Our Team'], 'show' => ['drawing', 'quote', 'wa']]); ?>
      </div>
      <div class="pc-final__side">
        <div class="pc-final__card">
          <h3>Direct Contact</h3>
          <a href="tel:<?php echo esc_attr($c['phone_tel']); ?>"><?php echo sp_icon('phone', 18); ?><?php echo esc_html($c['phone']); ?></a>
          <a href="<?php echo esc_url(sp_wa_url()); ?>" target="_blank" rel="noopener"><?php echo sp_icon('whatsapp', 18); ?>WhatsApp +<?php echo esc_html($c['wa_digits']); ?></a>
          <a href="mailto:<?php echo esc_attr($c['email']); ?>"><?php echo sp_icon('mail', 18); ?><?php echo esc_html($c['email']); ?></a>
          <span><?php echo sp_icon('clock', 18); ?><?php echo esc_html($c['hours']); ?></span>
          <p class="pc-final__formats">Accepted: PDF • DWG • DXF • Excel • Word • JPG • PNG • ZIP</p>
        </div>
      </div>
    </div>
  </div>
</section>

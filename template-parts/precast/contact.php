<?php
/**
 * Precast — Contact page (Brief: Priority 19)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$c = sp_company();
$heading = $args['heading'] ?: 'Contact Precast Al Turab';
$desc    = $args['description'] ?: 'Share your drawing, BOQ or technical specification with our technical sales team. We quote heavy precast, barrier and utility packages clearly and quickly.';
$map = 'https://www.google.com/maps?q=' . rawurlencode($c['map_query']) . '&output=embed';
?>
<section class="pc-section pc-contact">
  <div class="container">
    <div class="pc-contact__grid">
      <div class="pc-contact__info">
        <?php echo sp_section_head('Get in touch', $heading, $desc); ?>
        <ul class="pc-contact__list">
          <li><span class="pc-contact__ic"><?php echo sp_icon('factory', 20); ?></span><div><strong>Company</strong><span><?php echo esc_html($c['name']); ?><br><small><?php echo esc_html($c['legal']); ?></small></span></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('phone', 20); ?></span><div><strong>Phone</strong><a href="tel:<?php echo esc_attr($c['phone_tel']); ?>"><?php echo esc_html($c['phone']); ?></a></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('whatsapp', 20); ?></span><div><strong>WhatsApp</strong><a href="<?php echo esc_url(sp_wa_url()); ?>" target="_blank" rel="noopener">+<?php echo esc_html($c['wa_digits']); ?></a></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('mail', 20); ?></span><div><strong>Email</strong><a href="mailto:<?php echo esc_attr($c['email']); ?>"><?php echo esc_html($c['email']); ?></a></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('pin', 20); ?></span><div><strong>Office</strong><span><?php echo esc_html($c['address']); ?></span></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('heavy', 20); ?></span><div><strong>Factory</strong><span><?php echo esc_html($c['factory']); ?></span></div></li>
          <li><span class="pc-contact__ic"><?php echo sp_icon('clock', 20); ?></span><div><strong>Business Hours</strong><span><?php echo esc_html($c['hours']); ?></span></div></li>
        </ul>
        <?php echo sp_cta_buttons(['labels' => ['quote' => 'Request Quotation', 'drawing' => 'Send Drawing', 'wa' => 'WhatsApp']]); ?>
        <div class="pc-contact__map">
          <iframe src="<?php echo esc_url($map); ?>" width="100%" height="300" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Precast Al Turab location map"></iframe>
        </div>
      </div>
      <div class="pc-contact__form">
        <?php echo sp_rfq_form_html(['heading' => 'Send Us Your Requirement', 'subtext' => 'Fill in the form and our team will respond within one business day.', 'compact' => true]); ?>
      </div>
    </div>
  </div>
</section>

<?php
/**
 * Precast — Contact page, laid out like the reference site (precastuae.ae/contact/):
 * left card  = Office / Factory map tabs, locations + hours, badges, "Talk to our team"
 * right card = "Request a Project Quote" form
 * band below = Office · Production · Compliance · Coverage
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$c = sp_company();
$office_map  = 'https://maps.google.com/maps?q=' . rawurlencode('MAZYAD Offices 2, Mohamed Bin Zayed City, Abu Dhabi') . '&z=14&output=embed';
$factory_map = 'https://maps.google.com/maps?q=' . rawurlencode('Sharjah Industrial Area, Sharjah') . '&z=13&output=embed';
$insights = [
    ['Office',     'Abu Dhabi Office',     'Our Abu Dhabi office in Mohamed Bin Zayed City supports quotations, submittals, and project follow-up for consultants, contractors, and procurement teams.', 'pin'],
    ['Production', 'Factory Output',       'Production is set up for repeat runs, bulk orders, and phased call-offs, with factory QA and delivery planning aligned to active project schedules.', 'factory'],
    ['Compliance', 'Approvals & Systems',  'Project documentation is prepared around RTA, DM, and ADM requirements together with ISO 9001 and ISO 45001 management-system controls.', 'qa'],
    ['Coverage',   'Service Areas',        'We support Abu Dhabi, Dubai, Al Ain, Sharjah, Ajman, and other UAE project locations, including planned deliveries for remote and phased sites.', 'truck'],
];
?>
<section class="pc-section pc-quote">
  <div class="container">
    <div class="pc-quote__grid">

      <div class="pc-quote__card pc-quote__card--left">
        <div class="pc-quote__maps" data-map-tabs>
          <div class="pc-quote__tabs" role="tablist" aria-label="Location view options">
            <button type="button" role="tab" class="is-active" aria-selected="true" data-src="<?php echo esc_url($office_map); ?>">Abu Dhabi Office</button>
            <button type="button" role="tab" aria-selected="false" data-src="<?php echo esc_url($factory_map); ?>">Sharjah Factory</button>
          </div>
          <iframe src="<?php echo esc_url($office_map); ?>" width="100%" height="240" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Precast Al Turab location map"></iframe>
        </div>

        <div class="pc-quote__locs">
          <div>
            <h4><?php echo sp_icon('pin', 16); ?> Abu Dhabi Office</h4>
            <p>MAZYAD Offices 2, Mohamed Bin Zayed City, Abu Dhabi 20614</p>
            <p class="pc-quote__hours"><?php echo sp_icon('clock', 14); ?> Hours: Mon–Fri 8:00 AM – 5:30 PM</p>
          </div>
          <div>
            <h4><?php echo sp_icon('factory', 16); ?> Sharjah Factory</h4>
            <p>Sharjah Industrial Area, Sharjah</p>
            <p class="pc-quote__hours"><?php echo sp_icon('clock', 14); ?> Hours: Mon–Sat 7:00 AM – 6:00 PM</p>
          </div>
        </div>

        <ul class="pc-quote__badges">
          <li><?php echo sp_icon('clock', 18); ?><strong>24h Quote</strong><span>Fast Response</span></li>
          <li><?php echo sp_icon('truck', 18); ?><strong>UAE Delivery</strong><span>Nationwide</span></li>
          <li><?php echo sp_icon('factory', 18); ?><strong>Factory Direct</strong><span>Best Value</span></li>
        </ul>

        <div class="pc-quote__team">
          <h3>Talk to Our Team</h3>
          <p>We're here to help with your project</p>
          <a class="pc-quote__line" href="tel:<?php echo esc_attr($c['phone_tel']); ?>" data-track="phone_click"><span class="pc-quote__ic"><?php echo sp_icon('phone', 18); ?></span><span><small>Call Us</small><?php echo esc_html($c['phone']); ?></span></a>
          <a class="pc-quote__line pc-quote__line--wa" href="<?php echo esc_url(sp_wa_url()); ?>" target="_blank" rel="noopener" data-track="whatsapp_click"><span class="pc-quote__ic"><?php echo sp_icon('whatsapp', 18); ?></span><span><small>WhatsApp</small>Chat on WhatsApp</span></a>
          <a class="pc-quote__line" href="mailto:<?php echo esc_attr($c['email']); ?>" data-track="email_click"><span class="pc-quote__ic"><?php echo sp_icon('mail', 18); ?></span><span><small>Email Us</small><?php echo esc_html($c['email']); ?></span></a>
        </div>
      </div>

      <div class="pc-quote__card pc-quote__card--form">
        <?php echo sp_rfq_form_html(['heading' => 'Request a Project Quote', 'subtext' => "Share your requirements and we'll get back to you within 24 hours."]); ?>
      </div>

    </div>
  </div>
</section>

<section class="pc-section pc-insights">
  <div class="container">
    <div class="pc-insights__grid">
      <?php foreach ($insights as [$tag, $title, $text, $icon]) : ?>
      <div class="pc-insights__item">
        <span class="pc-insights__ic"><?php echo sp_icon($icon, 22); ?></span>
        <span class="pc-insights__tag"><?php echo esc_html($tag); ?></span>
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo esc_html($text); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="pc-insights__legal"><?php echo esc_html($c['address']); ?> · <?php echo esc_html($c['legal']); ?></p>
  </div>
</section>
<script>
(function(){var w=document.querySelector('[data-map-tabs]');if(!w)return;var f=w.querySelector('iframe'),b=[].slice.call(w.querySelectorAll('[data-src]'));b.forEach(function(x){x.addEventListener('click',function(){f.src=x.getAttribute('data-src');b.forEach(function(y){y.classList.toggle('is-active',y===x);y.setAttribute('aria-selected',y===x?'true':'false');});});});})();
</script>

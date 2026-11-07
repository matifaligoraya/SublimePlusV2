<?php
/**
 * Site footer — Precast Al Turab (Brief: Priority 30)
 *
 * PRECAST AL TURAB · PRODUCTS · COMPANY · CONTACT · quick RFQ button,
 * plus Privacy / Terms / Copyright.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$c       = sp_company();
$logo_id = get_theme_mod('custom_logo');
$logo    = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';

$product_links = [
    ['Precast Bunkers',   'precast-bunker'],
    ['T-Walls',           't-wall'],
    ['Concrete Barriers', 'jersey-barrier'],
    ['Box Culverts',      'box-culvert'],
    ['U-Channels',        'u-channel'],
    ['Manholes',          'manhole'],
    ['Custom Precast',    'custom-precast'],
];
$company_links = [
    ['About Us',            sp_page_url('about-us', '/about-us/')],
    ['Products',            get_post_type_archive_link('sp_product') ?: home_url('/products/')],
    ['Projects',            get_post_type_archive_link('sp_project') ?: home_url('/projects/')],
    ['Capabilities',        sp_page_url('capabilities', '/capabilities/')],
    ['Technical Resources', sp_page_url('technical-resources', '/technical-resources/')],
    ['Request Quotation',   sp_rfq_url()],
    ['Contact',             sp_page_url('contact-us', '/contact-us/')],
];
$privacy = get_privacy_policy_url() ?: sp_page_url('privacy-policy', '/privacy-policy/');
$terms   = sp_page_url('terms-and-conditions', '/terms-and-conditions/');
?>

<footer id="footer" class="pc-foot" role="contentinfo">
  <div class="container">
    <div class="pc-foot__grid">

      <div class="pc-foot__brand">
        <?php if ($logo) : ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="pc-foot__logo"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" height="48" loading="lazy"></a>
        <?php endif; ?>
        <strong class="pc-foot__name notranslate" translate="no">PRECAST AL TURAB</strong>
        <p class="pc-foot__tag">UAE Precast Concrete Manufacturing</p>
        <a href="<?php echo esc_url(sp_profile_url()); ?>" class="pc-link pc-link--light" data-track="profile_download"><?php echo sp_icon('download', 16); ?> Download Company Profile</a>
        <?php if ($c['linkedin'] || $c['instagram'] || $c['facebook']) : ?>
        <div class="pc-foot__social">
          <?php if ($c['linkedin']) : ?><a href="<?php echo esc_url($c['linkedin']); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg></a><?php endif; ?>
          <?php if ($c['instagram']) : ?><a href="<?php echo esc_url($c['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg></a><?php endif; ?>
          <?php if ($c['facebook']) : ?><a href="<?php echo esc_url($c['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a><?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="pc-foot__col">
        <h4>Products</h4>
        <ul>
          <?php foreach ($product_links as [$label, $slug]) :
            $p = sp_pc_product_by_slug($slug);
            $u = $p ? get_permalink($p) : (get_post_type_archive_link('sp_product') ?: home_url('/products/'));
          ?>
          <li><a href="<?php echo esc_url($u); ?>"><?php echo esc_html($label); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="pc-foot__col">
        <h4>Company</h4>
        <ul>
          <?php foreach ($company_links as [$label, $u]) : ?>
          <li><a href="<?php echo esc_url($u); ?>"><?php echo esc_html($label); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="pc-foot__col pc-foot__contact">
        <h4>Contact</h4>
        <ul>
          <li><?php echo sp_icon('phone', 16); ?><a href="tel:<?php echo esc_attr($c['phone_tel']); ?>"><?php echo esc_html($c['phone']); ?></a></li>
          <li><?php echo sp_icon('whatsapp', 16); ?><a href="<?php echo esc_url(sp_wa_url()); ?>" target="_blank" rel="noopener">WhatsApp +<?php echo esc_html($c['wa_digits']); ?></a></li>
          <li><?php echo sp_icon('mail', 16); ?><a href="mailto:<?php echo esc_attr($c['email']); ?>"><?php echo esc_html($c['email']); ?></a></li>
          <li><?php echo sp_icon('pin', 16); ?><span><small class="pc-foot__lbl">Office</small><?php echo esc_html($c['address']); ?></span></li>
          <li><?php echo sp_icon('factory', 16); ?><span><small class="pc-foot__lbl">Factory</small><?php echo esc_html($c['factory']); ?><br><a class="pc-foot__map" href="<?php echo esc_url($c['factory_map_url']); ?>" target="_blank" rel="noopener" data-track="map_click">View on Google Maps &rarr;</a></span></li>
          <li><?php echo sp_icon('clock', 16); ?><span><?php echo esc_html($c['hours']); ?></span></li>
        </ul>
        <a href="<?php echo esc_url(sp_rfq_url()); ?>" class="pc-btn pc-btn--accent pc-foot__rfq" data-track="rfq_click"><?php echo sp_icon('quote', 16); ?> Request Quotation</a>
      </div>

    </div>
  </div>

  <div class="pc-foot__bottom">
    <div class="container">
      <span>&copy; <?php echo esc_html(date_i18n('Y')); ?> Precast Al Turab — <?php echo esc_html($c['legal']); ?>. All rights reserved.</span>
      <nav aria-label="Legal">
        <a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a>
        <a href="<?php echo esc_url($terms); ?>">Terms &amp; Conditions</a>
      </nav>
    </div>
  </div>
</footer>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>

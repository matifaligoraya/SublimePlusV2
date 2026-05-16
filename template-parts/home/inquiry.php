<?php
/**
 * Homepage — Project Inquiry / Contact section
 * Renders: left info panel + right Formidable Pro form card
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args = $args ?? [];

$phone    = $args['phone']    ?? get_theme_mod('sp_footer_phone',    '+971 54 350 7724');
$email    = $args['email']    ?? get_theme_mod('sp_footer_email',    'info@precastalturab.ae');
$address  = $args['address']  ?? get_theme_mod('sp_footer_address',  '75, Sultan Bin Mohammed Al Qubaisi St, Mohamed Bin Zayed City, Abu Dhabi 20614');
$whatsapp = $args['whatsapp'] ?? get_theme_mod('sp_footer_whatsapp', 'https://wa.me/971543507724');
$linkedin = get_theme_mod('sp_footer_linkedin',  'https://www.linkedin.com/company/precastuae');
$instagram= get_theme_mod('sp_footer_instagram', 'https://www.instagram.com/precast_uae');
$facebook = get_theme_mod('sp_footer_facebook',  'https://www.facebook.com/precastuae');
$form_sc  = $args['form_sc']  ?? get_theme_mod('sp_footer_form_shortcode', '[formidable id=1]');
?>
<section class="sp-inquiry" id="inquiry">
  <div class="container">
  <div class="sp-inquiry__inner">

    <!-- ── Left: info panel ─────────────────────────────────────────────────── -->
    <div class="sp-inquiry__info">

      <span class="sp-inquiry__eyebrow"><?php _e('GET IN TOUCH', 'sublimeplus'); ?></span>
      <h2 class="sp-inquiry__heading"><?php _e('Request a Project Quote', 'sublimeplus'); ?></h2>
      <p class="sp-inquiry__desc"><?php _e('Tell us about your project — our team responds within 24 hours with a detailed quote, material specs, and delivery schedule.', 'sublimeplus'); ?></p>

      <!-- Trust signals -->
      <ul class="sp-inquiry__trust">
        <li>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <?php _e('24-hour response guarantee', 'sublimeplus'); ?>
        </li>
        <li>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <?php _e('Free consultation &amp; detailed quote', 'sublimeplus'); ?>
        </li>
        <li>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <?php _e('UAE-wide delivery — all seven emirates', 'sublimeplus'); ?>
        </li>
        <li>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <?php _e('RTA approved &amp; ISO 9001 certified', 'sublimeplus'); ?>
        </li>
      </ul>

      <!-- Contact details -->
      <ul class="sp-inquiry__contacts">
        <?php if ($phone) : ?>
        <li>
          <span class="sp-inquiry__icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.82 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 3.12 4.18 2 2 0 0 1 5.09 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </span>
          <div>
            <span class="sp-inquiry__contact-label"><?php _e('Phone', 'sublimeplus'); ?></span>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
          </div>
        </li>
        <?php endif; ?>
        <?php if ($email) : ?>
        <li>
          <span class="sp-inquiry__icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </span>
          <div>
            <span class="sp-inquiry__contact-label"><?php _e('Email', 'sublimeplus'); ?></span>
            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
          </div>
        </li>
        <?php endif; ?>
        <?php if ($whatsapp) : ?>
        <li>
          <span class="sp-inquiry__icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
          </span>
          <div>
            <span class="sp-inquiry__contact-label">WhatsApp</span>
            <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener"><?php _e('Chat Now', 'sublimeplus'); ?></a>
          </div>
        </li>
        <?php endif; ?>
        <?php if ($address) : ?>
        <li>
          <span class="sp-inquiry__icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          </span>
          <div>
            <span class="sp-inquiry__contact-label"><?php _e('Address', 'sublimeplus'); ?></span>
            <span><?php echo esc_html($address); ?></span>
          </div>
        </li>
        <?php endif; ?>
      </ul>

      <!-- Social -->
      <div class="sp-inquiry__social">
        <?php if ($linkedin) : ?>
        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
        </a>
        <?php endif; ?>
        <?php if ($instagram) : ?>
        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
        </a>
        <?php endif; ?>
        <?php if ($facebook) : ?>
        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <?php endif; ?>
      </div>

    </div><!-- /.sp-inquiry__info -->

    <!-- ── Right: form card ──────────────────────────────────────────────────── -->
    <div class="sp-inquiry__form-wrap">
      <div class="sp-inquiry__form-card">
        <div class="sp-inquiry__form-card-header">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          <div>
            <h3><?php _e('Send Us Your Requirements', 'sublimeplus'); ?></h3>
            <p><?php _e('We\'ll prepare a detailed quote within 24 hours.', 'sublimeplus'); ?></p>
          </div>
        </div>
        <div class="sp-inquiry__form-body">
          <?php echo do_shortcode($form_sc); ?>
        </div>
      </div>
    </div>

  </div><!-- /.sp-inquiry__inner -->
  </div><!-- /.container -->
</section>

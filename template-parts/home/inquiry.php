<?php
/**
 * Homepage — Project Inquiry + Request a Quote
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$args = $args ?? [];

$info_heading = $args['info_heading'] ?? get_theme_mod('sp_inquiry_info_heading', 'Project Inquiry');
$info_text    = $args['info_text']    ?? get_theme_mod('sp_inquiry_info_text', "Tell us about your project and we'll get back to you with a detailed quote, material specs, and delivery timeline.");
$phone        = $args['phone']        ?? get_theme_mod('sp_inquiry_phone',   '+971 54 350 7724');
$email        = $args['email']        ?? get_theme_mod('sp_inquiry_email',   'info@precastalturab.ae');
$address      = $args['address']      ?? get_theme_mod('sp_inquiry_address', '75, Sultan Bin Mohammed Al Qubaisi St, Mohamed Bin Zayed City, Abu Dhabi 20614');
$whatsapp     = $args['whatsapp']     ?? get_theme_mod('sp_inquiry_whatsapp', 'https://wa.me/971543507724');

$form_heading = $args['form_heading'] ?? get_theme_mod('sp_inquiry_form_heading', 'Request a Project Quote');

$nonce = wp_create_nonce('sp_inquiry_nonce');
?>
<section class="inquiry-section" id="inquiry">
  <div class="container">
    <div class="inquiry-grid">

      <!-- Contact info panel -->
      <div class="inquiry-info">
        <h2><?php echo esc_html($info_heading); ?></h2>
        <p><?php echo esc_html($info_text); ?></p>

        <div class="inquiry-contacts">
          <?php if ($phone) : ?>
          <div class="inquiry-contact-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.82 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 3.12 4.18 2 2 0 0 1 5.09 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
          </div>
          <?php endif; ?>

          <?php if ($email) : ?>
          <div class="inquiry-contact-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
          </div>
          <?php endif; ?>

          <?php if ($whatsapp) : ?>
          <div class="inquiry-contact-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">WhatsApp</a>
          </div>
          <?php endif; ?>

          <?php if ($address) : ?>
          <div class="inquiry-contact-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><?php echo esc_html($address); ?></span>
          </div>
          <?php endif; ?>
        </div>

        <div class="inquiry-social">
          <a href="https://www.linkedin.com/company/precastuae" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="https://www.instagram.com/precast_uae" target="_blank" rel="noopener" aria-label="Instagram">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
          </a>
          <a href="https://www.facebook.com/precastuae" target="_blank" rel="noopener" aria-label="Facebook">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
        </div>
      </div>

      <!-- Quote form panel -->
      <div class="inquiry-form-panel">
        <h3><?php echo esc_html($form_heading); ?></h3>
        <form class="inquiry-form" id="sp-inquiry-form" novalidate>
          <?php wp_nonce_field('sp_inquiry_nonce', 'sp_nonce'); ?>

          <div class="form-row">
            <input type="text"  name="company"  placeholder="<?php esc_attr_e('Company Name', 'sublimeplus'); ?>" required>
            <input type="text"  name="contact"  placeholder="<?php esc_attr_e('Contact Name', 'sublimeplus'); ?>" required>
          </div>
          <div class="form-row">
            <input type="email" name="email"    placeholder="<?php esc_attr_e('Email Address', 'sublimeplus'); ?>" required>
            <input type="tel"   name="phone_no" placeholder="<?php esc_attr_e('Phone Number', 'sublimeplus'); ?>">
          </div>
          <div class="form-row">
            <select name="emirate">
              <option value=""><?php esc_html_e('Project Location', 'sublimeplus'); ?></option>
              <?php foreach (['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah', 'Western Region', 'Other'] as $em) : ?>
              <option value="<?php echo esc_attr($em); ?>"><?php echo esc_html($em); ?></option>
              <?php endforeach; ?>
            </select>
            <select name="product">
              <option value=""><?php esc_html_e('Product Type', 'sublimeplus'); ?></option>
              <?php foreach (['Jersey Barriers', 'Bunker / Box Culvert Systems', 'Wheel Stoppers', 'Masonry Blocks', 'Hoarding Blocks', 'Water-Filled Barriers', 'Multiple / Mixed Order', 'Other'] as $p) : ?>
              <option value="<?php echo esc_attr($p); ?>"><?php echo esc_html($p); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <textarea name="message" placeholder="<?php esc_attr_e('Project requirements, quantities, delivery timeline…', 'sublimeplus'); ?>" rows="4"></textarea>
          <button type="submit" class="inquiry-submit">
            <?php esc_html_e('Submit Quote Request', 'sublimeplus'); ?>
          </button>
          <div class="inquiry-notice" id="sp-inquiry-notice" hidden></div>
        </form>
      </div>

    </div>
  </div>
</section>

<script>
(function () {
  var form   = document.getElementById('sp-inquiry-form');
  var notice = document.getElementById('sp-inquiry-notice');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var btn = form.querySelector('.inquiry-submit');
    btn.disabled = true;
    btn.textContent = '<?php echo esc_js(__('Sending…', 'sublimeplus')); ?>';

    var data = new FormData(form);
    data.append('action', 'sp_inquiry_submit');

    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
      method: 'POST',
      credentials: 'same-origin',
      body: data,
    })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        notice.hidden = false;
        if (res.success) {
          notice.className = 'inquiry-notice inquiry-notice--success';
          notice.textContent = res.data;
          form.reset();
        } else {
          notice.className = 'inquiry-notice inquiry-notice--error';
          notice.textContent = res.data || '<?php echo esc_js(__('Something went wrong. Please try again.', 'sublimeplus')); ?>';
        }
      })
      .catch(function () {
        notice.hidden = false;
        notice.className = 'inquiry-notice inquiry-notice--error';
        notice.textContent = '<?php echo esc_js(__('Network error. Please try again.', 'sublimeplus')); ?>';
      })
      .finally(function () {
        btn.disabled = false;
        btn.textContent = '<?php echo esc_js(__('Submit Quote Request', 'sublimeplus')); ?>';
      });
  });
})();
</script>

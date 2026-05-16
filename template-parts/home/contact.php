<?php
/**
 * Contact page section — two-column layout
 * Left: contact details  |  Right: Formidable quote form card
 *
 * @package SublimePlusV2
 * @var array $args  Passed from sublime_contact shortcode via _sublime_render_part()
 */
defined('ABSPATH') || exit;

$heading       = $args['heading']       ?? 'CONTACT';
$description   = $args['description']   ?? '';
$phone         = $args['phone']         ?? '';
$phone_label   = $args['phone_label']   ?? 'Sales Department';
$email_sales   = $args['email_sales']   ?? '';
$email_general = $args['email_general'] ?? '';
$whatsapp      = $args['whatsapp']      ?? '';
$address       = $args['address']       ?? '';
$trade_name    = $args['trade_name']    ?? '';
$form_id       = (int) ($args['form_id'] ?? 3);
$form_heading  = $args['form_heading']  ?? 'Request a Project Quote';
$form_subtext  = $args['form_subtext']  ?? 'Fill in the form and our team will respond within 24 hours.';

$phone_clean = preg_replace('/[^+\d]/', '', $phone);
?>
<section class="sp-contact-pg">
  <div class="container">
    <div class="sp-contact-pg__inner">

      <!-- ── Left: contact info ── -->
      <div class="sp-contact-pg__info">

        <h1 class="sp-contact-pg__heading"><?= esc_html($heading) ?></h1>

        <?php if ($description) : ?>
          <p class="sp-contact-pg__desc"><?= esc_html($description) ?></p>
        <?php endif; ?>

        <?php if ($address) : ?>
          <div class="sp-contact-pg__block">
            <p class="sp-contact-pg__label">Office Location</p>
            <div class="sp-contact-pg__value">
              <?= nl2br(esc_html($address)) ?>
              <?php if ($trade_name) : ?>
                <span class="sp-contact-pg__trade"><?= esc_html($trade_name) ?></span>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($phone) : ?>
          <div class="sp-contact-pg__block">
            <p class="sp-contact-pg__label"><?= esc_html($phone_label) ?></p>
            <a class="sp-contact-pg__value sp-contact-pg__value--bold"
               href="tel:<?= esc_attr($phone_clean) ?>"><?= esc_html($phone) ?></a>
          </div>
        <?php endif; ?>

        <?php if ($email_sales) : ?>
          <div class="sp-contact-pg__block">
            <p class="sp-contact-pg__label">Sales Email</p>
            <a class="sp-contact-pg__value sp-contact-pg__value--bold"
               href="mailto:<?= esc_attr($email_sales) ?>"><?= esc_html($email_sales) ?></a>
          </div>
        <?php endif; ?>

        <?php if ($email_general) : ?>
          <div class="sp-contact-pg__block">
            <p class="sp-contact-pg__label">General Inquiries</p>
            <a class="sp-contact-pg__value sp-contact-pg__value--bold"
               href="mailto:<?= esc_attr($email_general) ?>"><?= esc_html($email_general) ?></a>
          </div>
        <?php endif; ?>

        <div class="sp-contact-pg__actions">
          <?php if ($phone) : ?>
            <a href="tel:<?= esc_attr($phone_clean) ?>" class="sp-contact-pg__btn sp-contact-pg__btn--call">
              <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 13.5a19.79 19.79 0 01-3.07-8.72A2 2 0 012 2.84h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 10.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              <?= esc_html__('Call', 'sublimeplus') ?>
            </a>
          <?php endif; ?>

          <?php if ($whatsapp) : ?>
            <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer"
               class="sp-contact-pg__btn sp-contact-pg__btn--wa">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              <?= esc_html__('WhatsApp', 'sublimeplus') ?>
            </a>
          <?php endif; ?>

          <?php $email_action = $email_sales ?: $email_general; ?>
          <?php if ($email_action) : ?>
            <a href="mailto:<?= esc_attr($email_action) ?>" class="sp-contact-pg__btn sp-contact-pg__btn--email">
              <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
              <?= esc_html__('Email', 'sublimeplus') ?>
            </a>
          <?php endif; ?>
        </div>

      </div><!-- /.sp-contact-pg__info -->

      <!-- ── Right: form card ── -->
      <div class="sp-contact-pg__form-wrap">
        <div class="sp-contact-pg__card">

          <div class="sp-contact-pg__card-hdr">
            <h2><?= esc_html($form_heading) ?></h2>
            <?php if ($form_subtext) : ?>
              <p><?= esc_html($form_subtext) ?></p>
            <?php endif; ?>
          </div>

          <div class="sp-contact-pg__card-body">
            <?= do_shortcode('[formidable id=' . $form_id . ']') ?>
          </div>

        </div>
      </div><!-- /.sp-contact-pg__form-wrap -->

    </div><!-- /.sp-contact-pg__inner -->
  </div>
</section>

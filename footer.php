<?php
/**
 * Site footer — SublimePlusV2
 *
 * Structure:
 *  1. Footer Builder page (if selected in Customizer → Footer → Builder)
 *     OR default layout:
 *       a. Contact + Formidable form strip
 *       b. Brand / links / certifications columns (widget-editable)
 *  2. Copyright bar (always)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

// ── Customizer values ─────────────────────────────────────────────────────────
$sp_linkedin  = get_theme_mod('sp_footer_linkedin',  'https://www.linkedin.com/company/precastuae');
$sp_instagram = get_theme_mod('sp_footer_instagram', 'https://www.instagram.com/precast_uae');
$sp_facebook  = get_theme_mod('sp_footer_facebook',  'https://www.facebook.com/precastuae');
$sp_tagline   = get_theme_mod('sp_footer_tagline',   'UAE\'s trusted source for RTA-approved precast concrete barriers, blocks, and bespoke structural systems.');
$sp_copyright = get_theme_mod('sp_footer_copyright', '');
$sp_page_id   = (int) get_theme_mod('sp_footer_page_id', 0);

$copy_text = $sp_copyright ?: ('&copy; ' . date_i18n('Y') . ' ' . esc_html(get_bloginfo('name')) . '. All rights reserved.');

do_action('bootscore_before_footer');
?>

<footer id="footer" class="sp-footer" role="contentinfo">

<?php
// ── Footer Builder mode ───────────────────────────────────────────────────────
$use_builder = false;
if ($sp_page_id) {
    $fp = get_post($sp_page_id);
    if ($fp && $fp->post_status === 'publish') {
        $use_builder = true;
        echo '<div class="sp-footer__builder">';
        echo do_shortcode(apply_filters('the_content', $fp->post_content));
        echo '</div>';
    }
}

if (!$use_builder) :
?>

  <!-- ── Pre-footer: contact info + form (shared template) ───────────────── -->
  <?php echo do_shortcode('[sublime_inquiry]'); ?>

  <!-- ── Brand / Links columns ────────────────────────────────────────────── -->
  <div class="sp-footer__columns">
    <div class="container">
      <div class="sp-footer__cols-grid">

        <!-- Col 1: Brand + social -->
        <div class="sp-footer__col sp-footer__col--brand">
          <?php if (is_active_sidebar('sp-footer-col-1')) : ?>
            <?php dynamic_sidebar('sp-footer-col-1'); ?>
          <?php else : ?>
            <?php
            $logo_id  = get_theme_mod('custom_logo');
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
            ?>
            <?php if ($logo_url) : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="sp-footer__logo">
              <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" height="40">
            </a>
            <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="sp-footer__site-name">
              <?php echo esc_html(get_bloginfo('name')); ?>
            </a>
            <?php endif; ?>
            <?php if ($sp_tagline) : ?>
            <p class="sp-footer__tagline"><?php echo esc_html($sp_tagline); ?></p>
            <?php endif; ?>
            <div class="sp-footer__trust-badges">
              <span class="sp-footer__badge">RTA Approved</span>
              <span class="sp-footer__badge">ISO 9001</span>
              <span class="sp-footer__badge">ICV Certified</span>
              <span class="sp-footer__badge">ESMA</span>
            </div>
            <div class="sp-footer__social">
              <?php if ($sp_linkedin) : ?>
              <a href="<?php echo esc_url($sp_linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
              <?php endif; ?>
              <?php if ($sp_instagram) : ?>
              <a href="<?php echo esc_url($sp_instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
              </a>
              <?php endif; ?>
              <?php if ($sp_facebook) : ?>
              <a href="<?php echo esc_url($sp_facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Col 2: Products -->
        <div class="sp-footer__col">
          <?php if (is_active_sidebar('sp-footer-col-2')) : ?>
            <?php dynamic_sidebar('sp-footer-col-2'); ?>
          <?php else : ?>
            <h4 class="sp-footer__col-heading"><?php _e('Our Products', 'sublimeplus'); ?></h4>
            <ul class="sp-footer__links">
              <li><a href="<?php echo esc_url(get_post_type_archive_link('sp_product') ?: home_url('/products/')); ?>"><?php _e('All Products', 'sublimeplus'); ?></a></li>
              <?php
              $prod_cats = get_terms(['taxonomy' => 'sp_product_cat', 'hide_empty' => true, 'number' => 6]);
              if ($prod_cats && !is_wp_error($prod_cats)) {
                  foreach ($prod_cats as $pc) {
                      echo '<li><a href="' . esc_url(get_term_link($pc)) . '">' . esc_html($pc->name) . '</a></li>';
                  }
              }
              ?>
            </ul>
          <?php endif; ?>
        </div>

        <!-- Col 3: Company -->
        <div class="sp-footer__col">
          <?php if (is_active_sidebar('sp-footer-col-3')) : ?>
            <?php dynamic_sidebar('sp-footer-col-3'); ?>
          <?php else : ?>
            <h4 class="sp-footer__col-heading"><?php _e('Company', 'sublimeplus'); ?></h4>
            <ul class="sp-footer__links">
              <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'sublimeplus'); ?></a></li>
              <li><a href="<?php echo esc_url(get_post_type_archive_link('sp_project') ?: home_url('/projects/')); ?>"><?php _e('Projects', 'sublimeplus'); ?></a></li>
              <li><a href="<?php echo esc_url(get_post_type_archive_link('sp_product') ?: home_url('/products/')); ?>"><?php _e('Products', 'sublimeplus'); ?></a></li>
              <li><a href="<?php echo esc_url(home_url('/#logistics')); ?>"><?php _e('Supply Capability', 'sublimeplus'); ?></a></li>
              <li><a href="<?php echo esc_url(home_url('/#inquiry')); ?>"><?php _e('Get a Quote', 'sublimeplus'); ?></a></li>
            </ul>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

<?php endif; // end !use_builder ?>

  <!-- ── Copyright bar ───────────────────────────────────────────────────── -->
  <div class="sp-footer__bottom">
    <div class="container">
      <span class="sp-footer__copy"><?php echo wp_kses_post($copy_text); ?></span>
      <nav class="sp-footer__bottom-nav" aria-label="<?php esc_attr_e('Footer navigation', 'sublimeplus'); ?>">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer-menu',
            'container'      => false,
            'menu_class'     => 'sp-footer__bottom-links',
            'fallback_cb'    => '__return_false',
            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            'depth'          => 1,
        ]);
        ?>
      </nav>
    </div>
  </div>

</footer>

<!-- Back to top -->
<a href="#" class="sp-back-top" aria-label="<?php esc_attr_e('Back to top', 'sublimeplus'); ?>">
  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="18 15 12 9 6 15"/></svg>
</a>
<script>
(function(){
  var btn = document.querySelector('.sp-back-top');
  if (!btn) return;
  window.addEventListener('scroll', function(){ btn.classList.toggle('visible', window.scrollY > 400); }, {passive:true});
  btn.addEventListener('click', function(e){ e.preventDefault(); window.scrollTo({top:0, behavior:'smooth'}); });
})();
</script>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

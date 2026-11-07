<?php
/**
 * Precast Al Turab — site-wide behaviour: analytics + click tracking, quick
 * actions (floating WhatsApp, mobile bar), body classes, asset clean-up,
 * redirects. Hooks are registered in Precast::define_*_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_Site {

    /** Google Analytics 4 (only when an ID is configured). wp_head @3 */
    public function analytics() {
        $c = sp_company();
        if (!$c['ga_id']) return;
        $id = esc_js($c['ga_id']);
        echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$id}\"></script>\n";
        echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$id}');</script>\n";
    }

    /** Click tracking → gtag events (no-op without GA). wp_footer @99 */
    public function click_tracking() {
        ?>
<script>
(function(){
  function ev(n,p){ if(typeof gtag==='function'){ gtag('event',n,p||{}); } }
  document.addEventListener('click',function(e){
    var a=e.target.closest('a'); if(!a) return;
    var h=a.getAttribute('href')||''; var t=a.getAttribute('data-track');
    if(t){ ev(t,{link_url:h}); return; }
    if(h.indexOf('tel:')===0) ev('phone_click',{link_url:h});
    else if(h.indexOf('mailto:')===0) ev('email_click',{link_url:h});
    else if(h.indexOf('wa.me')>-1||h.indexOf('whatsapp')>-1) ev('whatsapp_click',{link_url:h});
    else if(/\.(pdf|dwg|dxf|zip|docx?|xlsx?)(\?|$)/i.test(h)) ev('file_download',{link_url:h,file_name:h.split('/').pop()});
  },true);
  window.spTrack=ev;
})();
</script>
        <?php
    }

    /** Floating WhatsApp (desktop) + fixed mobile bar: CALL | WHATSAPP | GET QUOTE. wp_footer @98 */
    public function quick_actions() {
        $c = sp_company();
        $wa = is_singular('sp_product') ? sp_wa_url_for_product(get_queried_object_id()) : sp_wa_url();
        ?>
<a href="<?php echo esc_url($wa); ?>" class="pc-wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" data-track="whatsapp_click">
  <?php echo sp_icon('whatsapp', 28); ?>
  <span>WhatsApp</span>
</a>
<nav class="pc-mbar" aria-label="Quick actions">
  <a href="tel:<?php echo esc_attr($c['phone_tel']); ?>" data-track="phone_click"><?php echo sp_icon('phone', 20); ?><span>Call</span></a>
  <a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener" class="pc-mbar__wa" data-track="whatsapp_click"><?php echo sp_icon('whatsapp', 20); ?><span>WhatsApp</span></a>
  <a href="<?php echo esc_url(sp_rfq_url(is_singular('sp_product') ? get_the_title() : '')); ?>" class="pc-mbar__quote" data-track="rfq_click"><?php echo sp_icon('quote', 20); ?><span>Get Quote</span></a>
</nav>
        <?php
    }

    /** body_class filter. */
    public function body_class($classes) {
        $classes[] = 'pc-site';
        if (is_front_page()) $classes[] = 'pc-home';
        return $classes;
    }

    /** Remove emoji, oEmbed discovery and generator tags. init */
    public function cleanup_head() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
    }

    /** Dequeue legacy / unused assets. wp_enqueue_scripts @1000 */
    public function dequeue_unused_assets() {
        // The old product-showcase hero needed model-viewer; the new hero loads it itself.
        wp_dequeue_script('model-viewer');
        wp_deregister_script('model-viewer');
        // jQuery Migrate is not needed by any theme script.
        wp_dequeue_script('jquery-migrate-js');
        wp_dequeue_script('jquery-migrate');
        // Legacy "wave" main.js calls WOW(), which is never loaded, so it only throws an error.
        wp_dequeue_script('main');
        // Unused legacy vendor scripts whose files are missing.
        foreach (['defer-js', 'sublimeplus-scripts'] as $h) {
            $src = wp_scripts()->registered[$h]->src ?? '';
            if ($src && !file_exists(str_replace(SUBLIMEPLUS_URI, SUBLIMEPLUS_DIR, $src))) {
                wp_dequeue_script($h);
            }
        }
        // Clever icon font stylesheet is referenced by the old framework but not shipped (404).
        if (!file_exists(SUBLIMEPLUS_DIR . 'assets/vendor/cleverfont/style.min.css')) {
            wp_dequeue_style('clever-font');
        }
        // Montserrat is loaded by the old Customizer typography but no element uses it.
        wp_dequeue_style('Montserrat-font');
        // Formidable's stylesheet is only needed where a [formidable] form is on the page.
        $post = get_queried_object();
        $has_frm = ($post instanceof WP_Post) && has_shortcode($post->post_content, 'formidable');
        if (!$has_frm) wp_dequeue_style('formidable');
    }

    /** Projects taken off the site (drafted) → 301 to the portfolio. template_redirect @1 */
    public function redirect_unpublished_projects() {
        if (!is_404()) return;
        $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        if (!preg_match('#^projects/([a-z0-9-]+)$#', $path, $m)) return;
        $p = get_page_by_path($m[1], OBJECT, 'sp_project');
        if ($p && $p->post_status !== 'publish') {
            wp_safe_redirect(get_post_type_archive_link('sp_project'), 301);
            exit;
        }
    }

    /** Drop jQuery Migrate on the front end. wp_default_scripts */
    public function drop_jquery_migrate($scripts) {
        if (is_admin() || empty($scripts->registered['jquery'])) return;
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }

    /** Add defer to non-critical scripts. script_loader_tag (2 args) */
    public function defer_scripts($tag, $handle) {
        if (is_admin()) return $tag;
        $defer = ['bootstrap', 'bootscore-theme', 'wpb_composer_front_js', 'vc_woocommerce-add-to-cart-js'];
        if (in_array($handle, $defer, true) && strpos($tag, 'defer') === false) {
            $tag = str_replace(' src=', ' defer src=', $tag);
        }
        return $tag;
    }

    /** New JPEG/PNG uploads generate WebP sub-sizes. image_editor_output_format */
    public function webp_output_format($formats) {
        $formats['image/jpeg'] = 'image/webp';
        $formats['image/png']  = 'image/webp';
        return $formats;
    }

    /** Hide the old pre-footer inquiry strip where the new CTA lives. sp_show_footer_inquiry */
    public function hide_footer_inquiry($show) {
        if (is_front_page() || is_page(['request-quotation', 'contact-us', 'contact'])) return false;
        return $show;
    }

    /** 404 pages always return a 404 status. template_redirect */
    public function send_404_status() {
        if (is_404()) status_header(404);
    }

    /** Front-end script for the RFQ form, language switch and header. wp_enqueue_scripts @20 */
    public function enqueue_scripts() {
        $file = get_template_directory() . '/assets/js/precast.js';
        if (!file_exists($file)) return;
        wp_enqueue_script('precast', get_template_directory_uri() . '/assets/js/precast.js', [], date('YmdHi', filemtime($file)), true);
        wp_localize_script('precast', 'spRfq', ['ajax' => admin_url('admin-ajax.php'), 'maxBytes' => sp_rfq_max_bytes()]);
    }
}

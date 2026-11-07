<?php
/**
 * Precast — site-wide behaviour: analytics + click tracking, performance,
 * floating WhatsApp, mobile bottom bar, body classes, nav fallback.
 * (Brief: Priority 1, 18, 23, 24, 33)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/** Google Analytics 4 + conversion tracking (only when an ID is configured). */
add_action('wp_head', function () {
    $c = sp_company();
    if (!$c['ga_id']) return;
    $id = esc_js($c['ga_id']);
    echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$id}\"></script>\n";
    echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$id}');</script>\n";
}, 3);

/** Click/submit tracking → gtag events (no-op without GA). */
add_action('wp_footer', function () {
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
}, 99);

/** Floating WhatsApp (desktop) + fixed mobile bar: CALL | WHATSAPP | GET QUOTE. */
add_action('wp_footer', function () {
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
}, 98);

/** Body classes. */
add_filter('body_class', function ($classes) {
    $classes[] = 'pc-site';
    if (is_front_page()) $classes[] = 'pc-home';
    return $classes;
});

/** Performance: lazy-load, remove emoji + embeds + jquery-migrate, defer non-critical scripts. */
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
});
add_action('wp_enqueue_scripts', function () {
    // The old product-showcase hero needed model-viewer; the new hero does not.
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
    // Montserrat is loaded by the old Customizer typography but no element uses it (Oswald + Inter are the site fonts).
    wp_dequeue_style('Montserrat-font');
    // Formidable's stylesheet is only needed where a [formidable] form is actually on the page.
    $post = get_queried_object();
    $has_frm = ($post instanceof WP_Post) && has_shortcode($post->post_content, 'formidable');
    if (!$has_frm) wp_dequeue_style('formidable');
}, 1000);

/** Projects taken off the site (drafted) → 301 to the projects portfolio instead of a 404. */
add_action('template_redirect', function () {
    if (!is_404()) return;
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if (!preg_match('#^projects/([a-z0-9-]+)$#', $path, $m)) return;
    $p = get_page_by_path($m[1], OBJECT, 'sp_project');
    if ($p && $p->post_status !== 'publish') {
        wp_safe_redirect(get_post_type_archive_link('sp_project'), 301);
        exit;
    }
}, 1);

/** Drop jQuery Migrate on the front end (no theme or plugin script needs it). */
add_action('wp_default_scripts', function ($scripts) {
    if (is_admin() || empty($scripts->registered['jquery'])) return;
    $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
});
add_filter('script_loader_tag', function ($tag, $handle) {
    if (is_admin()) return $tag;
    $defer = ['bootstrap', 'bootscore-theme', 'wpb_composer_front_js', 'vc_woocommerce-add-to-cart-js'];
    if (in_array($handle, $defer, true) && strpos($tag, 'defer') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);
add_filter('wp_lazy_loading_enabled', '__return_true');

/** Images: make WebP uploads the default output when a JPEG/PNG is uploaded (WP 6.1+). */
add_filter('image_editor_output_format', function ($formats) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
});

/** Default main menu when no menu is assigned (Brief: Priority 1 structure). */
function sp_default_nav_items(): array {
    return [
        ['Home',                home_url('/')],
        ['About Us',            sp_page_url('about-us', '/about-us/')],
        ['Products',            get_post_type_archive_link('sp_product') ?: home_url('/products/')],
        ['Projects',            get_post_type_archive_link('sp_project') ?: home_url('/projects/')],
        ['Capabilities',        sp_page_url('capabilities', '/capabilities/')],
        ['Technical Resources', sp_page_url('technical-resources', '/technical-resources/')],
        ['Contact',             sp_page_url('contact-us', '/contact-us/')],
    ];
}
function sp_nav_html(string $class = 'pc-nav'): string {
    $loc = has_nav_menu('main-menu') ? 'main-menu' : (has_nav_menu('primary-menu') ? 'primary-menu' : '');
    if ($loc) {
        $menu = wp_nav_menu([
            'theme_location' => $loc,
            'container'      => false,
            'echo'           => false,
            'fallback_cb'    => '__return_false',
            'items_wrap'     => '<ul class="' . esc_attr($class) . '">%3$s</ul>',
            'depth'          => 2,
        ]);
        if ($menu) return $menu;
    }
    $out = '<ul class="' . esc_attr($class) . '">';
    $cur = trailingslashit(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')));
    foreach (sp_default_nav_items() as [$label, $url]) {
        $active = trailingslashit($url) === $cur ? ' current-menu-item' : '';
        $out .= '<li class="menu-item' . $active . '"><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
    }
    return $out . '</ul>';
}

/** Remove the old pre-footer inquiry strip on pages where the new CTA lives. */
add_filter('sp_show_footer_inquiry', function ($show) {
    if (is_front_page() || is_page(['request-quotation', 'contact-us', 'contact'])) return false;
    return $show;
});

/** Project archive: reduce excessive filters — only the 6 approved categories (Brief: Priority 9). */
function sp_project_filter_slugs(): array {
    return ['heavy-precast', 'infrastructure', 'industrial', 'security', 'commercial', 'utilities'];
}

/** 404 should never be cached as 200; add a sensible 404 title. */
add_action('template_redirect', function () {
    if (is_404()) status_header(404);
});

/** Front-end script for the RFQ form and header. */
add_action('wp_enqueue_scripts', function () {
    $file = get_template_directory() . '/assets/js/precast.js';
    if (!file_exists($file)) return;
    wp_enqueue_script('precast', get_template_directory_uri() . '/assets/js/precast.js', [], date('YmdHi', filemtime($file)), true);
    wp_localize_script('precast', 'spRfq', ['ajax' => admin_url('admin-ajax.php'), 'maxBytes' => sp_rfq_max_bytes()]);
}, 20);

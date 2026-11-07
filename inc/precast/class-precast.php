<?php
/**
 * Precast Al Turab — core class.
 *
 * Loads the Precast modules, creates the feature objects and registers every
 * hook through Precast_Loader in define_*_hooks(). This is the only place in
 * inc/precast/ that wires callbacks to WordPress.
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast {

    /** @var Precast_Loader */
    protected $loader;

    /** @var string */
    protected $version;

    public function __construct() {
        $this->version = defined('PRECAST_VERSION') ? PRECAST_VERSION : '1.2.0';
        $this->load_dependencies();
        $this->define_shared_hooks();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_shortcodes();
    }

    /** Helper functions (used by templates) and the feature classes. */
    private function load_dependencies() {
        $dir = __DIR__ . '/';
        // Template helpers — plain functions, no hooks.
        require_once $dir . 'settings.php';
        require_once $dir . 'seo.php';
        require_once $dir . 'meta.php';
        require_once $dir . 'rfq.php';
        require_once $dir . 'site.php';
        require_once $dir . 'sections.php';
        // Loader + feature classes.
        require_once $dir . 'class-precast-loader.php';
        require_once $dir . 'class-precast-settings.php';
        require_once $dir . 'class-precast-seo.php';
        require_once $dir . 'class-precast-meta.php';
        require_once $dir . 'class-precast-rfq.php';
        require_once $dir . 'class-precast-site.php';
        require_once $dir . 'class-precast-sections.php';

        $this->loader   = new Precast_Loader();
        $this->settings = new Precast_Settings();
        $this->seo      = new Precast_SEO();
        $this->meta     = new Precast_Meta();
        $this->rfq      = new Precast_RFQ();
        $this->site     = new Precast_Site();
        $this->sections = new Precast_Sections();
    }

    /** @var Precast_Settings */ protected $settings;
    /** @var Precast_SEO */      protected $seo;
    /** @var Precast_Meta */     protected $meta;
    /** @var Precast_RFQ */      protected $rfq;
    /** @var Precast_Site */     protected $site;
    /** @var Precast_Sections */ protected $sections;

    /** Hooks needed on every request (front end, admin and AJAX). */
    private function define_shared_hooks() {
        $l = $this->loader;
        $l->add_action('init', $this->rfq, 'register_post_type');
        $l->add_action('init', $this->site, 'cleanup_head');
        $l->add_action('customize_register', $this->settings, 'customize_register');
        $l->add_action('customize_register', $this->seo, 'customize_register');
        $l->add_action('wp_ajax_sp_rfq_submit', $this->rfq, 'submit');
        $l->add_action('wp_ajax_nopriv_sp_rfq_submit', $this->rfq, 'submit');
        $l->add_action('vc_before_init', $this->sections, 'register_wpbakery_elements');
        $l->add_action('wp_default_scripts', $this->site, 'drop_jquery_migrate');
        $l->add_filter('image_editor_output_format', $this->site, 'webp_output_format');
        $l->add_filter('wp_get_attachment_image_attributes', $this->seo, 'image_alt_fallback', 10, 2);
        $l->add_filter('sp_fullwidth_shortcodes', $this->sections, 'fullwidth_shortcodes');
    }

    /** wp-admin: meta boxes and saving. */
    private function define_admin_hooks() {
        $l = $this->loader;
        $l->add_action('add_meta_boxes', $this->meta, 'add_meta_boxes');
        $l->add_action('save_post', $this->meta, 'save_post', 10, 2);
        $l->add_action('add_meta_boxes_sp_rfq', $this->rfq, 'add_files_meta_box');
    }

    /** Front end: head output, assets, footer UI, redirects. */
    private function define_public_hooks() {
        $l = $this->loader;
        $l->add_filter('pre_get_document_title', $this->seo, 'document_title', 20);
        $l->add_action('wp_head', $this->seo, 'head_meta', 1);
        $l->add_action('wp_head', $this->seo, 'canonical', 2);
        $l->add_action('wp_head', $this->site, 'analytics', 3);
        $l->add_action('wp_head', $this->seo, 'schema', 5);
        $l->add_action('wp_footer', $this->site, 'quick_actions', 98);
        $l->add_action('wp_footer', $this->site, 'click_tracking', 99);
        $l->add_filter('body_class', $this->site, 'body_class');
        $l->add_action('wp_enqueue_scripts', $this->site, 'enqueue_scripts', 20);
        $l->add_action('wp_enqueue_scripts', $this->site, 'dequeue_unused_assets', 1000);
        $l->add_filter('script_loader_tag', $this->site, 'defer_scripts', 10, 2);
        $l->add_filter('wp_lazy_loading_enabled', null, '__return_true');
        $l->add_action('template_redirect', $this->site, 'redirect_unpublished_projects', 1);
        $l->add_action('template_redirect', $this->site, 'send_404_status');
        $l->add_filter('sp_show_footer_inquiry', $this->site, 'hide_footer_inquiry');
    }

    /** Section shortcodes + the RFQ form shortcode. */
    private function define_shortcodes() {
        foreach (array_keys(sp_pc_shortcode_definitions()) as $tag) {
            $this->loader->add_shortcode($tag, $this->sections, 'render_shortcode');
        }
        $this->loader->add_shortcode('sublime_rfq_form', $this->rfq, 'form_shortcode');
    }

    /** Register all hooks with WordPress. */
    public function run() {
        $this->loader->run();
    }

    public function get_version() {
        return $this->version;
    }
}

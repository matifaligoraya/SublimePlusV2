<?php
/**
 * Register theme Scripts/Style.
 *
 * @package     SublimePulse
 * @version     3.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 * @des         All js, css of theme user must register in this file. Dev can remove or delete js/css don't use.
 */

/**
 * Load theme style
 */
if (!function_exists('sublimeplus_styles')) {
    function sublimeplus_styles()
    {
        // Bootstrap and other
        // wp_enqueue_style('bootstrap', SUBLIMEPLUS_URI . 'assets/vendor/bootstrap/bootstrap-grid.min.css');
        // wp_enqueue_style('wavemain', SUBLIMEPLUS_URI . 'assets/css/wave/style.css');
        // wp_enqueue_style('wavescroll', SUBLIMEPLUS_URI . 'assets/css/wave/jquery.mCustomScrollbar.min.css');
        // wp_enqueue_style('wavelightg', SUBLIMEPLUS_URI . 'assets/css/wave/lightgallery.min.css');
        // wp_enqueue_style('waveanimate', SUBLIMEPLUS_URI . 'assets/css/wave/animate.css');
        wp_register_style('slick', SUBLIMEPLUS_URI . 'assets/vendor/slick/slick.css');


        if (class_exists('WooCommerce', false)) {
            //Remove style don't use.
            wp_deregister_style('woocommerce-layout');
            wp_deregister_style('woocommerce-smallscreen');
            wp_deregister_style('woocommerce_prettyPhoto_css');
            wp_deregister_style('jquery-selectBox');
            //Custom Woocommerce Css
            wp_enqueue_style('sublimeplus-woocommerce', SUBLIMEPLUS_URI . 'assets/css/sublimeplus-woocommerce.css');
        }
        wp_register_style('sublimeplus-base-styles', false);
        wp_enqueue_style('sublimeplus-base-styles');
        wp_enqueue_style('sublimeplus-styles', SUBLIMEPLUS_URI . 'assets/css/zoo-styles.css');
        // Load style of customize
        $Sublimeplus_auto_css = Sublimeplus_Customize_Live_CSS::get_instance();

        wp_add_inline_style('sublimeplus-styles', $Sublimeplus_auto_css->auto_css());
        // Main style
        wp_enqueue_style('sublimeplus', get_stylesheet_uri());

    }
}
add_action('wp_enqueue_scripts', 'sublimeplus_styles', 999);

/**
 * Load theme Script
 */
if (!function_exists('sublimeplus_scripts')) {
    function sublimeplus_scripts()
    {
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }


        
// <!-- build:js js/vendor.js -->
// <script src="js/jquery-3.3.1.min.js"></script>
// <script src="js/popper.min.js" ></script>
// <script src="js/bootstrap.min.js"></script>
// <script src="js/slick.min.js"></script>
// <script src="js/wow.min.js"></script>
// <script src="js/jquery.mCustomScrollbar.js"></script>
// <script src="js/slideNav.min.js"></script>
// <script src="js/masonry.pkgd.min.js"></script>
// <script src="js/lightgallery-all.min.js"></script>
// <!-- endbuild -->

// <!-- build:js js/custom.js -->
// <script src="js/main.js"></script>
// <!-- endbuild -->
wp_register_script('popper', SUBLIMEPLUS_URI . 'assets/js/wave/popper.min.js');
wp_register_script('bootstrap', SUBLIMEPLUS_URI . 'assets/js/wave/bootstrap.min.js');
wp_register_script('popper', SUBLIMEPLUS_URI . 'assets/js/wave/popper.min.js');
wp_register_script('wow', SUBLIMEPLUS_URI . 'assets/js/wave/wow.min.js');
wp_register_script('mCustomScrollbar', SUBLIMEPLUS_URI . 'assets/js/wave/jquery.mCustomScrollbar.js');
wp_register_script('slideNav', SUBLIMEPLUS_URI . 'assets/js/wave/slideNav.min.js');
wp_register_script('masonry', SUBLIMEPLUS_URI . 'assets/js/wave/masonry.pkgd.min.js');
wp_register_script('lightgallery', SUBLIMEPLUS_URI . 'assets/js/wave/lightgallery-all.min.js');
wp_register_script('custom', SUBLIMEPLUS_URI . 'assets/js/wave/custom.js');
wp_register_script('main', SUBLIMEPLUS_URI . 'assets/js/wave/main.js');
//wp_register_script('jquery-core', SUBLIMEPLUS_URI . 'assets/js/wave/jquery-3.3.1.min.js', true);
wp_register_script('slick', SUBLIMEPLUS_URI . 'assets/vendor/slick/slick.min.js');

        wp_register_script('isotope', SUBLIMEPLUS_URI . 'assets/vendor/isotope/isotope.pkgd.min.js', array('jquery-core'), '3.0.6', true);
        wp_enqueue_script('defer-js', SUBLIMEPLUS_URI . 'assets/vendor/defer/defer.min.js', array('jquery-core'), '3.0.6', true);
        wp_register_script('sublimeplus-scripts', SUBLIMEPLUS_URI . 'assets/js/sublimeplus-scripts.js', array('jquery-core'), false, true);

        if (class_exists('WooCommerce', false)) {
	        wp_register_script('spritespin', SUBLIMEPLUS_URI . 'assets/vendor/spritespin/spritespin.js', array('jquery-core'), false, true);
            if (get_theme_mod('Sublimeplus_enable_quick_view', '1') == 1) {
                wp_enqueue_script('countdown');
                wp_enqueue_script('wc-add-to-cart-variation');
            }
            wp_enqueue_script('sublimeplus-woo-ajax', SUBLIMEPLUS_URI . 'assets/js/sublimeplus-woo-ajax.js', array('jquery-core'), false, true);
            wp_enqueue_script('sublimeplus-woocommerce', SUBLIMEPLUS_URI . 'assets/js/sublimeplus-woocommerce.js', array('jquery-core'), false, true);
        }

        wp_enqueue_script('sublimeplus-scripts');
        wp_enqueue_script('jquery-core');
        wp_enqueue_script('jquery-migrate-js');
        wp_enqueue_script('main');
    // wp_enqueue_script('bootstrap'); 
    //    wp_enqueue_script('wow');
    //     wp_enqueue_script('custom');
    //     wp_enqueue_script('lightgallery');
    //     wp_enqueue_script('masonry');
    //     wp_enqueue_script('slideNav');
    //     wp_enqueue_script('mCustomScrollbar');
    //            wp_enqueue_script('popper');
    }
}
add_action('wp_enqueue_scripts', 'sublimeplus_scripts');

/**
 * Add pingback
 */
if (!function_exists('Sublimeplus_pingback_header')) {
    function Sublimeplus_pingback_header() {
        if ( is_singular() && pings_open() ) {
            printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' ) ));
        }
    }
}
add_action( 'wp_head', 'Sublimeplus_pingback_header' );

/**
 * Ajax Url
 */
add_action('wp_enqueue_scripts', 'Sublimeplus_framework_ajax_url_render', 1000);
// Enqueue scripts for theme.
if (!function_exists('Sublimeplus_framework_ajax_url_render')) {
    function Sublimeplus_framework_ajax_url_render()
    {
        // Load custom style
        wp_add_inline_script('sublimeplus-scripts', Sublimeplus_framework_ajax_url());
    }
}
if (!function_exists('Sublimeplus_framework_ajax_url')) {
    function Sublimeplus_framework_ajax_url()
    {
        $ajaxurl = 'var ajaxurl = "' . esc_url(admin_url('admin-ajax.php')) . '";';
        return $ajaxurl;
    }
}
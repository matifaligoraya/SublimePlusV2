<?php
/**
 * Register theme Features
 *
 * @package     SublimePulse
 * @version     3.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 
 * @des         All features of theme will register here. Dev can add or remove features.
 */
if (!function_exists('sublimeplus_setup')) :
    function sublimeplus_setup()
    {
        load_theme_textdomain('sublimeplus', get_template_directory() . '/languages');

        add_theme_support('title-tag');

        add_theme_support('cs-font');

        add_theme_support('post-thumbnails');

        add_theme_support('automatic-feed-links');

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('post-formats', array('aside', 'gallery', 'image', 'quote', 'video', 'audio'));

        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        add_theme_support('advanced-image-compression');
        add_theme_support( "responsive-embeds" );
        add_theme_support( "wp-block-styles" );
        //Add site support for customize
        add_theme_support('custom-logo', array(
            'height' => 100,
            'width' => 400,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        ));
        add_theme_support("custom-header");
        add_theme_support("custom-background");
        add_theme_support( 'align-wide' );
        add_editor_style();
        if (!isset($GLOBALS['content_width'])) $GLOBALS['content_width'] = 992;
        if (class_exists('WooCommerce', false)) {
            add_theme_support( 'woocommerce', array(
                'gallery_thumbnail_image_width' => get_theme_mod('Sublimeplus_gallery_thumbnail_width','120'),
                'product_grid'          => array(
                    'default_rows'    => 3,
                    'min_rows'        => 1,
                    'max_rows'        => 8,
                    'default_columns' => 3,
                    'min_columns'     => 1,
                    'max_columns'     => 6,
                ),
            ) );
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
        }
    }
endif;
add_action('after_setup_theme', 'sublimeplus_setup');

// Disable WordPress Lazy Load
if(get_theme_mod('Sublimeplus_enable_lazy_image',1) != 1) {
    add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}
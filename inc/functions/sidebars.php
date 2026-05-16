<?php
/**
 * Register theme sidebars
 *
 * @package     SublimePulse
 * @version     3.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 
 * @des         All sidebar of theme register at here. Add/remove sidebars as you want.
 */

add_action('widgets_init', function () {
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'sublimeplus'),
        'id' => 'sidebar',
        'description' => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'sublimeplus'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar 2', 'sublimeplus'),
        'id' => 'sidebar-2',
        'description' => esc_html__('Secondary sidebar of blog page. User can set location display of this sidebar in Customize -> Blog -> Blog Archive -> Sidebar', 'sublimeplus'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    if (class_exists('WooCommerce', false)) {
        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'sublimeplus'),
            'id' => 'shop',
            'description' => esc_html__('Add widgets here to appear in your sidebar of shop page.', 'sublimeplus'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Shop Top Sidebar', 'sublimeplus'),
            'id' => 'top-shop',
            'description' => esc_html__('Add widgets here to appear in your sidebar of top shop page.', 'sublimeplus'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    } else {
        unregister_sidebar('shop');
        unregister_sidebar('top-shop');
    }

    // Footer widget areas
    $footer_cols = [
        'sp-footer-col-1' => 'Footer — Brand',
        'sp-footer-col-2' => 'Footer — Products',
        'sp-footer-col-3' => 'Footer — Company',
        'sp-footer-col-4' => 'Footer — Contact',
    ];
    foreach ($footer_cols as $id => $name) {
        register_sidebar([
            'name'          => esc_html__($name, 'sublimeplus'),
            'id'            => $id,
            'description'   => esc_html__('Override default footer column content with widgets.', 'sublimeplus'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="sp-footer__col-heading">',
            'after_title'   => '</h4>',
        ]);
    }
},10,0);
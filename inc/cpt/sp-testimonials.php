<?php
/**
 * Register the sp_testimonial custom post type.
 * Archive URL : /testimonials/
 * Single  URL : /testimonials/{slug}/
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('init', 'sp_register_testimonials_cpt', 0);

function sp_register_testimonials_cpt() {
    register_post_type('sp_testimonial', [
        'labels' => [
            'name'               => __('Testimonials',             'sublimeplus'),
            'singular_name'      => __('Testimonial',              'sublimeplus'),
            'add_new'            => __('Add Testimonial',          'sublimeplus'),
            'add_new_item'       => __('Add New Testimonial',      'sublimeplus'),
            'edit_item'          => __('Edit Testimonial',         'sublimeplus'),
            'new_item'           => __('New Testimonial',          'sublimeplus'),
            'view_item'          => __('View Testimonial',         'sublimeplus'),
            'search_items'       => __('Search Testimonials',      'sublimeplus'),
            'not_found'          => __('No testimonials found',    'sublimeplus'),
            'not_found_in_trash' => __('No testimonials in trash', 'sublimeplus'),
            'all_items'          => __('All Testimonials',         'sublimeplus'),
            'menu_name'          => __('Testimonials',             'sublimeplus'),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => 'testimonials',
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => ['title', 'editor', 'thumbnail', 'revisions', 'page-attributes'],
        'rewrite'            => ['slug' => 'testimonials', 'with_front' => false],
    ]);
}

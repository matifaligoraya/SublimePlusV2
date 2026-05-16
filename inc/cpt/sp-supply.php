<?php
/**
 * Supply Capability CPT — sp_supply
 *
 * Each post = one supply card shown on the homepage via [sublime_supply].
 * Supports: title, featured image (card photo), excerpt (card description).
 * Extra meta: icon key, custom link URL, display order.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('init', function () {

    register_post_type('sp_supply', [
        'labels' => [
            'name'               => __('Supply Items', 'sublimeplus'),
            'singular_name'      => __('Supply Item', 'sublimeplus'),
            'add_new'            => __('Add New', 'sublimeplus'),
            'add_new_item'       => __('Add Supply Item', 'sublimeplus'),
            'edit_item'          => __('Edit Supply Item', 'sublimeplus'),
            'new_item'           => __('New Supply Item', 'sublimeplus'),
            'view_item'          => __('View Supply Item', 'sublimeplus'),
            'search_items'       => __('Search Supply Items', 'sublimeplus'),
            'not_found'          => __('No supply items found.', 'sublimeplus'),
            'not_found_in_trash' => __('No supply items found in Trash.', 'sublimeplus'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-admin-tools',
        'menu_position'       => 26,
        'supports'            => ['title', 'thumbnail', 'excerpt', 'page-attributes'],
        'has_archive'         => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    ]);

}, 0);

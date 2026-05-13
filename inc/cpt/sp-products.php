<?php
/**
 * Register the sp_product custom post type and sp_product_cat taxonomy.
 * Archive URL : /products/
 * Single  URL : /products/{slug}/
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('init', 'sp_register_products_cpt', 0);

function sp_register_products_cpt() {

    // ── Custom Post Type ──────────────────────────────────────────────────────
    register_post_type('sp_product', [
        'labels' => [
            'name'               => __('Products',               'sublimeplus'),
            'singular_name'      => __('Product',                'sublimeplus'),
            'add_new'            => __('Add Product',            'sublimeplus'),
            'add_new_item'       => __('Add New Product',        'sublimeplus'),
            'edit_item'          => __('Edit Product',           'sublimeplus'),
            'new_item'           => __('New Product',            'sublimeplus'),
            'view_item'          => __('View Product',           'sublimeplus'),
            'view_items'         => __('View Products',          'sublimeplus'),
            'search_items'       => __('Search Products',        'sublimeplus'),
            'not_found'          => __('No products found',      'sublimeplus'),
            'not_found_in_trash' => __('No products in trash',   'sublimeplus'),
            'all_items'          => __('All Products',           'sublimeplus'),
            'archives'           => __('Product Archives',       'sublimeplus'),
            'menu_name'          => __('Products',               'sublimeplus'),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-building',
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes'],
        'rewrite'            => ['slug' => 'products', 'with_front' => false],
    ]);

    // ── Category Taxonomy ─────────────────────────────────────────────────────
    register_taxonomy('sp_product_cat', 'sp_product', [
        'labels' => [
            'name'              => __('Product Categories',    'sublimeplus'),
            'singular_name'     => __('Product Category',     'sublimeplus'),
            'search_items'      => __('Search Categories',    'sublimeplus'),
            'all_items'         => __('All Categories',       'sublimeplus'),
            'parent_item'       => __('Parent Category',      'sublimeplus'),
            'parent_item_colon' => __('Parent Category:',     'sublimeplus'),
            'edit_item'         => __('Edit Category',        'sublimeplus'),
            'update_item'       => __('Update Category',      'sublimeplus'),
            'add_new_item'      => __('Add New Category',     'sublimeplus'),
            'new_item_name'     => __('New Category Name',    'sublimeplus'),
            'menu_name'         => __('Categories',           'sublimeplus'),
        ],
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_admin_column'  => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'product-category', 'with_front' => false],
    ]);
}

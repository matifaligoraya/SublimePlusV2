<?php
/**
 * Register the sp_project custom post type and sp_project_cat taxonomy.
 * Archive URL : /projects/
 * Single  URL : /projects/{slug}/
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('init', 'sp_register_projects_cpt', 0);

function sp_register_projects_cpt() {

    // ── Custom Post Type ──────────────────────────────────────────────────────
    register_post_type('sp_project', [
        'labels' => [
            'name'               => __('Projects',               'sublimeplus'),
            'singular_name'      => __('Project',                'sublimeplus'),
            'add_new'            => __('Add Project',            'sublimeplus'),
            'add_new_item'       => __('Add New Project',        'sublimeplus'),
            'edit_item'          => __('Edit Project',           'sublimeplus'),
            'new_item'           => __('New Project',            'sublimeplus'),
            'view_item'          => __('View Project',           'sublimeplus'),
            'view_items'         => __('View Projects',          'sublimeplus'),
            'search_items'       => __('Search Projects',        'sublimeplus'),
            'not_found'          => __('No projects found',      'sublimeplus'),
            'not_found_in_trash' => __('No projects in trash',   'sublimeplus'),
            'all_items'          => __('All Projects',           'sublimeplus'),
            'archives'           => __('Project Archives',       'sublimeplus'),
            'menu_name'          => __('Projects',               'sublimeplus'),
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
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes'],
        'rewrite'            => ['slug' => 'projects', 'with_front' => false],
    ]);

    // ── Category Taxonomy ─────────────────────────────────────────────────────
    register_taxonomy('sp_project_cat', 'sp_project', [
        'labels' => [
            'name'              => __('Project Categories',   'sublimeplus'),
            'singular_name'     => __('Project Category',    'sublimeplus'),
            'search_items'      => __('Search Categories',   'sublimeplus'),
            'all_items'         => __('All Categories',      'sublimeplus'),
            'parent_item'       => __('Parent Category',     'sublimeplus'),
            'parent_item_colon' => __('Parent Category:',    'sublimeplus'),
            'edit_item'         => __('Edit Category',       'sublimeplus'),
            'update_item'       => __('Update Category',     'sublimeplus'),
            'add_new_item'      => __('Add New Category',    'sublimeplus'),
            'new_item_name'     => __('New Category Name',   'sublimeplus'),
            'menu_name'         => __('Categories',          'sublimeplus'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'project-category', 'with_front' => false],
    ]);
}

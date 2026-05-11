<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'name' => 'Sublimeplus_blog',
        'type' => 'panel',
        'label' => esc_html__('Blog', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_blog_archive',
        'type' => 'section',
        'label' => esc_html__('Blog Archive', 'sublimeplus'),
        'panel' => 'Sublimeplus_blog',
    ],
    [
        'name' => 'Sublimeplus_blog_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_archive',
    ],
    [
        'name' => 'Sublimeplus_blog_layout',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'title' => esc_html__('Layout', 'sublimeplus'),
        'default' => 'list',
        'choices' => [
            'list' => esc_html__('List', 'sublimeplus'),
            'list-2' => esc_html__('List 2', 'sublimeplus'),
            'grid' => esc_html__('Grid', 'sublimeplus'),
            'masonry' => esc_html__('Masonry', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_blog_grid_img_size',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Image size', 'sublimeplus'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'sublimeplus'),
        'default' => 'medium',
        'required' => ['Sublimeplus_blog_layout', '!=', 'list'],
	    'choices'=>Sublimeplus_get_image_sizes()

    ],
	[
        'name' => 'Sublimeplus_blog_img_size',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Image size', 'sublimeplus'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'sublimeplus'),
        'default' => 'full',
        'required' => ['Sublimeplus_blog_layout', '==', 'list'],
	    'choices'=>Sublimeplus_get_image_sizes()

    ],
	[
        'name' => 'Sublimeplus_blog_cols',
        'type' => 'number',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Columns', 'sublimeplus'),
        'description' => esc_html__('Apply for Grid Layout only', 'sublimeplus'),
        'default' => 3,
        'required' => ['Sublimeplus_blog_layout', '!=', 'list'],
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'class' => 'sublimeplus-range-slider'
        ),
    ],
    [
        'name' => 'Sublimeplus_enable_blog_cover',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Blog Cover', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 0
    ],
    [
        'name' => 'Sublimeplus_blog_cover',
        'type' => 'styling',
        'section' => 'Sublimeplus_blog_archive',
        'title' => esc_html__('Blog cover style', 'sublimeplus'),
        'description' => esc_html__('Styling for categories page', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_blog_cover', '==', '1'],
        'selector' => [
            'normal' => '.wrap-blog-cover',
        ],
        'css_format' => 'styling',
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'margin' => false,
                'link_color' => false,
                'border_style' => false,
                'border_heading' => false,
                'border_radius' => false,
                'box_shadow' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => false
        ]
    ],
    [
        'name' => 'Sublimeplus_blog_sidebar_settings',
        'type' => 'heading',
        'label' => esc_html__('Sidebar Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_archive'
    ],
    [
        'name' => 'Sublimeplus_blog_sidebar_config',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'title' => esc_html__('Sidebar layout', 'sublimeplus'),
        'default' => 'right',
        'choices' => [
            '' => esc_html__('None', 'sublimeplus'),
            'left' => esc_html__('Left', 'sublimeplus'),
            'right' => esc_html__('Right', 'sublimeplus'),
        ]
    ],[
        'name' => 'Sublimeplus_blog_sidebar',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'title' => esc_html__('Sidebar', 'sublimeplus'),
        'required' => ['Sublimeplus_blog_sidebar_config', '!=', 'none'],
        'choices' => Sublimeplus_get_registered_sidebars()
    ],
    [
        'name' => 'Sublimeplus_blog_item_settings',
        'type' => 'heading',
        'label' => esc_html__('Blog Item', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_archive',
    ],
    [
        'name' => 'Sublimeplus_blog_loop_post_info_style',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_archive',
        'title' => esc_html__('Post info style', 'sublimeplus'),
        'default' => 'icon',
        'choices' => [
            'icon' => esc_html__('icon', 'sublimeplus'),
            'text' => esc_html__('Text', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_enable_loop_author_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Author Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'Sublimeplus_enable_loop_date_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Date Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'Sublimeplus_enable_loop_cat_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Post Categories', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_loop_excerpt',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Blog Excerpt', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 0
    ],
    [
        'name' => 'Sublimeplus_loop_excerpt_length',
        'type' => 'number',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Blog Excerpt length', 'sublimeplus'),
        'default' => 30,
        'required' => ['Sublimeplus_enable_loop_excerpt', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 256,
            'class' => 'sublimeplus-range-slider'
        ),
    ],
    [
        'name' => 'Sublimeplus_enable_loop_readmore',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_archive',
        'label' => esc_html__('Enable Read more', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ]
];
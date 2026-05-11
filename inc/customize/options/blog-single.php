<?php
/**
 * Customize for Blog Single
 */
return [
    [
        'name' => 'Sublimeplus_blog_single',
        'type' => 'section',
        'label' => esc_html__('Blog Single', 'sublimeplus'),
        'panel' => 'Sublimeplus_blog',
    ],
    [
        'name' => 'Sublimeplus_blog_single_sidebar_settings',
        'type' => 'heading',
        'label' => esc_html__('Sidebar Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_single',
    ],
    [
        'name' => 'Sublimeplus_blog_single_sidebar_config',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_single',
        'title' => esc_html__('Sidebar layout', 'sublimeplus'),
        'default' => '',
        'choices' => [
            '' => esc_html__('None', 'sublimeplus'),
            'left' => esc_html__('Left', 'sublimeplus'),
            'right' => esc_html__('Right', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_blog_single_sidebar',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_single',
        'title' => esc_html__('Sidebar', 'sublimeplus'),
        'required' => ['Sublimeplus_blog_single_sidebar_config', '!=', 'none'],
        'choices' => Sublimeplus_get_registered_sidebars()
    ],
    [
        'name' => 'Sublimeplus_blog_single_features_settings',
        'type' => 'heading',
        'label' => esc_html__('Features Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_single',
    ],
    [
        'name' => 'Sublimeplus_blog_single_post_info_style',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_single',
        'title' => esc_html__('Post info style', 'sublimeplus'),
        'default' => 'icon',
        'choices' => [
            'icon' => esc_html__('Icon', 'sublimeplus'),
            'text' => esc_html__('Text', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_blog_single_post_header_align',
        'type' => 'select',
        'section' => 'Sublimeplus_blog_single',
        'title' => esc_html__('Header post align', 'sublimeplus'),
        'default' => 'center',
        'choices' => [
            'left' => esc_html__('Left', 'sublimeplus'),
            'center' => esc_html__('Center', 'sublimeplus'),
            'right' => esc_html__('Right', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_enable_blog_author_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Author Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'Sublimeplus_enable_blog_date_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Date Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'Sublimeplus_enable_blog_cat_post',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Post Categories', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'Sublimeplus_enable_blog_tags',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Tags', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_blog_share',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Share', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_next_previous_posts',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Next & Previous Posts', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_blog_single_related_post',
        'type' => 'heading',
        'label' => esc_html__('Related Post Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_blog_single',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_enable_blog_related',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Enable Related Posts', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_blog_related_numbers',
        'type' => 'number',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Related post numbers', 'sublimeplus'),
        'default' => 3,
        'required' => ['Sublimeplus_enable_blog_related', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
            'class' => 'sublimeplus-range-slider'
        ),
    ], [
        'name' => 'Sublimeplus_blog_related_cols',
        'type' => 'number',
        'section' => 'Sublimeplus_blog_single',
        'label' => esc_html__('Related post columns', 'sublimeplus'),
        'default' => 3,
        'required' => ['Sublimeplus_enable_blog_related', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'class' => 'sublimeplus-range-slider'
        ),
    ],
];
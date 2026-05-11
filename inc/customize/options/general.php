<?php
/**
 * Customize for Site
 */
return [
    [
        'name' => 'Sublimeplus_general',
        'type' => 'section',
        'label' => esc_html__('General', 'sublimeplus'),
        'priority'=>0
    ],
    [
        'name' => 'Sublimeplus_site_layout',
        'type' => 'select',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Site Layout', 'sublimeplus'),
        'description' => esc_html__('Config Layout for site', 'sublimeplus'),
        'default' => 'normal',
        'choices' => [
            'normal' => esc_html__('Normal', 'sublimeplus'),
            'boxed' => esc_html__('Boxed', 'sublimeplus'),
            'full-width' => esc_html__('Full Width', 'sublimeplus'),
        ]
    ],[
        'name' => 'Sublimeplus_site_max_width',
        'type' => 'number',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Site Max Width', 'sublimeplus'),
        'description' => esc_html__('Max width content of site. Leave it blank or 0, size max width will full width.', 'sublimeplus'),
        'default' => '1170',
    ],[
        'name' => 'Sublimeplus_disable_breadcrumbs',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Disable Breadcrumbs', 'sublimeplus'),
        'default' => 0,
        'checkbox_label' => esc_html__('Breadcrumbs will remove if checked.', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_disable_emojis',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Disable Emojis', 'sublimeplus'),
        'default' => 1,
        'checkbox_label' => esc_html__('Emojis will remove if checked.', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_enable_lazy_image',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Enable Lazy Load Images', 'sublimeplus'),
        'default' => 1,
        'checkbox_label' => esc_html__('Enable Lazy Load Images if checked.', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_enable_site_meta',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Enable Site Meta', 'sublimeplus'),
        'default' => 0,
        'checkbox_label' => esc_html__('Show post thumbnail, title, description when share.', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_enable_back_top_top',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_general',
        'title' => esc_html__('Enable Back to Top', 'sublimeplus'),
        'default' => 1,
        'checkbox_label' => esc_html__('Show button back to top.', 'sublimeplus'),
    ],
];
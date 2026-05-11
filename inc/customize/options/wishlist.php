<?php
/**
 * Customize Wishlist Options
 */
return [
    [
        'type' => 'section',
        'name' => 'Sublimeplus_wishlist',
        'title' => esc_html__('Wishlist', 'sublimeplus'),
        'panel' => 'woocommerce',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_wishlist_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_wishlist'
    ],
    [
        'name' => 'Sublimeplus_enable_wishlist',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Enable Wishlist', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_shop_loop_wishlist',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Enable Shop Wishlist', 'sublimeplus'),
        'checkbox_label' => esc_html__('Wishlist button will show in shop loop if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_wishlist_redirect',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Enable Wishlist Redirect Link', 'sublimeplus'),
        'checkbox_label' => esc_html__('Redirect to wishlist page when click to button browse wishlist.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 0
    ],
    [
        'name' => 'Sublimeplus_wishlist_page',
        'type' => 'select',
        'section' => 'Sublimeplus_wishlist',
        'title' => esc_html__('Wishlist page', 'sublimeplus'),
        'default' => '',
        'theme_supports' => 'woocommerce',
        'choices' => Sublimeplus_list_pages_by_slug(),
        'required' => ['Sublimeplus_enable_wishlist_redirect', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_wishlist_add_to_wishlist_settings',
        'type' => 'heading',
        'label' => esc_html__('Add to Wishlist Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_wishlist',
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_text_add_to_wishlist',
        'type' => 'text',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Add to Wishlist', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_icon_add_to_wishlist',
        'type' => 'icon',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'sublimeplus-icon',
            'icon' => 'sublimeplus-icon-heart-o'
        ],
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_wishlist_browse_to_wishlist_settings',
        'type' => 'heading',
        'label' => esc_html__('Browse to Wishlist Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_wishlist',
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_text_browse_to_wishlist',
        'type' => 'text',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Browse Wishlist', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_icon_browse_to_wishlist',
        'type' => 'icon',
        'section' => 'Sublimeplus_wishlist',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'sublimeplus-icon',
            'icon' => 'sublimeplus-icon-heart-o'
        ],
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_wishlist_style_settings',
        'type' => 'heading',
        'label' => esc_html__('Wishlist Style', 'sublimeplus'),
        'section' => 'Sublimeplus_wishlist',
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_wishlist_icon_size',
        'type' => 'slider',
        'label' => esc_html__('Font Size', 'sublimeplus'),
        'section' => 'Sublimeplus_wishlist',
        'min' => 8,
        'step' => 1,
        'max' => 100,
        'selector' => ".woocommerce ul.products li.product .sublimeplus-wishlist-button>i",
        'css_format' => "font-size: {{value}};",
        'required' => ['Sublimeplus_enable_wishlist', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_wishlist_shop_style',
        'type' => 'styling',
        'section' => 'Sublimeplus_wishlist',
        'title' => esc_html__('Wishlist style', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Wishlist in shop loop', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_wishlist', '==', 1],
        'selector' => [
            'normal' => '.woocommerce ul.products li.product .sublimeplus-wishlist-button',
            'hover' => '.woocommerce ul.products li.product .sublimeplus-wishlist-button:hover, .woocommerce ul.products li.product .sublimeplus-wishlist-button.browse-wishlist',
        ],
        'css_format' => 'styling',
        'priority' => 11,
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'link_color' => false,
                'margin' => false,
                'padding' => false,
                'bg_image' => false,
                'device_settings' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => [
                'link_color' => false
            ]
        ]
    ]
];

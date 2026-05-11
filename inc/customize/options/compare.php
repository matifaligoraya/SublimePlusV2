<?php
/**
 * Customize Compare Options
 */
return [
    [
        'type' => 'section',
        'name' => 'Sublimeplus_compare',
        'title' => esc_html__('Compare', 'sublimeplus'),
        'panel' => 'woocommerce',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_compare_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_compare'
    ],
    [
        'name' => 'Sublimeplus_enable_compare',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Enable Compare', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_shop_loop_compare',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Enable Shop Compare', 'sublimeplus'),
        'checkbox_label' => esc_html__('compare button will show in shop loop if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_enable_compare_redirect',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Enable compare Redirect Link', 'sublimeplus'),
        'checkbox_label' => esc_html__('Redirect to compare page when click to button browse compare.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 0
    ],
    [
        'name' => 'Sublimeplus_compare_page',
        'type' => 'select',
        'section' => 'Sublimeplus_compare',
        'title' => esc_html__('Compare page', 'sublimeplus'),
        'default' => '',
        'theme_supports' => 'woocommerce',
        'choices' => Sublimeplus_list_pages_by_slug(),
        'required' => ['Sublimeplus_enable_compare_redirect', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_compare_add_to_compare_settings',
        'type' => 'heading',
        'label' => esc_html__('Add to compare Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_compare',
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_text_add_to_compare',
        'type' => 'text',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Add to Compare', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_icon_add_to_compare',
        'type' => 'icon',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'sublimeplus-icon',
            'icon' => 'sublimeplus-icon-refresh'
        ],
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_compare_browse_to_compare_settings',
        'type' => 'heading',
        'label' => esc_html__('Browse to compare Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_compare',
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_text_browse_to_compare',
        'type' => 'text',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Browse compare', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_icon_browse_to_compare',
        'type' => 'icon',
        'section' => 'Sublimeplus_compare',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'sublimeplus-icon',
            'icon' => 'sublimeplus-icon-refresh'
        ],
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_compare_style_settings',
        'type' => 'heading',
        'label' => esc_html__('compare Style', 'sublimeplus'),
        'section' => 'Sublimeplus_compare',
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_compare_icon_size',
        'type' => 'slider',
        'label' => esc_html__('Font Size', 'sublimeplus'),
        'section' => 'Sublimeplus_compare',
        'min' => 8,
        'step' => 1,
        'max' => 100,
        'selector' => ".woocommerce ul.products li.product .sublimeplus-compare-button>i",
        'css_format' => "font-size: {{value}};",
        'required' => ['Sublimeplus_enable_compare', '==', 1]
    ],
    [
        'name' => 'Sublimeplus_compare_shop_style',
        'type' => 'styling',
        'section' => 'Sublimeplus_compare',
        'title' => esc_html__('compare style', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for compare in shop loop', 'sublimeplus'),
        'required' => ['Sublimeplus_enable_compare', '==', 1],
        'selector' => [
            'normal' => '.woocommerce ul.products li.product .sublimeplus-compare-button',
            'hover' => '.woocommerce ul.products li.product .sublimeplus-compare-button:hover, .woocommerce ul.products li.product .sublimeplus-compare-button.browse-products-compare',
        ],
        'css_format' => 'styling',
        'priority' => 11,
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'link_color' => false, // disable for special field.
                'margin' => false,
                'padding' => false,
                'bg_image' => false,
                'device_settings' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => [
                'link_color' => false, // disable for special field.
            ]
        ]
    ]
];

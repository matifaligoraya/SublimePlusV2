<?php
/**
 * Customize for General Style
 */
return [
    [
        'name' => 'Sublimeplus_style',
        'type' => 'panel',
        'label' => esc_html__('Style', 'sublimeplus'),
    ], [
        'name' => 'Sublimeplus_general_style',
        'type' => 'section',
        'label' => esc_html__('General Style', 'sublimeplus'),
        'panel' => 'Sublimeplus_style',
        'description' => esc_html__('Leave option blank if you want use default style of theme.', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_general_style_heading_color',
        'type' => 'heading',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Color', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_color_preset',
        'type' => 'select',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Preset', 'sublimeplus'),
        'description' => esc_html__('Predefined color scheme to Style', 'sublimeplus'),
        'default' => 'default',
        'choices' => [
            'default' => esc_html__('Default', 'sublimeplus'),
            'black' => esc_html__('Black', 'sublimeplus'),
            'blue' => esc_html__('Blue', 'sublimeplus'),
            'red' => esc_html__('Red', 'sublimeplus'),
            'yellow' => esc_html__('Yellow', 'sublimeplus'),
            'green' => esc_html__('Green', 'sublimeplus'),
            'grey' => esc_html__('Grey', 'sublimeplus'),
            'custom' => esc_html__('Custom', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_primary_color',
        'type' => 'color',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Primary color', 'sublimeplus'),
        'selector' => ".accent-color",
        'css_format' => 'color: {{value}};',
        'description' => esc_html__('Primary color of theme apply only when preset is custom.', 'sublimeplus'),
        'required'=>['Sublimeplus_color_preset','==','custom']
    ],[
        'name' => 'Sublimeplus_site_color',
        'type' => 'color',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Text color', 'sublimeplus'),
        'selector' => "body",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_site_link_color',
        'type' => 'color',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Link color', 'sublimeplus'),
        'selector' => "a",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_site_link_color_hover',
        'type' => 'color',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Link color hover', 'sublimeplus'),
        'selector' => "a:hover",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_site_heading_color',
        'type' => 'color',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Heading color', 'sublimeplus'),
        'selector' => "h1, h2, h3, h4, h5, h6",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'Sublimeplus_general_heading_bg',
        'type' => 'heading',
        'section' => 'Sublimeplus_general_style',
        'title' => esc_html__('Background', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_general_bg',
        'type' => 'styling',
        'section' => 'Sublimeplus_general_style',
        'title'  => esc_html__('Background', 'sublimeplus'),
        'selector' => [
            'normal' => "body",
        ],
        'field_class'=>'no-hide no-heading',
        'css_format' => 'styling', // styling
        'fields' => [
            'normal_fields' => [
                'text_color' => false,
                'link_color' => false,
                'link_hover_color' => false,
                'padding' => false,
                'box_shadow' => false,
                'border_radius' => false,
                'border_style' => false,
                'border_heading' => false,
                'bg_heading' => false,
                'margin' => false
            ],
            'hover_fields' => false
        ]
    ],
];

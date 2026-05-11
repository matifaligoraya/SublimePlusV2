<?php
/**
 * Customize for General Style
 */
return [ 
    [
        'name' => 'Sublimeplus_sidebar_style',
        'type' => 'section',
        'label' => esc_html__('Sidebar Style', 'sublimeplus'),
        'panel' => 'Sublimeplus_style',
        'description' => esc_html__('Leave option blank if you want use default style of theme.', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_sidebar_heading_color',
        'type' => 'heading',
        'section' => 'Sublimeplus_sidebar_style',
        'title' => esc_html__('Color', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_sidebar_title_color',
        'type' => 'color',
        'section' => 'Sublimeplus_sidebar_style',
        'title' => esc_html__('Title Sidebar Color', 'sublimeplus'),
        'selector' => ".sidebar .widget-title",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'Sublimeplus_sidebar_color',
        'type' => 'color',
        'section' => 'Sublimeplus_sidebar_style',
        'title' => esc_html__('Text color', 'sublimeplus'),
        'selector' => ".sidebar",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_sidebar_link_color',
        'type' => 'color',
        'section' => 'Sublimeplus_sidebar_style',
        'title' => esc_html__('Link color', 'sublimeplus'),
        'selector' => ".sidebar a, .widget > ul li a",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_sidebar_link_color_hover',
        'type' => 'color',
        'section' => 'Sublimeplus_sidebar_style',
        'title' => esc_html__('Link color hover', 'sublimeplus'),
        'selector' => ".sidebar a:hover, .widget > ul li a:hover",
        'css_format' => 'color: {{value}};',
    ],
];

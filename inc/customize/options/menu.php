<?php
/**
 * Customize for Menu
 */
return [
    [
        'name' => 'Sublimeplus_menu',
        'type' => 'section',
        'label' => esc_html__('Menu Settings', 'sublimeplus'),
        'priority' => 5
    ],
    [
        'name' => 'Sublimeplus_primary_menu_alignment',
        'type' => 'select',
        'section' => 'Sublimeplus_menu',
        'title' => esc_html__('Primary Menu Alignment', 'sublimeplus'),
        'description' => esc_html__('Choose the alignment for the primary menu.', 'sublimeplus'),
        'default' => 'left',
        'choices' => [
            'left' => esc_html__('Left', 'sublimeplus'),
            'center' => esc_html__('Center', 'sublimeplus'),
            'right' => esc_html__('Right', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'Sublimeplus_primary_menu_hide_arrow',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_menu',
        'title' => esc_html__('Hide Primary Menu Dropdown Arrow', 'sublimeplus'),
        'default' => 0,
        'checkbox_label' => esc_html__('Hide the dropdown arrow for submenus.', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_top_menu_hide_arrow',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_menu',
        'title' => esc_html__('Hide Top Menu Dropdown Arrow', 'sublimeplus'),
        'default' => 0,
        'checkbox_label' => esc_html__('Hide the dropdown arrow for top menu submenus.', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_mobile_menu_hide_arrow',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_menu',
        'title' => esc_html__('Hide Mobile Menu Dropdown Arrow', 'sublimeplus'),
        'default' => 0,
        'checkbox_label' => esc_html__('Hide the dropdown arrow for mobile menu submenus.', 'sublimeplus'),
    ],
];
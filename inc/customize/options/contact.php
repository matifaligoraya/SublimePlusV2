<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'type' => 'section',
        'name' => 'Sublimeplus_contact',
        'title' => esc_html__('Contact', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_contact_general_settings',
        'type' => 'heading',
        'label' => esc_html__('Contact Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_contact',
    ],
    [
        'name' => 'Sublimeplus_contact_type',
        'type' => 'select',
        'section' => 'Sublimeplus_contact',
        'title' => esc_html__('Contact Type', 'sublimeplus'),
        'default' => 'none',
        'choices' => [
            'none' => esc_html__('None', 'sublimeplus'),
            'phone' => esc_html__('Phone', 'sublimeplus'),
            'email' => esc_html__('Email', 'sublimeplus'),
            'messenger' => esc_html__('Messenger', 'sublimeplus'),
            'whatsapp' => esc_html__('Whatsapp', 'sublimeplus'),
            'skype' => esc_html__('Skype', 'sublimeplus'),
        ]
    ],
    [
        'type' => 'text',
        'name' => 'Sublimeplus_contact_id',
        'label' => esc_html__('Contact ID', 'sublimeplus'),
        'section' => 'Sublimeplus_contact',
        'description' => esc_html__('Your contact id. That is your phone, email or social id follow type contact you selected', 'sublimeplus'),
        'required' => ['Sublimeplus_contact_type', '!=', 'none'],
    ],
];

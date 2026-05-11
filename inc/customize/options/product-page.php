<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'type' => 'section',
        'name' => 'Sublimeplus_single_product',
        'title' => esc_html__('Product Page', 'sublimeplus'),
        'panel' => 'woocommerce',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_single_product_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_single_product',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_enable_product_new',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_single_product',
        'label' => esc_html__('Enable Product New', 'sublimeplus'),
        'checkbox_label' => esc_html__('Show product new if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'Sublimeplus_single_product_layout_settings',
        'type' => 'heading',
        'label' => esc_html__('Layout & Gallery Settings', 'sublimeplus'),
        'section' => 'Sublimeplus_single_product',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_enable_product_zoom',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_single_product',
        'label' => esc_html__('Enable Product Gallery Zoom', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'checkbox_label' => esc_html__('Enable product zoom for product gallery.', 'sublimeplus'),
        'default' => 1,
    ],[
        'name' => 'Sublimeplus_enable_product_lb',
        'type' => 'checkbox',
        'section' => 'Sublimeplus_single_product',
        'label' => esc_html__('Enable Product Gallery Light Box', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'checkbox_label' => esc_html__('Enable light box for product gallery.', 'sublimeplus'),
        'default' => 1,
    ],
];
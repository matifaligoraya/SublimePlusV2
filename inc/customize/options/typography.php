<?php
/**
 * Typography for theme
 * @core: 3.0
 * @version : 1.0.0
 * @package : SublimePulse
 */
return[
    [
        'name' => 'Sublimeplus_typography',
        'type' => 'section',
        'label' => esc_html__('Typography', 'sublimeplus'),
        'panel' => 'Sublimeplus_style',
    ],

    array(
        'name'  => 'Sublimeplus_use_font',
        'type'  => 'select',
        'label' => esc_html__('Choose Use Font', 'sublimeplus'),
        'section' => 'Sublimeplus_typography',
        'default' => 'default',
        'choices' => [
            'default'        => esc_html__( 'Default Font', 'sublimeplus' ),
            'google'        => esc_html__( 'Google Font', 'sublimeplus' ),
            'custom'        => esc_html__( 'Custom Font', 'sublimeplus' ),
        ]
    ),
    //Add new font
    [
        'name' => 'Sublimeplus_typo_new_font_heading',
        'type' => 'heading',
        'label' => esc_html__('Add New Font', 'sublimeplus'),
        'section' => 'Sublimeplus_typography',
        'required'=>['Sublimeplus_use_font','==','custom']
    ],
    [
        'name'        => 'Sublimeplus_typo_new_font_family',
        'type'        => 'text',
        'section'     => 'Sublimeplus_typography',
        'title'       => esc_html__('Add Family Name', 'sublimeplus'),
        'description' => esc_html__('Ex: Roboto, Larsseit...', 'sublimeplus'),
        'required'=>['Sublimeplus_use_font','==','custom']
    ],
    array(
        'name'             => 'Sublimeplus_font_items',
        'type'             => 'repeater',
        'section'          => 'Sublimeplus_typography',
        'title'            => esc_html__('Add Font', 'sublimeplus'),
        'live_title_field' => 'font',
        'default'          => array(
            array(
                'weight' =>'normal',
                'style' =>'normal',
                'woff' =>'#',
                'woff2' =>'#',
                'ttf' =>'#',
                'svg' =>'#',
            ),
        ),
        'fields'           => array(
            array(
                'name'  => 'weight',
                'type'  => 'select',
                'label' => esc_html__('Weight', 'sublimeplus'),
                'default' => 'normal',
                'choices' => [
                    'normal'        => esc_html__( 'Normal', 'sublimeplus' ),
                    'bold'        => esc_html__( 'Bold', 'sublimeplus' ),
                    '100'       => esc_html__( '100', 'sublimeplus' ),
                    '200'       => esc_html__( '200', 'sublimeplus' ),
                    '300'       => esc_html__( '300', 'sublimeplus' ),
                    '400'       => esc_html__( '400', 'sublimeplus' ),
                    '500'       => esc_html__( '500', 'sublimeplus' ),
                    '600'       => esc_html__( '600', 'sublimeplus' ),
                    '700'       => esc_html__( '700', 'sublimeplus' ),
                    '800'       => esc_html__( '800', 'sublimeplus' ),
                    '900'       => esc_html__( '900', 'sublimeplus' ),
                ]
            ),
            array(
                'name'  => 'style',
                'type'  => 'select',
                'label' => esc_html__('Style', 'sublimeplus'),
                'default' => 'normal',
                'choices' => [
                    'normal'        => esc_html__( 'Normal', 'sublimeplus' ),
                    'italic'        => esc_html__( 'Italic', 'sublimeplus' ),
                    'oblique'        => esc_html__( 'Oblique', 'sublimeplus' ),
                ]
            ),

            array(
                'name'  => 'woff',
                'type'  => 'text',
                'label' => esc_html__('URL WOFF File', 'sublimeplus'),
            ),
            array(
                'name'  => 'woff2',
                'type'  => 'text',
                'label' => esc_html__('URL WOFF2 File', 'sublimeplus'),
            ),
            array(
                'name'  => 'ttf',
                'type'  => 'text',
                'label' => esc_html__('URL TTF File', 'sublimeplus'),
            ),
            array(
                'name'  => 'svg',
                'type'  => 'text',
                'label' => esc_html__('URL SVG File', 'sublimeplus'),
            ),

        ),
        'required'=>['Sublimeplus_use_font','==','custom']
    ),

    // Google font
    [
        'name' => 'Sublimeplus_typo_base_heading',
        'type' => 'heading',
        'label' => esc_html__('Base', 'sublimeplus'),
        'section' => 'Sublimeplus_typography',
        'required'=>['Sublimeplus_use_font','==','google']
    ],
    [
        'name'        => 'Sublimeplus_typo_base',
        'type'        => 'typography',
        'section'     => 'Sublimeplus_typography',
        'title'       => esc_html__('Base Typography', 'sublimeplus'),
        'description' => esc_html__('Typography for site', 'sublimeplus'),
        'selector'    => "body",
        'css_format'  => 'typography',
        'field_class'=>'no-hide',
        'fields' => array(
            'style' => false,
            'text_decoration' => false,
            'text_transform' => false,
        ),
        'required'=>['Sublimeplus_use_font','==','google']
    ],
    [
        'name' => 'Sublimeplus_typo_heading_heading',
        'type' => 'heading',
        'label' => esc_html__('Heading & Title', 'sublimeplus'),
        'section' => 'Sublimeplus_typography',
    ],
    [
        'name'        => 'Sublimeplus_typo_heading',
        'type'        => 'typography',
        'section'     => 'Sublimeplus_typography',
        'title'       => esc_html__('Heading & Title Typography', 'sublimeplus'),
        'description' => esc_html__('Typography for heading', 'sublimeplus'),
        'selector'    => "h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6",
        'css_format'  => 'typography',
        'field_class'=>'no-hide',
        'fields' => array(
            'style' => false,
            'text_decoration' => false,
            'text_transform' => false,
            'font_size' => false,
        ),
        'required'=>['Sublimeplus_use_font','==','google']
    ],

    [
        'name' => 'Sublimeplus_typo_h1_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h1,.h1',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H1 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_h2_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h2,.h2',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H2 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_h3_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h3,.h3',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H3 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_h4_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h4,.h4',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H4 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_h5_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h5,.h5',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H5 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_h6_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => 'h6,.h6',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('H6 Font Size', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_title_loop_blog_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => '.post-loop-item .entry-title',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('Post Loop Title Font Size', 'sublimeplus'),
        'description' => esc_html__('Font size title of post in loop', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_title_single_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => '.title-detail',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('Post Title Font Size', 'sublimeplus'),
        'description' => esc_html__('Font size title of single post', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_widget_title_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector'  => '.widget .widget-title',
        'css_format' => 'font-size: {{value}};',
        'label' => esc_html__('Widget Title Font Size', 'sublimeplus'),
        'description' => esc_html__('Font size title of widget', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_typo_woo_heading',
        'type' => 'heading',
        'label' => esc_html__('WooCommerce Typography', 'sublimeplus'),
        'section' => 'Sublimeplus_typography',
    ],
    [
        'name'        => 'Sublimeplus_typo_woo',
        'type'        => 'typography',
        'section'     => 'Sublimeplus_typography',
        'title'       => esc_html__('WooCommerce Title Typography', 'sublimeplus'),
        'description' => esc_html__('Typography for title product', 'sublimeplus'),
        'selector'    => ".product-loop-title,  .product_title",
        'css_format'  => 'typography',
        'field_class'=>'no-hide',
        'fields' => array(
            'style' => false,
            'text_decoration' => false,
            'text_transform' => false,
            'font_size' => false,
        ),
        'required'=>['Sublimeplus_use_font','==','google']
    ],
    [
        'name' => 'Sublimeplus_typo_product_loop_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'selector' => ".woocommerce ul.products li.product h3.product-loop-title a, .woocommerce ul.products li.product .woocommerce-loop-category__title a",
        'css_format' => 'font-size: {{value}};',
        'theme_supports' => 'woocommerce',
        'label' => esc_html__('Product Font Size', 'sublimeplus'),
        'description' => esc_html__('Font size title of product in loop', 'sublimeplus'),
    ],[
        'name' => 'Sublimeplus_typo_product_single_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_typography',
        'min' => 0,
        'step' => 1,
        'max' => 100,
        'css_format' => 'font-size: {{value}};',
        'selector' => ".woocommerce div.product .product_title",
        'theme_supports' => 'woocommerce',
        'label' => esc_html__('Single Product Font Size', 'sublimeplus'),
        'description' => esc_html__('Font size title of Single Product', 'sublimeplus'),
    ],
];

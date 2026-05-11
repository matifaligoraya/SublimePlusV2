<?php
/**
 * Customize for WooCommerce Style
 */
return [ 
    [
        'name' => 'Sublimeplus_woo_style',
        'type' => 'section',
        'label' => esc_html__('Woocommerce Style', 'sublimeplus'),
        'panel' => 'Sublimeplus_style',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_woo_general_style',
        'type' => 'heading',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('General Style', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_rating_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Rating color', 'sublimeplus'),
        'selector' => 'body #site-main-content .star-rating span::before, .comment-form-rating p.stars:hover a::before, .comment-form-rating p.stars a:hover, .comment-form-rating p.stars a.active::before',
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_woo_price_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Price color', 'sublimeplus'),
        'selector' => '.total .amount, body #site-main-content div.product .summary p.price, body #site-main-content div.product .summary span.price, body #site-main-content ul.products li.product .price, .price, .amount',
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_woo_sale_price_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Sale Price color', 'sublimeplus'),
        'selector' => '.price ins, body #site-main-content ul.products li.product .price ins',
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_woo_regular_price_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Regular Price color', 'sublimeplus'),
        'selector' => '.price del,body #site-main-content ul.products li.product .price del, body #site-main-content div.product .summary p.price del, body #site-main-content div.product .summary span.price del',
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'Sublimeplus_woo_store_notice_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Store Notice Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Store Notice', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body .woocommerce-store-notice.demo_store',
            'normal_link_color' => 'body .woocommerce-store-notice.demo_store a',
            'hover' => 'body .woocommerce-store-notice.demo_store a:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
                'bg_repeat'     => false,
                'bg_attachment' => false,
                'bg_position'   => false,
                'border_heading'   => false,
                'border_width'   => false,
                'border_style'   => false,
                'border_radius'   => false,
                'box_shadow'   => false,
            ),
            'hover_fields' => array(
                'bg_heading'      => false,
                'bg_color'      => false,
                'bg_cover'      => false,
                'bg_image'      => false,
                'bg_repeat'     => false,
                'bg_attachment' => false,
                'bg_position'   => false,
                'border_heading'   => false,
                'border_width'   => false,
                'border_style'   => false,
                'border_radius'   => false,
                'box_shadow'   => false,
            )
        ),
    ],
    [
        'name' => 'Sublimeplus_woo_store_notice_size',
        'type' => 'slider',
        'section' => 'Sublimeplus_woo_style',
        'min' => 0,
        'step' => 1,
        'max' => 50,
        'selector' => "body .woocommerce-store-notice.demo_store",
        'css_format' => 'font-size: {{value}};',
        'theme_supports' => 'woocommerce',
        'label' => esc_html__('Store Notice Font Size', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_shop_loop_style',
        'type' => 'heading',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Shop Loop Item Style', 'sublimeplus'),
        'description' => esc_html__('Style of product item in shop loop', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_shop_loop_title_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Title color', 'sublimeplus'),
        'selector' => '.product .product-loop-title, .products h2body #site-main-content-loop-category__title, body #site-main-content-cart table.cart .product-name a,.products .product .wrap-product-loop-content .wrap-product-loop-detail .product-loop-title a',
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'Sublimeplus_woo_shop_loop_title_color_hover',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Title color hover', 'sublimeplus'),
        'selector' => '.product .product-loop-title:hover, .products h2body #site-main-content-loop-category__title:hover, body #site-main-content-cart table.cart .product-name a:hover,.products .product .wrap-product-loop-content .wrap-product-loop-detail .product-loop-title a:hover',
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'Sublimeplus_woo_shop_loop_cart_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Cart button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for button cart', 'sublimeplus'),
        'selector' => array(
            'normal' => '#site-main-content li.product a.add_to_cart_button,
                        #site-main-content li.product a.product_type_simple',
            'hover' => '#site-main-content li.product a.add_to_cart_button:hover,
                        #site-main-content li.product a.added,
                        #site-main-content li.product a.added_to_cart,
                        #site-main-content li.product a.product_type_simple:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_shop_loop_quick_view_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Quick View button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for button quickview', 'sublimeplus'),
        'selector' => array(
            'normal' => '#site-main-content li.product .btn-quick-view',
            'hover' => '#site-main-content li.product .btn-quick-view:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_shop_loop_sale_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Sale Label Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for sale label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'li.product .onsale',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],
    [
        'name' => 'Sublimeplus_woo_shop_loop_new_label_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('New Label Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for new label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'li.product .sublimeplus-new-label',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],[
        'name' => 'Sublimeplus_woo_shop_loop_out_stock_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Out of Stock Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Out of Stock label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'ul.products li.product .out-stock-label',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],[
        'name' => 'Sublimeplus_woo_shop_loop_low_stock_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Low Stock Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Low Stock label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'ul.products li.product .low-stock-label',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],
    /* Single Product*/
    [
        'name' => 'Sublimeplus_woo_single_product_style',
        'type' => 'heading',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Single Product Style', 'sublimeplus'),
        'description' => esc_html__('Style of single product', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_single_product_title_color',
        'type' => 'color',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Title color', 'sublimeplus'),
        'selector' => 'body #site-main-content div.product .product_title, body #sublimeplus-quickview-lb div.product .product_title',
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'Sublimeplus_woo_single_product_cart_button_styling',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Cart button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for cart button.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #sublimeplus-quickview-lb div.product form.cart .button.single_add_to_cart_button, body #site-main-content div.product form.cart .button.single_add_to_cart_button:not(.sublimeplus-buy-now),.sublimeplus-sticky-add-to-cart .button.button-sticky-add-to-cart,body #site-main-content .sublimeplus-wrap-popup-content a.add_to_cart_button, .sublimeplus-popup-panel a.add_to_cart_button, .sublimeplus-popup-panel .ajax_add_to_cart',

            'hover' => 'body #sublimeplus-quickview-lb div.product form.cart .button.single_add_to_cart_button:hover, body #site-main-content div.product form.cart .button.single_add_to_cart_button:not(.sublimeplus-buy-now):hover, .sublimeplus-sticky-add-to-cart .button-sticky-add-to-cart.added_to_cart,.sublimeplus-sticky-add-to-cart .button.button-sticky-add-to-cart:hover,body #site-main-content .sublimeplus-wrap-popup-content a.add_to_cart_button:hover, .sublimeplus-popup-panel a.add_to_cart_button:hover, .sublimeplus-popup-panel .ajax_add_to_cart:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_single_product_buy_now_button_styling',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Buy now button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for cart buy now button.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content div.product form.cart .button.single_add_to_cart_button.sublimeplus-buy-now',
            'hover' => 'body #site-main-content div.product form.cart .button.single_add_to_cart_button.sublimeplus-buy-now:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_single_product_button_styling',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for button in single product.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body div.product form.cart .button',
            'hover' => 'body div.product form.cart .button :hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],
    // Single product label
    [
        'name' => 'Sublimeplus_woo_single_product_sale_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Sale Label Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for sale label.', 'sublimeplus'),
        'selector' => array(
            'normal' => '.wrap-single-product-content .product .summary .onsale, body #sublimeplus-quickview-lb .product .summary .onsale',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],
    [
        'name' => 'Sublimeplus_woo_single_product_out_stock_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Out of Stock Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Out of Stock label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content .wrap-single-product-content .product .summary .out-of-stock, body #sublimeplus-quickview-lb .product .summary .out-of-stock',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],[
        'name' => 'Sublimeplus_woo_single_product_in_stock_style',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('In Stock Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Low Stock label.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content .wrap-single-product-content .product .summary .in-stock,body #site-main-content .wrap-single-product-content .product .summary .available-on-backorder, body #sublimeplus-quickview-lb .product .summary .in-stock,body #sublimeplus-quickview-lb .product .summary .available-on-backorder',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),
            'hover_fields' => false
        ),
    ],[
        'name' => 'Sublimeplus_woo_single_product_tab_styling',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Tabs Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for tabs control in single product.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content div.product body #site-main-content-tabs ul.tabs li, .tab-heading',
            'hover' => 'body #site-main-content div.product body #site-main-content-tabs ul.tabs li:hover, body #site-main-content div.product body #site-main-content-tabs ul.tabs li.active, .accordion-active .tab-heading, .tab-heading:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],
    //Canvas cart
    [
        'name' => 'Sublimeplus_woo_canvas_cart_checkout_style',
        'type' => 'heading',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Canvas Cart Style', 'sublimeplus'),
        'description' => esc_html__('Style of canvas cart', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_canvas_cart_button',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Cart Button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Cart Button.', 'sublimeplus'),
        'selector' => array(
            'normal' => '.woocommerce-mini-cart__buttons .button.wc-forward:not(.checkout)',
            'hover' => '.woocommerce-mini-cart__buttons .button.wc-forward:not(.checkout):hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_canvas_cart_checkout_button',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Checkout Button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Checkout Button.', 'sublimeplus'),
        'selector' => array(
            'normal' => '.woocommerce-mini-cart__buttons .button.wc-forward.checkout',
            'hover' => '.woocommerce-mini-cart__buttons .button.wc-forward.checkout:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],
    [
        'name' => 'Sublimeplus_woo_cart_checkout_style',
        'type' => 'heading',
        'section' => 'Sublimeplus_woo_style',
        'title' => esc_html__('Cart & Check out Style', 'sublimeplus'),
        'description' => esc_html__('Style of Cart and Checkout page', 'sublimeplus'),
    ],
    [
        'name' => 'Sublimeplus_woo_cart_checkout_primary_button',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Primary Button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Primary Button.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content #respond input#submit.alt, body #site-main-content a.button.alt, body #site-main-content button.button.alt, body #site-main-content input.button.alt',
            'hover' => 'body #site-main-content #respond input#submit.alt:hover, body #site-main-content a.button.alt:hover, body #site-main-content button.button.alt:hover, body #site-main-content input.button.alt:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],[
        'name' => 'Sublimeplus_woo_cart_checkout_second_button',
        'type' => 'styling',
        'section' =>'Sublimeplus_woo_style',
        'title' => esc_html__('Second Button Styling', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for Second Button.', 'sublimeplus'),
        'selector' => array(
            'normal' => 'body #site-main-content #respond input#submit, body #site-main-content a.button, body #site-main-content button.button, body #site-main-content input.button',
            'hover' => 'body #site-main-content #respond input#submit:hover, body #site-main-content a.button:hover, body #site-main-content button.button:hover, body #site-main-content input.button:hover',
        ),
        'css_format' => 'styling',
        'fields' => array(
            'normal_fields' => array(
                'link_color' => false, // disable for special field.
                'link_hover_color' => false, // disable for special field.
                'margin' => false,
                'bg_image' => false,
            ),'hover_fields' => array(
                'link_color' => false, // disable for special field.
            )
        ),
    ],
];

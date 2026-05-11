<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'name'           => 'Sublimeplus_shop_columns_settings',
        'type'           => 'heading',
        'label'          => esc_html__( 'Columns Settings', 'sublimeplus' ),
        'description' => esc_html__( 'Product per page will be sum of Rows per page and Products per row.', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name'        => 'Sublimeplus_shop_cols_tablet',
        'type'        => 'number',
        'label'       => esc_html__( 'Shop loop columns on Tablet', 'sublimeplus' ),
        'section'     => 'woocommerce_product_catalog',
        'unit'        => false,
        'input_attrs' => array(
            'min'   => 1,
            'max'   => 6,
            'class' => 'sublimeplus-range-slider'
        ),
        'default'     => 2,
    ],
    [
        'name'        => 'Sublimeplus_shop_cols_mobile',
        'type'        => 'number',
        'label'       => esc_html__( 'Shop loop columns on Mobile', 'sublimeplus' ),
        'section'     => 'woocommerce_product_catalog',
        'input_attrs' => array(
            'min'   => 1,
            'max'   => 6,
            'class' => 'sublimeplus-range-slider'
        ),
        'default'     => 2,
    ],
    [
        'name'           => 'Sublimeplus_shop_general_settings',
        'type'           => 'heading',
        'label'          => esc_html__( 'General Settings', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'theme_supports' => 'woocommerce',
        'order'=>-1
    ],
    [
        'name'           => 'Sublimeplus_enable_catalog_mod',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Catalog Mod', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Will be enabled if checked.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 0
    ],
    [
        'name'           => 'Sublimeplus_enable_free_shipping_notice',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Free Shipping Notice', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Free shipping thresholds will show in cart if checked.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
    ],
    [
        'name'           => 'Sublimeplus_enable_shop_heading',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Shop Heading', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Display product archive title and description.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
    ],[
        'name'           => 'Sublimeplus_enable_shop_heading_product_count',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Shop Heading Product Count', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Display number of products.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
        'required'    => [ 'Sublimeplus_enable_shop_heading', '==', '1' ],
    ],[
        'name'           => 'Sublimeplus_enable_shop_heading_categories',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Shop Heading Categories', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Display product categories.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
        'required'    => [ 'Sublimeplus_enable_shop_heading', '==', '1' ],
    ],[
        'name'           => 'Sublimeplus_enable_cat_des',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Product Category Description', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Display product description and thumbnail.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
    ],
    [
        'name'        => 'Sublimeplus_shop_banner',
        'type'        => 'image',
        'section'     => 'woocommerce_product_catalog',
        'title'       => esc_html__( 'Shop banner', 'sublimeplus' ),
        'description' => esc_html__( 'Banner image display at top Products page. It will override by Category image.', 'sublimeplus' ),
        'required'    => [ 'Sublimeplus_enable_shop_heading', '==', '1' ],
    ],
    [
        'name'           => 'Sublimeplus_shop_layout_settings',
        'type'           => 'heading',
        'label'          => esc_html__( 'Layout Settings', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name'    => 'Sublimeplus_shop_sidebar',
        'type'    => 'select',
        'section' => 'woocommerce_product_catalog',
        'title'   => esc_html__( 'Shop Sidebar', 'sublimeplus' ),
        'default' => 'left',
        'choices' => [
            'left'       => esc_html__( 'Left', 'sublimeplus' ),
            'right'      => esc_html__( 'Right', 'sublimeplus' ),
            'off-canvas' => esc_html__( 'Off canvas', 'sublimeplus' ),
        ]
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_shop_full_width',
        'label'          => esc_html__( 'Enable Shop Full Width', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '0',
        'checkbox_label' => esc_html__( 'Shop layout will full width if enabled.', 'sublimeplus' ),
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_shop_loop_item_border',
        'label'          => esc_html__( 'Enable Product border', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '0',
        'checkbox_label' => esc_html__( 'Enable border for product item.', 'sublimeplus' ),
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_highlight_featured_product',
        'label'          => esc_html__( 'Enable High light Featured Product', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '0',
        'checkbox_label' => esc_html__( 'Featured product will display bigger more than another product.', 'sublimeplus' ),
    ],
    [
        'type'        => 'number',
        'name'        => 'Sublimeplus_shop_loop_item_gutter',
        'label'       => esc_html__( 'Product Gutter', 'sublimeplus' ),
        'section'     => 'woocommerce_product_catalog',
        'description' => esc_html__( 'White space between product item.', 'sublimeplus' ),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'class' => 'sublimeplus-range-slider'
        ),
        'default'     => 30
    ],
    [
        'name'           => 'Sublimeplus_shop_product_item_settings',
        'type'           => 'heading',
        'label'          => esc_html__( 'Product Item Settings', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'Sublimeplus_product_hover_effect',
        'type' => 'select',
        'section' => 'woocommerce_product_catalog',
        'title' => esc_html__('Hover Effect', 'sublimeplus'),
        'description' => esc_html__('Hover Effect of product item when hover.', 'sublimeplus'),
        'default' => 'default',
        'choices' => [
            'default' => esc_html__('Default', 'sublimeplus'),
            'style-2' => esc_html__('Style 2', 'sublimeplus'),
            'style-3' => esc_html__('Style 3', 'sublimeplus'),
            'style-4' => esc_html__('Style 4', 'sublimeplus'),
            'style-5' => esc_html__('Style 5', 'sublimeplus'),
            'style-6' => esc_html__('Style 6', 'sublimeplus'),
        ]
    ],
    [
        'name'           => 'Sublimeplus_enable_shop_loop_cart',
        'type'           => 'checkbox',
        'section'        => 'woocommerce_product_catalog',
        'label'          => esc_html__( 'Enable Shop Loop Cart', 'sublimeplus' ),
        'checkbox_label' => esc_html__( 'Button Add to cart will show if checked.', 'sublimeplus' ),
        'theme_supports' => 'woocommerce',
        'default'        => 1,
        'required'       => [ 'Sublimeplus_enable_catalog_mod', '!=', 1 ],
    ],
    [
        'name'    => 'Sublimeplus_shop_cart_icon',
        'type'    => 'icon',
        'section' => 'woocommerce_product_catalog',
        'title'   => esc_html__( 'Cart icon', 'sublimeplus' ),
        'default' => [
            'type' => 'sublimeplus-icon',
            'icon' => 'sublimeplus-icon-cart'
        ]
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_alternative_images',
        'label'          => esc_html__( 'Enable Alternative Image', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '1',
        'checkbox_label' => esc_html__( 'Alternative Image will show if checked.', 'sublimeplus' ),
    ],
    [
        'type'    => 'select',
        'name'    => 'Sublimeplus_sale_type',
        'label'   => esc_html__( 'Sale label type display', 'sublimeplus' ),
        'section' => 'woocommerce_product_catalog',
        'default' => 'text',
        'choices' => [
            'numeric' => esc_html__( 'Numeric', 'sublimeplus' ),
            'text'    => esc_html__( 'Text', 'sublimeplus' ),
        ]
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_shop_new_label',
        'label'          => esc_html__( 'Show New Label', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '1',
        'checkbox_label' => esc_html__( 'Stock New will show if checked.', 'sublimeplus' ),
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_shop_stock_label',
        'label'          => esc_html__( 'Show Stock Label', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '1',
        'checkbox_label' => esc_html__( 'Stock label will show if checked.', 'sublimeplus' ),
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_quick_view',
        'label'          => esc_html__( 'Enable Quick View', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '1',
        'checkbox_label' => esc_html__( 'Button quick view will show if checked.', 'sublimeplus' ),
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_enable_shop_loop_rating',
        'label'          => esc_html__( 'Show rating', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => '1',
        'checkbox_label' => esc_html__( 'Show rating in product item if checked.', 'sublimeplus' ),
    ],
    [
        'name'           => 'Sublimeplus_limit_title_shop_loop_settings',
        'type'           => 'heading',
        'label'          => esc_html__( 'Limit Words for Title Shop Loop', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'theme_supports' => 'woocommerce'
    ],
    [
        'type'           => 'number',
        'name'           => 'Sublimeplus_number_limit_title_shop_loop',
        'label'          => esc_html__( 'Number Limit Words', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => 55,
    ],
    [
        'type'           => 'text',
        'name'           => 'Sublimeplus_more_limit_title_shop_loop',
        'label'          => esc_html__( 'Append If Text Needs To Be Trimmed', 'sublimeplus' ),
        'section'        => 'woocommerce_product_catalog',
        'default'        => null,
        'description' => esc_html__( 'Append to the end of the trimmed text, e.g. ….', 'sublimeplus' ),
    ],
    /*Product image thumb for gallery*/
    [
        'name'           => 'Sublimeplus_gallery_thumbnail_heading',
        'type'           => 'heading',
        'label'          => esc_html__( 'Gallery Thumbnail', 'sublimeplus' ),
        'section'        => 'woocommerce_product_images',
        'theme_supports' => 'woocommerce'
    ],
    [
        'type'           => 'number',
        'name'           => 'Sublimeplus_gallery_thumbnail_width',
        'label'          => esc_html__( 'Gallery Thumbnail Width', 'sublimeplus' ),
        'section'        => 'woocommerce_product_images',
        'default'        => '120',
        'description' => esc_html__( 'Max width of image for gallery thumbnail.', 'sublimeplus' ),
    ],
    [
        'type'           => 'number',
        'name'           => 'Sublimeplus_gallery_thumbnail_height',
        'label'          => esc_html__( 'Gallery Thumbnail Height', 'sublimeplus' ),
        'section'        => 'woocommerce_product_images',
        'default'        => '120',
    ],
    [
        'type'           => 'checkbox',
        'name'           => 'Sublimeplus_gallery_thumbnail_crop',
        'label'          => esc_html__( 'Crop', 'sublimeplus' ),
        'section'        => 'woocommerce_product_images',
        'default'        => '0',
        'checkbox_label' => esc_html__( 'Crop Gallery Thumbnail.', 'sublimeplus' ),
    ],
];

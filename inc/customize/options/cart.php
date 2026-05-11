<?php
/**
 * Customize for Shop loop product
 */
return [
	[
		'type'           => 'section',
		'name'           => 'Sublimeplus_cart',
		'title'          => esc_html__( 'Cart Page', 'sublimeplus' ),
		'panel'          => 'woocommerce',
		'theme_supports' => 'woocommerce'
	],
	[
		'name'           => 'Sublimeplus_cart_general_settings',
		'type'           => 'heading',
		'label'          => esc_html__( 'General Settings', 'sublimeplus' ),
		'section'        => 'Sublimeplus_cart',
		'theme_supports' => 'woocommerce'
	],
	[
		'type'        => 'image',
		'name'        => 'Sublimeplus_cart_trust_badges',
		'label'       => esc_html__( 'Trust Badges', 'sublimeplus' ),
		'section'     => 'Sublimeplus_cart',
		'description' => esc_html__( 'Security & trust badges logo on cart & checkout pages.', 'sublimeplus' ),
	],
];

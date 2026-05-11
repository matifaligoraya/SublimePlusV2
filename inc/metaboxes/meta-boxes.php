<?php
/**
 * Meta box for theme
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @core        3.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 */

if ( class_exists( 'RWMB_Loader' ) ):
	add_filter( 'rwmb_meta_boxes', 'Sublimeplus_meta_box_options' );
	if ( ! function_exists( 'Sublimeplus_meta_box_options' ) ) {
		function Sublimeplus_meta_box_options() {
			$Sublimeplus_prefix       = "Sublimeplus_";
			$Sublimeplus_meta_boxes   = array();
			$Sublimeplus_meta_boxes[] = array(
				'id'      => $Sublimeplus_prefix . 'single_post_heading',
				'title'   => esc_html__( 'Post Config', 'sublimeplus' ),
				'pages'   => array( 'post' ),
				'context' => 'side',
				'fields'  => array(
					array(
                        'name'    => esc_html__( 'Post sidebar', 'sublimeplus' ),
						'id'      => $Sublimeplus_prefix . "blog_single_sidebar_config",
						'type'    => 'select',
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'sublimeplus' ),
							'left'    => esc_html__( 'Left', 'sublimeplus' ),
							'right'   => esc_html__( 'Right', 'sublimeplus' ),
							''    => esc_html__( 'None', 'sublimeplus' ),
						),
						'std'     => 'inherit',
						'desc'    => esc_html__( 'Select sidebar layout you want set for this post.', 'sublimeplus' )
					),
                    array(
                        'name'    => esc_html__( 'Header align', 'sublimeplus' ),
						'id'      => $Sublimeplus_prefix . "blog_single_header_align",
						'type'    => 'select',
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'sublimeplus' ),
							'left'    => esc_html__( 'Left', 'sublimeplus' ),
							'center'    => esc_html__( 'Center', 'sublimeplus' ),
							'right'   => esc_html__( 'Right', 'sublimeplus' ),
						),
						'std'     => 'inherit',
						'desc'    => esc_html__( 'Align for header post.', 'sublimeplus' )
					),
                    array(
                        'id'   => $Sublimeplus_prefix . "blog_single_alternate_img",
                        'name' => esc_html__( 'Alternate Image', 'sublimeplus' ),
                        'type' => 'single_image',
                        'desc' => esc_html__( 'Images display in blog page apply only with Masonry Layout', 'sublimeplus' )
                    ),
				)
			);
			//All page
//			$Sublimeplus_meta_boxes[] = array(
//				'id'      => $Sublimeplus_prefix . 'single_product_image_360_heading',
//				'title'   => esc_html__( 'Product image 360 view', 'sublimeplus' ),
//				'pages'   => array( 'product' ),
//				'context' => 'advanced',
//				'fields'  => array(
//					array(
//						'id'   => $Sublimeplus_prefix . "single_product_image_360",
//						'name' => esc_html__( 'Images', 'sublimeplus' ),
//						'type' => 'image_advanced',
//						'desc' => esc_html__( 'Images for 360 degree view.', 'sublimeplus' )
//					),
//				)
//			);
//			$Sublimeplus_meta_boxes[] = array(
//				'id'      => $Sublimeplus_prefix . 'single_product_video_heading',
//				'title'   => esc_html__( 'Product Video', 'sublimeplus' ),
//				'pages'   => array( 'product' ),
//				'context' => 'side',
//				'fields'  => array(
//					array(
//						'id'   => $Sublimeplus_prefix . "single_product_video",
//						'type' => 'oembed',
//						'desc' => esc_html__( 'Enter your embed video url.', 'sublimeplus' )
//					),
//				)
//			);
//
			$Sublimeplus_meta_boxes[] = array(
				'id'      => 'title_meta_box',
				'title'   => esc_html__( 'Layout Options', 'sublimeplus' ),
				'pages'   => array( 'page', 'post' ),
				'context' => 'advanced',
				'fields'  => array(
					array(
						'name' => esc_html__( 'Title & Breadcrumbs Options', 'sublimeplus' ),
						'desc' => esc_html__( '', 'sublimeplus' ),
						'id'   => $Sublimeplus_prefix . "heading_title",
						'type' => 'heading'
					),
					array(
						'name' => esc_html__( 'Disable Title', 'sublimeplus' ),
						'desc' => esc_html__( '', 'sublimeplus' ),
						'id'   => $Sublimeplus_prefix . "disable_title",
						'std'  => '0',
						'type' => 'checkbox'
					),
					array(
						'name' => esc_html__( 'Disable Breadcrumbs', 'sublimeplus' ),
						'desc' => esc_html__( '', 'sublimeplus' ),
						'id'   => $Sublimeplus_prefix . "disable_breadcrumbs",
						'std'  => '0',
						'type' => 'checkbox'
					),
					array(
						'name' => esc_html__( 'Page Layout', 'sublimeplus' ),
						'desc' => esc_html__( '', 'sublimeplus' ),
						'id'   => $Sublimeplus_prefix . "body_heading",
						'type' => 'heading'
					),
					array(
						'name'    => esc_html__( 'Layout Options', 'sublimeplus' ),
						'id'      => $Sublimeplus_prefix . "site_layout",
						'type'    => 'select',
						'options' => array(
							'inherit'    => esc_html__( 'Inherit', 'sublimeplus' ),
							'normal'     => esc_html__( 'Normal', 'sublimeplus' ),
							'boxed'      => esc_html__( 'Boxed', 'sublimeplus' ),
							'full-width' => esc_html__( 'Full Width', 'sublimeplus' ),
						),
						'std'     => 'inherit',
					),
					array(
						'name' => esc_html__( 'Page Max Width', 'sublimeplus' ),
						'desc' => esc_html__( 'Accept only number. If not set, it will follow customize config.', 'sublimeplus' ),
						'id'   => $Sublimeplus_prefix . "site_max_width",
						'type' => 'number'
					),
				)
			);

			return $Sublimeplus_meta_boxes;
		}
	}
endif;
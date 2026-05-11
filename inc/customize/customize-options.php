<?php
/**
 * Import customize style
 *
 * @return Css inline at header.
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2018 SublimePulse
 
 */

// Render css customize
add_action('wp_enqueue_scripts', 'Sublimeplus_customze_options_inline', 99999);

if( !function_exists('Sublimeplus_customze_options_inline')){
    function Sublimeplus_customze_options_inline(){
        wp_add_inline_style('sublimeplus-styles', Sublimeplus_customize_options());
    }
}

if (!function_exists('Sublimeplus_customize_options')) {
    function Sublimeplus_customize_options()
    {
        
        /*===============Theme Customize Style============== */
            $css = null;
            // Accent color
            $Sublimeplus_color_preset           = get_theme_mod('Sublimeplus_color_preset', 'default');

            $Sublimeplus_primary_color          = sanitize_hex_color(get_theme_mod('Sublimeplus_primary_color', '#282828')) ?: '#282828';
            $Sublimeplus_site_color             = sanitize_hex_color(get_theme_mod('Sublimeplus_site_color', '#777')) ?: '#777';
            $Sublimeplus_site_link_color        = sanitize_hex_color(get_theme_mod('Sublimeplus_site_link_color', '#282828')) ?: '#282828';
            $Sublimeplus_site_link_color_hover  = sanitize_hex_color(get_theme_mod('Sublimeplus_site_link_color_hover', '#B8A16B')) ?: '#B8A16B';
            $Sublimeplus_site_heading_color     = sanitize_hex_color(get_theme_mod('Sublimeplus_site_heading_color', '#282828')) ?: '#282828';
            switch ($Sublimeplus_color_preset) {
                case 'black':
                    $Sublimeplus_primary_color          = '#282828';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'blue':
                    $Sublimeplus_primary_color          = '#0000FF';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'red':
                    $Sublimeplus_primary_color          = '#FF0000';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'yellow':
                    $Sublimeplus_primary_color          = '#FFFF00';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'green':
                    $Sublimeplus_primary_color          = '#008000';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'grey':
                    $Sublimeplus_primary_color          = '#808080';
                    $Sublimeplus_site_color             = '#424242';
                    $Sublimeplus_site_link_color        = '#959595';
                    $Sublimeplus_site_link_color_hover  = '#FF3738';
                    $Sublimeplus_site_heading_color     = '#252525';
                    break;
                case 'custom':
                    $Sublimeplus_primary_color          = sanitize_hex_color(get_theme_mod('Sublimeplus_primary_color')) ?: $Sublimeplus_primary_color;
                    $Sublimeplus_site_color             = sanitize_hex_color(get_theme_mod('Sublimeplus_site_color')) ?: $Sublimeplus_site_color;
                    $Sublimeplus_site_link_color        = sanitize_hex_color(get_theme_mod('Sublimeplus_site_link_color')) ?: $Sublimeplus_site_link_color;
                    $Sublimeplus_site_link_color_hover  = sanitize_hex_color(get_theme_mod('Sublimeplus_site_link_color_hover')) ?: $Sublimeplus_site_link_color_hover;
                    $Sublimeplus_site_heading_color     = sanitize_hex_color(get_theme_mod('Sublimeplus_site_heading_color')) ?: $Sublimeplus_site_heading_color;
                    break;
                default:

                    break;
            }

            $css .= ':root{'
                . '--bs-body-color:'.$Sublimeplus_site_color.';'
                . '--bs-link-color:'.$Sublimeplus_site_link_color.';'
                . '--bs-link-hover-color:'.$Sublimeplus_site_link_color_hover.';'
                . '--bs-primary:'.$Sublimeplus_primary_color.';'
                . '--bs-heading-color:'.$Sublimeplus_site_heading_color.';'
            . '}';

            /* Primary color page option */
            if(get_post_meta(get_the_ID(),'Sublimeplus_primary_color', true)){
                $Sublimeplus_primary_color = get_post_meta(get_the_ID(),'Sublimeplus_primary_color', true);
            }
            // Primary color
            $css .= '
                body a,
                .widget ul li .count,
                .widget ul li .count:before,
                .widget ul li .count:after
            
            {color:'.$Sublimeplus_primary_color.'}';
            // Site color
            $css .= '
                body{color:'.$Sublimeplus_site_color.'}';

            // Site link color
            $css .= '
                body a{color:'.$Sublimeplus_site_link_color.'}';

            // Site link hover color
            $css .= '
                body a:hover,
                .post-loop-item .sublimeplus-post-inner .entry-title a:hover,
                .post-loop-item .sublimeplus-post-inner .list-cat a:hover,
                .entry-content a:hover,
                .sidebar.widget-area .widget ul li a:hover,
                .sidebar .widget a:hover
            
            {color:'.$Sublimeplus_site_link_color_hover.'}';

            $css .= '.main-content .error-404 svg{fill:'.$Sublimeplus_primary_color.'}';

            // Button
            $Sublimeplus_button_color = get_theme_mod('Sublimeplus_button_color','#fff');
            $Sublimeplus_button_background_color = get_theme_mod('Sublimeplus_button_background_color','#282828');
            $Sublimeplus_button_border_color = get_theme_mod('Sublimeplus_button_border_color','#282828');

            $Sublimeplus_button_color_hover = get_theme_mod('Sublimeplus_button_color_hover','#fff'); 
            $Sublimeplus_button_background_color_hover = get_theme_mod('Sublimeplus_button_background_color_hover','#B8A16B');
            $Sublimeplus_button_border_color_hover = get_theme_mod('Sublimeplus_button_border_color_hover','#B8A16B');

            if($Sublimeplus_button_color){
                $css .= '
                #sublimeplus-theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #sublimeplus-theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                  
                {color:'.$Sublimeplus_button_color.'}';
            }
            if($Sublimeplus_button_background_color){
                $css .= '
                #sublimeplus-theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #sublimeplus-theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                
                {background:'.$Sublimeplus_button_background_color.'}';
            }
            if($Sublimeplus_button_border_color){
                $css .= '
                #sublimeplus-theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #sublimeplus-theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                
                {border-color:'.$Sublimeplus_button_border_color.'}';
            }
            if($Sublimeplus_button_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover,
                #site-main-content .navigation.pagination .nav-links .page-numbers.current, 
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                   
                {color:'.$Sublimeplus_button_color_hover.'}';
            }
            if($Sublimeplus_button_background_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover,
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                
                {background:'.$Sublimeplus_button_background_color_hover.'}';
            }
            if($Sublimeplus_button_border_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover, 
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #sublimeplus-theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                
                {border-color:'.$Sublimeplus_button_border_color_hover.'}';
            }

            if($Sublimeplus_site_heading_color){
                $css .= '
                h1,h2,h3,h4,h5,h6,
                .h1,.h2,.h3,.h4,.h5,.h6
                
                {color:'.$Sublimeplus_site_heading_color.'}';
            }

            //Main Content
            $Sublimeplus_body_background = get_post_meta(get_the_ID(),'Sublimeplus_body_background', true);
            if( $Sublimeplus_body_background ){
                $css .= '.page-main-content{background: '.$Sublimeplus_body_background.'}';
            }
            if(!get_theme_mod('Sublimeplus_enable_rtl', '1')){
                $css .= '#sublimeplus-theme-dev-actions{display: none}';
            }
            

        /* ==============End Theme Customize Style ===========================*/
        return $css;
    }
}
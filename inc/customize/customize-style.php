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
add_action('wp_enqueue_scripts', 'Sublimeplus_enqueue_render', 1000);
// Enqueue scripts for theme.
function Sublimeplus_enqueue_render()
{
    // Load custom style
    wp_add_inline_style('sublimeplus-base-styles', Sublimeplus_customize_style());
}

if (!function_exists('Sublimeplus_customize_style')) {
    function Sublimeplus_customize_style()
    {
        $css = '';
        /* ----------------------------------------------------------
                                    Typography
                            All typography must add here
        ---------------------------------------------------------- */
        $body_font_family = 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';

        if (get_theme_mod('Sublimeplus_use_font', 'default') == 'default') {
            wp_enqueue_style('Montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');
            $body_font_family = '"Montserrat", sans-serif';
        }

        if (get_theme_mod('Sublimeplus_use_font', 'default') != 'default') {
            $font_name = get_theme_mod('Sublimeplus_typo_new_font_family');
$font_arr = get_theme_mod('Sublimeplus_font_items', []);
            $safe_font_name = addcslashes($font_name, '"');
            foreach ($font_arr as $key => $font) {
                $css .= '@font-face {';
                $css .= 'font-family: "' . $safe_font_name . '";';
                $css .= 'font-weight: ' . $font['weight'] . ';';
                $css .= 'font-style:  ' . $font['style'] . ';';

                $css .= 'src:';
                $arr = array();
                if (!empty($font['woff2'])) {
                    $arr[] = 'url(' . esc_url($font['woff2']) . ") format('woff2')";
                }
                if (!empty($font['woff'])) {
                    $arr[] = 'url(' . esc_url($font['woff']) . ") format('woff')";
                }
                if (!empty($font['ttf'])) {
                    $arr[] = 'url(' . esc_url($font['ttf']) . ") format('truetype')";
                }
                if (!empty($font['svg'])) {
                    $arr[] = 'url(' . esc_url($font['svg']) . '#' . esc_attr(strtolower(str_replace(' ', '_', $font_name))) . ") format('svg')";
                }
                $css .= join(', ', $arr);
                $css .= ';';
                $css .= '}';
            }
            $body_font_family = '"' . $safe_font_name . '", sans-serif';
        }

        $css .= ':root {';
        $css .= '--bs-font-sans-serif: ' . $body_font_family . ';';
        $css .= '--bs-body-font-family: ' . $body_font_family . ';';
        $css .= '--bs-heading-font-family: ' . $body_font_family . ';';
        $css .= '}';

        $css .= 'body {';
        $css .= 'font-family: var(--bs-body-font-family);';
        $css .= 'font-weight: normal;';
        $css .= 'font-style: normal;';
        $css .= 'font-size: 16px;';
        $css .= '}';

        $css .= 'h1,h2,h3,h4,h5,h6 {';
        $css .= 'font-family: var(--bs-heading-font-family);';
        $css .= '}';

        //font-size
        // $css .= "html{";
        // $css .= "font-size: 16px;";
        // $css .= "}";
        // $css .= "body{";
        // $css .= "font-size: 1rem;";
        // $css .= "}";
        /* ----------------------------------------------------------
                                            Responsive control
                                    Control Breakpoint of header Layout
                                    Don't remove this section
                ---------------------------------------------------------- */
        $theme_settings = get_option(Sublimeplus_SETTINGS_KEY, []);
        $mobile_breakpoint = !empty($theme_settings['mobile_breakpoint_width']) ? strval(intval($theme_settings['mobile_breakpoint_width'])) : '992';
        $css .= '@media(min-width: ' . $mobile_breakpoint . 'px) {
                    .wrap-site-header-mobile {
                        display: none;
                    }
                    .show-on-mobile {
                        display: none;
                    }
                }
        
                @media(max-width: ' . $mobile_breakpoint . 'px) {
                    .wrap-site-header-desktop {
                        display: none;
                    }
                    .show-on-desktop {
                        display: none;
                    }
                }
        ';
        $css .= '@media(min-width:1500px){.elementor-section.elementor-section-boxed>.elementor-container,.container{max-width:' . Sublimeplus_site_width() . ';width:100%}}';

        /* ----------------------------------------------------------
                            Menu Alignment
        ---------------------------------------------------------- */
        $menu_alignment = get_theme_mod('Sublimeplus_primary_menu_alignment', 'left');
        if ($menu_alignment !== 'left') {
            $css .= '.primary-menu .nav-menu { display: flex; justify-content: ' . $menu_alignment . '; }';
        }

        /* ----------------------------------------------------------
                            End Responsive control
                    Control Breakpoint of header Layout
                    Don't remove this section
        ---------------------------------------------------------- */
        return $css;
    }
}
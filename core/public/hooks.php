<?php
/**
 * Public Hooks
 *
 * Hooks used on public screens only.
 *
 * @package SublimePulse\Core\Admin
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

 /**
  * Add drop-down icon for menus
  *
  * @see  https://developer.wordpress.org/reference/hooks/nav_menu_item_title/
  */
 add_filter('nav_menu_item_title', function ($title, $item, $args, $depth) {
     // Add custom icon
     $icon = get_post_meta($item->ID, '_menu_item_icon', true);
     if (!empty($icon)) {
         if (strpos($icon, '<svg') === 0) {
             // SVG code - sanitize and allow SVG tags
             $icon_html = wp_kses_post($icon);
         } elseif (filter_var($icon, FILTER_VALIDATE_URL)) {
             // Image URL (including SVG URLs)
             $icon_html = '<img class="nav-icon" src="' . esc_url($icon) . '" alt="" width="18" height="18" aria-hidden="true">';
         } else {
             // Font Awesome or custom class
             $icon_html = '<i class="' . esc_attr($icon) . ' nav-icon" aria-hidden="true"></i>';
         }
         $title = $icon_html . $title;
     }

     if (in_array('menu-item-has-children', $item->classes)) {
         $menu_locations = get_nav_menu_locations();
         if(isset($args->menu->term_id)) {
             if (!empty($menu_locations['primary-menu']) && $menu_locations['primary-menu'] == $args->menu->term_id && !Sublimeplus_customize_get_setting('header_primary_menu_hide_arrow')) {
                 $title .= '<span class="sublimeplus-icon-down"></span>';
             } elseif (!empty($menu_locations['top-menu']) && $menu_locations['top-menu'] == $args->menu->term_id && !Sublimeplus_customize_get_setting('header_top_menu_hide_arrow')) {
                 $title .= '<span class="sublimeplus-icon-down"></span>';
             } elseif (!empty($menu_locations['mobile-menu']) && $menu_locations['mobile-menu'] == $args->menu->term_id && !Sublimeplus_customize_get_setting('header_mobile_menu__hide-arrow')) {
                 $title .= '<span class="sublimeplus-icon-down"></span>';
             }
         }
     }

     return $title;
 }, 25, 4);

/**
 * @see  https://developer.wordpress.org/reference/hooks/wp_head/
 */
add_action('wp_enqueue_scripts', function () {
    $settings = get_option(Sublimeplus_SETTINGS_KEY);

    if (!empty($settings['header_scripts'])) {
        wp_add_inline_script('jquery-core', wp_unslash($settings['header_scripts']));
    }
}, PHP_INT_MAX, 0);

/**
 * @see  https://developer.wordpress.org/reference/hooks/wp_head/
 */
add_action('wp_enqueue_scripts', function () {
    $settings = get_option(Sublimeplus_SETTINGS_KEY);
    if (!empty($settings['footer_scripts'])) {
        wp_add_inline_script('sublimeplus-scripts', wp_unslash($settings['footer_scripts']));
    }
}, PHP_INT_MAX, 0);

/**
 * Enqueue frontend styles and scripts
 */
add_action('wp_enqueue_scripts', function () {
    $Sublimeplus_auto_css = Sublimeplus_Customize_Live_CSS::get_instance();
    $theme_options = get_option(Sublimeplus_SETTINGS_KEY, []);

    unset($theme_options['header_scripts'], $theme_options['footer_scripts']);

    $theme_options['isRtl'] = is_rtl();
    $theme_options['ajaxUrl'] = admin_url('admin-ajax.php');

    wp_enqueue_style('clever-font', SUBLIMEPLUS_URI . 'assets/vendor/cleverfont/style.min.css', [], SUBLIMEPLUS_VERSION);

    if (class_exists('WooCommerce', false)) {
        if(get_theme_mod('Sublimeplus_enable_wishlist','1')){
            wp_enqueue_script('sublimeplus-wishlist', SUBLIMEPLUS_URI . 'core/assets/js/wishlist' . SUBLIMEPLUS_JS_SUFFIX, ['jquery-core'], SUBLIMEPLUS_VERSION, true);
            $add_to_wishlist_icon = get_theme_mod('Sublimeplus_icon_add_to_wishlist', ['type' => 'sublimeplus-icon', 'icon' => 'sublimeplus-icon-heart-o']);
            if ($add_to_wishlist_icon) {
                $add_to_wishlist_icon = '<i class="' . $add_to_wishlist_icon['icon'] . '"></i> ';
            } else {
                $add_to_wishlist_icon = '';
            }
            $browse_to_wishlist_icon = get_theme_mod('Sublimeplus_icon_browse_to_wishlist', ['type' => 'sublimeplus-icon', 'icon' => 'sublimeplus-icon-heart']);
            if ($browse_to_wishlist_icon) {
                $browse_to_wishlist_icon = '<i class="' . $browse_to_wishlist_icon['icon'] . '"></i> ';
            } else {
                $browse_to_wishlist_icon = '';
            }

            wp_localize_script('sublimeplus-wishlist', 'zooWishlistCDATA', [
                'addToWishlist' => get_theme_mod('Sublimeplus_text_add_to_wishlist', esc_html__('Add to Wishlist', 'sublimeplus')),
                'addToWishlistIcon' => $add_to_wishlist_icon,
                'browseWishlist' => get_theme_mod('Sublimeplus_text_browse_to_wishlist', esc_html__('Browse Wishlist', 'sublimeplus')),
                'browseWishlistIcon' => $browse_to_wishlist_icon,
                'addToWishlistErr' => esc_html__('Failed to add the item to Wishlist.', 'sublimeplus'),
                'wishlistIsEmpty' => esc_html__('Wishlist is empty.', 'sublimeplus')
            ]);
        }
        if(get_theme_mod('Sublimeplus_enable_compare','1')) {
            wp_enqueue_script( 'sublimeplus-products-compare', SUBLIMEPLUS_URI . 'core/assets/js/products-compare' . SUBLIMEPLUS_JS_SUFFIX, [ 'jquery-core' ], SUBLIMEPLUS_VERSION, true );
            $add_to_compare_icon = get_theme_mod( 'Sublimeplus_icon_add_to_compare', [
                'type' => 'sublimeplus-icon',
                'icon' => 'sublimeplus-icon-refresh'
            ] );
            if ( $add_to_compare_icon ) {
                $add_to_compare_icon = '<i class="' . $add_to_compare_icon['icon'] . '"></i> ';
            } else {
                $add_to_compare_icon = '';
            }
            $browse_to_compare_icon = get_theme_mod( 'Sublimeplus_icon_browse_to_compare', [
                'type' => 'sublimeplus-icon',
                'icon' => 'sublimeplus-icon-refresh'
            ] );
            if ( $browse_to_compare_icon ) {
                $browse_to_compare_icon = '<i class="' . $browse_to_compare_icon['icon'] . '"></i> ';
            } else {
                $browse_to_compare_icon = '';
            }

            wp_localize_script( 'sublimeplus-products-compare', 'zooProductsCompareCDATA', [
                'addToCompare'      => get_theme_mod( 'Sublimeplus_text_add_to_compare', esc_html__( 'Add to Compare', 'sublimeplus' ) ),
                'addToCompareIcon'  => $add_to_compare_icon,
                'browseCompare'     => get_theme_mod( 'Sublimeplus_text_browse_to_compare', esc_html__( 'Browse Compare', 'sublimeplus' ) ),
                'browseCompareIcon' => $browse_to_compare_icon,
                'addToCompareErr'   => esc_html__( 'Failed to add the item to compare list.', 'sublimeplus' ),
                'compareIsEmpty'    => esc_html__( 'No products to compare.', 'sublimeplus' )
            ] );
        }
    }

    wp_localize_script('jquery-core', 'zooThemeSettings', $theme_options);

    wp_add_inline_style('sublimeplus-styles', $Sublimeplus_auto_css->auto_css());

    if ($google_fonts_url = $Sublimeplus_auto_css->get_font_url()) {
        wp_enqueue_style('sublimeplus-google-fonts', $google_fonts_url, [], SUBLIMEPLUS_VERSION);
    }
}, 10, 0);

if (class_exists('WooCommerce', false)) {
    add_filter('template_include', function ($tpl) {
        global $wp_query;

        $wishlist_page_enable = Sublimeplus_customize_get_setting('Sublimeplus_enable_wishlist_redirect');
        $compare_page_enable = Sublimeplus_customize_get_setting('Sublimeplus_enable_compare_redirect');

        if (!$wp_query->is_main_query()) {
            return $tpl;
        }

        $wishlist_page = get_theme_mod('Sublimeplus_wishlist_page');
        $compare_page = get_theme_mod('Sublimeplus_compare_page');

        if ($wishlist_page_enable && $wishlist_page && $wp_query->is_page($wishlist_page)) {
            return SUBLIMEPLUS_DIR . 'woocommerce/wishlist/my-wishlist.php';
        }

        if ($compare_page_enable && $compare_page && $wp_query->is_page($compare_page)) {
            return SUBLIMEPLUS_DIR . 'woocommerce/compare/my-compare.php';
        }

        return $tpl;
    }, 99);
}
/**
 * @see  https://developer.wordpress.org/reference/hooks/default_title/
 * @see  https://developer.wordpress.org/reference/hooks/default_content/
 * @see  https://developer.wordpress.org/reference/functions/current_filter/
 */
if (function_exists('pll_get_post')) { // make sure that Polylang activated.
    function Sublimeplus_localize_pll_post_content($content, $post)
    {
        $filter = current_filter();
        $from_post = isset($_GET['from_post']) ? (int)$_GET['from_post'] : false;

        if ($content == '') {
            $from_post = get_post($from_post);
            if ($from_post) {
                switch ($filter) {
                    case 'default_content':
                        $content = $from_post->post_content;
                        break;
                    case 'default_title':
                        $content = $from_post->post_title;
                        break;
                    default:
                        $content = apply_filters('Sublimeplus_localize_pll_post_content', $content, $from_post);
                        break;
                }
            }
        }

        return $content;
    }

    add_filter('default_title', 'Sublimeplus_localize_pll_post_content', 100, 2);
    add_filter('default_content', 'Sublimeplus_localize_pll_post_content', 100, 2);
}

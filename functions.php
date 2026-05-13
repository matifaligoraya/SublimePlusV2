<?php
/**
 * Theme functions file
 *
 * @package  sublimeplus
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Load default constants
 *
 * @var  resource
 */
require get_template_directory() . '/core/const.php';

// Bootscore integration — loaded at top level so after_setup_theme hooks register correctly
require get_template_directory() . '/inc/bootscore/navwalker.php';
require get_template_directory() . '/inc/bootscore/navmenu.php';
require get_template_directory() . '/inc/bootscore/widgets.php';
require get_template_directory() . '/inc/bootscore/enqueue.php';
require get_template_directory() . '/inc/bootscore/template-functions.php';
require get_template_directory() . '/inc/bootscore/template-tags.php';
require get_template_directory() . '/inc/bootscore/columns.php';
require get_template_directory() . '/inc/bootscore/pagination.php';
require get_template_directory() . '/inc/bootscore/breadcrumb.php';
require get_template_directory() . '/inc/bootscore/excerpt.php';

/**
 * Check if system meets requirements
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_switch_theme/
 */
function sublimeplus_pre_activation_check($old_theme_name, WP_Theme $old_theme_object)
{
    try {
        if (version_compare(PHP_VERSION, '5.6', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'PHP', '5.6'));
        }

        if (version_compare($GLOBALS['wpdb']->db_version(), '5.0', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security.', 'MySQL', '5.6'));
        }

        if (version_compare($GLOBALS['wp_version'], '5.2', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'WordPress', '5.2'));
        }

        if (!defined('WP_CONTENT_DIR') || !is_writable(WP_CONTENT_DIR)) {
            throw new Exception('WordPress content directory is not writable. Please correct this directory permissions!');
        }
    } catch (Exception $e) {
        $die_msg = sprintf('<h1 class="align-center">'.esc_html__('Theme Activation Error', 'sublimeplus').'</h1><p class="sublimeplus-active-theme-error" >%s</p><p class="align-center"><a href="%s">'.esc_html__('Return to dashboard', 'sublimeplus').'</a></p>', $e->getMessage(), get_admin_url(null, 'index.php'));
        switch_theme($old_theme_object->stylesheet);
        wp_die($die_msg, esc_html__('Theme Activation Error', 'sublimeplus'), 500);
    }

    add_option(Sublimeplus_SETTINGS_KEY, [
        'header_scripts'  => '',
        'footer_scripts'  => '',
        'import_settings' => '',
        'enable_dev_mode' => 0,
        'enable_builtin_mega_menu' => 0,
        'mobile_breakpoint_width' => 992,
    ]);

    if (!is_child_theme()) {
        set_transient('theme_setup_wizard_redirect', '1');
    }
}
add_action('after_switch_theme', 'sublimeplus_pre_activation_check', 10, 2);

/**
 * Setup theme
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_setup_theme/
 */
function sublimeplus_default_setup()
{
    $settings = get_option(Sublimeplus_SETTINGS_KEY);

    register_nav_menus([
        'top-menu'     => esc_html__('Top Menu', 'sublimeplus'),
        'mobile-menu'  => esc_html__('Mobile Menu', 'sublimeplus'),
        'primary-menu' => esc_html__('Primary Menu', 'sublimeplus'),
    ]);

    // Load common resources
    require SUBLIMEPLUS_DIR . 'core/common/functions/filesystem.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/formatting.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/customize.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/layout.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/plugin.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/fonts.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/media.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/theme.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/page.php';
    require SUBLIMEPLUS_DIR . 'core/common/functions/css.php';
    require SUBLIMEPLUS_DIR . 'core/common/hooks.php';
    require SUBLIMEPLUS_DIR . 'core/admin/formatting.php';
    

    // nav-menu.php registers wp_nav_menu_item_custom_fields (admin) and nav_menu_item_title (public)
    require SUBLIMEPLUS_DIR . 'core/public/functions/nav-menu.php';

    // Load admin resources.
    if (is_admin()) {

        require SUBLIMEPLUS_DIR . 'core/admin/functions/menu.php';

        require SUBLIMEPLUS_DIR . 'core/admin/pages/sublimeplus-welcome-page.php';
        require SUBLIMEPLUS_DIR . 'core/admin/pages/sublimeplus-customize-page.php';
        require SUBLIMEPLUS_DIR . 'core/admin/pages/sublimeplus-settings-page.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/class-sublimeplus-wxr-parser.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/class-sublimeplus-wxr-importer.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/class-sublimeplus-customize-importer.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/tgm-plugin-activation.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/class-sublimeplus-demo-importer.php';
        require SUBLIMEPLUS_DIR . 'core/admin/pages/sublimeplus-setup-demo-page.php';
        require SUBLIMEPLUS_DIR . 'core/admin/migration/class-sublimeplus-setup-wizard.php';
        require SUBLIMEPLUS_DIR . 'core/admin/hooks.php';
    } else { // Load public resources.
        //require SUBLIMEPLUS_DIR . 'core/public/megamenu/class-mega-menu-walker.php';
        require SUBLIMEPLUS_DIR . 'core/public/breadcrumb/sublimeplus-breadcrumb.php';
        require SUBLIMEPLUS_DIR . 'core/public/functions/pagination.php';
        require SUBLIMEPLUS_DIR . 'core/public/functions/breadcrumb.php';
        require SUBLIMEPLUS_DIR . 'core/public/hooks.php';
    }

    // Load extra theme functionality.
    require SUBLIMEPLUS_DIR . 'inc/init.php';

    // Load customize resources.
    require SUBLIMEPLUS_DIR . 'core/customize/class-sublimeplus-customize-sanitizer.php';
    require SUBLIMEPLUS_DIR . 'core/customize/class-sublimeplus-customize-live-css.php';
    require SUBLIMEPLUS_DIR . 'core/customize/class-sublimeplus-customizer.php';
}
add_action('after_setup_theme', 'sublimeplus_default_setup', 9, 0);

/**
 * Allow SVG uploads and serving
 */
function sublimeplus_allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'sublimeplus_allow_svg_uploads');

/**
 * Allow SVG in front-end display
 */
function sublimeplus_sanitize_svg($allowed_html, $context) {
    $allowed_html['svg'] = array(
        'xmlns' => true,
        'viewBox' => true,
        'width' => true,
        'height' => true,
        'class' => true,
        'style' => true,
        'fill' => true,
        'stroke' => true,
        'data-*' => true,
    );
    
    $allowed_html['path'] = array(
        'd' => true,
        'fill' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['circle'] = array(
        'cx' => true,
        'cy' => true,
        'r' => true,
        'fill' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['rect'] = array(
        'x' => true,
        'y' => true,
        'width' => true,
        'height' => true,
        'fill' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['line'] = array(
        'x1' => true,
        'y1' => true,
        'x2' => true,
        'y2' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['polyline'] = array(
        'points' => true,
        'fill' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['polygon'] = array(
        'points' => true,
        'fill' => true,
        'stroke' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['text'] = array(
        'x' => true,
        'y' => true,
        'fill' => true,
        'font-size' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['g'] = array(
        'class' => true,
        'style' => true,
        'transform' => true,
        'data-*' => true,
    );
    
    $allowed_html['use'] = array(
        'xlink:href' => true,
        'href' => true,
        'x' => true,
        'y' => true,
        'width' => true,
        'height' => true,
        'class' => true,
        'style' => true,
        'data-*' => true,
    );
    
    $allowed_html['defs'] = array();
    $allowed_html['style'] = array();
    $allowed_html['title'] = array();
    $allowed_html['desc'] = array();
    
    return $allowed_html;
}
add_filter('wp_kses_allowed_html', 'sublimeplus_sanitize_svg', 10, 2);

/**
 * Add body class for pages built with WPBakery so CSS can go full-width.
 */
add_filter('body_class', function ($classes) {
    if (is_singular()) {
        global $post;
        if ($post && has_shortcode($post->post_content, 'vc_row')) {
            $classes[] = 'has-wpb-content';
        }
    }
    return $classes;
});

/**
 * Register Elementor Locations.
 *
 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
 */
function Sublimeplus_register_elementor_locations($elementor_theme_manager) {
	$elementor_theme_manager->register_all_core_location(); // Full support.
}
add_action('elementor/theme/register_locations', 'Sublimeplus_register_elementor_locations');

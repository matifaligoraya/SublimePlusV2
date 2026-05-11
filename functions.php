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
        require SUBLIMEPLUS_DIR . 'core/public/functions/nav-menu.php';
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
 * Register Elementor Locations.
 *
 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
 */
function Sublimeplus_register_elementor_locations($elementor_theme_manager) {
	$elementor_theme_manager->register_all_core_location(); // Full support.
}
add_action('elementor/theme/register_locations', 'Sublimeplus_register_elementor_locations');

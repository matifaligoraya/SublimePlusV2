<?php
/**
 * Admin Hooks
 *
 * Hooks used on admin screens only.
 *
 * @package SublimePulse\Core\Admin
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * @see  https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 */
add_action('admin_enqueue_scripts', function($hook_suffix)
{
    if (isset($_GET['page']) && 'sublimeplus-theme-settings' === $_GET['page']) {
        wp_add_inline_style('dashicons', '#wpcontent{padding-left:0 !important}');
    }

    if (isset($_GET['page']) && 'sublimeplus-theme-setup-demo' === $_GET['page']) {
        wp_add_inline_style('dashicons', '#wpcontent #wpbody #wpbody-content .notice{display:none !important}');
    }

    if ($hook_suffix === 'nav-menus.php') {
        wp_enqueue_media();
        wp_add_inline_script('jquery', "
            jQuery(document).ready(function($) {
                $(document).on('click', '.upload-icon-button', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var input = button.prev('input');
                    var mediaUploader = wp.media({
                        title: 'Select Icon Image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: false
                    });
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        input.val(attachment.url);
                    });
                    mediaUploader.open();
                });
            });
        ");
    }

    wp_enqueue_media();
    wp_enqueue_style('bootstrap', SUBLIMEPLUS_URI.'assets/bootstrap/css/bootstrap.css', array('dashicons'), SUBLIMEPLUS_VERSION);
    wp_enqueue_script('bootstrap-js', SUBLIMEPLUS_URI.'assets/bootstrap/js/bootstrap.bundle.min.js', array('jquery-core'), SUBLIMEPLUS_VERSION);
    wp_enqueue_script('jquery-core');
    wp_enqueue_script('jquery-migrate-js');
    //wp_enqueue_style('bootstrap');
    wp_enqueue_style('sublimeplus-theme-admin', SUBLIMEPLUS_URI.'core/assets/css/admin.min.css', array('dashicons'), SUBLIMEPLUS_VERSION);
//
   // wp_enqueue_script('sublimeplus-theme-admin', SUBLIMEPLUS_URI.'core/assets/js/admin.min.js', array('jquery'), SUBLIMEPLUS_VERSION, true);
    wp_localize_script('sublimeplus-theme-admin', 'zooAdminL10n', [
        'install' => esc_html__('Install', 'sublimeplus'),
        'installing' => esc_html__('Installing...', 'sublimeplus'),
        'installed' => esc_html__('Installed', 'sublimeplus'),
        'uninstall' => esc_html__('Uninstall', 'sublimeplus'),
        'uninstalling' => esc_html__('Uninstalling...', 'sublimeplus')
    ]);
});

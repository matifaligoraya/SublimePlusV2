<?php
/**
 * Sublimeplus_Customize_Page
 *
 * @package SublimePulse\Core\Admin\Classes
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */
final class Sublimeplus_Customize_Page
{
    /**
     * Nope constructor
     */
    private function __construct()
    {

    }

    /**
     * Singleton
     */
    static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new self;
            add_action('admin_menu', [$instance, '_add'], 12);
        }
    }

    /**
     * Add to admin menu
     */
    function _add($context = '')
    {
		Sublimeplus_add_submenu_page(
			Sublimeplus_Welcome_Page::SLUG,
			esc_html__('Theme Customize', 'sublimeplus'),
			esc_html__('Theme Customize', 'sublimeplus'),
			'manage_options',
			admin_url('customize.php')
		);
    }
}
Sublimeplus_Customize_Page::getInstance();

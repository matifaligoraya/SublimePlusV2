<?php
/**
 * Core Constants
 *
 * @package SublimePulse\Core
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Childtheme slug
 *
 * @var  string
 */
define('Sublimeplus_CHILD_THEME_SLUG', get_option('stylesheet', 'SublimePulse-child'));

/**
 * Theme settings key
 *
 * Key to store settings other than theme mods.
 *
 * @var  string
 */
define('Sublimeplus_SETTINGS_KEY', 'sublimeplus_settings_for_' . get_option('template', 'sublimeplus'));

/**
 * Theme version
 *
 * @var  string
 */
define('SUBLIMEPLUS_VERSION', wp_get_theme()->version);
define('MFN_THEME_VERSION', wp_get_theme()->version);
/**
 * Theme base path
 *
 * @var  string
 */
define('SUBLIMEPLUS_DIR', wp_normalize_path(get_template_directory() . '/'));


/**
 * Theme base uri
 *
 * @see  https://google.github.io/styleguide/htmlcssguide.xml?showone=Protocol#Protocol
 *
 * @var  string
 */
define('SUBLIMEPLUS_URI', preg_replace('/^http(s)?:/', '', get_template_directory_uri()) . '/');

/**
 * CSS file suffix
 *
 * @var  string
 */
define('SUBLIMEPLUS_CSS_SUFFIX', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '.css' : '.min.css');

/**
 * JS file suffix
 *
 * @var  string
 */
define('SUBLIMEPLUS_JS_SUFFIX', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '.js' : '.min.js');


/**
 * Theme Logo
 */
if (file_exists(SUBLIMEPLUS_DIR.'assets/images/logo.png')) {
    define('SUBLIMEPLUS_LOGO', SUBLIMEPLUS_URI.'assets/images/logo.png');
} else {
    define('SUBLIMEPLUS_LOGO', admin_url('images/wordpress-logo.svg'));
}
<?php
/**
 * Layout Functionality
 *
 * @package SublimePulse\Core\Common\Functions
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Get registered sidebar id=>name
 *
 * @return  array
 */
function Sublimeplus_get_registered_sidebars()
{
    global $wp_registered_sidebars;

    $sidebar_options = [];

    foreach ($wp_registered_sidebars as $sidebar) {
        $sidebar_options[$sidebar['id']] = $sidebar['name'];
    }

    return $sidebar_options;
}
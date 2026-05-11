<?php
/**
 * Breadcrumb functionality
 *
 * @package    Lib\Functions
 */

/**
* Sublimeplus_breadcrumbs
*/
if (!function_exists('Sublimeplus_breadcrumbs'))
{
    function Sublimeplus_breadcrumbs($home_title = '', $home_icon = '', $sep = '')
    {
        $breadcrumb = new Sublimeplus_Breadcrumb($home_title, $home_icon, $sep);

        $breadcrumb->render($GLOBALS['wp_query']);
    }
}

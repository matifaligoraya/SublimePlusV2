<?php
/**
 * Nav layout — icon-left + optional subtitle
 *
 * Restructures every top-level nav link in the primary nav:
 *   - Pulls any leading <img>/<i>/<svg> icon outside the text wrapper
 *   - Wraps the title text (and optional subtitle) in <span class="sp-nav-label">
 *   - Subtitle comes from WP Admin → Appearance → Menus → Description field
 *     (enable "Description" via Screen Options first)
 *
 * Result without subtitle:
 *   <a>[icon] <span class="sp-nav-label">Title</span></a>
 *
 * Result with subtitle:
 *   <a>[icon] <span class="sp-nav-label">Title <span class="sp-nav-sub">Sub</span></span></a>
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_filter('walker_nav_menu_start_el', function (string $item_output, WP_Post $item, int $depth, stdClass $args): string {

    // Only top-level items in the primary nav
    if ($depth !== 0) {
        return $item_output;
    }

    $location = $args->theme_location ?? '';
    if (!in_array($location, ['main-menu', 'primary-menu'], true)) {
        return $item_output;
    }

    $sub = !empty($item->description)
        ? '<span class="sp-nav-sub">' . esc_html($item->description) . '</span>'
        : '';

    $item_output = preg_replace_callback(
        '/(<a\b[^>]*>)(.*?)(<\/a>)/s',
        function ($m) use ($sub) {
            $open  = $m[1];
            $inner = $m[2];
            $close = $m[3];

            // Extract a leading icon element (img void, or i/svg paired)
            $icon = '';
            if (preg_match('/^\s*(<img\b[^>]*\/?>)/si', $inner, $im)) {
                $icon  = $im[1];
                $inner = ltrim(substr($inner, strlen($im[0])));
            } elseif (preg_match('/^\s*(<(i|svg)\b[^>]*>.*?<\/\2>)/si', $inner, $im)) {
                $icon  = $im[1];
                $inner = ltrim(substr($inner, strlen($im[0])));
            }

            return $open
                . $icon
                . '<span class="sp-nav-label">' . $inner . $sub . '</span>'
                . $close;
        },
        $item_output
    );

    return $item_output;

}, 10, 4);

<?php
/**
 * Precast — site helpers used by templates: default navigation and the
 * approved project filter list. Site-wide hooks live in class-precast-site.php
 * and are registered by Precast::define_public_hooks().
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/** Default main menu when no menu is assigned (Brief: Priority 1 structure). */
function sp_default_nav_items(): array {
    return [
        ['Home',                home_url('/')],
        ['About Us',            sp_page_url('about-us', '/about-us/')],
        ['Products',            get_post_type_archive_link('sp_product') ?: home_url('/products/')],
        ['Projects',            get_post_type_archive_link('sp_project') ?: home_url('/projects/')],
        ['Capabilities',        sp_page_url('capabilities', '/capabilities/')],
        ['Technical Resources', sp_page_url('technical-resources', '/technical-resources/')],
        ['Contact',             sp_page_url('contact-us', '/contact-us/')],
    ];
}

function sp_nav_html(string $class = 'pc-nav'): string {
    $loc = has_nav_menu('main-menu') ? 'main-menu' : (has_nav_menu('primary-menu') ? 'primary-menu' : '');
    if ($loc) {
        $menu = wp_nav_menu([
            'theme_location' => $loc,
            'container'      => false,
            'echo'           => false,
            'fallback_cb'    => '__return_false',
            'items_wrap'     => '<ul class="' . esc_attr($class) . '">%3$s</ul>',
            'depth'          => 2,
        ]);
        if ($menu) return $menu;
    }
    $out = '<ul class="' . esc_attr($class) . '">';
    $cur = trailingslashit(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')));
    foreach (sp_default_nav_items() as [$label, $url]) {
        $active = trailingslashit($url) === $cur ? ' current-menu-item' : '';
        $out .= '<li class="menu-item' . $active . '"><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
    }
    return $out . '</ul>';
}

/** Project archive: reduce excessive filters — only the 6 approved categories (Brief: Priority 9). */
function sp_project_filter_slugs(): array {
    return ['heavy-precast', 'infrastructure', 'industrial', 'security', 'commercial', 'utilities'];
}

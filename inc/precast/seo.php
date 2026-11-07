<?php
/**
 * Precast — SEO: titles, meta descriptions, Open Graph, JSON-LD schema.
 * (Brief: Priority 20, 34, 35)
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/** Resolve the SEO title for the current request. */
function sp_seo_title(): string {
    if (is_front_page()) {
        return get_theme_mod('sp_seo_home_title', 'Precast Concrete Manufacturer UAE | Bunkers, T-Walls & Barriers | Precast Al Turab');
    }
    if (is_singular()) {
        $t = get_post_meta(get_queried_object_id(), '_sp_seo_title', true);
        if ($t) return $t;
        return get_the_title(get_queried_object_id()) . ' | Precast Al Turab';
    }
    if (is_post_type_archive('sp_product')) return 'Precast Concrete Products UAE | Precast Al Turab';
    if (is_post_type_archive('sp_project')) return 'Precast Concrete Projects UAE | Case Studies | Precast Al Turab';
    if (is_tax()) {
        $term = get_queried_object();
        return $term->name . ' UAE | Precast Al Turab';
    }
    if (is_404()) return 'Page Not Found | Precast Al Turab';
    return wp_get_document_title();
}

/** Resolve the meta description. */
function sp_seo_description(): string {
    if (is_front_page()) {
        return get_theme_mod('sp_seo_home_desc', 'Precast Al Turab manufactures reinforced precast concrete products in the UAE including bunkers, T-Walls, barriers, box culverts, chambers and custom precast structures. Request a quotation.');
    }
    if (is_singular()) {
        $id = get_queried_object_id();
        $d  = get_post_meta($id, '_sp_seo_desc', true);
        if ($d) return $d;
        $ex = has_excerpt($id) ? get_the_excerpt($id) : wp_trim_words(wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $id))), 28, '…');
        return $ex ?: get_bloginfo('description');
    }
    if (is_post_type_archive('sp_product')) return 'Standard and custom reinforced precast concrete products manufactured in the UAE: bunkers, T-Walls, barriers, box culverts, U-channels, manholes and custom precast.';
    if (is_post_type_archive('sp_project')) return 'Precast concrete project case studies manufactured in the UAE by Precast Al Turab — heavy precast, infrastructure, industrial, security and utility works.';
    if (is_tax()) {
        $term = get_queried_object();
        return $term->description ?: ($term->name . ' manufactured in the UAE by Precast Al Turab. Request a quotation or send your drawing.');
    }
    return get_bloginfo('description');
}

/** Breadcrumb items used by both the visual breadcrumb and the schema. */
function sp_breadcrumb_items(): array {
    $items = [['name' => 'Home', 'url' => home_url('/')]];
    if (is_singular('sp_product')) {
        $items[] = ['name' => 'Products', 'url' => get_post_type_archive_link('sp_product')];
        $terms = get_the_terms(get_queried_object_id(), 'sp_product_cat');
        if ($terms && !is_wp_error($terms)) $items[] = ['name' => $terms[0]->name, 'url' => get_term_link($terms[0])];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('sp_project')) {
        $items[] = ['name' => 'Projects', 'url' => get_post_type_archive_link('sp_project')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('page') && !is_front_page()) {
        $p = get_queried_object();
        if ($p->post_parent) $items[] = ['name' => get_the_title($p->post_parent), 'url' => get_permalink($p->post_parent)];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('post')) {
        $items[] = ['name' => 'Blog', 'url' => get_permalink(get_option('page_for_posts')) ?: home_url('/blog/')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_post_type_archive('sp_product')) {
        $items[] = ['name' => 'Products', 'url' => get_post_type_archive_link('sp_product')];
    } elseif (is_post_type_archive('sp_project')) {
        $items[] = ['name' => 'Projects', 'url' => get_post_type_archive_link('sp_project')];
    } elseif (is_tax('sp_product_cat')) {
        $items[] = ['name' => 'Products', 'url' => get_post_type_archive_link('sp_product')];
        $items[] = ['name' => get_queried_object()->name, 'url' => get_term_link(get_queried_object())];
    } elseif (is_tax('sp_project_cat')) {
        $items[] = ['name' => 'Projects', 'url' => get_post_type_archive_link('sp_project')];
        $items[] = ['name' => get_queried_object()->name, 'url' => get_term_link(get_queried_object())];
    }
    return $items;
}

/** Visual breadcrumb (also used by templates). */
function sp_breadcrumb_html(): string {
    $items = sp_breadcrumb_items();
    if (count($items) < 2) return '';
    $out = '<nav class="pc-crumb" aria-label="Breadcrumb"><div class="container"><ol>';
    $n = count($items);
    foreach ($items as $i => $it) {
        if ($i === $n - 1) $out .= '<li aria-current="page">' . esc_html($it['name']) . '</li>';
        else $out .= '<li><a href="' . esc_url($it['url']) . '">' . esc_html($it['name']) . '</a></li>';
    }
    return $out . '</ol></div></nav>';
}


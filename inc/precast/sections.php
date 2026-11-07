<?php
/**
 * Precast — section shortcodes + WPBakery elements.
 *
 * Every shortcode renders a template in template-parts/precast/.
 * Defaults follow the Nov-2026 website improvement brief so pages work
 * even with no parameters set.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/** Render template-parts/precast/{slug}.php with $args, safely. */
function sp_pc_render(string $slug, array $args = []): string {
    global $post;
    $sv_post = $post;
    $sv_wpq  = $GLOBALS['wp_query'] ?? null;
    ob_start();
    get_template_part('template-parts/precast/' . $slug, null, $args);
    $out = ob_get_clean();
    if ($sv_wpq) $GLOBALS['wp_query'] = $sv_wpq;
    $post = $sv_post;
    return $out;
}

/** Parse WPBakery param_group → rows (works without WPBakery too). */
function sp_pc_rows($raw): array {
    if (empty($raw)) return [];
    if (is_array($raw)) return $raw;
    if (function_exists('vc_param_group_parse_atts')) {
        $rows = vc_param_group_parse_atts($raw);
        return is_array($rows) ? $rows : [];
    }
    $json = json_decode(urldecode($raw), true);
    return is_array($json) ? $json : [];
}

/** "Lines" textarea → array. */
function sp_pc_lines($raw): array {
    if (is_array($raw)) return $raw;
    $raw = html_entity_decode((string) $raw);
    $lines = preg_split('/\r\n|\r|\n|\|/', $raw);
    return array_values(array_filter(array_map('trim', $lines)));
}

function sp_pc_shortcode_definitions(): array {
    return [
    'sublime_hero_heavy'     => ['tpl' => 'hero',            'atts' => ['bg_image_id' => '', 'heading' => '', 'subheading' => '', 'description' => '', 'formats' => '']],
    'sublime_capability_bar' => ['tpl' => 'capability-bar',  'atts' => ['items' => '']],
    'sublime_systems'        => ['tpl' => 'systems',         'atts' => ['heading' => '', 'subtext' => '', 'cards' => '']],
    'sublime_heavy_feature'  => ['tpl' => 'heavy-feature',   'atts' => ['heading' => '', 'text' => '', 'products' => '', 'btn_text' => '', 'btn_url' => '', 'image_id' => '']],
    'sublime_process'        => ['tpl' => 'process',         'atts' => ['eyebrow' => '', 'heading' => '', 'subtext' => '', 'steps' => '', 'bg' => 'light']],
    'sublime_qaqc'           => ['tpl' => 'qaqc',            'atts' => ['heading' => '', 'subtext' => '', 'steps' => '']],
    'sublime_resources_teaser' => ['tpl' => 'resources-teaser', 'atts' => ['heading' => '', 'subtext' => '']],
    'sublime_final_cta'      => ['tpl' => 'final-cta',       'atts' => ['heading' => '', 'subheading' => '', 'items' => '']],
    'sublime_page_hero'      => ['tpl' => 'page-hero',       'atts' => ['eyebrow' => '', 'heading' => '', 'subtext' => '', 'bg_image_id' => '', 'show_cta' => '1']],
    'sublime_capabilities'   => ['tpl' => 'capabilities',    'atts' => ['blocks' => '']],
    'sublime_tech_resources' => ['tpl' => 'tech-resources',  'atts' => ['docs' => '']],
    'sublime_contact_pc'     => ['tpl' => 'contact',         'atts' => ['heading' => '', 'description' => '']],
    'sublime_why'            => ['tpl' => 'why',             'atts' => ['eyebrow' => '', 'heading' => '', 'subtext' => '', 'items' => '', 'bg' => '']],
    'sublime_featured_projects' => ['tpl' => 'featured-projects', 'atts' => ['heading' => '', 'subtext' => '', 'count' => '4']],
    'sublime_partners'       => ['tpl' => 'partners',        'atts' => ['heading' => '', 'subtext' => '', 'logos' => '']],
    'sublime_about_capabilities' => ['tpl' => 'about-capabilities', 'atts' => ['heading' => '', 'items' => '']],
    'sublime_text_block'     => ['tpl' => 'text-block',      'atts' => ['eyebrow' => '', 'heading' => '', 'image_id' => '', 'img_pos' => 'right', 'cta_text' => '', 'cta_url' => '']],
    ];
}


/** Shared: product card data by slug (used by systems + heavy feature). */
function sp_pc_product_by_slug(string $slug) {
    $p = get_page_by_path($slug, OBJECT, 'sp_product');
    return $p ?: null;
}

/**
 * Product card details (weight / height / strength + stock + lead time), from the
 * `_sp_card` product meta: {"specs":[[label,value],...],"stock":"In Stock","lead":"5–10 Days"}.
 */
function sp_pc_card_data(int $product_id): array {
    if (!$product_id) return [];
    $d = json_decode((string) get_post_meta($product_id, '_sp_card', true), true);
    return is_array($d) ? $d : [];
}
function sp_pc_card_specs_html(int $product_id): string {
    $d = sp_pc_card_data($product_id);
    if (!$d) return '';
    $icons = ['weight' => 'weight', 'height' => 'height', 'strength' => 'box', 'length' => 'length', 'concrete' => 'box', 'wall' => 'layers'];
    $out = '';
    if (!empty($d['specs'])) {
        $out .= '<dl class="pc-cardspec">';
        foreach (array_slice($d['specs'], 0, 3) as $s) {
            $key = strtolower(strtok((string) $s[0], ' '));
            $out .= '<div><span class="pc-cardspec__ic">' . sp_icon($icons[$key] ?? 'box', 18) . '</span><dt>' . esc_html($s[0]) . '</dt><dd>' . esc_html($s[1]) . '</dd></div>';
        }
        $out .= '</dl>';
    }
    if (!empty($d['stock']) || !empty($d['lead'])) {
        $out .= '<div class="pc-cardchips">';
        if (!empty($d['stock'])) {
            $cls = stripos($d['stock'], 'stock') !== false ? 'is-stock' : 'is-order';
            $out .= '<span class="pc-cardchip ' . $cls . '"><i aria-hidden="true"></i>' . esc_html($d['stock']) . '</span>';
        }
        if (!empty($d['lead'])) $out .= '<span class="pc-cardchip">' . sp_icon('truck', 14) . esc_html($d['lead']) . '</span>';
        $out .= '</div>';
    }
    return $out;
}

/** Fallback image for a product-type card (concrete pattern + icon). */
function sp_pc_placeholder(string $icon = 'box', string $label = ''): string {
    return '<div class="pc-ph" aria-hidden="true"><span class="pc-ph__icon">' . sp_icon($icon, 44) . '</span>' . ($label ? '<span class="pc-ph__label">' . esc_html($label) . '</span>' : '') . '</div>';
}

/** Project card (archive, featured, related). */
function sp_pc_project_card(int $pid, bool $featured = false): string {
    $emirate_map = ['dubai' => 'Dubai', 'abu-dhabi' => 'Abu Dhabi', 'sharjah' => 'Sharjah', 'ajman' => 'Ajman', 'ras-al-khaimah' => 'Ras Al Khaimah', 'fujairah' => 'Fujairah', 'umm-al-quwain' => 'Umm Al Quwain', 'western-region' => 'Western Region', 'al-ain' => 'Al Ain', 'uae' => 'UAE'];
    $status_map  = ['completed' => 'Completed', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming'];
    $img   = get_the_post_thumbnail_url($pid, $featured ? 'large' : 'medium_large');
    $prod  = get_post_meta($pid, '_sp_project_product', true);
    if (!$prod) {
        $ids = json_decode((string) get_post_meta($pid, '_sp_project_products', true), true);
        if (is_array($ids) && $ids) $prod = implode(', ', array_filter(array_map('get_the_title', array_slice($ids, 0, 2))));
    }
    $loc   = get_post_meta($pid, '_sp_project_emirate', true);
    $loc   = $emirate_map[$loc] ?? $loc;
    $qty   = get_post_meta($pid, '_sp_project_quantity', true) ?: get_post_meta($pid, '_sp_project_scale', true);
    $date  = get_post_meta($pid, '_sp_project_date', true);
    $year  = $date ? date('Y', strtotime($date)) : '';
    $stat  = get_post_meta($pid, '_sp_project_status', true);
    $stat_label = $status_map[$stat] ?? '';
    $cats  = get_the_terms($pid, 'sp_project_cat');
    $cat_slugs = ($cats && !is_wp_error($cats)) ? implode(' ', wp_list_pluck($cats, 'slug')) : '';
    $cat_name  = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';

    $out  = '<article class="pc-proj-card' . ($featured ? ' pc-proj-card--featured' : '') . '" data-cats="' . esc_attr($cat_slugs) . '">';
    $out .= '<a class="pc-proj-card__media" href="' . esc_url(get_permalink($pid)) . '" tabindex="-1" aria-hidden="true">';
    $out .= $img ? '<img src="' . esc_url($img) . '" alt="' . esc_attr(get_the_title($pid)) . '" loading="lazy" decoding="async">' : sp_pc_placeholder('crane', 'Project photo');
    if ($cat_name) $out .= '<span class="pc-tag">' . esc_html($cat_name) . '</span>';
    if ($stat_label) $out .= '<span class="pc-status pc-status--' . esc_attr($stat) . '">' . esc_html($stat_label) . '</span>';
    $out .= '</a><div class="pc-proj-card__body">';
    $out .= '<h3 class="pc-proj-card__title"><a href="' . esc_url(get_permalink($pid)) . '">' . esc_html(get_the_title($pid)) . '</a></h3>';
    $out .= '<dl class="pc-proj-card__meta">';
    if ($prod) $out .= '<div><dt>Product</dt><dd>' . esc_html($prod) . '</dd></div>';
    if ($loc)  $out .= '<div><dt>Location</dt><dd>' . esc_html($loc) . '</dd></div>';
    if ($qty)  $out .= '<div><dt>Quantity</dt><dd>' . esc_html($qty) . '</dd></div>';
    if ($year) $out .= '<div><dt>Year</dt><dd>' . esc_html($year) . '</dd></div>';
    $out .= '</dl>';
    $out .= '<a class="pc-link" href="' . esc_url(get_permalink($pid)) . '">View Case Study ' . sp_icon('arrow', 16) . '</a>';
    $out .= '</div></article>';
    return $out;
}

/** Product card (archive, related, systems). */
function sp_pc_product_card(int $pid, string $icon = 'box'): string {
    $img = get_the_post_thumbnail_url($pid, 'medium_large');
    $cats = get_the_terms($pid, 'sp_product_cat');
    $cat_name = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';
    $ex = get_the_excerpt($pid);
    $out  = '<article class="pc-prod-card">';
    $out .= '<a class="pc-prod-card__media" href="' . esc_url(get_permalink($pid)) . '" tabindex="-1" aria-hidden="true">';
    $out .= $img ? '<img src="' . esc_url($img) . '" alt="' . esc_attr(get_the_title($pid)) . '" loading="lazy" decoding="async">' : sp_pc_placeholder($icon);
    if ($cat_name) $out .= '<span class="pc-tag">' . esc_html($cat_name) . '</span>';
    $out .= '</a><div class="pc-prod-card__body">';
    $out .= '<h3 class="pc-prod-card__title"><a href="' . esc_url(get_permalink($pid)) . '">' . esc_html(get_the_title($pid)) . '</a></h3>';
    if ($ex) $out .= '<p>' . esc_html(wp_trim_words($ex, 22)) . '</p>';
    $out .= sp_pc_card_specs_html($pid);
    $out .= '<div class="pc-prod-card__actions"><a class="pc-btn pc-btn--sm pc-btn--dark" href="' . esc_url(get_permalink($pid)) . '">View Product</a><a class="pc-btn pc-btn--sm pc-btn--accent" href="' . esc_url(sp_rfq_url(get_the_title($pid))) . '" data-track="rfq_click">Get Quote</a></div>';
    $out .= '</div></article>';
    return $out;
}

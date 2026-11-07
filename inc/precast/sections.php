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

$sp_pc_shortcodes = [
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

foreach ($sp_pc_shortcodes as $tag => $def) {
    add_shortcode($tag, function ($atts, $content = '') use ($tag, $def) {
        $a = shortcode_atts($def['atts'], (array) $atts, $tag);
        $a['content'] = $content;
        return sp_pc_render($def['tpl'], $a);
    });
}

/** WPBakery registration so editors can manage the sections visually. */
add_action('vc_before_init', function () {
    if (!function_exists('vc_map')) return;
    $cat = 'Precast Sections';
    $t = fn($n, $h, $v = '', $g = '') => array_filter(['type' => 'textfield', 'param_name' => $n, 'heading' => $h, 'value' => $v, 'group' => $g]);
    $ta = fn($n, $h, $v = '', $g = '') => array_filter(['type' => 'textarea', 'param_name' => $n, 'heading' => $h, 'value' => $v, 'group' => $g]);
    $img = fn($n, $h) => ['type' => 'attach_image', 'param_name' => $n, 'heading' => $h];

    vc_map(['name' => 'Precast Hero (Heavy)', 'base' => 'sublime_hero_heavy', 'category' => $cat, 'icon' => 'dashicons-superhero', 'params' => [
        $img('bg_image_id', 'Background image (heavy precast photo)'),
        $t('heading', 'Main heading'), $t('subheading', 'Sub heading'), $ta('description', 'Description'), $t('formats', 'Formats line (e.g. PDF • DWG • BOQ)'),
    ]]);
    vc_map(['name' => 'Precast Capability Bar', 'base' => 'sublime_capability_bar', 'category' => $cat, 'icon' => 'dashicons-star-filled', 'params' => [
        ['type' => 'param_group', 'param_name' => 'items', 'heading' => 'Items (leave empty for defaults)', 'params' => [$t('title', 'Title'), $t('icon', 'Icon key (factory, mould, heavy, qa, delivery)')]],
    ]]);
    vc_map(['name' => 'Precast Systems (6 cards)', 'base' => 'sublime_systems', 'category' => $cat, 'icon' => 'dashicons-grid-view', 'params' => [
        $t('heading', 'Heading'), $ta('subtext', 'Subtitle'),
        ['type' => 'param_group', 'param_name' => 'cards', 'heading' => 'Cards (leave empty for defaults)', 'params' => [$t('title', 'Title'), $ta('desc', 'Description'), $t('btn_text', 'Button text'), $t('link', 'Link URL'), $img('image_id', 'Image'), $t('icon', 'Icon key')]],
    ]]);
    vc_map(['name' => 'Precast Heavy Feature', 'base' => 'sublime_heavy_feature', 'category' => $cat, 'icon' => 'dashicons-building', 'params' => [
        $t('heading', 'Heading'), $ta('text', 'Text'), $ta('products', 'Products (one per line)'), $t('btn_text', 'Button text'), $t('btn_url', 'Button URL'), $img('image_id', 'Image'),
    ]]);
    vc_map(['name' => 'Precast Process (8 steps)', 'base' => 'sublime_process', 'category' => $cat, 'icon' => 'dashicons-controls-forward', 'params' => [
        $t('eyebrow', 'Eyebrow'), $t('heading', 'Heading'), $ta('subtext', 'Subtext'),
        ['type' => 'dropdown', 'param_name' => 'bg', 'heading' => 'Background', 'value' => ['Light' => 'light', 'Dark' => 'dark']],
        ['type' => 'param_group', 'param_name' => 'steps', 'heading' => 'Steps (leave empty for defaults)', 'params' => [$t('title', 'Title'), $ta('desc', 'Description'), $t('icon', 'Icon key')]],
    ]]);
    vc_map(['name' => 'Precast QA/QC', 'base' => 'sublime_qaqc', 'category' => $cat, 'icon' => 'dashicons-yes-alt', 'params' => [$t('heading', 'Heading'), $ta('subtext', 'Subtext'), $ta('steps', 'Steps (one per line)')]]);
    vc_map(['name' => 'Precast Resources Teaser', 'base' => 'sublime_resources_teaser', 'category' => $cat, 'icon' => 'dashicons-media-document', 'params' => [$t('heading', 'Heading'), $ta('subtext', 'Subtext')]]);
    vc_map(['name' => 'Precast Final CTA', 'base' => 'sublime_final_cta', 'category' => $cat, 'icon' => 'dashicons-megaphone', 'params' => [$t('heading', 'Heading'), $t('subheading', 'Sub heading'), $ta('items', 'Review items (one per line)')]]);
    vc_map(['name' => 'Precast Page Hero', 'base' => 'sublime_page_hero', 'category' => $cat, 'icon' => 'dashicons-align-wide', 'params' => [$t('eyebrow', 'Eyebrow'), $t('heading', 'H1 heading'), $ta('subtext', 'Subtext'), $img('bg_image_id', 'Background image'), ['type' => 'checkbox', 'param_name' => 'show_cta', 'heading' => 'Show CTA buttons', 'value' => ['Yes' => '1']]]]);
    vc_map(['name' => 'Precast Capabilities Page', 'base' => 'sublime_capabilities', 'category' => $cat, 'icon' => 'dashicons-admin-tools', 'params' => [
        ['type' => 'param_group', 'param_name' => 'blocks', 'heading' => 'Blocks (leave empty for defaults)', 'params' => [$t('title', 'Title'), $ta('desc', 'Description'), $t('icon', 'Icon key'), $img('image_id', 'Photo')]],
    ]]);
    vc_map(['name' => 'Precast Technical Resources', 'base' => 'sublime_tech_resources', 'category' => $cat, 'icon' => 'dashicons-download', 'params' => [
        ['type' => 'param_group', 'param_name' => 'docs', 'heading' => 'Documents', 'params' => [$t('title', 'Title'), $ta('desc', 'Description'), $t('category', 'Category (Company, Product Data Sheets, Technical Documents, Certificates)'), ['type' => 'attach_image', 'param_name' => 'file_id', 'heading' => 'File (choose PDF in media library)'], $t('expiry', 'Expiry date (YYYY-MM-DD, certificates only)')]],
    ]]);
    vc_map(['name' => 'Precast Contact Page', 'base' => 'sublime_contact_pc', 'category' => $cat, 'icon' => 'dashicons-phone', 'params' => [$t('heading', 'Heading'), $ta('description', 'Description')]]);
    vc_map(['name' => 'Precast Why Choose Us', 'base' => 'sublime_why', 'category' => $cat, 'icon' => 'dashicons-thumbs-up', 'params' => [$t('heading', 'Heading'), $ta('subtext', 'Subtext'),
        ['type' => 'param_group', 'param_name' => 'items', 'heading' => 'Items (leave empty for defaults)', 'params' => [$t('title', 'Title'), $ta('desc', 'Description'), $t('icon', 'Icon key')]]]]);
    vc_map(['name' => 'Precast Featured Projects', 'base' => 'sublime_featured_projects', 'category' => $cat, 'icon' => 'dashicons-portfolio', 'params' => [$t('heading', 'Heading'), $ta('subtext', 'Subtext'), $t('count', 'Number of projects', '4')]]);
    vc_map(['name' => 'Precast Clients & Partners', 'base' => 'sublime_partners', 'category' => $cat, 'icon' => 'dashicons-groups', 'params' => [$t('heading', 'Heading'), $ta('subtext', 'Subtext'),
        ['type' => 'param_group', 'param_name' => 'logos', 'heading' => 'Logos (only verified clients)', 'params' => [$t('name', 'Name'), $img('image_id', 'Logo')]]]]);
    vc_map(['name' => 'Precast About Capabilities', 'base' => 'sublime_about_capabilities', 'category' => $cat, 'icon' => 'dashicons-list-view', 'params' => [$t('heading', 'Heading'), $ta('items', 'Items (one per line)')]]);
    vc_map(['name' => 'Precast Text Block', 'base' => 'sublime_text_block', 'category' => $cat, 'icon' => 'dashicons-text', 'params' => [$t('eyebrow', 'Eyebrow'), $t('heading', 'Heading'), ['type' => 'textarea_html', 'param_name' => 'content', 'heading' => 'Content'], $img('image_id', 'Image'), ['type' => 'dropdown', 'param_name' => 'img_pos', 'heading' => 'Image position', 'value' => ['Right' => 'right', 'Left' => 'left']], $t('cta_text', 'CTA text'), $t('cta_url', 'CTA URL')]]);
    vc_map(['name' => 'Precast RFQ Form', 'base' => 'sublime_rfq_form', 'category' => $cat, 'icon' => 'dashicons-forms', 'params' => [$t('heading', 'Heading', 'Request a Precast Quotation'), $ta('subtext', 'Subtext'), ['type' => 'checkbox', 'param_name' => 'compact', 'heading' => 'Compact layout', 'value' => ['Yes' => '1']]]]);
});

/** Tell page.php these tags are full-width layouts too. */
add_filter('sp_fullwidth_shortcodes', function ($tags) use ($sp_pc_shortcodes) {
    return array_merge($tags, array_keys($sp_pc_shortcodes), ['sublime_rfq_form']);
});

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

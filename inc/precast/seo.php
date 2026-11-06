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

add_filter('pre_get_document_title', function ($title) {
    $t = sp_seo_title();
    return $t ?: $title;
}, 20);

/** Meta description + Open Graph. */
add_action('wp_head', function () {
    $desc  = sp_seo_description();
    $title = sp_seo_title();
    $url   = is_singular() ? get_permalink(get_queried_object_id()) : home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));
    $img   = '';
    if (is_singular() && has_post_thumbnail(get_queried_object_id())) {
        $img = get_the_post_thumbnail_url(get_queried_object_id(), 'large');
    }
    if (!$img) {
        $logo_id = get_theme_mod('custom_logo');
        $img = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    }
    echo "\n<meta name=\"description\" content=\"" . esc_attr($desc) . "\">\n";
    echo '<meta property="og:site_name" content="Precast Al Turab">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular('post') ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(trailingslashit($url)) . '">' . "\n";
    if ($img) echo '<meta property="og:image" content="' . esc_url($img) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    if (is_404() || is_search()) echo '<meta name="robots" content="noindex,follow">' . "\n";
}, 1);

/** Canonical for archives/tax (WP core only adds it for singular). */
add_action('wp_head', function () {
    if (is_singular()) return;
    $url = '';
    if (is_front_page())                      $url = home_url('/');
    elseif (is_post_type_archive())           $url = get_post_type_archive_link(get_post_type());
    elseif (is_tax() || is_category())        $url = get_term_link(get_queried_object());
    if ($url && !is_wp_error($url)) {
        $paged = get_query_var('paged');
        if ($paged > 1) $url = trailingslashit($url) . 'page/' . (int) $paged . '/';
        echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
    }
}, 2);

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

/** JSON-LD schema. */
add_action('wp_head', function () {
    $c = sp_company();
    $logo_id = get_theme_mod('custom_logo');
    $logo = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $graph = [];

    $org = [
        '@type' => ['Organization', 'LocalBusiness'],
        '@id'   => home_url('/#organization'),
        'name'  => $c['name'],
        'legalName' => $c['legal'],
        'url'   => home_url('/'),
        'telephone' => $c['phone_tel'],
        'email' => $c['email'],
        'description' => 'UAE precast concrete manufacturer of bunkers, T-Walls, barriers, box culverts, chambers and custom reinforced precast products.',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress'   => 'MAZYAD Offices 2, 75 Sultan Bin Mohammed Al Qubaisi St (Street 207), Mohamed Bin Zayed City',
            'addressLocality' => 'Abu Dhabi',
            'postalCode'      => '20614',
            'addressCountry'  => 'AE',
        ],
        'areaServed' => ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain'],
        'openingHours' => 'Mo-Sa 08:00-18:00',
    ];
    if ($logo) $org['logo'] = $logo;
    $same = array_filter([$c['linkedin'], $c['instagram'], $c['facebook']]);
    if ($same) $org['sameAs'] = array_values($same);
    $graph[] = $org;

    $graph[] = [
        '@type' => 'WebSite',
        '@id'   => home_url('/#website'),
        'url'   => home_url('/'),
        'name'  => $c['name'],
        'publisher' => ['@id' => home_url('/#organization')],
    ];

    $crumbs = sp_breadcrumb_items();
    if (count($crumbs) > 1) {
        $list = [];
        foreach ($crumbs as $i => $it) {
            $list[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $it['name'], 'item' => $it['url']];
        }
        $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $list];
    }

    if (is_singular('sp_product')) {
        $id = get_queried_object_id();
        $product = [
            '@type' => 'Product',
            'name'  => get_the_title($id),
            'description' => sp_seo_description(),
            'brand' => ['@type' => 'Brand', 'name' => $c['name']],
            'manufacturer' => ['@id' => home_url('/#organization')],
            'url'   => get_permalink($id),
        ];
        if (has_post_thumbnail($id)) $product['image'] = get_the_post_thumbnail_url($id, 'large');
        $graph[] = $product;

        $faqs_raw = get_post_meta($id, '_sp_faqs', true);
        $faqs = $faqs_raw ? json_decode($faqs_raw, true) : [];
        if (is_array($faqs) && $faqs) {
            $q = [];
            foreach ($faqs as $f) {
                if (empty($f[0]) || empty($f[1])) continue;
                $q[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
            }
            if ($q) $graph[] = ['@type' => 'FAQPage', 'mainEntity' => $q];
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}, 5);

/** Customizer: homepage SEO. */
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('sp_seo', ['title' => 'Precast — Homepage SEO', 'priority' => 6]);
    $wp_customize->add_setting('sp_seo_home_title', ['sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('sp_seo_home_title', ['section' => 'sp_seo', 'label' => 'Homepage SEO title', 'type' => 'text']);
    $wp_customize->add_setting('sp_seo_home_desc', ['sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('sp_seo_home_desc', ['section' => 'sp_seo', 'label' => 'Homepage meta description', 'type' => 'textarea']);
});

/** Make sure images in post content get alt text fallback + lazy loading. */
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment) {
    if (empty($attr['alt'])) $attr['alt'] = get_the_title($attachment->ID);
    return $attr;
}, 10, 2);

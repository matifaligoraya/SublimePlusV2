<?php
/**
 * Precast Al Turab — SEO output: document title, meta description, Open
 * Graph, canonical, JSON-LD schema, image alt fallback, homepage SEO settings.
 * Hooks are registered in Precast::define_*_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_SEO {

    /** pre_get_document_title @20 */
    public function document_title($title) {
        $t = sp_seo_title();
        return $t ?: $title;
    }

    /** Meta description + Open Graph. wp_head @1 */
    public function head_meta() {
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
    }

    /** Canonical for archives / taxonomies (core only adds it for singular). wp_head @2 */
    public function canonical() {
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
    }

    /** JSON-LD: Organization/LocalBusiness, WebSite, BreadcrumbList, Product, FAQPage. wp_head @5 */
    public function schema() {
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
            'hasMap' => $c['factory_map_url'],
            'location' => [
                '@type' => 'Place',
                'name'  => 'Precast Al Turab Factory',
                'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Al Sajaa Industrial Area', 'addressLocality' => 'Sharjah', 'addressCountry' => 'AE'],
                'geo'   => ['@type' => 'GeoCoordinates', 'latitude' => $c['factory_lat'], 'longitude' => $c['factory_lng']],
                'hasMap' => $c['factory_map_url'],
            ],
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
    }

    /** Customizer: homepage SEO title + description. customize_register */
    public function customize_register($wp_customize) {
        $wp_customize->add_section('sp_seo', ['title' => 'Precast — Homepage SEO', 'priority' => 6]);
        $wp_customize->add_setting('sp_seo_home_title', ['sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('sp_seo_home_title', ['section' => 'sp_seo', 'label' => 'Homepage SEO title', 'type' => 'text']);
        $wp_customize->add_setting('sp_seo_home_desc', ['sanitize_callback' => 'sanitize_textarea_field']);
        $wp_customize->add_control('sp_seo_home_desc', ['section' => 'sp_seo', 'label' => 'Homepage meta description', 'type' => 'textarea']);
    }

    /** Alt text fallback for images. wp_get_attachment_image_attributes (2 args) */
    public function image_alt_fallback($attr, $attachment) {
        if (empty($attr['alt'])) $attr['alt'] = get_the_title($attachment->ID);
        return $attr;
    }
}

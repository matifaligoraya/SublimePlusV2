<?php
/**
 * WPBakery Page Builder — Sublime homepage section elements
 *
 * Registers six drag-and-drop elements under the "Sublime Sections" category.
 * Each maps directly to a template part in template-parts/home/.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!defined('WPB_VC_VERSION')) return;

// ─── Helpers ─────────────────────────────────────────────────────────────────

/**
 * Decode a WPBakery param_group value and resolve any 'image_id' keys to URLs.
 *
 * @param  string $raw       The URL-encoded JSON string from the shortcode attribute.
 * @param  string $img_size  WP image size to use when resolving attachment IDs.
 * @return array             Array of associative arrays, one per repeating row.
 */
function _sublime_parse_group($raw, $img_size = 'medium_large') {
    if (empty($raw)) return [];
    $rows = vc_param_group_parse_atts($raw);
    if (empty($rows) || !is_array($rows)) return [];

    return array_map(function ($row) use ($img_size) {
        if (!empty($row['image_id'])) {
            $row['img'] = wp_get_attachment_image_url((int) $row['image_id'], $img_size) ?: '';
            unset($row['image_id']);
        }
        return $row;
    }, $rows);
}

/**
 * Render a homepage template part and return as a string.
 *
 * WPBakery executes shortcodes during an early hook before the page template
 * calls the_post(). Nested WP_Query objects (products, blog) can corrupt
 * $wp_query->posts via pre_get_posts / the_posts hooks. We snapshot and
 * restore the complete global query state around every render call.
 */
function _sublime_render_part($slug, array $atts) {
    global $post;

    // Snapshot
    $sv_wp_query     = $GLOBALS['wp_query']     ?? null;
    $sv_wp_the_query = $GLOBALS['wp_the_query'] ?? null;
    $sv_posts        = isset($sv_wp_query->posts)        ? $sv_wp_query->posts        : null;
    $sv_post_obj     = isset($sv_wp_query->post)         ? $sv_wp_query->post         : null;
    $sv_current      = isset($sv_wp_query->current_post) ? $sv_wp_query->current_post : -1;
    $sv_in_loop      = isset($sv_wp_query->in_the_loop)  ? $sv_wp_query->in_the_loop  : false;
    $sv_global_post  = $post;

    $args = array_filter($atts, function ($v) {
        return $v !== '' && $v !== null && $v !== [];
    });
    ob_start();
    get_template_part('template-parts/home/' . $slug, null, $args);
    $output = ob_get_clean();

    // Restore
    if ($sv_wp_query !== null) {
        $GLOBALS['wp_query']           = $sv_wp_query;
        $sv_wp_query->posts            = $sv_posts;
        $sv_wp_query->post             = $sv_post_obj;
        $sv_wp_query->current_post     = $sv_current;
        $sv_wp_query->in_the_loop      = $sv_in_loop;
    }
    if ($sv_wp_the_query !== null) {
        $GLOBALS['wp_the_query'] = $sv_wp_the_query;
    }
    $post = $sv_global_post;

    return $output;
}

// ─── Shortcode callbacks ──────────────────────────────────────────────────────

// Hero
function sublime_shortcode_hero($atts) {
    $atts = shortcode_atts([
        'badge'       => '',
        'title_top'   => '',
        'title_bot'   => '',
        'description' => '',
        'btn1_text'   => '',
        'btn1_url'    => '',
        'btn2_text'   => '',
        'btn2_url'    => '',
        'bg_image_id' => '',
    ], $atts, 'sublime_hero');

    return _sublime_render_part('hero', $atts);
}
add_shortcode('sublime_hero', 'sublime_shortcode_hero');

// Certificates ticker
function sublime_shortcode_certificates($atts) {
    $atts = shortcode_atts([
        'items' => '',
    ], $atts, 'sublime_certificates');

    $args = [];
    $rows = _sublime_parse_group($atts['items'], 'thumbnail');
    if (!empty($rows)) {
        // Normalise: 'main' and 'sub' come straight from the group; 'alt' derived from 'main'
        $args['items'] = array_map(function ($r) {
            return [
                'img'  => $r['img']  ?? '',
                'main' => $r['main'] ?? '',
                'sub'  => $r['sub']  ?? '',
                'alt'  => $r['main'] ?? '',
            ];
        }, $rows);
    }

    return _sublime_render_part('approvals', $args);
}
add_shortcode('sublime_certificates', 'sublime_shortcode_certificates');

// Clients / logos
function sublime_shortcode_clients($atts) {
    $atts = shortcode_atts([
        'heading' => '',
        'subtext' => '',
        'clients' => '',
    ], $atts, 'sublime_clients');

    $args = [
        'heading' => $atts['heading'],
        'subtext' => $atts['subtext'],
    ];

    $rows = _sublime_parse_group($atts['clients'], 'medium');
    if (!empty($rows)) {
        $args['clients'] = array_map(function ($r) {
            return [
                'name' => $r['name'] ?? '',
                'url'  => $r['img']  ?? '',
            ];
        }, $rows);
    }

    return _sublime_render_part('clients', $args);
}
add_shortcode('sublime_clients', 'sublime_shortcode_clients');

// Products catalogue
function sublime_shortcode_products($atts) {
    $atts = shortcode_atts([
        'heading'  => '',
        'subtext'  => '',
        'cta_text' => '',
        'cta_url'  => '',
    ], $atts, 'sublime_products');

    return _sublime_render_part('products', $atts);
}
add_shortcode('sublime_products', 'sublime_shortcode_products');

// Supply capability
function sublime_shortcode_supply($atts) {
    $atts = shortcode_atts([
        'heading' => '',
        'subtext' => '',
        'cards'   => '',
    ], $atts, 'sublime_supply');

    $args = [
        'heading' => $atts['heading'],
        'subtext' => $atts['subtext'],
    ];

    $rows = _sublime_parse_group($atts['cards'], 'medium_large');
    if (!empty($rows)) {
        $args['cards'] = array_map(function ($r) {
            return [
                'img'   => $r['img']   ?? '',
                'title' => $r['title'] ?? '',
                'desc'  => $r['desc']  ?? '',
            ];
        }, $rows);
    }

    return _sublime_render_part('supply', $args);
}
add_shortcode('sublime_supply', 'sublime_shortcode_supply');

// Blog / insights
function sublime_shortcode_blog($atts) {
    $atts = shortcode_atts([
        'heading'  => '',
        'subtext'  => '',
        'cta_text' => '',
        'cta_url'  => '',
    ], $atts, 'sublime_blog');

    return _sublime_render_part('blog', $atts);
}
add_shortcode('sublime_blog', 'sublime_shortcode_blog');

// ─── WPBakery element registration ───────────────────────────────────────────

function sublime_register_vc_elements() {

    // ── Hero ─────────────────────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Hero', 'sublimeplus'),
        'base'        => 'sublime_hero',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-superhero',
        'description' => __('Full-width hero with background image, headline, description, and two CTA buttons.', 'sublimeplus'),
        'params'      => [
            [
                'type'        => 'attach_image',
                'heading'     => __('Background Image', 'sublimeplus'),
                'param_name'  => 'bg_image_id',
                'description' => __('Leave empty to use the homepage featured image or Customizer setting.', 'sublimeplus'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('Badge / Label', 'sublimeplus'),
                'param_name'  => 'badge',
                'value'       => '',
                'description' => __('Small pill above the headline. HTML allowed (e.g. &lt;strong&gt;).', 'sublimeplus'),
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('Headline — Top Line', 'sublimeplus'),
                'param_name' => 'title_top',
                'value'      => '',
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('Headline — Bottom Line', 'sublimeplus'),
                'param_name' => 'title_bot',
                'value'      => '',
            ],
            [
                'type'       => 'textarea',
                'heading'    => __('Description', 'sublimeplus'),
                'param_name' => 'description',
                'value'      => '',
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('Button 1 — Label', 'sublimeplus'),
                'param_name' => 'btn1_text',
                'value'      => '',
                'group'      => __('Buttons', 'sublimeplus'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('Button 1 — URL', 'sublimeplus'),
                'param_name'  => 'btn1_url',
                'value'       => '',
                'description' => __('Paste a full URL or relative path.', 'sublimeplus'),
                'group'       => __('Buttons', 'sublimeplus'),
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('Button 2 — Label', 'sublimeplus'),
                'param_name' => 'btn2_text',
                'value'      => '',
                'group'      => __('Buttons', 'sublimeplus'),
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('Button 2 — URL', 'sublimeplus'),
                'param_name' => 'btn2_url',
                'value'      => '',
                'group'      => __('Buttons', 'sublimeplus'),
            ],
        ],
    ]);

    // ── Certificates Ticker ───────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Certificates', 'sublimeplus'),
        'base'        => 'sublime_certificates',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-awards',
        'description' => __('Infinite-scroll certificates and authority approvals ticker bar.', 'sublimeplus'),
        'params'      => [
            [
                'type'        => 'param_group',
                'heading'     => __('Certificate Items', 'sublimeplus'),
                'param_name'  => 'items',
                'description' => __('Leave empty to use the theme defaults (RTA, ISO, ICV, etc.). Each row appears once in the scrolling ticker.', 'sublimeplus'),
                'value'       => '',
                'params'      => [
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Main Text', 'sublimeplus'),
                        'param_name' => 'main',
                        'value'      => '',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Sub Text', 'sublimeplus'),
                        'param_name' => 'sub',
                        'value'      => '',
                    ],
                    [
                        'type'        => 'attach_image',
                        'heading'     => __('Icon / Logo', 'sublimeplus'),
                        'param_name'  => 'image_id',
                        'description' => __('Small authority or certification logo (recommended: 80×80 px).', 'sublimeplus'),
                    ],
                ],
            ],
        ],
    ]);

    // ── Clients / Logos ───────────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Clients', 'sublimeplus'),
        'base'        => 'sublime_clients',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-groups',
        'description' => __('Trusted-by section with a client logo grid.', 'sublimeplus'),
        'params'      => [
            [
                'type'       => 'textfield',
                'heading'    => __('Section Heading', 'sublimeplus'),
                'param_name' => 'heading',
                'value'      => '',
            ],
            [
                'type'       => 'textarea',
                'heading'    => __('Sub-text', 'sublimeplus'),
                'param_name' => 'subtext',
                'value'      => '',
            ],
            [
                'type'        => 'param_group',
                'heading'     => __('Client Logos', 'sublimeplus'),
                'param_name'  => 'clients',
                'description' => __('Leave empty to use the theme default logo list. Add rows here to replace them entirely.', 'sublimeplus'),
                'value'       => '',
                'params'      => [
                    [
                        'type'        => 'textfield',
                        'heading'     => __('Client Name', 'sublimeplus'),
                        'param_name'  => 'name',
                        'value'       => '',
                        'admin_label' => true,
                        'description' => __('Used as the image alt text and tooltip.', 'sublimeplus'),
                    ],
                    [
                        'type'        => 'attach_image',
                        'heading'     => __('Logo Image', 'sublimeplus'),
                        'param_name'  => 'image_id',
                        'description' => __('Recommended: transparent PNG, max 200×80 px.', 'sublimeplus'),
                    ],
                ],
            ],
        ],
    ]);

    // ── Products Catalogue ────────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Products', 'sublimeplus'),
        'base'        => 'sublime_products',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-archive',
        'description' => __('Product catalogue grid — queries WooCommerce featured products, falling back to all products.', 'sublimeplus'),
        'params'      => [
            [
                'type'       => 'textfield',
                'heading'    => __('Section Heading', 'sublimeplus'),
                'param_name' => 'heading',
                'value'      => '',
            ],
            [
                'type'       => 'textarea',
                'heading'    => __('Sub-text', 'sublimeplus'),
                'param_name' => 'subtext',
                'value'      => '',
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('CTA Button Label', 'sublimeplus'),
                'param_name' => 'cta_text',
                'value'      => '',
                'group'      => __('Call to Action', 'sublimeplus'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('CTA Button URL', 'sublimeplus'),
                'param_name'  => 'cta_url',
                'value'       => '',
                'description' => __('Paste the full URL to your products/catalogue page.', 'sublimeplus'),
                'group'       => __('Call to Action', 'sublimeplus'),
            ],
        ],
    ]);

    // ── Supply Capability ─────────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Supply Capability', 'sublimeplus'),
        'base'        => 'sublime_supply',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-car',
        'description' => __('Supply capability cards: stock, delivery, compliance, moulds, site support, lab.', 'sublimeplus'),
        'params'      => [
            [
                'type'       => 'textfield',
                'heading'    => __('Section Heading', 'sublimeplus'),
                'param_name' => 'heading',
                'value'      => '',
            ],
            [
                'type'       => 'textarea',
                'heading'    => __('Sub-text', 'sublimeplus'),
                'param_name' => 'subtext',
                'value'      => '',
            ],
            [
                'type'        => 'param_group',
                'heading'     => __('Capability Cards', 'sublimeplus'),
                'param_name'  => 'cards',
                'description' => __('Leave empty to use the six default theme cards. Add rows here to replace them entirely.', 'sublimeplus'),
                'value'       => '',
                'params'      => [
                    [
                        'type'        => 'textfield',
                        'heading'     => __('Card Title', 'sublimeplus'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'admin_label' => true,
                    ],
                    [
                        'type'       => 'textarea',
                        'heading'    => __('Card Description', 'sublimeplus'),
                        'param_name' => 'desc',
                        'value'      => '',
                    ],
                    [
                        'type'        => 'attach_image',
                        'heading'     => __('Card Image', 'sublimeplus'),
                        'param_name'  => 'image_id',
                        'description' => __('Recommended: landscape photo, at least 600×400 px.', 'sublimeplus'),
                    ],
                ],
            ],
        ],
    ]);

    // ── Blog / Insights ───────────────────────────────────────────────────────
    vc_map([
        'name'        => __('Sublime Blog / Insights', 'sublimeplus'),
        'base'        => 'sublime_blog',
        'category'    => __('Sublime Sections', 'sublimeplus'),
        'icon'        => 'dashicons-admin-post',
        'description' => __('Latest blog posts grid — 5 posts, first card spans two columns.', 'sublimeplus'),
        'params'      => [
            [
                'type'       => 'textfield',
                'heading'    => __('Section Heading', 'sublimeplus'),
                'param_name' => 'heading',
                'value'      => '',
            ],
            [
                'type'       => 'textarea',
                'heading'    => __('Sub-text', 'sublimeplus'),
                'param_name' => 'subtext',
                'value'      => '',
            ],
            [
                'type'       => 'textfield',
                'heading'    => __('CTA Link Label', 'sublimeplus'),
                'param_name' => 'cta_text',
                'value'      => '',
                'group'      => __('Call to Action', 'sublimeplus'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('CTA Link URL', 'sublimeplus'),
                'param_name'  => 'cta_url',
                'value'       => '',
                'description' => __('Paste the full URL to your blog or news page.', 'sublimeplus'),
                'group'       => __('Call to Action', 'sublimeplus'),
            ],
        ],
    ]);
}
add_action('vc_before_init', 'sublime_register_vc_elements');

<?php
/**
 * Precast Al Turab — central company settings & helpers
 *
 * All contact details, WhatsApp URLs, RFQ links and brand strings used across
 * the theme come from here so they stay consistent (Brief: Priority 19/35).
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/**
 * Company contact details (Customizer-overridable, sane defaults).
 */
function sp_company(): array {
    static $c = null;
    if ($c !== null) return $c;

    $phone     = get_theme_mod('sp_footer_phone',    '+971 54 350 7724');
    $whatsapp  = get_theme_mod('sp_footer_whatsapp', 'https://wa.me/971543507724');
    $wa_digits = preg_replace('/\D+/', '', (string) parse_url($whatsapp, PHP_URL_PATH));
    if (!$wa_digits) $wa_digits = preg_replace('/\D+/', '', $phone);

    $c = [
        'name'       => 'Precast Al Turab',
        'legal'      => get_theme_mod('sp_legal_name', 'Al Turab Concrete Products Manufacturing L.L.C. S.P.'),
        'tagline'    => get_theme_mod('sp_footer_tagline', 'Specialists in Customized Precast Concrete Solutions'),
        'sectors'    => 'Government | Defence | Infrastructure | Industrial | Commercial',
        'slogan'     => 'Engineered for Challenges. Built for Strength. Trusted for Quality.',
        'phone2'     => get_theme_mod('sp_phone2', '+971 54 348 8946'),
        'phone2_tel' => preg_replace('/[^+\d]/', '', (string) get_theme_mod('sp_phone2', '+971 54 348 8946')),
        'phone'      => $phone,
        'phone_tel'  => preg_replace('/[^+\d]/', '', $phone),
        'email'      => get_theme_mod('sp_footer_email', 'info@precastalturab.ae'),
        'wa_digits'  => $wa_digits,
        'address'    => get_theme_mod('sp_footer_address', 'MAZYAD Offices 2, 75 Sultan Bin Mohammed Al Qubaisi St (Street 207), Mohamed Bin Zayed City, Abu Dhabi 20614, UAE'),
        'factory'    => get_theme_mod('sp_factory_address', 'Al Sajaa Industrial Area, Sharjah, UAE'),
        // Factory pin from the client (Google Maps, plus code 7HQQ8MX5+HPR, Al Sajaa, Sharjah)
        'factory_map_url' => get_theme_mod('sp_factory_map_url', 'https://maps.app.goo.gl/nLjqPWS8bPaPhwLR9'),
        'factory_map_q'   => '7HQQ8MX5+HPR',
        'factory_lat'     => 25.3489,
        'factory_lng'     => 55.6593,
        'hours'      => get_theme_mod('sp_hours', 'Mon – Sat: 8:00 AM – 6:00 PM'),
        'map_query'  => get_theme_mod('sp_map_query', 'MAZYAD Offices 2, Mohamed Bin Zayed City, Abu Dhabi'),
        'linkedin'   => get_theme_mod('sp_footer_linkedin',  ''),
        'instagram'  => get_theme_mod('sp_footer_instagram', ''),
        'facebook'   => get_theme_mod('sp_footer_facebook',  ''),
        'ga_id'      => get_theme_mod('sp_ga_id', ''),
        'profile_id' => (int) get_theme_mod('sp_company_profile_id', 0),
    ];
    return $c;
}

/** WhatsApp URL with a pre-filled message. */
function sp_wa_url(string $message = ''): string {
    $c = sp_company();
    if ($message === '') {
        $message = 'Hello Precast Al Turab, I would like to request a quotation for a precast concrete product.';
    }
    return 'https://wa.me/' . $c['wa_digits'] . '?text=' . rawurlencode($message);
}

/** Product-aware WhatsApp message (Brief: Priority 18). */
function sp_wa_url_for_product($post_id): string {
    $custom = get_post_meta($post_id, '_sp_wa_message', true);
    if ($custom) return sp_wa_url($custom);
    $title = get_the_title($post_id);
    return sp_wa_url('Hello Precast Al Turab, I need a quotation for ' . $title . '.');
}

/** URL of a page by slug, with fallback. */
function sp_page_url(string $slug, string $fallback = '/'): string {
    $p = get_page_by_path($slug);
    return $p ? get_permalink($p) : home_url($fallback);
}

/** RFQ page URL, optionally pre-filling product / reference project. */
function sp_rfq_url(string $product = '', string $project = '', string $intent = ''): string {
    $url = sp_page_url('request-quotation', '/request-quotation/');
    $q = [];
    if ($product !== '') $q['product'] = $product;
    if ($project !== '') $q['project'] = $project;
    if ($intent  !== '') $q['intent']  = $intent;
    return $q ? add_query_arg(array_map('rawurlencode', $q), $url) : $url;
}

/** Company profile PDF URL (if uploaded) — else RFQ with intent. */
function sp_profile_url(): string {
    $c = sp_company();
    if ($c['profile_id'] && ($u = wp_get_attachment_url($c['profile_id']))) return $u;
    return sp_rfq_url('', '', 'Company Profile Request');
}

/** Inline SVG icon library (stroke icons, currentColor). */
function sp_icon(string $name, int $size = 22): string {
    $icons = [
        'factory'   => '<path d="M2 20h20"/><path d="M4 20V9l5 3V9l5 3V6l6 3v11"/><path d="M9 20v-4h3v4"/>',
        'mould'     => '<path d="M3 7h18v10H3z"/><path d="M7 7v10M12 7v10M17 7v10"/><path d="M3 12h18"/>',
        'heavy'     => '<path d="M3 20h18"/><path d="M6 20V10h12v10"/><path d="M9 10V6h6v4"/><path d="M12 2v4"/>',
        'qa'        => '<path d="M9 12l2 2 4-4"/><path d="M12 2l8 3v7c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V5z"/>',
        'truck'     => '<path d="M1 4h14v12H1z"/><path d="M15 9h4l4 4v3h-8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
        'crane'     => '<path d="M3 21h18"/><path d="M6 21V4"/><path d="M6 4h13l-3 4H6"/><path d="M16 8v6"/><path d="M14 14h4v3h-4z"/>',
        'drawing'   => '<path d="M4 4h16v16H4z"/><path d="M4 9h16M9 9v11"/><path d="M12 13l3 3-3 3"/>',
        'rebar'     => '<path d="M3 6h18M3 12h18M3 18h18"/><path d="M7 3v18M12 3v18M17 3v18"/>',
        'cast'      => '<path d="M4 10h16l-2 11H6z"/><path d="M7 10V5a5 5 0 0 1 10 0v5"/>',
        'curing'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'finish'    => '<path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/>',
        'inspect'   => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/><path d="M8 11l2 2 4-4"/>',
        'lift'      => '<path d="M12 3v12"/><path d="m8 11 4 4 4-4"/><path d="M4 21h16"/><path d="M6 21v-3h12v3"/>',
        'load'      => '<path d="M2 7h12v9H2z"/><path d="M14 11h5l3 3v2h-8z"/><circle cx="6" cy="19" r="2"/><circle cx="18" cy="19" r="2"/><path d="M5 11h6"/>',
        'delivery'  => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'whatsapp'  => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>',
        'phone'     => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.82 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 3.12 4.18 2 2 0 0 1 5.09 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'mail'      => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'pin'       => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'clock'     => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'file'      => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/>',
        'upload'    => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m17 8-5-5-5 5"/><path d="M12 3v12"/>',
        'quote'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'arrow'     => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'check'     => '<path d="M20 6 9 17l-5-5"/>',
        'menu'      => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'close'     => '<path d="M18 6 6 18M6 6l12 12"/>',
        'shield'    => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'layers'    => '<path d="m12 2 10 5-10 5L2 7z"/><path d="m2 12 10 5 10-5"/><path d="m2 17 10 5 10-5"/>',
        'box'       => '<path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/>',
        'wall'      => '<path d="M3 5h18v14H3z"/><path d="M3 10h18M3 14h18"/><path d="M8 5v5M13 10v4M8 14v5M16 14v5M16 5v5"/>',
        'culvert'   => '<path d="M3 6h18v12H3z"/><path d="M7 10h10v4H7z"/>',
        'barrier'   => '<path d="M4 20h16"/><path d="M7 20V9l5-5 5 5v11"/><path d="M9 20v-6h6v6"/>',
        'manhole'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><path d="M12 7v10M7 12h10"/>',
        'custom'    => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        'download'  => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/><path d="M12 15V3"/>',
        'bunker'    => '<path d="M3 20h18"/><path d="M4 20V11a8 8 0 0 1 16 0v9"/><path d="M10 20v-5h4v5"/>',
        'users'     => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'calendar'  => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'cert'      => '<circle cx="12" cy="9" r="6"/><path d="m8.5 14-1.5 8 5-3 5 3-1.5-8"/>',
        'weight'    => '<path d="M6.5 8h11l2.5 12H4z"/><circle cx="12" cy="5" r="2.5"/>',
        'height'    => '<path d="M12 3v18"/><path d="m8 7 4-4 4 4"/><path d="m8 17 4 4 4-4"/>',
        'length'    => '<path d="M3 12h18"/><path d="m7 8-4 4 4 4"/><path d="m17 8 4 4-4 4"/>',
    ];
    $path = $icons[$name] ?? $icons['box'];
    $fill = ($name === 'whatsapp') ? 'currentColor' : 'none';
    $stroke = ($name === 'whatsapp') ? 'none' : 'currentColor';
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="' . $size . '" height="' . $size . '" fill="' . $fill . '" stroke="' . $stroke . '" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/** Primary CTA trio used everywhere (Brief: "Main conversion buttons"). */
function sp_cta_buttons(array $opts = []): string {
    $o = wp_parse_args($opts, [
        'product'   => '',
        'project'   => '',
        'wa_msg'    => '',
        'labels'    => [],
        'class'     => '',
        'show'      => ['quote', 'drawing', 'wa'],
    ]);
    $labels = wp_parse_args($o['labels'], ['quote' => 'Request a Quotation', 'drawing' => 'Send Your Drawing', 'wa' => 'WhatsApp Our Team']);
    $out = '<div class="pc-cta-group ' . esc_attr($o['class']) . '">';
    foreach ($o['show'] as $k) {
        if ($k === 'quote') {
            $out .= '<a class="pc-btn pc-btn--accent" href="' . esc_url(sp_rfq_url($o['product'], $o['project'])) . '" data-track="rfq_click">' . sp_icon('quote', 18) . '<span>' . esc_html($labels['quote']) . '</span></a>';
        } elseif ($k === 'drawing') {
            $out .= '<a class="pc-btn pc-btn--outline" href="' . esc_url(sp_rfq_url($o['product'], $o['project'], 'Send Drawing')) . '#rfq-files" data-track="drawing_click">' . sp_icon('upload', 18) . '<span>' . esc_html($labels['drawing']) . '</span></a>';
        } elseif ($k === 'wa') {
            $out .= '<a class="pc-btn pc-btn--wa" href="' . esc_url($o['wa_msg'] ? sp_wa_url($o['wa_msg']) : sp_wa_url()) . '" target="_blank" rel="noopener" data-track="whatsapp_click">' . sp_icon('whatsapp', 18) . '<span>' . esc_html($labels['wa']) . '</span></a>';
        }
    }
    $out .= '</div>';
    return $out;
}

/** Image URL helper with graceful fallback (concrete placeholder data-URI). */
function sp_img_url($attachment_id, string $size = 'large'): string {
    $attachment_id = (int) $attachment_id;
    if ($attachment_id && ($u = wp_get_attachment_image_url($attachment_id, $size))) return $u;
    return '';
}

/** Section heading block. */
function sp_section_head(string $eyebrow, string $heading, string $sub = '', string $align = 'left', string $tag = 'h2'): string {
    $out  = '<div class="pc-sec-head pc-sec-head--' . esc_attr($align) . '">';
    if ($eyebrow) $out .= '<span class="pc-eyebrow">' . esc_html($eyebrow) . '</span>';
    $out .= '<' . $tag . ' class="pc-h2">' . esc_html($heading) . '</' . $tag . '>';
    if ($sub) $out .= '<p class="pc-sub">' . esc_html($sub) . '</p>';
    $out .= '</div>';
    return $out;
}

/** Register Customizer fields for the company settings. */
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('sp_company', ['title' => 'Precast — Company Details', 'priority' => 5]);
    $fields = [
        'sp_footer_phone'       => ['Phone', 'text'],
        'sp_phone2'             => ['Second phone', 'text'],
        'sp_footer_whatsapp'    => ['WhatsApp URL (https://wa.me/9715...)', 'text'],
        'sp_footer_email'       => ['Email', 'text'],
        'sp_footer_address'     => ['Office address', 'textarea'],
        'sp_factory_address'    => ['Factory address', 'textarea'],
        'sp_factory_map_url'    => ['Factory Google Maps link', 'text'],
        'sp_hours'              => ['Business hours', 'text'],
        'sp_map_query'          => ['Google Maps query', 'text'],
        'sp_legal_name'         => ['Legal entity name', 'text'],
        'sp_footer_linkedin'    => ['LinkedIn URL', 'text'],
        'sp_footer_instagram'   => ['Instagram URL', 'text'],
        'sp_footer_facebook'    => ['Facebook URL', 'text'],
        'sp_ga_id'              => ['Google Analytics 4 Measurement ID (G-XXXX)', 'text'],
        'sp_company_profile_id' => ['Company profile PDF attachment ID', 'number'],
    ];
    foreach ($fields as $id => [$label, $type]) {
        $wp_customize->add_setting($id, ['sanitize_callback' => $type === 'number' ? 'absint' : 'sanitize_text_field']);
        $wp_customize->add_control($id, ['section' => 'sp_company', 'label' => $label, 'type' => $type]);
    }
});

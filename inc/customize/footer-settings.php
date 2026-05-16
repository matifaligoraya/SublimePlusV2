<?php
/**
 * Footer Customizer settings
 *
 * Panel: "Footer Settings"
 *   Section: Contact & Form    — phone, email, address, WhatsApp, form shortcode, headings
 *   Section: Branding          — tagline, LinkedIn, Instagram, Facebook
 *   Section: Copyright         — copyright text
 *   Section: Footer Builder    — select any published page to replace the default layout
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

    // ── Panel ─────────────────────────────────────────────────────────────────
    $wp_customize->add_panel('sp_footer_panel', [
        'title'       => __('Footer Settings', 'sublimeplus'),
        'priority'    => 160,
        'description' => __('Control the site footer: contact details, form, branding, links, and copyright.', 'sublimeplus'),
    ]);

    // ── Helper: add a text control ────────────────────────────────────────────
    $text = function (string $id, string $label, string $section, string $default = '', string $desc = '', string $type = 'text') use ($wp_customize) {
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control($id, [
            'label'       => $label,
            'description' => $desc,
            'section'     => $section,
            'type'        => $type,
        ]);
    };

    $url = function (string $id, string $label, string $section, string $default = '', string $desc = '') use ($wp_customize) {
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control($id, [
            'label'       => $label,
            'description' => $desc,
            'section'     => $section,
            'type'        => 'url',
        ]);
    };

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION — Contact & Form
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section('sp_footer_contact', [
        'title'    => __('Contact & Form', 'sublimeplus'),
        'panel'    => 'sp_footer_panel',
        'priority' => 10,
    ]);

    $text('sp_footer_info_heading', __('Info Column Heading', 'sublimeplus'), 'sp_footer_contact', 'Project Inquiry');
    $wp_customize->add_setting('sp_footer_info_text', [
        'default'           => "Tell us about your project and we'll get back to you with a detailed quote, material specs, and delivery timeline.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('sp_footer_info_text', [
        'label'   => __('Info Column Text', 'sublimeplus'),
        'section' => 'sp_footer_contact',
        'type'    => 'textarea',
    ]);

    $text('sp_footer_phone',   __('Phone Number', 'sublimeplus'),   'sp_footer_contact', '+971 54 350 7724');
    $text('sp_footer_email',   __('Email Address', 'sublimeplus'),  'sp_footer_contact', 'info@precastalturab.ae');
    $wp_customize->add_setting('sp_footer_address', [
        'default'           => '75, Sultan Bin Mohammed Al Qubaisi St, Mohamed Bin Zayed City, Abu Dhabi',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('sp_footer_address', [
        'label'   => __('Address', 'sublimeplus'),
        'section' => 'sp_footer_contact',
        'type'    => 'textarea',
    ]);
    $url('sp_footer_whatsapp', __('WhatsApp URL', 'sublimeplus'), 'sp_footer_contact', 'https://wa.me/971543507724',
        __('e.g. https://wa.me/971543507724', 'sublimeplus'));

    $text('sp_footer_form_heading', __('Form Column Heading', 'sublimeplus'), 'sp_footer_contact', 'Request a Project Quote');
    $text(
        'sp_footer_form_shortcode',
        __('Form Shortcode', 'sublimeplus'),
        'sp_footer_contact',
        '[formidable id=1]',
        __('Paste any Formidable Pro (or other plugin) shortcode here. Default: [formidable id=1]', 'sublimeplus')
    );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION — Branding
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section('sp_footer_branding', [
        'title'    => __('Branding', 'sublimeplus'),
        'panel'    => 'sp_footer_panel',
        'priority' => 20,
    ]);

    $wp_customize->add_setting('sp_footer_tagline', [
        'default'           => "UAE's trusted source for RTA-approved precast concrete barriers, blocks, and bespoke structural systems.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('sp_footer_tagline', [
        'label'   => __('Footer Tagline', 'sublimeplus'),
        'section' => 'sp_footer_branding',
        'type'    => 'textarea',
    ]);

    $url('sp_footer_linkedin',  __('LinkedIn URL', 'sublimeplus'),  'sp_footer_branding', 'https://www.linkedin.com/company/precastuae');
    $url('sp_footer_instagram', __('Instagram URL', 'sublimeplus'), 'sp_footer_branding', 'https://www.instagram.com/precast_uae');
    $url('sp_footer_facebook',  __('Facebook URL', 'sublimeplus'),  'sp_footer_branding', 'https://www.facebook.com/precastuae');

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION — Copyright
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section('sp_footer_copyright_sec', [
        'title'    => __('Copyright', 'sublimeplus'),
        'panel'    => 'sp_footer_panel',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('sp_footer_copyright', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('sp_footer_copyright', [
        'label'       => __('Copyright Text', 'sublimeplus'),
        'description' => __('Leave blank to auto-generate: © {year} {Site Name}. All rights reserved.', 'sublimeplus'),
        'section'     => 'sp_footer_copyright_sec',
        'type'        => 'text',
    ]);

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION — Footer Builder
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section('sp_footer_builder', [
        'title'       => __('Footer Builder', 'sublimeplus'),
        'panel'       => 'sp_footer_panel',
        'priority'    => 40,
        'description' => __('Select a published page to use as the entire footer body (e.g. built with WPBakery or Elementor). Leave empty to use the default footer layout.', 'sublimeplus'),
    ]);

    $wp_customize->add_setting('sp_footer_page_id', [
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('sp_footer_page_id', [
        'label'       => __('Footer Builder Page', 'sublimeplus'),
        'description' => __('Choose a page whose content replaces the default footer columns. The copyright bar is always shown below it.', 'sublimeplus'),
        'section'     => 'sp_footer_builder',
        'type'        => 'dropdown-pages',
    ]);
});

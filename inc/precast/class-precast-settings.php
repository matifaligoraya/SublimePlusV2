<?php
/**
 * Precast Al Turab — Customizer section "Precast — Company Details".
 * Values are read by sp_company() (settings.php). Hook registered in
 * Precast::define_shared_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_Settings {

    /** customize_register */
    public function customize_register($wp_customize) {
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
    }
}

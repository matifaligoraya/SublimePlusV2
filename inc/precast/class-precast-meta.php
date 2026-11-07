<?php
/**
 * Precast Al Turab — extra edit-screen fields for products, projects and SEO.
 * The box renderers are sp_pc_product_box(), sp_pc_project_box() and
 * sp_pc_seo_box() in meta.php. Hooks are registered in Precast::define_admin_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_Meta {

    /** add_meta_boxes */
    public function add_meta_boxes() {
        add_meta_box('sp_pc_product', 'Product Page Content (Precast)', 'sp_pc_product_box', 'sp_product', 'normal', 'high');
        add_meta_box('sp_pc_project', 'Case Study Details (Precast)',   'sp_pc_project_box', 'sp_project', 'normal', 'high');
        add_meta_box('sp_pc_seo',     'SEO',                            'sp_pc_seo_box',     ['sp_product', 'sp_project', 'page', 'post'], 'side', 'default');
    }

    /** save_post (2 args) */
    public function save_post($post_id, $post) {
        if (!isset($_POST['sp_pc_nonce']) || !wp_verify_nonce($_POST['sp_pc_nonce'], 'sp_pc_save')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        $text_keys = ['_sp_applications', '_sp_wa_message', '_sp_seo_title', '_sp_project_product', '_sp_project_quantity', '_sp_project_contractor', '_sp_project_consultant', '_sp_project_period', '_sp_project_lifting', '_sp_project_process_gallery', '_sp_project_logistics_gallery'];
        foreach ($text_keys as $k) {
            if (isset($_POST[$k])) update_post_meta($post_id, $k, sanitize_text_field($_POST[$k]));
        }
        $area_keys = ['_sp_overview', '_sp_seo_desc', '_sp_project_scope'];
        foreach ($area_keys as $k) {
            if (isset($_POST[$k])) update_post_meta($post_id, $k, sanitize_textarea_field($_POST[$k]));
        }
        if (isset($_POST['sp_faq_q'])) {
            $faqs = [];
            foreach ((array) $_POST['sp_faq_q'] as $i => $q) {
                $q = sanitize_text_field($q); $a = sanitize_textarea_field($_POST['sp_faq_a'][$i] ?? '');
                if ($q !== '' && $a !== '') $faqs[] = [$q, $a];
            }
            update_post_meta($post_id, '_sp_faqs', wp_json_encode($faqs, JSON_UNESCAPED_UNICODE));
        }
        if (isset($_POST['sp_tech_k'])) {
            $rows = [];
            foreach ((array) $_POST['sp_tech_k'] as $i => $k) {
                $k = sanitize_text_field($k); $v = sanitize_text_field($_POST['sp_tech_v'][$i] ?? '');
                if ($k !== '' && $v !== '') $rows[] = [$k, $v];
            }
            update_post_meta($post_id, '_sp_project_tech', wp_json_encode($rows, JSON_UNESCAPED_UNICODE));
        }
    }
}

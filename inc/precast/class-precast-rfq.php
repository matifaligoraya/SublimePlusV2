<?php
/**
 * Precast Al Turab — RFQ (quotation request): private post type, AJAX submit,
 * admin files box and [sublime_rfq_form] shortcode. The submit logic itself
 * lives in sp_rfq_submit_handler() (rfq.php). Hooks are registered in
 * Precast::define_*_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_RFQ {

    /** Private CPT so every submission is visible in wp-admin. init */
    public function register_post_type() {
        register_post_type('sp_rfq', [
            'labels' => [
                'name'          => 'RFQ Submissions',
                'singular_name' => 'RFQ',
                'menu_name'     => 'RFQ Inbox',
            ],
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => true,
            'menu_icon'    => 'dashicons-email-alt',
            'menu_position'=> 26,
            'supports'     => ['title', 'editor'],
            'capability_type' => 'post',
            'capabilities' => ['create_posts' => 'do_not_allow'],
            'map_meta_cap' => true,
        ]);
    }

    /** AJAX submit (logged-in and visitors). wp_ajax_sp_rfq_submit / wp_ajax_nopriv_sp_rfq_submit */
    public function submit() {
        sp_rfq_submit_handler();
    }

    /** add_meta_boxes_sp_rfq */
    public function add_files_meta_box() {
        add_meta_box('sp_rfq_files', 'Uploaded Files', [$this, 'render_files_meta_box'], 'sp_rfq', 'side');
    }

    /** Meta box: list of files uploaded with the request. */
    public function render_files_meta_box($post) {
        $files = get_post_meta($post->ID, '_rfq_files', true);
        if (!$files) { echo '<p>No files uploaded.</p>'; return; }
        echo '<ul>';
        foreach ($files as $f) echo '<li><a href="' . esc_url($f['url']) . '" target="_blank">' . esc_html($f['name']) . '</a> (' . esc_html(size_format($f['size'])) . ')</li>';
        echo '</ul>';
    }

    /** [sublime_rfq_form heading="" subtext="" compact="0"] */
    public function form_shortcode($atts) {
        $atts = shortcode_atts(['heading' => 'Request a Precast Quotation', 'subtext' => '', 'compact' => '0'], $atts, 'sublime_rfq_form');
        return sp_rfq_form_html(['heading' => $atts['heading'], 'subtext' => $atts['subtext'], 'compact' => $atts['compact'] === '1']);
    }
}

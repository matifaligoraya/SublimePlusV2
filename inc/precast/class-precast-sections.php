<?php
/**
 * Precast Al Turab — section shortcodes and their WPBakery elements.
 * Each [sublime_*] shortcode renders template-parts/precast/{tpl}.php with the
 * definitions from sp_pc_shortcode_definitions() (sections.php).
 * Hooks are registered in Precast::define_*_hooks().
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_Sections {

    /** Shared callback for every [sublime_*] section shortcode (WordPress passes the tag as 3rd argument). */
    public function render_shortcode($atts, $content = '', $tag = '') {
        $defs = sp_pc_shortcode_definitions();
        if (!isset($defs[$tag])) return '';
        $def = $defs[$tag];
        $a = shortcode_atts($def['atts'], (array) $atts, $tag);
        $a['content'] = $content;
        return sp_pc_render($def['tpl'], $a);
    }

    /** page.php treats these shortcodes as full-width layouts. sp_fullwidth_shortcodes */
    public function fullwidth_shortcodes($tags) {
        return array_merge($tags, array_keys(sp_pc_shortcode_definitions()), ['sublime_rfq_form']);
    }

    /** WPBakery element definitions so editors can manage the sections visually. vc_before_init */
    public function register_wpbakery_elements() {
        if (!function_exists('vc_map')) return;
        $cat = 'Precast Sections';

        vc_map(['name' => 'Precast Hero (Heavy)', 'base' => 'sublime_hero_heavy', 'category' => $cat, 'icon' => 'dashicons-superhero', 'params' => [
            $this->image('bg_image_id', 'Background image (heavy precast photo)'),
            $this->text('heading', 'Main heading'), $this->text('subheading', 'Sub heading'), $this->area('description', 'Description'), $this->text('formats', 'Formats line (e.g. PDF • DWG • BOQ)'),
        ]]);
        vc_map(['name' => 'Precast Capability Bar', 'base' => 'sublime_capability_bar', 'category' => $cat, 'icon' => 'dashicons-star-filled', 'params' => [
            ['type' => 'param_group', 'param_name' => 'items', 'heading' => 'Items (leave empty for defaults)', 'params' => [$this->text('title', 'Title'), $this->text('icon', 'Icon key (factory, mould, heavy, qa, delivery)')]],
        ]]);
        vc_map(['name' => 'Precast Systems (6 cards)', 'base' => 'sublime_systems', 'category' => $cat, 'icon' => 'dashicons-grid-view', 'params' => [
            $this->text('heading', 'Heading'), $this->area('subtext', 'Subtitle'),
            ['type' => 'param_group', 'param_name' => 'cards', 'heading' => 'Cards (leave empty for defaults)', 'params' => [$this->text('title', 'Title'), $this->area('desc', 'Description'), $this->text('btn_text', 'Button text'), $this->text('link', 'Link URL'), $this->image('image_id', 'Image'), $this->text('icon', 'Icon key')]],
        ]]);
        vc_map(['name' => 'Precast Heavy Feature', 'base' => 'sublime_heavy_feature', 'category' => $cat, 'icon' => 'dashicons-building', 'params' => [
            $this->text('heading', 'Heading'), $this->area('text', 'Text'), $this->area('products', 'Products (one per line)'), $this->text('btn_text', 'Button text'), $this->text('btn_url', 'Button URL'), $this->image('image_id', 'Image'),
        ]]);
        vc_map(['name' => 'Precast Process (8 steps)', 'base' => 'sublime_process', 'category' => $cat, 'icon' => 'dashicons-controls-forward', 'params' => [
            $this->text('eyebrow', 'Eyebrow'), $this->text('heading', 'Heading'), $this->area('subtext', 'Subtext'),
            ['type' => 'dropdown', 'param_name' => 'bg', 'heading' => 'Background', 'value' => ['Light' => 'light', 'Dark' => 'dark']],
            ['type' => 'param_group', 'param_name' => 'steps', 'heading' => 'Steps (leave empty for defaults)', 'params' => [$this->text('title', 'Title'), $this->area('desc', 'Description'), $this->text('icon', 'Icon key')]],
        ]]);
        vc_map(['name' => 'Precast QA/QC', 'base' => 'sublime_qaqc', 'category' => $cat, 'icon' => 'dashicons-yes-alt', 'params' => [$this->text('heading', 'Heading'), $this->area('subtext', 'Subtext'), $this->area('steps', 'Steps (one per line)')]]);
        vc_map(['name' => 'Precast Resources Teaser', 'base' => 'sublime_resources_teaser', 'category' => $cat, 'icon' => 'dashicons-media-document', 'params' => [$this->text('heading', 'Heading'), $this->area('subtext', 'Subtext')]]);
        vc_map(['name' => 'Precast Final CTA', 'base' => 'sublime_final_cta', 'category' => $cat, 'icon' => 'dashicons-megaphone', 'params' => [$this->text('heading', 'Heading'), $this->text('subheading', 'Sub heading'), $this->area('items', 'Review items (one per line)')]]);
        vc_map(['name' => 'Precast Page Hero', 'base' => 'sublime_page_hero', 'category' => $cat, 'icon' => 'dashicons-align-wide', 'params' => [$this->text('eyebrow', 'Eyebrow'), $this->text('heading', 'H1 heading'), $this->area('subtext', 'Subtext'), $this->image('bg_image_id', 'Background image'), ['type' => 'checkbox', 'param_name' => 'show_cta', 'heading' => 'Show CTA buttons', 'value' => ['Yes' => '1']]]]);
        vc_map(['name' => 'Precast Capabilities Page', 'base' => 'sublime_capabilities', 'category' => $cat, 'icon' => 'dashicons-admin-tools', 'params' => [
            ['type' => 'param_group', 'param_name' => 'blocks', 'heading' => 'Blocks (leave empty for defaults)', 'params' => [$this->text('title', 'Title'), $this->area('desc', 'Description'), $this->text('icon', 'Icon key'), $this->image('image_id', 'Photo')]],
        ]]);
        vc_map(['name' => 'Precast Technical Resources', 'base' => 'sublime_tech_resources', 'category' => $cat, 'icon' => 'dashicons-download', 'params' => [
            ['type' => 'param_group', 'param_name' => 'docs', 'heading' => 'Documents', 'params' => [$this->text('title', 'Title'), $this->area('desc', 'Description'), $this->text('category', 'Category (Company, Product Data Sheets, Technical Documents, Certificates)'), ['type' => 'attach_image', 'param_name' => 'file_id', 'heading' => 'File (choose PDF in media library)'], $this->text('expiry', 'Expiry date (YYYY-MM-DD, certificates only)')]],
        ]]);
        vc_map(['name' => 'Precast Contact Page', 'base' => 'sublime_contact_pc', 'category' => $cat, 'icon' => 'dashicons-phone', 'params' => [$this->text('heading', 'Heading'), $this->area('description', 'Description')]]);
        vc_map(['name' => 'Precast Why Choose Us', 'base' => 'sublime_why', 'category' => $cat, 'icon' => 'dashicons-thumbs-up', 'params' => [$this->text('heading', 'Heading'), $this->area('subtext', 'Subtext'),
            ['type' => 'param_group', 'param_name' => 'items', 'heading' => 'Items (leave empty for defaults)', 'params' => [$this->text('title', 'Title'), $this->area('desc', 'Description'), $this->text('icon', 'Icon key')]]]]);
        vc_map(['name' => 'Precast Featured Projects', 'base' => 'sublime_featured_projects', 'category' => $cat, 'icon' => 'dashicons-portfolio', 'params' => [$this->text('heading', 'Heading'), $this->area('subtext', 'Subtext'), $this->text('count', 'Number of projects', '4')]]);
        vc_map(['name' => 'Precast Clients & Partners', 'base' => 'sublime_partners', 'category' => $cat, 'icon' => 'dashicons-groups', 'params' => [$this->text('heading', 'Heading'), $this->area('subtext', 'Subtext'),
            ['type' => 'param_group', 'param_name' => 'logos', 'heading' => 'Logos (only verified clients)', 'params' => [$this->text('name', 'Name'), $this->image('image_id', 'Logo')]]]]);
        vc_map(['name' => 'Precast About Capabilities', 'base' => 'sublime_about_capabilities', 'category' => $cat, 'icon' => 'dashicons-list-view', 'params' => [$this->text('heading', 'Heading'), $this->area('items', 'Items (one per line)')]]);
        vc_map(['name' => 'Precast Text Block', 'base' => 'sublime_text_block', 'category' => $cat, 'icon' => 'dashicons-text', 'params' => [$this->text('eyebrow', 'Eyebrow'), $this->text('heading', 'Heading'), ['type' => 'textarea_html', 'param_name' => 'content', 'heading' => 'Content'], $this->image('image_id', 'Image'), ['type' => 'dropdown', 'param_name' => 'img_pos', 'heading' => 'Image position', 'value' => ['Right' => 'right', 'Left' => 'left']], ['type' => 'dropdown', 'param_name' => 'layout', 'heading' => 'Layout (without image)', 'value' => ['Reading width' => '', 'Full width' => 'wide', 'Centred' => 'center']], $this->text('cta_text', 'CTA text'), $this->text('cta_url', 'CTA URL')]]);
        vc_map(['name' => 'Precast RFQ Form', 'base' => 'sublime_rfq_form', 'category' => $cat, 'icon' => 'dashicons-forms', 'params' => [$this->text('heading', 'Heading', 'Request a Precast Quotation'), $this->area('subtext', 'Subtext'), ['type' => 'checkbox', 'param_name' => 'compact', 'heading' => 'Compact layout', 'value' => ['Yes' => '1']]]]);
    }

    /** WPBakery param: text field. */
    private function text($n, $h, $v = '', $g = '') {
        return array_filter(['type' => 'textfield', 'param_name' => $n, 'heading' => $h, 'value' => $v, 'group' => $g]);
    }

    /** WPBakery param: textarea. */
    private function area($n, $h, $v = '', $g = '') {
        return array_filter(['type' => 'textarea', 'param_name' => $n, 'heading' => $h, 'value' => $v, 'group' => $g]);
    }

    /** WPBakery param: image picker. */
    private function image($n, $h) {
        return ['type' => 'attach_image', 'param_name' => $n, 'heading' => $h];
    }
}

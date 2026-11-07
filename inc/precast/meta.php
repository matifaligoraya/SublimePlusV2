<?php
/**
 * Precast — extra meta fields for products, projects and pages.
 *
 * Products: overview, applications, FAQs, WhatsApp message, SEO title/desc.
 * Projects: product supplied, quantity, contractor, consultant, scope,
 *           technical info table, process gallery, logistics gallery, SEO.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

function sp_pc_field_text($name, $label, $value, $placeholder = '') {
    printf('<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s" placeholder="%4$s"></p>',
        esc_attr($name), esc_html($label), esc_attr($value), esc_attr($placeholder));
}
function sp_pc_field_area($name, $label, $value, $rows = 4, $help = '') {
    printf('<p><label for="%1$s"><strong>%2$s</strong></label>%4$s<br><textarea class="widefat" rows="%5$d" id="%1$s" name="%1$s">%3$s</textarea></p>',
        esc_attr($name), esc_html($label), esc_textarea($value), $help ? '<br><span class="description">' . esc_html($help) . '</span>' : '', (int) $rows);
}
function sp_pc_field_gallery($name, $label, $value) {
    $ids = array_filter(array_map('absint', explode(',', (string) $value)));
    echo '<p><strong>' . esc_html($label) . '</strong></p>';
    echo '<input type="hidden" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" value="' . esc_attr(implode(',', $ids)) . '">';
    echo '<button type="button" class="button sp-pc-gal-btn" data-target="' . esc_attr($name) . '">Select Images</button> ';
    echo '<button type="button" class="button sp-pc-gal-clear" data-target="' . esc_attr($name) . '">Clear</button>';
    echo '<div class="sp-pc-gal-preview" id="' . esc_attr($name) . '_preview" style="display:flex;flex-wrap:wrap;gap:6px;margin:8px 0 14px">';
    foreach ($ids as $id) { $u = wp_get_attachment_image_url($id, 'thumbnail'); if ($u) echo '<img src="' . esc_url($u) . '" style="width:64px;height:64px;object-fit:cover;border-radius:4px">'; }
    echo '</div>';
}

function sp_pc_product_box($post) {
    wp_nonce_field('sp_pc_save', 'sp_pc_nonce');
    $g = fn($k) => get_post_meta($post->ID, $k, true);
    sp_pc_field_area('_sp_overview', 'Product Overview', $g('_sp_overview'), 5, 'What the product is and its common applications. Shown as Section 2. Falls back to the main editor content.');
    sp_pc_field_text('_sp_applications', 'Applications (comma separated)', $g('_sp_applications'), 'Infrastructure, Construction, Industrial, Utilities, Security, Road Works');
    sp_pc_field_text('_sp_wa_message', 'WhatsApp pre-filled message', $g('_sp_wa_message'), 'Hello Precast Al Turab, I need a quotation for a precast bunker.');
    $faqs = $g('_sp_faqs') ? json_decode($g('_sp_faqs'), true) : [];
    echo '<p><strong>FAQs</strong> <span class="description">5–8 questions recommended. Output as FAQ schema.</span></p><div id="sp-pc-faqs">';
    foreach ((array) $faqs as $f) {
        echo '<div class="sp-pc-faq" style="display:flex;gap:6px;margin-bottom:6px"><input type="text" name="sp_faq_q[]" placeholder="Question" value="' . esc_attr($f[0] ?? '') . '" style="flex:1"><textarea name="sp_faq_a[]" placeholder="Answer" rows="2" style="flex:2">' . esc_textarea($f[1] ?? '') . '</textarea><button type="button" class="button sp-pc-del">×</button></div>';
    }
    echo '</div><button type="button" class="button" id="sp-pc-add-faq">+ Add FAQ</button>';
    sp_pc_admin_js();
}

function sp_pc_project_box($post) {
    wp_nonce_field('sp_pc_save', 'sp_pc_nonce');
    $g = fn($k) => get_post_meta($post->ID, $k, true);
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:0 18px">';
    sp_pc_field_text('_sp_project_product',    'Product Supplied',          $g('_sp_project_product'),    'e.g. Precast Bunker Components');
    sp_pc_field_text('_sp_project_quantity',   'Quantity',                  $g('_sp_project_quantity'),   'e.g. 120 units');
    sp_pc_field_text('_sp_project_contractor', 'Main Contractor (if authorised)', $g('_sp_project_contractor'));
    sp_pc_field_text('_sp_project_consultant', 'Consultant (if authorised)', $g('_sp_project_consultant'));
    sp_pc_field_text('_sp_project_period',     'Production Period',         $g('_sp_project_period'),     'e.g. 6 weeks');
    sp_pc_field_text('_sp_project_lifting',    'Lifting Method',            $g('_sp_project_lifting'),    'e.g. 4-point cast-in lifting anchors, 50T crane');
    echo '</div>';
    sp_pc_field_area('_sp_project_scope', 'Scope of Work', $g('_sp_project_scope'), 4, 'Exactly what Precast Al Turab supplied.');
    $tech = $g('_sp_project_tech') ? json_decode($g('_sp_project_tech'), true) : [];
    echo '<p><strong>Technical Information</strong> <span class="description">Dimensions, Concrete Grade, Reinforcement, Wall Thickness, Unit Weight, Finish…</span></p><div id="sp-pc-tech">';
    foreach ((array) $tech as $t) {
        echo '<div class="sp-pc-tech-row" style="display:flex;gap:6px;margin-bottom:6px"><input type="text" name="sp_tech_k[]" placeholder="Label" value="' . esc_attr($t[0] ?? '') . '" style="flex:1"><input type="text" name="sp_tech_v[]" placeholder="Value" value="' . esc_attr($t[1] ?? '') . '" style="flex:2"><button type="button" class="button sp-pc-del">×</button></div>';
    }
    echo '</div><button type="button" class="button" id="sp-pc-add-tech">+ Add Row</button><hr>';
    sp_pc_field_gallery('_sp_project_process_gallery',   'Manufacturing Process Photos (mould, rebar, casting, curing, demoulding, finishing, inspection)', $g('_sp_project_process_gallery'));
    sp_pc_field_gallery('_sp_project_logistics_gallery', 'Logistics Photos (crane lifting, trailer loading, transport, site delivery)', $g('_sp_project_logistics_gallery'));
    sp_pc_admin_js();
}

function sp_pc_seo_box($post) {
    wp_nonce_field('sp_pc_save', 'sp_pc_nonce');
    sp_pc_field_text('_sp_seo_title', 'SEO Title', get_post_meta($post->ID, '_sp_seo_title', true), 'Max ~60 characters');
    sp_pc_field_area('_sp_seo_desc', 'Meta Description', get_post_meta($post->ID, '_sp_seo_desc', true), 3, 'Max ~155 characters');
}

function sp_pc_admin_js() {
    static $done = false; if ($done) return; $done = true;
    wp_enqueue_media();
    ?>
    <script>
    jQuery(function($){
        $('#sp-pc-add-faq').on('click',function(){$('#sp-pc-faqs').append('<div class="sp-pc-faq" style="display:flex;gap:6px;margin-bottom:6px"><input type="text" name="sp_faq_q[]" placeholder="Question" style="flex:1"><textarea name="sp_faq_a[]" placeholder="Answer" rows="2" style="flex:2"></textarea><button type="button" class="button sp-pc-del">×</button></div>');});
        $('#sp-pc-add-tech').on('click',function(){$('#sp-pc-tech').append('<div class="sp-pc-tech-row" style="display:flex;gap:6px;margin-bottom:6px"><input type="text" name="sp_tech_k[]" placeholder="Label" style="flex:1"><input type="text" name="sp_tech_v[]" placeholder="Value" style="flex:2"><button type="button" class="button sp-pc-del">×</button></div>');});
        $(document).on('click','.sp-pc-del',function(){$(this).parent().remove();});
        $('.sp-pc-gal-btn').on('click',function(e){e.preventDefault();var t=$(this).data('target');var f=wp.media({title:'Select Images',multiple:'add',library:{type:'image'}});f.on('select',function(){var ids=[],h='';f.state().get('selection').each(function(a){a=a.toJSON();ids.push(a.id);h+='<img src="'+(a.sizes&&a.sizes.thumbnail?a.sizes.thumbnail.url:a.url)+'" style="width:64px;height:64px;object-fit:cover;border-radius:4px">';});$('#'+t).val(ids.join(','));$('#'+t+'_preview').html(h);});f.open();});
        $('.sp-pc-gal-clear').on('click',function(){var t=$(this).data('target');$('#'+t).val('');$('#'+t+'_preview').html('');});
    });
    </script>
    <?php
}

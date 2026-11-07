<?php
/**
 * Precast — RFQ / Quotation form: handler, storage and emails.
 * (Brief: Priority 17, 31, 32)
 *
 * The form itself is rendered by template-parts/precast/rfq-form.php.
 * Submissions are stored as a private "RFQ" post type (admin only) and
 * emailed to the company plus an automatic copy to the customer.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

/** Allowed upload types (Brief: PDF DWG DXF Excel Word JPG PNG ZIP). */
function sp_rfq_allowed_ext(): array {
    return ['pdf', 'dwg', 'dxf', 'xls', 'xlsx', 'csv', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp', 'zip', 'rar', '7z'];
}
function sp_rfq_max_bytes(): int {
    $ini = wp_max_upload_size();
    return min($ini, 30 * MB_IN_BYTES);
}

/**
 * Field definitions shared by renderer + handler.
 * Mirrors the reference site's quote form (precastuae.ae/contact/): 3 steps —
 * Contact / Project / Details — plus a drawing upload for "Send Drawing" links.
 */
function sp_rfq_fields(): array {
    return [
        'contact'  => ['step' => 1, 'label' => 'Contact Name',     'type' => 'text',  'required' => true,  'ph' => 'Your Name'],
        'phone'    => ['step' => 1, 'label' => 'Mobile Number',    'type' => 'tel',   'required' => true,  'ph' => '+971 50 ...'],
        'email'    => ['step' => 1, 'label' => 'Email Address',    'type' => 'email', 'required' => true,  'ph' => 'name@company.com'],
        'quantity' => ['step' => 2, 'label' => 'Quantity',         'type' => 'select','required' => false, 'ph' => 'Estimated quantity...', 'options' => ['1–25 Units', '25–50 Units', '50–100 Units', '100–500 Units', '500+ Units']],
        'emirate'  => ['step' => 2, 'label' => 'Emirate',          'type' => 'select','required' => false, 'ph' => 'Select Emirate...', 'options' => ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain']],
        'delivery' => ['step' => 2, 'label' => 'Delivery',         'type' => 'select','required' => false, 'ph' => 'When do you need it?', 'options' => ['ASAP (24–48h)', 'Within 7 Days', 'Within 2 Weeks', 'Flexible']],
        'location' => ['step' => 2, 'label' => 'Project Location', 'type' => 'text',  'required' => false, 'ph' => 'Delivery location...'],
        'message'  => ['step' => 3, 'label' => 'Message / Details','type' => 'textarea', 'required' => true, 'ph' => 'Please describe your requirement (Quantity, Dimensions, Delivery Location)...'],
    ];
}

/** "Product Interest" cards: product slug => [label, image attachment ID]. */
function sp_rfq_products(): array {
    return [
        'jersey-barrier'  => ['Concrete Barriers',       8],
        'precast-bunker'  => ['Bunkers & Shelters',      13],
        't-wall'          => ['T-Walls / Blast Walls',   208],
        'manhole'         => ['Manholes & Chambers',     212],
        'box-culvert'     => ['Box Culverts & Channels', 211],
        'custom-precast'  => ['Custom Precast',          15],
        'wheel-stopper'   => ['Wheel Stoppers',          18],
        'masonry-block'   => ['Masonry Blocks',          23],
        'hoarding-block'  => ['Hoarding Blocks',         28],
        'plastic-barrier' => ['Plastic Barriers',        33],
    ];
}

/** Map a free-text product name (from ?product=) to a Product Interest card. */
function sp_rfq_match_product(string $text): string {
    $t = strtolower($text);
    if ($t === '') return '';
    $map = [
        'plastic' => 'plastic-barrier', 'water' => 'plastic-barrier', 'wheel' => 'wheel-stopper', 'hoarding' => 'hoarding-block',
        'masonry' => 'masonry-block', 'block' => 'masonry-block', 't-wall' => 't-wall', 'blast' => 't-wall',
        'bunker' => 'precast-bunker', 'shelter' => 'precast-bunker', 'manhole' => 'manhole', 'chamber' => 'manhole',
        'culvert' => 'box-culvert', 'channel' => 'box-culvert', 'c-type' => 'box-culvert', 'trough' => 'manhole', 'slab' => 'manhole',
        'barrier' => 'jersey-barrier', 'jersey' => 'jersey-barrier', 'custom' => 'custom-precast', 'heavy' => 'custom-precast',
    ];
    foreach ($map as $k => $slug) if (strpos($t, $k) !== false) return $slug;
    return 'custom-precast';
}
function sp_rfq_checkboxes(): array {
    return [
        'custom_mould'    => 'Custom mould required',
        'transport'       => 'Transport required',
        'crane_loading'   => 'Crane loading required',
        'crane_offload'   => 'Crane offloading required',
        'submittal'       => 'Technical submittal required',
        'shop_drawing'    => 'Shop drawing required',
    ];
}

/** AJAX handler. */
function sp_rfq_submit_handler() {
    if (!check_ajax_referer('sp_rfq_nonce', 'sp_nonce', false)) {
        wp_send_json_error(['message' => 'Security check failed. Please refresh the page and try again.']);
    }
    // Honeypot
    if (!empty($_POST['website_url'])) {
        wp_send_json_success(['message' => 'Thank you. Your request has been received.']);
    }

    $fields = sp_rfq_fields();
    $data   = [];
    $errors = [];
    foreach ($fields as $key => $f) {
        $raw = $_POST[$key] ?? '';
        $val = $f['type'] === 'textarea' ? sanitize_textarea_field($raw) : ($f['type'] === 'email' ? sanitize_email($raw) : sanitize_text_field($raw));
        if ($f['required'] && $val === '') $errors[] = $f['label'] . ' is required.';
        if ($f['type'] === 'email' && $val && !is_email($val)) $errors[] = 'Please enter a valid email address.';
        if ($f['type'] === 'select' && $val !== '' && !in_array($val, $f['options'], true)) $val = '';
        $data[$key] = $val;
    }
    // Product Interest (one or more cards)
    $cards  = sp_rfq_products();
    $picked = array_values(array_intersect(array_map('sanitize_key', (array) wp_unslash($_POST['products'] ?? [])), array_keys($cards)));
    if (!$picked) $errors[] = 'Please select at least one product.';
    $data['product'] = implode(', ', array_map(fn($s) => $cards[$s][0], $picked));
    if ($errors) wp_send_json_error(['message' => implode(' ', $errors)]);

    $checks = [];
    foreach (sp_rfq_checkboxes() as $k => $label) {
        if (!empty($_POST['req'][$k])) $checks[] = $label;
    }
    $data['reference_project'] = sanitize_text_field($_POST['reference_project'] ?? '');
    $data['intent']            = sanitize_text_field($_POST['intent'] ?? '');
    $data['source_url']        = esc_url_raw($_POST['source_url'] ?? '');

    // ── Files ─────────────────────────────────────────────────────────────────
    $saved_files = [];
    if (!empty($_FILES['files']) && is_array($_FILES['files']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        $allowed = sp_rfq_allowed_ext();
        $max     = sp_rfq_max_bytes();
        $count   = count($_FILES['files']['name']);
        if ($count > 10) wp_send_json_error(['message' => 'Please upload a maximum of 10 files.']);

        // Dedicated folder, non-guessable, no directory listing.
        $upload = wp_upload_dir();
        $token  = wp_generate_password(16, false, false);
        $subdir = '/rfq/' . date('Y/m') . '/' . $token;
        $target = $upload['basedir'] . $subdir;
        wp_mkdir_p($target);
        if (!file_exists($upload['basedir'] . '/rfq/index.html')) {
            @file_put_contents($upload['basedir'] . '/rfq/index.html', '');
            @file_put_contents($upload['basedir'] . '/rfq/.htaccess', "Options -Indexes\n");
        }

        for ($i = 0; $i < $count; $i++) {
            if ($_FILES['files']['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
            if ($_FILES['files']['error'][$i] !== UPLOAD_ERR_OK) {
                wp_send_json_error(['message' => 'One of the files could not be uploaded (error ' . (int) $_FILES['files']['error'][$i] . ').']);
            }
            $name = sanitize_file_name($_FILES['files']['name'][$i]);
            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) {
                wp_send_json_error(['message' => "File type .$ext is not allowed. Allowed: PDF, DWG, DXF, Excel, Word, JPG, PNG, ZIP."]);
            }
            if ((int) $_FILES['files']['size'][$i] > $max) {
                wp_send_json_error(['message' => "File $name is larger than " . size_format($max) . '.']);
            }
            $dest = $target . '/' . wp_unique_filename($target, $name);
            if (!@move_uploaded_file($_FILES['files']['tmp_name'][$i], $dest)) {
                wp_send_json_error(['message' => "File $name could not be saved. Please try again or email it to us."]);
            }
            @chmod($dest, 0644);
            $saved_files[] = ['name' => basename($dest), 'url' => $upload['baseurl'] . $subdir . '/' . basename($dest), 'size' => filesize($dest)];
        }
    }

    // ── Store submission ─────────────────────────────────────────────────────
    $lines = ['Product Interest: ' . $data['product']];
    foreach ($fields as $key => $f) {
        if ($data[$key] !== '') $lines[] = $f['label'] . ': ' . $data[$key];
    }
    if ($data['reference_project']) $lines[] = 'Reference Project: ' . $data['reference_project'];
    if ($data['intent'])            $lines[] = 'Request Type: ' . $data['intent'];
    if ($checks)                    $lines[] = 'Requirements: ' . implode(', ', $checks);
    if ($saved_files) {
        $lines[] = 'Files:';
        foreach ($saved_files as $sf) $lines[] = '  - ' . $sf['name'] . ' (' . size_format($sf['size']) . '): ' . $sf['url'];
    }
    if ($data['source_url']) $lines[] = 'Submitted from: ' . $data['source_url'];
    $lines[] = 'IP: ' . sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $body_txt = implode("\n", $lines);

    $post_id = wp_insert_post([
        'post_type'    => 'sp_rfq',
        'post_status'  => 'private',
        'post_title'   => sprintf('%s — %s (%s)', $data['contact'], $data['product'], date_i18n('d M Y H:i')),
        'post_content' => $body_txt,
    ]);
    if ($post_id) {
        foreach ($data as $k => $v) update_post_meta($post_id, '_rfq_' . $k, $v);
        update_post_meta($post_id, '_rfq_requirements', $checks);
        update_post_meta($post_id, '_rfq_files', $saved_files);
    }

    // ── Emails ───────────────────────────────────────────────────────────────
    $c  = sp_company();
    $to = array_unique(array_filter([$c['email'], get_option('admin_email')]));
    $subject = sprintf('[RFQ] %s — %s%s', $data['contact'], $data['product'], $data['quantity'] ? ' × ' . $data['quantity'] : '');
    $headers = ['Content-Type: text/plain; charset=UTF-8', 'From: Precast Al Turab Website <' . $c['email'] . '>', 'Reply-To: ' . $data['contact'] . ' <' . $data['email'] . '>'];
    $admin_body  = "New quotation request from precastalturab.ae\n\n" . $body_txt . "\n\n";
    if ($post_id) $admin_body .= 'View in WordPress: ' . admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";
    wp_mail($to, $subject, $admin_body, $headers);

    // Customer copy (Brief: "send an automatic email copy to the customer")
    $cust_body  = "Dear " . $data['contact'] . ",\n\n";
    $cust_body .= "Thank you. Your request has been received by Precast Al Turab. Our team will review your drawing and project requirements and respond with a quotation.\n\n";
    $cust_body .= "Summary of your request:\n" . implode("\n", array_filter($lines, function ($l) { return strpos($l, 'IP:') !== 0 && strpos($l, 'Submitted from') !== 0; })) . "\n\n";
    $cust_body .= "Phone: " . $c['phone'] . "\nWhatsApp: https://wa.me/" . $c['wa_digits'] . "\nEmail: " . $c['email'] . "\n\nPrecast Al Turab\n" . home_url('/');
    wp_mail($data['email'], 'Your quotation request — Precast Al Turab', $cust_body, ['Content-Type: text/plain; charset=UTF-8', 'From: Precast Al Turab <' . $c['email'] . '>']);

    wp_send_json_success([
        'message' => 'Thank you. Your request has been received by Precast Al Turab. Our team will review your drawing and project requirements.',
    ]);
}
/** Render the RFQ form (used by shortcode + contact page). */
function sp_rfq_form_html(array $opts = []): string {
    $o = wp_parse_args($opts, ['compact' => false, 'heading' => '', 'subtext' => '']);
    ob_start();
    get_template_part('template-parts/precast/rfq-form', null, $o);
    return ob_get_clean();
}

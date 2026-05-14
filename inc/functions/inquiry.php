<?php
/**
 * Project inquiry AJAX form handler
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

function sp_inquiry_submit_handler() {
    if (!check_ajax_referer('sp_inquiry_nonce', 'sp_nonce', false)) {
        wp_send_json_error(__('Security check failed. Please refresh the page and try again.', 'sublimeplus'));
    }

    $company  = sanitize_text_field($_POST['company']  ?? '');
    $contact  = sanitize_text_field($_POST['contact']  ?? '');
    $email    = sanitize_email($_POST['email']          ?? '');
    $phone_no = sanitize_text_field($_POST['phone_no'] ?? '');
    $emirate  = sanitize_text_field($_POST['emirate']  ?? '');
    $product  = sanitize_text_field($_POST['product']  ?? '');
    $message  = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($company) || empty($contact) || empty($email)) {
        wp_send_json_error(__('Please fill in Company Name, Contact Name, and Email.', 'sublimeplus'));
    }

    if (!is_email($email)) {
        wp_send_json_error(__('Please enter a valid email address.', 'sublimeplus'));
    }

    $to      = get_option('admin_email');
    $subject = sprintf('[Quote Request] %s — %s', $company, $product ?: 'General Inquiry');

    $body  = "New quote request from the website:\n\n";
    $body .= "Company:   $company\n";
    $body .= "Contact:   $contact\n";
    $body .= "Email:     $email\n";
    if ($phone_no) $body .= "Phone:     $phone_no\n";
    if ($emirate)  $body .= "Location:  $emirate\n";
    if ($product)  $body .= "Product:   $product\n";
    if ($message) {
        $body .= "\nMessage:\n$message\n";
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: $contact <$email>",
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(__("Thank you! We've received your request and will be in touch within 24 hours.", 'sublimeplus'));
    } else {
        wp_send_json_error(__('Your message could not be sent. Please email us directly.', 'sublimeplus'));
    }
}
add_action('wp_ajax_sp_inquiry_submit',        'sp_inquiry_submit_handler');
add_action('wp_ajax_nopriv_sp_inquiry_submit', 'sp_inquiry_submit_handler');

<?php
/**
 * Breadcrumbs template
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 */

if (class_exists('WooCommerce', false)) {
    if (is_woocommerce()) {
        return;
    }
}
if (get_theme_mod('Sublimeplus_disable_breadcrumbs', '0') == '1') {
    return;
}
if ((is_single() || is_page()) && get_post_meta(get_the_ID(), 'Sublimeplus_disable_breadcrumbs', true) == 1) {
    return;
}
?>
<div class="wrap-breadcrumb">
    <div class="container">
        <?php Sublimeplus_breadcrumbs(esc_html__('Home', 'sublimeplus'), '', 'sublimeplus-separator'); ?>
    </div>
</div>
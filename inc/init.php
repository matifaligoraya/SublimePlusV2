<?php
/**
 * Theme functions and definitions
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 
 */

/**
 * Theme functions
 * All theme functions will load below.
 */
include SUBLIMEPLUS_DIR.'inc/functions/helper.php';
include SUBLIMEPLUS_DIR.'inc/functions/features.php';
include SUBLIMEPLUS_DIR.'inc/functions/sidebars.php';
include SUBLIMEPLUS_DIR.'inc/functions/scripts.php';
include SUBLIMEPLUS_DIR.'inc/functions/plugins.php';
include SUBLIMEPLUS_DIR.'inc/functions/functions.php';
include SUBLIMEPLUS_DIR.'inc/functions/hooks.php';
/**
 * WooCommerce theme functions
 * All hooks, functions, features will load below.
 */
if (class_exists('WooCommerce', false)) {
    require SUBLIMEPLUS_DIR.'inc/woocommerce/woocommerce.php';
}

/**
 * Theme customize and metaboxes
 */
require SUBLIMEPLUS_DIR.'inc/metaboxes/meta-boxes.php';
require SUBLIMEPLUS_DIR.'inc/customize/customize-style.php';
require SUBLIMEPLUS_DIR.'inc/customize/customize-options.php';
require SUBLIMEPLUS_DIR.'inc/customize/footer-settings.php';

/**
 * WPBakery Page Builder — custom homepage elements
 */
require SUBLIMEPLUS_DIR.'inc/functions/wpbakery-elements.php';

/**
 * Products CPT + meta box
 */
require SUBLIMEPLUS_DIR.'inc/cpt/sp-products.php';
require SUBLIMEPLUS_DIR.'inc/metaboxes/sp-product-metabox.php';

/**
 * Testimonials CPT + meta box
 */
require SUBLIMEPLUS_DIR.'inc/cpt/sp-testimonials.php';
require SUBLIMEPLUS_DIR.'inc/metaboxes/sp-testimonial-metabox.php';

/**
 * Projects CPT + meta box
 */
require SUBLIMEPLUS_DIR.'inc/cpt/sp-projects.php';
require SUBLIMEPLUS_DIR.'inc/metaboxes/sp-project-metabox.php';

/**
 * Supply Capability CPT + meta box
 */
require SUBLIMEPLUS_DIR.'inc/cpt/sp-supply.php';
require SUBLIMEPLUS_DIR.'inc/metaboxes/sp-supply-metabox.php';

/**
 * Inquiry AJAX handler (front-end quote form)
 */
require SUBLIMEPLUS_DIR.'inc/functions/inquiry.php';

/**
 * One-click importers (Tools menu) — idempotent, safe to keep
 */
if (is_admin()) {
    require SUBLIMEPLUS_DIR.'inc/tools/sp-import-products.php';
    require SUBLIMEPLUS_DIR.'inc/tools/sp-import-clients.php';
    require SUBLIMEPLUS_DIR.'inc/tools/sp-import-projects.php';
    require SUBLIMEPLUS_DIR.'inc/tools/sp-import-supply.php';
}


/**
 * Elementor widgets
 */
require SUBLIMEPLUS_DIR.'inc/elementor/elementor.php';

<?php
/**
 * Elementor Integration
 *
 * @package SublimePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Initialize Elementor widgets
 */
function sublimeplus_elementor_widgets_init() {
    // Check if Elementor is active
    if ( ! did_action( 'elementor/loaded' ) ) {
        return;
    }

    // Include widget files
    require_once SUBLIMEPLUS_DIR . 'inc/elementor/widgets/client-slider.php';
}
add_action( 'elementor/widgets/widgets_registered', 'sublimeplus_elementor_widgets_init' );
<?php
/**
 * Product category pages (/product-category/{slug}/) use the same layout as the
 * products archive: category filter, product cards and quotation CTA.
 * archive-sp_product.php reads the active category from get_queried_object().
 *
 * @package SublimePlusV2
 * @since   1.2.1
 */
defined('ABSPATH') || exit;
require locate_template('archive-sp_product.php');

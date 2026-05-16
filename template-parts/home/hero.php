<?php
/**
 * Homepage — Hero section
 *
 * Delegates entirely to the product showcase banner.
 * Products are queried directly inside banner.php from sp_product CPT.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

get_template_part('template-parts/home/banner', null, $args ?? []);

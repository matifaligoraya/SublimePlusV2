<?php
/**
 * Enable excerpt support on pages
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_post_type_support('page', 'excerpt');

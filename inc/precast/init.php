<?php
/**
 * Precast Al Turab — module bootstrap.
 *
 * Loaded from inc/init.php (after_setup_theme). Creates the core class,
 * which loads the helpers and feature classes and registers every hook
 * through Precast_Loader (see class-precast.php).
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

if (!defined('PRECAST_VERSION')) {
    define('PRECAST_VERSION', '1.2.1');
}

require_once __DIR__ . '/class-precast.php';

/** Start the Precast modules. */
function run_precast() {
    $precast = new Precast();
    $precast->run();
}
run_precast();

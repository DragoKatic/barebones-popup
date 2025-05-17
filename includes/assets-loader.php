<?php
/**
 * Assets loader for Barebones PopUp plugin
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load plugin textdomain for translations.
 */
function barebones_popup_load_textdomain() {
    $plugin_rel_path = basename(dirname(__DIR__)) . '/assets/languages';
    load_plugin_textdomain('barebones-popup', false, $plugin_rel_path);
}
add_action('init', 'barebones_popup_load_textdomain');

function barebones_popup_enqueue_admin_styles() {
    wp_enqueue_style( 'jetbrains-mono', 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap', array(), null );
}
add_action( 'admin_enqueue_scripts', 'barebones_popup_enqueue_admin_styles' );

/**
 * Enqueue plugin CSS and JS.
 */
function barebones_popup_enqueue_assets() {
    // Enqueue main popup style.
    wp_enqueue_style(
        'barebones-popup-style',
        plugin_dir_url( __FILE__ ) . '../assets/css/style.css',
        array(),
        '1.0' // Version of the plugin.
    );

    // Enqueue popup JavaScript.
    wp_enqueue_script(
        'barebones-popup-script',
        plugin_dir_url( __FILE__ ) . '../assets/js/script.js',
        array(),
        '1.0', // Version of the plugin.
        true // Load script in the footer.
    );
}
add_action( 'wp_enqueue_scripts', 'barebones_popup_enqueue_assets' );

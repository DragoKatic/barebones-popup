<?php
/**
 * Assets loader for Barebones PopUp plugin.
 *
 * Handles the registration and enqueuing of frontend and admin styles and scripts,
 * as well as loading the plugin textdomain for localization.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load plugin textdomain for translations.
 *
 * Allows localization by loading .mo and .po files from the /languages directory.
 */
function barebones_popup_load_textdomain() {
	$plugin_rel_path = basename( dirname( __DIR__ ) ) . '/languages';
	// phpcs:ignore PluginCheck.CodeAnalysis.DiscouragedFunctions.load_plugin_textdomainFound
	load_plugin_textdomain( 'barebones-popup', false, $plugin_rel_path );
}
add_action( 'init', 'barebones_popup_load_textdomain' );

/**
 * Enqueue frontend CSS and JS for the popup display.
 *
 * Loads the custom popup styling and functionality on the site’s frontend.
 */
function barebones_popup_enqueue_assets() {
	$version = '1.0'; // Update to filemtime() for dynamic cache busting if needed.

	wp_enqueue_style(
		'barebones-popup-style',
		plugin_dir_url( __FILE__ ) . '../assets/css/style.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'barebones-popup-script',
		plugin_dir_url( __FILE__ ) . '../assets/js/script.js',
		array(),
		$version,
		true // Load in footer.
	);
}
add_action( 'wp_enqueue_scripts', 'barebones_popup_enqueue_assets' );

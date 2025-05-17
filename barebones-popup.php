<?php
/**
 * Plugin Name: Barebones PopUp
 * Plugin URI: https://github.com/DragoKatic/barebones-popup
 * Description: Barebones PopUp is a minimalist WordPress plugin for displaying customizable popup windows. 
 * Version: 1.0
 * Requires at least: 5.8
 * Tested up to: 6.9
 * Requires PHP: 7.4
 * Author: Drago Katić
 * Author URI: https://dragokatic.github.io/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: barebones-popup
 * Domain Path: /languages
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants.
define( 'BAREBONES_POPUP_PATH', plugin_dir_path( __FILE__ ) );
define( 'BAREBONES_POPUP_URL', plugin_dir_url( __FILE__ ) );
define( 'BAREBONES_POPUP_VERSION', '1.0' );
define( 'BAREBONES_POPUP_MINIMUM_WP_VERSION', '5.8' );

// Load required plugin files.
require_once BAREBONES_POPUP_PATH . 'includes/install.php';
require_once BAREBONES_POPUP_PATH . 'includes/db-handler.php';
require_once BAREBONES_POPUP_PATH . 'includes/assets-loader.php';
require_once BAREBONES_POPUP_PATH . 'includes/uninstall.php';

// Hooks for activation and uninstall.
register_activation_hook( __FILE__, 'barebones_popup_create_table' );
register_uninstall_hook( __FILE__, 'barebones_popup_delete_table' );

// Load admin functionality only in the dashboard.
if ( is_admin() ) {
    require_once BAREBONES_POPUP_PATH . 'admin/admin-page.php';
}

// Render popup automatically in footer on the homepage.
function barebones_popup_render_homepage_popup() {
    if ( is_front_page() && ! is_admin() ) {
        include BAREBONES_POPUP_PATH . 'templates/display-popup.php';
    }
}
add_action( 'wp_footer', 'barebones_popup_render_homepage_popup' );

// Shortcode [barebones_popup] to insert popup anywhere.
function barebones_popup_shortcode() {
    ob_start();
    include BAREBONES_POPUP_PATH . 'templates/display-popup.php';
    return ob_get_clean();
}
add_shortcode( 'barebones_popup', 'barebones_popup_shortcode' );

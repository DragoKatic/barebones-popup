<?php
/**
 * Plugin Name: Barebones PopUp
 * Plugin URI: https://github.com/DragoKatic/barebones-popup
 * Description: Barebones PopUp is a minimalist WordPress plugin for displaying customizable popup windows.
 * Version: 1.0.0
 * Requires at least: 6.8
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * Author: Drago Katić
 * Author URI: https://dragokatic.github.io/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: barebones-popup
 * Domain Path: /languages
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Prevent multiple inclusions of this plugin file.
if ( defined( 'BAREBONES_POPUP_LOADED' ) ) {
    return;
}
define( 'BAREBONES_POPUP_LOADED', true );

// Define essential plugin path onstant.
define( 'BAREBONES_POPUP_PATH', plugin_dir_path( __FILE__ ) );
define( 'BAREBONES_POPUP_VERSION', '1.0.0' );
define( 'BAREBONES_POPUP_MINIMUM_WP_VERSION', '6.8' );

// Load core plugin files.
require_once BAREBONES_POPUP_PATH . 'includes/install.php';
require_once BAREBONES_POPUP_PATH . 'includes/db-handler.php';
require_once BAREBONES_POPUP_PATH . 'includes/assets-loader.php';
require_once BAREBONES_POPUP_PATH . 'includes/uninstall.php';

// Register hooks for plugin activation and uninstallation.
register_activation_hook( __FILE__, 'barebones_popup_create_table' );
register_uninstall_hook( __FILE__, 'barebones_popup_delete_table' );

// Load admin-specific functionality only in the WordPress dashboard.
if ( is_admin() ) {
    require_once BAREBONES_POPUP_PATH . 'admin/admin-page.php';
}

/**
 * Automatically render the popup on the homepage footer.
 */
function barebones_popup_render_homepage_popup() {
    if ( is_front_page() && ! is_admin() ) {
        include BAREBONES_POPUP_PATH . 'templates/display-popup.php';
    }
}
add_action( 'wp_footer', 'barebones_popup_render_homepage_popup' );

/**
 * Shortcode [barebones_popup] to display the popup anywhere within content.
 *
 * @return string Rendered popup HTML.
 */
function barebones_popup_shortcode() {
    ob_start();
    include BAREBONES_POPUP_PATH . 'templates/display-popup.php';
    return ob_get_clean();
}
add_shortcode( 'barebones_popup', 'barebones_popup_shortcode' );

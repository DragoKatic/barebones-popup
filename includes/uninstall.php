<?php
/**
 * Uninstallation functions for Barebones PopUp plugin.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Delete the database table during plugin uninstall.
 *
 * @return void
 */
function barebones_popup_delete_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'barebones_popup'; // WordPress table prefix.

    // Drop the table if it exists.
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

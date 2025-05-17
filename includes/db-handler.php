<?php
/**
 * Database handler functions for Barebones PopUp plugin
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Save or update popup data in the database.
 *
 * @param string $css     The custom CSS for the popup.
 * @param string $content The HTML content of the popup.
 *
 * @return int|false Number of rows affected or false on error.
 */
function barebones_popup_save_data( $css, $content ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'barebones_popup';

    // Check if a popup with ID 1 already exists.
    $existing = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM $table_name WHERE id = %d",
            1
        )
    );

    if ( $existing ) {
        // Update existing record.
        return $wpdb->update(
            $table_name,
            array(
                'popup_css'     => $css,
                'popup_content' => $content,
                'created_at'    => current_time( 'mysql' ),
            ),
            array( 'id' => 1 ),
            array( '%s', '%s', '%s' ),
            array( '%d' )
        );
    } else {
        // Insert new record (should rarely happen).
        return $wpdb->insert(
            $table_name,
            array(
                'id'            => 1,
                'popup_css'     => $css,
                'popup_content' => $content,
            ),
            array( '%d', '%s', '%s' )
        );
    }
}

/**
 * Fetch popup data from the database.
 *
 * @return object|null Database row object or null if not found.
 */
function barebones_popup_get_data() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'barebones_popup';

    return $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            1
        )
    );
}

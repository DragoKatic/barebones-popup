<?php
/**
 * Admin page functionality for the Barebones PopUp plugin.
 *
 * This file defines the admin menu and handles form submission
 * for customizing the popup content and CSS styling.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register admin menu item for the plugin.
add_action( 'admin_menu', 'barebones_popup_add_admin_menu' );

/**
 * Adds a top-level menu item for Barebones PopUp in the WordPress admin.
 *
 * @return void
 */
function barebones_popup_add_admin_menu() {
    add_menu_page(
        __( 'Barebones PopUp', 'barebones-popup' ),
        __( 'Barebones PopUp', 'barebones-popup' ),
        'manage_options',
        'barebones-popup',
        'barebones_popup_admin_page',
        // Inline SVG as base64-encoded icon.
        'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTAwMCAxMDAwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IGZpbGw9IndoaXRlIiB4PSI1MzguNSIgeT0iNDk5LjUiIHdpZHRoPSIyNDkiIGhlaWdodD0iMjQ5Ii8+PHJlY3QgZmlsbD0id2hpdGUiIHg9IjE4Ny41IiB5PSI0NTIuNSIgd2lkdGg9IjI0OSIgaGVpZ2h0PSIyNDkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0zNDMuNyA1NTguNykgcm90YXRlKC02MCkiLz48cmVjdCBmaWxsPSJ3aGl0ZSIgeD0iNDAyLjUiIHk9IjE3MS41IiB3aWR0aD0iMjQ5IiBoZWlnaHQ9IjI0OSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTc3LjQgMzAzLjE2KSByb3RhdGUoLTMwKSIvPjwvc3ZnPg==',
        null
    );
}

/**
 * Renders the Barebones PopUp admin page content.
 *
 * Handles access control, nonce verification, form data sanitization,
 * and saving of popup CSS and content into the database.
 *
 * @return void
 */
function barebones_popup_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    require_once plugin_dir_path( __FILE__ ) . '../includes/db-handler.php';

    // Handle form submission and save settings if nonce is valid.
    if (
        isset( $_POST['barebones_popup_nonce'] ) &&
        wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['barebones_popup_nonce'] ) ), 'barebones_popup_save_settings' )
    ) {
        $popup_css     = isset( $_POST['popup_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['popup_css'] ) ) : '';
        $popup_content = isset( $_POST['popup_content'] ) ? wp_kses_post( wp_unslash( $_POST['popup_content'] ) ) : '';

        $saved = barebones_popup_save_data( $popup_css, $popup_content );

        if ( $saved ) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved successfully.', 'barebones-popup' ) . '</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Failed to save settings.', 'barebones-popup' ) . '</p></div>';
        }
    }

    // Display the settings form.
    include plugin_dir_path( __FILE__ ) . '../templates/admin-form.php';
}

<?php
/**
 * Admin page functionality for Barebones PopUp
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add menu item to WordPress admin.
add_action( 'admin_menu', 'barebones_popup_add_admin_menu' );

/**
 * Register top-level admin menu for Barebones PopUp.
 */
function barebones_popup_add_admin_menu() {
    add_menu_page(
        __( 'Barebones PopUp', 'barebones-popup' ), // Translators: Plugin name.
        __( 'Barebones PopUp', 'barebones-popup' ), // Translators: Menu title.
        'manage_options',
        'barebones-popup',
        'barebones_popup_admin_page',
        'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTAwMCAxMDAwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IGZpbGw9IndoaXRlIiB4PSI1MzguNSIgeT0iNDk5LjUiIHdpZHRoPSIyNDkiIGhlaWdodD0iMjQ5Ii8+PHJlY3QgZmlsbD0id2hpdGUiIHg9IjE4Ny41IiB5PSI0NTIuNSIgd2lkdGg9IjI0OSIgaGVpZ2h0PSIyNDkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0zNDMuNyA1NTguNykgcm90YXRlKC02MCkiLz48cmVjdCBmaWxsPSJ3aGl0ZSIgeD0iNDAyLjUiIHk9IjE3MS41IiB3aWR0aD0iMjQ5IiBoZWlnaHQ9IjI0OSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTc3LjQgMzAzLjE2KSByb3RhdGUoLTMwKSIvPjwvc3ZnPg==',
        null
    );
}

/**
 * Display the admin page content.
 */
function barebones_popup_admin_page() {
    // Check user capabilities.
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    require_once plugin_dir_path( __FILE__ ) . '../includes/db-handler.php';

    // Handle form submission.
    if (
        isset( $_POST['barebones_popup_nonce'] ) &&
        wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['barebones_popup_nonce'] ) ), 'barebones_popup_save_settings' )
    ) {
        // Sanitize popup CSS (pure text, no HTML).
        $popup_css = sanitize_textarea_field( wp_unslash( $_POST['popup_css'] ) );

        // Allow only safe HTML for popup content.
        $popup_content = wp_kses_post( wp_unslash( $_POST['popup_content'] ) );

        $saved = barebones_popup_save_data( $popup_css, $popup_content );

        if ( $saved ) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved successfully.', 'barebones-popup' ) . '</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Failed to save settings.', 'barebones-popup' ) . '</p></div>';
        }
    }

    // Include admin form template.
    include plugin_dir_path( __FILE__ ) . '../templates/admin-form.php';
}

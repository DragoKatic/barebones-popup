<?php
/**
 * Admin settings form for Barebones PopUp plugin.
 *
 * Displays the settings page in the WordPress admin area where users
 * can edit the popup CSS and HTML content. Handles output of
 * current values loaded from the database.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Retrieve the latest popup data from the database.
$data = barebones_popup_get_data();
$popup_css     = isset( $data->popup_css ) ? $data->popup_css : '';
$popup_content = isset( $data->popup_content ) ? $data->popup_content : '';
?>

<div class="wrap">
    <h1><?php echo wp_kses_post( __( 'Barebones PopUp Settings', 'barebones-popup' ) ); ?></h1>

    <p><?php echo wp_kses_post( __( 'Use the fields below to customize your popup\'s appearance and content. Save your changes to update the popup displayed on your site.', 'barebones-popup' ) ); ?></p>

    <form method="post" action="">
        <?php wp_nonce_field( 'barebones_popup_save_settings', 'barebones_popup_nonce' ); ?>

        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">
                    <label for="popup_css"><?php echo wp_kses_post( __( 'Popup (CSS)', 'barebones-popup' ) ); ?></label>
                </th>
                <td>
                    <textarea
                        name="popup_css"
                        id="popup_css"
                        rows="12"
                        cols="80"
                        class="large-text code"
                    ><?php echo esc_textarea( $popup_css ); ?></textarea>
                    <p class="description"><?php echo wp_kses_post( __( 'Customize the CSS that styles your popup window.', 'barebones-popup' ) ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="popup_content"><?php echo wp_kses_post( __( 'Popup (HTML)', 'barebones-popup' ) ); ?></label>
                </th>
                <td>
                    <textarea
                        name="popup_content"
                        id="popup_content"
                        rows="12"
                        cols="80"
                        class="large-text code"
                    ><?php echo esc_textarea( $popup_content ); ?></textarea>
                    <p class="description"><?php echo wp_kses_post( __( 'HTML content for your popup. Use standard tags (div, h4, p, etc.).', 'barebones-popup' ) ); ?></p>
                </td>
            </tr>
        </table>

        <?php submit_button( __( 'Save Settings', 'barebones-popup' ) ); ?>
    </form>
</div>

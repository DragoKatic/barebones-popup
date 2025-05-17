<?php
/**
 * Front-end popup display template for Barebones PopUp plugin.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Fetch the popup content by fixed ID = 1.
global $wpdb;

$table_name = $wpdb->prefix . 'barebones_popup';
$result     = $wpdb->get_row(
    $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", 1 )
);

// If no popup content is found, exit.
if ( ! $result ) {
    return;
}
?>

<!-- Popup HTML -->
<div id="ac-wrapper" class="popup-overlay">
    <div class="popup-inner">
        <span class="close">&times;</span>

        <?php if ( ! empty( $result->popup_content ) ) : ?>
            <div class="popup-content">
                <?php echo wp_kses_post( translate( $result->popup_content, 'barebones-popup' ) ); ?>
                <?php /* echo wp_kses_post( $result->popup_content );*/ ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $result->popup_css ) ) : ?>
            <style>
                /* Scoped popup CSS */
                #ac-wrapper {
                    <?php echo wp_strip_all_tags( $result->popup_css ); ?>
                }
            </style>
        <?php endif; ?>
    </div>
</div>

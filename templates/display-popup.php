<?php
/**
 * Front-end popup display template for Barebones PopUp plugin.
 *
 * Outputs the popup HTML and scoped CSS on the front-end.
 * Loads popup data from the database with caching.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure the database handler function is available.
if ( ! function_exists( 'barebones_popup_get_data' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '../includes/db-handler.php';
}

// Retrieve popup data from cache or database.
$result = barebones_popup_get_data();

// Abort if no popup data is found.
if ( ! $result ) {
	return;
}
?>

<!-- Popup HTML structure -->
<div id="ac-wrapper" class="popup-overlay">
	<div class="popup-inner">
		<span class="close">&times;</span>

		<?php if ( ! empty( $result->popup_content ) ) : ?>
			<div class="popup-content">
				<?php echo wp_kses_post( $result->popup_content ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $result->popup_css ) ) : ?>
			<style>
				/* Scoped popup CSS injected inline */
				#ac-wrapper {
					<?php echo esc_html( $result->popup_css ); ?>
				}
			</style>
		<?php endif; ?>
	</div>
</div>

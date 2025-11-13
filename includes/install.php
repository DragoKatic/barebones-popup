<?php
/**
 * Installation functions for Barebones PopUp plugin.
 *
 * Handles creation of the plugin's custom database table
 * and inserts default popup content during plugin activation.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create the database table and insert default data during plugin activation.
 *
 * Checks if the table already contains the default row. If not, creates
 * the table and inserts default CSS and popup content.
 *
 * @return void
 */
function barebones_popup_create_table() {
	global $wpdb;

	$table_name      = $wpdb->prefix . 'barebones_popup';
	$charset_collate = $wpdb->get_charset_collate();

	$cache_key  = 'barebones_popup_row_1';

	// Attempt to retrieve cached ID of the default row.
	$existing = wp_cache_get( $cache_key );

	if ( false === $existing ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$existing = $wpdb->get_var( "SELECT id FROM {$table_name} WHERE id = 1" );
		wp_cache_set( $cache_key, $existing );
	}

	if ( ! $existing ) {
		// SQL statement to create the custom table.
		$sql = "CREATE TABLE {$table_name} (
			id INT(11) NOT NULL AUTO_INCREMENT,
			popup_css TEXT NOT NULL,
			popup_content TEXT NOT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	if ( ! $existing ) {
		// Default CSS styles for the popup content.
		$default_css = "
		/* Popup content text */
		.popup-content h4 {
			font-size: 24px;
			font-weight: 700;
			color: #ff911c;
			margin-top: 0;
		}
		.popup-content p {
			font-size: 16px;
			font-weight: 400;
			color: #ff911c;
			margin: 10px 0;
		}
		/* Link styled as button */
		.popup-inner a {
			display: inline-block;
			margin-top: 10px;
			padding: 12px 24px;
			font-size: 1rem;
			font-weight: 700;
			text-align: center;
			text-decoration: none;
			border-radius: 100px;
			background-color: #ff911c;
			color: #0d1321;
			border: 1px solid #0d1321;
			cursor: pointer;
			transition: 
			color 0.3s ease-in-out, 
			background-color 0.3s ease-in-out, 
			border-color 0.3s ease-in-out;
		}
		.popup-inner a:hover,
		.popup-inner a:focus,
		.popup-inner a:active {
			color: #ffffff;
			background-color: #ff911c;
			border-color: #ff911c;
		}
		";

		// Default popup HTML content.
		$default_content = '<h4>Welcome and thank you for using Barebones PopUp</h4><p>This plugin offers a minimalist admin interface.</p><p>To make significant adjustments, you will need to modify the HTML, CSS, and JavaScript code directly.</p><p><a class="custom-btn btn custom-link" href="https://dragokatic.github.io/" target="_blank">Developer Site</a></p>';

		// Insert default popup data into the table.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$wpdb->insert(
			$table_name,
			array(
				'id'            => 1,
				'popup_css'     => $default_css,
				'popup_content' => $default_content,
			),
			array( '%d', '%s', '%s' )
		);
	}
}

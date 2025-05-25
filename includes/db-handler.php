<?php
/**
 * Database handler functions for Barebones PopUp plugin.
 *
 * Provides functions to save, update, and retrieve popup data
 * from the custom database table with caching for performance.
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
 * Uses caching to minimize database queries for existing data.
 *
 * @param string $css     Custom CSS code for styling the popup.
 * @param string $content HTML content displayed inside the popup.
 *
 * @return int|false Number of rows affected on success, false on failure.
 */
function barebones_popup_save_data( $css, $content ) {
	global $wpdb;

	$table_name = $wpdb->prefix . 'barebones_popup';
	$cache_key  = 'barebones_popup_row_1';

	// Attempt to retrieve cached record ID.
	$existing = wp_cache_get( $cache_key );

	if ( false === $existing ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$existing = $wpdb->get_var( "SELECT id FROM {$table_name} WHERE id = 1" );
		wp_cache_set( $cache_key, $existing );
	}

	if ( $existing ) {
		// Update existing record.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$result = $wpdb->update(
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
		// Insert new record.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$result = $wpdb->insert(
			$table_name,
			array(
				'id'            => 1,
				'popup_css'     => $css,
				'popup_content' => $content,
			),
			array( '%d', '%s', '%s' )
		);
	}

	// Clear cached data after insert or update to ensure consistency.
	wp_cache_delete( $cache_key );

	return $result;
}

/**
 * Retrieve popup data from the database with object caching.
 *
 * Attempts to fetch the popup data from cache before querying the database.
 *
 * @return object|null Database row object containing popup data or null if none found.
 */
function barebones_popup_get_data() {
	global $wpdb;

	$cache_key = 'barebones_popup_row_1';
	$data      = wp_cache_get( $cache_key );

	if ( false === $data ) {
		$table_name = $wpdb->prefix . 'barebones_popup';

		// Table name cannot be parameterized.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$data = $wpdb->get_row( "SELECT * FROM {$table_name} WHERE id = 1" );

		wp_cache_set( $cache_key, $data );
	}

	return $data;
}

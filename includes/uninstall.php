<?php
/**
 * Uninstallation functions for Barebones PopUp plugin.
 *
 * Handles cleanup tasks when the plugin is uninstalled, such as
 * removing the custom database table.
 *
 * @package Barebones_PopUp
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Delete the plugin's custom database table upon uninstall.
 *
 * This function drops the table used to store popup data.
 *
 * @return void
 */
function barebones_popup_delete_table() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'barebones_popup';

	// Drop the table if it exists.
	// Using prepare() is not needed for table names and not recommended here.
	$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" ); // @codingStandardsIgnoreLine
}

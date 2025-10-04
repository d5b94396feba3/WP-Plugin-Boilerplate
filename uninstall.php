<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Get plugin slug from the file being uninstalled
$plugin_file = plugin_basename( __FILE__ );
$plugin_slug = dirname( $plugin_file );

// Delete options
$options = array(
    $plugin_slug . '_option_1',
    $plugin_slug . '_option_2',
);

foreach ( $options as $option ) {
    if ( get_option( $option ) ) {
        delete_option( $option );
    }
}

// Drop custom tables
global $wpdb;
$table_name = $wpdb->prefix . $plugin_slug . '_data';
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
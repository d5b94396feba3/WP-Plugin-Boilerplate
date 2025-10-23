<?php
defined( 'ABSPATH' ) || exit;

class Plugin_Activator {
    // Now accepts the slug to use dynamic option names
    public static function activate( $plugin_slug ) {
        // Example: Set a flag using the dynamic slug
        if ( ! get_option( $plugin_slug . '_activated' ) ) {
            add_option( $plugin_slug . '_activated', true );
        }
        
        // Flush rewrite rules for any custom post types
        flush_rewrite_rules();
        
        error_log( $plugin_slug . ' activated successfully' );
    }
}

<?php
class Plugin_Deactivator {
    // Now accepts the slug to use dynamic option/transient names
    public static function deactivate( $plugin_slug ) {
        // Clean up temporary data
        self::cleanup_temp_data( $plugin_slug );
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    private static function cleanup_temp_data( $plugin_slug ) {
        // Remove any temporary transients using the dynamic slug
        delete_transient( $plugin_slug . '_temp_data' );
        
        // Clear scheduled hooks if any using the dynamic slug
        wp_clear_scheduled_hook( $plugin_slug . '_daily_event' );
    }
}
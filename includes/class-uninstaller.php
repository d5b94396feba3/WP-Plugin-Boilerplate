<?php
defined( 'ABSPATH' ) || exit;

class Plugin_Uninstaller {
    
    /**
     * Plugin uninstall - COMPLETE removal when plugin is deleted
     */
    public static function uninstall( $plugin_slug ) {
        // Remove the database table and all data
        self::drop_database_table( $plugin_slug );
        
        // Clean up all plugin options
        self::cleanup_plugin_options( $plugin_slug );
        
        // Clean up any temporary data
        self::cleanup_temp_data( $plugin_slug );
        
        error_log( "AI Proposal System: Plugin uninstalled - all data removed" );
    }

    /**
     * Drop the database table when plugin is uninstalled
     */
    private static function drop_database_table( $plugin_slug ) {
        global $wpdb;
        
        // Generate the table name exactly how it was created
        $clean_slug_part = sanitize_key( $plugin_slug );
        $final_slug_part = str_replace('-', '_', $clean_slug_part); 
        $table_name = $wpdb->prefix . $final_slug_part;
        
        // Check if table exists before trying to drop it
        $table_exists = $wpdb->get_var( $wpdb->prepare(
            "SHOW TABLES LIKE %s", 
            $table_name
        ) );
        
        if ( $table_exists ) {
            // Drop the table using WordPress database functions
            $sql = "DROP TABLE IF EXISTS `$table_name`";
            $result = $wpdb->query( $sql );
            
            if ( $result !== false ) {
                error_log( "Successfully dropped table {$table_name}" );
            } else {
                error_log( "Failed to drop table {$table_name} - " . $wpdb->last_error );
            }
        } else {
            error_log( "Table {$table_name} does not exist, skipping drop." );
        }
    }

    /**
     * Clean up plugin options from the database
     */
    private static function cleanup_plugin_options( $plugin_slug ) {
        // Remove DocuSign settings
        delete_option( $plugin_slug . '_option_name' );
        delete_option( '_option_name' );        
    }

    private static function cleanup_temp_data( $plugin_slug ) {
        // Remove any temporary transients using the dynamic slug
        delete_transient( $plugin_slug . '_temp_data' );
    }
}

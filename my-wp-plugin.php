<?php
/**
 * Plugin Name: My Dynamic Plugin Name
 * Plugin URI:  https://example.com/my-plugin
 * Description: A brief description of my plugin.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: my-plugin-slug
 * Domain Path: /languages
 */

// Exit if accessed directly (security)
if (!defined('WPINC')) {
    die;
}

// --- Dynamic Name/Slug/Version Definitions ---

// Get the main plugin header data
$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version', 'TextDomain' => 'Text Domain', 'Name' => 'Plugin Name' ), 'plugin' );

// Define plugin constants based on the header data
if (!defined('MY_PLUGIN_NAME')) {
    define('MY_PLUGIN_NAME', $plugin_data['Name']); // "My Dynamic Plugin Name"
}
if (!defined('MY_PLUGIN_SLUG')) {
    // The Text Domain is the best value to use for the unique slug
    define('MY_PLUGIN_SLUG', $plugin_data['TextDomain']); // "my-plugin-slug"
}
if (!defined('MY_PLUGIN_VERSION')) {
    define('MY_PLUGIN_VERSION', $plugin_data['Version']); // "1.0.0"
}

// Define plugin paths
if (!defined('MY_PLUGIN_PATH')) {
    define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
if (!defined('MY_PLUGIN_URL')) {
    define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));
}

// --- Activation/Deactivation ---

// Use the dynamic slug in activation/deactivation hooks where options are set
function my_plugin_activate() {
    require_once MY_PLUGIN_PATH . 'includes/class-activator.php';
    Plugin_Activator::activate( MY_PLUGIN_SLUG );
}
register_activation_hook(__FILE__, 'my_plugin_activate');

function my_plugin_deactivate() {
    require_once MY_PLUGIN_PATH . 'includes/class-deactivator.php';
    Plugin_Deactivator::deactivate( MY_PLUGIN_SLUG );
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');

// --- Initialization ---

function my_plugin_init() {
    // Load the plugin text domain for internationalization
    load_plugin_textdomain(
        MY_PLUGIN_SLUG, // The dynamic slug (Text Domain)
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages/' // Path to the languages folder
    );

    // Load core classes
    require_once MY_PLUGIN_PATH . 'includes/class-loader.php';
    require_once MY_PLUGIN_PATH . 'includes/class-main.php';
    require_once MY_PLUGIN_PATH . 'admin/class-admin.php';
    require_once MY_PLUGIN_PATH . 'public/class-public.php';

    // Pass the dynamic constants to the main orchestrator class
    $plugin = new Plugin_Main( MY_PLUGIN_NAME, MY_PLUGIN_SLUG, MY_PLUGIN_VERSION );
    $plugin->run();
}
add_action('plugins_loaded', 'my_plugin_init');
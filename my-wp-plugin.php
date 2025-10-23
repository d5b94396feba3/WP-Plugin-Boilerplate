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

if (!defined('WPINC')) {
    die;
}

class My_Plugin_Bootstrap {

    public static function init() {
        self::define_constants();
        self::load_dependencies();
        self::run_plugin();
    }

    private static function define_constants() {
        $plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version', 'TextDomain' => 'Text Domain', 'Name' => 'Plugin Name' ), 'plugin' );

        if (!defined('MY_PLUGIN_NAME')) {
            define('MY_PLUGIN_NAME', $plugin_data['Name']);
        }
        if (!defined('MY_PLUGIN_SLUG')) {
            define('MY_PLUGIN_SLUG', $plugin_data['TextDomain']);
        }
        if (!defined('MY_PLUGIN_VERSION')) {
            define('MY_PLUGIN_VERSION', $plugin_data['Version']);
        }
        if (!defined('MY_PLUGIN_PATH')) {
            define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
        }
        if (!defined('MY_PLUGIN_URL')) {
            define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));
        }
    }

    private static function load_dependencies() {
        load_plugin_textdomain(
            MY_PLUGIN_SLUG,
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        );

        require_once MY_PLUGIN_PATH . 'includes/class-loader.php';
        require_once MY_PLUGIN_PATH . 'includes/class-main.php';
        require_once MY_PLUGIN_PATH . 'admin/class-admin.php';
        require_once MY_PLUGIN_PATH . 'public/class-public.php';
    }

    private static function run_plugin() {
        $plugin = new Plugin_Main( MY_PLUGIN_NAME, MY_PLUGIN_SLUG, MY_PLUGIN_VERSION );
        $plugin->run();
    }
}

// Activation/Deactivation
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

// Uninstall Hook
function my_plugin_uninstall() {
    require_once MY_PLUGIN_PATH . 'includes/class-uninstaller.php';
    Plugin_Uninstaller::uninstall( MY_PLUGIN_SLUG );
}
register_uninstall_hook(__FILE__, 'my_plugin_uninstall');

// Initialize plugin
add_action('plugins_loaded', array('My_Plugin_Bootstrap', 'init'));

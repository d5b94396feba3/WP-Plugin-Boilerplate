<?php
defined( 'ABSPATH' ) || exit;

class Plugin_Main {
    protected $loader;
    protected $plugin_name; // "My Dynamic Plugin Name"
    protected $plugin_slug; // "my-plugin-slug"
    protected $version;     // "1.0.0"

    public function __construct( $plugin_name, $plugin_slug, $version ) {
        $this->plugin_name = $plugin_name;
        $this->plugin_slug = $plugin_slug;
        $this->version     = $version;

        $this->loader = new Plugin_Loader();
        $this->define_hooks();
    }

    private function define_hooks() {
        // Admin hooks
        if (is_admin()) {
            // Pass the dynamic values to the admin class
            $admin = new Plugin_Admin( $this->plugin_name, $this->plugin_slug, $this->version );
            $this->loader->add_action('admin_menu', $admin, 'add_menu');
        }

        // Public hooks
        // Pass the dynamic values to the public class
        $public = new Plugin_Public( $this->plugin_slug, $this->version );
        $this->loader->add_action('wp_enqueue_scripts', $public, 'enqueue_scripts');
        $this->loader->add_action('wp_enqueue_scripts', $public, 'enqueue_styles'); // Added style hook
    }

    public function run() {
        $this->loader->run();
    }
}

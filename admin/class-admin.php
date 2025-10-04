<?php
class Plugin_Admin {
    private $plugin_name;
    private $plugin_slug;
    private $version;

    // Updated constructor to accept name and slug
    public function __construct( $plugin_name, $plugin_slug, $version ) {
        $this->plugin_name = $plugin_name;
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
    }

    public function add_menu() {
        add_menu_page(
            $this->plugin_name, // Dynamic Page Title
            $this->plugin_name, // Dynamic Menu Title
            'manage_options',
            $this->plugin_slug, // Dynamic Menu Slug
            [$this, 'admin_page']
        );
    }

    public function admin_page() {
        // Use the dynamic name for the heading
        echo '<div class="wrap"><h1>' . esc_html( $this->plugin_name ) . ' Settings</h1></div>';
    }
}
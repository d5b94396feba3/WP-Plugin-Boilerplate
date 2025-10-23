<?php
defined( 'ABSPATH' ) || exit;

class Plugin_Public {

    private $plugin_slug; // Using slug for handles
    private $version;

    // Updated constructor to accept slug and version
    public function __construct( $plugin_slug, $version ) {
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_slug . '-public', // Dynamic Handle
            MY_PLUGIN_URL . 'assets/css/public.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_slug . '-public', // Dynamic Handle
            MY_PLUGIN_URL . 'assets/js/public.js',
            array( 'jquery' ),
            $this->version,
            true // True for loading in footer
        );
        // Localize script to pass the version/slug to public.js if needed
        wp_localize_script(
            $this->plugin_slug . '-public',
            'myPluginData',
            array(
                'slug'    => $this->plugin_slug,
                'version' => $this->version,
            )
        );
    }
}

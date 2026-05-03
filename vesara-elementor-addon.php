<?php
/**
 * Plugin Name: VESARA Elementor Widgets
 * Plugin URI:  https://vesara.com
 * Description: Premium Elementor widgets for VESARA luxury saree brand — Hero Banner, Shop by Category, New Arrivals, Feature Highlights, Testimonials, and Footer.
 * Version:     1.0.2
 * Author:      VESARA
 * Text Domain: vesara-elementor-addon
 * Domain Path: /languages
 * Requires Plugins: elementor
 * Requires at least: 5.8
 * Tested up to: 6.5
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'VESARA_EA_VERSION',  '1.0.2' );
define( 'VESARA_EA_PATH',     plugin_dir_path( __FILE__ ) );
define( 'VESARA_EA_URL',      plugin_dir_url( __FILE__ ) );
define( 'VESARA_EA_BASENAME', plugin_basename( __FILE__ ) );

// ── Dependency check ────────────────────────────────────────────────────────
add_action( 'admin_notices', 'vesara_ea_dependency_notice' );
function vesara_ea_dependency_notice() {
    if ( did_action( 'elementor/loaded' ) ) return;
    echo '<div class="notice notice-error"><p>';
    esc_html_e( 'VESARA Elementor Widgets requires Elementor to be installed and activated.', 'vesara-elementor-addon' );
    echo '</p></div>';
}

// ── Boot on Elementor/init ───────────────────────────────────────────────────
add_action( 'elementor/init', 'vesara_ea_init' );
function vesara_ea_init() {
    // Register custom widget category
    add_action( 'elementor/elements/categories_registered', 'vesara_ea_register_category' );
    // Register widgets
    add_action( 'elementor/widgets/register', 'vesara_ea_register_widgets' );
    // Register frontend assets
    add_action( 'elementor/frontend/before_register_styles', 'vesara_ea_register_assets' );
    add_action( 'wp_enqueue_scripts', 'vesara_ea_register_assets' );
}

function vesara_ea_register_category( $elements_manager ) {
    $elements_manager->add_category( 'vesara', [
        'title' => esc_html__( 'VESARA', 'vesara-elementor-addon' ),
        'icon'  => 'fa fa-gem',
    ] );
}

function vesara_ea_register_widgets( $widgets_manager ) {
    $widgets = [
        'banner'             => 'Banner_Widget',
        'shop-category'      => 'Shop_Category_Widget',
        'new-arrivals'       => 'New_Arrivals_Widget',
        'feature-highlights' => 'Feature_Highlights_Widget',
        'testimonials'       => 'Testimonials_Widget',
        'footer'             => 'Footer_Widget',
    ];
    foreach ( $widgets as $file => $class ) {
        $path = VESARA_EA_PATH . "widgets/class-{$file}-widget.php";
        if ( file_exists( $path ) ) {
            require_once $path;
            $fqcn = "\\Vesara_Elementor_Addon\\Widgets\\{$class}";
            $widgets_manager->register( new $fqcn() );
        }
    }
}

function vesara_ea_register_assets() {
    // Global CSS
    wp_register_style(
        'vesara-ea-global',
        VESARA_EA_URL . 'assets/css/widget-global.css',
        [],
        VESARA_EA_VERSION
    );
    // Per-widget CSS
    $styles = [ 'banner', 'shop-category', 'new-arrivals', 'feature-highlights', 'testimonials', 'footer' ];
    foreach ( $styles as $handle ) {
        wp_register_style(
            "vesara-ea-{$handle}",
            VESARA_EA_URL . "assets/css/{$handle}.css",
            [ 'vesara-ea-global' ],
            VESARA_EA_VERSION
        );
    }
    // JS
    wp_register_script(
        'vesara-ea-testimonials',
        VESARA_EA_URL . 'assets/js/testimonials-carousel.js',
        [],
        VESARA_EA_VERSION,
        true
    );
    wp_register_script(
        'vesara-ea-handlers',
        VESARA_EA_URL . 'assets/js/widget-handlers.js',
        [ 'jquery', 'vesara-ea-testimonials' ],
        VESARA_EA_VERSION,
        true
    );
}

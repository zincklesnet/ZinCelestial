<?php
/**
 * ZinCelestial Theme Functions
 * Author: Zinckles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Setup
 */
function zc_setup() {

    // Core theme supports
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ] );

    // Plugin supports
    add_theme_support( 'woocommerce' );
    add_theme_support( 'bp-default' ); // BuddyPress template compatibility

    // Navigation menus
    register_nav_menus([
        'primary' => __( 'Primary Menu', 'zincelestial' ),
        'header'  => __( 'Header Menu', 'zincelestial' ),
        'mobile'  => __( 'Mobile Menu', 'zincelestial' ),
        'footer'  => __( 'Footer Menu', 'zincelestial' ),
    ]);

    // Sidebars
    register_sidebar([
        'name'          => __( 'Main Sidebar', 'zincelestial' ),
        'id'            => 'sidebar-main',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action( 'after_setup_theme', 'zc_setup' );


/**
 * Enqueue Scripts & Styles
 */
function zc_enqueue_assets() {

    $version = wp_get_theme()->get( 'Version' );

    // Bootstrap CSS
    wp_enqueue_style(
        'zc-bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        '5.3.3'
    );

    // Bootstrap Icons
    wp_enqueue_style(
        'zc-bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        [],
        '1.11.3'
    );

    // Theme main CSS (compiled from Sass)
    wp_enqueue_style(
        'zc-main',
        get_template_directory_uri() . '/assets/dist/css/main.css',
        [ 'zc-bootstrap' ],
        $version
    );

    // Bootstrap JS
    wp_enqueue_script(
        'zc-bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [ 'jquery' ],
        '5.3.3',
        true
    );

    // Theme main JS
    wp_enqueue_script(
        'zc-main-js',
        get_template_directory_uri() . '/assets/dist/js/main.js',
        [ 'jquery', 'zc-bootstrap-js' ],
        $version,
        true
    );

    // AJAX globals
    wp_localize_script( 'zc-main-js', 'zcAjax', [
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'zc-ajax-nonce' ),
    ]);
}
add_action( 'wp_enqueue_scripts', 'zc_enqueue_assets' );


/**
 * AJAX Example Endpoint (BuddyPress/Woo/bbPress ready)
 */
add_action( 'wp_ajax_zc_ajax_example', 'zc_ajax_example' );
add_action( 'wp_ajax_nopriv_zc_ajax_example', 'zc_ajax_example' );

function zc_ajax_example() {
    check_ajax_referer( 'zc-ajax-nonce', 'nonce' );

    wp_send_json_success([
        'message' => 'ZinCelestial AJAX is working.',
    ]);
}

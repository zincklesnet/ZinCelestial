<?php
/**
 * ZinCelestial v3.0 — FluentCart Compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'FluentCart' ) ) return;

// Wrapper classes
add_action( 'fluent_cart_before_wrapper', function() {
    echo '<div class="zc-fluent-cart-wrapper">';
} );
add_action( 'fluent_cart_after_wrapper', function() {
    echo '</div>';
} );

// Checkout: distraction free
add_action( 'fluent_cart_checkout_before', function() {
    if ( zc_option( 'wc_checkout_clean', 1 ) ) {
        add_filter( 'zc_show_sidebar', '__return_false' );
    }
} );

// Enqueue FluentCart CSS
add_action( 'wp_enqueue_scripts', function() {
    if ( function_exists( 'fluent_cart' ) ) {
        wp_enqueue_style(
            'zc-fluentcart',
            ZC_ASSETS . 'css/fluentcart.css',
            [],
            ZC_VERSION
        );
    }
} );

// Add ZinCelestial button class to FluentCart buttons
add_filter( 'fluent_cart_add_to_cart_class', function( $class ) {
    return $class . ' zc-btn zc-btn-primary';
} );

add_filter( 'fluent_cart_checkout_submit_class', function( $class ) {
    return $class . ' zc-btn zc-btn-primary zc-btn-lg';
} );

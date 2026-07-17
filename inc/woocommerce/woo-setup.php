<?php
/**
 * ZinCelestial v5.2.0 — WooCommerce Setup
 *
 * v5.2.0 Fixes:
 *  - woocommerce_setup_themes hook used correctly
 *  - remove_action for default WC wrappers replaced with ZC wrappers
 *  - Bootstrap 5 classes bridged to all WC form fields
 *  - Shop page layout: grid/list with cards
 *  - WC notice/alert Bootstrap styling
 *  - Cart widget Bootstrap styling
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_WC_Setup {

    public static function init() {
        if ( ! class_exists( 'WooCommerce' ) ) return;

        // Theme support (must run in after_setup_theme)
        add_action( 'after_setup_theme', [ __CLASS__, 'setup' ], 20 );

        // WC hooks
        add_action( 'wp_enqueue_scripts',       [ __CLASS__, 'enqueue_wc_styles' ], 20 );
        add_filter( 'woocommerce_enqueue_styles', [ __CLASS__, 'filter_wc_styles' ] );

        // Replace default WC wrappers with Bootstrap-friendly markup
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
        add_action( 'woocommerce_before_main_content',    [ __CLASS__, 'wc_wrapper_start' ], 10 );
        add_action( 'woocommerce_after_main_content',     [ __CLASS__, 'wc_wrapper_end' ], 10 );

        // Remove default WC sidebar
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        add_action( 'woocommerce_sidebar',    [ __CLASS__, 'wc_sidebar' ], 10 );

        // Product card Bootstrap classes
        add_filter( 'woocommerce_post_class',   [ __CLASS__, 'product_post_class' ], 20, 3 );
        add_filter( 'woocommerce_loop_add_to_cart_args', [ __CLASS__, 'bs5_add_to_cart_args' ], 10, 2 );

        // Bootstrap form field classes
        add_filter( 'woocommerce_form_field_class', [ __CLASS__, 'bs5_form_field_class' ], 10, 4 );

        // Shop columns
        add_filter( 'loop_shop_columns',        [ __CLASS__, 'shop_columns' ] );
        add_filter( 'loop_shop_per_page',        [ __CLASS__, 'products_per_page' ] );

        // Bootstrap notices
        add_filter( 'wc_add_to_cart_message_html', [ __CLASS__, 'bs5_cart_message' ] );

        // Related products
        add_filter( 'woocommerce_output_related_products_args', [ __CLASS__, 'related_products_args' ] );

        // Breadcrumbs
        add_filter( 'woocommerce_breadcrumb_defaults', [ __CLASS__, 'breadcrumb_defaults' ] );

        // Mini-cart fragment
        add_filter( 'woocommerce_add_to_cart_fragments', [ __CLASS__, 'cart_fragment' ] );

        // Checkout BS5
        add_action( 'woocommerce_before_checkout_form', [ __CLASS__, 'checkout_wrapper_start' ], 5 );
        add_action( 'woocommerce_after_checkout_form',  [ __CLASS__, 'checkout_wrapper_end' ], 5 );
    }

    /* ── Theme Support ──────────────────────────────────────────────────────── */
    public static function setup() {
        add_theme_support( 'woocommerce', [
            'thumbnail_image_width' => 350,
            'gallery_thumbnail_image_width' => 100,
            'single_image_width'    => 600,
        ] );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    /* ── Enqueue WC styles ───────────────────────────────────────────────────── */
    public static function enqueue_wc_styles() {
        if ( ! class_exists( 'WooCommerce' ) ) return;

        $css = ZC_DIR . '/assets/css/woocommerce.css';
        if ( file_exists( $css ) ) {
            wp_enqueue_style( 'zc-woocommerce', ZC_ASSETS . '/css/woocommerce.css', [ 'zc-core' ], ZC_VERSION );
        }

        // Dynamic WC tokens
        $shop_cols = (int) zc_option( 'wc_shop_columns', 3 );
        $css_vars = ':root{--zc-wc-columns:' . $shop_cols . ';}';
        wp_add_inline_style( 'zc-woocommerce', $css_vars );
    }

    /* ── Disable WC's own CSS (we provide our own) ───────────────────────────── */
    public static function filter_wc_styles( $styles ) {
        // Keep WC inline blocks styles, remove old layout CSS
        unset( $styles['woocommerce-layout'] );
        unset( $styles['woocommerce-smallscreen'] );
        return $styles;
    }

    /* ── WC content wrappers ─────────────────────────────────────────────────── */
    public static function wc_wrapper_start() {
        $layout = zc_option( 'sidebar_layout', 'right' );
        echo '<div class="container-fluid zc-content-wrapper zc-wc-page px-3 px-lg-4 py-4">';
        echo '<div class="row g-4">';

        if ( $layout === 'left' && is_active_sidebar( 'zc-sidebar-woocommerce' ) ) {
            echo '<div class="col-12 col-lg-3 zc-sidebar-col">';
            dynamic_sidebar( 'zc-sidebar-woocommerce' );
            echo '</div>';
        }

        $col = ( $layout !== 'none' && is_active_sidebar( 'zc-sidebar-woocommerce' ) ) ? 'col-12 col-lg-9' : 'col-12';
        echo '<div class="' . esc_attr( $col ) . ' zc-main-col">';
    }

    public static function wc_wrapper_end() {
        echo '</div>'; // .zc-main-col
        echo '</div>'; // .row
        echo '</div>'; // .zc-content-wrapper
    }

    /* ── WC Sidebar ──────────────────────────────────────────────────────────── */
    public static function wc_sidebar() {
        $layout = zc_option( 'sidebar_layout', 'right' );
        if ( $layout === 'right' && is_active_sidebar( 'zc-sidebar-woocommerce' ) ) {
            echo '</div><div class="col-12 col-lg-3 zc-sidebar-col">';
            dynamic_sidebar( 'zc-sidebar-woocommerce' );
        }
    }

    /* ── Product post class → BS5 card ───────────────────────────────────────── */
    public static function product_post_class( $classes, $class, $post_id ) {
        $classes[] = 'zc-product-card';
        $classes[] = 'h-100';
        return $classes;
    }

    /* ── Add-to-cart button Bootstrap classes ────────────────────────────────── */
    public static function bs5_add_to_cart_args( $args, $product ) {
        $args['class'] = str_replace( 'button', 'btn btn-primary zc-atc-btn', $args['class'] );
        return $args;
    }

    /* ── Form field Bootstrap classes ────────────────────────────────────────── */
    public static function bs5_form_field_class( $classes, $key, $args, $value ) {
        $type = $args['type'] ?? 'text';
        $map  = [
            'text'     => 'form-control',
            'email'    => 'form-control',
            'tel'      => 'form-control',
            'password' => 'form-control',
            'textarea' => 'form-control',
            'select'   => 'form-select',
            'checkbox' => 'form-check-input',
            'radio'    => 'form-check-input',
            'number'   => 'form-control',
        ];
        if ( isset( $map[ $type ] ) ) {
            $classes = array_filter( $classes, fn( $c ) => ! in_array( $c, [ 'input-text', 'select' ], true ) );
            $classes[] = $map[ $type ];
        }
        return $classes;
    }

    /* ── Shop column count from admin option ─────────────────────────────────── */
    public static function shop_columns() {
        return (int) zc_option( 'wc_shop_columns', 3 );
    }

    /* ── Products per page ───────────────────────────────────────────────────── */
    public static function products_per_page() {
        return (int) zc_option( 'wc_products_per_page', 12 );
    }

    /* ── Bootstrap cart notice ───────────────────────────────────────────────── */
    public static function bs5_cart_message( $message ) {
        return '<div class="alert alert-success d-flex align-items-center gap-2 zc-wc-notice">'
             . '<i class="bi bi-bag-check-fill"></i>'
             . $message
             . '</div>';
    }

    /* ── Related products args ───────────────────────────────────────────────── */
    public static function related_products_args( $args ) {
        $args['posts_per_page'] = (int) zc_option( 'wc_related_products', 4 );
        $args['columns']        = (int) zc_option( 'wc_shop_columns', 3 );
        return $args;
    }

    /* ── Breadcrumb defaults ─────────────────────────────────────────────────── */
    public static function breadcrumb_defaults( $defaults ) {
        $defaults['delimiter']   = '<i class="bi bi-chevron-right mx-2" aria-hidden="true"></i>';
        $defaults['wrap_before'] = '<nav class="zc-wc-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'zincelestial' ) . '"><ol class="breadcrumb">';
        $defaults['wrap_after']  = '</ol></nav>';
        $defaults['before']      = '<li class="breadcrumb-item">';
        $defaults['after']       = '</li>';
        return $defaults;
    }

    /* ── Mini-cart fragment for header cart icon ──────────────────────────────── */
    public static function cart_fragment( $fragments ) {
        ob_start();
        $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        ?>
        <span class="zc-cart-count"><?php echo absint( $count ); ?></span>
        <?php
        $fragments['span.zc-cart-count'] = ob_get_clean();
        return $fragments;
    }

    /* ── Checkout wrapper ────────────────────────────────────────────────────── */
    public static function checkout_wrapper_start() {
        echo '<div class="zc-checkout-wrap">';
    }
    public static function checkout_wrapper_end() {
        echo '</div>';
    }
}

ZC_WC_Setup::init();

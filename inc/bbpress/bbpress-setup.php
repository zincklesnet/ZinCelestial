<?php
/**
 * ZinCelestial v5.2.0 — bbPress Setup
 *
 * v5.2.0: Full bbPress Bootstrap 5 integration
 *  - BS5 form classes bridged
 *  - Forum/topic/reply wrapper classes
 *  - Breadcrumb Bootstrap styling
 *  - Pagination Bootstrap styling
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_BBPress_Setup {

    public static function init() {
        if ( ! class_exists( 'bbPress' ) ) return;

        add_action( 'after_setup_theme',  [ __CLASS__, 'setup' ], 20 );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_styles' ], 20 );

        // BS5 form class bridging
        add_filter( 'bbp_get_form_field_class', [ __CLASS__, 'bs5_field_class' ], 10, 2 );

        // Pagination
        add_filter( 'bbp_get_forum_pagination_links', [ __CLASS__, 'bs5_pagination' ] );
        add_filter( 'bbp_get_topic_pagination_links', [ __CLASS__, 'bs5_pagination' ] );

        // Breadcrumb
        add_filter( 'bbp_get_breadcrumb', [ __CLASS__, 'bs5_breadcrumb' ], 10, 3 );

        // Submit button
        add_filter( 'bbp_get_submit_button', [ __CLASS__, 'bs5_submit_btn' ], 10, 2 );

        // Body class
        add_filter( 'body_class', [ __CLASS__, 'body_class' ] );
    }

    public static function setup() {
        add_theme_support( 'bbpress' );
    }

    public static function enqueue_styles() {
        if ( ! class_exists( 'bbPress' ) ) return;
        $css = ZC_DIR . '/assets/css/bbpress.css';
        if ( file_exists( $css ) ) {
            wp_enqueue_style( 'zc-bbpress', ZC_ASSETS . '/css/bbpress.css', [ 'zc-core' ], ZC_VERSION );
        }
    }

    public static function bs5_field_class( $class, $type ) {
        $map = [
            'text'     => 'form-control',
            'email'    => 'form-control',
            'textarea' => 'form-control',
            'select'   => 'form-select',
            'checkbox' => 'form-check-input',
        ];
        return $map[ $type ] ?? $class;
    }

    public static function bs5_pagination( $links ) {
        // Wrap existing links in BS5 pagination nav
        if ( empty( $links ) ) return $links;
        return '<nav class="zc-bbp-pagination" aria-label="' . esc_attr__( 'Forum pagination', 'zincelestial' ) . '">'
             . '<ul class="pagination pagination-sm justify-content-center flex-wrap">'
             . $links
             . '</ul></nav>';
    }

    public static function bs5_breadcrumb( $trail, $crumbs, $args ) {
        if ( empty( $crumbs ) ) return $trail;
        $out = '<nav class="zc-bbp-breadcrumb" aria-label="' . esc_attr__( 'Forum location', 'zincelestial' ) . '">';
        $out .= '<ol class="breadcrumb">';
        foreach ( $crumbs as $i => $crumb ) {
            $last = ( $i === count( $crumbs ) - 1 );
            if ( $last ) {
                $out .= '<li class="breadcrumb-item active" aria-current="page">' . wp_kses_post( $crumb ) . '</li>';
            } else {
                $out .= '<li class="breadcrumb-item">' . wp_kses_post( $crumb ) . '</li>';
            }
        }
        $out .= '</ol></nav>';
        return $out;
    }

    public static function bs5_submit_btn( $button, $args ) {
        return str_replace( 'class="button"', 'class="btn btn-primary zc-bbp-submit"', $button );
    }

    public static function body_class( $classes ) {
        if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
            $classes[] = 'zc-bbpress-page';
        }
        return $classes;
    }
}

ZC_BBPress_Setup::init();

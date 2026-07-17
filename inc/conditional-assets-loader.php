<?php
/**
 * ZinCelestial v3.0 — Conditional Assets Loader
 * Only enqueues CSS/JS on pages that need them
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_Conditional_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_unneeded' ], 20 );
        add_filter( 'zc_load_gamipress_assets',  [ $this, 'check_gamipress' ] );
        add_filter( 'zc_load_reactions_assets',  [ $this, 'check_reactions' ] );
        add_filter( 'zc_load_compose_assets',    [ $this, 'check_compose' ] );
        add_filter( 'zc_load_bp_assets',         [ $this, 'check_buddypress' ] );
        add_filter( 'zc_load_woo_assets',        [ $this, 'check_woocommerce' ] );
        add_filter( 'zc_load_bbpress_assets',    [ $this, 'check_bbpress' ] );
    }

    public function dequeue_unneeded() {
        $opts = get_option( 'zc_options', [] );
        if ( empty( $opts['pf_conditional_assets'] ) ) return;

        // GamiPress assets
        if ( ! apply_filters( 'zc_load_gamipress_assets', false ) ) {
            wp_dequeue_style( 'zc-gamipress' );
            wp_dequeue_script( 'zc-gamipress' );
        }

        // Reactions assets
        if ( ! apply_filters( 'zc_load_reactions_assets', false ) ) {
            wp_dequeue_style( 'zc-reactions' );
            wp_dequeue_script( 'zc-reactions' );
        }

        // Compose assets
        if ( ! apply_filters( 'zc_load_compose_assets', false ) ) {
            wp_dequeue_style( 'zc-compose' );
            wp_dequeue_script( 'zc-compose' );
        }

        // BuddyPress assets
        if ( ! apply_filters( 'zc_load_bp_assets', false ) ) {
            wp_dequeue_style( 'zc-buddypress' );
        }

        // WooCommerce assets
        if ( ! apply_filters( 'zc_load_woo_assets', false ) ) {
            wp_dequeue_style( 'zc-woocommerce' );
        }

        // bbPress assets
        if ( ! apply_filters( 'zc_load_bbpress_assets', false ) ) {
            wp_dequeue_style( 'zc-bbpress' );
        }
    }

    public function check_gamipress( $load ) {
        if ( ! class_exists( 'GamiPress' ) ) return false;
        $opts = get_option( 'zc_options', [] );
        if ( empty( $opts['gp_bar_enabled'] ) ) return false;
        return true; // Always load when GamiPress bar is enabled
    }

    public function check_reactions( $load ) {
        $opts = get_option( 'zc_options', [] );
        if ( empty( $opts['rx_enabled'] ) ) return false;

        // Load on posts/pages/BP/WooCommerce
        if ( is_singular( [ 'post', 'page', 'product', 'download' ] ) ) return true;
        if ( function_exists( 'bp_is_activity_component' ) && bp_is_activity_component() ) return true;
        if ( function_exists( 'bp_is_user' ) && bp_is_user() ) return true;
        if ( function_exists( 'bp_is_group' ) && bp_is_group() ) return true;
        if ( is_home() || is_front_page() || is_archive() ) return true;
        return false;
    }

    public function check_compose( $load ) {
        $opts = get_option( 'zc_options', [] );
        if ( empty( $opts['cb_enabled'] ) ) return false;
        if ( ! is_user_logged_in() && ! empty( $opts['cb_hide_loggedout'] ) ) return false;

        if ( ! empty( $opts['cb_show_activity'] ) && function_exists( 'bp_is_activity_component' ) && bp_is_activity_component() ) return true;
        if ( ! empty( $opts['cb_show_profile'] ) && function_exists( 'bp_is_user' ) && bp_is_user() ) return true;
        if ( ! empty( $opts['cb_show_group'] ) && function_exists( 'bp_is_group' ) && bp_is_group() ) return true;
        if ( ! empty( $opts['cb_show_home'] ) && ( is_home() || is_front_page() ) ) return true;
        if ( ! empty( $opts['cb_show_single'] ) && is_singular( 'post' ) ) return true;
        return false;
    }

    public function check_buddypress( $load ) {
        if ( ! function_exists( 'buddypress' ) ) return false;
        return is_buddypress() || bp_is_user() || bp_is_group() || bp_is_activity_component();
    }

    public function check_woocommerce( $load ) {
        if ( ! class_exists( 'WooCommerce' ) ) return false;
        return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
    }

    public function check_bbpress( $load ) {
        if ( ! function_exists( 'is_bbpress' ) ) return false;
        return is_bbpress();
    }
}

new ZC_Conditional_Assets();

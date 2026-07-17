<?php
/**
 * ZinCelestial v5.1.0 — Asset Enqueue
 *
 * CRITICAL FIX #1: Admin sub-page hook suffix = 'zc-dashboard_page_zc-{slug}'
 * CRITICAL FIX #9: WooCommerce textdomain — never load manually; WC handles it at plugins_loaded.
 * v5.1.0: Added subheader CSS vars, online dot CSS, scheme switcher CSS, scroll-to-top CSS.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══════════════════════════════════════════════════════════════════════════
   FRONTEND ASSETS
═══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', function () {

    // ── Bootstrap 5.3.3 CSS (CDN) ────────────────────────────────────────────
    wp_enqueue_style( 'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [], '5.3.3' );

    // ── Bootstrap Icons 1.11.3 ───────────────────────────────────────────────
    wp_enqueue_style( 'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        [], '1.11.3' );

    // ── Color scheme CSS ─────────────────────────────────────────────────────
    $scheme = zc_option( 'color_scheme', 'cosmic' );
    $scheme_file = ZC_DIR . '/styles/' . $scheme . '.css';
    if ( file_exists( $scheme_file ) ) {
        wp_enqueue_style( 'zc-scheme', ZC_URI . '/styles/' . $scheme . '.css', [ 'bootstrap' ], ZC_VERSION );
    }

    // ── Core CSS ─────────────────────────────────────────────────────────────
    $core_file = ZC_ASSETS_DIR . '/css/core.css';
    if ( file_exists( $core_file ) ) {
        wp_enqueue_style( 'zc-core', ZC_ASSETS . '/css/core.css', [ 'bootstrap', 'bootstrap-icons' ], ZC_VERSION );
    }

    // ── Color mode CSS ───────────────────────────────────────────────────────
    $cm_file = ZC_ASSETS_DIR . '/css/color-mode.css';
    if ( file_exists( $cm_file ) ) {
        wp_enqueue_style( 'zc-color-mode', ZC_ASSETS . '/css/color-mode.css', [ 'zc-core' ], ZC_VERSION );
    }

    // ── Bootstrap Bridge CSS ─────────────────────────────────────────────────
    $bb_file = ZC_ASSETS_DIR . '/css/bootstrap-bridge.css';
    if ( file_exists( $bb_file ) ) {
        wp_enqueue_style( 'zc-bootstrap-bridge', ZC_ASSETS . '/css/bootstrap-bridge.css', [ 'zc-core' ], ZC_VERSION );
    }

    // ── Google Fonts ─────────────────────────────────────────────────────────
    if ( zc_option( 'disable_google_fonts', '0' ) !== '1' ) {
        $font_body    = zc_option( 'font_body', 'Inter' );
        $font_display = zc_option( 'font_display', 'Syne' );
        $system_fonts = [ 'system-ui', 'inherit', 'sans-serif', 'serif', 'monospace' ];
        $families     = [];
        if ( ! in_array( $font_body, $system_fonts, true ) )    $families[] = str_replace( ' ', '+', $font_body ) . ':wght@300;400;500;600;700';
        if ( $font_display !== $font_body && ! in_array( $font_display, $system_fonts, true ) )
            $families[] = str_replace( ' ', '+', $font_display ) . ':wght@400;600;700;800;900';

        if ( ! empty( $families ) ) {
            wp_enqueue_style( 'zc-google-fonts',
                'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $families ) . '&display=swap',
                [], null );
        }
    }

    // ── Bootstrap 5.3.3 JS ───────────────────────────────────────────────────
    wp_enqueue_script( 'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [], '5.3.3', true );

    // ── Lucide Icons ─────────────────────────────────────────────────────────
    wp_enqueue_script( 'lucide',
        'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js',
        [], '0.263.1', true );

    // ── Color Mode JS (early apply — inline before body) ─────────────────────
    $cm_js = ZC_ASSETS_DIR . '/js/color-mode.js';
    if ( file_exists( $cm_js ) ) {
        wp_enqueue_script( 'zc-color-mode', ZC_ASSETS . '/js/color-mode.js', [], ZC_VERSION, false );
    }

    // ── Core JS ──────────────────────────────────────────────────────────────
    $core_js = ZC_ASSETS_DIR . '/js/core.js';
    if ( file_exists( $core_js ) ) {
        wp_enqueue_script( 'zc-core-js', ZC_ASSETS . '/js/core.js', [ 'bootstrap-js' ], ZC_VERSION, true );
    }

    // ── Localise JS ──────────────────────────────────────────────────────────
    wp_localize_script( 'zc-core-js', 'ZC', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'zc_frontend_nonce' ),
        'siteUrl'   => home_url( '/' ),
        'scheme'    => zc_option( 'color_scheme', 'cosmic' ),
        'mode'      => zc_option( 'color_mode', 'dark' ),
        'isLoggedIn'=> is_user_logged_in() ? '1' : '0',
    ] );

    // ── Inline CSS: design tokens from saved options ─────────────────────────
    zc_output_design_tokens();

} );

/**
 * Output CSS custom properties from saved ZinCelestial options.
 * This bridges the admin panel colour pickers to the frontend.
 */
function zc_output_design_tokens() {
    $max_w  = (int) zc_option( 'container_max_width', 1280 );
    $radius = (int) zc_option( 'border_radius_md', 12 );
    $fs     = (int) zc_option( 'font_size_base', 16 );
    $font_b = esc_attr( zc_option( 'font_body', 'Inter' ) );
    $font_d = esc_attr( zc_option( 'font_display', 'Syne' ) );
    $lp_w   = (int) zc_option( 'left_panel_width', 280 );
    $rp_w   = (int) zc_option( 'right_panel_width', 280 );

    // Custom colours (only output if set — otherwise scheme CSS handles it)
    $primary = sanitize_hex_color( zc_option( 'color_primary', '' ) );
    $secondary = sanitize_hex_color( zc_option( 'color_secondary', '' ) );

    // Header colours
    $hbg  = sanitize_hex_color( zc_option( 'header_bg_color', '' ) );
    $htc  = sanitize_hex_color( zc_option( 'header_text_color', '' ) );
    $fbg  = sanitize_hex_color( zc_option( 'footer_bg_color', '' ) );
    $ftc  = sanitize_hex_color( zc_option( 'footer_text_color', '' ) );
    $logo_h = (int) zc_option( 'header_logo_height', 40 );

    // Sub-header
    $sub_h  = (int) zc_option( 'subheader_height', 120 );
    $sub_bg = sanitize_hex_color( zc_option( 'subheader_bg_color', '' ) );
    $sub_tc = sanitize_hex_color( zc_option( 'subheader_text_color', '' ) );

    $css = ':root{';
    $css .= '--zc-container-max:' . $max_w . 'px;';
    $css .= '--zc-radius-md:' . $radius . 'px;';
    $css .= '--zc-font-base:' . $fs . 'px;';
    $css .= '--zc-font-body:"' . $font_b . '",system-ui,sans-serif;';
    $css .= '--zc-font-display:"' . $font_d . '",system-ui,sans-serif;';
    $css .= '--zc-panel-w-left:' . $lp_w . 'px;';
    $css .= '--zc-panel-w-right:' . $rp_w . 'px;';
    $css .= '--zc-logo-h:' . $logo_h . 'px;';
    $css .= '--zc-subheader-h:' . $sub_h . 'px;';
    if ( $primary )   $css .= '--zc-primary:' . $primary . ';';
    if ( $secondary ) $css .= '--zc-secondary:' . $secondary . ';';
    if ( $hbg )  $css .= '--zc-header-bg:' . $hbg . ';';
    if ( $htc )  $css .= '--zc-header-text:' . $htc . ';';
    if ( $fbg )  $css .= '--zc-footer-bg:' . $fbg . ';';
    if ( $ftc )  $css .= '--zc-footer-text:' . $ftc . ';';
    if ( $sub_bg ) $css .= '--zc-subheader-bg:' . $sub_bg . ';';
    if ( $sub_tc ) $css .= '--zc-subheader-text:' . $sub_tc . ';';
    $css .= '}';

    // Scroll-to-top and scheme switcher position
    $stt_pos = zc_option( 'scroll_to_top_position', 'bottom-right' );
    $sw_pos  = zc_option( 'scheme_switcher_position', 'bottom-left' );
    list( $stt_v, $stt_h ) = explode( '-', $stt_pos . '-right' );
    list( $sw_v,  $sw_h  ) = explode( '-', $sw_pos . '-left' );
    $css .= '.zc-scroll-top{' . $stt_v . ':2rem;' . $stt_h . ':2rem;}';
    $css .= '.zc-scheme-switcher-panel{' . $sw_v . ':5rem;' . $sw_h . ':1.5rem;}';

    // Navbar forced horizontal on desktop
    $css .= '@media(min-width:992px){';
    $css .= '.zc-primary-nav{flex-direction:row!important;flex-wrap:nowrap!important;}';
    $css .= '.zc-primary-nav .nav-item{white-space:nowrap;}';
    $css .= '}';

    wp_add_inline_style( 'zc-core', $css );
}

/* ═══════════════════════════════════════════════════════════════════════════
   ADMIN ASSETS
═══════════════════════════════════════════════════════════════════════════ */
add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {

    // Only load on ZinCelestial admin pages
    // Parent page hook:  'toplevel_page_zc-dashboard'
    // Sub-page hook:     'zc-dashboard_page_zc-{slug}'
    $is_zc_page = (
        $hook_suffix === 'toplevel_page_zc-dashboard'
        || str_starts_with( $hook_suffix, 'zc-dashboard_page_zc-' )
    );

    if ( ! $is_zc_page ) return;

    // If ZinGenesis is active, it handles Bootstrap — we just load our panel CSS/JS
    if ( ! defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) || ! ZC_GENESIS_ADMIN_ACTIVE ) {
        // Bootstrap CSS + JS for admin (only when Genesis not active)
        wp_enqueue_style( 'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [], '5.3.3' );
        wp_enqueue_script( 'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            [], '5.3.3', true );
    }

    // Bootstrap Icons (always needed for admin panel icons)
    wp_enqueue_style( 'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        [], '1.11.3' );

    // Admin panel CSS
    $admin_css = ZC_ASSETS_DIR . '/css/admin-panel.css';
    if ( file_exists( $admin_css ) ) {
        wp_enqueue_style( 'zc-admin-panel',
            ZC_ASSETS . '/css/admin-panel.css',
            [ 'bootstrap-icons' ], ZC_VERSION );
    }

    // WP colour picker
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    // WordPress media (for image pickers)
    wp_enqueue_media();

    // Admin panel JS
    $admin_js = ZC_ASSETS_DIR . '/js/admin-panel.js';
    if ( file_exists( $admin_js ) ) {
        wp_enqueue_script( 'zc-admin-panel',
            ZC_ASSETS . '/js/admin-panel.js',
            [ 'jquery', 'wp-color-picker', 'bootstrap-js' ], ZC_VERSION, true );
        wp_localize_script( 'zc-admin-panel', 'ZCA', [
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( 'zca_save_options' ),
            'safeModeNonce' => wp_create_nonce( 'zca_safe_mode' ),
            'optsKey'   => ZC_OPTS_KEY,
            'version'   => ZC_VERSION,
        ] );
    }

} );

/* ═══════════════════════════════════════════════════════════════════════════
   REMOVE UNUSED HEAD JUNK
═══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function () {
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}, 1 );

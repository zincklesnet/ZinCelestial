<?php
/**
 * ZinCelestial v3.0 — Custom Login Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_Login {

    public function __construct() {
        add_action( 'login_enqueue_scripts', [ $this, 'enqueue' ] );
        add_filter( 'login_headerurl',       [ $this, 'logo_url' ] );
        add_filter( 'login_headertext',      [ $this, 'logo_title' ] );
        add_action( 'login_head',            [ $this, 'custom_styles' ] );
        add_filter( 'login_redirect',        [ $this, 'redirect_after_login' ], 10, 3 );
        add_action( 'wp_logout',             [ $this, 'redirect_after_logout' ] );
        add_filter( 'login_errors',          [ $this, 'generic_errors' ] );
        add_action( 'login_form',            [ $this, 'honeypot_field' ] );
        add_filter( 'authenticate',          [ $this, 'check_honeypot' ], 100, 3 );
    }

    public function enqueue() {
        $opts = get_option( 'zc_options', [] );
        if ( empty( $opts['sec_custom_login'] ) ) return;
        wp_enqueue_style(
            'zc-login',
            ZC_ASSETS . 'css/login.css',
            [],
            ZC_VERSION
        );
    }

    public function logo_url() {
        return home_url( '/' );
    }

    public function logo_title() {
        return get_bloginfo( 'name' );
    }

    public function custom_styles() {
        $opts  = get_option( 'zc_options', [] );
        if ( empty( $opts['sec_custom_login'] ) ) return;

        $bg       = sanitize_hex_color( $opts['sec_login_bg']   ?? '#07070f' );
        $card     = sanitize_hex_color( $opts['sec_login_card'] ?? '#0f0f1f' );
        $primary  = sanitize_hex_color( $opts['zc_primary']     ?? '#7c6ff7' );
        $logo_url = esc_url( $opts['sec_login_logo'] ?? '' );
        $bg_img   = esc_url( $opts['sec_login_bg_img'] ?? '' );

        echo '<style>
        body.login {
            background-color:' . $bg . ';
            background-image:' . ( $bg_img ? "url('" . $bg_img . "')" : 'none' ) . ';
            background-size:cover;background-position:center;
        }
        body.login::before {
            content:"";position:fixed;inset:0;
            background:linear-gradient(135deg,' . $bg . 'cc,' . $card . 'ee);
            z-index:0;pointer-events:none;
        }
        #login {
            position:relative;z-index:1;
            background:' . $card . ';
            border:1px solid rgba(255,255,255,.08);
            border-radius:20px;
            padding:2.5rem 2rem;
            box-shadow:0 24px 64px rgba(0,0,0,.6);
        }
        #login h1 a {
            ' . ( $logo_url ? 'background-image:url(' . $logo_url . ');background-size:contain;width:160px;height:60px;' : '' ) . '
        }
        .login label { color:rgba(255,255,255,.7) !important; font-size:.82rem !important; }
        .login input[type="text"],
        .login input[type="password"],
        .login input[type="email"] {
            background:rgba(255,255,255,.07) !important;
            border:1px solid rgba(255,255,255,.12) !important;
            color:#fff !important;
            border-radius:10px !important;
            box-shadow:none !important;
        }
        .login input[type="text"]:focus,
        .login input[type="password"]:focus {
            border-color:' . $primary . ' !important;
            box-shadow:0 0 0 3px rgba(124,111,247,.2) !important;
        }
        .wp-core-ui .button-primary {
            background:linear-gradient(135deg,' . $primary . ',#00d4ff) !important;
            border:none !important;
            border-radius:100px !important;
            box-shadow:0 4px 18px rgba(124,111,247,.4) !important;
            color:#fff !important;
            font-weight:700 !important;
            height:44px !important;
            width:100% !important;
            font-size:.95rem !important;
        }
        #nav, #backtoblog { text-align:center; }
        #nav a, #backtoblog a { color:rgba(255,255,255,.5) !important; font-size:.78rem !important; }
        #nav a:hover, #backtoblog a:hover { color:' . $primary . ' !important; }
        .login .message, .login .success { border-color:' . $primary . '; background:rgba(124,111,247,.1); color:#fff; border-radius:10px; }
        .login #login_error { border-color:#ef4444; background:rgba(239,68,68,.1); color:#fca5a5; border-radius:10px; }
        .zc-honeypot { display:none !important; }
        </style>' . "\n";
    }

    public function redirect_after_login( $redirect_to, $request, $user ) {
        $opts = get_option( 'zc_options', [] );
        if ( ! empty( $opts['sec_login_redirect'] ) && is_wp_error( $user ) === false ) {
            return esc_url( $opts['sec_login_redirect'] );
        }
        return $redirect_to;
    }

    public function redirect_after_logout() {
        $opts = get_option( 'zc_options', [] );
        if ( ! empty( $opts['sec_logout_redirect'] ) ) {
            wp_safe_redirect( esc_url( $opts['sec_logout_redirect'] ) );
            exit;
        }
    }

    public function generic_errors( $error ) {
        $opts = get_option( 'zc_options', [] );
        if ( ! empty( $opts['sec_generic_errors'] ) ) {
            return '<strong>' . esc_html__( 'Error', 'zincelestial' ) . ':</strong> ' . esc_html__( 'Invalid username or password.', 'zincelestial' );
        }
        return $error;
    }

    public function honeypot_field() {
        $opts = get_option( 'zc_options', [] );
        if ( ! empty( $opts['sec_honeypot'] ) ) {
            echo '<div class="zc-honeypot" aria-hidden="true">';
            echo '<input type="text" name="zc_hp_email" tabindex="-1" autocomplete="off" value="">';
            echo '</div>';
        }
    }

    public function check_honeypot( $user, $username, $password ) {
        $opts = get_option( 'zc_options', [] );
        if ( ! empty( $opts['sec_honeypot'] ) && ! empty( $_POST['zc_hp_email'] ) ) {
            return new WP_Error( 'zc_honeypot', esc_html__( 'Registration failed. Please try again.', 'zincelestial' ) );
        }
        return $user;
    }
}

new ZC_Login();

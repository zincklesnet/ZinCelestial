<?php
/**
 * ZinCelestial v3.0 — Dynamic CSS Output
 * Generates inline CSS from theme options and design tokens
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_Custom_Styles {

    private $opts;

    public function __construct() {
        $this->opts = get_option( 'zc_options', [] );
        add_action( 'wp_head',    [ $this, 'output_dynamic_css' ], 99 );
        add_action( 'wp_head',    [ $this, 'output_custom_head_code' ], 100 );
        add_action( 'wp_footer',  [ $this, 'output_custom_js' ], 99 );
    }

    private function opt( $key, $default = '' ) {
        return isset( $this->opts[ $key ] ) ? $this->opts[ $key ] : $default;
    }

    public function output_dynamic_css() {
        $css = $this->build_root_tokens();
        $css .= $this->build_header_styles();
        $css .= $this->build_typography_styles();
        $css .= $this->build_scheme_overrides();
        $css .= $this->opt( 'adv_custom_css', '' );
        $css .= $this->opt( 'wc_custom_css', '' );

        if ( ! empty( trim( $css ) ) ) {
            echo '<style id="zc-dynamic-styles">' . $this->minify_css( $css ) . '</style>' . "\n";
        }
    }

    private function build_root_tokens() {
        $tokens = [
            '--zc-primary'       => sanitize_hex_color( $this->opt( 'color_primary',   '#7c6ff7' ) ),
            '--zc-secondary'     => sanitize_hex_color( $this->opt( 'color_secondary', '#00d4ff' ) ),
            '--zc-accent'        => sanitize_hex_color( $this->opt( 'color_accent',    '#a78bfa' ) ),
            '--zc-bg'            => sanitize_hex_color( $this->opt( 'color_bg',        '#07070f' ) ),
            '--zc-bg-secondary'  => sanitize_hex_color( $this->opt( 'color_bg_sec',    '#0f0f1f' ) ),
            '--zc-bg-card'       => sanitize_hex_color( $this->opt( 'color_bg_card',   '#111128' ) ),
            '--zc-border'        => sanitize_hex_color( $this->opt( 'color_border',    '#1e1e3a' ) ),
            '--zc-text'          => sanitize_hex_color( $this->opt( 'color_text',      '#e2e8f0' ) ),
            '--zc-text-muted'    => sanitize_hex_color( $this->opt( 'color_text_muted','#64748b' ) ),
            '--zc-text-strong'   => sanitize_hex_color( $this->opt( 'color_text_strong','#f1f5f9' ) ),
            '--zc-header-bg'     => sanitize_hex_color( $this->opt( 'color_header_bg', '#0a0a18' ) ),
            '--zc-topbar-bg'     => sanitize_hex_color( $this->opt( 'color_topbar_bg', '#07070f' ) ),
            '--zc-footer-bg'     => sanitize_hex_color( $this->opt( 'color_footer_bg', '#07070f' ) ),
            '--zc-header-height' => absint( $this->opt( 'header_height', 70 ) ) . 'px',
            '--zc-topbar-height' => absint( $this->opt( 'topbar_height', 40 ) ) . 'px',
            '--zc-radius-sm'     => absint( $this->opt( 'radius_sm', 4 ) ) . 'px',
            '--zc-radius-md'     => absint( $this->opt( 'radius_md', 8 ) ) . 'px',
            '--zc-radius-lg'     => absint( $this->opt( 'radius_lg', 12 ) ) . 'px',
            '--zc-radius-xl'     => absint( $this->opt( 'radius_xl', 16 ) ) . 'px',
        ];

        // Font tokens
        $body_font    = sanitize_text_field( $this->opt( 'font_body',    'Inter' ) );
        $heading_font = sanitize_text_field( $this->opt( 'font_heading', 'Inter' ) );
        $display_font = sanitize_text_field( $this->opt( 'font_display', 'Inter' ) );
        $tokens['--zc-font-body']    = "'" . $body_font . "', -apple-system, sans-serif";
        $tokens['--zc-font-heading'] = "'" . $heading_font . "', -apple-system, sans-serif";
        $tokens['--zc-font-display'] = "'" . $display_font . "', -apple-system, sans-serif";
        $tokens['--zc-font-size-base'] = absint( $this->opt( 'font_size_base', 15 ) ) . 'px';

        // Build custom scheme overrides
        $custom_tokens = [
            'sc_custom_primary'   => '--zc-primary',
            'sc_custom_secondary' => '--zc-secondary',
            'sc_custom_bg'        => '--zc-bg',
            'sc_custom_card'      => '--zc-bg-card',
            'sc_custom_text'      => '--zc-text',
            'sc_custom_muted'     => '--zc-text-muted',
            'sc_custom_border'    => '--zc-border',
            'sc_custom_header'    => '--zc-header-bg',
        ];
        foreach ( $custom_tokens as $opt_key => $var ) {
            $val = sanitize_hex_color( $this->opt( $opt_key, '' ) );
            if ( $val ) {
                $tokens[ $var ] = $val;
            }
        }

        $css = ':root{';
        foreach ( $tokens as $prop => $val ) {
            if ( ! empty( $val ) ) {
                $css .= $prop . ':' . $val . ';';
            }
        }
        $css .= '}' . "\n";
        return $css;
    }

    private function build_header_styles() {
        $css = '';
        $logo_height = absint( $this->opt( 'logo_height', 40 ) );
        $css .= ".custom-logo{height:{$logo_height}px;width:auto;}" . "\n";

        // Sticky header shadow
        if ( ! empty( $this->opt( 'header_sticky', 1 ) ) ) {
            $css .= ".zc-header.scrolled{box-shadow:0 2px 20px rgba(0,0,0,.4);}" . "\n";
        }
        return $css;
    }

    private function build_typography_styles() {
        $css = '';
        $h1 = absint( $this->opt( 'font_size_h1', 36 ) );
        $h2 = absint( $this->opt( 'font_size_h2', 28 ) );
        $h3 = absint( $this->opt( 'font_size_h3', 22 ) );
        $h4 = absint( $this->opt( 'font_size_h4', 18 ) );
        $css .= "h1{font-size:{$h1}px;}h2{font-size:{$h2}px;}h3{font-size:{$h3}px;}h4{font-size:{$h4}px;}" . "\n";
        return $css;
    }

    private function build_scheme_overrides() {
        $scheme = $this->opt( 'active_scheme', 'default' );
        // Active scheme is loaded as a stylesheet; this just ensures gradient matches
        $primary   = sanitize_hex_color( $this->opt( 'color_primary', '#7c6ff7' ) );
        $secondary = sanitize_hex_color( $this->opt( 'color_secondary', '#00d4ff' ) );
        return ":root{--zc-gradient:linear-gradient(135deg,{$primary},{$secondary});}" . "\n";
    }

    public function output_custom_head_code() {
        $code = $this->opt( 'adv_head_code', '' );
        if ( ! empty( $code ) && current_user_can( 'manage_options' ) ) {
            echo '<!-- ZinCelestial Custom Head -->' . "\n";
            // Output sanitized — admin only
            echo wp_kses_post( $code ) . "\n";
        }
    }

    public function output_custom_js() {
        $js = $this->opt( 'adv_custom_js', '' );
        if ( ! empty( $js ) && current_user_can( 'manage_options' ) ) {
            echo '<script id="zc-custom-js">' . "\n";
            echo $js . "\n"; // Admin-only, trusted input
            echo '<\/script>' . "\n";
        }

        // Debug info for admins
        if ( current_user_can( 'manage_options' ) && ! empty( $this->opt( 'adv_query_count', 0 ) ) ) {
            global $wpdb;
            echo '<div id="zc-debug-bar" style="position:fixed;bottom:0;left:0;right:0;background:#1a1a2e;color:#94a3b8;padding:.3rem 1rem;font-size:.72rem;z-index:99999;font-family:monospace;">';
            printf( esc_html__( 'Queries: %d | Memory: %s | Theme: ZinCelestial %s', 'zincelestial' ),
                $wpdb->num_queries,
                size_format( memory_get_peak_usage() ),
                defined('ZC_VERSION') ? ZC_VERSION : '3.0.0'
            );
            echo '</div>';
        }
    }

    private function minify_css( $css ) {
        $css = preg_replace( '/\s+/', ' ', $css );
        $css = preg_replace( '/\s*{\s*/', '{', $css );
        $css = preg_replace( '/\s*}\s*/', '}', $css );
        $css = preg_replace( '/\s*:\s*/', ':', $css );
        $css = preg_replace( '/\s*;\s*/', ';', $css );
        return trim( $css );
    }
}

new ZC_Custom_Styles();

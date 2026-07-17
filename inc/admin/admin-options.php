<?php
/**
 * ZinCelestial v5.0.0 — Admin Options
 * BUG FIX #3: zc_default_options() guarded with function_exists() — no duplicate fatal error
 * BUG FIX #5: All option reads use ZC_OPTS_KEY = 'zincelestial_options' (single key)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Default options — single source of truth.
 * guarded so admin-options.php can be included without clashing with functions.php
 * (functions.php also declares this with the same guard).
 */
if ( ! function_exists( 'zc_default_options' ) ) :
function zc_default_options() {
    return [
        'safe_mode'                 => '0',
        'enable_buddypress'         => '0',
        'enable_woocommerce'        => '0',
        'enable_bbpress'            => '0',
        'enable_reactions'          => '0',
        'enable_compose_bar'        => '0',
        'enable_gamipress_bar'      => '0',
        'enable_helpdesk'           => '0',
        'enable_analytics'          => '0',
        'enable_calendar_page'      => '0',
        'enable_library'            => '0',
        'enable_ai'                 => '0',
        'enable_dark_mode'          => '0',
        'enable_rtl'                => '0',
        'enable_post_meta'          => '0',
        'enable_category_colors'    => '0',
        'enable_header_sections'    => '0',
        'color_scheme'              => 'cosmic',
        'color_mode'                => 'dark',
        'sidebar_layout'            => 'right',
        'container_max_width'       => '1280',
        'excerpt_length'            => '30',
        'show_read_time'            => '0',
        'disable_google_fonts'      => '0',
        'color_primary'             => '#7c6ff7',
        'color_secondary'           => '#00d4ff',
        'color_accent'              => '#a78bfa',
        'color_success'             => '#34d399',
        'color_warning'             => '#fbbf24',
        'color_danger'              => '#f87171',
        'color_info'                => '#38bdf8',
        'color_bg'                  => '#07070f',
        'color_surface'             => '#0f0f1f',
        'color_card'                => '#161626',
        'color_border'              => '#1e1e3a',
        'color_text'                => '#e2e8f0',
        'font_body'                 => 'Inter',
        'font_display'              => 'Syne',
        'font_mono'                 => 'JetBrains Mono',
        'font_size_base'            => '16',
        'border_radius_md'          => '12',
        'header_layout'             => 'standard',
        'header_sticky'             => '0',
        'header_transparent'        => '0',
        'show_topbar'               => '0',
        'topbar_announcement'       => '',
        'header_left_menu'          => 'zc-primary',
        'header_center_menu'        => '',
        'header_right_menu'         => '',
        'header_right_icons'        => 'search,notifications,cart,user',
        'show_search_header'        => '0',
        'show_notifications_icon'   => '0',
        'show_messages_icon'        => '0',
        'show_cart_icon'            => '0',
        'show_left_panel'           => '0',
        'show_right_panel'          => '0',
        'left_panel_width'          => '280',
        'right_panel_width'         => '280',
        'show_footer_widgets'       => '0',
        'show_footer_bottom'        => '1',
        'footer_cols'               => '4',
        'footer_layout'             => '4-col',
        'footer_copyright'          => '&copy; ' . gmdate( 'Y' ) . ' Zinckles. All rights reserved.',
        'scroll_to_top'             => '0',
        'scroll_to_top_position'    => 'bottom-right',
        'scroll_to_top_style'       => 'arrow',
        'scroll_to_top_size'        => 'md',
        'show_scheme_switcher'      => '0',
        'scheme_switcher_position'  => 'bottom-left',
        'container_pad_left'        => '4',
        'container_pad_right'       => '4',
        'content_pad_top'           => '16',
        'content_pad_right'         => '4',
        'content_pad_bottom'        => '16',
        'content_pad_left'          => '4',
        'admin_ui_density'          => 'comfortable',
        'admin_card_padding'        => '28',
        'admin_content_gap'         => '24',
        'bp_cover_image'            => '0',
        'bp_cover_height'           => '350',
        'bp_cover_style'            => 'gradient-overlay',
        'bp_member_header_layout'   => 'card',
        'show_verified_badge'       => '0',
        'show_online_indicator'     => '0',
        'online_indicator_color'    => '#34d399',
        'member_directory_layout'   => 'grid',
        'members_per_page'          => '20',
        'group_directory_layout'    => 'grid',
        'groups_per_page'           => '20',
        'show_activity_reactions'   => '0',
        'show_bp_social_links'      => '0',
        'bp_sidebar_layout'         => 'none',
        'shop_layout'               => 'grid',
        'products_per_row'          => '4',
        'products_per_page'         => '12',
        'show_product_ratings'      => '0',
        'mini_cart'                 => '0',
        'mini_cart_position'        => 'offcanvas',
        'checkout_layout'           => 'standard',
        'woo_sidebar'               => '0',
        'enable_lazy_load'          => '0',
        'disable_emojis'            => '0',
        'disable_xmlrpc'            => '0',
        'remove_wp_version'         => '0',
    ];
}
endif;

/**
 * Option getter — also guarded (functions.php may define it first)
 */
if ( ! function_exists( 'zc_option' ) ) :
function zc_option( $key, $fallback = null ) {
    static $opts = null;
    if ( $opts === null ) {
        $opts = wp_parse_args(
            (array) get_option( ZC_OPTS_KEY, [] ),
            zc_default_options()
        );
    }
    if ( $fallback === null ) {
        $defs     = zc_default_options();
        $fallback = $defs[ $key ] ?? '';
    }
    return $opts[ $key ] ?? $fallback;
}
endif;

/**
 * Module enabled helper
 */
if ( ! function_exists( 'zc_module_enabled' ) ) :
function zc_module_enabled( $module ) {
    return zc_option( 'enable_' . $module ) === '1';
}
endif;

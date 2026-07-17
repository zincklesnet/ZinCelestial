<?php
/**
 * ZinCelestial v5.2.0 — WordPress Customizer
 *
 * Panels:
 *  1. General / Site Identity
 *  2. Header & Navigation
 *  3. Typography
 *  4. Colors & Schemes
 *  5. BuddyPress
 *  6. WooCommerce
 *  7. bbPress
 *  8. Footer
 *  9. Layout & Sidebars
 * 10. Advanced
 *
 * NO references to any other theme names in this file.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'customize_register', 'zc_customizer_register' );

function zc_customizer_register( $wp_customize ) {

    /* ── Helper: add setting + control together ──────────────────────────── */
    $add = function( $id, $label, $type, $section, $default = '', $choices = [], $transport = 'postMessage', $extra = [] ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, array_merge( [
            'default'           => $default,
            'transport'         => $transport,
            'sanitize_callback' => zc_customizer_sanitize_cb( $type ),
        ], $extra ) );

        $ctrl_args = [
            'label'   => $label,
            'section' => $section,
            'type'    => $type,
        ];
        if ( ! empty( $choices ) ) $ctrl_args['choices'] = $choices;

        if ( $type === 'color' ) {
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $ctrl_args ) );
        } elseif ( $type === 'image' ) {
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $ctrl_args ) );
        } else {
            $wp_customize->add_control( $id, $ctrl_args );
        }
    };

    /* ── Panels ─────────────────────────────────────────────────────────────── */
    $panels = [
        'zc_panel_header'   => [ 'title' => 'Header & Navigation',  'priority' => 30 ],
        'zc_panel_identity' => [ 'title' => 'Site Identity & Branding', 'priority' => 31 ],
        'zc_panel_typo'     => [ 'title' => 'Typography',           'priority' => 32 ],
        'zc_panel_colors'   => [ 'title' => 'Colors & Schemes',     'priority' => 33 ],
        'zc_panel_layout'   => [ 'title' => 'Layout & Sidebars',    'priority' => 34 ],
        'zc_panel_bp'       => [ 'title' => 'BuddyPress',           'priority' => 40 ],
        'zc_panel_wc'       => [ 'title' => 'WooCommerce',          'priority' => 41 ],
        'zc_panel_bbp'      => [ 'title' => 'bbPress Forums',       'priority' => 42 ],
        'zc_panel_footer'   => [ 'title' => 'Footer',               'priority' => 50 ],
        'zc_panel_advanced' => [ 'title' => 'Advanced',             'priority' => 60 ],
    ];
    foreach ( $panels as $id => $args ) {
        $wp_customize->add_panel( $id, [
            'title'    => $args['title'],
            'priority' => $args['priority'],
        ] );
    }

    /* ════════════════════════════════════════════════════════
       SECTIONS
    ════════════════════════════════════════════════════════ */

    /* ── Header & Navigation ─────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_header_general', [ 'title' => 'General Header', 'panel' => 'zc_panel_header', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_header_colors',  [ 'title' => 'Header Colors',  'panel' => 'zc_panel_header', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_header_logo',    [ 'title' => 'Logo & Branding','panel' => 'zc_panel_header', 'priority' => 30 ] );
    $wp_customize->add_section( 'zc_sec_topbar',         [ 'title' => 'Topbar',         'panel' => 'zc_panel_header', 'priority' => 40 ] );
    $wp_customize->add_section( 'zc_sec_nav_menus',      [ 'title' => 'Navigation Menus','panel' => 'zc_panel_header','priority' => 50 ] );
    $wp_customize->add_section( 'zc_sec_subheader',      [ 'title' => 'Page Subheader', 'panel' => 'zc_panel_header', 'priority' => 60 ] );

    /* ── Site Identity ───────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_site_id',  [ 'title' => 'Site Name & Tagline', 'panel' => 'zc_panel_identity', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_favicons', [ 'title' => 'Favicon & Icons',     'panel' => 'zc_panel_identity', 'priority' => 20 ] );

    /* ── Typography ─────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_fonts_body',    [ 'title' => 'Body Font',    'panel' => 'zc_panel_typo', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_fonts_display', [ 'title' => 'Heading Font', 'panel' => 'zc_panel_typo', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_font_sizes',    [ 'title' => 'Font Sizes',   'panel' => 'zc_panel_typo', 'priority' => 30 ] );

    /* ── Colors & Schemes ───────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_scheme',     [ 'title' => 'Color Scheme',    'panel' => 'zc_panel_colors', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_colors_pri', [ 'title' => 'Primary Colors',  'panel' => 'zc_panel_colors', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_dark_light',  [ 'title' => 'Dark/Light Mode','panel' => 'zc_panel_colors', 'priority' => 30 ] );

    /* ── Layout ─────────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_layout_general', [ 'title' => 'General Layout',  'panel' => 'zc_panel_layout', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_layout_blog',    [ 'title' => 'Blog Layout',     'panel' => 'zc_panel_layout', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_layout_single',  [ 'title' => 'Single Post',     'panel' => 'zc_panel_layout', 'priority' => 30 ] );

    /* ── BuddyPress ─────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_bp_members',  [ 'title' => 'Members Directory', 'panel' => 'zc_panel_bp', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_bp_activity', [ 'title' => 'Activity Feed',     'panel' => 'zc_panel_bp', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_bp_groups',   [ 'title' => 'Groups Directory',  'panel' => 'zc_panel_bp', 'priority' => 30 ] );
    $wp_customize->add_section( 'zc_sec_bp_profile',  [ 'title' => 'Member Profiles',   'panel' => 'zc_panel_bp', 'priority' => 40 ] );
    $wp_customize->add_section( 'zc_sec_bp_avatars',  [ 'title' => 'Avatars & Cover Photos', 'panel' => 'zc_panel_bp', 'priority' => 50 ] );

    /* ── WooCommerce ─────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_wc_shop',     [ 'title' => 'Shop / Archive',  'panel' => 'zc_panel_wc', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_wc_product',  [ 'title' => 'Single Product',  'panel' => 'zc_panel_wc', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_wc_cart',     [ 'title' => 'Cart & Checkout', 'panel' => 'zc_panel_wc', 'priority' => 30 ] );
    $wp_customize->add_section( 'zc_sec_wc_colors',   [ 'title' => 'WC Colors',       'panel' => 'zc_panel_wc', 'priority' => 40 ] );

    /* ── bbPress ─────────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_bbp_general', [ 'title' => 'Forum General',  'panel' => 'zc_panel_bbp', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_bbp_colors',  [ 'title' => 'Forum Colors',   'panel' => 'zc_panel_bbp', 'priority' => 20 ] );

    /* ── Footer ──────────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_footer_general', [ 'title' => 'General Footer',  'panel' => 'zc_panel_footer', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_footer_colors',  [ 'title' => 'Footer Colors',   'panel' => 'zc_panel_footer', 'priority' => 20 ] );
    $wp_customize->add_section( 'zc_sec_footer_widgets', [ 'title' => 'Footer Widgets',  'panel' => 'zc_panel_footer', 'priority' => 30 ] );

    /* ── Advanced ─────────────────────────────────────────────────────────── */
    $wp_customize->add_section( 'zc_sec_adv_perf',  [ 'title' => 'Performance',    'panel' => 'zc_panel_advanced', 'priority' => 10 ] );
    $wp_customize->add_section( 'zc_sec_adv_custom', [ 'title' => 'Custom CSS/JS', 'panel' => 'zc_panel_advanced', 'priority' => 20 ] );

    /* ════════════════════════════════════════════════════════
       SETTINGS & CONTROLS
    ════════════════════════════════════════════════════════ */

    /* ── Header General ─────────────────────────────────────────────────── */
    $add( 'zc_header_layout', 'Header Layout', 'select', 'zc_sec_header_general', 'standard', [
        'standard'    => 'Standard (Logo Left, Menu Right)',
        'centered'    => 'Centered (Logo Center)',
        'left-aligned'=> 'Left-Aligned (Logo + Menu Left)',
        'split'       => 'Split (Menu both sides)',
    ] );
    $add( 'zc_header_sticky', 'Sticky Header', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_header_transparent', 'Transparent Header on Front Page', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_header_fullwidth', 'Full-width Header', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_show_search_header', 'Show Search Icon in Header', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_show_cart_icon', 'Show Cart Icon in Header (WC)', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_show_notifications_icon', 'Show Notifications Icon (BP)', 'checkbox', 'zc_sec_header_general', false );
    $add( 'zc_show_messages_icon', 'Show Messages Icon (BP)', 'checkbox', 'zc_sec_header_general', false );

    /* ── Header Colors ───────────────────────────────────────────────────── */
    $add( 'zc_header_bg_color',   'Header Background Color',  'color', 'zc_sec_header_colors', '' );
    $add( 'zc_header_text_color', 'Header Text/Link Color',   'color', 'zc_sec_header_colors', '' );
    $add( 'zc_nav_hover_color',   'Nav Link Hover Color',     'color', 'zc_sec_header_colors', '' );

    /* ── Header Logo ──────────────────────────────────────────────────────── */
    $add( 'zc_logo_height', 'Logo Height (px)', 'number', 'zc_sec_header_logo', 40 );
    $add( 'zc_logo_mobile_height', 'Logo Height on Mobile (px)', 'number', 'zc_sec_header_logo', 32 );

    /* ── Topbar ───────────────────────────────────────────────────────────── */
    $add( 'zc_show_topbar',    'Show Topbar',   'checkbox', 'zc_sec_topbar', false );
    $add( 'zc_topbar_text',    'Topbar Text / HTML', 'textarea', 'zc_sec_topbar', '' );
    $add( 'zc_topbar_bg',      'Topbar Background Color', 'color', 'zc_sec_topbar', '' );
    $add( 'zc_topbar_text_color', 'Topbar Text Color', 'color', 'zc_sec_topbar', '' );

    /* ── Subheader ────────────────────────────────────────────────────────── */
    $add( 'zc_show_subheader',     'Show Page Subheader', 'checkbox', 'zc_sec_subheader', true );
    $add( 'zc_subheader_height',   'Subheader Height (px)', 'number', 'zc_sec_subheader', 120 );
    $add( 'zc_subheader_bg_color', 'Subheader Background Color', 'color', 'zc_sec_subheader', '' );
    $add( 'zc_subheader_text_color', 'Subheader Text Color', 'color', 'zc_sec_subheader', '' );
    $add( 'zc_subheader_bg_image', 'Subheader Background Image', 'image', 'zc_sec_subheader', '' );
    $add( 'zc_subheader_show_breadcrumb', 'Show Breadcrumb', 'checkbox', 'zc_sec_subheader', true );

    /* ── Navigation ──────────────────────────────────────────────────────── */
    $add( 'zc_nav_style', 'Navigation Style', 'select', 'zc_sec_nav_menus', 'default', [
        'default'  => 'Default',
        'underline'=> 'Underline Active',
        'pill'     => 'Pill Active',
        'bordered' => 'Bordered',
    ] );

    /* ── Typography ─────────────────────────────────────────────────────── */
    $google_fonts = [ 'Inter', 'Syne', 'Nunito', 'Raleway', 'Roboto', 'Open Sans', 'Poppins', 'Montserrat', 'Lato', 'Source Sans Pro', 'Playfair Display', 'Merriweather', 'system-ui' ];
    $font_choices = array_combine( $google_fonts, $google_fonts );

    $add( 'zc_font_body',     'Body Font Family',    'select', 'zc_sec_fonts_body',    'Inter',  $font_choices, 'refresh' );
    $add( 'zc_font_size_base','Base Font Size (px)', 'number', 'zc_sec_fonts_body',    16 );
    $add( 'zc_font_display',  'Heading Font Family', 'select', 'zc_sec_fonts_display', 'Syne',   $font_choices, 'refresh' );
    $add( 'zc_disable_google_fonts', 'Disable Google Fonts (use system fonts)', 'checkbox', 'zc_sec_fonts_body', false );

    /* ── Color Scheme ───────────────────────────────────────────────────── */
    $add( 'zc_color_scheme', 'Active Color Scheme', 'select', 'zc_sec_scheme', 'cosmic', [
        'cosmic'   => 'Cosmic (Purple/Cyan)',
        'aurora'   => 'Aurora (Teal/Violet)',
        'nova'     => 'Nova (Gold/Crimson)',
        'zenith'   => 'Zenith (Slate/Sky)',
        'ember'    => 'Ember (Rose/Orange)',
        'twilight' => 'Twilight (Lavender/Pink)',
    ], 'refresh' );

    $add( 'zc_color_mode', 'Color Mode', 'select', 'zc_sec_dark_light', 'dark', [
        'dark'  => 'Dark',
        'light' => 'Light',
        'auto'  => 'Auto (System Preference)',
    ], 'refresh' );

    /* ── Custom Colors ───────────────────────────────────────────────────── */
    $add( 'zc_color_primary',   'Primary Color',   'color', 'zc_sec_colors_pri', '' );
    $add( 'zc_color_secondary', 'Secondary Color', 'color', 'zc_sec_colors_pri', '' );
    $add( 'zc_color_accent',    'Accent Color',    'color', 'zc_sec_colors_pri', '' );

    /* ── Layout ─────────────────────────────────────────────────────────── */
    $add( 'zc_container_max_width', 'Max Container Width (px)', 'number', 'zc_sec_layout_general', 1280 );
    $add( 'zc_border_radius',       'Border Radius (px)',       'number', 'zc_sec_layout_general', 12 );
    $add( 'zc_sidebar_layout', 'Default Sidebar Layout', 'select', 'zc_sec_layout_general', 'right', [
        'right' => 'Right Sidebar',
        'left'  => 'Left Sidebar',
        'none'  => 'No Sidebar (Full Width)',
    ] );
    $add( 'zc_blog_layout', 'Blog Grid Columns', 'select', 'zc_sec_layout_blog', '3', [
        '1' => '1 Column',
        '2' => '2 Columns',
        '3' => '3 Columns (default)',
        '4' => '4 Columns',
    ] );

    /* ── BuddyPress — Members ────────────────────────────────────────────── */
    $add( 'zc_bp_members_per_page', 'Members Per Page', 'number', 'zc_sec_bp_members', 20 );
    $add( 'zc_bp_members_default_view', 'Default Members View', 'select', 'zc_sec_bp_members', 'grid', [
        'grid' => 'Grid (Cards)',
        'list' => 'List',
    ] );
    $add( 'zc_bp_show_online_status', 'Show Online Status Indicator', 'checkbox', 'zc_sec_bp_members', true );
    $add( 'zc_bp_show_verified_badge', 'Show Verified Badge', 'checkbox', 'zc_sec_bp_members', true );
    $add( 'zc_bp_show_follow_btn', 'Show Follow/Friend Button', 'checkbox', 'zc_sec_bp_members', true );

    /* ── BuddyPress — Activity ───────────────────────────────────────────── */
    $add( 'zc_bp_activity_per_page', 'Activity Items Per Page', 'number', 'zc_sec_bp_activity', 20 );
    $add( 'zc_bp_activity_load', 'Activity Load Style', 'select', 'zc_sec_bp_activity', 'ajax', [
        'ajax'       => 'AJAX Load More',
        'infinite'   => 'Infinite Scroll',
        'pagination' => 'Pagination',
    ] );

    /* ── BuddyPress — Groups ─────────────────────────────────────────────── */
    $add( 'zc_bp_groups_per_page', 'Groups Per Page', 'number', 'zc_sec_bp_groups', 20 );
    $add( 'zc_bp_groups_default_view', 'Default Groups View', 'select', 'zc_sec_bp_groups', 'grid', [
        'grid' => 'Grid (Cards)',
        'list' => 'List',
    ] );

    /* ── BuddyPress — Profiles ───────────────────────────────────────────── */
    $add( 'zc_bp_cover_photos', 'Enable Cover Photos', 'checkbox', 'zc_sec_bp_profile', true );
    $add( 'zc_bp_cover_height', 'Cover Photo Height (px)', 'number', 'zc_sec_bp_profile', 300 );
    $add( 'zc_bp_member_header_layout', 'Member Header Layout', 'select', 'zc_sec_bp_profile', 'standard', [
        'standard' => 'Standard (Avatar Left)',
        'centered' => 'Centered (Avatar Center)',
        'minimal'  => 'Minimal',
    ] );

    /* ── BuddyPress — Avatars ────────────────────────────────────────────── */
    $add( 'zc_bp_avatar_size',       'Avatar Size (px)',        'number',   'zc_sec_bp_avatars', 80 );
    $add( 'zc_bp_round_avatars',     'Round Avatars',           'checkbox', 'zc_sec_bp_avatars', true );
    $add( 'zc_bp_gravatar_fallback', 'Use Gravatar Fallback',   'checkbox', 'zc_sec_bp_avatars', true );
    $add( 'zc_bp_default_avatar',    'Default User Avatar',     'image',    'zc_sec_bp_avatars', '' );
    $add( 'zc_bp_default_group_avatar', 'Default Group Avatar', 'image',    'zc_sec_bp_avatars', '' );

    /* ── WooCommerce — Shop ──────────────────────────────────────────────── */
    $add( 'zc_wc_shop_columns',     'Shop Grid Columns',     'select', 'zc_sec_wc_shop', '3', [
        '2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns',
    ] );
    $add( 'zc_wc_products_per_page','Products Per Page',     'number', 'zc_sec_wc_shop', 12 );
    $add( 'zc_wc_show_sale_badge',  'Show Sale Badge',       'checkbox','zc_sec_wc_shop', true );
    $add( 'zc_wc_show_rating',      'Show Star Rating',      'checkbox','zc_sec_wc_shop', true );
    $add( 'zc_wc_show_quick_view',  'Enable Quick View Button','checkbox','zc_sec_wc_shop', false );

    /* ── WooCommerce — Product ───────────────────────────────────────────── */
    $add( 'zc_wc_related_products', 'Related Products Count', 'number', 'zc_sec_wc_product', 4 );
    $add( 'zc_wc_show_tabs',        'Show Product Tabs',      'checkbox','zc_sec_wc_product', true );
    $add( 'zc_wc_show_social_share','Show Social Share Buttons','checkbox','zc_sec_wc_product', false );

    /* ── WooCommerce — Colors ────────────────────────────────────────────── */
    $add( 'zc_wc_price_color',    'Price Color',         'color', 'zc_sec_wc_colors', '' );
    $add( 'zc_wc_button_color',   'Button Color',        'color', 'zc_sec_wc_colors', '' );
    $add( 'zc_wc_sale_badge_color', 'Sale Badge Color',  'color', 'zc_sec_wc_colors', '' );

    /* ── bbPress ─────────────────────────────────────────────────────────── */
    $add( 'zc_bbp_show_breadcrumb', 'Show Forum Breadcrumb', 'checkbox', 'zc_sec_bbp_general', true );
    $add( 'zc_bbp_topics_per_page', 'Topics Per Page', 'number', 'zc_sec_bbp_general', 20 );
    $add( 'zc_bbp_replies_per_page','Replies Per Page', 'number', 'zc_sec_bbp_general', 15 );
    $add( 'zc_bbp_accent_color',    'Forum Accent Color', 'color', 'zc_sec_bbp_colors', '' );

    /* ── Footer ─────────────────────────────────────────────────────────── */
    $add( 'zc_footer_columns', 'Footer Widget Columns', 'select', 'zc_sec_footer_general', '4', [
        '1' => '1 Column', '2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns',
    ] );
    $add( 'zc_footer_copyright', 'Copyright Text', 'text', 'zc_sec_footer_general', '© ' . gmdate('Y') . ' ZinCelestial. All Rights Reserved.' );
    $add( 'zc_show_footer_social', 'Show Social Icons', 'checkbox', 'zc_sec_footer_general', true );
    $add( 'zc_footer_bg_color',   'Footer Background Color', 'color', 'zc_sec_footer_colors', '' );
    $add( 'zc_footer_text_color', 'Footer Text Color',       'color', 'zc_sec_footer_colors', '' );
    $add( 'zc_footer_link_color', 'Footer Link Color',       'color', 'zc_sec_footer_colors', '' );

    /* ── Advanced ────────────────────────────────────────────────────────── */
    $add( 'zc_disable_google_fonts_adv', 'Disable Google Fonts', 'checkbox', 'zc_sec_adv_perf', false );
    $add( 'zc_enable_lazy_load',  'Enable Lazy Loading Images', 'checkbox', 'zc_sec_adv_perf', true );

    /* Custom CSS - use WP's built-in section */
    $wp_customize->get_section( 'custom_css' ) &&
        $wp_customize->get_section( 'custom_css' )->panel = 'zc_panel_advanced';
}

/* ── Sanitize callback factory ───────────────────────────────────────────── */
function zc_customizer_sanitize_cb( $type ) {
    switch ( $type ) {
        case 'checkbox':  return 'zc_sanitize_checkbox';
        case 'color':     return 'sanitize_hex_color';
        case 'number':    return 'absint';
        case 'select':    return 'sanitize_key';
        case 'textarea':  return 'wp_kses_post';
        case 'text':
        default:          return 'sanitize_text_field';
    }
}

if ( ! function_exists( 'zc_sanitize_checkbox' ) ) {
    function zc_sanitize_checkbox( $val ) {
        return (bool) $val;
    }
}

/* ── Live preview (postMessage) ─────────────────────────────────────────── */
add_action( 'customize_preview_init', function () {
    $js = ZC_ASSETS_DIR . '/js/customizer.js';
    if ( file_exists( $js ) ) {
        wp_enqueue_script( 'zc-customizer', ZC_ASSETS . '/js/customizer.js', [ 'customize-preview' ], ZC_VERSION, true );
    }
} );

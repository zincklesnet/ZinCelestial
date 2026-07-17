<?php
/**
 * ZinCelestial v5.1.0 — Main Functions File
 * WordPress Multisite Frontend Theme
 * Bootstrap 5.3.3 | BuddyPress | WooCommerce | bbPress
 *
 * v5.1.0 Changes:
 *  - Added full Customizer panels (header, BP, WC, bbP, menus, typography)
 *  - Fixed BP template stack registration (bp_register_template_stack)
 *  - Fixed WC textdomain timing (deferred to after_setup_theme priority 20)
 *  - Fixed admin tabs coexistence with Bootstrap 5
 *  - Fixed safe mode AJAX nonce
 *  - Added ZinGenesis detection hiding Performance/Security at menu-register time
 *  - Added subheader/hero section support
 *  - Added proper sidebar registration for BP/WC/bbP
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ═══════════════════════════════════════════════════════════════════════════════
// CONSTANTS
// ═══════════════════════════════════════════════════════════════════════════════
define( 'ZC_VERSION',    '5.2.0' );
define( 'ZC_DIR',        get_template_directory() );
define( 'ZC_URI',        get_template_directory_uri() );
define( 'ZC_INC',        ZC_DIR . '/inc/' );
define( 'ZC_ASSETS',     ZC_URI . '/assets' );
define( 'ZC_ASSETS_DIR', ZC_DIR . '/assets' );
define( 'ZC_TEXT',       'zincelestial' );
define( 'ZC_MIN_PHP',    '8.0' );
define( 'ZC_MIN_WP',     '6.0' );
define( 'ZC_OPTS_KEY',   'zincelestial_options' );

// ═══════════════════════════════════════════════════════════════════════════════
// PHP VERSION GATE
// ═══════════════════════════════════════════════════════════════════════════════
if ( version_compare( PHP_VERSION, ZC_MIN_PHP, '<' ) ) {
    add_action( 'admin_notices', function () {
        echo '<div class="notice notice-error"><p><strong>ZinCelestial</strong> requires PHP '
            . ZC_MIN_PHP . ' or later. Current: ' . PHP_VERSION . '</p></div>';
    } );
    return;
}

// ═══════════════════════════════════════════════════════════════════════════════
// ZINGENESIS ADMIN DETECTION (must run very early)
// ═══════════════════════════════════════════════════════════════════════════════
if ( ! function_exists( 'zc_is_genesis_admin_active' ) ) :
function zc_is_genesis_admin_active() {
    static $result = null;
    if ( $result !== null ) return $result;
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $slugs = [
        'zinckles-genesis-admin-theme/zinckles-genesis-admin-theme.php',
        'zinckles-genesis-admin-theme/genesis-admin.php',
        'genesis-admin/genesis-admin.php',
        'zinckles-genesis-admin/zinckles-genesis-admin.php',
        'zinckles-genesis-admin/genesis-admin.php',
        'zingenesis/zingenesis.php',
        'zin-genesis/zin-genesis.php',
    ];
    foreach ( $slugs as $slug ) {
        if ( is_plugin_active( $slug ) || is_plugin_active_for_network( $slug ) ) {
            $result = true;
            return $result;
        }
    }
    // Also check by class/constant presence
    if ( defined( 'ZINGENESIS_VERSION' ) || class_exists( 'ZinGenesis_Admin' ) ) {
        $result = true;
        return $result;
    }
    $result = false;
    return $result;
}
endif;

// Define constant immediately for use throughout theme
add_action( 'after_setup_theme', function () {
    if ( ! defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) ) {
        define( 'ZC_GENESIS_ADMIN_ACTIVE', zc_is_genesis_admin_active() );
    }
}, 1 );

// ═══════════════════════════════════════════════════════════════════════════════
// DEFAULT OPTIONS
// ═══════════════════════════════════════════════════════════════════════════════
if ( ! function_exists( 'zc_default_options' ) ) :
function zc_default_options() {
    return [
        // Core
        'safe_mode'                 => '0',
        // Plugin detection
        'enable_buddypress'         => '0',
        'enable_woocommerce'        => '0',
        'enable_bbpress'            => '0',
        // Stage 2+ modules (all OFF by default)
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
        // Design
        'color_scheme'              => 'cosmic',
        'color_mode'                => 'dark',
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
        // Typography
        'font_body'                 => 'Inter',
        'font_display'              => 'Syne',
        'font_mono'                 => 'JetBrains Mono',
        'font_size_base'            => '16',
        'border_radius_md'          => '12',
        'disable_google_fonts'      => '0',
        // Layout
        'sidebar_layout'            => 'right',
        'container_max_width'       => '1280',
        'excerpt_length'            => '30',
        'show_read_time'            => '0',
        // Header
        'header_layout'             => 'standard',
        'header_sticky'             => '0',
        'header_transparent'        => '0',
        'show_topbar'               => '0',
        'topbar_announcement'       => '',
        'topbar_bg_color'           => '',
        'header_bg_color'           => '',
        'header_text_color'         => '',
        'header_logo_height'        => '40',
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
        // Subheader
        'show_subheader'            => '0',
        'subheader_style'           => 'gradient',
        'subheader_height'          => '120',
        'subheader_bg_color'        => '',
        'subheader_text_color'      => '',
        'subheader_show_breadcrumb' => '1',
        'subheader_show_title'      => '1',
        // Footer
        'show_footer_widgets'       => '0',
        'show_footer_bottom'        => '1',
        'footer_cols'               => '4',
        'footer_layout'             => '4-col',
        'footer_copyright'          => '&copy; ' . gmdate( 'Y' ) . ' Zinckles. All rights reserved.',
        'footer_bg_color'           => '',
        'footer_text_color'         => '',
        // UI controls
        'scroll_to_top'             => '0',
        'scroll_to_top_position'    => 'bottom-right',
        'scroll_to_top_style'       => 'arrow',
        'scroll_to_top_size'        => 'md',
        'show_scheme_switcher'      => '0',
        'scheme_switcher_position'  => 'bottom-left',
        // BuddyPress
        'bp_template_pack'          => 'nouveau',
        'bp_cover_image'            => '0',
        'bp_cover_height'           => '350',
        'bp_cover_style'            => 'gradient-overlay',
        'bp_member_header_layout'   => 'card',
        'bp_default_avatar'         => '',
        'bp_default_group_avatar'   => '',
        'bp_default_cover'          => '',
        'bp_default_group_cover'    => '',
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
        'bp_show_friends_count'     => '1',
        'bp_show_group_count'       => '1',
        'bp_activity_layout'        => 'single',
        // WooCommerce
        'shop_layout'               => 'grid',
        'products_per_row'          => '4',
        'products_per_page'         => '12',
        'show_product_ratings'      => '0',
        'mini_cart'                 => '0',
        'mini_cart_position'        => 'offcanvas',
        'checkout_layout'           => 'standard',
        'woo_sidebar'               => '0',
        'woo_layout'                => 'full-width',
        'woo_breadcrumb'            => '1',
        'woo_sale_badge'            => '1',
        'woo_quick_view'            => '0',
        // bbPress
        'bbp_layout'                => 'standard',
        'bbp_sidebar'               => '0',
        'bbp_show_breadcrumb'       => '1',
        'bbp_avatars'               => '1',
        'bbp_ajax_replies'          => '0',
        // Performance (when Genesis not active)
        'enable_lazy_load'          => '0',
        'disable_emojis'            => '0',
        'disable_xmlrpc'            => '0',
        'remove_wp_version'         => '0',
        // Security (when Genesis not active)
        'disable_file_edit'         => '0',
        'login_logo'                => '0',
        // Admin UI
        'admin_ui_density'          => 'comfortable',
        'admin_card_padding'        => '28',
        'admin_content_gap'         => '24',
    ];
}
endif;

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

if ( ! function_exists( 'zc_module_enabled' ) ) :
function zc_module_enabled( $module ) {
    return zc_option( 'enable_' . $module ) === '1';
}
endif;

// ═══════════════════════════════════════════════════════════════════════════════
// SAFE MODE — bail to minimal mode if enabled
// ═══════════════════════════════════════════════════════════════════════════════
add_action( 'after_setup_theme', function () {
    if ( zc_option( 'safe_mode' ) === '1' ) {
        // Redirect template loading to Twenty Twenty-Five
        add_filter( 'stylesheet', function () { return 'twentytwentyfive'; } );
        add_filter( 'template',   function () { return 'twentytwentyfive'; } );
        // Keep admin accessible
    }
}, 5 );

// ═══════════════════════════════════════════════════════════════════════════════
// CORE THEME SETUP
// ═══════════════════════════════════════════════════════════════════════════════
add_action( 'after_setup_theme', function () {

    load_theme_textdomain( ZC_TEXT, ZC_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'custom-background' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );

    // ── Content width
    if ( ! isset( $GLOBALS['content_width'] ) ) {
        $GLOBALS['content_width'] = (int) zc_option( 'container_max_width', 1280 );
    }

}, 10 );

// ── WooCommerce theme support — deferred to priority 20 to avoid textdomain warning
add_action( 'after_setup_theme', function () {
    if ( class_exists( 'WooCommerce' ) ) {
        add_theme_support( 'woocommerce', [
            'thumbnail_image_width'         => 300,
            'single_image_width'            => 600,
            'product_grid'                  => [
                'default_rows'    => 3,
                'min_rows'        => 1,
                'default_columns' => (int) zc_option( 'products_per_row', 4 ),
                'min_columns'     => 1,
                'max_columns'     => 6,
            ],
        ] );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}, 20 );

// ── BuddyPress theme support — after BP is loaded
add_action( 'after_setup_theme', function () {
    if ( function_exists( 'buddypress' ) ) {
        add_theme_support( 'buddypress' );
    }
}, 20 );

// ═══════════════════════════════════════════════════════════════════════════════
// BUDDYPRESS TEMPLATE STACK (critical — must run at bp_setup_theme or later)
// ═══════════════════════════════════════════════════════════════════════════════
add_action( 'bp_setup_theme', function () {
    if ( ! function_exists( 'bp_register_template_stack' ) ) return;

    // Register ZinCelestial's BP template directory at high priority
    bp_register_template_stack( function() {
        return ZC_DIR . '/buddypress';
    }, 10 );

    // Disable BP's own theme compat so our templates take over completely
    add_filter( 'bp_use_theme_compat_with_current_theme', '__return_false' );
    add_filter( 'bp_get_theme_compat_active', '__return_false' );

} );

// Also hook into bp_get_template_stack for extra safety
add_filter( 'bp_get_template_stack', function ( $stack ) {
    $zc_bp = ZC_DIR . '/buddypress';
    if ( ! in_array( $zc_bp, (array) $stack, true ) ) {
        array_unshift( $stack, $zc_bp );
    }
    return $stack;
}, 999 );

// ═══════════════════════════════════════════════════════════════════════════════
// LOAD INC FILES
// ═══════════════════════════════════════════════════════════════════════════════
$zc_files = [
    // Admin options first (defines zc_option, zc_default_options)
    'inc/admin/admin-options.php',
    // Setup
    'inc/setup/menus.php',
    'inc/setup/sidebars.php',
    'inc/setup/enqueue.php',
    // Helpers
    'inc/extras.php',
    // Admin panel
    'inc/admin/admin-panel.php',
    // Customizer
    'inc/customizer/customizer.php',
    // BuddyPress integration
    'inc/buddypress/bp-setup.php',
    // WooCommerce integration
    'inc/woocommerce/woo-setup.php',
    // bbPress integration
    'inc/bbpress/bbpress-setup.php',
    // Shortcodes
    'inc/shortcodes/shortcodes.php',
    // Post meta
    'inc/post-meta/post-meta.php',
    // Category colors
    'inc/taxonomy/category-colors.php',
];

foreach ( $zc_files as $file ) {
    $full_path = ZC_DIR . '/' . $file;
    if ( file_exists( $full_path ) ) {
        require_once $full_path;
    }
}
unset( $file, $full_path, $zc_files );

// ═══════════════════════════════════════════════════════════════════════════════
// PERFORMANCE (when Genesis Admin NOT active)
// ═══════════════════════════════════════════════════════════════════════════════
add_action( 'init', function () {
    if ( ZC_GENESIS_ADMIN_ACTIVE ) return;

    if ( zc_option( 'disable_emojis' ) === '1' ) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }

    if ( zc_option( 'disable_xmlrpc' ) === '1' ) {
        add_filter( 'xmlrpc_enabled', '__return_false' );
    }

    if ( zc_option( 'remove_wp_version' ) === '1' ) {
        remove_action( 'wp_head', 'wp_generator' );
        add_filter( 'the_generator', '__return_empty_string' );
    }

    if ( zc_option( 'disable_file_edit' ) === '1' && ! defined( 'DISALLOW_FILE_EDIT' ) ) {
        define( 'DISALLOW_FILE_EDIT', true );
    }
} );

// ═══════════════════════════════════════════════════════════════════════════════
// SUBHEADER / PAGE HERO
// ═══════════════════════════════════════════════════════════════════════════════
if ( ! function_exists( 'zc_render_subheader' ) ) :
function zc_render_subheader() {
    if ( zc_option( 'show_subheader', '0' ) !== '1' ) return;

    $show_title      = zc_option( 'subheader_show_title', '1' ) === '1';
    $show_breadcrumb = zc_option( 'subheader_show_breadcrumb', '1' ) === '1';
    $style           = zc_option( 'subheader_style', 'gradient' );
    $height          = (int) zc_option( 'subheader_height', 120 );

    // Get the current page title
    if ( is_home() || is_front_page() ) {
        $title = get_bloginfo( 'name' );
    } elseif ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    } elseif ( is_search() ) {
        $title = sprintf( __( 'Search: %s', ZC_TEXT ), get_search_query() );
    } elseif ( is_404() ) {
        $title = __( 'Page Not Found', ZC_TEXT );
    } elseif ( is_singular() ) {
        $title = get_the_title();
    } elseif ( is_archive() ) {
        $title = get_the_archive_title();
    } else {
        $title = get_bloginfo( 'name' );
    }

    // BuddyPress title override
    if ( function_exists( 'bp_is_active' ) && function_exists( 'bp_get_displayed_user_fullname' ) ) {
        if ( function_exists( 'bp_current_component' ) && bp_current_component() ) {
            $title = function_exists( 'bp_get_displayed_user_fullname' )
                ? bp_get_displayed_user_fullname()
                : $title;
        }
    }

    echo '<div class="zc-subheader zc-subheader--' . esc_attr( $style ) . '" style="min-height:' . esc_attr( $height ) . 'px;">';
    echo '<div class="container">';
    if ( $show_title ) {
        echo '<h1 class="zc-subheader__title">' . esc_html( $title ) . '</h1>';
    }
    if ( $show_breadcrumb ) {
        zc_breadcrumb();
    }
    echo '</div></div>';
}
endif;

if ( ! function_exists( 'zc_breadcrumb' ) ) :
function zc_breadcrumb() {
    // Use WooCommerce breadcrumb if on WC page
    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        woocommerce_breadcrumb( [
            'wrap_before' => '<nav aria-label="breadcrumb"><ol class="breadcrumb zc-breadcrumb">',
            'wrap_after'  => '</ol></nav>',
            'before'      => '<li class="breadcrumb-item">',
            'after'       => '</li>',
            'delimiter'   => '',
        ] );
        return;
    }
    // Simple WP breadcrumb
    echo '<nav aria-label="breadcrumb"><ol class="breadcrumb zc-breadcrumb">';
    echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', ZC_TEXT ) . '</a></li>';
    if ( ! is_front_page() && ! is_home() ) {
        if ( is_singular() ) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
        } elseif ( is_category() || is_tag() || is_author() || is_archive() ) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html( get_the_archive_title() ) . '</li>';
        } elseif ( is_search() ) {
            echo '<li class="breadcrumb-item active" aria-current="page">'
                . sprintf( esc_html__( 'Search: %s', ZC_TEXT ), esc_html( get_search_query() ) ) . '</li>';
        } elseif ( is_404() ) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( '404', ZC_TEXT ) . '</li>';
        }
    }
    echo '</ol></nav>';
}
endif;

// ═══════════════════════════════════════════════════════════════════════════════
// BODY CLASSES
// ═══════════════════════════════════════════════════════════════════════════════
add_filter( 'body_class', function ( $classes ) {
    $classes[] = 'zc-theme';
    $classes[] = 'zc-scheme-' . zc_option( 'color_scheme', 'cosmic' );
    $classes[] = 'zc-mode-' . zc_option( 'color_mode', 'dark' );
    if ( zc_option( 'header_sticky' ) === '1' ) $classes[] = 'zc-sticky-header';
    if ( zc_option( 'show_left_panel' ) === '1' ) $classes[] = 'zc-has-left-panel';
    if ( zc_option( 'show_right_panel' ) === '1' ) $classes[] = 'zc-has-right-panel';
    if ( defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) && ZC_GENESIS_ADMIN_ACTIVE ) $classes[] = 'zc-genesis-active';
    return $classes;
} );

// ═══════════════════════════════════════════════════════════════════════════════
// TITLE TAG SUPPORT
// ═══════════════════════════════════════════════════════════════════════════════
add_filter( 'document_title_separator', function () { return '|'; } );

// ═══════════════════════════════════════════════════════════════════════════════
// EXCERPT LENGTH
// ═══════════════════════════════════════════════════════════════════════════════
add_filter( 'excerpt_length', function () {
    return (int) zc_option( 'excerpt_length', 30 );
} );
add_filter( 'excerpt_more', function () {
    return '&hellip; <a class="zc-read-more btn btn-sm btn-outline-primary" href="' . esc_url( get_permalink() ) . '">'
        . esc_html__( 'Read More', ZC_TEXT ) . '</a>';
} );

// ═══════════════════════════════════════════════════════════════════════════════
// COMMENTS PAGINATION
// ═══════════════════════════════════════════════════════════════════════════════
add_filter( 'previous_comments_link_attributes', function () {
    return 'class="btn btn-sm btn-outline-secondary"';
} );
add_filter( 'next_comments_link_attributes', function () {
    return 'class="btn btn-sm btn-outline-primary"';
} );

// ═══════════════════════════════════════════════════════════════════════════════
// IMAGE LAZY LOAD
// ═══════════════════════════════════════════════════════════════════════════════
add_filter( 'wp_lazy_loading_enabled', function ( $enabled ) {
    return ( zc_option( 'enable_lazy_load' ) === '1' ) ? true : $enabled;
} );

// ═══════════════════════════════════════════════════════════════════════════════
// COMPAT STUBS (BuddyPress / WooCommerce / bbPress safe calls)
// ═══════════════════════════════════════════════════════════════════════════════
if ( ! function_exists( 'bp_is_active' ) )         { function bp_is_active($c=''){ return false; } }
if ( ! function_exists( 'wc_get_cart_url' ) )      { function wc_get_cart_url(){ return ''; } }
if ( ! function_exists( 'wc_get_checkout_url' ) )  { function wc_get_checkout_url(){ return ''; } }
if ( ! function_exists( 'wc_get_account_endpoint_url' ) ) { function wc_get_account_endpoint_url($e=''){ return ''; } }
if ( ! function_exists( 'WC' ) )                   { function WC(){ return null; } }

<?php
/**
 * ZinCelestial v5.1.0 — Sidebar / Widget Area Registration
 *
 * Registers all widget areas for:
 *  - Standard WordPress sidebars (left, right)
 *  - BuddyPress sidebar
 *  - WooCommerce sidebar
 *  - bbPress sidebar
 *  - Footer columns (1–4)
 *  - Speciality panels (right panel, shop banner, leaderboard)
 *
 * v5.1.0 changes:
 *  - Bootstrap 5 wrapper classes (card, card-body) for all widgets
 *  - zc_register_sidebars() guarded with function_exists()
 *  - All sidebar IDs use zc- prefix (no conflicts)
 *  - Textdomain ZC_TEXT (constant, safe after init)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'zc_register_sidebars' ) ) :
function zc_register_sidebars() {
    $wrap_start  = '<div class="zc-widget card shadow-sm mb-4 %2$s" id="%1$s">';
    $wrap_end    = '</div>';
    $title_start = '<h5 class="zc-widget__title card-header fw-semibold">';
    $title_end   = '</h5><div class="card-body">';

    // Close both card-body and card
    $after_widget = '</div></div>';

    $areas = [
        /* ─ Primary sidebars ─────────────────────────────────────────── */
        [
            'id'          => 'zc-sidebar-right',
            'name'        => __( 'Right Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on posts, pages, and archives when the right-sidebar layout is active.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-sidebar-left',
            'name'        => __( 'Left Sidebar', ZC_TEXT ),
            'description' => __( 'Shown when the left-sidebar layout is active.', ZC_TEXT ),
        ],
        /* ─ BuddyPress ───────────────────────────────────────────────── */
        [
            'id'          => 'zc-sidebar-buddypress',
            'name'        => __( 'BuddyPress Sidebar', ZC_TEXT ),
            'description' => __( 'Appears on all BuddyPress member, group, and activity pages.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-bp-member-sidebar',
            'name'        => __( 'BP Member Profile Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on individual BuddyPress member profile pages.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-bp-group-sidebar',
            'name'        => __( 'BP Group Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on BuddyPress group pages.', ZC_TEXT ),
        ],
        /* ─ WooCommerce ─────────────────────────────────────────────── */
        [
            'id'          => 'zc-woo-sidebar',
            'name'        => __( 'WooCommerce Shop Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on the WooCommerce shop and product archive pages.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-woo-product-sidebar',
            'name'        => __( 'WooCommerce Product Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on single product pages.', ZC_TEXT ),
        ],
        /* ─ bbPress ──────────────────────────────────────────────────── */
        [
            'id'          => 'zc-bbpress-sidebar',
            'name'        => __( 'bbPress Forum Sidebar', ZC_TEXT ),
            'description' => __( 'Shown on bbPress forum, topic, and reply pages.', ZC_TEXT ),
        ],
        /* ─ Footer columns ───────────────────────────────────────────── */
        [
            'id'          => 'zc-footer-1',
            'name'        => __( 'Footer Column 1', ZC_TEXT ),
            'description' => __( 'First footer widget column.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-footer-2',
            'name'        => __( 'Footer Column 2', ZC_TEXT ),
            'description' => __( 'Second footer widget column.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-footer-3',
            'name'        => __( 'Footer Column 3', ZC_TEXT ),
            'description' => __( 'Third footer widget column.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-footer-4',
            'name'        => __( 'Footer Column 4', ZC_TEXT ),
            'description' => __( 'Fourth footer widget column.', ZC_TEXT ),
        ],
        /* ─ Speciality panels ────────────────────────────────────────── */
        [
            'id'          => 'zc-right-panel',
            'name'        => __( 'Right Panel', ZC_TEXT ),
            'description' => __( 'Sliding right panel — shown to logged-in users.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-shop-banner',
            'name'        => __( 'Shop Banner', ZC_TEXT ),
            'description' => __( 'Full-width banner above the WooCommerce shop grid.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-leaderboard',
            'name'        => __( 'Leaderboard Widget Area', ZC_TEXT ),
            'description' => __( 'GamiPress leaderboard widget area.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-header-widgets',
            'name'        => __( 'Header Widget Area', ZC_TEXT ),
            'description' => __( 'Widgets rendered inside the site header.', ZC_TEXT ),
        ],
        [
            'id'          => 'zc-404-widgets',
            'name'        => __( '404 Widget Area', ZC_TEXT ),
            'description' => __( 'Widgets shown on the 404 error page.', ZC_TEXT ),
        ],
    ];

    foreach ( $areas as $area ) {
        register_sidebar( array_merge( [
            'before_widget' => $wrap_start,
            'after_widget'  => $after_widget,
            'before_title'  => $title_start,
            'after_title'   => $title_end,
        ], $area ) );
    }
}
endif;

add_action( 'widgets_init', 'zc_register_sidebars', 10 );

/* ─── Sidebar display helpers ────────────────────────────────────────────── */

if ( ! function_exists( 'zc_get_sidebar_position' ) ) :
/**
 * Returns 'left', 'right', 'both', or 'none' for the current page context.
 * Checks page-level meta first, then theme option defaults.
 */
function zc_get_sidebar_position() {
    $default = zc_option( 'sidebar_position', 'right' );

    // Post meta override
    if ( is_singular() ) {
        $meta = get_post_meta( get_the_ID(), '_zc_sidebar_position', true );
        if ( $meta && in_array( $meta, [ 'left', 'right', 'both', 'none' ], true ) ) {
            return $meta;
        }
    }

    // BuddyPress pages
    if ( function_exists( 'buddypress' ) && ( is_buddypress() || bp_is_user() || bp_is_group() ) ) {
        return zc_option( 'bp_sidebar_position', 'right' );
    }

    // WooCommerce pages
    if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
        return zc_option( 'woo_sidebar_position', 'right' );
    }

    // bbPress pages
    if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
        return zc_option( 'bbp_sidebar_position', 'none' );
    }

    return $default;
}
endif;

if ( ! function_exists( 'zc_has_sidebar' ) ) :
/**
 * Returns true if there is at least one active sidebar widget area for the
 * current page context, and the layout calls for a sidebar.
 */
function zc_has_sidebar( $side = 'right' ) {
    $position = zc_get_sidebar_position();
    if ( $position === 'none' ) return false;
    if ( $position !== $side && $position !== 'both' ) return false;

    // Determine which sidebar ID to check
    if ( function_exists( 'buddypress' ) && ( is_buddypress() || ( function_exists( 'bp_is_user' ) && bp_is_user() ) ) ) {
        return is_active_sidebar( 'zc-sidebar-buddypress' );
    }
    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        return is_active_sidebar( 'zc-woo-sidebar' );
    }
    if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
        return is_active_sidebar( 'zc-bbpress-sidebar' );
    }
    $id = ( $side === 'left' ) ? 'zc-sidebar-left' : 'zc-sidebar-right';
    return is_active_sidebar( $id );
}
endif;

if ( ! function_exists( 'zc_grid_classes' ) ) :
/**
 * Returns Bootstrap column classes for main content and sidebar.
 *
 * @return array{ content: string, sidebar: string }
 */
function zc_grid_classes() {
    $pos  = zc_get_sidebar_position();
    $full = [ 'content' => 'col-12', 'sidebar' => '' ];

    switch ( $pos ) {
        case 'right':
            return [ 'content' => 'col-lg-8', 'sidebar' => 'col-lg-4' ];
        case 'left':
            return [ 'content' => 'col-lg-8 order-lg-2', 'sidebar' => 'col-lg-4 order-lg-1' ];
        case 'both':
            return [ 'content' => 'col-lg-6 order-lg-2', 'sidebar' => 'col-lg-3' ];
        default:
            return $full;
    }
}
endif;

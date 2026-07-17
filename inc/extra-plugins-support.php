<?php
/**
 * ZinCelestial v3.0 — Extra Plugin Support Hooks
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ─── ELEMENTOR ─────────────────────────────────────── */
add_action( 'elementor/theme/register_locations', function( $manager ) {
    $manager->register_all_core_location();
} );
add_action( 'elementor/widgets/register', function() {}, 10 );
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' ); // Use our fonts

// Elementor canvas: hide header/footer
add_action( 'wp', function() {
    if ( function_exists( '\Elementor\Plugin::$instance' ) ) {
        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) return;
        $template = get_page_template_slug();
        if ( $template === 'elementor_canvas' ) {
            add_filter( 'zc_show_header', '__return_false' );
            add_filter( 'zc_show_footer', '__return_false' );
        }
    }
} );

/* ─── DOKAN ─────────────────────────────────────────── */
add_filter( 'dokan_get_dashboard_settings_heading', function( $heading ) {
    return esc_html__( 'Vendor Dashboard', 'zincelestial' );
} );
add_action( 'dokan_dashboard_before_widgets', function() {
    // Add ZinCelestial design wrapper
    echo '<div class="zc-dokan-dashboard">';
} );
add_action( 'dokan_dashboard_after_widgets', function() {
    echo '</div>';
} );

/* ─── WCFM ──────────────────────────────────────────── */
add_filter( 'wcfm_store_style', function( $style ) {
    return ZC_ASSETS . 'css/dokan.css';
} );

/* ─── LEARNDASH ─────────────────────────────────────── */
add_filter( 'learndash_course_grid_html_classes', function( $classes ) {
    $classes[] = 'zc-learndash-grid';
    return $classes;
} );
add_action( 'learndash_course_grid_before_thumbnail', function() {
    echo '<div class="zc-course-card-thumb">';
} );
add_action( 'learndash_course_grid_after_thumbnail', function() {
    echo '</div>';
} );

/* ─── LIFTERLMS ─────────────────────────────────────── */
add_filter( 'llms_get_layout', function( $layout ) {
    return zc_option( 'layout_sidebar', 'right' ) === 'none' ? 'full-width' : $layout;
} );

/* ─── PEEPSO ─────────────────────────────────────────── */
add_filter( 'peepso_theme_name', function() {
    return 'ZinCelestial';
} );

/* ─── RTMEDIA ────────────────────────────────────────── */
add_filter( 'rtmedia_default_media_size', function( $size ) {
    return 'large';
} );

/* ─── AAM ────────────────────────────────────────────── */
// Ensure ZinCelestial content gate works with AAM
add_filter( 'aam_content_access_object', function( $object ) {
    return $object;
} );

/* ─── PMPRO ──────────────────────────────────────────── */
add_filter( 'pmpro_checkout_order_classes', function( $classes ) {
    $classes[] = 'zc-pmpro-checkout';
    return $classes;
} );
add_action( 'pmpro_checkout_preheader', function() {
    add_filter( 'zc_show_sidebar', '__return_false' );
} );

/* ─── UMP ────────────────────────────────────────────── */
add_action( 'ihc_custom_css', function() {
    // Override IHC default styles
    echo '.ihc_forms_wrapper { background: var(--zc-bg-card); border: 1px solid var(--zc-border); border-radius: var(--zc-radius-xl); }';
} );

/* ─── ADS PRO ────────────────────────────────────────── */
add_filter( 'adsp_ad_wrapper_class', function( $class ) {
    return $class . ' zc-ad-unit';
} );

/* ─── BETTER MESSAGES ────────────────────────────────── */
add_filter( 'bm_thread_list_classes', function( $classes ) {
    $classes[] = 'zc-bm-thread-list';
    return $classes;
} );

/* ─── BUDDYMEET ──────────────────────────────────────── */
add_filter( 'buddymeet_button_class', function( $class ) {
    return 'zc-btn zc-btn-sm zc-btn-outline';
} );

/* ─── YOUZIFY ────────────────────────────────────────── */
add_filter( 'youzify_profile_tabs_order', function( $tabs ) {
    return $tabs; // Preserve tab order, ZinCelestial handles styling
} );

/* ─── EDD ────────────────────────────────────────────── */
add_filter( 'edd_checkout_submit_class', function( $class ) {
    return $class . ' zc-btn zc-btn-primary zc-btn-lg';
} );

/* ─── JOB MANAGER ────────────────────────────────────── */
add_filter( 'job_manager_job_listing_data_fields', function( $fields ) {
    return $fields;
} );

/* ─── TUTOR LMS ──────────────────────────────────────── */
add_action( 'tutor_course/archive/before_container', function() {
    echo '<div class="zc-tutor-archive">';
} );
add_action( 'tutor_course/archive/after_container', function() {
    echo '</div>';
} );

/* ─── GENERIC: REMOVE PLUGIN INLINE CSS CONFLICTS ───── */
add_action( 'wp_print_styles', function() {
    $opts = get_option( 'zc_options', [] );
    if ( ! empty( $opts['wc_disable_styles'] ) && class_exists( 'WooCommerce' ) ) {
        wp_dequeue_style( 'woocommerce-general' );
        wp_dequeue_style( 'woocommerce-layout' );
        wp_dequeue_style( 'woocommerce-smallscreen' );
    }
}, 100 );

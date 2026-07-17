<?php
/**
 * ZinCelestial — RTMedia Integration Functions
 *
 * Bridges RTMedia (photos/video/audio) with ZinCelestial's
 * BuddyPress templates, reactions system, and admin controls.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. DETECT RTMEDIA
// ─────────────────────────────────────────────

function zc_rtmedia_active() {
    return class_exists( 'RTMedia' ) || function_exists( 'rtmedia_init' );
}

// ─────────────────────────────────────────────
// 2. ENQUEUE RTMEDIA COMPAT STYLES
// ─────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'zc_rtmedia_enqueue', 20 );
function zc_rtmedia_enqueue() {
    if ( ! zc_rtmedia_active() ) return;
    // Core RTMedia styles loaded by plugin; we layer our overrides
    wp_enqueue_style(
        'zc-rtmedia',
        get_template_directory_uri() . '/assets/css/rtmedia.css',
        [ 'rtmedia-front-css' ],
        ZC_VERSION
    );
}

// ─────────────────────────────────────────────
// 3. MEDIA COUNT BADGE ON PROFILE HEADER
// ─────────────────────────────────────────────

add_action( 'bp_profile_header_meta', 'zc_rtmedia_profile_media_count', 25 );
function zc_rtmedia_profile_media_count() {
    if ( ! zc_rtmedia_active() ) return;
    if ( ! zc_option( 'rtmedia_header_count', true ) ) return;
    if ( ! bp_is_user() ) return;

    $user_id      = bp_displayed_user_id();
    $media_count  = function_exists( 'RTMediaQuery' ) ? RTMediaQuery::instance()->media_count( $user_id ) : 0;
    if ( ! $media_count ) return;

    echo '<span class="zc-rtmedia-badge" title="' . esc_attr__( 'Media uploads', 'zincelestial' ) . '">'
         . '<span class="zc-icon" aria-hidden="true">📷</span>'
         . number_format_i18n( $media_count ) . ' ' . esc_html__( 'Media', 'zincelestial' )
         . '</span>';
}

// ─────────────────────────────────────────────
// 4. MEDIA LIGHTBOX — ZC WRAPPER
// ─────────────────────────────────────────────

/**
 * Wrap RTMedia galleries in a ZinCelestial lightbox-compatible container.
 */
add_filter( 'rtmedia_gallery_before_container', 'zc_rtmedia_gallery_wrapper_open' );
function zc_rtmedia_gallery_wrapper_open( $html ) {
    return '<div class="zc-rtmedia-gallery-wrap">' . $html;
}

add_filter( 'rtmedia_gallery_after_container', 'zc_rtmedia_gallery_wrapper_close' );
function zc_rtmedia_gallery_wrapper_close( $html ) {
    return $html . '</div>';
}

// ─────────────────────────────────────────────
// 5. REACTIONS ON MEDIA ITEMS
// ─────────────────────────────────────────────

/**
 * Inject ZinCelestial reactions bar below RTMedia single media view.
 */
add_action( 'rtmedia_after_single_media_content', 'zc_rtmedia_reactions_bar' );
function zc_rtmedia_reactions_bar() {
    if ( ! zc_option( 'reactions_on_media', true ) ) return;
    if ( ! function_exists( 'zc_render_reactions' ) ) return;

    global $rtmedia_media;
    if ( ! isset( $rtmedia_media->media_id ) ) return;

    $object_id   = (int) $rtmedia_media->media_id;
    $object_type = 'rtmedia';

    zc_render_reactions( $object_id, $object_type );
}

// ─────────────────────────────────────────────
// 6. ACTIVITY MEDIA THUMBNAIL IN ACTIVITY STREAM
// ─────────────────────────────────────────────

add_filter( 'bp_get_activity_content_body', 'zc_rtmedia_activity_thumb_wrap', 10, 1 );
function zc_rtmedia_activity_thumb_wrap( $content ) {
    if ( ! zc_rtmedia_active() ) return $content;
    // RTMedia injects its own thumbnails; wrap them for ZC styling
    $content = str_replace( 'class="rtmedia-list"', 'class="rtmedia-list zc-activity-media-list"', $content );
    return $content;
}

// ─────────────────────────────────────────────
// 7. ALLOWED MEDIA TYPES — ADMIN CONTROL
// ─────────────────────────────────────────────

add_filter( 'rtmedia_allowed_types', 'zc_rtmedia_allowed_types' );
function zc_rtmedia_allowed_types( $types ) {
    $enabled = zc_option( 'rtmedia_allowed_types', [ 'photo', 'video', 'audio', 'document' ] );
    if ( ! is_array( $enabled ) ) return $types;
    return array_intersect( $types, $enabled );
}

// ─────────────────────────────────────────────
// 8. MEDIA UPLOAD SIZE LIMIT — ADMIN CONTROL
// ─────────────────────────────────────────────

add_filter( 'rtmedia_upload_size', 'zc_rtmedia_upload_size' );
function zc_rtmedia_upload_size( $size ) {
    $admin_size = zc_option( 'rtmedia_upload_size_mb', 0 );
    return $admin_size > 0 ? (int) $admin_size * 1024 * 1024 : $size;
}

// ─────────────────────────────────────────────
// 9. SHORTCODE: [zc_user_media user_id="" count=""]
// ─────────────────────────────────────────────

add_shortcode( 'zc_user_media', 'zc_rtmedia_user_media_shortcode' );
function zc_rtmedia_user_media_shortcode( $atts ) {
    if ( ! zc_rtmedia_active() ) return '';
    $atts = shortcode_atts( [
        'user_id' => get_current_user_id(),
        'count'   => 9,
        'type'    => 'photo',
    ], $atts );

    ob_start();
    if ( function_exists( 'rtmedia_gallery' ) ) {
        echo '<div class="zc-rtmedia-shortcode">';
        rtmedia_gallery( [
            'context'      => 'profile',
            'context_id'   => (int) $atts['user_id'],
            'media_type'   => sanitize_key( $atts['type'] ),
            'per_page'     => (int) $atts['count'],
        ] );
        echo '</div>';
    }
    return ob_get_clean();
}

// ─────────────────────────────────────────────
// 10. PRIVACY — HIDE MEDIA FROM NON-FRIENDS
// ─────────────────────────────────────────────

add_filter( 'rtmedia_privacy', 'zc_rtmedia_privacy_control', 10, 2 );
function zc_rtmedia_privacy_control( $privacy, $media_id ) {
    if ( ! zc_option( 'rtmedia_friends_only', false ) ) return $privacy;
    if ( ! bp_is_active( 'friends' ) ) return $privacy;
    $media_user = get_post_field( 'post_author', $media_id );
    if ( ! $media_user || $media_user == get_current_user_id() ) return $privacy;
    if ( ! friends_check_friendship( get_current_user_id(), $media_user ) ) {
        return 40; // Friends only in RTMedia's privacy scale
    }
    return $privacy;
}

// ─────────────────────────────────────────────
// 11. MULTISITE MEDIA SYNC
// ─────────────────────────────────────────────

/**
 * When a media item is added, store a cross-site reference for multisite feeds.
 */
add_action( 'rtmedia_after_add_media', 'zc_rtmedia_multisite_sync', 10, 2 );
function zc_rtmedia_multisite_sync( $media_id, $media_data ) {
    if ( ! is_multisite() ) return;
    if ( ! zc_option( 'rtmedia_multisite_sync', false ) ) return;
    // Store a flag on the blog's options so network feeds can surface it
    $blog_id   = get_current_blog_id();
    $user_id   = $media_data['media_author'] ?? get_current_user_id();
    $event_key = 'zc_rtmedia_event_' . $blog_id . '_' . $media_id;
    update_user_meta( $user_id, $event_key, [
        'blog_id'    => $blog_id,
        'media_id'   => $media_id,
        'created_at' => time(),
    ] );
}

<?php
/**
 * ZinCelestial — System: Security & Safety (Stage 2, System 6)
 *
 * Frontend-facing security layer: content visibility rules,
 * member blocking/reporting UI, age-gate, spam detection hooks,
 * and GDPR/privacy controls surfaced to members.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. BLOCK / REPORT MEMBER
// ─────────────────────────────────────────────

/**
 * Add a "Block / Report" action link on member profile pages.
 */
add_action( 'bp_member_header_actions', 'zc_security_block_report_button', 30 );
function zc_security_block_report_button() {
    if ( ! is_user_logged_in() || bp_is_my_profile() ) return;
    if ( ! zc_option( 'security_block_enable', true ) ) return;
    $target = bp_displayed_user_id();
    $nonce  = wp_create_nonce( 'zc_block_member_' . $target );
    echo '<button class="zc-btn zc-btn-ghost zc-btn-block-report" data-user="' . esc_attr( $target ) . '" data-nonce="' . esc_attr( $nonce ) . '" aria-label="' . esc_attr__( 'Block or report this member', 'zincelestial' ) . '">';
    echo '<span class="zc-icon" aria-hidden="true">🚫</span> ' . esc_html__( 'Block / Report', 'zincelestial' );
    echo '</button>';
}

// ─────────────────────────────────────────────
// 2. AJAX — BLOCK MEMBER
// ─────────────────────────────────────────────

add_action( 'wp_ajax_zc_block_member', 'zc_ajax_block_member' );
function zc_ajax_block_member() {
    check_ajax_referer( 'zc_block_member_' . (int) $_POST['target_id'], 'nonce' );
    if ( ! is_user_logged_in() ) wp_send_json_error( 'Not logged in' );

    $blocker    = get_current_user_id();
    $blocked    = (int) $_POST['target_id'];
    $block_list = get_user_meta( $blocker, 'zc_blocked_users', true ) ?: [];

    if ( ! in_array( $blocked, $block_list, true ) ) {
        $block_list[] = $blocked;
        update_user_meta( $blocker, 'zc_blocked_users', array_map( 'intval', $block_list ) );
        do_action( 'zc_member_blocked', $blocker, $blocked );
    }
    wp_send_json_success( [ 'message' => __( 'Member blocked.', 'zincelestial' ) ] );
}

// ─────────────────────────────────────────────
// 3. AJAX — REPORT CONTENT
// ─────────────────────────────────────────────

add_action( 'wp_ajax_zc_report_content', 'zc_ajax_report_content' );
function zc_ajax_report_content() {
    check_ajax_referer( 'zc_report_content', 'nonce' );
    if ( ! is_user_logged_in() ) wp_send_json_error( 'Not logged in' );

    $reporter     = get_current_user_id();
    $object_id    = (int) $_POST['object_id'];
    $object_type  = sanitize_key( $_POST['object_type'] );
    $reason       = sanitize_text_field( $_POST['reason'] ?? '' );

    $report = [
        'reporter'    => $reporter,
        'object_id'   => $object_id,
        'object_type' => $object_type,
        'reason'      => $reason,
        'date'        => current_time( 'mysql' ),
        'status'      => 'pending',
    ];

    $existing = get_option( 'zc_content_reports', [] );
    $existing[] = $report;
    update_option( 'zc_content_reports', $existing, false );

    // Email admin
    if ( zc_option( 'security_report_email', true ) ) {
        $admin_email = get_option( 'admin_email' );
        $subject     = sprintf( __( '[%s] New content report', 'zincelestial' ), get_bloginfo( 'name' ) );
        $body        = sprintf( "Reporter: %d\nObject: %s #%d\nReason: %s\nDate: %s", $reporter, $object_type, $object_id, $reason, current_time( 'mysql' ) );
        wp_mail( $admin_email, $subject, $body );
    }

    wp_send_json_success( [ 'message' => __( 'Content reported. Thank you.', 'zincelestial' ) ] );
}

// ─────────────────────────────────────────────
// 4. HIDE CONTENT FROM BLOCKED USERS
// ─────────────────────────────────────────────

add_filter( 'bp_get_activity_content_body', 'zc_filter_blocked_activity', 10, 1 );
function zc_filter_blocked_activity( $content ) {
    if ( ! is_user_logged_in() ) return $content;
    global $activities_template;
    if ( empty( $activities_template->activity ) ) return $content;

    $viewer      = get_current_user_id();
    $block_list  = get_user_meta( $viewer, 'zc_blocked_users', true ) ?: [];
    $author      = (int) $activities_template->activity->user_id;

    if ( in_array( $author, $block_list, true ) ) {
        return '<em class="zc-blocked-content">' . esc_html__( 'Content from a blocked member.', 'zincelestial' ) . '</em>';
    }
    return $content;
}

// ─────────────────────────────────────────────
// 5. AGE GATE
// ─────────────────────────────────────────────

add_action( 'template_redirect', 'zc_age_gate_check' );
function zc_age_gate_check() {
    if ( ! zc_option( 'security_age_gate', false ) ) return;
    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) return;
    if ( isset( $_COOKIE['zc_age_verified'] ) ) return;

    $min_age = (int) zc_option( 'security_age_gate_min', 18 );
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' . esc_html__( 'Age Verification', 'zincelestial' ) . '</title>';
    echo '<link rel="stylesheet" href="' . esc_url( get_template_directory_uri() . '/assets/css/login.css' ) . '"></head><body>';
    echo '<div class="zc-age-gate"><div class="zc-age-gate__card">';
    echo '<h2>' . esc_html__( 'Age Verification', 'zincelestial' ) . '</h2>';
    echo '<p>' . sprintf( esc_html__( 'You must be %d or older to enter.', 'zincelestial' ), $min_age ) . '</p>';
    echo '<form method="post"><button name="zc_age_confirm" value="1" class="zc-btn zc-btn-primary">' . esc_html__( 'I confirm I am old enough', 'zincelestial' ) . '</button>';
    echo '<a href="https://google.com" class="zc-btn zc-btn-ghost">' . esc_html__( 'Exit', 'zincelestial' ) . '</a></form></div></div></body></html>';
    exit;
}

add_action( 'init', 'zc_age_gate_set_cookie' );
function zc_age_gate_set_cookie() {
    if ( isset( $_POST['zc_age_confirm'] ) && (int) $_POST['zc_age_confirm'] === 1 ) {
        setcookie( 'zc_age_verified', '1', time() + DAY_IN_SECONDS * 30, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
        wp_safe_redirect( wp_get_referer() ?: home_url() );
        exit;
    }
}

// ─────────────────────────────────────────────
// 6. SPAM DETECTION HOOKS
// ─────────────────────────────────────────────

/**
 * Rate-limit activity posts: max N posts per hour per user.
 */
add_action( 'bp_activity_before_save', 'zc_security_activity_rate_limit' );
function zc_security_activity_rate_limit( $activity ) {
    $max_per_hour = (int) zc_option( 'security_activity_rate_limit', 20 );
    if ( ! $max_per_hour ) return;

    $user_id   = get_current_user_id();
    $cache_key = 'zc_act_count_' . $user_id;
    $count     = (int) get_transient( $cache_key );

    if ( $count >= $max_per_hour ) {
        $activity->errors->add( 'rate_limit', __( 'You are posting too quickly. Please wait before posting again.', 'zincelestial' ) );
        return;
    }

    set_transient( $cache_key, $count + 1, HOUR_IN_SECONDS );
}

// ─────────────────────────────────────────────
// 7. GDPR — DATA EXPORT / DELETION HOOKS
// ─────────────────────────────────────────────

/**
 * Register ZinCelestial data with WP's privacy tools.
 */
add_filter( 'wp_privacy_personal_data_exporters', 'zc_register_privacy_exporter' );
function zc_register_privacy_exporter( $exporters ) {
    $exporters['zincelestial'] = [
        'exporter_friendly_name' => __( 'ZinCelestial Theme Data', 'zincelestial' ),
        'callback'               => 'zc_privacy_export_data',
    ];
    return $exporters;
}

function zc_privacy_export_data( $email, $page = 1 ) {
    $user       = get_user_by( 'email', $email );
    $export_items = [];
    if ( $user ) {
        $blocked = get_user_meta( $user->ID, 'zc_blocked_users', true ) ?: [];
        $export_items[] = [
            'group_id'    => 'zincelestial',
            'group_label' => __( 'ZinCelestial Data', 'zincelestial' ),
            'item_id'     => 'blocked-users',
            'data'        => [ [ 'name' => __( 'Blocked Users', 'zincelestial' ), 'value' => implode( ', ', $blocked ) ] ],
        ];
    }
    return [ 'data' => $export_items, 'done' => true ];
}

add_filter( 'wp_privacy_personal_data_erasers', 'zc_register_privacy_eraser' );
function zc_register_privacy_eraser( $erasers ) {
    $erasers['zincelestial'] = [
        'eraser_friendly_name' => __( 'ZinCelestial Theme Data', 'zincelestial' ),
        'callback'             => 'zc_privacy_erase_data',
    ];
    return $erasers;
}

function zc_privacy_erase_data( $email, $page = 1 ) {
    $user = get_user_by( 'email', $email );
    $removed = false;
    if ( $user ) {
        delete_user_meta( $user->ID, 'zc_blocked_users' );
        delete_user_meta( $user->ID, 'zincelestial_color_mode' );
        $removed = true;
    }
    return [ 'items_removed' => $removed, 'items_retained' => false, 'messages' => [], 'done' => true ];
}

// ─────────────────────────────────────────────
// 8. SCRIPT NONCES IN LOCALIZED DATA
// ─────────────────────────────────────────────

add_filter( 'zc_localized_data', 'zc_security_add_nonces' );
function zc_security_add_nonces( $data ) {
    $data['nonces']['block_member']   = wp_create_nonce( 'zc_block_member_' . get_current_user_id() );
    $data['nonces']['report_content'] = wp_create_nonce( 'zc_report_content' );
    return $data;
}

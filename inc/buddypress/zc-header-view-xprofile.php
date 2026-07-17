<?php
/**
 * ZinCelestial — XProfile Header View
 *
 * Renders BuddyPress xProfile fields in the member header area,
 * including tagline, location, social proof badges, and custom fields.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. HEADER XPROFILE FIELD RENDERER
// ─────────────────────────────────────────────

/**
 * Display selected xProfile fields in the member profile header.
 * Hooked to bp_profile_header_meta via bp-hooks.php.
 */
function zc_render_header_xprofile_fields() {
    if ( ! bp_is_active( 'xprofile' ) ) return;
    if ( ! zc_option( 'xprofile_header_enable', true ) ) return;

    $user_id          = bp_displayed_user_id();
    $show_tagline     = zc_option( 'xprofile_header_tagline', true );
    $show_location    = zc_option( 'xprofile_header_location', true );
    $show_occupation  = zc_option( 'xprofile_header_occupation', true );
    $tagline_field    = zc_option( 'xprofile_tagline_field', 'Tagline' );
    $location_field   = zc_option( 'xprofile_location_field', 'Location' );
    $occupation_field = zc_option( 'xprofile_occupation_field', 'Occupation' );

    $tagline    = $show_tagline    ? zc_get_xprofile_field( $user_id, $tagline_field )    : '';
    $location   = $show_location   ? zc_get_xprofile_field( $user_id, $location_field )   : '';
    $occupation = $show_occupation ? zc_get_xprofile_field( $user_id, $occupation_field ) : '';

    if ( ! $tagline && ! $location && ! $occupation ) return;

    echo '<div class="zc-member-xprofile-header">';

    if ( $tagline ) {
        echo '<p class="zc-member-tagline">' . wp_kses_post( $tagline ) . '</p>';
    }

    echo '<div class="zc-member-meta-row">';
    if ( $occupation ) {
        echo '<span class="zc-meta-item zc-meta-occupation"><span class="zc-icon" aria-hidden="true">💼</span>'
             . esc_html( $occupation ) . '</span>';
    }
    if ( $location ) {
        echo '<span class="zc-meta-item zc-meta-location"><span class="zc-icon" aria-hidden="true">📍</span>'
             . esc_html( $location ) . '</span>';
    }
    echo '</div>';

    // Additional custom xProfile fields chosen in admin
    $extra_fields = zc_option( 'xprofile_header_extra_fields', [] );
    if ( ! empty( $extra_fields ) && is_array( $extra_fields ) ) {
        echo '<div class="zc-member-extra-fields">';
        foreach ( $extra_fields as $field_name ) {
            $val = zc_get_xprofile_field( $user_id, $field_name );
            if ( $val ) {
                echo '<span class="zc-extra-field"><strong>' . esc_html( $field_name ) . ':</strong> '
                     . wp_kses_post( $val ) . '</span>';
            }
        }
        echo '</div>';
    }

    echo '</div><!-- .zc-member-xprofile-header -->';
}
add_action( 'bp_profile_header_meta', 'zc_render_header_xprofile_fields', 10 );

// ─────────────────────────────────────────────
// 2. HELPER: GET XPROFILE FIELD VALUE
// ─────────────────────────────────────────────

/**
 * Retrieve a single xProfile field value for a user.
 *
 * @param int    $user_id    User ID.
 * @param string $field_name Field name.
 * @return string Field value or empty string.
 */
function zc_get_xprofile_field( $user_id, $field_name ) {
    if ( ! function_exists( 'xprofile_get_field_data' ) ) return '';
    $value = xprofile_get_field_data( $field_name, $user_id );
    if ( is_array( $value ) ) {
        $value = implode( ', ', $value );
    }
    return wp_strip_all_tags( (string) $value );
}

// ─────────────────────────────────────────────
// 3. MEMBER CARD XPROFILE PREVIEW
// ─────────────────────────────────────────────

/**
 * Show tagline snippet in member directory cards.
 */
add_action( 'bp_directory_members_item', 'zc_member_card_tagline', 15 );
function zc_member_card_tagline() {
    if ( ! zc_option( 'xprofile_card_tagline', true ) ) return;
    $user_id      = bp_get_member_user_id();
    $tagline_field = zc_option( 'xprofile_tagline_field', 'Tagline' );
    $tagline       = zc_get_xprofile_field( $user_id, $tagline_field );
    if ( $tagline ) {
        echo '<p class="zc-card-tagline">' . esc_html( wp_trim_words( $tagline, 12, '…' ) ) . '</p>';
    }
}

// ─────────────────────────────────────────────
// 4. XPROFILE HEADER FIELDS — ADMIN AJAX SAVE
// ─────────────────────────────────────────────

/**
 * Return available xProfile field names for admin settings dropdowns.
 */
add_action( 'wp_ajax_zc_get_xprofile_fields', 'zc_ajax_get_xprofile_fields' );
function zc_ajax_get_xprofile_fields() {
    check_ajax_referer( 'zincelestial_admin', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );
    if ( ! function_exists( 'bp_xprofile_get_groups' ) ) wp_send_json_success( [] );

    $groups = bp_xprofile_get_groups( [ 'fetch_fields' => true ] );
    $fields = [];
    foreach ( $groups as $group ) {
        foreach ( $group->fields as $field ) {
            $fields[] = [ 'id' => $field->id, 'name' => $field->name ];
        }
    }
    wp_send_json_success( $fields );
}

// ─────────────────────────────────────────────
// 5. SCHEMA / STRUCTURED DATA FROM XPROFILE
// ─────────────────────────────────────────────

/**
 * Output JSON-LD Person schema using xProfile data on member profiles.
 */
add_action( 'wp_head', 'zc_member_schema_from_xprofile' );
function zc_member_schema_from_xprofile() {
    if ( ! bp_is_user() ) return;
    if ( ! zc_option( 'xprofile_schema_enable', false ) ) return;

    $user_id  = bp_displayed_user_id();
    $user     = get_userdata( $user_id );
    $name     = bp_get_displayed_user_fullname();
    $avatar   = bp_get_profile_avatar( [ 'item_id' => $user_id, 'html' => false ] );
    $url      = bp_displayed_user_domain();
    $location = zc_get_xprofile_field( $user_id, zc_option( 'xprofile_location_field', 'Location' ) );
    $job      = zc_get_xprofile_field( $user_id, zc_option( 'xprofile_occupation_field', 'Occupation' ) );

    $schema = [ '@context' => 'https://schema.org', '@type' => 'Person', 'name' => $name, 'url' => $url ];
    if ( $avatar )   $schema['image']       = $avatar;
    if ( $location ) $schema['homeLocation'] = [ '@type' => 'Place', 'name' => $location ];
    if ( $job )      $schema['jobTitle']     = $job;

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '<\/script>' . "\n";
}

<?php
/**
 * ZinCelestial — Social Links via XProfile
 *
 * Reads social link URLs from xProfile fields and renders
 * styled icon links on member headers, cards, and sidebar widgets.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. SOCIAL NETWORK DEFINITIONS
// ─────────────────────────────────────────────

/**
 * Map of social networks → xProfile field names + icons.
 * Admin can override field names in ZinCelestial → BuddyPress settings.
 *
 * @return array
 */
function zc_social_networks() {
    return apply_filters( 'zc_social_networks', [
        'twitter'   => [ 'label' => 'Twitter / X',  'icon' => '𝕏',  'field' => zc_option( 'social_field_twitter',   'Twitter' ),   'class' => 'zc-social-twitter'   ],
        'facebook'  => [ 'label' => 'Facebook',     'icon' => 'fb', 'field' => zc_option( 'social_field_facebook',  'Facebook' ),  'class' => 'zc-social-facebook'  ],
        'instagram' => [ 'label' => 'Instagram',    'icon' => '📷', 'field' => zc_option( 'social_field_instagram', 'Instagram' ), 'class' => 'zc-social-instagram' ],
        'linkedin'  => [ 'label' => 'LinkedIn',     'icon' => 'in', 'field' => zc_option( 'social_field_linkedin',  'LinkedIn' ),  'class' => 'zc-social-linkedin'  ],
        'youtube'   => [ 'label' => 'YouTube',      'icon' => '▶',  'field' => zc_option( 'social_field_youtube',   'YouTube' ),   'class' => 'zc-social-youtube'   ],
        'tiktok'    => [ 'label' => 'TikTok',       'icon' => '♪',  'field' => zc_option( 'social_field_tiktok',    'TikTok' ),    'class' => 'zc-social-tiktok'    ],
        'github'    => [ 'label' => 'GitHub',       'icon' => '⌥',  'field' => zc_option( 'social_field_github',    'GitHub' ),    'class' => 'zc-social-github'    ],
        'website'   => [ 'label' => 'Website',      'icon' => '🌐', 'field' => zc_option( 'social_field_website',   'Website' ),   'class' => 'zc-social-website'   ],
        'discord'   => [ 'label' => 'Discord',      'icon' => '💬', 'field' => zc_option( 'social_field_discord',   'Discord' ),   'class' => 'zc-social-discord'   ],
        'twitch'    => [ 'label' => 'Twitch',       'icon' => '🎮', 'field' => zc_option( 'social_field_twitch',    'Twitch' ),    'class' => 'zc-social-twitch'    ],
    ] );
}

// ─────────────────────────────────────────────
// 2. RENDER SOCIAL LINKS — MEMBER HEADER
// ─────────────────────────────────────────────

add_action( 'bp_profile_header_meta', 'zc_render_social_links_header', 20 );
function zc_render_social_links_header() {
    if ( ! zc_option( 'social_links_header', true ) ) return;
    $user_id = bp_displayed_user_id();
    zc_output_social_links( $user_id, 'header' );
}

// ─────────────────────────────────────────────
// 3. RENDER SOCIAL LINKS — MEMBER DIRECTORY CARD
// ─────────────────────────────────────────────

add_action( 'bp_directory_members_item', 'zc_render_social_links_card', 20 );
function zc_render_social_links_card() {
    if ( ! zc_option( 'social_links_cards', false ) ) return;
    $user_id = bp_get_member_user_id();
    zc_output_social_links( $user_id, 'card' );
}

// ─────────────────────────────────────────────
// 4. CORE OUTPUT FUNCTION
// ─────────────────────────────────────────────

/**
 * Build and echo the social links HTML block.
 *
 * @param int    $user_id WP user ID.
 * @param string $context 'header' | 'card' | 'sidebar'.
 */
function zc_output_social_links( $user_id, $context = 'header' ) {
    if ( ! function_exists( 'xprofile_get_field_data' ) ) return;

    $networks     = zc_social_networks();
    $shown_max    = ( $context === 'card' ) ? (int) zc_option( 'social_links_card_max', 4 ) : 0;
    $links_html   = '';
    $count        = 0;

    foreach ( $networks as $key => $net ) {
        if ( empty( $net['field'] ) ) continue;
        $url = xprofile_get_field_data( $net['field'], $user_id );
        if ( empty( $url ) ) continue;

        // Ensure URL is absolute
        if ( ! preg_match( '#^https?://#i', $url ) ) {
            $url = 'https://' . ltrim( $url, '/' );
        }
        if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) continue;

        $count++;
        if ( $shown_max && $count > $shown_max ) break;

        $links_html .= sprintf(
            '<a href="%s" class="zc-social-link %s" title="%s" target="_blank" rel="noopener noreferrer me" aria-label="%s"><span class="zc-social-icon" aria-hidden="true">%s</span></a>',
            esc_url( $url ),
            esc_attr( $net['class'] ),
            esc_attr( $net['label'] ),
            esc_attr( $net['label'] ),
            esc_html( $net['icon'] )
        );
    }

    if ( ! $links_html ) return;

    $modifier = $context ? ' zc-social-links--' . sanitize_html_class( $context ) : '';
    echo '<div class="zc-social-links' . $modifier . '" role="list">' . $links_html . '</div>';
}

// ─────────────────────────────────────────────
// 5. WIDGET: SOCIAL LINKS SIDEBAR
// ─────────────────────────────────────────────

class ZC_Social_Links_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'zc_social_links',
            __( 'ZinCelestial — Member Social Links', 'zincelestial' ),
            [ 'description' => __( 'Shows BuddyPress member social links on profile pages.', 'zincelestial' ) ]
        );
    }

    public function widget( $args, $instance ) {
        if ( ! bp_is_user() ) return;
        $title   = apply_filters( 'widget_title', $instance['title'] ?? '' );
        $user_id = bp_displayed_user_id();

        echo $args['before_widget'];
        if ( $title ) echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        zc_output_social_links( $user_id, 'sidebar' );
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = $instance['title'] ?? __( 'Connect', 'zincelestial' );
        echo '<p><label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'zincelestial' ) . '</label>';
        echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '"></p>';
    }

    public function update( $new, $old ) {
        return [ 'title' => sanitize_text_field( $new['title'] ?? '' ) ];
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'ZC_Social_Links_Widget' );
} );

// ─────────────────────────────────────────────
// 6. SHORTCODE: [zc_social_links user_id=""]
// ─────────────────────────────────────────────

add_shortcode( 'zc_social_links', 'zc_social_links_shortcode' );
function zc_social_links_shortcode( $atts ) {
    $atts    = shortcode_atts( [ 'user_id' => get_current_user_id(), 'context' => 'inline' ], $atts );
    $user_id = (int) $atts['user_id'];
    ob_start();
    zc_output_social_links( $user_id, sanitize_key( $atts['context'] ) );
    return ob_get_clean();
}

// ─────────────────────────────────────────────
// 7. REST API ENDPOINT — GET SOCIAL LINKS
// ─────────────────────────────────────────────

add_action( 'rest_api_init', function() {
    register_rest_route( 'zincelestial/v1', '/social-links/(?P<user_id>\d+)', [
        'methods'             => 'GET',
        'callback'            => 'zc_rest_social_links',
        'permission_callback' => '__return_true',
        'args'                => [ 'user_id' => [ 'type' => 'integer', 'required' => true ] ],
    ] );
} );

function zc_rest_social_links( WP_REST_Request $request ) {
    if ( ! function_exists( 'xprofile_get_field_data' ) ) return new WP_Error( 'no_bp', 'BuddyPress not active', [ 'status' => 500 ] );
    $user_id  = (int) $request['user_id'];
    $networks = zc_social_networks();
    $data     = [];
    foreach ( $networks as $key => $net ) {
        $url = xprofile_get_field_data( $net['field'], $user_id );
        if ( $url ) $data[ $key ] = esc_url_raw( $url );
    }
    return rest_ensure_response( $data );
}

<?php
/**
 * ZinCelestial v3.0 — BuddyPress Member Customization
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_BP_Member_Customization {

    public function __construct() {
        // Member profile extras
        add_action( 'bp_before_member_header_meta', [ $this, 'member_rank_badge' ] );
        add_action( 'bp_before_member_header_meta', [ $this, 'member_verified_badge' ] );
        add_action( 'bp_after_member_header_meta',  [ $this, 'member_stats_bar' ] );
        add_filter( 'bp_core_get_user_displayname',  [ $this, 'append_verified_to_name' ], 10, 2 );

        // Member card extras
        add_action( 'bp_directory_members_item',    [ $this, 'member_card_badges' ] );
        add_action( 'bp_directory_members_item',    [ $this, 'member_card_rank' ] );

        // Friends button customization
        add_filter( 'bp_get_add_friend_button',     [ $this, 'custom_friend_button' ] );

        // Follow button
        add_action( 'bp_member_header_actions',     [ $this, 'follow_button' ] );

        // Video call button (BuddyMeet)
        add_action( 'bp_member_header_actions',     [ $this, 'video_call_button' ] );

        // Member avatar overlay (online status)
        add_action( 'bp_before_member_header_avatar', [ $this, 'cover_upload_button' ] );
        add_filter( 'bp_core_fetch_avatar',           [ $this, 'add_online_dot' ], 10, 2 );

        // XProfile extras
        add_action( 'bp_profile_field_items',       [ $this, 'social_links_row' ] );

        // Member loop extras
        add_filter( 'bp_get_member_excerpt',        [ $this, 'enhance_excerpt' ] );
    }

    public function member_rank_badge() {
        if ( ! class_exists( 'GamiPress' ) ) return;
        if ( ! zc_option( 'gp_rank_profile', 1 ) ) return;
        $user_id = bp_displayed_user_id();
        $ranks   = gamipress_get_user_ranks( $user_id );
        if ( empty( $ranks ) ) return;
        $rank = reset( $ranks );
        echo '<div class="zc-profile-rank-badge"><span class="zc-rank-icon">⭐</span>'
            . '<span class="zc-rank-name">' . esc_html( $rank->post_title ) . '</span></div>';
    }

    public function member_verified_badge() {
        $user_id = bp_displayed_user_id();
        if ( zc_is_verified( $user_id ) ) {
            echo '<span class="zc-verified-badge zc-verified-profile" title="' . esc_attr__( 'Verified Member', 'zincelestial' ) . '">✓ ' . esc_html__( 'Verified', 'zincelestial' ) . '</span>';
        }
    }

    public function member_stats_bar() {
        $user_id = bp_displayed_user_id();
        ?>
        <div class="zc-profile-stats-bar">
            <?php if ( function_exists( 'bp_get_total_friend_count' ) ) : ?>
            <div class="zc-profile-stat">
                <span class="zc-stat-number"><?php echo esc_html( zc_format_count( bp_get_total_friend_count( $user_id ) ) ); ?></span>
                <span class="zc-stat-label"><?php esc_html_e( 'Friends', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( function_exists( 'bp_activity_get_user_activity_count' ) ) : ?>
            <div class="zc-profile-stat">
                <span class="zc-stat-number"><?php echo esc_html( zc_format_count( bp_get_total_status_updates_for_user( $user_id ) ) ); ?></span>
                <span class="zc-stat-label"><?php esc_html_e( 'Posts', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( function_exists( 'bp_groups_total_groups_for_user' ) ) : ?>
            <div class="zc-profile-stat">
                <span class="zc-stat-number"><?php echo esc_html( zc_format_count( bp_groups_total_groups_for_user( $user_id ) ) ); ?></span>
                <span class="zc-stat-label"><?php esc_html_e( 'Groups', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( class_exists( 'GamiPress' ) && zc_option( 'gp_profile_totals', 1 ) ) :
                $points = gamipress_get_user_points( $user_id );
            ?>
            <div class="zc-profile-stat">
                <span class="zc-stat-number"><?php echo esc_html( zc_format_count( $points ) ); ?></span>
                <span class="zc-stat-label"><?php esc_html_e( 'Points', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function append_verified_to_name( $display_name, $user_id ) {
        if ( zc_is_verified( $user_id ) ) {
            return $display_name . ' <span class="zc-verified-badge-inline">✓</span>';
        }
        return $display_name;
    }

    public function member_card_badges() {
        $user_id = bp_get_member_user_id();
        if ( ! class_exists( 'GamiPress' ) || ! zc_option( 'gp_badges_member_card', 1 ) ) return;
        $badges = gamipress_get_user_achievements( [
            'user_id'          => $user_id,
            'achievement_type' => 'badge',
            'limit'            => zc_option( 'gp_badges_card_max', 3 ),
        ] );
        if ( empty( $badges ) ) return;
        echo '<div class="zc-member-card-badges">';
        foreach ( $badges as $badge ) {
            $img = get_the_post_thumbnail_url( $badge->ID, 'thumbnail' );
            $size_class = 'zc-badge-' . zc_option( 'gp_badge_size', 'md' );
            echo '<img src="' . esc_url( $img ?: '' ) . '" class="zc-badge-img ' . esc_attr( $size_class ) . '" title="' . esc_attr( get_the_title( $badge->ID ) ) . '" loading="lazy">';
        }
        echo '</div>';
    }

    public function member_card_rank() {
        if ( ! class_exists( 'GamiPress' ) || ! zc_option( 'gp_rank_member_card', 1 ) ) return;
        $user_id = bp_get_member_user_id();
        $ranks   = gamipress_get_user_ranks( $user_id );
        if ( empty( $ranks ) ) return;
        $rank = reset( $ranks );
        echo '<div class="zc-member-card-rank">' . esc_html( $rank->post_title ) . '</div>';
    }

    public function custom_friend_button( $button ) {
        if ( isset( $button['wrapper_class'] ) ) {
            $button['wrapper_class'] .= ' zc-friend-btn-wrap';
        }
        if ( isset( $button['link_class'] ) ) {
            $button['link_class'] = 'zc-btn zc-btn-sm zc-btn-outline ' . $button['link_class'];
        }
        return $button;
    }

    public function follow_button() {
        if ( bp_is_my_profile() ) return;
        $user_id   = bp_displayed_user_id();
        $following = get_user_meta( get_current_user_id(), '_zc_following', true ) ?: [];
        $is_following = in_array( $user_id, (array) $following );
        $class = $is_following ? 'zc-btn zc-btn-sm zc-btn-secondary zc-unfollow' : 'zc-btn zc-btn-sm zc-btn-primary zc-follow';
        echo '<button type="button" class="' . esc_attr( $class ) . '" data-user="' . esc_attr( $user_id ) . '">'
            . ( $is_following ? esc_html__( 'Following', 'zincelestial' ) : esc_html__( 'Follow', 'zincelestial' ) )
            . '</button>';
    }

    public function video_call_button() {
        if ( ! class_exists( 'BuddyMeet' ) || ! zc_option( 'meet_profile_btn', 1 ) ) return;
        if ( bp_is_my_profile() ) return;
        $user_id = bp_displayed_user_id();
        echo '<a href="' . esc_url( bp_core_get_user_domain( $user_id ) . 'buddymeet/' ) . '" class="zc-btn zc-btn-sm zc-btn-ghost" data-tip="' . esc_attr__( 'Video Call', 'zincelestial' ) . '">📹</a>';
    }

    public function cover_upload_button() {
        if ( ! bp_is_my_profile() ) return;
        if ( ! function_exists( 'bp_displayed_user_id' ) ) return;
        echo '<div class="zc-cover-upload-btn"><label for="bp-cover-image-file" class="zc-btn zc-btn-xs zc-btn-glass">📷 ' . esc_html__( 'Change Cover', 'zincelestial' ) . '</label></div>';
    }

    public function add_online_dot( $html, $params ) {
        // Add online indicator if user was recently active
        if ( ! is_array( $params ) || empty( $params['item_id'] ) ) return $html;
        $user_id = $params['item_id'];
        $last_activity = bp_get_user_last_activity( $user_id );
        if ( $last_activity ) {
            $minutes = floor( ( time() - strtotime( $last_activity ) ) / 60 );
            if ( $minutes < 15 ) {
                $html = '<div class="zc-avatar-wrap">' . $html . '<span class="zc-online-dot"></span></div>';
            }
        }
        return $html;
    }

    public function social_links_row() {
        $user_id = bp_displayed_user_id();
        $networks = [ 'twitter', 'facebook', 'linkedin', 'instagram', 'github', 'youtube', 'website' ];
        $links    = [];
        foreach ( $networks as $net ) {
            $val = get_user_meta( $user_id, '_zc_social_' . $net, true );
            if ( $val ) {
                $links[ $net ] = esc_url( $val );
            }
        }
        if ( empty( $links ) ) return;
        echo '<div class="zc-xprofile-social-links">';
        foreach ( $links as $net => $url ) {
            echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" class="zc-social-link zc-social-' . esc_attr( $net ) . '" data-tip="' . esc_attr( ucfirst( $net ) ) . '"></a>';
        }
        echo '</div>';
    }

    public function enhance_excerpt( $excerpt ) {
        return $excerpt; // Can be filtered further
    }
}

new ZC_BP_Member_Customization();

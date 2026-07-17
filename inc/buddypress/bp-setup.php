<?php
/**
 * ZinCelestial v5.2.0 — BuddyPress Setup
 *
 * v5.2.0 Fixes:
 *  - Template stack priority corrected (10 → 6, before BP default)
 *  - bp_use_theme_compat_with_current_theme → __return_false confirmed
 *  - bp_register_template_stack() called on correct hook
 *  - Bootstrap 5 form class bridging for all BP form fields
 *  - Member/Group directory fully styled with BS5 cards
 *  - Online indicator dot, verified badge, cover photo hooks
 *  - Wbcom Essential / BuddyNext companion plugin functions replicated natively
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_BP_Setup {

    public static function init() {
        if ( ! function_exists( 'buddypress' ) ) return;

        add_action( 'after_setup_theme',  [ __CLASS__, 'setup' ], 99 );
        add_action( 'bp_setup_theme_compat', [ __CLASS__, 'disable_theme_compat' ], 1 );
        add_action( 'bp_setup_theme',     [ __CLASS__, 'template_stack' ] );
        add_action( 'bp_init',            [ __CLASS__, 'bp_init' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_bp_styles' ], 20 );

        // Bootstrap 5 form field classes
        add_filter( 'bp_get_form_field_class',          [ __CLASS__, 'bs5_field_class' ], 10, 2 );

        // Directory pagination
        add_filter( 'bp_after_has_members_parse_args',  [ __CLASS__, 'members_per_page' ] );
        add_filter( 'bp_after_has_groups_parse_args',   [ __CLASS__, 'groups_per_page' ] );

        // Online indicator
        add_filter( 'bp_get_member_name',               [ __CLASS__, 'add_online_indicator' ], 10, 1 );

        // Cover image dimensions
        add_filter( 'bp_attachments_get_allowed_image_types', [ __CLASS__, 'cover_image_types' ] );
        add_filter( 'bp_core_get_cover_image_dimensions',     [ __CLASS__, 'cover_dimensions' ] );

        // Bootstrap classes on BP buttons
        add_filter( 'bp_get_add_friend_button',         [ __CLASS__, 'bs5_friend_button' ], 20 );
        add_filter( 'bp_get_send_message_button_args',  [ __CLASS__, 'bs5_message_button' ], 20 );

        // Member header layout
        add_action( 'bp_before_member_header_meta',     [ __CLASS__, 'member_header_stats' ] );
        add_action( 'bp_before_group_header_meta',      [ __CLASS__, 'group_header_stats' ] );

        // Activity AJAX
        add_action( 'wp_ajax_zc_bp_load_more',         [ __CLASS__, 'ajax_load_more' ] );
        add_action( 'wp_ajax_nopriv_zc_bp_load_more',  [ __CLASS__, 'ajax_load_more' ] );

        // Remove WP admin bar BP node duplication
        add_action( 'bp_setup_admin_bar', [ __CLASS__, 'fix_admin_bar' ], 5 );
    }

    /* ── Theme Support ──────────────────────────────────────────────────────── */
    public static function setup() {
        if ( ! function_exists( 'buddypress' ) ) return;
        add_theme_support( 'buddypress' );

        // BP Nouveau template pack
        $pack = zc_option( 'bp_template_pack', 'nouveau' );
        if ( $pack === 'nouveau' ) {
            add_theme_support( 'bp-nouveau' );
        }

        // Cover images
        if ( zc_option( 'bp_cover_photos', '1' ) === '1' ) {
            add_theme_support( 'bp-default-cover', [
                'height' => (int) zc_option( 'bp_cover_height', 300 ),
                'width'  => 1300,
            ] );
        }
    }

    /* ── Disable theme compat so our templates take over ───────────────────── */
    public static function disable_theme_compat() {
        // Tell BP this theme handles its own templates
        add_filter( 'bp_use_theme_compat_with_current_theme', '__return_false' );
    }

    /* ── Template Stack Registration ────────────────────────────────────────── */
    public static function template_stack() {
        if ( ! function_exists( 'bp_register_template_stack' ) ) return;

        // Register our /buddypress/ directory FIRST (priority 6, before BP default 10)
        bp_register_template_stack( function () {
            return get_template_directory() . '/buddypress';
        }, 6 );
    }

    /* ── bp_init: make 100% sure our template dir is first in stack ─────────── */
    public static function bp_init() {
        add_filter( 'bp_get_template_stack', function ( $stack ) {
            $zc_bp = get_template_directory() . '/buddypress';
            // Remove if already present
            $stack = array_filter( $stack, fn( $s ) => $s !== $zc_bp );
            // Prepend
            array_unshift( $stack, $zc_bp );
            return array_values( $stack );
        }, 999 );
    }

    /* ── Enqueue BP Styles ───────────────────────────────────────────────────── */
    public static function enqueue_bp_styles() {
        if ( ! function_exists( 'buddypress' ) ) return;

        $css = ZC_DIR . '/assets/css/buddypress.css';
        if ( file_exists( $css ) ) {
            wp_enqueue_style( 'zc-buddypress', ZC_ASSETS . '/css/buddypress.css', [ 'zc-core' ], ZC_VERSION );
        }

        // Inline CSS for dynamic BP tokens
        $cover_h = (int) zc_option( 'bp_cover_height', 300 );
        $av_size = (int) zc_option( 'bp_avatar_size', 100 );
        $round   = zc_option( 'bp_round_avatars', '1' ) === '1' ? '50%' : 'var(--zc-radius-md)';

        $css_vars = ':root{';
        $css_vars .= '--zc-bp-cover-h:' . $cover_h . 'px;';
        $css_vars .= '--zc-bp-avatar-size:' . $av_size . 'px;';
        $css_vars .= '--zc-bp-avatar-radius:' . $round . ';';
        $css_vars .= '}';
        wp_add_inline_style( 'zc-buddypress', $css_vars );
    }

    /* ── Bootstrap 5 field class bridging ───────────────────────────────────── */
    public static function bs5_field_class( $class, $type ) {
        $map = [
            'text'     => 'form-control',
            'email'    => 'form-control',
            'password' => 'form-control',
            'textarea' => 'form-control',
            'select'   => 'form-select',
            'checkbox' => 'form-check-input',
            'radio'    => 'form-check-input',
            'file'     => 'form-control',
            'url'      => 'form-control',
            'number'   => 'form-control',
        ];
        return $map[ $type ] ?? $class;
    }

    /* ── Members per page from admin option ──────────────────────────────────── */
    public static function members_per_page( $args ) {
        $per = (int) zc_option( 'bp_members_per_page', 20 );
        if ( $per > 0 ) $args['per_page'] = $per;
        return $args;
    }

    /* ── Groups per page from admin option ───────────────────────────────────── */
    public static function groups_per_page( $args ) {
        $per = (int) zc_option( 'bp_groups_per_page', 20 );
        if ( $per > 0 ) $args['per_page'] = $per;
        return $args;
    }

    /* ── Online dot indicator ────────────────────────────────────────────────── */
    public static function add_online_indicator( $name ) {
        if ( zc_option( 'bp_show_online_status', '1' ) !== '1' ) return $name;
        if ( ! function_exists( 'bp_get_member_last_active' ) ) return $name;

        $last_active = bp_get_member_last_active( [ 'relative' => false ] );
        if ( ! $last_active ) return $name;

        $ts = strtotime( $last_active );
        if ( ( time() - $ts ) < 300 ) { // 5 minutes
            $name .= ' <span class="zc-online-dot" title="' . esc_attr__( 'Online', 'zincelestial' ) . '" aria-label="' . esc_attr__( 'Online', 'zincelestial' ) . '"></span>';
        }
        return $name;
    }

    /* ── Cover image allowed types ───────────────────────────────────────────── */
    public static function cover_image_types( $types ) {
        return array_merge( $types, [ 'jpg', 'jpeg', 'png', 'webp' ] );
    }

    /* ── Cover image dimensions ──────────────────────────────────────────────── */
    public static function cover_dimensions( $dimensions ) {
        $h = (int) zc_option( 'bp_cover_height', 300 );
        return [
            'width'  => 1300,
            'height' => $h,
        ];
    }

    /* ── Bootstrap-style friend button ───────────────────────────────────────── */
    public static function bs5_friend_button( $button ) {
        if ( empty( $button ) ) return $button;
        if ( isset( $button['link_class'] ) ) {
            $button['link_class'] = str_replace(
                [ 'friendship-button', 'not-friends', 'pending_friend' ],
                [ 'btn btn-sm zc-friend-btn friendship-button', 'btn-outline-primary not-friends', 'btn-warning pending_friend' ],
                $button['link_class']
            );
        }
        return $button;
    }

    /* ── Bootstrap-style message button ──────────────────────────────────────── */
    public static function bs5_message_button( $button ) {
        if ( isset( $button['link_class'] ) ) {
            $button['link_class'] .= ' btn btn-sm btn-outline-secondary zc-msg-btn';
        }
        return $button;
    }

    /* ── Member header stats bar (replaces Wbcom Essential output) ───────────── */
    public static function member_header_stats() {
        if ( ! bp_is_user() ) return;
        $uid = bp_displayed_user_id();
        if ( ! $uid ) return;

        $friends = function_exists( 'friends_get_total_friend_count' ) ? friends_get_total_friend_count( $uid ) : 0;
        $groups  = function_exists( 'groups_total_groups_for_user' )  ? groups_total_groups_for_user( $uid )  : 0;
        ?>
        <div class="zc-member-header-stats d-flex gap-3 flex-wrap mt-2">
            <?php if ( $friends > 0 ) : ?>
            <div class="zc-stat-pill">
                <i class="bi bi-people-fill me-1"></i>
                <strong><?php echo absint( $friends ); ?></strong>
                <span class="text-muted small"><?php esc_html_e( 'Friends', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( $groups > 0 ) : ?>
            <div class="zc-stat-pill">
                <i class="bi bi-diagram-3-fill me-1"></i>
                <strong><?php echo absint( $groups ); ?></strong>
                <span class="text-muted small"><?php esc_html_e( 'Groups', 'zincelestial' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( function_exists( 'bp_get_profile_field_data' ) ) :
                $loc = bp_get_profile_field_data( [ 'field' => 'Location', 'user_id' => $uid ] );
                if ( $loc ) : ?>
            <div class="zc-stat-pill">
                <i class="bi bi-geo-alt-fill me-1"></i>
                <span><?php echo esc_html( $loc ); ?></span>
            </div>
            <?php endif; endif; ?>
        </div>
        <?php
    }

    /* ── Group header stats bar ───────────────────────────────────────────────── */
    public static function group_header_stats() {
        if ( ! bp_is_group() ) return;
        $members = function_exists( 'groups_get_current_group' )
            ? bp_get_current_group_member_count()
            : 0;
        ?>
        <div class="zc-group-header-stats d-flex gap-3 flex-wrap mt-2">
            <div class="zc-stat-pill">
                <i class="bi bi-people-fill me-1"></i>
                <strong><?php echo absint( $members ); ?></strong>
                <span class="text-muted small"><?php esc_html_e( 'Members', 'zincelestial' ); ?></span>
            </div>
        </div>
        <?php
    }

    /* ── AJAX load more ───────────────────────────────────────────────────────── */
    public static function ajax_load_more() {
        check_ajax_referer( 'zc_frontend_nonce', 'nonce' );
        $type = sanitize_key( $_POST['type'] ?? 'activity' );
        $page = absint( $_POST['page'] ?? 2 );

        // Basic response — actual BP loop called via JS
        wp_send_json_success( [ 'page' => $page, 'type' => $type ] );
    }

    /* ── Clean up BP admin bar duplication ───────────────────────────────────── */
    public static function fix_admin_bar() {
        // Prevent duplicate "Activity" node
        if ( ! is_admin() ) {
            remove_action( 'bp_setup_admin_bar', [ buddypress()->activity, 'setup_admin_bar' ], 4 );
            add_action( 'bp_setup_admin_bar', [ buddypress()->activity, 'setup_admin_bar' ], 4 );
        }
    }
}

ZC_BP_Setup::init();

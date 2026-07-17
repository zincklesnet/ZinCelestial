<?php
/**
 * ZinCelestial — BuddyPress Group Customizations
 *
 * Handles group-specific UI enhancements: cover images, custom group types,
 * group meta display, group nav reordering, and admin panel controls.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. GROUP COVER IMAGE
// ─────────────────────────────────────────────

/**
 * Enable group cover images via BuddyPress xProfile extension.
 */
add_filter( 'bp_groups_get_group_types', 'zc_group_cover_support' );
function zc_group_cover_support( $types ) {
    if ( zc_option( 'group_cover_enable', true ) ) {
        add_theme_support( 'bp-group-cover-image' );
    }
    return $types;
}

/**
 * Output group cover image container on group header.
 */
add_action( 'bp_before_group_header', 'zc_render_group_cover' );
function zc_render_group_cover() {
    if ( ! zc_option( 'group_cover_enable', true ) ) return;
    $group_id = bp_get_current_group_id();
    $cover    = bp_attachments_get_attachment( 'url', [
        'object_dir' => 'groups',
        'item_id'    => $group_id,
    ] );
    $default  = get_template_directory_uri() . '/assets/images/default-group-cover.jpg';
    $src      = $cover ?: $default;
    echo '<div class="zc-group-cover" style="background-image:url(' . esc_url( $src ) . ');" aria-hidden="true"></div>';
}

// ─────────────────────────────────────────────
// 2. GROUP TYPES DISPLAY
// ─────────────────────────────────────────────

/**
 * Display group type badge on group listings.
 */
add_action( 'bp_group_header_meta', 'zc_group_type_badge' );
add_action( 'bp_directory_groups_item', 'zc_group_type_badge' );
function zc_group_type_badge() {
    if ( ! bp_is_active( 'groups' ) ) return;
    $group_id = bp_get_current_group_id() ?: bp_get_group_id();
    $types    = bp_groups_get_group_type( $group_id, false );
    if ( empty( $types ) ) return;
    echo '<div class="zc-group-types">';
    foreach ( (array) $types as $type ) {
        $obj = bp_groups_get_group_type_object( $type );
        if ( $obj ) {
            echo '<span class="zc-group-type-badge">' . esc_html( $obj->labels['singular_name'] ) . '</span>';
        }
    }
    echo '</div>';
}

// ─────────────────────────────────────────────
// 3. GROUP NAV REORDER
// ─────────────────────────────────────────────

/**
 * Reorder group sub-navigation tabs based on admin settings.
 */
add_filter( 'bp_groups_nav_items', 'zc_reorder_group_nav', 20 );
function zc_reorder_group_nav( $nav_items ) {
    $order = zc_option( 'group_nav_order', [] );
    if ( empty( $order ) || ! is_array( $order ) ) return $nav_items;
    $reordered = [];
    foreach ( $order as $slug ) {
        if ( isset( $nav_items[ $slug ] ) ) {
            $reordered[ $slug ] = $nav_items[ $slug ];
        }
    }
    foreach ( $nav_items as $slug => $item ) {
        if ( ! isset( $reordered[ $slug ] ) ) {
            $reordered[ $slug ] = $item;
        }
    }
    return $reordered;
}

// ─────────────────────────────────────────────
// 4. GROUP META BOX — CUSTOM FIELDS
// ─────────────────────────────────────────────

/**
 * Register group extension for custom meta fields.
 */
function zc_register_group_extension() {
    if ( ! class_exists( 'BP_Group_Extension' ) ) return;

    class ZC_Group_Extension extends BP_Group_Extension {
        public function __construct() {
            $this->name         = __( 'Group Details', 'zincelestial' );
            $this->slug         = 'group-details';
            $this->nav_item_position = 61;
            $this->enable_create_step = true;
            $this->enable_nav_item    = false;
            $this->enable_edit_item   = true;
        }

        public function edit_screen( $group_id = null ) {
            if ( ! $group_id ) $group_id = bp_get_current_group_id();
            $website = groups_get_groupmeta( $group_id, 'zc_group_website', true );
            $tagline = groups_get_groupmeta( $group_id, 'zc_group_tagline', true );
            ?>
            <div class="zc-group-ext-fields">
                <label for="zc_group_website"><?php esc_html_e( 'Group Website', 'zincelestial' ); ?></label>
                <input type="url" id="zc_group_website" name="zc_group_website" value="<?php echo esc_url( $website ); ?>" class="zc-input" />

                <label for="zc_group_tagline"><?php esc_html_e( 'Group Tagline', 'zincelestial' ); ?></label>
                <input type="text" id="zc_group_tagline" name="zc_group_tagline" value="<?php echo esc_attr( $tagline ); ?>" class="zc-input" maxlength="160" />
            </div>
            <?php
            wp_nonce_field( 'zc_group_ext_save', 'zc_group_ext_nonce' );
        }

        public function edit_screen_save( $group_id = null ) {
            if ( ! $group_id ) $group_id = bp_get_current_group_id();
            if ( ! isset( $_POST['zc_group_ext_nonce'] ) || ! wp_verify_nonce( $_POST['zc_group_ext_nonce'], 'zc_group_ext_save' ) ) return;
            if ( isset( $_POST['zc_group_website'] ) ) {
                groups_update_groupmeta( $group_id, 'zc_group_website', esc_url_raw( $_POST['zc_group_website'] ) );
            }
            if ( isset( $_POST['zc_group_tagline'] ) ) {
                groups_update_groupmeta( $group_id, 'zc_group_tagline', sanitize_text_field( $_POST['zc_group_tagline'] ) );
            }
        }

        public function create_screen( $group_id = null ) {
            $this->edit_screen( $group_id );
        }

        public function create_screen_save( $group_id = null ) {
            $this->edit_screen_save( $group_id );
        }
    }

    bp_register_group_extension( 'ZC_Group_Extension' );
}
add_action( 'bp_include', 'zc_register_group_extension' );

// ─────────────────────────────────────────────
// 5. GROUP HEADER META — WEBSITE & TAGLINE
// ─────────────────────────────────────────────

add_action( 'bp_group_header_meta', 'zc_group_custom_meta_display', 15 );
function zc_group_custom_meta_display() {
    $group_id = bp_get_current_group_id();
    $website  = groups_get_groupmeta( $group_id, 'zc_group_website', true );
    $tagline  = groups_get_groupmeta( $group_id, 'zc_group_tagline', true );
    if ( $tagline ) {
        echo '<p class="zc-group-tagline">' . esc_html( $tagline ) . '</p>';
    }
    if ( $website ) {
        echo '<a href="' . esc_url( $website ) . '" class="zc-group-website" target="_blank" rel="noopener noreferrer">'
             . '<span class="zc-icon">🌐</span> ' . esc_html( wp_parse_url( $website, PHP_URL_HOST ) ) . '</a>';
    }
}

// ─────────────────────────────────────────────
// 6. GROUP INVITE CONTROLS
// ─────────────────────────────────────────────

/**
 * Restrict group invitations to admins/mods only if option set.
 */
add_filter( 'bp_group_can_send_invitation', 'zc_group_invite_restriction', 10, 2 );
function zc_group_invite_restriction( $can, $group_id ) {
    if ( zc_option( 'group_invite_restrict', false ) ) {
        return ( bp_current_user_can( 'bp_moderate' ) || groups_is_user_admin( get_current_user_id(), $group_id ) || groups_is_user_mod( get_current_user_id(), $group_id ) );
    }
    return $can;
}

// ─────────────────────────────────────────────
// 7. GROUP STATS WIDGET
// ─────────────────────────────────────────────

add_action( 'bp_before_group_header_meta', 'zc_group_stats_bar' );
function zc_group_stats_bar() {
    if ( ! bp_is_group() || ! zc_option( 'group_stats_bar', true ) ) return;
    $group_id    = bp_get_current_group_id();
    $member_count = groups_get_total_member_count( $group_id );
    $post_count   = (int) groups_get_groupmeta( $group_id, 'total_forum_topics', true );
    echo '<div class="zc-group-stats">';
    echo '<span class="zc-stat"><span class="zc-stat-icon">👥</span>' . number_format_i18n( $member_count ) . ' ' . esc_html__( 'Members', 'zincelestial' ) . '</span>';
    if ( $post_count ) {
        echo '<span class="zc-stat"><span class="zc-stat-icon">💬</span>' . number_format_i18n( $post_count ) . ' ' . esc_html__( 'Topics', 'zincelestial' ) . '</span>';
    }
    echo '</div>';
}

// ─────────────────────────────────────────────
// 8. GROUP ADMIN SETTINGS INTEGRATION
// ─────────────────────────────────────────────

/**
 * Helper: get ZinCelestial option with fallback.
 * (Defined in admin-options.php but stub here for safety.)
 */
if ( ! function_exists( 'zc_option' ) ) {
    function zc_option( $key, $default = '' ) {
        $opts = get_option( 'zincelestial_options', [] );
        return isset( $opts[ $key ] ) ? $opts[ $key ] : $default;
    }
}

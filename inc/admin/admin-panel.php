<?php
/**
 * ZinCelestial v5.1.0 — Admin Panel
 *
 * FIXES:
 *  #1 CRITICAL: Hook suffix = 'zc-dashboard_page_zc-{slug}' (not zincelestial_page_...)
 *  #3: zc_default_options() guarded with function_exists()
 *  #5: Single canonical ZC_OPTS_KEY = 'zincelestial_options'
 *  #6: Safe mode AJAX with correct nonce 'zca_safe_mode'
 *  v5.1.0: Genesis detection hides Performance/Security at registration time
 *  v5.1.0: Module-gated pages check plugin active status (BP/WC/bbP)
 *  v5.1.0: Admin tabs use data-zc-tab / data-zc-panel to avoid Bootstrap conflict
 *  v5.1.0: All AJAX handlers use proper nonce verification
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_Admin_Panel {

    /* ── Admin pages definition ──────────────────────────────────────────────── */
    const PAGES = [
        // Core — always visible
        'zc-dashboard'   => [ 'title' => 'Dashboard',          'icon' => 'bi-speedometer2',              'module' => null,            'stage' => 1 ],
        'zc-general'     => [ 'title' => 'General',            'icon' => 'bi-gear-fill',                 'module' => null,            'stage' => 1 ],
        'zc-design'      => [ 'title' => 'Design & Colors',    'icon' => 'bi-palette-fill',              'module' => null,            'stage' => 1 ],
        'zc-typography'  => [ 'title' => 'Typography',         'icon' => 'bi-type',                      'module' => null,            'stage' => 1 ],
        'zc-header'      => [ 'title' => 'Header & Nav',       'icon' => 'bi-layout-text-window-reverse','module' => null,            'stage' => 1 ],
        'zc-footer'      => [ 'title' => 'Footer',             'icon' => 'bi-layout-text-window',        'module' => null,            'stage' => 1 ],
        'zc-sidebar'     => [ 'title' => 'Sidebars',           'icon' => 'bi-layout-sidebar-reverse',    'module' => null,            'stage' => 1 ],
        'zc-schemes'     => [ 'title' => 'Color Schemes',      'icon' => 'bi-brush-fill',                'module' => null,            'stage' => 1 ],
        // Plugin integrations — always visible (auto-detect active plugins)
        'zc-buddypress'  => [ 'title' => 'BuddyPress',         'icon' => 'bi-people-fill',               'module' => 'buddypress',    'stage' => 1, 'plugin_check' => 'buddypress' ],
        'zc-woocommerce' => [ 'title' => 'WooCommerce',        'icon' => 'bi-bag-fill',                  'module' => 'woocommerce',   'stage' => 1, 'plugin_check' => 'woocommerce' ],
        'zc-bbpress'     => [ 'title' => 'bbPress',            'icon' => 'bi-chat-left-dots-fill',       'module' => 'bbpress',       'stage' => 1, 'plugin_check' => 'bbpress' ],
        // Core advanced
        'zc-integrations'=> [ 'title' => 'Integrations',       'icon' => 'bi-plug-fill',                 'module' => null,            'stage' => 1 ],
        'zc-advanced'    => [ 'title' => 'Advanced',            'icon' => 'bi-cpu-fill',                  'module' => null,            'stage' => 1 ],
        'zc-shortcodes'  => [ 'title' => 'Shortcodes Ref',     'icon' => 'bi-code-square',               'module' => null,            'stage' => 1 ],
        // Performance/Security — hidden when ZinGenesis active
        'zc-performance' => [ 'title' => 'Performance',        'icon' => 'bi-lightning-fill',            'module' => null,            'stage' => 1, 'hide_with_genesis' => true ],
        'zc-security'    => [ 'title' => 'Security',           'icon' => 'bi-shield-fill-check',         'module' => null,            'stage' => 1, 'hide_with_genesis' => true ],
        // Network
        'zc-network'     => [ 'title' => 'Network',            'icon' => 'bi-diagram-3-fill',            'module' => null,            'stage' => 1, 'network_only' => true ],
        // Stage 2+ — only shown when module enabled in options
        'zc-reactions'   => [ 'title' => 'Reactions',          'icon' => 'bi-emoji-smile-fill',          'module' => 'reactions',     'stage' => 2 ],
        'zc-gamipress'   => [ 'title' => 'GamiPress Bar',      'icon' => 'bi-trophy-fill',               'module' => 'gamipress_bar', 'stage' => 2 ],
        'zc-compose'     => [ 'title' => 'Compose Bar',        'icon' => 'bi-pencil-fill',               'module' => 'compose_bar',   'stage' => 2 ],
        'zc-helpdesk'    => [ 'title' => 'Help Desk',          'icon' => 'bi-headset',                   'module' => 'helpdesk',      'stage' => 2 ],
        'zc-analytics'   => [ 'title' => 'Analytics',          'icon' => 'bi-bar-chart-fill',            'module' => 'analytics',     'stage' => 2 ],
        'zc-calendar'    => [ 'title' => 'Calendar',           'icon' => 'bi-calendar3',                 'module' => 'calendar_page', 'stage' => 2 ],
        'zc-library'     => [ 'title' => 'Element Library',    'icon' => 'bi-collection-fill',           'module' => 'library',       'stage' => 2 ],
        'zc-posttypes'   => [ 'title' => 'Post Types',         'icon' => 'bi-file-richtext-fill',        'module' => 'post_meta',     'stage' => 2 ],
        'zc-ai'          => [ 'title' => 'AI / Copilot',       'icon' => 'bi-robot',                     'module' => 'ai',            'stage' => 3 ],
    ];

    /* ── slug → view file map ───────────────────────────────────────────────── */
    const VIEW_MAP = [
        'zc-dashboard'   => 'dashboard',
        'zc-general'     => 'general',
        'zc-design'      => 'design',
        'zc-typography'  => 'typography',
        'zc-header'      => 'header-nav',
        'zc-footer'      => 'footer',
        'zc-sidebar'     => 'sidebars',
        'zc-buddypress'  => 'buddypress',
        'zc-woocommerce' => 'woocommerce',
        'zc-bbpress'     => 'bbpress',
        'zc-schemes'     => 'schemes',
        'zc-performance' => 'performance',
        'zc-security'    => 'security',
        'zc-integrations'=> 'integrations',
        'zc-advanced'    => 'advanced',
        'zc-reactions'   => 'reactions',
        'zc-gamipress'   => 'gamipress',
        'zc-compose'     => 'compose',
        'zc-library'     => 'library',
        'zc-posttypes'   => 'posttypes',
        'zc-helpdesk'    => 'helpdesk',
        'zc-analytics'   => 'analytics',
        'zc-calendar'    => 'calendar',
        'zc-shortcodes'  => 'shortcodes-ref',
        'zc-ai'          => 'ai',
        'zc-network'     => 'network',
    ];

    /* ── Bootstrap ──────────────────────────────────────────────────────────── */
    public static function init() {
        add_action( 'admin_menu',         [ __CLASS__, 'register_menus' ] );
        add_action( 'network_admin_menu', [ __CLASS__, 'register_network_menu' ] );

        // AJAX handlers
        add_action( 'wp_ajax_zca_save_options',   [ __CLASS__, 'ajax_save_options' ] );
        add_action( 'wp_ajax_zca_save_safe_mode', [ __CLASS__, 'ajax_save_safe_mode' ] );
        add_action( 'wp_ajax_zca_reset_section',  [ __CLASS__, 'ajax_reset_section' ] );
        add_action( 'wp_ajax_zca_import_options', [ __CLASS__, 'ajax_import_options' ] );
    }

    /* ── Determine whether a page should be visible ─────────────────────────── */
    private static function page_visible( $slug, $cfg ) {
        // Stage 2+ — only if module enabled
        if ( isset( $cfg['stage'] ) && $cfg['stage'] >= 2 ) {
            if ( ! zc_module_enabled( $cfg['module'] ?? '' ) ) return false;
        }

        // Hide Performance/Security when Genesis active
        if ( ! empty( $cfg['hide_with_genesis'] ) && defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) && ZC_GENESIS_ADMIN_ACTIVE ) {
            return false;
        }

        // Network-only pages: skip in single-site admin_menu
        if ( ! empty( $cfg['network_only'] ) ) return false;

        // Plugin-gated pages: show if plugin is active regardless of module toggle
        if ( ! empty( $cfg['plugin_check'] ) ) {
            switch ( $cfg['plugin_check'] ) {
                case 'buddypress':
                    return function_exists( 'buddypress' );
                case 'woocommerce':
                    return class_exists( 'WooCommerce' );
                case 'bbpress':
                    return class_exists( 'bbPress' );
            }
        }

        return true;
    }

    /* ── Register admin menu ─────────────────────────────────────────────────── */
    public static function register_menus() {
        if ( ! current_user_can( 'manage_options' ) ) return;

        // Dashboard (parent page = also menu parent)
        add_menu_page(
            'ZinCelestial',
            'ZinCelestial',
            'manage_options',
            'zc-dashboard',
            [ __CLASS__, 'render_page' ],
            'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#7c6ff7" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>'),
            58
        );

        // Sub-pages
        foreach ( self::PAGES as $slug => $cfg ) {
            if ( $slug === 'zc-dashboard' ) continue;
            if ( ! self::page_visible( $slug, $cfg ) ) continue;

            add_submenu_page(
                'zc-dashboard',
                'ZinCelestial — ' . $cfg['title'],
                $cfg['title'],
                'manage_options',
                $slug,
                [ __CLASS__, 'render_page' ]
            );
        }
    }

    /* ── Network admin menu ──────────────────────────────────────────────────── */
    public static function register_network_menu() {
        if ( ! current_user_can( 'manage_network_options' ) ) return;
        add_menu_page(
            'ZinCelestial Network',
            'ZinCelestial',
            'manage_network_options',
            'zc-network',
            [ __CLASS__, 'render_page' ],
            '',
            58
        );
    }

    /* ── Render page ─────────────────────────────────────────────────────────── */
    public static function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Unauthorized.', ZC_TEXT ) );
        }

        $slug     = sanitize_key( $_GET['page'] ?? 'zc-dashboard' );
        $view_key = self::VIEW_MAP[ $slug ] ?? 'dashboard';
        $view     = ZC_INC . 'admin/views/' . $view_key . '.php';

        // Fallback to dashboard if view missing
        if ( ! file_exists( $view ) ) {
            $view = ZC_INC . 'admin/views/dashboard.php';
        }

        echo '<div class="zca-wrap">';
        self::render_sidebar( $slug );
        echo '<div class="zca-content">';
        self::render_topbar( $slug );
        echo '<div class="zca-page-body">';

        if ( file_exists( $view ) ) {
            include $view;
        } else {
            echo '<div class="zca-card"><p>View file not found: ' . esc_html( $view_key ) . '.php</p></div>';
        }

        echo '</div></div></div>'; // page-body, content, wrap
    }

    /* ── Sidebar navigation ──────────────────────────────────────────────────── */
    private static function render_sidebar( $current_slug ) {
        $genesis = defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) && ZC_GENESIS_ADMIN_ACTIVE;
        ?>
        <aside class="zca-sidebar">
            <div class="zca-sidebar-brand">
                <span class="zca-brand-icon">✦</span>
                <span class="zca-brand-name">ZinCelestial</span>
                <span class="zca-brand-ver">v<?php echo esc_html( ZC_VERSION ); ?></span>
            </div>

            <?php if ( $genesis ) : ?>
            <div class="zca-genesis-badge" title="ZinGenesis Admin Theme is active — Performance & Security managed by Genesis">
                <i class="bi bi-shield-fill-check"></i> ZinGenesis Active
            </div>
            <?php endif; ?>

            <nav class="zca-sidebar-nav" role="navigation">
                <?php
                $groups = [
                    'Core'          => [ 'zc-dashboard','zc-general','zc-design','zc-typography','zc-header','zc-footer','zc-sidebar','zc-schemes' ],
                    'Integrations'  => [ 'zc-buddypress','zc-woocommerce','zc-bbpress' ],
                    'Settings'      => [ 'zc-integrations','zc-advanced','zc-shortcodes' ],
                    'System'        => [ 'zc-performance','zc-security' ],
                    'Modules'       => [ 'zc-reactions','zc-gamipress','zc-compose','zc-helpdesk','zc-analytics','zc-calendar','zc-library','zc-posttypes','zc-ai' ],
                ];
                foreach ( $groups as $label => $slugs ) :
                    $visible = array_filter( $slugs, function( $s ) {
                        $cfg = self::PAGES[ $s ] ?? [];
                        return self::page_visible( $s, $cfg );
                    });
                    if ( empty( $visible ) ) continue;
                ?>
                <div class="zca-nav-group">
                    <div class="zca-nav-group-label"><?php echo esc_html( $label ); ?></div>
                    <?php foreach ( $visible as $slug ) :
                        $cfg   = self::PAGES[ $slug ] ?? [ 'title' => $slug, 'icon' => 'bi-circle' ];
                        $url   = admin_url( 'admin.php?page=' . $slug );
                        $active= ( $slug === $current_slug ) ? 'zca-nav-item--active' : '';
                    ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="zca-nav-item <?php echo esc_attr( $active ); ?>">
                        <i class="<?php echo esc_attr( $cfg['icon'] ); ?> zca-nav-icon"></i>
                        <span class="zca-nav-label"><?php echo esc_html( $cfg['title'] ); ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </nav>

            <div class="zca-sidebar-footer">
                <a href="<?php echo esc_url( home_url('/') ); ?>" target="_blank" class="zca-sidebar-link">
                    <i class="bi bi-eye"></i> View Site
                </a>
                <a href="<?php echo esc_url( admin_url('customize.php') ); ?>" class="zca-sidebar-link">
                    <i class="bi bi-palette"></i> Customizer
                </a>
            </div>
        </aside>
        <?php
    }

    /* ── Top bar (page title + save button) ─────────────────────────────────── */
    private static function render_topbar( $slug ) {
        $cfg   = self::PAGES[ $slug ] ?? [ 'title' => 'ZinCelestial', 'icon' => 'bi-speedometer2' ];
        $title = $cfg['title'];
        $icon  = $cfg['icon'];
        ?>
        <div class="zca-topbar">
            <div class="zca-topbar-left">
                <i class="<?php echo esc_attr( $icon ); ?> zca-topbar-icon"></i>
                <h1 class="zca-topbar-title"><?php echo esc_html( $title ); ?></h1>
            </div>
            <div class="zca-topbar-actions">
                <span class="zca-save-status" id="zca-save-status"></span>
                <button class="zca-btn zca-btn-ghost zca-btn-sm" id="zca-export-btn" title="Export settings JSON">
                    <i class="bi bi-download"></i> Export
                </button>
                <button class="zca-btn zca-btn-ghost zca-btn-sm" id="zca-import-btn" title="Import settings JSON">
                    <i class="bi bi-upload"></i> Import
                </button>
                <input type="file" id="zca-import-file" accept=".json" style="display:none;">
                <button class="zca-btn zca-btn-primary zca-btn-sm" id="zca-save-btn" onclick="zcaSaveOptions()" title="Save (Ctrl+S)">
                    <i class="bi bi-floppy-fill"></i> Save Changes
                </button>
            </div>
        </div>
        <?php
    }

    /* ═══════════════════════════════════════════════════════════════════════════
       AJAX HANDLERS
    ═══════════════════════════════════════════════════════════════════════════ */

    public static function ajax_save_options() {
        check_ajax_referer( 'zca_save_options', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );

        $incoming = json_decode( stripslashes( $_POST['options'] ?? '{}' ), true );
        if ( ! is_array( $incoming ) ) wp_send_json_error( 'Invalid data' );

        // Sanitize
        $clean = [];
        foreach ( $incoming as $key => $val ) {
            $key = sanitize_key( $key );
            if ( is_array( $val ) ) {
                $clean[ $key ] = array_map( 'sanitize_text_field', $val );
            } else {
                $clean[ $key ] = sanitize_text_field( $val );
            }
        }

        // Merge with existing options
        $existing = (array) get_option( ZC_OPTS_KEY, [] );
        $merged   = array_merge( $existing, $clean );
        update_option( ZC_OPTS_KEY, $merged );

        wp_send_json_success( [ 'message' => 'Options saved', 'count' => count( $clean ) ] );
    }

    public static function ajax_save_safe_mode() {
        check_ajax_referer( 'zca_safe_mode', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );

        $safe = ( sanitize_text_field( $_POST['safe_mode'] ?? '0' ) === '1' ) ? '1' : '0';
        $opts = (array) get_option( ZC_OPTS_KEY, [] );
        $opts['safe_mode'] = $safe;
        update_option( ZC_OPTS_KEY, $opts );

        wp_send_json_success( [ 'safe_mode' => $safe ] );
    }

    public static function ajax_reset_section() {
        check_ajax_referer( 'zca_save_options', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );

        $section  = sanitize_text_field( $_POST['section'] ?? '' );
        $defaults = zc_default_options();
        $existing = (array) get_option( ZC_OPTS_KEY, [] );

        // Section → option key prefix mapping
        $prefix_map = [
            'header'   => [ 'header_', 'show_topbar', 'topbar_', 'show_subheader', 'subheader_', 'show_search_header', 'show_notifications_icon', 'show_messages_icon', 'show_cart_icon', 'show_left_panel', 'show_right_panel' ],
            'footer'   => [ 'footer_', 'show_footer_' ],
            'design'   => [ 'color_', 'border_radius' ],
            'typography'=> [ 'font_', 'disable_google_fonts' ],
            'buddypress'=> [ 'bp_', 'member_directory', 'members_per', 'group_directory', 'groups_per', 'show_verified', 'show_online', 'show_bp_', 'online_indicator' ],
            'woocommerce'=> [ 'shop_', 'products_', 'mini_cart', 'checkout_', 'woo_' ],
            'bbpress'  => [ 'bbp_' ],
        ];

        $prefixes = $prefix_map[ $section ] ?? [];
        if ( empty( $prefixes ) ) {
            wp_send_json_error( 'Unknown section: ' . $section );
        }

        foreach ( $defaults as $key => $default_val ) {
            foreach ( $prefixes as $prefix ) {
                if ( str_starts_with( $key, $prefix ) || $key === $prefix ) {
                    $existing[ $key ] = $default_val;
                    break;
                }
            }
        }

        update_option( ZC_OPTS_KEY, $existing );
        wp_send_json_success( [ 'section' => $section, 'reset' => true ] );
    }

    public static function ajax_import_options() {
        check_ajax_referer( 'zca_save_options', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );

        $incoming = json_decode( stripslashes( $_POST['options'] ?? '{}' ), true );
        if ( ! is_array( $incoming ) ) wp_send_json_error( 'Invalid JSON' );

        $clean = [];
        foreach ( $incoming as $key => $val ) {
            $clean[ sanitize_key( $key ) ] = sanitize_text_field( $val );
        }

        $merged = array_merge( (array) get_option( ZC_OPTS_KEY, [] ), $clean );
        update_option( ZC_OPTS_KEY, $merged );

        wp_send_json_success( [ 'imported' => count( $clean ) ] );
    }
}

ZC_Admin_Panel::init();

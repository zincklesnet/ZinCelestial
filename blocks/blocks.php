<?php
/**
 * ZinCelestial — Block Pattern Registration
 *
 * Registers all ZinCelestial block patterns and pattern categories
 * for the WordPress block editor (Gutenberg).
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// 1. PATTERN CATEGORIES
// ─────────────────────────────────────────────

add_action( 'init', 'zc_register_block_pattern_categories' );
function zc_register_block_pattern_categories() {
    $categories = [
        'zincelestial-hero'      => [ 'label' => __( 'ZinCelestial — Hero',      'zincelestial' ) ],
        'zincelestial-community' => [ 'label' => __( 'ZinCelestial — Community', 'zincelestial' ) ],
        'zincelestial-cards'     => [ 'label' => __( 'ZinCelestial — Cards',     'zincelestial' ) ],
        'zincelestial-cta'       => [ 'label' => __( 'ZinCelestial — CTA',       'zincelestial' ) ],
        'zincelestial-media'     => [ 'label' => __( 'ZinCelestial — Media',     'zincelestial' ) ],
    ];

    foreach ( $categories as $slug => $args ) {
        if ( function_exists( 'register_block_pattern_category' ) ) {
            register_block_pattern_category( $slug, $args );
        }
    }
}

// ─────────────────────────────────────────────
// 2. PATTERN LOADER
// ─────────────────────────────────────────────

add_action( 'init', 'zc_register_block_patterns' );
function zc_register_block_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) return;

    $patterns_dir = get_template_directory() . '/patterns/';
    $pattern_files = glob( $patterns_dir . '*.php' );
    if ( empty( $pattern_files ) ) return;

    foreach ( $pattern_files as $file ) {
        zc_load_block_pattern( $file );
    }
}

/**
 * Parse pattern file header and register the pattern.
 *
 * Pattern files use PHP docblock headers:
 *   Title, Slug, Description, Categories, Keywords, Viewport Width, Block Types
 *
 * @param string $file Absolute path to pattern file.
 */
function zc_load_block_pattern( $file ) {
    $pattern_data = get_file_data( $file, [
        'title'          => 'Title',
        'slug'           => 'Slug',
        'description'    => 'Description',
        'categories'     => 'Categories',
        'keywords'       => 'Keywords',
        'viewport_width' => 'Viewport Width',
        'block_types'    => 'Block Types',
    ] );

    if ( empty( $pattern_data['title'] ) || empty( $pattern_data['slug'] ) ) return;

    ob_start();
    include $file;
    $content = ob_get_clean();

    $args = [
        'title'       => $pattern_data['title'],
        'description' => $pattern_data['description'] ?? '',
        'content'     => $content,
    ];

    if ( ! empty( $pattern_data['categories'] ) ) {
        $args['categories'] = array_map( 'trim', explode( ',', $pattern_data['categories'] ) );
    }
    if ( ! empty( $pattern_data['keywords'] ) ) {
        $args['keywords'] = array_map( 'trim', explode( ',', $pattern_data['keywords'] ) );
    }
    if ( ! empty( $pattern_data['viewport_width'] ) ) {
        $args['viewportWidth'] = (int) $pattern_data['viewport_width'];
    }
    if ( ! empty( $pattern_data['block_types'] ) ) {
        $args['blockTypes'] = array_map( 'trim', explode( ',', $pattern_data['block_types'] ) );
    }

    register_block_pattern( $pattern_data['slug'], $args );
}

// ─────────────────────────────────────────────
// 3. CUSTOM BLOCK STYLES
// ─────────────────────────────────────────────

add_action( 'init', 'zc_register_block_styles' );
function zc_register_block_styles() {
    if ( ! function_exists( 'register_block_style' ) ) return;

    // Button styles
    register_block_style( 'core/button', [
        'name'  => 'zc-gradient',
        'label' => __( 'ZinCelestial Gradient', 'zincelestial' ),
    ] );
    register_block_style( 'core/button', [
        'name'  => 'zc-ghost',
        'label' => __( 'ZinCelestial Ghost', 'zincelestial' ),
    ] );

    // Image styles
    register_block_style( 'core/image', [
        'name'  => 'zc-rounded',
        'label' => __( 'ZinCelestial Rounded', 'zincelestial' ),
    ] );
    register_block_style( 'core/image', [
        'name'  => 'zc-glow',
        'label' => __( 'ZinCelestial Glow', 'zincelestial' ),
    ] );

    // Group block
    register_block_style( 'core/group', [
        'name'  => 'zc-card',
        'label' => __( 'ZinCelestial Card', 'zincelestial' ),
    ] );
    register_block_style( 'core/group', [
        'name'  => 'zc-glass',
        'label' => __( 'ZinCelestial Glass', 'zincelestial' ),
    ] );

    // Columns
    register_block_style( 'core/columns', [
        'name'  => 'zc-feature-grid',
        'label' => __( 'ZinCelestial Feature Grid', 'zincelestial' ),
    ] );

    // Quote
    register_block_style( 'core/quote', [
        'name'  => 'zc-accent',
        'label' => __( 'ZinCelestial Accent Quote', 'zincelestial' ),
    ] );
}

// ─────────────────────────────────────────────
// 4. BLOCK EDITOR ASSETS
// ─────────────────────────────────────────────

add_action( 'enqueue_block_editor_assets', 'zc_enqueue_editor_assets' );
function zc_enqueue_editor_assets() {
    wp_enqueue_style(
        'zc-editor-styles',
        get_template_directory_uri() . '/assets/css/blocks.css',
        [],
        ZC_VERSION
    );

    // Inline editor CSS for block styles preview
    $inline = '
        .is-style-zc-gradient { background: linear-gradient(135deg,#7c6ff7,#00d4ff); color:#fff; border:none; }
        .is-style-zc-ghost { background:transparent; border:2px solid #7c6ff7; color:#7c6ff7; }
        .is-style-zc-rounded img { border-radius:16px; }
        .is-style-zc-glow img { box-shadow:0 0 30px rgba(124,111,247,.4); border-radius:12px; }
        .is-style-zc-card { background:#0f0f1f; border:1px solid #1e1e3a; border-radius:16px; padding:2rem; }
        .is-style-zc-glass { background:rgba(255,255,255,.05); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.1); border-radius:16px; padding:2rem; }
        .is-style-zc-feature-grid { gap:2rem; }
        .is-style-zc-accent { border-left:4px solid #7c6ff7; padding-left:1.5rem; }
    ';
    wp_add_inline_style( 'zc-editor-styles', $inline );
}

// ─────────────────────────────────────────────
// 5. ALLOWED BLOCK TYPES (OPTIONAL ADMIN CONTROL)
// ─────────────────────────────────────────────

add_filter( 'allowed_block_types_all', 'zc_allowed_block_types', 10, 2 );
function zc_allowed_block_types( $allowed_blocks, $editor_context ) {
    // Admin can restrict blocks — only apply if option is set
    $blocked_types = zc_option( 'editor_blocked_blocks', [] );
    if ( empty( $blocked_types ) || ! is_array( $blocked_types ) || true === $allowed_blocks ) {
        return $allowed_blocks;
    }
    if ( is_array( $allowed_blocks ) ) {
        return array_diff( $allowed_blocks, $blocked_types );
    }
    return $allowed_blocks;
}

// ─────────────────────────────────────────────
// 6. THEME.JSON GLOBAL STYLES HOOK
// ─────────────────────────────────────────────

add_filter( 'wp_theme_json_data_theme', 'zc_dynamic_theme_json' );
function zc_dynamic_theme_json( $theme_json ) {
    // Inject admin-chosen accent color into theme.json color palette at runtime
    $accent = zc_option( 'color_primary', '#7c6ff7' );
    if ( ! preg_match( '/^#[0-9a-fA-F]{6}$/', $accent ) ) $accent = '#7c6ff7';

    $new_data = [
        'version'  => 2,
        'settings' => [
            'color' => [
                'palette' => [
                    [ 'slug' => 'zc-primary', 'color' => $accent,   'name' => 'ZinCelestial Primary'  ],
                    [ 'slug' => 'zc-accent',  'color' => '#00d4ff', 'name' => 'ZinCelestial Accent'   ],
                ],
            ],
        ],
    ];

    return $theme_json->update_with( $new_data );
}

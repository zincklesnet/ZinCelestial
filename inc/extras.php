<?php
/**
 * ZinCelestial v5.1.0 — Extra Helper Functions
 *
 * BUG FIX #2 (CRITICAL): extras.php line 13 parse error caused by
 * literal backslash-escaped parameters (\$key, \$default) — now clean PHP.
 *
 * All functions guarded with function_exists() to prevent fatal errors
 * when this file is included multiple times or alongside admin-options.php.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ─── READ TIME ──────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_read_time' ) ) :
function zc_read_time( $post_id = 0 ) {
    $content    = get_post_field( 'post_content', $post_id ?: get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $mins       = max( 1, (int) ceil( $word_count / 200 ) );
    return sprintf( _n( '%d min read', '%d min read', $mins, ZC_TEXT ), $mins );
}
endif;

/* ─── VIEW COUNT ─────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_view_count' ) ) :
function zc_view_count( $post_id = 0 ) {
    $id    = $post_id ?: get_the_ID();
    $count = (int) get_post_meta( $id, '_zc_view_count', true );
    if ( ! is_admin() && is_singular() && get_the_ID() === $id ) {
        update_post_meta( $id, '_zc_view_count', $count + 1 );
    }
    return $count;
}
endif;

if ( ! function_exists( 'zc_view_count_formatted' ) ) :
function zc_view_count_formatted( $post_id = 0 ) {
    $n = zc_view_count( $post_id );
    if ( $n >= 1000000 ) return round( $n / 1000000, 1 ) . 'M';
    if ( $n >= 1000 )    return round( $n / 1000, 1 ) . 'K';
    return (string) $n;
}
endif;

/* ─── AVATAR HELPERS ─────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_get_avatar_url' ) ) :
function zc_get_avatar_url( $user_id = 0, $size = 60 ) {
    $uid = $user_id ?: get_current_user_id();
    // BuddyPress avatar takes precedence
    if ( function_exists( 'bp_core_fetch_avatar' ) ) {
        $url = bp_core_fetch_avatar([
            'item_id' => $uid,
            'type'    => 'full',
            'html'    => false,
        ]);
        if ( $url && ! str_contains( $url, 'mystery' ) ) return $url;
    }
    // Gravatar fallback
    $email = get_userdata( $uid )->user_email ?? '';
    $hash  = md5( strtolower( trim( $email ) ) );
    $default_avatar = zc_option( 'default_user_avatar', '' );
    $default_param  = $default_avatar ? urlencode( $default_avatar ) : 'identicon';
    return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default_param}";
}
endif;

if ( ! function_exists( 'zc_get_group_avatar_url' ) ) :
function zc_get_group_avatar_url( $group_id = 0, $size = 60 ) {
    if ( function_exists( 'bp_core_fetch_avatar' ) ) {
        $url = bp_core_fetch_avatar([
            'item_id'    => $group_id ?: ( function_exists( 'bp_get_current_group_id' ) ? bp_get_current_group_id() : 0 ),
            'object'     => 'group',
            'type'       => 'full',
            'html'       => false,
        ]);
        if ( $url ) return $url;
    }
    $default = zc_option( 'default_group_avatar', '' );
    return $default ?: '';
}
endif;

/* ─── ONLINE STATUS ──────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_is_user_online' ) ) :
function zc_is_user_online( $user_id ) {
    // BuddyPress provides bp_is_user_online()
    if ( function_exists( 'bp_is_user_online' ) ) {
        return bp_is_user_online( $user_id );
    }
    // Fallback: check last_activity user meta (set by many plugins)
    $last = get_user_meta( $user_id, 'last_activity', true );
    if ( ! $last ) return false;
    return ( time() - strtotime( $last ) ) < 300; // 5 minutes
}
endif;

if ( ! function_exists( 'zc_online_dot' ) ) :
/**
 * Returns HTML span for an online/offline indicator dot.
 * CSS classes: .zc-online-dot, .zc-online-dot--online, .zc-online-dot--offline
 */
function zc_online_dot( $user_id, $echo = true ) {
    if ( ! zc_option( 'show_online_indicator', '1' ) ) return '';
    $online = zc_is_user_online( $user_id );
    $cls    = $online ? 'zc-online-dot--online' : 'zc-online-dot--offline';
    $label  = $online ? esc_html__( 'Online', ZC_TEXT ) : esc_html__( 'Offline', ZC_TEXT );
    $html   = '<span class="zc-online-dot ' . esc_attr( $cls ) . '" title="' . esc_attr( $label ) . '"></span>';
    if ( $echo ) {
        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
        return '';
    }
    return $html;
}
endif;

/* ─── SHARING BAR ─────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_sharing_bar' ) ) :
function zc_sharing_bar( $post_id = 0 ) {
    if ( ! zc_option( 'show_share_bar', '1' ) ) return '';
    $id    = $post_id ?: get_the_ID();
    $url   = urlencode( get_permalink( $id ) );
    $title = urlencode( get_the_title( $id ) );

    $networks = [
        'twitter'   => [ 'label' => 'X (Twitter)', 'icon' => 'bi-twitter-x',   'href' => "https://twitter.com/intent/tweet?url={$url}&text={$title}" ],
        'facebook'  => [ 'label' => 'Facebook',    'icon' => 'bi-facebook',     'href' => "https://www.facebook.com/sharer/sharer.php?u={$url}" ],
        'linkedin'  => [ 'label' => 'LinkedIn',    'icon' => 'bi-linkedin',     'href' => "https://www.linkedin.com/sharing/share-offcanvas?url={$url}" ],
        'reddit'    => [ 'label' => 'Reddit',      'icon' => 'bi-reddit',       'href' => "https://reddit.com/submit?url={$url}&title={$title}" ],
        'copy'      => [ 'label' => 'Copy Link',   'icon' => 'bi-clipboard',    'href' => '#' ],
    ];

    ob_start();
    echo '<div class="zc-share-bar d-flex gap-2 align-items-center">';
    echo '<span class="zc-share-bar__label text-muted small">' . esc_html__( 'Share:', ZC_TEXT ) . '</span>';
    foreach ( $networks as $key => $net ) {
        $data_copy = ( $key === 'copy' ) ? ' data-zca-copy="' . esc_attr( get_permalink( $id ) ) . '"' : '';
        printf(
            '<a href="%s" class="zc-share-btn btn btn-sm btn-outline-secondary" target="_blank" rel="noopener noreferrer" title="%s"%s>'
            . '<i class="%s"></i></a>',
            esc_url( $net['href'] ),
            esc_attr( $net['label'] ),
            $data_copy,
            esc_attr( $net['icon'] )
        );
    }
    echo '</div>';
    return ob_get_clean();
}
endif;

/* ─── SCHEMA MARKUP ──────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_schema_article' ) ) :
function zc_schema_article( $post_id = 0 ) {
    if ( ! zc_option( 'enable_schema', '1' ) ) return;
    $id = $post_id ?: get_the_ID();
    if ( ! $id ) return;

    $post        = get_post( $id );
    $author_data = get_userdata( $post->post_author );
    $schema      = [
        '@context'        => 'https://schema.org',
        '@type'           => 'Article',
        'headline'        => get_the_title( $id ),
        'datePublished'   => get_the_date( 'c', $id ),
        'dateModified'    => get_the_modified_date( 'c', $id ),
        'author'          => [
            '@type' => 'Person',
            'name'  => $author_data ? $author_data->display_name : '',
            'url'   => $author_data ? get_author_posts_url( $post->post_author ) : '',
        ],
        'url'             => get_permalink( $id ),
        'description'     => wp_strip_all_tags( get_the_excerpt( $id ) ),
    ];

    if ( has_post_thumbnail( $id ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $id, 'large' );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n"; // phpcs:ignore
}
endif;

/* ─── VERIFIED BADGE ─────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_verified_badge' ) ) :
function zc_verified_badge( $user_id, $echo = true ) {
    if ( ! zc_option( 'show_verified_badge', '1' ) ) return '';
    $verified = get_user_meta( $user_id, 'zc_verified', true );
    if ( ! $verified ) return '';
    $html = '<span class="zc-verified-badge badge bg-primary ms-1" title="' . esc_attr__( 'Verified', ZC_TEXT ) . '">'
          . '<i class="bi bi-patch-check-fill"></i></span>';
    if ( $echo ) {
        echo $html; // phpcs:ignore
        return '';
    }
    return $html;
}
endif;

/* ─── BREADCRUMBS ─────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_breadcrumbs' ) ) :
function zc_breadcrumbs( $echo = true ) {
    $items = [];

    // Home
    $items[] = '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">'
             . '<i class="bi bi-house-fill me-1"></i>' . esc_html__( 'Home', ZC_TEXT ) . '</a></li>';

    if ( is_home() || is_front_page() ) {
        $items[] = '<li class="breadcrumb-item active">' . esc_html__( 'Blog', ZC_TEXT ) . '</li>';
    } elseif ( is_singular() ) {
        // Post type archive link
        $post_type = get_post_type();
        if ( $post_type && $post_type !== 'post' && $post_type !== 'page' ) {
            $pto = get_post_type_object( $post_type );
            if ( $pto && $pto->has_archive ) {
                $items[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '">'
                         . esc_html( $pto->labels->name ) . '</a></li>';
            }
        }
        // Category (for posts)
        if ( $post_type === 'post' ) {
            $cats = get_the_category();
            if ( $cats ) {
                $items[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">'
                         . esc_html( $cats[0]->name ) . '</a></li>';
            }
        }
        $items[] = '<li class="breadcrumb-item active">' . esc_html( get_the_title() ) . '</li>';

    } elseif ( is_archive() ) {
        if ( is_category() ) {
            $items[] = '<li class="breadcrumb-item active">' . esc_html( single_cat_title( '', false ) ) . '</li>';
        } elseif ( is_tag() ) {
            $items[] = '<li class="breadcrumb-item active">' . sprintf( esc_html__( 'Tag: %s', ZC_TEXT ), single_tag_title( '', false ) ) . '</li>';
        } elseif ( is_author() ) {
            $items[] = '<li class="breadcrumb-item active">' . sprintf( esc_html__( 'Author: %s', ZC_TEXT ), get_the_author() ) . '</li>';
        } elseif ( is_date() ) {
            $items[] = '<li class="breadcrumb-item active">' . get_the_date( 'F Y' ) . '</li>';
        } else {
            $items[] = '<li class="breadcrumb-item active">' . esc_html__( 'Archives', ZC_TEXT ) . '</li>';
        }
    } elseif ( is_search() ) {
        $items[] = '<li class="breadcrumb-item active">'
                 . sprintf( esc_html__( 'Search: %s', ZC_TEXT ), esc_html( get_search_query() ) ) . '</li>';
    } elseif ( is_404() ) {
        $items[] = '<li class="breadcrumb-item active">' . esc_html__( '404 — Page Not Found', ZC_TEXT ) . '</li>';
    }

    $html  = '<nav aria-label="' . esc_attr__( 'Breadcrumb', ZC_TEXT ) . '" class="zc-breadcrumb-nav">';
    $html .= '<ol class="breadcrumb mb-0">' . implode( '', $items ) . '</ol>';
    $html .= '</nav>';

    if ( $echo ) {
        echo $html; // phpcs:ignore
        return '';
    }
    return $html;
}
endif;

/* ─── BODY CLASSES ───────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_body_classes' ) ) :
function zc_body_classes( $classes ) {
    // Color scheme
    $scheme = zc_option( 'color_scheme', 'cosmic' );
    $classes[] = 'zc-scheme-' . sanitize_html_class( $scheme );

    // Layout
    $layout    = zc_option( 'site_layout', 'wide' );
    $classes[] = 'zc-layout-' . sanitize_html_class( $layout );

    // Sidebar position
    $sidebar_pos = zc_option( 'sidebar_position', 'right' );
    $classes[] = 'zc-sidebar-' . sanitize_html_class( $sidebar_pos );

    // Header style
    $header_style = zc_option( 'header_style', 'standard' );
    $classes[] = 'zc-header-' . sanitize_html_class( $header_style );

    // BuddyPress
    if ( function_exists( 'buddypress' ) ) {
        $classes[] = 'zc-has-buddypress';
        if ( function_exists( 'bp_is_user' ) && bp_is_user() )    $classes[] = 'zc-bp-member';
        if ( function_exists( 'bp_is_group' ) && bp_is_group() )   $classes[] = 'zc-bp-group';
        if ( function_exists( 'bp_is_activity_component' ) && bp_is_activity_component() ) $classes[] = 'zc-bp-activity';
    }

    // WooCommerce
    if ( class_exists( 'WooCommerce' ) ) {
        $classes[] = 'zc-has-woocommerce';
    }

    // bbPress
    if ( class_exists( 'bbPress' ) ) {
        $classes[] = 'zc-has-bbpress';
    }

    // Genesis admin active
    if ( defined( 'ZC_GENESIS_ADMIN_ACTIVE' ) && ZC_GENESIS_ADMIN_ACTIVE ) {
        $classes[] = 'zc-genesis-active';
    }

    return $classes;
}
add_filter( 'body_class', 'zc_body_classes' );
endif;

/* ─── EXCERPT ─────────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_excerpt_length' ) ) :
function zc_excerpt_length( $length ) {
    return (int) zc_option( 'excerpt_length', 30 );
}
add_filter( 'excerpt_length', 'zc_excerpt_length' );
endif;

if ( ! function_exists( 'zc_excerpt_more' ) ) :
function zc_excerpt_more( $more ) {
    return '&hellip; <a href="' . esc_url( get_permalink() ) . '" class="zc-read-more">'
         . esc_html__( 'Read More', ZC_TEXT ) . '</a>';
}
add_filter( 'excerpt_more', 'zc_excerpt_more' );
endif;

/* ─── LAZY LOAD ──────────────────────────────────────────────────────────── */

if ( ! function_exists( 'zc_lazy_load_attr' ) ) :
function zc_lazy_load_attr( $attr ) {
    if ( zc_option( 'enable_lazy_load', '1' ) ) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'zc_lazy_load_attr' );
endif;

/* ─── TEMPLATE TAG HELPERS ───────────────────────────────────────────────── */

if ( ! function_exists( 'zc_posted_on' ) ) :
function zc_posted_on() {
    $time = sprintf(
        '<time class="entry-date published" datetime="%1$s"><i class="bi bi-calendar3 me-1"></i>%2$s</time>',
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );
    echo '<span class="zc-posted-on">' . $time . '</span>'; // phpcs:ignore
}
endif;

if ( ! function_exists( 'zc_posted_by' ) ) :
function zc_posted_by() {
    printf(
        '<span class="zc-posted-by"><i class="bi bi-person-fill me-1"></i><a href="%s" rel="author">%s</a></span>',
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_html( get_the_author() )
    );
}
endif;

/* ─── PLUGIN COMPAT STUBS ─────────────────────────────────────────────────── */
// These stubs prevent fatal errors when BP/WC/bbP are not active.
// They're empty no-ops — the actual plugin provides real implementations.

if ( ! function_exists( 'bp_content' ) ) :
function bp_content() {
    // BuddyPress not active — output nothing
    echo '<div class="zc-plugin-inactive alert alert-info">'
       . esc_html__( 'BuddyPress is not currently active.', ZC_TEXT )
       . '</div>';
}
endif;

if ( ! function_exists( 'bp_is_user' ) )  : function bp_is_user()  { return false; } endif;
if ( ! function_exists( 'bp_is_group' ) ) : function bp_is_group() { return false; } endif;
if ( ! function_exists( 'bp_is_activity_component' ) ) : function bp_is_activity_component() { return false; } endif;
if ( ! function_exists( 'bp_get_current_user_id' ) )  : function bp_get_current_user_id()    { return get_current_user_id(); } endif;
if ( ! function_exists( 'bp_is_active' ) ) : function bp_is_active( $component = '' ) { return false; } endif;

if ( ! function_exists( 'wc_get_cart_url' ) )     : function wc_get_cart_url()     { return home_url( '/cart/' ); } endif;
if ( ! function_exists( 'wc_get_checkout_url' ) ) : function wc_get_checkout_url() { return home_url( '/checkout/' ); } endif;
if ( ! function_exists( 'woocommerce_mini_cart' ) ) : function woocommerce_mini_cart() { echo '<p>' . esc_html__( 'WooCommerce not active.', ZC_TEXT ) . '</p>'; } endif;

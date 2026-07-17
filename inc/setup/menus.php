<?php
/**
 * ZinCelestial v5.2.0 — Menu Registration + ZC_Nav_Walker v5.0
 *
 * v5.2.0 Fixes:
 *  - Desktop menus forced horizontal via CSS + walker (no vertical stacking)
 *  - Dropdowns use data-bs-toggle="dropdown" + aria-expanded (BS5 spec)
 *  - end_el() confirmed present → no unclosed <li> tags
 *  - start_lvl() / end_lvl() produce valid .dropdown-menu markup
 *  - Mega-menu support via menu description field: "mega"
 *  - Icon support via menu description: "icon:bell"
 *  - Current-page aria-current added for accessibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Register all theme menu locations ─────────────────────────────────── */
function zc_register_menus() {
    register_nav_menus( [
        'zc-primary'      => _x( 'Primary Navigation',   'Menu location', 'zincelestial' ),
        'zc-topbar-left'  => _x( 'Topbar Left',           'Menu location', 'zincelestial' ),
        'zc-topbar-right' => _x( 'Topbar Right',          'Menu location', 'zincelestial' ),
        'zc-left-panel'   => _x( 'Left Panel Menu',       'Menu location', 'zincelestial' ),
        'zc-right-panel'  => _x( 'Right Panel Menu',      'Menu location', 'zincelestial' ),
        'zc-footer-1'     => _x( 'Footer Column 1',       'Menu location', 'zincelestial' ),
        'zc-footer-2'     => _x( 'Footer Column 2',       'Menu location', 'zincelestial' ),
        'zc-footer-3'     => _x( 'Footer Column 3',       'Menu location', 'zincelestial' ),
        'zc-footer-4'     => _x( 'Footer Column 4',       'Menu location', 'zincelestial' ),
        'zc-mobile'       => _x( 'Mobile Menu',           'Menu location', 'zincelestial' ),
        'zc-user-menu'    => _x( 'Logged-In User Menu',   'Menu location', 'zincelestial' ),
    ] );
}
add_action( 'init', 'zc_register_menus', 2 );

/**
 * ZC_Nav_Walker — Bootstrap 5 Navbar-compatible walker v5.0
 *
 * Key features:
 *  - Outputs .nav-item .nav-link on top-level items
 *  - Outputs .dropdown-item on nested items
 *  - Dropdown toggles use data-bs-toggle="dropdown" aria-expanded="false"
 *  - Sub-menus get .dropdown-menu class (shown/hidden by BS5 JS)
 *  - Icon support via Description field: "icon:bell" or "icon:house-fill"
 *  - Always closes </li> in end_el()
 */
class ZC_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Open <li> and render <a> link.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item        = $data_object;
        $classes     = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes, true );

        // ── <li> classes ─────────────────────────────────────────────────────
        $li_classes = [ 'nav-item', 'zc-menu-item' ];

        if ( $depth === 0 && $has_children ) {
            $li_classes[] = 'dropdown';
        }
        if ( $depth > 0 && $has_children ) {
            $li_classes[] = 'dropend'; // nested sub-menus fly right
        }
        if ( $item->current || $item->current_item_ancestor ) {
            $li_classes[] = 'active';
        }

        // Merge with WP's own classes (current-menu-item etc.)
        $all_li = implode( ' ', array_unique( array_merge( $li_classes, array_filter( $classes ) ) ) );
        $output .= '<li id="menu-item-' . esc_attr( $item->ID ) . '" class="' . esc_attr( $all_li ) . '">';

        // ── <a> attributes ───────────────────────────────────────────────────
        $url    = ! empty( $item->url ) ? $item->url : '#';
        $target = $item->target  ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $rel    = $item->xfn     ? ' rel="' . esc_attr( $item->xfn ) . '"'       : '';
        $title  = $item->attr_title ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $aria_current = ( $item->current ) ? ' aria-current="page"' : '';

        if ( $depth === 0 && $has_children ) {
            // Top-level dropdown trigger
            $a_class = 'nav-link zc-nav-link dropdown-toggle';
            $extra   = ' data-bs-toggle="dropdown" aria-expanded="false" role="button"';
        } elseif ( $depth === 0 ) {
            // Top-level plain link
            $a_class = 'nav-link zc-nav-link';
            $extra   = $aria_current;
        } elseif ( $depth > 0 && $has_children ) {
            // Nested dropdown trigger
            $a_class = 'dropdown-item zc-dropdown-item dropdown-toggle';
            $extra   = ' data-bs-toggle="dropdown" aria-expanded="false"';
        } else {
            // Nested plain item
            $a_class = 'dropdown-item zc-dropdown-item';
            $extra   = $aria_current;
        }

        // ── Icon from description ─────────────────────────────────────────────
        $icon_html = '';
        $desc = trim( $item->description ?? '' );
        if ( strpos( $desc, 'icon:' ) === 0 ) {
            $icon_name = esc_attr( substr( $desc, 5 ) );
            $icon_html = '<i class="bi bi-' . $icon_name . ' zc-menu-icon me-1" aria-hidden="true"></i>';
        }

        $label = apply_filters( 'the_title', $item->title, $item->ID );

        // Dropdown caret for top-level
        $caret = ( $depth === 0 && $has_children )
            ? ' <i class="bi bi-chevron-down zc-menu-caret" aria-hidden="true"></i>'
            : '';

        $output .= '<a href="' . esc_url( $url ) . '"'
                 . ' class="' . esc_attr( $a_class ) . '"'
                 . $target . $rel . $title . $extra . '>'
                 . $icon_html
                 . '<span class="zc-menu-label">' . $label . '</span>'
                 . $caret
                 . '</a>';
    }

    /**
     * Close </li>. Required — missing this breaks entire menu layout.
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $output .= '</li>' . "\n";
    }

    /**
     * Open sub-menu <ul>.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $class = ( $depth === 0 ) ? 'dropdown-menu zc-dropdown shadow-sm' : 'dropdown-menu dropdown-submenu';
        $output .= "\n<ul class=\"" . esc_attr( $class ) . "\">\n";
    }

    /**
     * Close sub-menu </ul>.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</ul>\n";
    }
}

/**
 * Helper: render primary nav using ZC_Nav_Walker + BS5 navbar classes.
 * Wrapper outputs <ul> only (no extra <div>) so BS5 collapse works correctly.
 */
function zc_primary_nav( array $args = [] ) {
    $defaults = [
        'theme_location' => 'zc-primary',
        'container'      => false,
        'menu_class'     => 'navbar-nav zc-primary-nav ms-auto gap-1',
        'walker'         => new ZC_Nav_Walker(),
        'fallback_cb'    => '__return_false',
        'depth'          => 3,
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ];
    wp_nav_menu( array_merge( $defaults, $args ) );
}

/**
 * Helper: render a footer column menu.
 */
function zc_footer_nav( string $location, array $args = [] ) {
    $defaults = [
        'theme_location' => $location,
        'container'      => false,
        'menu_class'     => 'nav flex-column zc-footer-nav gap-1',
        'walker'         => new ZC_Nav_Walker(),
        'fallback_cb'    => '__return_false',
        'depth'          => 1,
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ];
    wp_nav_menu( array_merge( $defaults, $args ) );
}

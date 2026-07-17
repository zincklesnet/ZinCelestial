<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ZinCelestial Category Colors v4.3
 * - Adds color picker to category + post_tag taxonomies
 * - Frontend display via CSS custom properties
 * - Multisite synced via site_option
 */
class ZC_Category_Colors {
    const META_KEY = 'zc_term_color';

    public static function init() {
        // Add color field to categories and tags
        foreach ( [ 'category', 'post_tag', 'product_cat', 'bp_group_type' ] as $tax ) {
            add_action( "{$tax}_add_form_fields",  [ __CLASS__, 'add_form_field' ] );
            add_action( "{$tax}_edit_form_fields", [ __CLASS__, 'edit_form_field' ] );
            add_action( "created_{$tax}",          [ __CLASS__, 'save_field' ] );
            add_action( "edited_{$tax}",           [ __CLASS__, 'save_field' ] );
        }
        // Pages need categories via custom taxonomy
        add_action( 'init', [ __CLASS__, 'register_page_category' ] );
        // Frontend: output color CSS
        add_action( 'wp_head', [ __CLASS__, 'output_color_css' ], 20 );
        // Add color column to term list tables
        add_filter( 'manage_edit-category_columns',  [ __CLASS__, 'add_column' ] );
        add_filter( 'manage_edit-post_tag_columns',  [ __CLASS__, 'add_column' ] );
        add_action( 'manage_category_custom_column', [ __CLASS__, 'render_column' ], 10, 3 );
        add_action( 'manage_post_tag_custom_column', [ __CLASS__, 'render_column' ], 10, 3 );
        // Multisite sync on save
        add_action( 'saved_term', [ __CLASS__, 'sync_multisite' ], 10, 3 );
        // Shortcode to display colored category badges
        add_shortcode( 'zc_category_badge', [ __CLASS__, 'shortcode_badge' ] );
    }

    public static function register_page_category() {
        if ( ! taxonomy_exists( 'page_category' ) ) {
            register_taxonomy( 'page_category', 'page', [
                'label'        => __( 'Page Categories', 'zincelestial' ),
                'hierarchical' => true,
                'show_ui'      => true,
                'show_in_menu' => true,
                'rewrite'      => [ 'slug' => 'page-category' ],
                'show_admin_column' => true,
            ] );
        }
        if ( ! taxonomy_exists( 'page_tag' ) ) {
            register_taxonomy( 'page_tag', 'page', [
                'label'        => __( 'Page Tags', 'zincelestial' ),
                'hierarchical' => false,
                'show_ui'      => true,
                'show_in_menu' => true,
                'rewrite'      => [ 'slug' => 'page-tag' ],
                'show_admin_column' => true,
            ] );
        }
    }

    public static function add_form_field( $taxonomy ) {
        ?>
        <div class="form-field term-color-wrap">
          <label for="zc_term_color"><?php esc_html_e( 'Category Color', 'zincelestial' ); ?></label>
          <input type="color" name="zc_term_color" id="zc_term_color" value="#7c6ff7" style="height:38px;width:60px;padding:2px;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
          <p class="description"><?php esc_html_e( 'Pick a color for this category. Displayed on frontend as badges, borders, and highlights.', 'zincelestial' ); ?></p>
        </div>
        <?php
    }

    public static function edit_form_field( $term ) {
        $color = get_term_meta( $term->term_id, self::META_KEY, true ) ?: '#7c6ff7';
        ?>
        <tr class="form-field term-color-wrap">
          <th><label for="zc_term_color"><?php esc_html_e( 'Category Color', 'zincelestial' ); ?></label></th>
          <td>
            <input type="color" name="zc_term_color" id="zc_term_color" value="<?php echo esc_attr( $color ); ?>"
                   style="height:38px;width:60px;padding:2px;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
            <div style="width:30px;height:30px;border-radius:50%;background:<?php echo esc_attr( $color ); ?>;display:inline-block;vertical-align:middle;margin-left:8px;border:2px solid rgba(0,0,0,.1);"></div>
            <p class="description"><?php esc_html_e( 'Displayed on frontend as colored badges, borders, and category highlights.', 'zincelestial' ); ?></p>
          </td>
        </tr>
        <?php
    }

    public static function save_field( $term_id ) {
        if ( ! isset( $_POST['zc_term_color'] ) ) return;
        $color = sanitize_hex_color( $_POST['zc_term_color'] ) ?: '#7c6ff7';
        update_term_meta( $term_id, self::META_KEY, $color );
    }

    public static function sync_multisite( $term_id, $tt_id, $taxonomy ) {
        if ( ! is_multisite() ) return;
        $color = get_term_meta( $term_id, self::META_KEY, true );
        if ( ! $color ) return;
        // Store in network-wide option for cross-site access
        $network_colors = get_site_option( 'zc_term_colors', [] );
        $network_colors[ $term_id ] = [
            'color'    => $color,
            'taxonomy' => $taxonomy,
            'blog_id'  => get_current_blog_id(),
        ];
        update_site_option( 'zc_term_colors', $network_colors );
    }

    public static function output_color_css() {
        global $wp_query;
        $terms = [];
        // Collect all terms on the current page
        $post_id = get_queried_object_id();
        if ( $post_id ) {
            $post_terms = wp_get_post_terms( $post_id, [ 'category', 'post_tag', 'page_category', 'page_tag', 'product_cat' ], [ 'fields' => 'all' ] );
            if ( ! is_wp_error( $post_terms ) ) {
                $terms = array_merge( $terms, $post_terms );
            }
        }
        // Add queried object (archive pages)
        $q = get_queried_object();
        if ( $q instanceof WP_Term ) $terms[] = $q;

        if ( empty( $terms ) ) return;

        echo '<style id="zc-term-colors">';
        foreach ( $terms as $term ) {
            $color = get_term_meta( $term->term_id, self::META_KEY, true );
            if ( ! $color ) continue;
            $slug  = esc_attr( $term->slug );
            // CSS custom property per term
            echo ".zc-term-{$slug} { --zc-term-color: {$color}; }";
            echo ".zc-cat-badge[data-term=\"{$slug}\"] { background-color: {$color}; }";
            echo ".zc-cat-label[data-term=\"{$slug}\"] { color: {$color}; border-color: {$color}; }";
        }
        echo '</style>';
    }

    public static function add_column( $columns ) {
        $columns['zc_color'] = __( 'Color', 'zincelestial' );
        return $columns;
    }

    public static function render_column( $content, $column, $term_id ) {
        if ( $column !== 'zc_color' ) return;
        $color = get_term_meta( $term_id, self::META_KEY, true ) ?: '#cccccc';
        echo '<div style="width:24px;height:24px;border-radius:50%;background:' . esc_attr( $color ) . ';border:2px solid rgba(0,0,0,.15);display:inline-block;" title="' . esc_attr( $color ) . '"></div>';
        echo ' <small style="color:#666;">' . esc_html( $color ) . '</small>';
    }

    public static function shortcode_badge( $atts ) {
        $atts = shortcode_atts( [ 'post_id' => get_the_ID(), 'taxonomy' => 'category', 'link' => 'yes' ], $atts, 'zc_category_badge' );
        $terms = wp_get_post_terms( (int)$atts['post_id'], $atts['taxonomy'] );
        if ( is_wp_error( $terms ) || empty( $terms ) ) return '';
        $out = '<span class="zc-cat-badges">';
        foreach ( $terms as $term ) {
            $color = get_term_meta( $term->term_id, self::META_KEY, true ) ?: '#7c6ff7';
            $badge = '<span class="zc-cat-badge" data-term="' . esc_attr( $term->slug ) . '" '
                   . 'style="background:' . esc_attr( $color ) . ';color:#fff;padding:2px 10px;border-radius:20px;font-size:.75rem;font-weight:600;display:inline-block;margin:2px;">';
            if ( $atts['link'] === 'yes' ) {
                $badge .= '<a href="' . esc_url( get_term_link( $term ) ) . '" style="color:inherit;text-decoration:none;">' . esc_html( $term->name ) . '</a>';
            } else {
                $badge .= esc_html( $term->name );
            }
            $badge .= '</span>';
            $out   .= $badge;
        }
        $out .= '</span>';
        return $out;
    }
}

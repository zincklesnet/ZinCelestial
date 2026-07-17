<?php
/**
 * ZinCelestial v3.0 — Featured Image Position Options
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ZC_Featured_Image_Position {

    public function __construct() {
        add_action( 'add_meta_boxes',        [ $this, 'add_meta_box' ] );
        add_action( 'save_post',             [ $this, 'save_meta' ], 10, 2 );
        add_filter( 'post_class',            [ $this, 'post_class' ], 10, 3 );
        add_filter( 'the_content',           [ $this, 'maybe_hide_featured' ], 8 );
    }

    public function add_meta_box() {
        add_meta_box(
            'zc_featured_image_position',
            esc_html__( 'Featured Image Options', 'zincelestial' ),
            [ $this, 'render_meta_box' ],
            [ 'post', 'page' ],
            'side',
            'low'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'zc_fi_pos', 'zc_fi_pos_nonce' );
        $position = get_post_meta( $post->ID, '_zc_fi_position', true ) ?: 'default';
        $hide_on_single = get_post_meta( $post->ID, '_zc_fi_hide_single', true );
        ?>
        <p>
            <label for="zc_fi_position" style="display:block;font-weight:600;margin-bottom:.3rem"><?php esc_html_e( 'Position', 'zincelestial' ); ?></label>
            <select name="zc_fi_position" id="zc_fi_position" style="width:100%">
                <option value="default" <?php selected( $position, 'default' ); ?>><?php esc_html_e( 'Default (Above Content)', 'zincelestial' ); ?></option>
                <option value="behind-title" <?php selected( $position, 'behind-title' ); ?>><?php esc_html_e( 'Full-Width Behind Title', 'zincelestial' ); ?></option>
                <option value="full-bleed" <?php selected( $position, 'full-bleed' ); ?>><?php esc_html_e( 'Full-Bleed Header', 'zincelestial' ); ?></option>
                <option value="sidebar" <?php selected( $position, 'sidebar' ); ?>><?php esc_html_e( 'In Sidebar', 'zincelestial' ); ?></option>
                <option value="none" <?php selected( $position, 'none' ); ?>><?php esc_html_e( 'Hidden', 'zincelestial' ); ?></option>
            </select>
        </p>
        <p>
            <label>
                <input type="checkbox" name="zc_fi_hide_single" value="1" <?php checked( 1, $hide_on_single ); ?>>
                <?php esc_html_e( 'Hide on single post page', 'zincelestial' ); ?>
            </label>
        </p>
        <?php
    }

    public function save_meta( $post_id, $post ) {
        if ( ! isset( $_POST['zc_fi_pos_nonce'] ) || ! wp_verify_nonce( $_POST['zc_fi_pos_nonce'], 'zc_fi_pos' ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        $allowed_positions = [ 'default', 'behind-title', 'full-bleed', 'sidebar', 'none' ];
        $pos = sanitize_key( $_POST['zc_fi_position'] ?? 'default' );
        if ( in_array( $pos, $allowed_positions, true ) ) {
            update_post_meta( $post_id, '_zc_fi_position', $pos );
        }
        update_post_meta( $post_id, '_zc_fi_hide_single', isset( $_POST['zc_fi_hide_single'] ) ? 1 : 0 );
    }

    public function post_class( $classes, $class, $post_id ) {
        $position = get_post_meta( $post_id, '_zc_fi_position', true );
        if ( $position ) {
            $classes[] = 'zc-fi-' . sanitize_html_class( $position );
        }
        return $classes;
    }

    public function maybe_hide_featured( $content ) {
        if ( ! is_singular() ) return $content;
        $post_id = get_the_ID();
        if ( get_post_meta( $post_id, '_zc_fi_hide_single', true ) ) {
            add_filter( 'zc_show_featured_image', '__return_false' );
        }
        $position = get_post_meta( $post_id, '_zc_fi_position', true );
        if ( $position === 'none' ) {
            add_filter( 'zc_show_featured_image', '__return_false' );
        }
        return $content;
    }
}

new ZC_Featured_Image_Position();

/**
 * Helper: get the featured image position for a post
 */
function zc_get_fi_position( $post_id = 0 ) {
    return get_post_meta( $post_id ?: get_the_ID(), '_zc_fi_position', true ) ?: 'default';
}

/**
 * Helper: should we show featured image on this page?
 */
function zc_show_featured_image() {
    return apply_filters( 'zc_show_featured_image', true );
}

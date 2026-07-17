<?php
/**
 * ZinCelestial — PeepSo Single Layout Page Template
 *
 * Template Name: PeepSo Single Layout
 *
 * Used by PeepSo to render activity, profile, and community pages
 * without a sidebar — full-width PeepSo stream layout.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<div id="zc-wrap" class="zc-wrap zc-peepso-wrap zc-peepso-single">

    <?php do_action( 'zc_before_main_content' ); ?>

    <!-- Compose Bar (PeepSo) -->
    <?php if ( zc_option( 'compose_bar_enable', true ) && is_user_logged_in() ) : ?>
        <?php get_template_part( 'template-parts/global/compose-bar' ); ?>
    <?php endif; ?>

    <div class="zc-container zc-container--wide">

        <div class="zc-peepso-layout">

            <!-- ── Left: User sidebar ── -->
            <aside class="zc-peepso-sidebar zc-peepso-sidebar--left">
                <?php do_action( 'zc_peepso_sidebar_before' ); ?>
                <?php if ( class_exists( 'PeepSo' ) ) : ?>
                    <?php PeepSo::action( 'peepso_sidebar_left' ); ?>
                <?php else : ?>
                    <?php dynamic_sidebar( 'zc-peepso-left' ); ?>
                <?php endif; ?>
                <?php do_action( 'zc_peepso_sidebar_after' ); ?>
            </aside>

            <!-- ── Main Stream ── -->
            <main id="zc-main" class="zc-main zc-peepso-main" role="main">
                <?php do_action( 'zc_before_peepso_content' ); ?>

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div class="zc-peepso-content entry-content">
                        <?php
                        the_content();
                        wp_link_pages();
                        ?>
                    </div>
                <?php endwhile; endif; ?>

                <?php do_action( 'zc_after_peepso_content' ); ?>
            </main><!-- #zc-main -->

            <!-- ── Right: Trending/Suggestions ── -->
            <?php if ( zc_option( 'peepso_right_sidebar', true ) ) : ?>
                <aside class="zc-peepso-sidebar zc-peepso-sidebar--right">
                    <?php do_action( 'zc_peepso_right_sidebar_before' ); ?>
                    <?php if ( class_exists( 'PeepSo' ) ) : ?>
                        <?php PeepSo::action( 'peepso_sidebar_right' ); ?>
                    <?php else : ?>
                        <?php dynamic_sidebar( 'zc-peepso-right' ); ?>
                    <?php endif; ?>
                    <?php do_action( 'zc_peepso_right_sidebar_after' ); ?>
                </aside>
            <?php endif; ?>

        </div><!-- .zc-peepso-layout -->
    </div><!-- .zc-container--wide -->

    <?php do_action( 'zc_after_main_content' ); ?>

</div><!-- #zc-wrap -->

<?php get_footer(); ?>

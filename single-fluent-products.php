<?php
/**
 * ZinCelestial — Single FluentCart Product Template
 *
 * Template for single FluentCart / FluentCommerce product pages.
 *
 * @package ZinCelestial
 * @since   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<div id="zc-wrap" class="zc-wrap zc-single-product zc-fluent-product">

    <?php do_action( 'zc_before_main_content' ); ?>

    <div class="zc-container">
        <div class="zc-row">

            <?php if ( zc_option( 'fluent_product_sidebar_left', false ) ) : ?>
                <aside id="zc-sidebar-left" class="zc-sidebar zc-sidebar-left" role="complementary">
                    <?php dynamic_sidebar( 'zc-sidebar-left' ); ?>
                </aside>
            <?php endif; ?>

            <main id="zc-main" class="zc-main" role="main">

                <?php do_action( 'zc_before_fluent_product' ); ?>

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'zc-product-article zc-card' ); ?>>

                        <!-- ── Product Gallery ── -->
                        <div class="zc-product-gallery">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="zc-product-main-image">
                                    <?php the_post_thumbnail( 'large', [ 'class' => 'zc-product-img', 'loading' => 'eager' ] ); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ── Product Info ── -->
                        <div class="zc-product-info">

                            <!-- Breadcrumb -->
                            <nav class="zc-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'zincelestial' ); ?>">
                                <a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'zincelestial' ); ?></a>
                                <span class="zc-bc-sep" aria-hidden="true">›</span>
                                <a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>"><?php esc_html_e( 'Products', 'zincelestial' ); ?></a>
                                <span class="zc-bc-sep" aria-hidden="true">›</span>
                                <span aria-current="page"><?php the_title(); ?></span>
                            </nav>

                            <h1 class="zc-product-title entry-title"><?php the_title(); ?></h1>

                            <!-- Price (FluentCart hooks) -->
                            <div class="zc-product-price">
                                <?php do_action( 'fluentcommerce_product_price' ); ?>
                            </div>

                            <!-- Short description / excerpt -->
                            <?php if ( has_excerpt() ) : ?>
                                <div class="zc-product-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Add to Cart form -->
                            <div class="zc-product-actions">
                                <?php do_action( 'fluentcommerce_add_to_cart' ); ?>
                            </div>

                            <!-- Product meta -->
                            <div class="zc-product-meta">
                                <?php
                                $terms = get_the_terms( get_the_ID(), 'product_category' );
                                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
                                    $cats = wp_list_pluck( $terms, 'name' );
                                ?>
                                    <span class="zc-meta-item">
                                        <strong><?php esc_html_e( 'Category:', 'zincelestial' ); ?></strong>
                                        <?php echo esc_html( implode( ', ', $cats ) ); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="zc-meta-item">
                                    <strong><?php esc_html_e( 'SKU:', 'zincelestial' ); ?></strong>
                                    <?php echo esc_html( get_post_meta( get_the_ID(), '_sku', true ) ?: '—' ); ?>
                                </span>
                            </div>

                            <!-- Social share -->
                            <?php if ( zc_option( 'product_share_bar', true ) ) : ?>
                                <div class="zc-product-share">
                                    <?php do_action( 'zc_sharing_bar' ); ?>
                                </div>
                            <?php endif; ?>

                        </div><!-- .zc-product-info -->

                    </article><!-- .zc-product-article -->

                    <!-- ── Tabs: Description / Reviews / Related ── -->
                    <div class="zc-product-tabs zc-card">
                        <nav class="zc-tabs-nav" role="tablist">
                            <button class="zc-tab-btn zc-tab-active" data-tab="description" role="tab" aria-selected="true">
                                <?php esc_html_e( 'Description', 'zincelestial' ); ?>
                            </button>
                            <button class="zc-tab-btn" data-tab="reviews" role="tab" aria-selected="false">
                                <?php esc_html_e( 'Reviews', 'zincelestial' ); ?>
                            </button>
                            <button class="zc-tab-btn" data-tab="shipping" role="tab" aria-selected="false">
                                <?php esc_html_e( 'Shipping', 'zincelestial' ); ?>
                            </button>
                        </nav>

                        <div id="tab-description" class="zc-tab-panel zc-tab-panel--active" role="tabpanel">
                            <div class="entry-content zc-product-description"><?php the_content(); ?></div>
                        </div>

                        <div id="tab-reviews" class="zc-tab-panel" role="tabpanel" hidden>
                            <?php do_action( 'fluentcommerce_product_reviews' ); ?>
                            <?php comments_template(); ?>
                        </div>

                        <div id="tab-shipping" class="zc-tab-panel" role="tabpanel" hidden>
                            <?php
                            $shipping_info = get_post_meta( get_the_ID(), '_shipping_info', true );
                            echo $shipping_info ? wp_kses_post( $shipping_info ) : '<p>' . esc_html__( 'Standard shipping rates apply.', 'zincelestial' ) . '</p>';
                            ?>
                        </div>
                    </div><!-- .zc-product-tabs -->

                    <!-- ── Related Products ── -->
                    <div class="zc-related-products">
                        <h2 class="zc-section-title"><?php esc_html_e( 'Related Products', 'zincelestial' ); ?></h2>
                        <?php do_action( 'fluentcommerce_related_products' ); ?>
                    </div>

                <?php endwhile; endif; ?>

                <?php do_action( 'zc_after_fluent_product' ); ?>

            </main><!-- #zc-main -->

            <?php get_sidebar(); ?>

        </div><!-- .zc-row -->
    </div><!-- .zc-container -->

    <?php do_action( 'zc_after_main_content' ); ?>

</div><!-- #zc-wrap -->

<?php get_footer(); ?>

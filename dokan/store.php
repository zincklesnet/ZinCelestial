<?php
/**
 * ZinCelestial — Dokan Store/Vendor Page Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-dokan-store" class="zc-dokan-wrap zc-dokan-store-page">
	<div class="zc-container">

		<?php if ( function_exists( 'dokan_get_store_info' ) ) :
			$store_user   = get_userdata( get_query_var( 'author' ) );
			$store_info   = dokan_get_store_info( $store_user->ID );
			$store_name   = isset( $store_info['store_name'] ) ? $store_info['store_name'] : $store_user->display_name;
			$store_banner = isset( $store_info['banner'] ) ? $store_info['banner'] : '';
			$store_logo   = get_avatar_url( $store_user->ID, [ 'size' => 80 ] );
		?>

		<!-- Store Header -->
		<div class="zc-dokan-store__header">
			<?php if ( $store_banner ) : ?>
				<div class="zc-dokan-store__banner">
					<img src="<?php echo esc_url( $store_banner ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" loading="lazy" class="zc-dokan-store__banner-img">
				</div>
			<?php endif; ?>
			<div class="zc-dokan-store__info">
				<img src="<?php echo esc_url( $store_logo ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" class="zc-dokan-store__logo zc-avatar">
				<div class="zc-dokan-store__meta">
					<h1 class="zc-dokan-store__name"><?php echo esc_html( $store_name ); ?></h1>
					<?php if ( ! empty( $store_info['location'] ) ) : ?>
						<p class="zc-dokan-store__location">
							<i class="zc-icon zc-icon--map-pin" aria-hidden="true"></i>
							<?php echo esc_html( $store_info['location'] ); ?>
						</p>
					<?php endif; ?>
					<?php do_action( 'dokan_store_header_info_fields', $store_user->ID ); ?>
				</div>
			</div>
		</div>

		<!-- Store Tabs -->
		<div class="zc-dokan-store__tabs">
			<nav class="zc-dokan-store__tab-nav" role="tablist">
				<a class="zc-dokan-store__tab is-active" href="#products" role="tab">
					<i class="zc-icon zc-icon--package" aria-hidden="true"></i>
					<?php esc_html_e( 'Products', 'zincelestial' ); ?>
				</a>
				<a class="zc-dokan-store__tab" href="<?php echo esc_url( dokan_get_store_url( $store_user->ID ) . 'reviews/' ); ?>">
					<i class="zc-icon zc-icon--star" aria-hidden="true"></i>
					<?php esc_html_e( 'Reviews', 'zincelestial' ); ?>
				</a>
				<?php do_action( 'dokan_store_tab', $store_user ); ?>
			</nav>
		</div>

		<!-- Products Grid -->
		<div id="products" class="zc-dokan-store__products">
			<?php
			$paged    = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
			$products = new WP_Query( [
				'post_type'      => 'product',
				'author'         => $store_user->ID,
				'posts_per_page' => apply_filters( 'dokan_store_product_count', 12 ),
				'paged'          => $paged,
				'post_status'    => 'publish',
			] );

			if ( $products->have_posts() ) :
				echo '<ul class="zc-woo-products-grid products">';
				while ( $products->have_posts() ) : $products->the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				echo '</ul>';
				wp_reset_postdata();
				echo '<div class="zc-bp-pagination">' . paginate_links( [
					'total'   => $products->max_num_pages,
					'current' => $paged,
				] ) . '</div>';
			else :
				echo '<div class="zc-bp-empty"><p>' . esc_html__( 'No products found.', 'zincelestial' ) . '</p></div>';
			endif;
			?>
		</div>

		<?php else : ?>
			<div class="zc-bp-empty">
				<p><?php esc_html_e( 'Store not found.', 'zincelestial' ); ?></p>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php get_footer();

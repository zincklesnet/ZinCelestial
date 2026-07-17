<?php
/**
 * ZinCelestial — WooCommerce Cart Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>
<div class="zc-woo-cart" id="zc-woo-cart">
	<h1 class="zc-woo-cart__title"><?php esc_html_e( 'Shopping Cart', 'zincelestial' ); ?></h1>

	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<div class="zc-woo-cart__table-wrap">
			<table class="zc-woo-cart__table shop_table shop_table_responsive cart woocommerce-cart-form__contents">
				<thead>
					<tr>
						<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'zincelestial' ); ?></span></th>
						<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail', 'zincelestial' ); ?></span></th>
						<th class="product-name"><?php esc_html_e( 'Product', 'zincelestial' ); ?></th>
						<th class="product-price"><?php esc_html_e( 'Price', 'zincelestial' ); ?></th>
						<th class="product-quantity"><?php esc_html_e( 'Quantity', 'zincelestial' ); ?></th>
						<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'zincelestial' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>
					<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
						<tr class="zc-woo-cart__item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<td class="product-remove">
								<?php echo apply_filters( 'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove zc-woo-cart__remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="zc-icon zc-icon--x" aria-hidden="true"></i></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'zincelestial' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								); ?>
							</td>
							<td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								if ( $product_permalink ) {
									echo '<a href="' . esc_url( $product_permalink ) . '">' . $thumbnail . '</a>';
								} else {
									echo $thumbnail;
								}
								?>
							</td>
							<td class="product-name">
								<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}
								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
								echo wc_get_formatted_cart_item_data( $cart_item );
								?>
							</td>
							<td class="product-price">
								<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
							</td>
							<td class="product-quantity">
								<?php
								if ( $_product->is_sold_individually() ) {
									$min_quantity = 1;
									$max_quantity = 1;
								} else {
									$min_quantity = 0;
									$max_quantity = $_product->get_max_purchase_quantity();
								}
								$product_quantity = woocommerce_quantity_input( [
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $max_quantity,
									'min_value'    => $min_quantity,
									'product_name' => $_product->get_name(),
								], $_product, false );
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
								?>
							</td>
							<td class="product-subtotal">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</td>
						</tr>
					<?php endif; endforeach; ?>
					<?php do_action( 'woocommerce_cart_contents' ); ?>

					<tr>
						<td colspan="6" class="actions">
							<?php if ( wc_coupons_enabled() ) : ?>
								<div class="coupon zc-woo-cart__coupon">
									<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon', 'zincelestial' ); ?></label>
									<input type="text" name="coupon_code" class="input-text zc-input" id="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'zincelestial' ); ?>" />
									<button type="submit" class="zc-btn zc-btn--secondary" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'zincelestial' ); ?>"><?php esc_html_e( 'Apply coupon', 'zincelestial' ); ?></button>
								</div>
							<?php endif; ?>
							<button type="submit" class="button zc-btn zc-btn--ghost" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'zincelestial' ); ?>"><?php esc_html_e( 'Update cart', 'zincelestial' ); ?></button>
							<?php do_action( 'woocommerce_cart_actions' ); ?>
							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</td>
					</tr>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
			</table>
		</div>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<div class="zc-woo-cart__collaterals cart-collaterals">
		<?php do_action( 'woocommerce_cart_collaterals' ); ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' );

<?php
/**
 * ZinCelestial — WooCommerce Checkout Form
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'zincelestial' ) ) );
	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout zc-woo-checkout-form"
      action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="zc-woo-checkout__grid">
			<div class="zc-woo-checkout__main">
				<div id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				<h2 id="order_review_heading" class="zc-woo-checkout__section-title">
					<?php esc_html_e( 'Your order', 'zincelestial' ); ?>
				</h2>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );

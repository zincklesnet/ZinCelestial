<?php
/**
 * ZinCelestial — WooCommerce My Account Page
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="zc-woo-account" id="zc-woo-account">
	<div class="zc-woo-account__sidebar">
		<div class="zc-woo-account__user">
			<?php echo get_avatar( get_current_user_id(), 64, '', '', [ 'class' => 'zc-avatar zc-avatar--account' ] ); ?>
			<div class="zc-woo-account__user-info">
				<strong><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>
				<span class="zc-woo-account__user-email"><?php echo esc_html( wp_get_current_user()->user_email ); ?></span>
			</div>
		</div>
		<nav class="zc-woo-account__nav" aria-label="<?php esc_attr_e( 'Account navigation', 'zincelestial' ); ?>">
			<?php
			$current = ( isset( $_GET['wc-ajax'] ) ) ? '' : wc_get_account_menu_item_classes( 'dashboard' );
			foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
				$icon = [
					'dashboard'       => 'layout',
					'orders'          => 'shopping-bag',
					'downloads'       => 'download',
					'edit-address'    => 'map-pin',
					'payment-methods' => 'credit-card',
					'edit-account'    => 'user',
					'customer-logout' => 'log-out',
				];
				$icon_key = $icon[ $endpoint ] ?? 'circle';
			?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
				   class="zc-woo-account__nav-link <?php echo sanitize_html_class( implode( ' ', wc_get_account_menu_item_classes( $endpoint ) ) ); ?>">
					<i class="zc-icon zc-icon--<?php echo esc_attr( $icon_key ); ?>" aria-hidden="true"></i>
					<?php echo esc_html( $label ); ?>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>

	<div class="zc-woo-account__content">
		<?php
		do_action( 'woocommerce_account_content' );
		?>
	</div>
</div>

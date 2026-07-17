<?php
/**
 * ZinCelestial — Paid Memberships Pro Checkout Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-pmpro-checkout" class="zc-pmpro-wrap zc-pmpro-checkout-page">
	<div class="zc-container">
		<div class="zc-pmpro-checkout__card">
			<div class="zc-pmpro-checkout__header">
				<h1 class="zc-pmpro-checkout__title">
					<i class="zc-icon zc-icon--shield" aria-hidden="true"></i>
					<?php esc_html_e( 'Membership Checkout', 'zincelestial' ); ?>
				</h1>
			</div>
			<div class="zc-pmpro-checkout__body">
				<?php if ( function_exists( 'pmpro_checkout' ) ) {
					pmpro_checkout();
				} else {
					the_content();
				} ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();

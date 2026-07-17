<?php
/**
 * ZinCelestial — WP Job Manager Listings Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-job-listings" class="zc-job-manager-wrap zc-job-listings-page">
	<div class="zc-container">
		<div class="zc-job-listings__header">
			<h1 class="zc-job-listings__title">
				<i class="zc-icon zc-icon--briefcase" aria-hidden="true"></i>
				<?php esc_html_e( 'Job Listings', 'zincelestial' ); ?>
			</h1>
		</div>
		<div class="zc-job-listings__filters">
			<?php if ( function_exists( 'get_job_listings' ) ) : ?>
				<?php echo do_shortcode( '[jobs show_filters="true" show_pagination="true" per_page="12"]' ); ?>
			<?php else : ?>
				<div class="zc-bp-empty">
					<i class="zc-icon zc-icon--briefcase" aria-hidden="true"></i>
					<p><?php esc_html_e( 'No job listings found.', 'zincelestial' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer();

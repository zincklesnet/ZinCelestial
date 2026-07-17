<?php
/**
 * ZinCelestial — EDD Download Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-edd-download" class="zc-edd-wrap zc-edd-download-single">
	<div class="zc-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="zc-edd-download-card">
				<div class="zc-edd-download-card__hero">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="zc-edd-download-card__thumb">
							<?php the_post_thumbnail( 'large', [ 'class' => 'zc-edd-download-card__img', 'loading' => 'eager' ] ); ?>
						</div>
					<?php endif; ?>
					<div class="zc-edd-download-card__info">
						<h1 class="zc-edd-download-card__title"><?php the_title(); ?></h1>
						<?php if ( function_exists( 'edd_price' ) ) : ?>
							<div class="zc-edd-download-card__price">
								<?php edd_price( get_the_ID() ); ?>
							</div>
						<?php endif; ?>
						<div class="zc-edd-download-card__meta">
							<?php if ( function_exists( 'edd_get_download_sales_stats' ) ) : ?>
								<span class="zc-chip">
									<i class="zc-icon zc-icon--download" aria-hidden="true"></i>
									<?php echo esc_html( edd_get_download_sales_stats( get_the_ID() ) ); ?> <?php esc_html_e( 'downloads', 'zincelestial' ); ?>
								</span>
							<?php endif; ?>
						</div>
						<?php if ( function_exists( 'edd_purchase_link' ) ) : ?>
							<div class="zc-edd-download-card__cta">
								<?php edd_purchase_link( [ 'download_id' => get_the_ID(), 'class' => 'zc-btn zc-btn--primary' ] ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="zc-edd-download-card__body">
					<div class="zc-edd-download-card__content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer();

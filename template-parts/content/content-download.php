<?php
/**
 * ZinCelestial — Template Part: Content / Download Item (EDD)
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'zc-download-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="zc-download-card__thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium', [ 'class' => 'zc-download-card__img', 'loading' => 'lazy' ] ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="zc-download-card__body">
		<h2 class="zc-download-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="zc-download-card__excerpt"><?php the_excerpt(); ?></div>
		<div class="zc-download-card__footer">
			<?php if ( function_exists( 'edd_price' ) ) : ?>
				<span class="zc-download-card__price"><?php edd_price( get_the_ID() ); ?></span>
			<?php endif; ?>
			<a href="<?php the_permalink(); ?>" class="zc-btn zc-btn--primary zc-btn--sm">
				<i class="zc-icon zc-icon--download" aria-hidden="true"></i>
				<?php esc_html_e( 'Download', 'zincelestial' ); ?>
			</a>
		</div>
	</div>
</article>

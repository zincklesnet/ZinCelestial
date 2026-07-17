<?php
/**
 * ZinCelestial — Template Part: Header / Site Branding
 * Logo, site title, tagline.
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

$logo_type       = get_theme_mod( 'zc_logo_type', 'image' ); // image | text | both
$logo_image      = get_theme_mod( 'custom_logo' );
$retina_logo_id  = get_theme_mod( 'zc_retina_logo' );
$site_title      = get_bloginfo( 'name' );
$tagline         = get_bloginfo( 'description' );
$show_tagline    = get_theme_mod( 'zc_show_tagline', false );
$logo_width      = get_theme_mod( 'zc_logo_width', 160 );
$logo_height     = get_theme_mod( 'zc_logo_height', 48 );
?>
<div class="zc-site-branding" itemscope itemtype="https://schema.org/Organization">

	<?php if ( has_custom_logo() && $logo_type !== 'text' ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="zc-logo-link" rel="home" itemprop="url">
			<?php
			$logo_attr = [
				'class'  => 'zc-logo zc-logo--image',
				'width'  => absint( $logo_width ),
				'height' => absint( $logo_height ),
			];
			// Output retina (2×) logo if set
			if ( $retina_logo_id ) {
				$retina_url = wp_get_attachment_image_url( $retina_logo_id, 'full' );
				$logo_attr['data-retina'] = esc_url( $retina_url );
			}
			the_custom_logo();
			?>
		</a>
	<?php endif; ?>

	<?php if ( $logo_type === 'text' || $logo_type === 'both' || ! has_custom_logo() ) : ?>
		<div class="zc-site-branding__text">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="zc-site-title" itemprop="name">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo esc_html( $site_title ); ?>
					</a>
				</h1>
			<?php else : ?>
				<p class="zc-site-title" itemprop="name">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo esc_html( $site_title ); ?>
					</a>
				</p>
			<?php endif; ?>
			<?php if ( $show_tagline && $tagline ) : ?>
				<p class="zc-site-tagline"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

</div><!-- .zc-site-branding -->

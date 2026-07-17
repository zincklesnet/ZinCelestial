<?php
/**
 * ZinCelestial — PeepSo Post Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-peepso-post" class="zc-peepso-wrap">
	<div class="zc-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="zc-peepso-post-card">
				<header class="zc-peepso-post-card__header">
					<h1 class="zc-peepso-post-card__title"><?php the_title(); ?></h1>
					<div class="zc-peepso-post-card__meta">
						<span><?php the_author(); ?></span>
						&bull;
						<time><?php the_date(); ?></time>
					</div>
				</header>
				<div class="zc-peepso-post-card__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer();

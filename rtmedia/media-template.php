<?php
/**
 * ZinCelestial — rtMedia Media Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-rtmedia-wrap" class="zc-rtmedia-wrap">
	<div class="zc-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="zc-rtmedia-single">
				<h1 class="zc-rtmedia-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>
		<?php if ( function_exists( 'rtmedia_template_media_detail' ) ) : ?>
			<?php rtmedia_template_media_detail(); ?>
		<?php endif; ?>
	</div>
</div>
<?php get_footer();

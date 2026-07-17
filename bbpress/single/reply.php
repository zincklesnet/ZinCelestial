<?php
/**
 * ZinCelestial — bbPress Single Reply
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-bbp-reply" class="zc-bbp-wrap zc-bbp-reply-single">
	<div class="zc-container">
		<div class="zc-bbp-breadcrumb"><?php bbp_breadcrumb(); ?></div>

		<?php while ( have_posts() ) : the_post(); ?>
			<div class="zc-bbp-reply-header">
				<h1 class="zc-bbp-reply-title">
					<?php printf(
						/* translators: %s: topic link */
						esc_html__( 'Reply to: %s', 'zincelestial' ),
						'<a href="' . esc_url( bbp_get_reply_topic_permalink() ) . '">' . bbp_get_reply_topic_title() . '</a>'
					); ?>
				</h1>
			</div>
			<div class="zc-bbp-reply-item">
				<div class="zc-bbp-reply-item__avatar">
					<?php bbp_reply_author_avatar( 48 ); ?>
				</div>
				<div class="zc-bbp-reply-item__body">
					<div class="zc-bbp-reply-item__header">
						<span class="zc-bbp-reply-item__author"><?php bbp_reply_author_link(); ?></span>
						<time class="zc-bbp-reply-item__time"><?php bbp_reply_post_date(); ?></time>
					</div>
					<div class="zc-bbp-reply-item__content"><?php the_content(); ?></div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer();

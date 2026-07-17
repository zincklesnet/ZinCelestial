<?php
/**
 * ZinCelestial — bbPress Single Topic
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-bbp-topic" class="zc-bbp-wrap zc-bbp-topic-single">
	<div class="zc-container">

		<!-- Breadcrumb -->
		<div class="zc-bbp-breadcrumb"><?php bbp_breadcrumb(); ?></div>

		<!-- Topic Header -->
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="zc-bbp-topic-header">
			<div class="zc-bbp-topic-header__left">
				<h1 class="zc-bbp-topic-title"><?php the_title(); ?></h1>
				<div class="zc-bbp-topic-meta">
					<?php bbp_topic_forum_link(); ?>
					&bull;
					<?php bbp_topic_voice_count(); ?> <?php esc_html_e( 'voices', 'zincelestial' ); ?>
					&bull;
					<?php bbp_topic_reply_count(); ?> <?php esc_html_e( 'replies', 'zincelestial' ); ?>
					&bull;
					<?php bbp_topic_last_active_time(); ?>
				</div>
			</div>
			<div class="zc-bbp-topic-header__actions">
				<?php if ( bbp_is_subscriptions_active() && is_user_logged_in() ) : ?>
					<?php bbp_topic_subscription_link(); ?>
				<?php endif; ?>
				<?php if ( is_super_admin() || bbp_is_topic_author() ) : ?>
					<?php bbp_topic_admin_links(); ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- Original post -->
		<div class="zc-bbp-original-post zc-bbp-reply-item">
			<div class="zc-bbp-reply-item__avatar">
				<?php bbp_topic_author_avatar( 48 ); ?>
			</div>
			<div class="zc-bbp-reply-item__body">
				<div class="zc-bbp-reply-item__header">
					<span class="zc-bbp-reply-item__author"><?php bbp_topic_author_link(); ?></span>
					<time class="zc-bbp-reply-item__time"><?php bbp_topic_post_date(); ?></time>
				</div>
				<div class="zc-bbp-reply-item__content"><?php the_content(); ?></div>
			</div>
		</div>
		<?php endwhile; ?>

		<!-- Replies -->
		<?php get_template_part( 'bbpress/loop/replies' ); ?>

		<!-- Reply form -->
		<?php get_template_part( 'bbpress/form/reply' ); ?>

	</div>
</div>
<?php get_footer();

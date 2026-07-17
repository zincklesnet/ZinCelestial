<?php
/**
 * ZinCelestial — bbPress Single Forum
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-bbp-forum" class="zc-bbp-wrap zc-bbp-forum-single">
	<div class="zc-container">
		<div class="zc-bbp-layout">

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="zc-bbp-forum-header">
					<h1 class="zc-bbp-forum-title"><?php the_title(); ?></h1>
					<?php if ( get_the_content() ) : ?>
						<div class="zc-bbp-forum-desc"><?php the_content(); ?></div>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>

			<!-- Sub-forums -->
			<?php if ( bbp_get_forum_subforum_count() ) : ?>
				<div class="zc-bbp-subforums">
					<h2 class="zc-bbp-section-title"><?php esc_html_e( 'Sub Forums', 'zincelestial' ); ?></h2>
					<?php get_template_part( 'bbpress/loop/forums' ); ?>
				</div>
			<?php endif; ?>

			<!-- Topics toolbar -->
			<div class="zc-bbp-topics-toolbar">
				<h2 class="zc-bbp-section-title"><?php esc_html_e( 'Topics', 'zincelestial' ); ?></h2>
				<div class="zc-bbp-topics-actions">
					<?php bbp_sort_form(); ?>
					<?php if ( bbp_is_subscriptions_active() && is_user_logged_in() ) : ?>
						<?php bbp_forum_subscription_link(); ?>
					<?php endif; ?>
					<?php if ( bbp_current_user_can_publish_topics() ) : ?>
						<a href="<?php bbp_new_topic_url(); ?>" class="zc-btn zc-btn--primary zc-btn--sm">
							<i class="zc-icon zc-icon--plus" aria-hidden="true"></i>
							<?php esc_html_e( 'New Topic', 'zincelestial' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php get_template_part( 'bbpress/loop/topics' ); ?>
			<?php get_template_part( 'bbpress/form/topic' ); ?>

		</div><!-- .zc-bbp-layout -->
	</div><!-- .zc-container -->
</div><!-- #zc-bbp-forum -->

<?php get_footer();

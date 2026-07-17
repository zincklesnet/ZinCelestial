<?php
/**
 * ZinCelestial — bbPress Topics Loop
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="zc-bbp-topics-wrap">
	<?php if ( bbp_has_topics( bbp_before_has_topics_parse_args() ) ) : ?>
		<?php do_action( 'bbp_template_before_topics_loop' ); ?>
		<ul class="zc-bbp-topic-list" role="list">
			<?php while ( bbp_topics() ) : bbp_the_topic(); ?>
				<li class="zc-bbp-topic-item <?php bbp_topic_class(); ?>" id="<?php bbp_topic_id(); ?>">
					<div class="zc-bbp-topic-item__status">
						<?php if ( bbp_is_topic_sticky() ) : ?>
							<span class="zc-chip zc-chip--primary" title="<?php esc_attr_e( 'Sticky', 'zincelestial' ); ?>">
								<i class="zc-icon zc-icon--pin" aria-hidden="true"></i>
							</span>
						<?php endif; ?>
						<?php if ( bbp_is_topic_closed() ) : ?>
							<span class="zc-chip zc-chip--warning" title="<?php esc_attr_e( 'Closed', 'zincelestial' ); ?>">
								<i class="zc-icon zc-icon--lock" aria-hidden="true"></i>
							</span>
						<?php endif; ?>
					</div>
					<div class="zc-bbp-topic-item__avatar">
						<?php bbp_topic_author_avatar( bbp_get_topic_author_id(), 40 ); ?>
					</div>
					<div class="zc-bbp-topic-item__body">
						<h3 class="zc-bbp-topic-item__title">
							<a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
						</h3>
						<div class="zc-bbp-topic-item__meta">
							<span><?php bbp_topic_author_link(); ?></span>
							&bull;
							<span><?php bbp_topic_freshness_link(); ?></span>
							<?php if ( function_exists( 'bbp_get_topic_tags' ) && bbp_get_topic_tags() ) : ?>
								&bull;
								<span class="zc-bbp-topic-item__tags"><?php bbp_topic_tags(); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="zc-bbp-topic-item__stats">
						<div class="zc-bbp-forum-stat">
							<span class="zc-bbp-forum-stat__num"><?php bbp_topic_voice_count(); ?></span>
							<span class="zc-bbp-forum-stat__label"><?php esc_html_e( 'Voices', 'zincelestial' ); ?></span>
						</div>
						<div class="zc-bbp-forum-stat">
							<span class="zc-bbp-forum-stat__num"><?php bbp_topic_reply_count(); ?></span>
							<span class="zc-bbp-forum-stat__label"><?php esc_html_e( 'Replies', 'zincelestial' ); ?></span>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php do_action( 'bbp_template_after_topics_loop' ); ?>
		<div class="zc-bbp-pagination"><?php bbp_topic_pagination(); ?></div>
	<?php else : ?>
		<div class="zc-bp-empty">
			<i class="zc-icon zc-icon--file-text" aria-hidden="true"></i>
			<p><?php esc_html_e( 'No topics found.', 'zincelestial' ); ?></p>
		</div>
	<?php endif; ?>
</div>

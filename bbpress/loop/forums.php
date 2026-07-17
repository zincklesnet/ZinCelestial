<?php
/**
 * ZinCelestial — bbPress Forum Loop
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="zc-bbp-forums-wrap">
	<?php if ( bbp_has_forums() ) : ?>
		<ul class="zc-bbp-forum-list" role="list">
			<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
				<li class="zc-bbp-forum-item" id="<?php bbp_forum_id(); ?>">
					<div class="zc-bbp-forum-item__icon" aria-hidden="true">
						<i class="zc-icon zc-icon--message-circle"></i>
					</div>
					<div class="zc-bbp-forum-item__body">
						<h3 class="zc-bbp-forum-item__title">
							<a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>
						</h3>
						<?php if ( bbp_get_forum_content() ) : ?>
							<p class="zc-bbp-forum-item__desc"><?php bbp_forum_content(); ?></p>
						<?php endif; ?>
						<?php if ( bbp_get_forum_subforum_count() ) : ?>
							<div class="zc-bbp-forum-item__subforums">
								<strong><?php esc_html_e( 'Subforums:', 'zincelestial' ); ?></strong>
								<?php bbp_list_forums(); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="zc-bbp-forum-item__stats">
						<div class="zc-bbp-forum-stat">
							<span class="zc-bbp-forum-stat__num"><?php bbp_forum_topic_count(); ?></span>
							<span class="zc-bbp-forum-stat__label"><?php esc_html_e( 'Topics', 'zincelestial' ); ?></span>
						</div>
						<div class="zc-bbp-forum-stat">
							<span class="zc-bbp-forum-stat__num"><?php bbp_forum_reply_count(); ?></span>
							<span class="zc-bbp-forum-stat__label"><?php esc_html_e( 'Replies', 'zincelestial' ); ?></span>
						</div>
					</div>
					<?php if ( bbp_get_forum_last_active_time() ) : ?>
					<div class="zc-bbp-forum-item__last">
						<span class="zc-bbp-forum-item__last-label"><?php esc_html_e( 'Last post:', 'zincelestial' ); ?></span>
						<?php bbp_forum_freshness_link(); ?>
					</div>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<div class="zc-bp-empty">
			<i class="zc-icon zc-icon--message-circle" aria-hidden="true"></i>
			<p><?php esc_html_e( 'No forums found.', 'zincelestial' ); ?></p>
		</div>
	<?php endif; ?>
</div>

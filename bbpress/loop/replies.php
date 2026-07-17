<?php
/**
 * ZinCelestial — bbPress Replies Loop
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="zc-bbp-replies-wrap">
	<?php if ( bbp_has_replies() ) : ?>
		<?php do_action( 'bbp_template_before_replies_loop' ); ?>
		<ol class="zc-bbp-reply-list" role="list">
			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>
				<li class="zc-bbp-reply-item <?php bbp_reply_class(); ?>" id="<?php bbp_reply_id(); ?>">
					<div class="zc-bbp-reply-item__avatar">
						<?php bbp_reply_author_avatar( 44 ); ?>
					</div>
					<div class="zc-bbp-reply-item__body">
						<div class="zc-bbp-reply-item__header">
							<span class="zc-bbp-reply-item__author"><?php bbp_reply_author_link(); ?></span>
							<a href="<?php bbp_reply_permalink(); ?>" class="zc-bbp-reply-item__time">
								<time datetime="<?php bbp_reply_post_date( get_the_ID(), true ); ?>">
									<?php bbp_reply_post_date(); ?>
								</time>
							</a>
							<?php if ( is_super_admin() || bbp_is_reply_author() ) : ?>
								<div class="zc-bbp-reply-item__admin-actions">
									<?php bbp_reply_admin_links(); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="zc-bbp-reply-item__content">
							<?php bbp_reply_content(); ?>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ol>
		<?php do_action( 'bbp_template_after_replies_loop' ); ?>
		<div class="zc-bbp-pagination"><?php bbp_reply_pagination(); ?></div>
	<?php else : ?>
		<div class="zc-bp-empty">
			<i class="zc-icon zc-icon--message-square" aria-hidden="true"></i>
			<p><?php esc_html_e( 'No replies found.', 'zincelestial' ); ?></p>
		</div>
	<?php endif; ?>
</div>

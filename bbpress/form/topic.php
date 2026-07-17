<?php
/**
 * ZinCelestial — bbPress New Topic Form
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

if ( ! bbp_current_user_can_publish_topics() ) return;
?>
<div id="zc-bbp-new-topic" class="zc-bbp-form-wrap">
	<h2 class="zc-bbp-form-title"><?php esc_html_e( 'Create New Topic', 'zincelestial' ); ?></h2>

	<?php if ( bbp_is_forum_closed() ) : ?>
		<div class="zc-notice zc-notice--warning">
			<?php esc_html_e( 'This forum is closed to new topics.', 'zincelestial' ); ?>
		</div>
	<?php else : ?>
		<form id="new-post" method="post" enctype="multipart/form-data" class="zc-bbp-form">

			<?php do_action( 'bbp_theme_before_topic_form' ); ?>

			<div class="zc-form-group">
				<label class="zc-label" for="bbp_topic_title">
					<?php esc_html_e( 'Topic Title', 'zincelestial' ); ?>
					<span class="zc-required" aria-hidden="true">*</span>
				</label>
				<input type="text" id="bbp_topic_title" name="bbp_topic_title"
				       class="zc-input" value="<?php bbp_form_topic_title(); ?>"
				       maxlength="<?php bbp_title_max_length(); ?>" required />
			</div>

			<div class="zc-form-group">
				<label class="zc-label" for="bbp_topic_content">
					<?php esc_html_e( 'Topic Content', 'zincelestial' ); ?>
					<span class="zc-required" aria-hidden="true">*</span>
				</label>
				<?php bbp_the_content( [ 'context' => 'topic' ] ); ?>
			</div>

			<?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags' ) ) : ?>
			<div class="zc-form-group">
				<label class="zc-label" for="bbp_topic_tags">
					<?php esc_html_e( 'Tags', 'zincelestial' ); ?>
				</label>
				<input type="text" id="bbp_topic_tags" name="bbp_topic_tags"
				       class="zc-input" value="<?php bbp_form_topic_tags(); ?>"
				       placeholder="<?php esc_attr_e( 'Comma-separated tags…', 'zincelestial' ); ?>" />
			</div>
			<?php endif; ?>

			<?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>

			<div class="zc-bbp-form-submit">
				<?php bbp_topic_hidden_fields(); ?>
				<button type="submit" class="zc-btn zc-btn--primary" name="bbp_topic_submit" id="bbp_topic_submit">
					<?php esc_html_e( 'Post Topic', 'zincelestial' ); ?>
				</button>
				<a href="<?php echo esc_url( bbp_get_forum_permalink() ); ?>" class="zc-btn zc-btn--ghost">
					<?php esc_html_e( 'Cancel', 'zincelestial' ); ?>
				</a>
			</div>

			<?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>

		</form>
	<?php endif; ?>
</div>

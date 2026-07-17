<?php
/**
 * ZinCelestial — bbPress Reply Form
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

if ( ! bbp_current_user_can_publish_replies() ) return;
if ( bbp_is_topic_closed() ) {
	echo '<div class="zc-notice zc-notice--warning">' . esc_html__( 'This topic is closed to new replies.', 'zincelestial' ) . '</div>';
	return;
}
?>
<div id="zc-bbp-new-reply" class="zc-bbp-form-wrap">
	<h3 class="zc-bbp-form-title"><?php esc_html_e( 'Leave a Reply', 'zincelestial' ); ?></h3>
	<form id="new-reply" method="post" enctype="multipart/form-data" class="zc-bbp-form">
		<?php do_action( 'bbp_theme_before_reply_form' ); ?>
		<div class="zc-form-group">
			<label class="zc-label" for="bbp_reply_content">
				<?php esc_html_e( 'Reply', 'zincelestial' ); ?>
				<span class="zc-required" aria-hidden="true">*</span>
			</label>
			<?php bbp_the_content( [ 'context' => 'reply' ] ); ?>
		</div>
		<?php do_action( 'bbp_theme_before_reply_form_submit_wrapper' ); ?>
		<div class="zc-bbp-form-submit">
			<?php bbp_reply_hidden_fields(); ?>
			<button type="submit" class="zc-btn zc-btn--primary" name="bbp_reply_submit" id="bbp_reply_submit">
				<i class="zc-icon zc-icon--send" aria-hidden="true"></i>
				<?php esc_html_e( 'Post Reply', 'zincelestial' ); ?>
			</button>
		</div>
		<?php do_action( 'bbp_theme_after_reply_form_submit_wrapper' ); ?>
	</form>
</div>

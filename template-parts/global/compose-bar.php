<?php
/**
 * ZinCelestial — Template Part: Global / Compose Bar (Boombox #COMPOSE style)
 * Sticky bar below header — opens a modal for posting to BuddyPress activity.
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

if ( ! is_user_logged_in() ) return;
if ( ! get_theme_mod( 'zc_compose_bar_enabled', true ) ) return;
if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'activity' ) ) return;

$user_id     = get_current_user_id();
$placeholder = get_theme_mod( 'zc_compose_placeholder', __( "What's on your mind?", 'zincelestial' ) );
?>
<div id="zc-compose-bar" class="zc-compose-bar" role="complementary" aria-label="<?php esc_attr_e( 'Compose activity', 'zincelestial' ); ?>">
	<div class="zc-compose-bar__inner zc-container">
		<?php echo get_avatar( $user_id, 36, '', '', [ 'class' => 'zc-avatar zc-compose-bar__avatar' ] ); ?>
		<button class="zc-compose-bar__trigger" id="zc-compose-trigger" aria-expanded="false" aria-controls="zc-compose-modal">
			<span class="zc-compose-bar__placeholder"><?php echo esc_html( $placeholder ); ?></span>
		</button>
		<div class="zc-compose-bar__actions">
			<button class="zc-compose-bar__action-btn" data-type="photo" aria-label="<?php esc_attr_e( 'Add photo', 'zincelestial' ); ?>">
				<i class="zc-icon zc-icon--image" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Photo', 'zincelestial' ); ?></span>
			</button>
			<button class="zc-compose-bar__action-btn" data-type="video" aria-label="<?php esc_attr_e( 'Add video', 'zincelestial' ); ?>">
				<i class="zc-icon zc-icon--video" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Video', 'zincelestial' ); ?></span>
			</button>
			<button class="zc-compose-bar__action-btn" data-type="gif" aria-label="<?php esc_attr_e( 'Add GIF', 'zincelestial' ); ?>">
				<i class="zc-icon zc-icon--film" aria-hidden="true"></i>
				<span><?php esc_html_e( 'GIF', 'zincelestial' ); ?></span>
			</button>
			<button class="zc-compose-bar__action-btn" data-type="link" aria-label="<?php esc_attr_e( 'Add link', 'zincelestial' ); ?>">
				<i class="zc-icon zc-icon--link" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Link', 'zincelestial' ); ?></span>
			</button>
		</div>
	</div>
</div><!-- #zc-compose-bar -->

<!-- Compose Modal -->
<div id="zc-compose-modal" class="zc-modal zc-compose-modal" role="dialog" aria-modal="true"
     aria-labelledby="zc-compose-modal-title" hidden>
	<div class="zc-modal__backdrop" id="zc-compose-backdrop"></div>
	<div class="zc-modal__panel">
		<div class="zc-modal__header">
			<h2 id="zc-compose-modal-title" class="zc-modal__title">
				<?php esc_html_e( 'Create Post', 'zincelestial' ); ?>
			</h2>
			<button class="zc-modal__close" id="zc-compose-close" aria-label="<?php esc_attr_e( 'Close', 'zincelestial' ); ?>">
				<i class="zc-icon zc-icon--x" aria-hidden="true"></i>
			</button>
		</div>
		<div class="zc-modal__body">
			<div class="zc-compose-modal__user">
				<?php echo get_avatar( $user_id, 48, '', '', [ 'class' => 'zc-avatar zc-compose-modal__avatar' ] ); ?>
				<div>
					<strong class="zc-compose-modal__name"><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>
					<select class="zc-compose-modal__audience" aria-label="<?php esc_attr_e( 'Audience', 'zincelestial' ); ?>">
						<option value="public"><?php esc_html_e( '🌍 Public', 'zincelestial' ); ?></option>
						<option value="friends"><?php esc_html_e( '👥 Friends', 'zincelestial' ); ?></option>
						<option value="only_me"><?php esc_html_e( '🔒 Only Me', 'zincelestial' ); ?></option>
					</select>
				</div>
			</div>
			<div class="zc-compose-modal__editor" id="zc-compose-editor"
			     contenteditable="true" role="textbox" aria-multiline="true"
			     data-placeholder="<?php echo esc_attr( $placeholder ); ?>"></div>
			<div class="zc-compose-modal__media-preview" id="zc-compose-preview" hidden></div>
		</div>
		<div class="zc-modal__footer">
			<div class="zc-compose-modal__media-btns">
				<button class="zc-compose-modal__media-btn" data-type="photo" aria-label="<?php esc_attr_e( 'Photo', 'zincelestial' ); ?>">
					<i class="zc-icon zc-icon--image" aria-hidden="true"></i>
				</button>
				<button class="zc-compose-modal__media-btn" data-type="video" aria-label="<?php esc_attr_e( 'Video', 'zincelestial' ); ?>">
					<i class="zc-icon zc-icon--video" aria-hidden="true"></i>
				</button>
				<button class="zc-compose-modal__media-btn" data-type="gif" aria-label="<?php esc_attr_e( 'GIF', 'zincelestial' ); ?>">
					<i class="zc-icon zc-icon--film" aria-hidden="true"></i>
				</button>
				<button class="zc-compose-modal__media-btn" data-type="link" aria-label="<?php esc_attr_e( 'Link', 'zincelestial' ); ?>">
					<i class="zc-icon zc-icon--link" aria-hidden="true"></i>
				</button>
				<button class="zc-compose-modal__media-btn" data-type="emoji" aria-label="<?php esc_attr_e( 'Emoji', 'zincelestial' ); ?>">
					<i class="zc-icon zc-icon--smile" aria-hidden="true"></i>
				</button>
			</div>
			<button class="zc-btn zc-btn--primary zc-compose-modal__submit" id="zc-compose-submit"
			        data-nonce="<?php echo esc_attr( wp_create_nonce( 'zc_compose_nonce' ) ); ?>">
				<?php esc_html_e( 'Post', 'zincelestial' ); ?>
			</button>
		</div>
	</div>
</div><!-- #zc-compose-modal -->

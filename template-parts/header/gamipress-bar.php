<?php
/**
 * ZinCelestial — Template Part: GamiPress Header Bar (Vikinger bar-progress-info style)
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

if ( ! is_user_logged_in() ) return;
if ( ! function_exists( 'gamipress_get_user_points' ) ) return;
if ( ! get_theme_mod( 'zc_gamipress_bar_enabled', true ) ) return;

$user_id = get_current_user_id();

// Points
$gzcreds  = gamipress_get_user_points( $user_id, 'gzcreds' );
$rubies   = gamipress_get_user_points( $user_id, 'rubies' );
$zcreds   = gamipress_get_user_points( $user_id, 'zcreds' );

// Rank & Level
$rank_label  = '';
$level_label = '';
if ( function_exists( 'gamipress_get_user_rank' ) ) {
	$rank = gamipress_get_user_rank( $user_id );
	if ( $rank ) $rank_label = $rank->post_title;
}

// XP / Level progress
$current_xp   = gamipress_get_user_points( $user_id, 'points' );
$next_xp      = absint( get_theme_mod( 'zc_xp_next_level', 1000 ) );
$xp_pct       = $next_xp > 0 ? min( 100, round( ( $current_xp / $next_xp ) * 100 ) ) : 0;

// Badge count
$badge_count  = function_exists( 'gamipress_get_user_achievements' )
	? count( gamipress_get_user_achievements( [ 'user_id' => $user_id, 'achievement_type' => 'badge' ] ) )
	: 0;

// Admin toggles
$show_avatar  = get_theme_mod( 'zc_gpbar_avatar', true );
$show_level   = get_theme_mod( 'zc_gpbar_level', true );
$show_xp      = get_theme_mod( 'zc_gpbar_xp', true );
$show_rank    = get_theme_mod( 'zc_gpbar_rank', true );
$show_gzcreds = get_theme_mod( 'zc_gpbar_gzcreds', true );
$show_rubies  = get_theme_mod( 'zc_gpbar_rubies', true );
$show_zcreds  = get_theme_mod( 'zc_gpbar_zcreds', true );
$show_badges  = get_theme_mod( 'zc_gpbar_badges', true );

$profile_url = function_exists( 'bp_loggedin_user_domain' ) ? bp_loggedin_user_domain() : '#';
?>
<div id="zc-gamipress-bar" class="zc-gamipress-bar bar-progress-info"
     data-refresh="<?php echo esc_attr( get_theme_mod( 'zc_gpbar_refresh', 60 ) ); ?>"
     aria-label="<?php esc_attr_e( 'Your progress', 'zincelestial' ); ?>">
	<div class="zc-gamipress-bar__inner zc-container">

		<?php if ( $show_avatar ) : ?>
		<a href="<?php echo esc_url( $profile_url ); ?>" class="zc-gpbar__avatar-link">
			<?php echo get_avatar( $user_id, 36, '', '', [ 'class' => 'zc-avatar zc-gpbar__avatar' ] ); ?>
		</a>
		<?php endif; ?>

		<?php if ( $show_level ) : ?>
		<div class="zc-gpbar__item zc-gpbar__level" title="<?php esc_attr_e( 'Level', 'zincelestial' ); ?>">
			<i class="zc-icon zc-icon--zap" aria-hidden="true"></i>
			<span class="zc-gpbar__label"><?php esc_html_e( 'Lv', 'zincelestial' ); ?></span>
			<span class="zc-gpbar__value" id="zc-bar-level">1</span>
		</div>
		<?php endif; ?>

		<?php if ( $show_xp ) : ?>
		<div class="zc-gpbar__xp-wrap" title="<?php printf( esc_attr__( '%d / %d XP', 'zincelestial' ), $current_xp, $next_xp ); ?>">
			<span class="zc-gpbar__xp-text">
				<span id="zc-bar-xp"><?php echo esc_html( number_format( $current_xp ) ); ?></span>
				/ <?php echo esc_html( number_format( $next_xp ) ); ?> XP
			</span>
			<div class="zc-xp-bar" role="progressbar"
			     aria-valuenow="<?php echo esc_attr( $xp_pct ); ?>" aria-valuemin="0" aria-valuemax="100">
				<div class="zc-xp-bar__fill" style="width:<?php echo esc_attr( $xp_pct ); ?>%"></div>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $show_rank && $rank_label ) : ?>
		<div class="zc-gpbar__item zc-gpbar__rank" title="<?php esc_attr_e( 'Rank', 'zincelestial' ); ?>">
			<i class="zc-icon zc-icon--award" aria-hidden="true"></i>
			<span class="zc-gpbar__value" id="zc-bar-rank"><?php echo esc_html( $rank_label ); ?></span>
		</div>
		<?php endif; ?>

		<div class="zc-gpbar__points-group">
			<?php if ( $show_gzcreds ) : ?>
			<div class="zc-gpbar__item zc-gpbar__points zc-gpbar__gzcreds"
			     title="<?php esc_attr_e( 'GZCreds', 'zincelestial' ); ?>">
				<span class="zc-gpbar__points-icon">✦</span>
				<span class="zc-gpbar__value" id="zc-bar-gzcreds"><?php echo esc_html( number_format( $gzcreds ) ); ?></span>
				<span class="zc-gpbar__label"><?php esc_html_e( 'GZCreds', 'zincelestial' ); ?></span>
			</div>
			<?php endif; ?>

			<?php if ( $show_rubies ) : ?>
			<div class="zc-gpbar__item zc-gpbar__points zc-gpbar__rubies"
			     title="<?php esc_attr_e( 'Rubies', 'zincelestial' ); ?>">
				<span class="zc-gpbar__points-icon">💎</span>
				<span class="zc-gpbar__value" id="zc-bar-rubies"><?php echo esc_html( number_format( $rubies ) ); ?></span>
				<span class="zc-gpbar__label"><?php esc_html_e( 'Rubies', 'zincelestial' ); ?></span>
			</div>
			<?php endif; ?>

			<?php if ( $show_zcreds ) : ?>
			<div class="zc-gpbar__item zc-gpbar__points zc-gpbar__zcreds"
			     title="<?php esc_attr_e( 'ZCreds', 'zincelestial' ); ?>">
				<span class="zc-gpbar__points-icon">⚡</span>
				<span class="zc-gpbar__value" id="zc-bar-zcreds"><?php echo esc_html( number_format( $zcreds ) ); ?></span>
				<span class="zc-gpbar__label"><?php esc_html_e( 'ZCreds', 'zincelestial' ); ?></span>
			</div>
			<?php endif; ?>
		</div>

		<?php if ( $show_badges ) : ?>
		<div class="zc-gpbar__item zc-gpbar__badges"
		     title="<?php esc_attr_e( 'Badges earned', 'zincelestial' ); ?>">
			<i class="zc-icon zc-icon--shield" aria-hidden="true"></i>
			<span class="zc-gpbar__value" id="zc-bar-badges"><?php echo esc_html( $badge_count ); ?></span>
			<span class="zc-gpbar__label"><?php esc_html_e( 'Badges', 'zincelestial' ); ?></span>
		</div>
		<?php endif; ?>

	</div><!-- .zc-gamipress-bar__inner -->
</div><!-- #zc-gamipress-bar -->

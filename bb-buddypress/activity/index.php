<?php
/**
 * ZinCelestial — BB-BuddyPress Activity Index (BuddyBoss Platform compat)
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
get_header( 'buddypress' );
?>
<div id="zc-bb-activity" class="zc-bp-wrap zc-bb-activity-wrap">
	<div class="zc-container">
		<?php get_template_part( 'template-parts/global/compose-bar' ); ?>
		<div class="zc-activity-stream" id="activity-stream">
			<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) ) ) : ?>
				<ul id="activity-stream" class="zc-activity-list" role="list">
					<?php while ( bp_activities() ) : bp_the_activity(); ?>
						<li id="activity-<?php bp_activity_id(); ?>" class="zc-activity-item <?php bp_activity_css_class(); ?>">
							<?php locate_template( [ 'bb-buddypress/activity/entry.php', 'buddypress/activity/entry.php' ], true ); ?>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<div class="zc-bp-empty"><p><?php esc_html_e( 'No activity found.', 'zincelestial' ); ?></p></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer( 'buddypress' );

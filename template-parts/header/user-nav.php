<?php
/**
 * ZinCelestial — Template Part: Header / User Nav (logged-in quick bar)
 * v3.3 Fix: All BuddyPress function calls now fully guarded with
 *           function_exists() + bp_is_active() checks. Removed calls to
 *           bp_notifications_get_unread_notification_count() and
 *           bp_get_total_unread_messages_count() without guards.
 *           <i class="zc-icon"> tags replaced with data-lucide attributes.
 *
 * @package ZinCelestial
 */
defined('ABSPATH')||exit;

if(!is_user_logged_in()) return;

$user_id     = get_current_user_id();
$user        = wp_get_current_user();
$profile_url = function_exists('bp_loggedin_user_domain')
               ? bp_loggedin_user_domain()
               : get_edit_profile_url($user_id);
?>
<div class="zc-user-nav" id="zc-user-nav">
	<div class="zc-user-nav__inner">

		<!-- Avatar + display name -->
		<a href="<?php echo esc_url($profile_url); ?>" class="zc-user-nav__avatar-link"
		   aria-label="<?php esc_attr_e('View your profile','zincelestial'); ?>">
			<?php echo get_avatar($user_id,40,'',esc_attr($user->display_name),array('class'=>'zc-avatar zc-avatar--user-nav')); ?>
			<span class="zc-user-nav__display-name"><?php echo esc_html($user->display_name); ?></span>
		</a>

		<!-- Quick action buttons -->
		<div class="zc-user-nav__actions">

			<!-- Notifications — guard: bp_is_active + function_exists -->
			<?php
			if(function_exists('bp_is_active') && bp_is_active('notifications')
			   && function_exists('bp_notifications_get_unread_notification_count')
			   && function_exists('bp_get_notifications_slug')):
				$notif_count = (int) bp_notifications_get_unread_notification_count($user_id);
				$notif_url   = trailingslashit($profile_url.bp_get_notifications_slug());
			?>
			<a href="<?php echo esc_url($notif_url); ?>"
			   class="zc-user-nav__action<?php echo $notif_count?' has-badge':''; ?>"
			   aria-label="<?php printf(esc_attr__('Notifications (%d unread)','zincelestial'),$notif_count); ?>">
				<i data-lucide="bell" aria-hidden="true"></i>
				<?php if($notif_count): ?>
				<span class="zc-badge zc-badge--danger"><?php echo esc_html(min($notif_count,99)); ?></span>
				<?php endif; ?>
			</a>
			<?php endif; ?>

			<!-- Messages — guard: bp_is_active + function_exists -->
			<?php
			if(function_exists('bp_is_active') && bp_is_active('messages')
			   && function_exists('bp_get_total_unread_messages_count')
			   && function_exists('bp_get_messages_slug')):
				$msg_count = (int) bp_get_total_unread_messages_count();
				$msg_url   = trailingslashit($profile_url.bp_get_messages_slug());
			?>
			<a href="<?php echo esc_url($msg_url); ?>"
			   class="zc-user-nav__action<?php echo $msg_count?' has-badge':''; ?>"
			   aria-label="<?php printf(esc_attr__('Messages (%d unread)','zincelestial'),$msg_count); ?>">
				<i data-lucide="mail" aria-hidden="true"></i>
				<?php if($msg_count): ?>
				<span class="zc-badge zc-badge--primary"><?php echo esc_html(min($msg_count,99)); ?></span>
				<?php endif; ?>
			</a>
			<?php endif; ?>

			<!-- Friend requests — guard: bp_is_active + function_exists -->
			<?php
			if(function_exists('bp_is_active') && bp_is_active('friends')
			   && function_exists('bp_friend_get_total_requests_count')
			   && function_exists('bp_get_friends_slug')):
				$friend_requests = (int) bp_friend_get_total_requests_count($user_id);
				$friends_url     = trailingslashit($profile_url.bp_get_friends_slug().'/requests');
			?>
			<?php if($friend_requests): ?>
			<a href="<?php echo esc_url($friends_url); ?>"
			   class="zc-user-nav__action has-badge"
			   aria-label="<?php printf(esc_attr__('%d friend requests','zincelestial'),$friend_requests); ?>">
				<i data-lucide="users" aria-hidden="true"></i>
				<span class="zc-badge zc-badge--success"><?php echo esc_html($friend_requests); ?></span>
			</a>
			<?php endif; ?>
			<?php endif; ?>

			<!-- Bookmarks -->
			<a href="<?php echo esc_url(trailingslashit($profile_url).'bookmarks/'); ?>"
			   class="zc-user-nav__action"
			   aria-label="<?php esc_attr_e('My Bookmarks','zincelestial'); ?>">
				<i data-lucide="bookmark" aria-hidden="true"></i>
			</a>

			<!-- WooCommerce cart — guard: function_exists('WC') -->
			<?php
			if(function_exists('WC') && WC()->cart
			   && zc_option('header_show_cart', get_theme_mod('zc_header_show_cart','1'))):
				$cart_count = (int) WC()->cart->get_cart_contents_count();
			?>
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>"
			   class="zc-user-nav__action<?php echo $cart_count?' has-badge':''; ?>"
			   aria-label="<?php printf(esc_attr__('Cart (%d items)','zincelestial'),$cart_count); ?>">
				<i data-lucide="shopping-cart" aria-hidden="true"></i>
				<?php if($cart_count): ?>
				<span class="zc-badge zc-badge--warning"><?php echo esc_html($cart_count); ?></span>
				<?php endif; ?>
			</a>
			<?php endif; ?>

		</div><!-- .zc-user-nav__actions -->

	</div><!-- .zc-user-nav__inner -->
</div><!-- #zc-user-nav -->

<?php
/**
 * ZinCelestial — Template Part: Header / Main Navigation
 * v3.3 Fix: All BuddyPress function calls (bp_notifications_get_unread_notification_count,
 *           bp_get_total_unread_messages_count, bp_loggedin_user_domain,
 *           bp_get_messages_slug) now fully guarded with function_exists() +
 *           bp_is_active() checks to prevent fatal errors when components are
 *           inactive or BP is not installed.
 *           Also: <i class="zc-icon"> tags replaced with data-lucide SVG
 *           attributes so Lucide JS can render them correctly.
 *
 * @package ZinCelestial
 */
defined('ABSPATH')||exit;

$menu_style  = zc_option('menu_style', get_theme_mod('zc_menu_style','horizontal'));
$show_search = zc_option('header_show_search', get_theme_mod('zc_header_search','1'));
?>
<nav id="zc-main-nav"
     class="zc-main-nav zc-main-nav--<?php echo esc_attr($menu_style); ?> navbar navbar-expand-lg"
     aria-label="<?php esc_attr_e('Primary navigation','zincelestial'); ?>">

	<!-- ── Mobile hamburger ─────────────────────────────────────────── -->
	<button class="zc-nav__toggle navbar-toggler" id="zc-nav-toggle"
	        aria-expanded="false" aria-controls="zc-nav-menu" data-bs-toggle="collapse" data-bs-target="#zc-nav-menu"
	        aria-label="<?php esc_attr_e('Toggle navigation','zincelestial'); ?>">
		<span class="zc-nav__hamburger"><span></span><span></span><span></span></span>
	</button>

	<!-- ── Primary menu ─────────────────────────────────────────────── -->
	<div class="zc-nav__menu-wrap navbar-collapse collapse" id="zc-nav-menu">
		<?php
		if(has_nav_menu('zc-primary')){
			wp_nav_menu(array(
				'theme_location' => 'zc-primary',
				'menu_id'        => 'zc-primary-menu',
				'menu_class'     => 'zc-nav__menu navbar-nav me-auto',
				'container'      => false,
				'walker'         => class_exists('ZC_Nav_Walker')?new ZC_Nav_Walker():null,
				'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
				'fallback_cb'    => false,
			));
		}
		?>
	</div><!-- .zc-nav__menu-wrap -->

	<!-- ── Right zone: search + notifications + user menu ───────────── -->
	<div class="zc-nav__right">

		<?php if($show_search): ?>
		<button class="zc-nav__icon-btn zc-search-toggle"
		        aria-label="<?php esc_attr_e('Search','zincelestial'); ?>"
		        aria-expanded="false" aria-controls="zc-header-search">
			<i data-lucide="search" aria-hidden="true"></i>
		</button>
		<div class="zc-header-search" id="zc-header-search" hidden>
			<?php get_search_form(); ?>
		</div>
		<?php endif; ?>

		<?php if(is_user_logged_in()):
			$current_user_id = get_current_user_id();
		?>

			<!-- Notifications (only when BP notifications component is active) -->
			<?php
			$notif_count = 0;
			if(function_exists('bp_is_active') && bp_is_active('notifications')
			   && function_exists('bp_notifications_get_unread_notification_count')):
				$notif_count = (int) bp_notifications_get_unread_notification_count($current_user_id);
			?>
			<button class="zc-nav__icon-btn zc-notif-toggle<?php echo $notif_count?' has-badge':''; ?>"
			        aria-label="<?php printf(esc_attr__('%d unread notifications','zincelestial'),$notif_count); ?>">
				<i data-lucide="bell" aria-hidden="true"></i>
				<?php if($notif_count): ?>
				<span class="zc-badge" aria-hidden="true"><?php echo esc_html($notif_count>99?'99+':$notif_count); ?></span>
				<?php endif; ?>
			</button>
			<?php endif; ?>

			<!-- Messages (only when BP messages component is active) -->
			<?php
			$msg_count = 0;
			if(function_exists('bp_is_active') && bp_is_active('messages')
			   && function_exists('bp_get_total_unread_messages_count')
			   && function_exists('bp_loggedin_user_domain')
			   && function_exists('bp_get_messages_slug')):
				$msg_count = (int) bp_get_total_unread_messages_count();
				$msg_url   = trailingslashit(bp_loggedin_user_domain().bp_get_messages_slug());
			?>
			<a href="<?php echo esc_url($msg_url); ?>"
			   class="zc-nav__icon-btn<?php echo $msg_count?' has-badge':''; ?>"
			   aria-label="<?php printf(esc_attr__('Messages (%d unread)','zincelestial'),$msg_count); ?>">
				<i data-lucide="message-circle" aria-hidden="true"></i>
				<?php if($msg_count): ?>
				<span class="zc-badge" aria-hidden="true"><?php echo esc_html($msg_count>99?'99+':$msg_count); ?></span>
				<?php endif; ?>
			</a>
			<?php endif; ?>

			<!-- User avatar dropdown -->
			<div class="zc-nav__user-dropdown">
				<button class="zc-nav__avatar-btn" aria-expanded="false" aria-haspopup="true"
				        aria-label="<?php esc_attr_e('User menu','zincelestial'); ?>">
					<?php echo get_avatar($current_user_id,36,'','',array('class'=>'zc-avatar zc-avatar--sm')); ?>
					<i data-lucide="chevron-down" aria-hidden="true"></i>
				</button>
				<div class="zc-dropdown-panel" role="menu">
					<div class="zc-dropdown-panel__header">
						<?php echo get_avatar($current_user_id,48,'','',array('class'=>'zc-avatar zc-avatar--md')); ?>
						<div>
							<strong class="zc-dropdown-panel__name"><?php echo esc_html(wp_get_current_user()->display_name); ?></strong>
							<span class="zc-dropdown-panel__email"><?php echo esc_html(wp_get_current_user()->user_email); ?></span>
						</div>
					</div>
					<ul class="zc-dropdown-panel__list">
						<?php if(function_exists('bp_loggedin_user_domain')): ?>
						<li>
							<a href="<?php echo esc_url(bp_loggedin_user_domain()); ?>" role="menuitem">
								<i data-lucide="user" aria-hidden="true"></i>
								<?php esc_html_e('My Profile','zincelestial'); ?>
							</a>
						</li>
						<?php endif; ?>
						<li>
							<a href="<?php echo esc_url(get_edit_profile_url()); ?>" role="menuitem">
								<i data-lucide="settings" aria-hidden="true"></i>
								<?php esc_html_e('Settings','zincelestial'); ?>
							</a>
						</li>
						<?php if(is_super_admin()||current_user_can('manage_options')): ?>
						<li>
							<a href="<?php echo esc_url(admin_url()); ?>" role="menuitem">
								<i data-lucide="layout-dashboard" aria-hidden="true"></i>
								<?php esc_html_e('WP Admin','zincelestial'); ?>
							</a>
						</li>
						<?php endif; ?>
						<li class="zc-dropdown-panel__divider" role="separator"></li>
						<li>
							<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" role="menuitem"
							   class="zc-dropdown-panel__item--danger">
								<i data-lucide="log-out" aria-hidden="true"></i>
								<?php esc_html_e('Sign Out','zincelestial'); ?>
							</a>
						</li>
					</ul>
				</div>
			</div><!-- .zc-nav__user-dropdown -->

		<?php else: ?>
			<a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"
			   class="zc-btn zc-btn--sm zc-btn--outline">
				<?php esc_html_e('Sign In','zincelestial'); ?>
			</a>
			<?php if(get_option('users_can_register')): ?>
			<a href="<?php echo esc_url(wp_registration_url()); ?>"
			   class="zc-btn zc-btn--sm zc-btn--primary">
				<?php esc_html_e('Register','zincelestial'); ?>
			</a>
			<?php endif; ?>
		<?php endif; ?>

		<!-- Right slide-out panel toggle -->
		<?php if(zc_option('show_right_panel', get_theme_mod('zc_show_right_panel','1'))): ?>
		<button class="zc-nav__icon-btn zc-panel-toggle" data-panel="right"
		        aria-label="<?php esc_attr_e('Open right panel','zincelestial'); ?>">
			<i data-lucide="panel-right" aria-hidden="true"></i>
		</button>
		<?php endif; ?>

	</div><!-- .zc-nav__right -->

</nav><!-- #zc-main-nav -->

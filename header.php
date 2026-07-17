<?php
/**
 * ZinCelestial v5.0.0 — Header Template
 * Bootstrap 5.3 navbar, topbar, search offcanvas, mobile menu offcanvas
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-bs-theme="<?php echo esc_attr( zc_option('color_mode','dark') ); ?>" data-zc-scheme="<?php echo esc_attr( zc_option('color_scheme','cosmic') ); ?>">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="<?php echo esc_attr( zc_option('color_primary','#7c6ff7') ); ?>">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class('zc-body'); ?>>
<?php wp_body_open(); ?>

<div id="zc-page" class="zc-page-wrapper d-flex flex-column min-vh-100">

<?php
/* ── Topbar (announcement / quick links) ────────────────────────────────── */
if ( zc_option('show_topbar','0') === '1' ) :
    get_template_part('template-parts/header/topbar');
endif;
?>

<?php
/* ── Main Header / Navbar ───────────────────────────────────────────────── */
$header_layout = zc_option('header_layout','standard');
$sticky        = zc_option('header_sticky','0') === '1' ? ' sticky-top' : '';
$transparent   = zc_option('header_transparent','0') === '1' ? ' zc-header--transparent' : '';
?>
<header id="zc-header" class="zc-header navbar-expand-lg<?php echo esc_attr( $sticky . $transparent ); ?>">
  <nav class="navbar zc-navbar" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation','zincelestial'); ?>">
    <div class="container-fluid zc-nav-container px-3 px-lg-4">

      <!-- ── Branding ─────────────────────────────────────────────── -->
      <a class="navbar-brand zc-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <?php
        $logo_id = get_theme_mod('custom_logo');
        if ( $logo_id ) :
            echo wp_get_attachment_image( $logo_id, 'full', false, [
                'class' => 'zc-logo img-fluid',
                'alt'   => esc_attr( get_bloginfo('name') ),
            ] );
        else :
        ?>
          <span class="zc-site-title fw-bold"><?php bloginfo('name'); ?></span>
          <?php if ( get_bloginfo('description') ) : ?>
          <span class="zc-site-desc visually-hidden"><?php bloginfo('description'); ?></span>
          <?php endif; ?>
        <?php endif; ?>
      </a>

      <!-- ── Primary Nav (desktop) ────────────────────────────────── -->
      <div class="collapse navbar-collapse zc-nav-collapse" id="zcNavbarCollapse">
        <?php
        wp_nav_menu([
            'theme_location' => 'zc-primary',
            'container'      => false,
            'menu_class'     => 'navbar-nav zc-primary-nav me-auto gap-1',
            'walker'         => new ZC_Nav_Walker(),
            'fallback_cb'    => '__return_false',
            'depth'          => 3,
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]);
        ?>
      </div>

      <!-- ── Right Icons ───────────────────────────────────────────── -->
      <div class="zc-header-actions d-flex align-items-center gap-2 ms-auto">

        <?php if ( zc_option('show_search_header','0') === '1' ) : ?>
        <!-- Search trigger -->
        <button class="btn btn-icon zc-icon-btn" data-bs-toggle="offcanvas" data-bs-target="#zcSearchOffcanvas" aria-label="<?php esc_attr_e('Search','zincelestial'); ?>">
          <i class="bi bi-search"></i>
        </button>
        <?php endif; ?>

        <?php if ( function_exists('buddypress') && zc_option('show_notifications_icon','0') === '1' ) : ?>
        <!-- Notifications -->
        <a class="btn btn-icon zc-icon-btn position-relative" href="<?php echo esc_url(bp_loggedin_user_domain() . bp_get_notifications_slug() . '/'); ?>" aria-label="<?php esc_attr_e('Notifications','zincelestial'); ?>">
          <i class="bi bi-bell"></i>
          <?php if ( function_exists('bp_notifications_get_unread_notification_count') ) :
            $count = bp_notifications_get_unread_notification_count();
            if ( $count > 0 ) : ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger zc-notif-badge"><?php echo absint($count); ?></span>
            <?php endif; ?>
          <?php endif; ?>
        </a>
        <?php endif; ?>

        <?php if ( function_exists('buddypress') && zc_option('show_messages_icon','0') === '1' ) : ?>
        <!-- Messages -->
        <a class="btn btn-icon zc-icon-btn" href="<?php echo esc_url(bp_loggedin_user_domain() . bp_get_messages_slug() . '/'); ?>" aria-label="<?php esc_attr_e('Messages','zincelestial'); ?>">
          <i class="bi bi-chat-dots"></i>
        </a>
        <?php endif; ?>

        <?php if ( class_exists('WooCommerce') && zc_option('show_cart_icon','0') === '1' ) : ?>
        <!-- Cart -->
        <a class="btn btn-icon zc-icon-btn position-relative" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="<?php esc_attr_e('Cart','zincelestial'); ?>">
          <i class="bi bi-bag"></i>
          <?php $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
          if ( $cart_count > 0 ) : ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary zc-cart-badge"><?php echo absint($cart_count); ?></span>
          <?php endif; ?>
        </a>
        <?php endif; ?>

        <?php if ( is_user_logged_in() ) : ?>
        <!-- User dropdown -->
        <div class="dropdown zc-user-dropdown">
          <button class="btn btn-icon zc-icon-btn zc-user-btn" data-bs-toggle="dropdown" aria-expanded="false" aria-label="<?php esc_attr_e('User menu','zincelestial'); ?>">
            <?php
            $uid = get_current_user_id();
            echo get_avatar( $uid, 32, '', '', ['class' => 'zc-avatar-sm rounded-circle'] );
            ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end zc-user-menu shadow">
            <?php
            $user = wp_get_current_user();
            $bp_profile = function_exists('bp_loggedin_user_domain') ? bp_loggedin_user_domain() : get_author_posts_url($uid);
            ?>
            <li class="dropdown-header px-3 py-2">
              <div class="fw-semibold"><?php echo esc_html($user->display_name); ?></div>
              <div class="text-muted small"><?php echo esc_html($user->user_email); ?></div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <?php if ( function_exists('bp_loggedin_user_domain') ) : ?>
            <li><a class="dropdown-item" href="<?php echo esc_url($bp_profile); ?>"><i class="bi bi-person me-2"></i><?php esc_html_e('My Profile','zincelestial'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo esc_url($bp_profile . bp_get_settings_slug() . '/'); ?>"><i class="bi bi-gear me-2"></i><?php esc_html_e('Settings','zincelestial'); ?></a></li>
            <?php endif; ?>
            <?php if ( class_exists('WooCommerce') ) : ?>
            <li><a class="dropdown-item" href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>"><i class="bi bi-box me-2"></i><?php esc_html_e('My Orders','zincelestial'); ?></a></li>
            <?php endif; ?>
            <?php if ( current_user_can('manage_options') || current_user_can('edit_theme_options') ) : ?>
            <li><a class="dropdown-item" href="<?php echo esc_url(admin_url('admin.php?page=zc-dashboard')); ?>"><i class="bi bi-speedometer2 me-2"></i><?php esc_html_e('ZinCelestial','zincelestial'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo esc_url(admin_url()); ?>"><i class="bi bi-tools me-2"></i><?php esc_html_e('WP Admin','zincelestial'); ?></a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
                <i class="bi bi-box-arrow-right me-2"></i><?php esc_html_e('Log Out','zincelestial'); ?>
              </a>
            </li>
          </ul>
        </div>
        <?php else : ?>
        <!-- Login / Register buttons -->
        <a class="btn btn-sm btn-outline-primary zc-login-btn" href="<?php echo esc_url(wp_login_url(get_permalink())); ?>">
          <i class="bi bi-box-arrow-in-right me-1"></i><?php esc_html_e('Log In','zincelestial'); ?>
        </a>
        <?php if ( get_option('users_can_register') ) : ?>
        <a class="btn btn-sm btn-primary zc-register-btn" href="<?php echo esc_url(function_exists('bp_get_signup_page') ? bp_get_signup_page() : wp_registration_url()); ?>">
          <?php esc_html_e('Join','zincelestial'); ?>
        </a>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Mobile hamburger -->
        <button class="navbar-toggler border-0 zc-mobile-toggle ms-2 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#zcMobileMenu" aria-label="<?php esc_attr_e('Toggle menu','zincelestial'); ?>">
          <i class="bi bi-list fs-4"></i>
        </button>

      </div><!-- /.zc-header-actions -->
    </div><!-- /.container-fluid -->
  </nav><!-- /.navbar -->
</header><!-- /#zc-header -->

<?php
/* ── Search Offcanvas ───────────────────────────────────────────────────── */
if ( zc_option('show_search_header','0') === '1' ) : ?>
<div class="offcanvas offcanvas-top zc-search-offcanvas" id="zcSearchOffcanvas" tabindex="-1" aria-label="<?php esc_attr_e('Search','zincelestial'); ?>">
  <div class="offcanvas-body py-4">
    <div class="container">
      <?php get_search_form(); ?>
    </div>
    <button class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Close','zincelestial'); ?>"></button>
  </div>
</div>
<?php endif; ?>

<?php
/* ── Mobile Menu Offcanvas ──────────────────────────────────────────────── */
?>
<div class="offcanvas offcanvas-start zc-mobile-menu" id="zcMobileMenu" tabindex="-1" aria-label="<?php esc_attr_e('Mobile menu','zincelestial'); ?>">
  <div class="offcanvas-header border-bottom">
    <a class="navbar-brand zc-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    <button class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Close','zincelestial'); ?>"></button>
  </div>
  <div class="offcanvas-body">
    <?php
    wp_nav_menu([
        'theme_location' => 'zc-mobile',
        'container'      => false,
        'menu_class'     => 'nav flex-column zc-mobile-nav gap-1',
        'walker'         => new ZC_Nav_Walker(),
        'fallback_cb'    => function() {
            wp_nav_menu([
                'theme_location' => 'zc-primary',
                'container'      => false,
                'menu_class'     => 'nav flex-column zc-mobile-nav gap-1',
                'walker'         => new ZC_Nav_Walker(),
                'fallback_cb'    => '__return_false',
            ]);
        },
        'depth'          => 3,
    ]);
    ?>
    <?php if ( ! is_user_logged_in() ) : ?>
    <hr>
    <div class="d-grid gap-2">
      <a class="btn btn-outline-primary" href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"><?php esc_html_e('Log In','zincelestial'); ?></a>
      <?php if ( get_option('users_can_register') ) : ?>
      <a class="btn btn-primary" href="<?php echo esc_url(wp_registration_url()); ?>"><?php esc_html_e('Register','zincelestial'); ?></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php
/* ── Left Panel (optional side drawer) ──────────────────────────────────── */
if ( zc_option('show_left_panel','0') === '1' ) :
    get_template_part('template-parts/global/left-panel');
endif;

/* ── Right Panel ─────────────────────────────────────────────────────────── */
if ( zc_option('show_right_panel','0') === '1' ) :
    get_template_part('template-parts/global/right-panel');
endif;
?>

<main id="zc-main" class="zc-main flex-grow-1">

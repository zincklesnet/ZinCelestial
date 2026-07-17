<?php
/**
 * ZinCelestial v5.0.0 — Topbar
 * Only rendered when enable_topbar = 1
 */
if ( zc_option('enable_topbar','0') !== '1' ) return;
?>
<div id="zc-topbar" class="zc-topbar py-1 px-3 d-none d-md-flex align-items-center justify-content-between">
  <div class="zc-topbar-left d-flex align-items-center gap-3">
    <?php if ( zc_option('topbar_text','') ) : ?>
    <span class="small"><?php echo wp_kses_post( zc_option('topbar_text','') ); ?></span>
    <?php endif; ?>
  </div>
  <div class="zc-topbar-right d-flex align-items-center gap-3">
    <?php if ( has_nav_menu('zc-topbar-menu') ) : ?>
    <?php wp_nav_menu(['theme_location'=>'zc-topbar-menu','menu_class'=>'d-flex gap-3 list-unstyled mb-0 small','container'=>false]); ?>
    <?php endif; ?>
    <?php if ( is_user_logged_in() ) : ?>
    <a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>" class="text-muted small">
      <i class="bi bi-box-arrow-right me-1"></i><?php esc_html_e('Sign Out','zincelestial'); ?>
    </a>
    <?php else : ?>
    <a href="<?php echo esc_url( wp_login_url() ); ?>" class="text-muted small">
      <i class="bi bi-box-arrow-in-right me-1"></i><?php esc_html_e('Sign In','zincelestial'); ?>
    </a>
    <?php endif; ?>
  </div>
</div>

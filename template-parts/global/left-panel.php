<?php
/**
 * ZinCelestial v5.0.0 — Left Side Panel (offcanvas on mobile)
 */
if ( zc_option('enable_left_panel','0') !== '1' ) return;
?>
<div id="zc-left-panel" class="zc-left-panel d-none d-xl-flex flex-column">
  <?php if ( is_user_logged_in() ) : ?>
  <div class="zc-panel-user p-3 border-bottom d-flex align-items-center gap-2">
    <?php echo get_avatar(get_current_user_id(), 40, '', '', ['class'=>'rounded-circle']); ?>
    <div class="min-w-0">
      <div class="fw-semibold text-truncate"><?php echo esc_html(wp_get_current_user()->display_name); ?></div>
      <div class="small text-muted">@<?php echo esc_html(wp_get_current_user()->user_login); ?></div>
    </div>
  </div>
  <?php endif; ?>
  <nav class="zc-panel-nav flex-grow-1 overflow-y-auto p-2">
    <?php wp_nav_menu(['theme_location'=>'zc-left-panel-menu','menu_class'=>'list-unstyled mb-0','container'=>false,'walker'=>new ZC_Nav_Walker()]); ?>
  </nav>
</div>

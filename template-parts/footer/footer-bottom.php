<?php
/**
 * ZinCelestial v5.0.0 — Footer Bottom Bar
 */
$copy = zc_option('footer_copyright', sprintf('&copy; %d %s — All Rights Reserved.', date('Y'), get_bloginfo('name')));
?>
<div class="zc-footer-bottom py-3 border-top">
  <div class="container-fluid px-3 px-lg-4">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
      <p class="mb-0 small"><?php echo wp_kses_post($copy); ?></p>
      <?php if ( has_nav_menu('zc-footer-menu') ) : ?>
      <?php wp_nav_menu(['theme_location'=>'zc-footer-menu','menu_class'=>'d-flex flex-wrap gap-3 list-unstyled mb-0 small','container'=>false]); ?>
      <?php endif; ?>
    </div>
  </div>
</div>

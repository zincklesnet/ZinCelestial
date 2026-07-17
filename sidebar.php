<?php
/**
 * ZinCelestial v5.0.0 — Right Sidebar
 */
if ( ! is_active_sidebar( 'zc-sidebar-right' ) ) return;
?>
<aside id="zc-sidebar-right" class="zc-sidebar widget-area">
  <?php dynamic_sidebar( 'zc-sidebar-right' ); ?>
</aside>

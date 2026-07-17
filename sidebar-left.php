<?php
/**
 * ZinCelestial v5.0.0 — Left Sidebar
 */
if ( ! is_active_sidebar( 'zc-sidebar-left' ) ) return;
?>
<aside id="zc-sidebar-left" class="zc-sidebar zc-sidebar--left widget-area">
  <?php dynamic_sidebar( 'zc-sidebar-left' ); ?>
</aside>

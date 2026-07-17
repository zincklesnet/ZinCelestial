<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Sidebar
 */
if ( ! is_active_sidebar( 'zc-sidebar-buddypress' ) ) return;
?>
<aside id="zc-sidebar-buddypress" class="zc-sidebar zc-sidebar--bp widget-area">
  <?php dynamic_sidebar( 'zc-sidebar-buddypress' ); ?>
</aside>

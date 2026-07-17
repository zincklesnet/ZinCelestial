<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Notifications
 */
bp_nouveau_before_member_notifications_content();
?>
<div id="buddypress" class="buddypress-wrap zc-bp-notifications">
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-bell me-2 text-primary"></i><?php esc_html_e('Notifications','zincelestial'); ?></h2>
    <div class="d-flex gap-2">
      <?php bp_nouveau_notifications_secondary_nav(); ?>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3">
      <div class="form-check mb-0">
        <input class="form-check-input" type="checkbox" id="select-all-notifications">
        <label class="form-check-label small" for="select-all-notifications"><?php esc_html_e('Select All','zincelestial'); ?></label>
      </div>
      <?php bp_nouveau_notifications_bulk_management_dropdown(); ?>
    </div>
    <div class="card-body p-0">
      <?php if ( bp_has_notifications() ) : ?>
      <ul class="list-group list-group-flush">
        <?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
        <li class="list-group-item px-3 py-3 d-flex align-items-start gap-3 <?php if ( ! bp_notification_is_read() ) echo 'zc-notification-unread bg-primary-subtle'; ?>">
          <div class="flex-shrink-0">
            <i class="bi bi-bell-fill text-primary fs-5"></i>
          </div>
          <div class="flex-grow-1 min-w-0">
            <p class="mb-1 small"><?php bp_notification_description(); ?></p>
            <span class="small text-muted"><?php bp_notification_time_since(); ?></span>
          </div>
          <div class="flex-shrink-0 d-flex gap-1">
            <?php bp_notification_action_links(['separator'=>'']); ?>
          </div>
        </li>
        <?php endwhile; ?>
      </ul>
      <?php else : ?>
      <div class="text-center py-5 text-muted">
        <i class="bi bi-bell-slash display-5 mb-3 opacity-25"></i>
        <p><?php esc_html_e('No notifications yet.','zincelestial'); ?></p>
      </div>
      <?php endif; ?>
    </div>
    <div class="card-footer"><?php bp_nouveau_notifications_pagination(); ?></div>
  </div>
</div>
<?php bp_nouveau_after_member_notifications_content(); ?>

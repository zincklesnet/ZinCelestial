<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Single Activity Entry
 */
?>
<li id="activity-<?php bp_activity_id(); ?>" <?php bp_activity_css_class('zc-activity-item card border-0 shadow-sm mb-3'); ?>>
  <div class="card-body p-3 p-md-4">
    <div class="d-flex gap-3">
      <div class="flex-shrink-0">
        <a href="<?php bp_activity_user_link(); ?>" class="text-decoration-none">
          <?php bp_activity_avatar(['type'=>'full','width'=>48,'height'=>48,'class'=>'rounded-circle border border-2']); ?>
        </a>
      </div>
      <div class="flex-grow-1 min-w-0">
        <div class="zc-activity-header mb-2">
          <p class="zc-activity-action mb-1 small"><?php bp_activity_action(); ?></p>
          <span class="small text-muted">
            <i class="bi bi-clock me-1"></i>
            <a href="<?php bp_activity_thread_permalink(); ?>" class="text-muted text-decoration-none">
              <?php bp_activity_date_recorded(); ?>
            </a>
          </span>
        </div>
        <?php if ( bp_activity_has_content() ) : ?>
        <div class="zc-activity-content mb-3"><?php bp_activity_content_body(); ?></div>
        <?php endif; ?>
        <?php bp_activity_action('action' => false, 'no_timestamp' => true); ?>
        <div class="zc-activity-meta d-flex flex-wrap gap-2 align-items-center pt-2 border-top mt-2">
          <?php if ( bp_activity_can_favorite() ) : ?>
          <button type="button" class="btn btn-link btn-sm p-0 text-muted zc-fav-btn <?php if ( bp_get_activity_is_favorite() ) echo 'active text-warning'; ?>"
            data-activity-id="<?php bp_activity_id(); ?>">
            <i class="bi bi-heart<?php if ( bp_get_activity_is_favorite() ) echo '-fill'; ?> me-1"></i>
            <span class="zc-like-count"><?php bp_activity_favorite_count(); ?></span>
          </button>
          <?php endif; ?>
          <?php if ( bp_activity_can_comment() ) : ?>
          <button type="button" class="btn btn-link btn-sm p-0 text-muted zc-comment-toggle"
            data-target="#ac-form-<?php bp_activity_id(); ?>">
            <i class="bi bi-chat me-1"></i><?php esc_html_e('Reply','zincelestial'); ?>
          </button>
          <?php endif; ?>
          <?php bp_nouveau_activity_buttons(); ?>
        </div>
        <?php bp_activity_comments(); ?>
      </div>
    </div>
  </div>
</li>

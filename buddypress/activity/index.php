<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Activity Stream
 */
bp_nouveau_before_activity_directory_content();
?>
<div class="zc-bp-directory zc-activity-directory">
  <div class="zc-bp-dir-header d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <h1 class="h3 fw-bold mb-0">
      <i class="bi bi-activity me-2 text-primary"></i>
      <?php esc_html_e('Activity Stream','zincelestial'); ?>
    </h1>
    <div class="d-flex gap-2">
      <?php bp_nouveau_activity_directory_item_buttons(); ?>
      <?php if ( bp_activity_do_mentions() && is_user_logged_in() ) : ?>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#zc-post-update-modal">
        <i class="bi bi-plus-circle me-1"></i><?php esc_html_e('Post Update','zincelestial'); ?>
      </button>
      <?php endif; ?>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-9">
      <div class="zc-bp-activity-filters card border-0 shadow-sm mb-4 p-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
          <?php bp_nouveau_activity_secondary_nav(); ?>
        </div>
      </div>
      <div id="buddypress" class="buddypress-wrap">
        <div class="activity" data-bp-list="activity">
          <div id="bp-ajax-loader" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
          </div>
          <?php bp_get_template_part('activity/list'); ?>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-3">
      <?php get_sidebar('buddypress'); ?>
    </div>
  </div>
</div>
<?php bp_nouveau_after_activity_directory_content(); ?>

<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Messages
 */
bp_nouveau_before_member_messages_content();
?>
<div id="buddypress" class="buddypress-wrap zc-bp-messages">
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-envelope me-2 text-primary"></i><?php esc_html_e('Messages','zincelestial'); ?></h2>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#zc-compose-message">
      <i class="bi bi-pencil-square me-1"></i><?php esc_html_e('New Message','zincelestial'); ?>
    </button>
  </div>

  <div class="row g-4">
    <!-- Folder sidebar -->
    <div class="col-12 col-md-3">
      <div class="card border-0 shadow-sm p-3">
        <nav><?php bp_nouveau_messages_secondary_nav(); ?></nav>
      </div>
    </div>
    <!-- Message list -->
    <div class="col-12 col-md-9">
      <div class="card border-0 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-2 px-3">
          <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="select-all-messages">
            <label class="form-check-label small" for="select-all-messages"><?php esc_html_e('Select All','zincelestial'); ?></label>
          </div>
          <?php bp_nouveau_messages_bulk_management_dropdown(); ?>
        </div>
        <div class="card-body p-0">
          <?php bp_nouveau_messages_no_messages(); ?>
          <ul id="message-threads" class="list-group list-group-flush" role="list">
            <?php bp_nouveau_messages_loop(); ?>
          </ul>
        </div>
        <div class="card-footer">
          <?php bp_nouveau_messages_pagination(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php bp_nouveau_after_member_messages_content(); ?>

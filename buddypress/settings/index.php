<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Member Settings
 */
bp_nouveau_before_member_settings_content();
?>
<div id="buddypress" class="buddypress-wrap zc-bp-settings">
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-gear me-2 text-primary"></i><?php esc_html_e('Settings','zincelestial'); ?></h2>
  </div>

  <div class="row g-4">
    <div class="col-12 col-md-3">
      <div class="card border-0 shadow-sm p-3">
        <nav><?php bp_nouveau_settings_secondary_nav(); ?></nav>
      </div>
    </div>
    <div class="col-12 col-md-9">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <?php bp_nouveau_member_settings_content(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php bp_nouveau_after_member_settings_content(); ?>
